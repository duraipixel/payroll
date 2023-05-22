<form id="bank_loan_form" enctype="multipart/form-data">
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <label for="" class="required">Bank</label>
                <select name="bank_id" id="bank_id" class="form-control">
                    <option value="">--select bank--</option>
                    @isset($bank)
                        @foreach ($bank as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    @endisset
                </select>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label for="" class="required">
                    Account No
                </label>
                <input type="text" name="account_no" id="account_no" class="form-control">
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label for="" class="required">
                    IFSC Code
                </label>
                <input type="text" name="ifsc_code" id="ifsc_code" class="form-control">
            </div>
        </div>
        <div class="col-sm-4 mt-5">
            <div class="form-group">
                <label for="" class="required">
                    Loan Type
                </label>
                <select name="loan_type" id="loan_type" class="form-control">
                    <option value="">--select--</option>
                    <option value="fixed">Fixed</option>
                    <option value="variable">Variable</option>
                </select>
            </div>
        </div>
        <div class="col-sm-4 mt-5">
            <div class="form-group">
                <label for="" class="required">
                    Amount
                </label>
                <input type="text" name="amount" id="amount" class="form-control price">
            </div>
        </div>
        <div class="col-sm-4 mt-5">
            <div class="form-group">
                <label for="" class="required">
                    Period of Loan
                </label>
                <div class="input-group mb-3">
                    <input type="text" name="period_of_loan" id="period_of_loan"
                        class="form-control number_only">
                    <span class="input-group-text" id="basic-addon2">Months</span>
                </div>
            </div>
        </div>
        <div class="col-sm-4 mt-5">
            <div class="form-group">
                <label for="" class="">
                    Loan Documents
                </label>
                <div>
                    <input type="file" name="document" id="document">
                </div>
            </div>
        </div>
        <div class="col-sm-12 mt-5 float-end">
            <div class="form-group text-end">
                <button class="btn btn-sm btn-primary" type="button" onclick="return bankFormSubmit()"
                    id="submit_button"> Submit
                </button>
                <a class="btn btn-sm btn-dark" href="{{ route('salary.loan') }}"> Cancel </a>
            </div>
        </div>
    </div>
</form>