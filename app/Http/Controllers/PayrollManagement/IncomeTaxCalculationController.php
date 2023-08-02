<?php

namespace App\Http\Controllers\PayrollManagement;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\PayrollManagement\ItStaffStatement;
use App\Models\PayrollManagement\OtherIncome;
use App\Models\PayrollManagement\StaffSalaryPattern;
use App\Models\PayrollManagement\StaffSalaryPatternField;
use App\Models\Tax\TaxScheme;
use App\Models\Tax\TaxSection;
use App\Models\Tax\TaxSectionItem;
use App\Models\User;
use App\Repositories\TaxCalculationRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use PDF;

class IncomeTaxCalculationController extends Controller
{
    private $taxRepository;
    public function __construct(TaxCalculationRepository $taxRepository)
    {
        $this->taxRepository = $taxRepository;
    }

    public function index(Request $request)
    {

        $employees = User::where('status', 'active')->orderBy('name', 'asc')->whereNull('is_super_admin')->get();
               
        // die;
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
        $statement_info = ItStaffStatement::where('staff_id', $staff_id)->where(['academic_id' => academicYearId(), 'status' => 'active'])->first();

        $info =  $statement_info;
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
                ->where('is_current', 'yes')
                ->first();
            
            if (isset($salary_pattern) && !empty($salary_pattern)) {

                $salary_calculated_month = getTaxOtherSalaryCalulatedMonth($salary_pattern);

                $gross_salary_annum = $salary_pattern->gross_salary * $salary_calculated_month;
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
        // $professional_tax_amount = getProfessionTaxAmount($salary_pattern);
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
            'national_pension_80cc1b' => $national_pension_80cc1b,
            'hra_amount' => $hra_amount,
            'salary_calculated_month' => $salary_calculated_month ?? 0,
            'statement_info' => $statement_info ?? '',
            'info' => $info
        );
        // dd( $salary_pattern );
        return view('pages.payroll_management.it_calculation._calc_form', $params);
    }

    public function ajaxTaxCalculation(Request $request)
    {

        $total_deduction_amount = $request->total_deduction_amount;
        $total_year_salary_income = $request->total_year_salary_income;
        $round_total = roundOff($total_year_salary_income);
        $tmp['round_total'] = $round_total;

        $tmp['tax_amount'] = getTaxablePayAmountUsingSlabs($round_total);

        if ($round_total < 500000) {
            $tmp['tax_after_rebate_amount'] = 0;
        } else {
            $tmp['tax_after_rebate_amount'] = $tmp['tax_amount'];
        }
        $tmp['educational_cess_tax_payable'] = round(getPercentageAmount(4, $tmp['tax_after_rebate_amount']));
        $tmp['total_income_tax_payable'] = $tmp['tax_after_rebate_amount'] + $tmp['educational_cess_tax_payable'];
        return $tmp;
    }

    public function saveItStatement(Request $request)
    {
        $staff_id = $request->staff_id;
      
        $academic_id = academicYearId();
        $id = $request->id ?? '';
        $validator      = Validator::make($request->all(), [
            'staff_id' => [
                'required', 'string',
                Rule::unique('it_staff_statements')->where(function ($query) use ($staff_id, $academic_id, $id) {
                    return $query->where('deleted_at', NULL)
                        ->where('staff_id', $staff_id)
                        ->where('academic_id', $academic_id)
                        ->where('status', 'active')
                        ->when($id != '', function ($q) use ($id) {
                            return $q->where('id', '!=', $id);
                        });
                }),
            ]
        ]);

        if ($validator->passes()) {
            // dd( $request->all() );
            $staff_details = User::find($staff_id);
            $mode = $request->mode ?? '';
            $ins = array(
                'academic_id' => academicYearId(),
                'staff_id' => $staff_id,
                'salary_pattern_id' => $request->salary_pattern_id ?? '',
                'pan_no' => $request->pan_no,
                'designation_id' => $request->designation_id,
                'gross_salary_anum' => $request->gross_salary_anum,
                'standard_deduction' => $request->standard_deduction,
                'gross_extract_from_standard_deduction' => $request->gross_extract_from_standard_deduction,
                'hra' => $request->hra,
                'total_year_salary_income' => $request->total_year_salary_income,
                'housing_loan_interest' => $request->housing_loan_interest,
                'total_extract_from_housing_loan_interest' => $request->total_extract_from_housing_loan_interest,
                'professional_tax' => $request->professional_tax,
                'total_extract_from_professional_tax' => $request->total_extract_from_professional_tax,
                'other_income' => $request->other_income,
                'gross_income' => $request->gross_income,
                'deduction_80c_amount' => $request->deduction_80c_amount,
                'national_pension_amount' => $request->national_pension_amount,
                'medical_policy_amount' => $request->medical_policy_amount,
                'bank_interest_deduction_amount' => $request->bank_interest_deduction_amount,
                'total_deduction_amount' => $request->total_deduction_amount,
                'taxable_gross_income' => $request->taxable_gross_income,
                'round_off_taxable_gross_income' => $request->round_off_taxable_gross_income,
                'tax_on_taxable_gross_income' => $request->tax_on_taxable_gross_income,
                'tax_after_rebate_amount' => $request->tax_after_rebate_amount,
                'educational_cess_tax_payable' => $request->educational_cess_tax_payable,
                'total_income_tax_payable' => $request->total_income_tax_payable,
                'added_by' => auth()->id()
            );
            if( isset($mode) && $mode == 'lock' ) {
                $ins['lock_calculation'] = 'yes';
            }

            $statement_id = ItStaffStatement::updateOrCreate(['id' => $id], $ins);
            /**
             * generate it statement pdf
             */
            generateIncomeTaxStatementPdfByStaff($id);

            $error = 0;
            $message = 'Statement saved successfully';

        } else {

            $message = $validator->errors()->all();
            $error = 1;
        }
        return array('error' => $error, 'message' => $message, 'staff_id' => $request->staff_id);
    }

    public function generateNewStatement(Request $request) {

        $staff_id = $request->staff_id;
        $error = 0;
        $message = '';
        if( $staff_id ){
            if($this->taxRepository->generateStatementForStaff($staff_id)){
                $message = 'Successfully generated';
            } else {
                $error = 1;
                $message = 'Error occurred while generating.Please contact Administrator';
            }
        }
        return ['error' => $error, 'message' => $message];
    }
}
