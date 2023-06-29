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
        <form id="it_statement_form">
            <div class="row">
                <div class="col-sm-9">
                    @if (isset($statement_info) && !empty($statement_info))
                        @include('pages.payroll_management.it_calculation._calc_update_form')
                    @else
                        @include('pages.payroll_management.it_calculation._calc_add_form')
                    @endif
                    <div class="row">
                        <div class="col-sm-12 mt-3 text-end">
                            @if (isset($statement_info) && !empty($statement_info))
                                @php
                                    $file_path = 'public/it/statement/' . $info->staff->society_emp_code . '/' . $info->document;
                                    $file_path = Storage::url($file_path);
                                @endphp
                                <a href="{{ asset('public'.$file_path) }}" target="_blank" class="btn btn-info btn-sm"
                                    onclick="return previewStatement()">
                                    <i class="fa fa-file-pdf"></i> Preview
                                </a>
                            @else
                                <button type="button" class="btn btn-success btn-sm"
                                    onclick="return submitTaxCalculation()"> Submit Calculation </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </form>
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

        total_year_salary_income = total_year_salary_income - parseFloat(total_deduction_amount);
        $('#taxable_gross_income').val(total_year_salary_income);
        // get tax slab amount and rebat, edu chess
        getTaxAmount(total_year_salary_income);
    }

    function getTaxAmount(total_year_salary_income) {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('it-calculation.calculation.ajax') }}",
            type: 'POST',
            data: {
                total_year_salary_income: total_year_salary_income
            },
            success: function(res) {

                if (res.round_total) {
                    $('#round_off_taxable_gross_income').val(res.round_total);
                }
                if (res.tax_amount) {
                    $('#tax_on_taxable_gross_income').val(res.tax_amount);
                }
                if (res.tax_after_rebate_amount) {
                    $('#tax_after_rebate_amount').val(res.tax_after_rebate_amount);
                }
                if (res.educational_cess_tax_payable) {
                    $('#educational_cess_tax_payable').val(res.educational_cess_tax_payable);
                }
                if (res.total_income_tax_payable) {
                    $('#total_income_tax_payable').val(res.total_income_tax_payable);
                }
            }
        })
    }

    function submitTaxCalculation() {

        Swal.fire({
            text: "Are you sure you would like to submit tax calculation?",
            icon: "warning",
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonText: "Yes, Change it!",
            cancelButtonText: "No, return",
            customClass: {
                confirmButton: "btn btn-danger",
                cancelButton: "btn btn-active-light"
            }
        }).then(function(result) {

            if (result.value) {
                var formData = $('#it_statement_form').serialize();
                var staff_id = $('#staff_id').val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('it-calculation.save.statement') }}",
                    type: 'POST',
                    data: formData + '&staff_id=' + staff_id,
                    beforeSend: function() {
                        $('#it_statement_form').addClass('blur_loading_3px');
                    },
                    success: function(res) {
                        $('#it_statement_form').removeClass('blur_loading_3px');
                        getStaffTaxCalculationPane(staff_id);
                    }
                })
            }

        });
    }
</script>
