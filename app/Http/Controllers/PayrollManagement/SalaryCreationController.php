<?php

namespace App\Http\Controllers\PayrollManagement;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\PayrollManagement\SalaryField;
use App\Models\PayrollManagement\SalaryFieldCalculationItem;
use App\Models\PayrollManagement\SalaryHead;
use App\Models\PayrollManagement\StaffSalary;
use App\Models\PayrollManagement\StaffSalaryField;
use App\Models\PayrollManagement\StaffSalaryPattern;
use App\Models\PayrollManagement\StaffSalaryPatternField;
use App\Models\PayrollManagement\StaffSalaryPatternFieldHistory;
use App\Models\PayrollManagement\StaffSalaryPatternHistory;
use App\Models\Staff\StaffBankLoan;
use App\Models\Staff\StaffInsurance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SalaryCreationController extends Controller
{

    public function index(Request $request)
    {

        $breadcrums = array(
            'title' => 'Salary Creation',
            'breadcrums' => array(
                array(
                    'link' => '', 'title' => 'Salary Creation'
                ),
            )
        );
        $staff_id = $request->staff_id ?? '';
        if ($staff_id) {
            $salary_info = StaffSalary::where('staff_id', $staff_id)->first();
            $salary_heads = SalaryHead::where('status', 'active')->get();
        } else {
            $salary_info = '';
            $salary_heads = '';
        }

        $employees = User::where('status', 'active')->orderBY('name', 'asc')->whereNull('is_super_admin')->get();
        $salary_heads = SalaryHead::where('status', 'active')->get();

        $acYear = AcademicYear::find(academicYearId());

        $start_year = '01-' . $acYear->from_month . '-' . $acYear->from_year;
        $end_year = '01-' . $acYear->to_month . '-' . $acYear->to_year;
        $start_Date = date('Y-m-d', strtotime($start_year));
        $payout_year = [];
        for ($i = 1; $i <= 12; $i++) {
            $payout_year[] = array(date('Y-m-d', strtotime($start_Date . ' + ' . $i . ' months')));
        }

        return view('pages.payroll_management.salary_creation.index', compact('breadcrums', 'employees', 'salary_heads', 'staff_id', 'salary_info', 'salary_heads', 'payout_year'));
    }

    public function salaryAdd(Request $request)
    {

        $salary_heads = SalaryHead::where('status', 'active')->get();
        $staff_id = $request->staff_id;
        $id = $request->id ?? '';
        $staff_info = User::find($staff_id);
        $payout_month = $request->payout_month;
        $earnings = 0;
        $deductions = 0;
        $net_pay = 0;
        
        $validator      = Validator::make($request->all(), [
            'payout_month' => ['required','string',
                        Rule::unique('staff_salary_patterns')->where(function ($query) use($staff_id, $payout_month, $id) {
                            return $query->where('payout_month', $payout_month)
                            ->where('deleted_at', NULL)
                            ->where('staff_id', $staff_id)
                            ->where('verification_status', '!=', 'rejected')
                            ->when($id != '', function($q) use($id){
                                return $q->where('id', '!=', $id);
                            });
                        }),
                        ],
            'staff_id' => 'required',
            'effective_from' => 'required',
            'net_salary' => 'required'
          
        ]);

        if ($validator->passes()) {   
            
            if ($salary_heads) {
                $ins = [];
                foreach ($salary_heads as $items) {
                    if (isset($items->fields) && !empty($items->fields)) {
                        foreach ($items->fields as $item_fields) {
                            if (isset($_POST['amount_' . $item_fields->id])) {
                                $amount = $_POST['amount_' . $item_fields->id];
                                $ins[] = array('field_id' => $item_fields->id, 'name' => $item_fields->name, 'amount' => $amount, 'reference_type' => $items->name, 'reference_id' => $items->id);
                                if ($items->name == 'EARNINGS') {
                                    $earnings += $amount;
                                } else {
                                    $deductions += $amount;
                                }
                            }
                        }
                    }
                }
            }
            $net_pay = $earnings - $deductions;
            $payout_month = date('Y-m-01', strtotime($request->payout_month));
    
            if (!empty($ins)) {
                /**
                 * check exists
                 * 
                 */
                $insert_data = [];

                $exist = StaffSalaryPattern::where(['id' => $id])->first();
                $current_active = StaffSalaryPattern::where(['staff_id' => $staff_id, 'is_current' => 'yes'])->orderBY('payout_month', 'desc')->first();
               
                if( $current_active && $current_active->payout_month < $payout_month ) {
                    StaffSalaryPattern::where(['staff_id' => $staff_id])->update(['is_current' => 'no']);
                    $is_current = 'yes';
                } else if($current_active && $current_active->payout_month > $payout_month) {
                    $is_current = 'no';
                } else {
                    $is_current = $exist->is_current ?? 'yes';
                }

                $insert_data['staff_id'] = $staff_id;
                $insert_data['salary_no'] = date('ymdhis');
                $insert_data['total_earnings'] = $earnings;
                $insert_data['total_deductions'] = $deductions;
                $insert_data['gross_salary'] = $earnings;
                $insert_data['net_salary'] = $net_pay;
                $insert_data['is_salary_processed'] = 'no';
                $insert_data['status'] = 'active';
                $insert_data['effective_from'] = date('Y-m-d', strtotime($request->effective_from));
                $insert_data['employee_remarks'] = $request->employee_remarks;
                $insert_data['payout_month'] = $payout_month;
                $insert_data['verification_status'] = 'pending';
                $insert_data['is_current'] = $is_current;
    
                if (!$exist) {
                    $insert_data['addedBy'] = auth()->id();
                } else {
                    $insert_data['lastUpdatedBy'] = auth()->id();
                }
    
                $salary_info = StaffSalaryPattern::updateOrCreate(['id' => $id], $insert_data);
                $history_info = StaffSalaryPatternHistory::create($insert_data);
                StaffSalaryPatternField::where('staff_salary_pattern_id', $salary_info->id)->forceDelete();
    
                foreach ($ins as $items_pay) {
    
                    $field_data = [];
                    $field_data['staff_id'] = $staff_id;
                    $field_data['staff_salary_pattern_id'] = $salary_info->id;
                    $field_data['field_id'] = $items_pay['field_id'];
                    $field_data['field_name'] = $items_pay['name'];
                    $field_data['amount'] = $items_pay['amount'];
                    $field_data['percentage'] = '';
                    $field_data['reference_type'] = $items_pay['reference_type'];
                    $field_data['reference_id'] = $items_pay['reference_id'];
                    StaffSalaryPatternField::create($field_data);
    
                    $field_data['staff_salary_pattern_id'] = $history_info->id;
                    StaffSalaryPatternFieldHistory::create($field_data);
                }
                $message = 'Salary is set successfully';
                $error = 0;

            } else {
                $message = 'Error while setting Salary Fields, Please make sure salary fiedls are mapped';
                $error = 1;

            }
            // if( $request->from != 'ajax_revision') {

            //     if ($request->from ) {
            //         return redirect('staff/register/' . $staff_id)->with('status', $error);
            //     } else {
            //         return redirect('/salary/creation')->with('status', $error);
            //     }
            // } 

        } else {
            $error = 1;
            $message = $validator->errors()->all();
        }    
        return response()->json(['error' => $error, 'message' => $message]);
        
    }

    public function getStaffSalaryInfo(Request $request)
    {
        $staff_id = $request->staff_id;
        $staff_info = User::find($staff_id);
        $salary_info = StaffSalaryPattern::where('staff_id', $staff_id)->where('status', 'active')->first();
        $salary_heads = SalaryHead::where('status', 'active')->get();
        $acYear = AcademicYear::find(academicYearId());
        $salary_fields = [];
        $payout_year = [];
        $nature_of_employment_id = '';
        if (isset($staff_info->appointment->nature_of_employment_id) && !empty($staff_info->appointment->nature_of_employment_id)) {
            $nature_of_employment_id = $staff_info->appointment->nature_of_employment_id;

            $earnings_data = SalaryField::where('nature_id', $nature_of_employment_id)
                ->where('salary_head_id', 1)
                ->orderBy('order_in_salary_slip')
                ->get();

            $deduction_data = SalaryField::where(function ($q) use ($nature_of_employment_id) {
                $q->where('nature_id', $nature_of_employment_id)
                    ->orWhere('entry_type', 'inbuilt_calculation');
            })
                ->where('salary_head_id', 2)
                ->orderBy('order_in_salary_slip')
                ->get();

            $start_year = '01-' . $acYear->from_month . '-' . $acYear->from_year;
            $end_year = '01-' . $acYear->to_month . '-' . $acYear->to_year;
            $start_Date = date('Y-m-d', strtotime($start_year));

            for ($i = 0; $i < 12; $i++) {
                $payout_year[] = date('Y-m-d', strtotime($start_Date . ' + ' . $i . ' months'));
            }
            $message = '';
        } else {
            $message = 'Empoyee Nature not mapped with this staff.Please assign in appointment details to add salary';
        }
        /**
         * CHECK SALARY IS ALREADY CREATED
         */
        $params = array(
            'nature_of_employment_id' => $nature_of_employment_id,
            'salary_heads' => $salary_heads,
            'salary_info' => $salary_info,
            'payout_year' => $payout_year,
            'message' => $message,
            'salary_fields' => $salary_fields,
            'earnings_data' => $earnings_data ?? [],
            'deduction_data' => $deduction_data ?? [],
            'staff_id' => $staff_id

        );
        if (!$salary_info) {
            return view('pages.payroll_management.salary_creation._salary_create', $params);
        } else {

            $all_salary_patterns = StaffSalaryPattern::where('staff_id', $staff_id)->orderBy('id', 'desc')
                                    ->where('verification_status', '!=', 'rejected')->get();
            $current_pattern = StaffSalaryPattern::where(['staff_id' => $staff_id, 'is_current' => 'yes'])->first();
            if( !$current_pattern ) {
                $current_pattern = StaffSalaryPattern::where(['staff_id' => $staff_id, 'is_current' => 'no'])->orderBy('payout_month', 'desc')->first();
            }
            $staff_details = User::find( $staff_id );
            $params['all_salary_patterns'] = $all_salary_patterns;
            $params['current_pattern'] = $current_pattern;
            $params['staff_details'] = $staff_details;
            
            return view('pages.payroll_management.salary_creation._revision_list', $params);
        }
    }

    public function getStaffSalaryDetailsPane(Request $request)
    {

        $staff_id = $request->staff_id;

        $salary_info = StaffSalaryPattern::where('staff_id', $staff_id)->first();
        $salary_heads = SalaryHead::where('status', 'active')->get();
        $acYear = AcademicYear::find(academicYearId());

        $start_year = '01-' . $acYear->from_month . '-' . $acYear->from_year;
        $end_year = '01-' . $acYear->to_month . '-' . $acYear->to_year;
        $start_Date = date('Y-m-d', strtotime($start_year));
        $payout_year = [];
        for ($i = 1; $i <= 12; $i++) {
            $payout_year[] = date('Y-m-d', strtotime($start_Date . ' + ' . $i . ' months'));
        }

        return view('pages.payroll_management.salary_creation.fields', compact('salary_heads', 'salary_info', 'payout_year'));
    }

    public function salaryModalView(Request $request)
    {

        $staff_id = $request->staff_id;
        $staff_info = User::find($staff_id);
        $salary_info = StaffSalaryPattern::where('staff_id', $staff_id)->first();
        $salary_heads = SalaryHead::where('status', 'active')->get();
        $title = 'Salary Preview';
        return view('pages.payroll_management.salary_creation._modal_view_salary', compact('salary_info', 'salary_heads', 'title', 'staff_info'));
    }

    public function downloadSalaryPreviewPdf(Request $request)
    {
        $staff_id = $request->staff_id;
        $staff_info = User::find($staff_id);
        $salary_info = StaffSalaryPattern::where('staff_id', $staff_id)->first();
        $salary_heads = SalaryHead::where('status', 'active')->get();
        $pdf = PDF::loadView('pages.payroll_management.salary_creation._salary_slip', array('staff_info' => $staff_info, 'salary_info' => $salary_info))->setPaper('a4', 'portrait');
        // download PDF file with download method
        if ($salary_info->salary_month && !empty($salary_info->salary_month)) {

            $file_name = $salary_info->salary_month . '_' . $salary_info->salary_year . '_salary.pdf';
        } else {
            $file_name = date('d-M-Y', strtotime($salary_info->created_at)) . '_salary.pdf';
        }

        return $pdf->stream($file_name);
    }

    public function getOthersData(Request $request)
    {

        $staff_id = $request->staff_id;
        $data_id = $request->data_id;

        if ($data_id == 'LIC') {
            $datas = StaffInsurance::where('status', 'active')->where('staff_id', $staff_id)->get();
            $title = 'Insurance Active Details';
            $content = view('pages.payroll_management.salary_creation._show_insurance_details', compact('datas', 'title'));
        } else {
            $title = 'Loans Acive Details';
            $datas = StaffBankLoan::where('status', 'active')->where('staff_id', $staff_id)->get();
            $content = view('pages.payroll_management.salary_creation._loan_details', compact('datas', 'title'));
        }

        return view('layouts.modal.show_modal', compact('content', 'title'));
    }

    public function getAmountBasedField(Request $request)
    {
        $amount = $request->amount;
        $field_id = $request->field_id;
        $field_name = $request->field_name;

        // $fieldCalculation = SalaryFieldCalculationItem::whereRaw("CHARINDEX('" . $field_id . "', multi_field_id) <> 0")->dd();
        $fieldCalculation = SalaryFieldCalculationItem::whereRaw("(',' + RTRIM(multi_field_id) + ',') LIKE '%,$field_id,%'")->get();
        
        $related_amount = [];
        if (isset($fieldCalculation) && count($fieldCalculation) > 0) {
            foreach ($fieldCalculation as $items) {
                $percentage = 0;
                $percentage_amount = 0;
                if (!strpos($items->multi_field_id, ',')) {

                    $tmp = [];
                    $tmp['id'] = $items->parentField->id;
                    $tmp['short_name'] = str_replace(' ', '_', $items->parentField->short_name);
                    $tmp['name'] = $items->parentField->name;
                    $percentage = $items->percentage;
                    $percentage_amount = getPercentageAmount($percentage, $amount);
                    $tmp['basic_percentage_amount'] = round($percentage_amount);
                    $related_amount[] = $tmp;
                }
            }
        }

        return $related_amount;
    }

    public function getStaffEpfAmount(Request $request)
    {

        $staff_id = $request->staff_id;
        $types = $request->types;

        $staff_info = User::find($staff_id);
        $nature_of_employment_id = $staff_info->appointment->employment_nature->id;

        $salary_fields = SalaryField::where('salary_head_id', 2)->where('nature_id', $nature_of_employment_id)
            ->where('short_name', $types)->first();

        return array('field_name' => $salary_fields->field_items->field_name ?? '', 'multi_field_id' => $salary_fields->field_items->multi_field_id, 'percentage' => $salary_fields->field_items->percentage);
    }

    public function updateSalaryPattern(Request $request)
    {
        $staff_id = $request->staff_id;
        $staff_info = User::find($staff_id);
        $nature_of_employment_id = $staff_info->appointment->employment_nature->id;
        $current_pattern = StaffSalaryPattern::where(['status' => 'active', 'is_current' => 'yes', 'staff_id' => $staff_id])->first();


        $earnings_data = SalaryField::where('nature_id', $nature_of_employment_id)
            ->where('salary_head_id', 1)
            ->orderBy('order_in_salary_slip')
            ->get();

        $deduction_data = SalaryField::where(function ($q) use ($nature_of_employment_id) {
            $q->where('nature_id', $nature_of_employment_id)
                ->orWhere('entry_type', 'inbuilt_calculation');
        })
            ->where('salary_head_id', 2)
            ->orderBy('order_in_salary_slip')
            ->get();
        
        $acYear = AcademicYear::find(academicYearId());

        $start_year = '01-' . $acYear->from_month . '-' . $acYear->from_year;
        $end_year = '01-' . $acYear->to_month . '-' . $acYear->to_year;
        $start_Date = date('Y-m-d', strtotime($start_year));
       
        $payout_year = [];
        for ($i = 0; $i < 12; $i++) {
            $payout_year[] = date('Y-m-d', strtotime($start_Date . ' + ' . $i . ' months'));
        }
        
        $params = array(
            'current_pattern' => $current_pattern,
            'earnings_data' => $earnings_data,
            'deduction_data' => $deduction_data,
            'payout_year' => $payout_year,
        );
        
        return view('pages.payroll_management.salary_creation._salary_update', $params);
    }

    public function getStaffSalaryPattern(Request $request) {

        $staff_id = $request->staff_id;
        $payout_date = $request->payout_date;

        $current_pattern = StaffSalaryPattern::where(['staff_id' => $staff_id, 'payout_month' => $payout_date])->first();
        $params['current_pattern'] = $current_pattern;
        return view('pages.payroll_management.salary_creation._salary_view', $params);

    }

    public function updateCurrentSalaryPattern(Request $request) {
        
        $staff_id = $request->staff_id;
        $payout_date = $request->payout_date;
        $current_pattern = StaffSalaryPattern::where(['staff_id' => $staff_id, 'payout_month' => $payout_date])->first();
        $params['current_pattern'] = $current_pattern;

        $staff_id = $request->staff_id;
        $staff_info = User::find($staff_id);
        $nature_of_employment_id = $staff_info->appointment->employment_nature->id;

        $earnings_data = SalaryField::where('nature_id', $nature_of_employment_id)
                        ->where('salary_head_id', 1)
                        ->orderBy('order_in_salary_slip')
                        ->get();

        $deduction_data = SalaryField::where(function ($q) use ($nature_of_employment_id) {
                            $q->where('nature_id', $nature_of_employment_id)
                                ->orWhere('entry_type', 'inbuilt_calculation');
                        })
                        ->where('salary_head_id', 2)
                        ->orderBy('order_in_salary_slip')
                        ->get();
        
        $acYear = AcademicYear::find(academicYearId());

        $start_year = '01-' . $acYear->from_month . '-' . $acYear->from_year;
        $start_Date = date('Y-m-d', strtotime($start_year));
       
        $payout_year = [];
        for ($i = 0; $i < 12; $i++) {
            $payout_year[] = date('Y-m-d', strtotime($start_Date . ' + ' . $i . ' months'));
        }
        
        $params = array(
            'current_pattern' => $current_pattern,
            'earnings_data' => $earnings_data,
            'deduction_data' => $deduction_data,
            'payout_year' => $payout_year,
        );

        return view('pages.payroll_management.salary_creation._current_salary_update', $params);

    }

    public function deleteSalaryPattern(Request $request) {

        $id = $request->id;
        $info = StaffSalaryPattern::find($id);
        $staff_id = $info->staff_id;
        if( isset($info->salaries) && count($info->salaries) > 0 ) {

            $error = 1;
            $message = 'Cannot delete Staff Salary Pattern. It has salary dependencies';

        } else {

            $is_current = $info->is_current;
            $info->delete();

            if( $is_current == 'yes' ) {
    
                $max_info = DB::select('SELECT ssp.id, ssp.payout_month
                                FROM staff_salary_patterns ssp
                                WHERE ssp.staff_id = '.$staff_id.'
                                AND ssp.payout_month = (
                                SELECT MAX(payout_month)
                                FROM staff_salary_patterns
                                WHERE staff_id = '.$staff_id.' and deleted_at is null
                                )');
    
                if( !empty($max_info)) {
                    
                    $pattern_id = $max_info[0]->id ?? '';
                    if( $pattern_id ) {
                        StaffSalaryPattern::where('staff_id', $staff_id)->update(['is_current' => 'no']);
                        StaffSalaryPattern::where('id', $pattern_id)->update(['is_current' => 'yes']);
                    }
                }
                
            }
    
            $error = 0;
            $message = 'Staff Salary Pattern deleted successfully';
        }

        return array('error' => $error, 'message' => $message, 'staff_id' => $staff_id);
    }

}
