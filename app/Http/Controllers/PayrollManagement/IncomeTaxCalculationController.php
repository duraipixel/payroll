<?php

namespace App\Http\Controllers\PayrollManagement;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\PayrollManagement\OtherIncome;
use App\Models\PayrollManagement\StaffSalaryPattern;
use App\Models\PayrollManagement\StaffSalaryPatternField;
use App\Models\Tax\TaxScheme;
use App\Models\Tax\TaxSection;
use App\Models\Tax\TaxSectionItem;
use App\Models\User;
use Illuminate\Http\Request;

class IncomeTaxCalculationController extends Controller
{
    public function index(Request $request)
    {

        $employees = User::where('status', 'active')->whereNull('is_super_admin')->get();

        $params = array(
            'employees' => $employees,
        );
        return view('pages.payroll_management.it_calculation.index', $params);
    }

    public function getCalculationForm(Request $request)
    {
        $staff_id = $request->staff_id;
        $staff_details = User::find($staff_id);
        $academic_data = AcademicYear::find(academicYearId());
        $current_tax_schemes = TaxScheme::where('is_current', 'yes')->first();
        // dd( $staff_details->staffBankInterest80TTADedcution );
        $error_message = '';
        if ($academic_data) {

            $sdate = $academic_data->from_year . '-' . $academic_data->from_month . '-01';
            $start_date = date('Y-m-d', strtotime($sdate));
            $edate = $academic_data->to_year . '-' . $academic_data->to_month . '-01';
            $end_date = date('Y-m-t', strtotime($edate));

            $salary_pattern = StaffSalaryPattern::where(['staff_id' => $staff_id, 'verification_status' => 'approved'])
                ->where(function ($q) use ($start_date, $end_date) {
                    $q->where('payout_month', '>=', $start_date);
                    $q->where('payout_month', '<=', $end_date);
                })
                ->first();

            if (isset($salary_pattern) && !empty($salary_pattern)) {
                $gross_salary_annum = $salary_pattern->gross_salary * 12;
                $professional_tax = getProfessionTaxAmount($salary_pattern->gross_salary, $salary_pattern->payout_month);

                $pf_data = StaffSalaryPatternField::join('salary_fields', 'salary_fields.id', '=', 'staff_salary_pattern_fields.field_id')
                    ->where('staff_salary_pattern_id', $salary_pattern->id)
                    ->where('salary_fields.short_name', 'EPF')
                    ->first();
            } else {
                $error_message = 'Salary Approval pending or Salary not created';
            }
            $other_income = OtherIncome::where('status', 'active')->get();
        }
        $deduction_80c = TaxSectionItem::select('tax_section_items.*')->join('tax_sections', 'tax_sections.id', '=', 'tax_section_items.tax_section_id')
                                ->where('tax_sections.slug', '80c')
                                ->where('tax_section_items.tax_scheme_id', $current_tax_schemes->id)->get();
        $deduction_80c_info = TaxSection::where('slug', '80c')->where('tax_scheme_id', $current_tax_schemes->id)->first();
        $medical_insurance = TaxSectionItem::select('tax_section_items.*','tax_sections.maximum_limit')->join('tax_sections', 'tax_sections.id', '=', 'tax_section_items.tax_section_id')
                                ->where('tax_sections.slug', 'medical-insurance')
                                ->where('tax_section_items.tax_scheme_id', $current_tax_schemes->id)->first();
        $bank_interest_80tta = TaxSectionItem::select('tax_section_items.*','tax_sections.maximum_limit')->join('tax_sections', 'tax_sections.id', '=', 'tax_section_items.tax_section_id')
                                ->where('tax_sections.slug', '80tta')
                                ->where('tax_section_items.tax_scheme_id', $current_tax_schemes->id)->first();
        
        $national_pension_80cc1b = TaxSectionItem::select('tax_section_items.*','tax_sections.maximum_limit')->join('tax_sections', 'tax_sections.id', '=', 'tax_section_items.tax_section_id')
                                ->where('tax_sections.slug', '80-ccd-1b')
                                ->where('tax_section_items.tax_scheme_id', $current_tax_schemes->id)->first();
        $params = array(
            'pf_data' => $pf_data ?? [],
            'gross_salary_annum' => $gross_salary_annum ?? 0,
            'salary_pattern' => $salary_pattern,
            'staff_details' => $staff_details,
            'error_message' => $error_message,
            'academic_data' => $academic_data,
            'other_income' => $other_income,
            'deduction_80c' => $deduction_80c,
            'deduction_80c_info' => $deduction_80c_info,
            'medical_insurance' => $medical_insurance,
            'bank_interest_80tta' => $bank_interest_80tta,
            'national_pension_80cc1b' => $national_pension_80cc1b
        );
        // dd( $salary_pattern );
        return view('pages.payroll_management.it_calculation._calc_form', $params);
    }
}
