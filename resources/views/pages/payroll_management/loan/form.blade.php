<form id="bank_loan_form" enctype="multipart/form-data">
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <input type="hidden" name="staff_id" id="emp_staff_id" value="{{ $id ?? ($loan_info->staff_id ?? '') }}">
                <input type="hidden" name="id" id="id" value="{{ $loan_info->id ?? '' }}">
                <label for="" class="required">Bank</label>
                <select name="bank_id" id="bank_id" class="form-control">
                    <option value="">--select bank--</option>
                    @isset($bank)
                        @foreach ($bank as $item)
                            <option value="{{ $item->id }}" @if (isset($loan_info->bank_id) && $loan_info->bank_id == $item->id) selected @endif>
                                {{ $item->name }}</option>
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
                <input type="text" name="account_no" id="account_no" value="{{ $loan_info->loan_ac_no ?? '' }}"
                    class="form-control">
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label for="" class="required">
                    IFSC Code
                </label>
                <input type="text" name="ifsc_code" id="ifsc_code" value="{{ $loan_info->ifsc_code ?? '' }}"
                    class="form-control">
            </div>
        </div>
        <div class="col-sm-4 mt-5">
            <div class="form-group">
                <label for="" class="required">
                    Loan Type
                </label>
                <select name="loan_type" id="loan_type" class="form-control">
                    <option value="">--select--</option>
                    <option value="fixed" @if (isset($loan_info->loan_due) && $loan_info->loan_due == 'fixed') selected @endif>Fixed</option>
                    <option value="variable" @if (isset($loan_info->loan_due) && $loan_info->loan_due == 'variable') selected @endif>Variable</option>
                </select>
            </div>
        </div>
        <div class="col-sm-4 mt-5">
            <div class="form-group">
                <label for="" class="required">
                    Amount
                </label>
                <input type="text" name="amount" id="amount" value="{{ $loan_info->every_month_amount ?? '' }}"
                    class="form-control price">
            </div>
        </div>
        <div class="col-sm-4 mt-5">
            <div class="form-group">
                <label for="" class="required">
                    Period of Loan
                </label>
                <div class="input-group mb-3">
                    <input type="text" name="period_of_loan" id="period_of_loan"
                        value="{{ $loan_info->period_of_loans ?? '' }}" class="form-control number_only">
                    <span class="input-group-text" id="basic-addon2">Months</span>
                </div>
            </div>
        </div>
        <div class="col-sm-4 mt-5">
            <div class="form-group">
                <label for="" class="">
                    Loan Start Date
                </label>
                <div>
                    <input type="date" name="loan_start_date" id="loan_start_date"
                        value="{{ $loan_info->loan_start_date ?? '' }}" class="form-control">
                </div>
            </div>
        </div>
        <div class="col-sm-4 mt-5">
            <div class="form-group">
                <label for="" class="">
                    Loan End Date
                </label>
                <div>
                    <input type="date" name="loan_end_date" id="loan_end_date"
                        value="{{ $loan_info->loan_end_date ?? '' }}" class="form-control">
                </div>
            </div>
        </div>
        <div class="col-sm-4 mt-5">
            <div class="form-group">
                <label for="" class="">
                    Loan Documents
                </label>
                <div>
                    <input class="mt-3" type="file" name="document" id="document">
                    @if (isset($loan_info->file) && !empty($loan_info->file))
                        {{-- <a href="{{ asset(Storage::url($loan_info->file)) }}" class="" target="_blank"> Download File </a> --}}
                        <a href="{{ asset('public' . Storage::url($loan_info->file)) }}" class="" target="_blank">
                            View File </a>
                    @else
                        <a href="javascript:void(0)"> No File Uploaded </a>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-sm-12 mt-5 float-end">
            <div class="form-group text-end">
                <button class="btn btn-sm btn-primary" type="button" onclick="return bankFormSubmit()"
                    id="submit_button" value="save"> Submit
                </button>
                <a class="btn btn-sm btn-dark" href="{{ route('salary.loan') }}"> Cancel </a>
            </div>
        </div>
    </div>
</form>
<script>
    function bankFormSubmit() {

        var form = document.getElementById('bank_loan_form');
        const submitButton = document.getElementById('submit_button');

        var form = document.getElementById("bank_loan_form");
        const submitter = document.querySelector("button[value=save]");

        event.preventDefault();
        var bank_form_error = false;

        var key_name = [
            'bank_id',
            'account_no',
            'ifsc_code',
            'loan_type',
            'amount',
            'period_of_loan'
        ];

        $('.kyc-form-errors').remove();
        $('.form-control,.form-select').removeClass('border-danger');

        const pattern = /_/gi;
        const replacement = " ";

        key_name.forEach(element => {
            var name_input = document.getElementById(element).value;

            if (name_input == '' || name_input == undefined) {

                bank_form_error = true;
                var elementValues = element.replace(pattern, replacement);
                var name_input_error =
                    '<div class="fv-plugins-message-container kyc-form-errors invalid-feedback"><div data-validator="notEmpty">' +
                    elementValues.toUpperCase() + ' is required</div></div>';
                // $('#' + element).after(name_input_error);
                $('#' + element).addClass('border-danger')
                $('#' + element).focus();
            }
        });

        if (!bank_form_error) {
            submitButton.disabled = true;
            var formData = new FormData();
            formData.append('staff_id', $('#staff_id').val());
            formData.append('bank_id', $('#bank_id').val());
            formData.append('id', $('#id').val());
            formData.append('account_no', $('#account_no').val());
            formData.append('ifsc_code', $('#ifsc_code').val());
            formData.append('loan_type', $('#loan_type').val());
            formData.append('amount', $('#amount').val());
            formData.append('period_of_loan', $('#period_of_loan').val());
            formData.append('loan_start_date', $('#loan_start_date').val());
            formData.append('loan_end_date', $('#loan_end_date').val());
            formData.append('document', $('input[type=file]')[0].files[0]);

            $.ajax({
                url: "{{ route('save.loan') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                success: function(res) {
                    // Disable submit button whilst loading
                    submitButton.disabled = false;

                    if (res.error == 1) {
                        if (res.message) {
                            res.message.forEach(element => {
                                toastr.error("Error",
                                    element);
                            });
                        }
                    } else {
                        toastr.success(
                            "Bank Loan added successfully"
                        );
                        if (res.staff_id) {
                            getSalaryBankLoans(res.staff_id);
                        }

                    }
                }
            })

        }

    }
</script>
