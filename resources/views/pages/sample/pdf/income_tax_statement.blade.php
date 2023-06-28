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
        border:none;
    }
    center{
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
    .align-items-center{
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
    STATEMENT FOR CALCULATION OF INCOME TAX FOR THE YEAR 2021-2022
</center>
<table class="tax-calculation-table">
    <tr>
        <td>Total Income during the financial year 2021-2022 </td>
        <td class="w-120px"> 100000 x 12 </td>
        <td>
            <input type="text" name="" class="form-input text-end" value="">
        </td>
    </tr>
    <tr>
        <td>
            Less : Standard Deduction
        </td>
        <td class="w-120px">50,000</td>
        <td>
            <input type="text" name="" class="form-input text-end" value="1150000">
        </td>
    </tr>
    <tr>
        <td colspan="2">Less : House Rent Allowance</td>
        <td>
            <input type="text" name="" class="form-input text-end" value="40,000">
        </td>
    </tr>
    <tr>

        <td colspan="2">Total Salary Income for the year 2021-2022 </td>
        <td>
            <input type="text" name="" class="form-input text-end" value="1110000">
        </td>
    </tr>
    <tr>
        <td>
            Deduct Loss from Self-Occupied House on account of Housing Loan Interest
            (Maximum Rs.2,00,000)
        </td>
        <td class="w-120px"> 40000 </td>
        <td>
            <input type="text" name="" class="form-input text-end" value="1070000">
        </td>
    </tr>
    <tr>
        <td>
            Profession Tax – Amount of profession tax actually paid (section 16 (I))
        </td>
        <td>
            2500
        </td>
        <td>
            <input type="text" name="" class="form-input text-end" value="1067500">
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <div class="text-muted"> Other Income </div>
            <div class="d-flex deduct-div border-bottom w-100">
                <div class="w-75 fs-5">Interest from Fixed Deposit & RD </div>
                <div class="w-25 text-end">Rs.1200</div>
            </div>
            <div class="d-flex deduct-div border-bottom">
                <div class="w-75 fs-5" >Interest from Fixed Deposit & RD </div>
                <div class="w-25 text-end">Rs.1200</div>
            </div>
            <div class="d-flex deduct-div border-bottom">
                <div class="w-75 fs-5">Interest from Fixed Deposit & RD </div>
                <div class="w-25 text-end">Rs.1200</div>
            </div>
            <div class="d-flex deduct-div border-bottom">
                <div class="w-75 fs-5">Interest from Fixed Deposit & RD </div>
                <div class="w-25 text-end">Rs.1200</div>
            </div>
            <div class="d-flex deduct-div border-bottom">
                <div class="w-75 fs-5">Interest from Fixed Deposit & RD </div>
                <div class="w-25 text-end">Rs.1200</div>
            </div>
        </td>

        <td>
            <input type="text" name="" class="form-input text-end" value="1067500">
        </td>
    </tr>
    <tr class="bg-secondary">
        <td colspan="2">
            Gross Income
        </td>
        <td>
            <input type="text" name="" class="form-input text-end" value="1067500">
        </td>
    </tr>
    <tr>
        <td colspan="2">
            Deduction U/s 80 (Chapter VI-A) U/s 80C
            <div>
                <div class="d-flex deduct-div border-bottom">
                    <div class="w-75">EPF Contribution (Employee share) </div>
                    <div class="w-25 text-end">Rs.1200</div>
                </div>
                <div class="d-flex deduct-div border-bottom">
                    <div class="w-75">Interest from Fixed Deposit & RD </div>
                    <div class="w-25 text-end">Rs.1200</div>
                </div>
                <div class="d-flex deduct-div border-bottom">
                    <div class="w-75">Interest from Fixed Deposit & RD </div>
                    <div class="w-25 text-end">Rs.1200</div>
                </div>
                <div class="d-flex deduct-div border-bottom">
                    <div class="w-75">Interest from Fixed Deposit & RD </div>
                    <div class="w-25 text-end">Rs.1200</div>
                </div>
                <div class="d-flex deduct-div border-bottom">
                    <div class="w-75 fw-bold">Total (Maximum Rs.1,50,000) </div>
                    <div class="w-25 text-end fw-bold">Rs.2080000</div>
                </div>
            </div>
        </td>
        <td>
            <input type="text" name="" class="form-input text-end" value="1,50,000">
        </td>
    </tr>
    <tr>
        <td>
            National Pension System u/s 80 CCD (1B) (Maximum Rs.50,000)
        </td>
        <td class="w-120px text-end">
            70000
        </td>
        <td>
            <input type="text" name="" class="form-input text-end" value="50000">
        </td>
    </tr>
    <tr>
        <td>
            Medical Insurance for assessee or any member of the family (Maximum Rs.25,000)
        </td>
        <td class="text-end">
            50000
        </td>
        <td>
            <input type="text" name="" class="form-input text-end" value="25000">
        </td>
    </tr>
    <tr>
        <td>
            Savings Bank Interest – 80TTA (Maximum Rs.10,000)
        </td>
        <td class="text-end">
            35000
        </td>
        <td>
            <input type="text" name="" class="form-input text-end" value="10000">
        </td>
    </tr>
    <tr class="bg-light-danger">
        <td colspan="2">
            Total Deductions
        </td>

        <td>
            <input type="text" name="" class="form-input text-end" value="23500">
        </td>
    </tr>
    <tr class="bg-light-success">
        <td colspan="2">
            Taxable Gross Income
        </td>

        <td>
            <input type="text" name="" class="form-input text-end" value="84250">
        </td>
    </tr>
    <tr>
        <td colspan="2">
            Taxable Gross Income (Rounded off to nearest multiple of ten)
        </td>

        <td>
            <input type="text" name="" class="form-input text-end" value="84250">
        </td>
    </tr>
    <tr>
        <td colspan="2">
            Tax on Taxable Gross Income
        </td>
        <td>
            <input type="text" name="" class="form-input text-end" value="84250">
        </td>
    </tr>
    <tr>
        <td colspan="2">
            Tax after Rebate
        </td>
        <td>
            <input type="text" name="" class="form-input text-end" value="84250">
        </td>
    </tr>
    <tr>
        <td colspan="2">
            Add : Educational Cess @ 4% on Tax payable
        </td>
        <td>
            <input type="text" name="" class="form-input text-end" value="84250">
        </td>
    </tr>
    <tr class="bg-success">
        <td colspan="2">
            Total Income Tax payable sum
        </td>
        <td>
            <input type="text" name="" class="form-input text-end" value="84250">
        </td>
    </tr>
    <tr>
        <td colspan="2">
            Less : Tax already paid (suim of total tax paid so far)
        </td>
        <td>
            <input type="text" name="" class="form-input text-end" value="84250">
        </td>
    </tr>
    <tr>
        <td colspan="2">
            Total tax deducted / tax to be deducted
        </td>
        <td>
            <input type="text" name="" class="form-input text-end" value="84250">
        </td>
    </tr>
</table>
