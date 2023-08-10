<form id="staff_bank_loan_form" enctype="multipart/form-data">
    <div class="row">
        <div class="col-sm-8">
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <input type="hidden" name="staff_id" id="emp_staff_id"
                            value="{{ $id ?? ($loan_info->staff_id ?? '') }}">
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
                        <input type="text" name="account_no" id="account_no"
                            value="{{ $loan_info->loan_ac_no ?? '' }}" class="form-control">
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
                            Loan Amount
                        </label>
                        <input type="text" name="amount" onkeyup="getEmiDetails()" id="amount"
                            value="{{ $loan_info->loan_amount ?? '' }}" class="form-control price">
                    </div>
                </div>
                <div class="col-sm-4 mt-5">
                    <div class="form-group">
                        <label for="" class="required">
                            Every Month Pay Amount
                        </label>
                        <input type="text" name="every_month_amount" onkeyup="getEmiDetails()"
                            id="every_month_amount" value="{{ $loan_info->every_month_amount ?? '' }}"
                            class="form-control price">
                    </div>
                </div>
                <div class="col-sm-4 mt-5">
                    <div class="form-group">
                        <label for="" class="required">
                            Period of Loan
                        </label>
                        <div class="input-group mb-3">
                            <input type="text" onkeyup="getEmiDetails()" name="period_of_loan" id="period_of_loan"
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
                                <a href="{{ asset('public' . Storage::url($loan_info->file)) }}" class=""
                                    target="_blank">
                                    View File </a>
                            @else
                                <a href="javascript:void(0)"> No File Uploaded </a>
                            @endif
                        </div>
                    </div>
                </div>


            </div>
        </div>
        <div class="col-sm-4">
            <div class="accordion" id="accordionPanelsStayOpenExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#panelsStayOpen-collapseEmi" aria-expanded="true"
                            aria-controls="panelsStayOpen-collapseEmi">
                            Emi Details
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapseEmi" class="accordion-collapse collapse show"
                        aria-labelledby="panelsStayOpen-headingOne">
                        <div class="accordion-body" id="emi_loan_content">
                            @if (isset($loan_info->loan_due) && $loan_info->loan_due == 'fixed')
                                @include('pages.payroll_management.loan._emi')
                            @else
                                @include('pages.payroll_management.loan._emi_variable')
                            @endif
                        </div>
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
    </div>
</form>
<script>
    function bankFormSubmit() {

        var form = document.getElementById('staff_bank_loan_form');
        const submitButton = document.getElementById('submit_button');

        var form = document.getElementById("staff_bank_loan_form");
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

            var form_in = document.getElementById('staff_bank_loan_form');
            if (form_in instanceof HTMLFormElement) {
                var formData = new FormData(form_in);

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
            } else {
                console.log('Form element is not valid:', form_in);

            }

        }

    }

    $('#loan_start_date').change(function() {

        var period_of_loan = $('#period_of_loan').val();
        var loan_type = $('#loan_type').val();
        if (period_of_loan == '' || period_of_loan == 'undefined') {
            toastr.error('Error', 'Please select Period of loan first');
            $('#loan_start_date').val('');
            return false;
        }
        if (loan_type == '' || loan_type == 'undefined') {
            toastr.error('Error', 'Please select Loan type');
            $('#loan_start_date').val('');
            return false;
        }

        getEmiDetails()

    })

    function getEmiDetails() {
        var period_of_loan = $('#period_of_loan').val();
        var loan_start_date = $('#loan_start_date').val();
        var amount = $('#every_month_amount').val();
        var loan_type = $('#loan_type').val();

        if (period_of_loan != '' && loan_start_date != '' && amount != '') {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('emi.loan') }}",
                type: 'POST',
                data: {
                    period_of_loan: period_of_loan,
                    loan_start_date: loan_start_date,
                    amount: amount,
                    loan_type: loan_type
                },
                beforeSend: function(){
                    $('#emi_loan_content').addClass('blur-loading');
                },
                success: function(res) {
                    $('#emi_loan_content').removeClass('blur-loading');
                    $('#emi_loan_content').html(res);
                }
            })
        }
    }
</script>
