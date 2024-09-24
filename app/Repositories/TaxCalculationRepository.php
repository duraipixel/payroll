<?php

namespace App\Repositories;

use App\Models\AcademicYear;
use App\Models\PayrollManagement\ItStaffStatement;
use App\Models\PayrollManagement\OtherIncome;
use App\Models\PayrollManagement\StaffSalaryPattern;
use App\Models\PayrollManagement\StaffSalaryPatternField;
use App\Models\Staff\StaffDeduction;
use App\Models\Tax\TaxScheme;
use App\Models\Tax\TaxSection;
use App\Models\Tax\TaxSectionItem;
use App\Models\User;
use App\Http\Controllers\PayrollManagement\IncomeTaxController;
class TaxCalculationRepository
{
    public function generateStatementForStaff($staff_id)
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        $staff_details = User::find($staff_id);
        if($staff_details->tax_scheme_id==''){
         return ['error' =>1, 'message' =>'Please set schema then create incometax calculation'];
        }
        $academic_data = AcademicYear::find(academicYearId());
        $statement_info = ItStaffStatement::where('staff_id', $staff_id)->where(['academic_id' => academicYearId(), 'status' => 'active'])->first();

        $info =  $statement_info;
        $current_tax_schemes = TaxScheme::find($staff_details->tax_scheme_id);
        // dd( $staff_details->staffBankInterest80TTADedcution );
        if ($academic_data) {

            $sdate = $academic_data->from_year . '-' . $academic_data->from_month . '-01';
            $start_date = date('Y-m-d', strtotime($sdate));
            $edate = $academic_data->to_year . '-' . $academic_data->to_month . '-01';
            $end_date = date('Y-m-t', strtotime($edate));

            $salary_pattern = StaffSalaryPattern::where(['staff_id' => $staff_id, 'verification_status' => 'approved'])
                ->where(function ($q) use ($start_date, $end_date) {
                    $q->where('payout_month', '>=', $start_date);
                    // $q->where('payout_month', '<=', $end_date);
                })
                ->orderBy('payout_month', 'desc')
                ->where('is_current', 'yes')
                ->first();

            $gross_salary_annum = 0;
            if (isset($salary_pattern) && !empty($salary_pattern)) {

                $salary_calculated_month = getTaxOtherSalaryCalulatedMonth($salary_pattern);

                $gross_salary_annum = $salary_pattern->gross_salary * $salary_calculated_month;
                // $professional_tax = getProfessionTaxAmount($salary_pattern->gross_salary, $salary_pattern->payout_month);

                $pf_data = StaffSalaryPatternField::join('salary_fields', 'salary_fields.id', '=', 'staff_salary_pattern_fields.field_id')
                    ->where('staff_salary_pattern_id', $salary_pattern->id)
                    ->where('salary_fields.short_name', 'EPF')
                    ->first();

                /**
                 * 1. staff epf deduction has to enter manually in  staff deduction table
                 */
                if( $pf_data ) {

                    $current_scheme = TaxScheme::where('is_current', 'yes')->where('status', 'active')->first();
                    $section_data = TaxSection::where('tax_scheme_id', $current_scheme->id)->where('slug', '80c')->first();
                    $pf_calc_data = TaxSectionItem::where('tax_section_id', $section_data->id)
                        ->where('is_pf_calculation', 'yes')->first();
                    $academic_id = academicYearId();
                    $ins['academic_id'] = $academic_id;
                    $ins['staff_id'] = $staff_id;
                    $ins['tax_section_id'] = $section_data->id;
                    $ins['tax_section_item_id'] = $pf_calc_data->id;
                    $ins['remarks'] = 'System Generated';
                    $ins['amount'] = ($pf_data->amount ?? 0) * 12;
                    $ins['status'] = 'active';
                    $ins['non_editable'] = 'yes';
                    $ins['added_by'] = auth()->id();
                    $ins['updated_by'] = auth()->id();
    
                    StaffDeduction::updateOrCreate(['academic_id' => $academic_id, 'staff_id' => $staff_id, 'tax_section_id' => $section_data->id, 'tax_section_item_id' => $pf_calc_data->id, 'non_editable' => 'yes'], $ins);
                }
            }

            $other_income = OtherIncome::where('status', 'active')->get();


            $deduction_80c = TaxSectionItem::select('tax_section_items.*')->join('tax_sections', 'tax_sections.id', '=', 'tax_section_items.tax_section_id')
                ->where('tax_sections.slug', '80c')
                ->where('tax_section_items.tax_scheme_id', $current_tax_schemes->id)->get();
            $deduction_80c_info = TaxSection::where('slug', '80c')->where('tax_scheme_id', $current_tax_schemes->id)->first();
            $medical_insurance = TaxSectionItem::select('tax_section_items.*', 'tax_sections.maximum_limit')->join('tax_sections', 'tax_sections.id', '=', 'tax_section_items.tax_section_id')
                ->where('tax_sections.slug', 'medical-insurance')
                ->where('tax_section_items.tax_scheme_id', $current_tax_schemes->id)->first();
            $bank_interest_80tta = TaxSectionItem::select('tax_section_items.*', 'tax_sections.maximum_limit')->join('tax_sections', 'tax_sections.id', '=', 'tax_section_items.tax_section_id')
                ->where('tax_sections.slug', '80tta')
                ->where('tax_section_items.tax_scheme_id', $current_tax_schemes->id)->first();
    
            $national_pension_80cc1b = TaxSectionItem::select('tax_section_items.*', 'tax_sections.maximum_limit')->join('tax_sections', 'tax_sections.id', '=', 'tax_section_items.tax_section_id')
                ->where('tax_sections.slug', '80-ccd-1b')
                ->where('tax_section_items.tax_scheme_id', $current_tax_schemes->id)->first();
    
            $hra_amount = getHRAAmount($current_tax_schemes->id, $staff_id, $salary_pattern);
        }
        // $professional_tax_amount = getProfessionTaxAmount($salary_pattern);

