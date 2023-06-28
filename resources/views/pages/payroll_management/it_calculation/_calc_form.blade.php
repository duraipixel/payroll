@if ($staff_details)
    @php
        $total = 0;
    @endphp
    @if ($error_message)
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="alert alert-danger">{{ $error_message }}</div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-sm-9">
                <div class="card">
                    <div class="card-body">
                        <table class="tax-calculation-table">
                            {{-- {{ dd( $academic_data ) }} --}}
                            <center class="fs-6 fw-bold">
                                STATEMENT FOR CALCULATION OF INCOME TAX FOR THE YEAR
                                {{ $academic_data->from_year }}-{{ $academic_data->to_year }}
                            </center>
                            <tr>
                                <td> Name & Emp code </td>
                                <td colspan="2">
                                    <label for="">{{ $staff_details->name ?? '' }} -
                                        {{ $staff_details->society_emp_code ?? '' }}</label>
                                    <input type="hidden" name="emp_code" id="emp_code" class="form-input text-end"
                                        value="">
                                </td>
                            </tr>
                            <tr>
                                <td> Designation </td>
                                <td colspan="2">
                                    <label
                                        for="">{{ $staff_details->position->designation->name ?? '' }}</label>
                                    <input type="hidden" name="designation_id" class="form-input text-end"
                                        value="{{ $staff_details->position->designation_id ?? '' }}">
                                </td>
                            </tr>
                            <tr>
                                <td> PAN Number </td>
                                <td colspan="2">
                                    <label for="">{{ $staff_details->pan->doc_number ?? '' }}</label>
                                    <input type="hidden" name="pan_no" class="form-input text-end"
                                        value="{{ $staff_details->pan->doc_number ?? '' }}">
                                </td>
                            </tr>
                            <tr>
                                <td>Total Income during the financial year 2021-2022 </td>
                                <td class="w-120px text-end"> {{ $salary_pattern->gross_salary ?? 0 }} x 12 </td>
                                <td>
                                    <input type="text" name="gross_salary_anum" id="gross_salary_anum"
                                        class="form-input text-end gross_salary_anum" value="{{ $gross_salary_annum }}"
                                        onkeyup="return doTaxCalculation()" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Less : Standard Deduction
                                </td>
                                <td class="w-120px text-end">50,000</td>
                                <td>
                                    <input type="hidden" name="standard_deduction" id="standard_deduction"
                                        class="form-input text-end first_deduct" value="50000"
                                        onkeyup="return doTaxCalculation()">
                                    <input type="text" name="gross_extract_from_standard_deduction"
                                        id="gross_extract_from_standard_deduction" class="form-input text-end"
                                        value="{{ $gross_salary_annum - 50000 }}" onkeyup="return doTaxCalculation()"
                                        readonly>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">Less : House Rent Allowance</td>
                                <td>
                                    <input type="text" name="hra" id="hra"
                                        class="form-input text-end first_deduct" onkeyup="return doTaxCalculation()"
                                        value="0">
                                </td>
                            </tr>
                            <tr>

                                <td colspan="2">Total Salary Income for the year
                                    {{ $academic_data->from_year }}-{{ $academic_data->to_year }} </td>
                                <td>
                                    <input type="text" name="total_year_salary_income" id="total_year_salary_income"
                                        class="form-input text-end" value="{{ $gross_salary_annum - 50000 }}">
                                </td>
                                @php
                                    $total = $gross_salary_annum - 50000;
                                @endphp
                            </tr>
                            <tr>
                                <td>
                                    Deduct Loss from Self-Occupied House on account of Housing Loan Interest
                                    (Maximum Rs.2,00,000)
                                </td>
                                <td class="w-120px text-end">
                                    {{ getStaffDeductionAmount($staff_details->id, 'self-occupied-house') }}
                                    <input type="hidden" class="" name="housing_loan_interest"
                                        id="housing_loan_interest"
                                        value=" {{ getStaffDeductionAmount($staff_details->id, 'self-occupied-house') }}">
                                </td>
                                @php
                                    $total = $total - getStaffDeductionAmount($staff_details->id, 'self-occupied-house') ?? 0;
                                    
                                @endphp
                                <td>
                                    <input type="text" id="total_extract_from_housing_loan_interest"
                                        name="total_extract_from_housing_loan_interest" class="form-input text-end"
                                        value="{{ $gross_salary_annum - 50000 - 40000 }}">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Profession Tax – Amount of profession tax actually paid (section 16 (I))
                                </td>
                                <td class="text-end">
                                    2500
                                    <input type="hidden" name="professional_tax" id="professional_tax" class=""
                                        value="2500">
                                </td>
                                @php
                                    $total = $total - 2500;
                                @endphp
                                <td>
                                    <input type="text" id="total_extract_from_professional_tax"
                                        name="total_extract_from_professional_tax" class="form-input text-end"
                                        value="{{ $total }}">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div class="text-muted"> Other Income </div>
                                    @php
                                        $other_income_amount = 0;
                                    @endphp
                                    @if (isset($other_income) && !empty($other_income))
                                        @foreach ($other_income as $oitem)
                                            @php
                                                $amount = 0;
                                                $amount = getStaffOtherIncomeAmount($staff_details->id, $oitem->id);
                                                $other_income_amount += $amount;
                                            @endphp
                                            <div class="d-flex deduct-div border-bottom">
                                                <div class="w-75">{{ $oitem->name }}</div>
                                                <div class="w-25 text-end">{{ $amount }}</div>
                                            </div>
                                        @endforeach
                                    @endif
                                    @php
                                        $total += $other_income_amount;
                                    @endphp
                                </td>

                                <td>
                                    <input type="text" name="other_income" class="form-input text-end first_add"
                                        value="{{ $other_income_amount ?? 0 }}">
                                </td>
                            </tr>
                            <tr class="bg-secondary">
                                <td colspan="2">
                                    Gross Income
                                </td>
                                <td>
                                    <input type="text" name="gross_income" id="gross_income"
                                        class="form-input text-end" value="{{ $total }}">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div class="p-2">
                                        Deduction U/s 80 (Chapter VI-A) U/s 80C
                                    </div>
                                    <div>
                                        @php
                                            $total_deduction_amount = 0;
                                        @endphp
                                        @if (isset($deduction_80c) && !empty($deduction_80c))
                                            @php
                                                $total_deduction_80c = 0;
                                            @endphp
                                            @foreach ($deduction_80c as $deitem)
                                                @php
                                                    $total_deduction_80c += getStaffDeduction80CAmount($staff_details->id, $deitem->id);
                                                @endphp
                                                <div class="d-flex deduct-div border-bottom">
                                                    <div class="w-75">{{ $deitem->name }}</div>
                                                    <div class="w-25 text-end">
                                                        Rs.{{ getStaffDeduction80CAmount($staff_details->id, $deitem->id) }}
                                                    </div>
                                                </div>
                                            @endforeach
                                            <div class="d-flex border-bottom">
                                                <div class="w-75 fw-bold">Total (Maximum
                                                    Rs.{{ $deduction_80c_info->maximum_limit }}) </div>
                                                <div class="w-25 fw-bold text-end">
                                                    Rs.{{ $total_deduction_80c }}
                                                </div>
                                            </div>
                                        @endif
                                        @php
                                            $deduction_80c_amount = $total_deduction_80c;
                                            if ($deduction_80c_info->maximum_limit < $total_deduction_80c) {
                                                $deduction_80c_amount = $deduction_80c_info->maximum_limit;
                                            }
                                            $total_deduction_amount += $deduction_80c_amount;
                                        @endphp
                                    </div>
                                </td>
                                <td>
                                    <input type="text" name="deduction_80c_amount" id="deduction_80c_amount"
                                        class="form-input text-end" value="{{ $deduction_80c_amount }}" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    {{ $national_pension_80cc1b->name ?? '' }} (Maximum
                                    Rs.{{ $national_pension_80cc1b->maximum_limit ?? 0 }})
                                </td>
                                <td class="w-120px text-end">
                                    {{ $staff_details->staffNationalPestion->amount ?? '0' }}
                                </td>
                                @php
                                    $national_pension_amount = $staff_details->staffNationalPestion->amount ?? 0;
                                    if ($national_pension_80cc1b->maximum_limit < $national_pension_amount) {
                                        $national_pension_amount = $national_pension_80cc1b->maximum_limit;
                                    }
                                    $total_deduction_amount += $national_pension_amount
                                @endphp
                                <td>
                                    <input type="text" name="national_pension_amount" id="national_pension_amount"
                                        class="form-input text-end" value="{{ $national_pension_amount }}" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    {{ $medical_insurance->name ?? '' }} (Maximum
                                    Rs.{{ $medical_insurance->maximum_limit ?? '' }})
                                </td>
                                <td class="text-end">
                                    {{ $staff_details->staffMedicalPolicyDeduction->amount ?? '0' }}
                                </td>
                                @php
                                    $medical_policy_amount = $staff_details->staffMedicalPolicyDeduction->amount ?? 0;
                                    if ($medical_insurance->maximum_limit < $medical_policy_amount) {
                                        $medical_policy_amount = $medical_insurance->maximum_limit;
                                    }
                                    $total_deduction_amount += $medical_policy_amount;
                                @endphp
                                <td>
                                    <input type="text" name="medical_policy_amount" id="medical_policy_amount"
                                        class="form-input text-end" value="{{ $medical_policy_amount }}" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    {{ $bank_interest_80tta->name ?? '' }} - 80TTA (Maximum
                                    Rs.{{ $bank_interest_80tta->maximum_limit ?? '' }})
                                </td>
                                <td class="text-end">
                                    {{ $staff_details->staffBankInterest80TTADedcution->amount ?? '0' }}
                                </td>
                                @php
                                    $bank_interest_deduction_amount = $staff_details->staffBankInterest80TTADedcution->amount ?? 0;
                                    if ($bank_interest_80tta->maximum_limit < $bank_interest_deduction_amount) {
                                        $bank_interest_deduction_amount = $bank_interest_80tta->maximum_limit;
                                    }
                                    $total_deduction_amount += $bank_interest_deduction_amount;
                                @endphp
                                <td>
                                    <input type="text" name="bank_interest_deduction_amount"
                                        id="bank_interest_deduction_amount" class="form-input text-end"
                                        value="{{ $bank_interest_deduction_amount }}" readonly>
                                </td>
                            </tr>
                            <tr class="bg-light-danger">
                                <td colspan="2">
                                    Total Deductions
                                </td>
                                <td>
                                    <input type="text" name="total_deduction_amount" id="total_deduction_amount" class="form-input text-end" readonly value="{{ $total_deduction_amount }}">
                                </td>
                            </tr>
                            <tr class="bg-light-success">
                                <td colspan="2">
                                    Taxable Gross Income
                                </td>
                                @php
                                    $total = $total - $total_deduction_amount;

                                @endphp
                                <td>
                                    <input type="text" name="taxable_gross_income" id="taxable_gross_income" class="form-input text-end" value="{{ $total }}" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    Taxable Gross Income (Rounded off to nearest multiple of ten)
                                </td>
                                <td>
                                    <input type="text" name="round_off_taxable_gross_income" id="round_off_taxable_gross_income" class="form-input text-end" value="{{ roundOff($total) }}" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    Tax on Taxable Gross Income
                                </td>
                                <td>
                                    <input type="text" name="tax_on_taxable_gross_income" id="tax_on_taxable_gross_income" class="form-input text-end" value="{{ getTaxablePayAmountUsingSlabs($total) }}" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    Tax after Rebate
                                </td>
                                @php
                                    if( roundOff($total) < 500000 ){
                                        $tax_after_rebate_amount = 0;
                                    } else {
                                        $tax_after_rebate_amount = getTaxablePayAmountUsingSlabs($total);
                                    }
                                @endphp
                                <td>
                                    <input type="text" name="tax_after_rebate_amount" id="tax_after_rebate_amount" class="form-input text-end" value="{{ $tax_after_rebate_amount ?? 0 }}" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    Add : Educational Cess @ 4% on Tax payable
                                </td>
                                <td>
                                    <input type="text" name="educational_cess_tax_payable" id="educational_cess_tax_payable" class="form-input text-end" value="{{ getPercentageAmount(4, $tax_after_rebate_amount) }}" readonly>
                                </td>
                            </tr>
                            <tr class="bg-success">
                                <td colspan="2">
                                    Total Income Tax payable sum
                                </td>
                                @php
                                    $total_income_tax_payable = $tax_after_rebate_amount + getPercentageAmount(4, $tax_after_rebate_amount);

                                @endphp
                                <td>
                                    <input type="text" name="total_income_tax_payable" id="total_income_tax_payable" class="form-input text-end" value="{{ $total_income_tax_payable }}" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    Less : Tax already paid (suim of total tax paid so far)
                                </td>
                                <td>
                                    <label></label>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    Total tax deducted / tax to be deducted
                                </td>
                                <td>
                                    <label></label>
                                </td>
                            </tr>
                        </table>
                    </div>

                </div>

            </div>
        </div>
    @endif
