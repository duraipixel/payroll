<style>
    .tax-calculation-table {
        border-collapse: collapse;
        font-size: 12px;
    }

    .tax-calculation-table td {
        border: 1px solid #9A9B9D;
        padding: 0px 5px;
    }

    input {
        border: none;
    }

    center {
        text-align: center;
    }

    .w-120px {
        width: 120px !important;
    }

    .w-100 {
        width: 100%;
    }

    /* .w-75 {
        width: 75%;
    }
    .w-25 {
        width: 25%;
    } */

    .border-bottom {
        border-bottom: 1px solid #ddd;
    }

    .text-end {
        text-align: right;
    }

    .d-flex {
        display: flex;
        /* align-content: center; */
    }

    .align-items-center {
        align-items: center;
    }

    .deduct-div {
        /* padding: 3px; */
    }

    .deduct-div:nth-of-type(odd) {
        background-color: #fbfdff;
    }

    .deduct-div:nth-of-type(even) {
        background-color: #f1f0f0;
    }

    .fs-5 {
        font-size: 11px;
    }
</style>
<center style="text-align: center;width:100%;font-size:13px;font-weight:bold;margin-bottom:5px;">
    STATEMENT FOR CALCULATION OF INCOME TAX FOR THE YEAR {{ $info->academic->from_year }}-{{ $info->academic->to_year }}
