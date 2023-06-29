<?php

namespace App\Http\Controllers\PayrollManagement;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\PayrollManagement\ItStaffStatement;
use App\Models\PayrollManagement\OtherIncome;
use App\Models\PayrollManagement\StaffSalaryPattern;
use App\Models\PayrollManagement\StaffSalaryPatternField;
use App\Models\Staff\StaffDeduction;
use App\Models\Staff\StaffOtherIncome;
use App\Models\Staff\StaffRentDetail;
use App\Models\Tax\TaxScheme;
use App\Models\Tax\TaxSection;
use App\Models\Tax\TaxSectionItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class IncomeTaxController extends Controller
{
    public function index(Request $request) {
        
        $employees = User::where('status', 'active')->whereNull('is_super_admin')->get();
        $params = array(
            'employees' => $employees
        );

        return view('pages.income_tax.index', $params);
    }

    public function getTab(Request $request) {

        $tab = $request->tab ?? '';
        $staff_id = $request->staff_id;
        $from = $request->from ?? '';
        $params['staff_details'] = User::find($staff_id);
        $params['tax_scheme'] = TaxScheme::where('status', 'active')->get();
        $current_scheme = TaxScheme::where('is_current', 'yes')->where('status', 'active')->first();
        $statement_data = ItStaffStatement::where(['staff_id' => $staff_id, 'academic_id' => academicYearId(), 'status' => 'active'])->first();
        $params['current_scheme'] = $current_scheme;
        $params['statement_data'] = $statement_data;
        if( !empty( $from ) ) {
            return view('pages.income_tax._staff_pane', $params);
        } else {

            switch ($tab) {
                case 'income':
                    return view('pages.income_tax._income_pane');
                    break;

                case 'deductions':
                    $sections = TaxSection::where('tax_scheme_id', $current_scheme->id)->get();
                    $params['sections'] = $sections;  

                    return view('pages.income_tax._deduction_pane', $params);
                    break;

                case 'other_income':
                    $params['other_incomes'] = OtherIncome::where('status', 'active')->get();
                    $params['staff_other_incomes'] = StaffOtherIncome::where('staff_id', $staff_id)->get();
                    return view('pages.income_tax._other_income', $params);
                    break;

                case 'regime':
                    return view('pages.income_tax._scheme_pane', $params);
                    break;

                case 'rent':
                    // dd( $params['staff_details']->staffRentByAcademic );
                    return view('pages.income_tax._rent_list', $params);
                    break;

                case 'taxpayable':
                    return view('pages.income_tax.__taxpayable_form', $params);
                
                default:
                    # code...
                    break;
            }

        }

    }

    public function getDeductionRow(Request $request) {

        $section_id = $request->section_id;
        $staff_id = $request->staff_id;
        $from = $request->from;
        $items = TaxSectionItem::where('tax_section_id', $section_id)
                ->where('is_pf_calculation', 'no')->get();
        $academic_data = AcademicYear::find(academicYearId());

        $statement_data = ItStaffStatement::where(['staff_id' => $staff_id, 'academic_id' => $academic_data->id, 'status' => 'active'])->first();

        if( $academic_data ) {

            $sdate = $academic_data->from_year.'-'.$academic_data->from_month.'-01';
            $start_date = date('Y-m-d', strtotime($sdate));
            $edate = $academic_data->to_year.'-'.$academic_data->to_month.'-01';
            $end_date = date('Y-m-t', strtotime($edate));

            $salary_pattern = StaffSalaryPattern::where(['staff_id' => $staff_id, 'verification_status' => 'approved'])
                            ->where(function($q) use($start_date, $end_date){
                                $q->where('payout_month', '>=', $start_date);
                                $q->where('payout_month', '<=', $end_date);
                            })
                            ->first();
            if( $salary_pattern ) {

                $pf_data = StaffSalaryPatternField::join('salary_fields', 'salary_fields.id', '=', 'staff_salary_pattern_fields.field_id') 
                            ->where('staff_salary_pattern_id', $salary_pattern->id)
                            ->where('salary_fields.short_name', 'EPF')
                            ->first();

            }
            
                        
        }
        
        $pf_calc_data = TaxSectionItem::where('tax_section_id', $section_id)
                        ->where('is_pf_calculation', 'yes')->get();
        $section_info = TaxSection::find($section_id);
        $deductions = StaffDeduction::where('staff_id', $staff_id)->where('tax_section_id', $section_id)->get();
        $params = array(
            'items' => $items,
            'staff_id' => $staff_id,
            'section_info' => $section_info,
            'deductions' => $deductions,
            'from' => $from,
            'pf_calc_data' => $pf_calc_data,
            'pf_data' => $pf_data ?? [],
            'statement_data' => $statement_data ?? ''
        );
        return view('pages.income_tax._deduction_row', $params);

    }

    public function saveDeduction(Request $request) {

        $validator      = Validator::make($request->all(), [
            'section_id' => 'required',
            'staff_id' => 'required' 
        ]);

        if ($validator->passes()) { 

            $items = $request->items;
            $amount = $request->amount;
            $remarks = $request->remarks;
            $staff_id = $request->staff_id;
            $section_id = $request->section_id;

            if( $items && count($items) > 0 ) {
                StaffDeduction::where(['staff_id' => $staff_id, 'tax_section_id' => $section_id])->delete();
                for ($i=0; $i < count($items); $i++) { 
                    $ins = [];
                    $ins['academic_id'] = academicYearId();
                    $ins['staff_id'] = $staff_id;
                    $ins['tax_section_id'] = $section_id;
                    $ins['tax_section_item_id'] = $items[$i];
                    $ins['remarks'] = $remarks[$i];
                    $ins['amount'] = $amount[$i];
                    $ins['status'] = 'active';
                    $ins['added_by'] = auth()->id();
                    $ins['updated_by'] = auth()->id();

                    StaffDeduction::create($ins);
                }
            }
            $error = 0;
            $message = 'Deduction items added successfully';
        } else {
            $message = $validator->errors()->all();
            $error = 1;
        }
        return array( 'error' => $error, 'message' => $message );
    }

    public function getOtherIncomeRow(Request $request) {

        $params['other_incomes'] = OtherIncome::where('status', 'active')->get();
        return view('pages.income_tax._other_income_row', $params);

    }

    public function saveOtherIncome(Request $request) {
        $validator      = Validator::make($request->all(), [
            'staff_id' => 'required' 
        ]);

        if ($validator->passes()) { 

            $description_id = $request->description_id;
            $amount = $request->amount;
            $remarks = $request->remarks;
            $staff_id = $request->staff_id;
            // dd( $request->all() );
            if( $description_id && count($description_id) > 0 ) {
                StaffOtherIncome::where(['staff_id' => $staff_id])->delete();
                for ($i=0; $i < count($description_id); $i++) { 
                    $ins = [];
                    $ins['academic_id'] = academicYearId();
                    $ins['staff_id'] = $staff_id;
                    $ins['other_income_id'] = $description_id[$i];
                    $ins['remarks'] = $remarks[$i];
                    $ins['amount'] = $amount[$i];
                    $ins['status'] = 'active';
                    $ins['added_by'] = auth()->id();
                    $ins['updated_by'] = auth()->id();

                    StaffOtherIncome::create($ins);
                }
            }
            $error = 0;
            $message = 'Other Income items added successfully';
        } else {
            $message = $validator->errors()->all();
            $error = 1;
        }
        return array( 'error' => $error, 'message' => $message );
    }

    public function rentModal(Request $request) {

        $staff_id = $request->staff_id;
        $academic_data = AcademicYear::find(academicYearId());
        $title = 'Add Month Rent for ( '.$academic_data->from_year .' / '.$academic_data->to_year.' )';
        $params = array(
            'staff_id' => $staff_id
        );
        $content = view('pages.income_tax._rent_form', $params);
        return view('layouts.modal.dynamic_modal', compact('content', 'title'));

    }

    public function rentList(Request $request) {

        $staff_id = $request->staff_id;
        $staff_details = User::find($staff_id);
        $params['staff_details'] = $staff_details;
        return view('pages.income_tax._rent_table', $params);

    }

    public function saveRent(Request $request) {
        $id = $request->id ?? '';
        $staff_id = $request->staff_id;
        $academic_id = academicYearId();
        $validator      = Validator::make($request->all(), [
            'amount' => 'required',
            'staff_id' => ['required','string',
                                Rule::unique('staff_rent_details')->where(function ($query) use($staff_id, $academic_id, $id) {
                                    return $query->where('deleted_at', NULL)
                                    ->where('staff_id', $staff_id)
                                    ->where('academic_id', $academic_id)
                                    ->when($id != '', function($q) use($id){
                                        return $q->where('id', '!=', $id);
                                    });
                                }),
                                ]
        ],['staff_id.unique' => 'Rent already updated on this year, If you want to add then delete previous data to continue']);

        if ($validator->passes()) { 
            
            $ins['academic_id'] = academicYearId();
            $ins['staff_id'] = $request->staff_id;
            $ins['amount'] = $request->amount;
            $ins['remarks'] = $request->remarks;
            $ins['annual_rent'] = $request->amount * 12;
            $staff_info = User::find($request->staff_id);
            if ($request->hasFile('document')) {
    
                $files = $request->file('document');
                $imageName = uniqid() . Str::replace([' ', '  ', ''], '', $files->getClientOriginalName());

                $directory = 'staff/' . $staff_info->emp_code . '/rent/'.academicYearId();
                $filename  = $directory . '/' . $imageName;

                Storage::disk('public')->put($filename, File::get($files));
                $ins['document'] = $filename;
            }

            StaffRentDetail::updateOrCreate(['id' => $id], $ins);
            $error = 0;
            $message = 'Rent saved successfully';
        } else {
            $message = $validator->errors()->all();
            $error = 1;
        }
        return array( 'error' => $error, 'message' => $message, 'staff_id' => $request->staff_id );
    }

    public function rentDelete(Request $request) {

        $rent_id = $request->rent_id;
        StaffRentDetail::where('id', $rent_id)->delete();
        return array( 'error' => 0, 'message' => 'Rent has been deleted successfully');

    }
}