@endif

<script>
    function doTaxCalculation() {

        var gross_salary_anum = $('#gross_salary_anum').val();
        var first_deduct = document.querySelectorAll('.first_deduct');
        var first_add = document.querySelectorAll('.first_add');
        var first_deduct_amount = 0;
        var first_add_amount = 0;
        var total_year_salary_income = 0;

        first_deduct.forEach(element => {

            if ($(element).val() != '' && $(element).val() != 'undefined' && $(element).val() != null) {
                first_deduct_amount += parseFloat($(element).val());
            }
        });
        total_year_salary_income = parseFloat(gross_salary_anum) - first_deduct_amount;
        $('#total_year_salary_income').val(total_year_salary_income);

        var housing_loan_interest = $('#housing_loan_interest').val();
        total_year_salary_income = total_year_salary_income - parseFloat(housing_loan_interest);
        $('#total_extract_from_housing_loan_interest').val(total_year_salary_income);

        var professional_tax = $('#professional_tax').val();
        total_year_salary_income = total_year_salary_income - parseFloat(professional_tax);
        $('#total_extract_from_professional_tax').val(total_year_salary_income);

        first_add.forEach(element => {
            if ($(element).val() != '' && $(element).val() != 'undefined' && $(element).val() != null) {
                first_add_amount += parseFloat($(element).val());
            }
        });
        total_year_salary_income = total_year_salary_income + first_add_amount;
        $('#gross_income').val(total_year_salary_income);
        var total_deduction_amount = $('#total_deduction_amount').val();
        console.log(total_deduction_amount, 'total_deduction_amount');
        total_year_salary_income = total_year_salary_income - parseFloat(total_deduction_amount);
        $('#taxable_gross_income').val(total_year_salary_income);

    }
</script>
