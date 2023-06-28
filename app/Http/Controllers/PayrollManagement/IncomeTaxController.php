<?php

namespace App\Http\Controllers\PayrollManagement;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\PayrollManagement\OtherIncome;
use App\Models\PayrollManagement\StaffSalaryPattern;
use App\Models\PayrollManagement\StaffSalaryPatternField;
use App\Models\Staff\StaffDeduction;
use App\Models\Staff\StaffOtherIncome;
use App\Models\Tax\TaxScheme;
use App\Models\Tax\TaxSection;
use App\Models\Tax\TaxSectionItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $params['current_scheme'] = $current_scheme;
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
            'pf_data' => $pf_data ?? []
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
}