</center>
<table class="tax-calculation-table">
    <tr>
        <td>Total Income during the financial year {{ $info->academic->from_year }}-{{ $info->academic->to_year }} </td>
        <td class="w-120px"> {{ $salary_pattern->gross_salary ?? 0 }} x {{ $salary_calculated_month }}</td>
        <td>
            <input type="text" name="" class="form-input text-end" value="{{ $info->gross_salary_anum }}">
        </td>
    </tr>
    <tr>
        <td>
            Less : Standard Deduction
        </td>
        <td class="w-120px">{{ $info->standard_deduction }}</td>
        <td>
            <input type="text" name="" class="form-input text-end"
                value="{{ $info->gross_salary_anum - $info->standard_deduction }}">
        </td>
    </tr>
    <tr>
        <td colspan="2">Less : House Rent Allowance</td>
        <td>
            <input type="text" name="" class="form-input text-end" value="{{ $info->hra }}">
        </td>
    </tr>
    <tr>

        <td colspan="2">Total Salary Income for the year 2021-2022 </td>
        <td>
            <input type="text" name="" class="form-input text-end"
                value="{{ $info->total_year_salary_income }}">
        </td>
    </tr>
    <tr>
        <td>
            Deduct Loss from Self-Occupied House on account of Housing Loan Interest
            (Maximum Rs.2,00,000)
        </td>
        <td class="w-120px"> {{ $info->housing_loan_interest }} </td>
        <td>
            <input type="text" name="" class="form-input text-end"
                value="{{ $info->total_extract_from_housing_loan_interest }}">
        </td>
    </tr>
    <tr>
        <td>
            Profession Tax – Amount of profession tax actually paid (section 16 (I))
        </td>
        <td>
            {{ $info->professional_tax }}
        </td>
        <td>
            <input type="text" name="" class="form-input text-end"
                value="{{ $info->total_extract_from_professional_tax }}">
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
                        $amount = getStaffOtherIncomeAmount($info->staff_id, $oitem->id);
                        $other_income_amount += $amount;
                    @endphp

                    <div class="d-flex deduct-div border-bottom w-100">
                        <div class="w-75 fs-5">{{ $oitem->name }}</div>
                        <div class="w-25 text-end">Rs.{{ $amount }}</div>
                    </div>
                @endforeach
            @endif

        </td>

        <td>
            <input type="text" name="" class="form-input text-end" value="{{ $info->other_income }}">
        </td>
    </tr>
    <tr class="bg-secondary">
        <td colspan="2">
            Gross Income
        </td>
        <td>
            <input type="text" name="" class="form-input text-end" value="{{ $info->gross_income }}">
        </td>
    </tr>
    <tr>
        <td colspan="2">
            Deduction U/s 80 (Chapter VI-A) U/s 80C
            <div>
                @if (isset($deduction_80c) && !empty($deduction_80c))
                    @php
                        $total_deduction_80c = 0;
                    @endphp
                    @foreach ($deduction_80c as $deitem)
                        @php
                            $total_deduction_80c += getStaffDeduction80CAmount($info->staff_id, $deitem->id);
                        @endphp

                        <div class="d-flex deduct-div border-bottom">
                            <div class="w-75">{{ $deitem->name }}</div>
                            <div class="w-25 text-end">
                                Rs.{{ getStaffDeduction80CAmount($info->staff_id, $deitem->id) }}</div>
                        </div>
                    @endforeach
                    <div class="d-flex deduct-div border-bottom">
                        <div class="w-75 fw-bold">Total (Maximum Rs.{{ $deduction_80c_info->maximum_limit }}) </div>
                        <div class="w-25 text-end fw-bold">Rs.{{ $total_deduction_80c }}</div>
                    </div>
                @endif

            </div>
        </td>
        <td>
            <input type="text" name="" class="form-input text-end" value="{{ $info->deduction_80c_amount }}">
        </td>
    </tr>
    <tr>
        <td>
            {{ $national_pension_80cc1b->name ?? '' }} (Maximum
            Rs.{{ $national_pension_80cc1b->maximum_limit ?? 0 }})
        </td>
        <td class="w-120px text-end">
            {{ $info->staff->staffNationalPestion->amount ?? '0' }}
        </td>
        <td>
            <input type="text" name="" class="form-input text-end"
                value="{{ $info->national_pension_amount }}">
        </td>
    </tr>
    <tr>
        <td>
            {{ $medical_insurance->name ?? '' }} (Maximum
            Rs.{{ $medical_insurance->maximum_limit ?? '' }})
        </td>
        <td class="text-end">
            {{ $info->staff->staffMedicalPolicyDeduction->amount ?? '0' }}
        </td>
        <td>
            <input type="text" name="" class="form-input text-end"
                value="{{ $info->medical_policy_amount }}">
        </td>
    </tr>
    <tr>
        <td>
            {{ $bank_interest_80tta->name ?? '' }} - 80TTA (Maximum
            Rs.{{ $bank_interest_80tta->maximum_limit ?? '' }})
        </td>
        <td class="text-end">
            {{ $info->staff->staffBankInterest80TTADedcution->amount ?? '0' }}
        </td>
        <td>
            <input type="text" name="" class="form-input text-end"
                value="{{ $info->bank_interest_deduction_amount }}">
        </td>
    </tr>
    <tr class="bg-light-danger">
        <td colspan="2">
            Total Deductions
        </td>

        <td>
            <input type="text" name="" class="form-input text-end"
                value="{{ $info->total_deduction_amount }}">
        </td>
    </tr>
    <tr class="bg-light-success">
        <td colspan="2">
            Taxable Gross Income
        </td>

        <td>
            <input type="text" name="" class="form-input text-end" value="{{ $info->taxable_gross_income }}">
        </td>
    </tr>
    <tr>
        <td colspan="2">
            Taxable Gross Income (Rounded off to nearest multiple of ten)
        </td>

        <td>
            <input type="text" name="" class="form-input text-end"
                value="{{ $info->round_off_taxable_gross_income }}">
        </td>
    </tr>
    <tr>
        <td colspan="2">
            Tax on Taxable Gross Income
        </td>
        <td>
            <input type="text" name="" class="form-input text-end"
                value="{{ $info->tax_on_taxable_gross_income }}">
        </td>
    </tr>
    <tr>
        <td colspan="2">
            Tax after Rebate
        </td>
        <td>
            <input type="text" name="" class="form-input text-end"
                value="{{ $info->tax_after_rebate_amount }}">
        </td>
    </tr>
    <tr>
        <td colspan="2">
            Add : Educational Cess @ 4% on Tax payable
        </td>
        <td>
            <input type="text" name="" class="form-input text-end"
                value="{{ $info->educational_cess_tax_payable }}">
        </td>
    </tr>
    <tr class="bg-success">
        <td colspan="2" style="font-weight: bold">
            Total Income Tax payable sum
        </td>
        <td>
            <input type="text" name="" class="form-input text-end" style="font-weight: bold"
                value="{{ $info->total_income_tax_payable }}">
        </td>
    </tr>
    <tr>
        <td colspan="2">
            Less : Tax already paid (suim of total tax paid so far)
        </td>
        <td>
            <input type="text" name="" class="form-input text-end" value="">
        </td>
    </tr>
    <tr>
        <td colspan="2">
            Total tax deducted / tax to be deducted
        </td>
        <td>
            <input type="text" name="" class="form-input text-end" value="">
        </td>
    </tr>
</table>
