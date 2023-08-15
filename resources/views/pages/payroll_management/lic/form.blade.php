<form id="staff_lic_form" enctype="multipart/form-data">
    <div class="row">
        <div class="col-sm-8">

            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <input type="hidden" name="staff_id" id="emp_staff_id"
                            value="{{ $info->staff_id ?? '' }}">
                        <input type="hidden" name="id" id="id" value="{{ $info->id ?? '' }}">
                        <label for="" class="required">Insurance Company</label>
                        <input type="text" name="insurance_name" id="insurance_name"
                            value="{{ $info->insurance_name ?? '' }}" class="form-control">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="" class="required">
                            Policy No
                        </label>
                        <input type="text" name="policy_no" id="policy_no" value="{{ $info->policy_no ?? '' }}"
                            class="form-control">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="" class="required">
                            Policy Maturity Date
                        </label>
                        <input type="date" name="policy_date" id="policy_date"
                            value="{{ $info->maturity_date ?? '' }}" class="form-control">
                    </div>
                </div>
                <div class="col-sm-4 mt-5">
                    <div class="form-group">
                        <label for="" class="required">
                            Insurance Type
                        </label>
                        <select name="insurance_due_type" id="insurance_due_type" class="form-control">
                            <option value="">--select--</option>
                            <option value="fixed" @if (isset($info->insurance_due_type) && $info->insurance_due_type == 'fixed') selected @endif>Fixed</option>
                            <option value="variable" @if (isset($info->insurance_due_type) && $info->insurance_due_type == 'variable') selected @endif>Variable</option>
                        </select>
                    </div>
                </div>

                <div class="col-sm-4 mt-5">
                    <div class="form-group">
                        <label for="" class="required">
                            Total Amount
                        </label>
                        <input type="text" name="amount" value="{{ $info->amount ?? '' }}" id="amount"
                            class="form-control price">
                    </div>
                </div>
                <div class="col-sm-4 mt-5">
                    <div class="form-group">
                        <label for="" class="required">
                            Monthly Pay Amount
                        </label>
                        <input type="text" name="every_month_amount" onkeyup="getEmiDetails()"
                            id="every_month_amount" value="{{ $info->every_month_amount ?? '' }}"
                            class="form-control price">
                    </div>
                </div>
                <div class="col-sm-4 mt-5">
                    <div class="form-group">
                        <label for="" class="required">
                            Periods in Month
                        </label>
                        <div class="input-group mb-3">
                            <input type="text" onkeyup="getEmiDetails()" name="period_of_loans" id="period_of_loans"
                                value="{{ $info->period_of_loans ?? '' }}" class="form-control number_only">
                            <span class="input-group-text" id="basic-addon2">Months</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 mt-5">
                    <div class="form-group">
                        <label for="" class="">
                            Insurance Start Date
                        </label>
                        <div>
                            <input type="date" name="start_date" id="start_date"
                                value="{{ $info->start_date ?? '' }}" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 mt-5">
                    <div class="form-group">
                        <label for="" class="">
                            Insurance End Date
                        </label>
                        <div>
                            <input type="date" name="end_date" id="end_date"
                                value="{{ $info->end_date ?? '' }}" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="col-sm-4 mt-5">
                    <div class="form-group">
                        <label for="" class="">
                            Documents
                        </label>
                        <div>
                            <input type="file" name="document" id="document">
                            @if (isset($info->file) && !empty($info->file))
                                {{-- <a href="{{ asset(Storage::url($info->file)) }}" class="" target="_blank"> Download File </a> --}}
                                <a href="{{ asset('public' . Storage::url($info->file)) }}" class=""
                                    target="_blank">
                                    View File </a>
                            @else
                                <a href="javascript:void(0)"> No File Uploaded </a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 mt-5 float-end">
                    <div class="form-group text-end">
                        <button class="btn btn-sm btn-primary" type="button" onclick="return licFormSubmit()"
                            id="submit_button"> Submit
                        </button>
                        <a class="btn btn-sm btn-dark" href="{{ route('salary.lic') }}"> Cancel </a>
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
                            @if (isset($info->insurance_due_type) && $info->insurance_due_type == 'fixed')
                                @include('pages.payroll_management.lic._emi')
                            @else
                                @include('pages.payroll_management.lic._emi_variable')
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    $('#start_date').change(function() {

        var period_of_loans = $('#period_of_loans').val();
        var loan_type = $('#insurance_due_type').val();
        if (period_of_loans == '' || period_of_loans == 'undefined') {
            toastr.error('Error', 'Please select Periods in Month first');
            $('#start_date').val('');
            return false;
        }
        if (loan_type == '' || loan_type == 'undefined') {
            toastr.error('Error', 'Please select Insurance type');
            $('#start_date').val('');
            return false;
        }

        getEmiDetails()

    })

    function getEmiDetails() {
        var period_of_loan = $('#period_of_loans').val();
        var start_date = $('#start_date').val();
        var amount = $('#every_month_amount').val();
        var loan_type = $('#insurance_due_type').val();

        if (period_of_loan != '' && start_date != '' && amount != '') {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('emi.lic') }}",
                type: 'POST',
                data: {
                    period_of_loan: period_of_loan,
                    loan_start_date: start_date,
                    amount: amount,
                    loan_type: loan_type
                },
                beforeSend: function() {
                    $('#emi_loan_content').addClass('blur-loading');
                },
                success: function(res) {
                    $('#emi_loan_content').removeClass('blur-loading');
                    $('#emi_loan_content').html(res);
                }
            })
        }
    }

    function licFormSubmit() {

        var form = document.getElementById('staff_lic_form');
        const submitButton = document.getElementById('submit_button');

        event.preventDefault();
        var bank_form_error = false;

        var key_name = [
            'insurance_name',
            'policy_no',
            'policy_date',
            'amount',
            'period_of_loans',
            'every_month_amount',
            'insurance_due_type'
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

        // Validate form before submit
        console.log(bank_form_error, 'bank_form_error')
        if (!bank_form_error) {
            submitButton.disabled = true;

            var form_in = document.getElementById('staff_lic_form');
            var formData = new FormData(form_in);

            $.ajax({
                url: "{{ route('save.lic') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {

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
                            "Insurance added successfully"
                        );
                        getSalaryInsurance(res.staff_id)

                    }
                }
            })

        }

    }
</script>
