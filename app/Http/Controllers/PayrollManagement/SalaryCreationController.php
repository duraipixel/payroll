<?php

namespace App\Http\Controllers\PayrollManagement;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\PayrollManagement\SalaryHead;
use App\Models\PayrollManagement\StaffSalary;
use App\Models\PayrollManagement\StaffSalaryField;
use App\Models\PayrollManagement\StaffSalaryPattern;
use App\Models\PayrollManagement\StaffSalaryPatternField;
use App\Models\Staff\StaffBankLoan;
use App\Models\Staff\StaffInsurance;
use App\Models\User;
use Illuminate\Http\Request;
use PDF;

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
        if( $staff_id ) {
            $salary_info = StaffSalary::where('staff_id', $staff_id)->first();
            $salary_heads = SalaryHead::where('status', 'active')->get();
        } else {
            $salary_info = '';
            $salary_heads = '';
        }

        $employees = User::where('status', 'active')->whereNull('is_super_admin')->get();
        $salary_heads = SalaryHead::where('status', 'active')->get();

        $acYear = AcademicYear::find(academicYearId());

        $start_year = '01-'.$acYear->from_month.'-'.$acYear->from_year;
        $end_year = '01-'.$acYear->to_month.'-'.$acYear->to_year;
        $start_Date = date('Y-m-d', strtotime($start_year));
        $payout_year = [];
        for ($i=1; $i <= 12; $i++) { 
            $payout_year[] = array(date('Y-m-d', strtotime($start_Date.' + '.$i.' months')));
        }
        
        return view('pages.payroll_management.salary_creation.index', compact('breadcrums', 'employees', 'salary_heads', 'staff_id', 'salary_info', 'salary_heads', 'payout_year'));

    }

    public function salaryAdd(Request $request)
    {
        
        $salary_heads = SalaryHead::where('status', 'active')->get();
        $staff_id = $request->staff_id;
        $staff_info = User::find($staff_id);
        $earnings = 0;
        $deductions = 0;
        $net_pay = 0;
        if($salary_heads) {
            $ins = [];
            foreach ($salary_heads as $items) {
                if ( isset($items->fields) && !empty($items->fields) ) {
                    foreach ( $items->fields as $item_fields ) {
                        if( isset($_POST['amount_'.$item_fields->id]) ) {
                            $amount = $_POST['amount_'.$item_fields->id];
                            $ins[] = array('field_id' => $item_fields->id, 'name' => $item_fields->name, 'amount' => $amount, 'reference_type' => $items->name, 'reference_id' => $items->id );
                            if( $items->name == 'EARNINGS') {
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
        $payout_month = date('Y-m-1', strtotime($request->payout_month));

        if( !empty( $ins )) {
            $insert_data = [];
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
            
            $salary_info = StaffSalaryPattern::updateOrCreate(['staff_id' => $staff_id, 'payout_month' => $payout_month], $insert_data);

            StaffSalaryPatternField::where('staff_salary_pattern_id', $salary_info->id )->forceDelete();

            foreach ( $ins as $items_pay ) {

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
                
            }
            $error = 'Salary is set successfully';
        } else {
            $error = 'Error while setting Salary Fields';
        }
        if( $request->from ) {
            return redirect('staff/register/'.$staff_id)->with('status', $error);
        } else {
            return redirect('/salary/creation')->with('status', $error);
        }

    }

    public function getStaffSalaryInfo(Request $request)
    {
        $staff_id = $request->staff_id;

        $salary_info = StaffSalaryPattern::where('staff_id', $staff_id)->first();
        $salary_heads = SalaryHead::where('status', 'active')->get();
        $acYear = AcademicYear::find(academicYearId());

        $start_year = '01-'.$acYear->from_month.'-'.$acYear->from_year;
        $end_year = '01-'.$acYear->to_month.'-'.$acYear->to_year;
        $start_Date = date('Y-m-d', strtotime($start_year));
        $payout_year = [];
        for ($i=1; $i <= 12; $i++) { 
            $payout_year[] = date('Y-m-d', strtotime($start_Date.' + '.$i.' months'));
        }
        
        return view('pages.payroll_management.salary_creation.fields', compact('salary_heads', 'salary_info', 'payout_year' ) );
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
        $pdf = PDF::loadView('pages.payroll_management.salary_creation._salary_slip',array('staff_info' => $staff_info, 'salary_info' => $salary_info))->setPaper('a4', 'portrait');
        // download PDF file with download method
        if ($salary_info->salary_month && !empty($salary_info->salary_month)) {

            $file_name = $salary_info->salary_month.'_'.$salary_info->salary_year.'_salary.pdf';
        } else {
            $file_name = date('d-M-Y', strtotime($salary_info->created_at)).'_salary.pdf';
        }
        
        return $pdf->stream($file_name);
    }

    public function getOthersData(Request $request)
    {
        

        $staff_id = $request->staff_id;
        $data_id = $request->data_id;

        if( $data_id == 'LIC') {
            $datas = StaffInsurance::where('status', 'active')->where('staff_id', $staff_id )->get();
            $title = 'Insurance Active Details';
            $content = view('pages.payroll_management.salary_creation._show_insurance_details', compact('datas', 'title') );
        } else {
            $title = 'Loans Acive Details';
            $datas = StaffBankLoan::where('status', 'active')->where('staff_id', $staff_id )->get();
            $content = view('pages.payroll_management.salary_creation._loan_details', compact('datas', 'title') );
        }

        return view('layouts.modal.show_modal', compact('content', 'title'));

    }

}