        /**
         * Calculation start for new tax calculation for staff
         */
        $statement_id = '';

        if( $gross_salary_annum > 0 ) {
            
            $total = ($gross_salary_annum) - 50000;
            $total1 = $total - $hra_amount;
            $total2 = $total1 - getStaffDeductionAmount($staff_details->id, 'self-occupied-house') ?? 0;
            /**
             * other income
             */
            $other_income_amount = 0;
            if (isset($other_income) && !empty($other_income)) {
    
                foreach ($other_income as $oitem) {
                    $amount = 0;
                    $amount = getStaffOtherIncomeAmount($staff_details->id, $oitem->id);
                    $other_income_amount += $amount;
                }
                $total3 = $total2 + $other_income_amount;
            }
            $total_deduction_amount = 0;
            if (isset($deduction_80c) && !empty($deduction_80c)) {
                $total_deduction_80c = 0;
                foreach ($deduction_80c as $deitem) {
                    $total_deduction_80c += getStaffDeduction80CAmount($staff_details->id, $deitem->id);
                }
                $deduction_80c_amount = $total_deduction_80c;
                if ($deduction_80c_info->maximum_limit < $total_deduction_80c) {
                    $deduction_80c_amount = $deduction_80c_info->maximum_limit;
                }
                $total_deduction_amount += $deduction_80c_amount;
            }
            #national_pension_amount
            $national_pension_amount = $staff_details->staffNationalPestion->amount ?? 0;
            if ($national_pension_80cc1b->maximum_limit < $national_pension_amount) {
                $national_pension_amount = $national_pension_80cc1b->maximum_limit;
            }
            $total_deduction_amount += $national_pension_amount;
            #medical_policy_amount
            $medical_policy_amount = $staff_details->staffMedicalPolicyDeduction->amount ?? 0;
            if ($medical_insurance->maximum_limit < $medical_policy_amount) {
                $medical_policy_amount = $medical_insurance->maximum_limit;
            }
            $total_deduction_amount += $medical_policy_amount;
            #bank_interest_deduction_amount
            $bank_interest_deduction_amount = $staff_details->staffBankInterest80TTADedcution->amount ?? 0;
            if ($bank_interest_80tta->maximum_limit < $bank_interest_deduction_amount) {
                $bank_interest_deduction_amount = $bank_interest_80tta->maximum_limit;
            }
            $total_deduction_amount += $bank_interest_deduction_amount;
    
            $total4 = $total3 - $total_deduction_amount;
    
            if (roundOff($total4) < 500000) {
                $tax_after_rebate_amount = 0;
            } else {
                $tax_after_rebate_amount = getTaxablePayAmountUsingSlabs($total4,$staff_details->tax_scheme_id);
            }
    
            $total_income_tax_payable = $tax_after_rebate_amount + round(getPercentageAmount(4, $tax_after_rebate_amount));
    
            $ins = array(
                'academic_id' => academicYearId(),
                'staff_id' => $staff_id,
                'pan_no' => $staff_details->pan->doc_number ?? '',
                'designation_id' => $staff_details->position->designation_id ?? '',
                'gross_salary_anum' => $gross_salary_annum,
                'standard_deduction' => 50000,
                'gross_extract_from_standard_deduction' => $gross_salary_annum - 50000,
                'hra' => $hra_amount,
                'total_year_salary_income' => $total1,
                'housing_loan_interest' => getStaffDeductionAmount($staff_details->id, 'self-occupied-house'),
                'total_extract_from_housing_loan_interest' => $total2,
                'professional_tax' => 0,
                'total_extract_from_professional_tax' => $total2,
                'other_income' => $other_income_amount,
                'gross_income' => $total3,
                'deduction_80c_amount' => $deduction_80c_amount,
                'national_pension_amount' => $national_pension_amount,
                'medical_policy_amount' => $medical_policy_amount,
                'bank_interest_deduction_amount' => $bank_interest_deduction_amount,
                'total_deduction_amount' => $total_deduction_amount,
                'taxable_gross_income' => $total4,
                'round_off_taxable_gross_income' => roundOff($total4),
                'tax_on_taxable_gross_income' => getTaxablePayAmountUsingSlabs($total4,$staff_details->tax_scheme_id),
                'tax_after_rebate_amount' => $tax_after_rebate_amount,
                'educational_cess_tax_payable' => round(getPercentageAmount(4, $tax_after_rebate_amount)),
                'total_income_tax_payable' => $total_income_tax_payable,
                'salary_pattern_id' => $salary_pattern->id ?? null,
                'added_by' => auth()->id(),
               'tax_scheme_id'=>$staff_details->tax_scheme_id??1,
            );
            if( $total_income_tax_payable == 0 ) {
                $ins['lock_calculation'] = 'yes';
            }
            // dd( $ins );
            $check_exist = ItStaffStatement::where(['academic_id' => academicYearId(), 'staff_id' => $staff_id, 'status' => 'active' ])->first();
           
            if( !$check_exist ) {
    
                $statement_id = ItStaffStatement::create($ins)->id;
            }else{
                #..ajith

                $statement_id = $check_exist->id; 

            }
        }
        if( $statement_id ) {
            generateIncomeTaxStatementPdfByStaff($statement_id);
            return true;
        } else {
          
            return false;
        }
        
    }

    public function generateIncomeTaxStatemenForAll() {

        $staff_details = User::where('verification_status', 'approved')->where('status', 'active')->where('transfer_status', 'active')->get();
        $generated = [];
        $not_generated = [];
        if( isset( $staff_details ) && !empty( $staff_details ) ) {
            foreach( $staff_details as $items ) {
                if( $this->generateStatementForStaff($items->id ) ) {
                    $generated[] = $items;
                }
            }
        }

        return $generated;

    }
}
