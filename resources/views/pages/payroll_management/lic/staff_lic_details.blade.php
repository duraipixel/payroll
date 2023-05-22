<div class="accordion" id="accordionPanelsStayOpenExample">
    <div class="accordion-item">
        <h2 class="accordion-header" id="panelsStayOpen-headingOne">
            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true"
                aria-controls="panelsStayOpen-collapseOne">
                Add Insurance
            </button>
        </h2>
        <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show"
            aria-labelledby="panelsStayOpen-headingOne">
            <div class="accordion-body">
                @include('pages.payroll_management.lic.form')
            </div>
        </div>
    </div>

</div>
<div id="kt_table_users_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer mt-5">
    <div class="table-responsive">
        <table class="table align-middle text-center table-hover table-bordered table-striped fs-7 no-footer"
            id="salary_head_table">
            <thead class="bg-primary">
                <tr class="text-start text-center text-muted fw-bolder fs-7 text-uppercase gs-0">
                    <th class="text-center text-white">
                        Insurance Company
                    </th>
                    <th class="text-center text-white">
                        Policy No
                    </th>
                    <th class="text-center text-white">
                        Maturity Date
                    </th>
                    <th class="text-center text-white">
                        Amount
                    </th>
                    <th class="text-center text-white">
                        Status
                    </th>
                    <th class="text-center text-white">
                        Actions
                    </th>
                </tr>
            </thead>

            <tbody class="text-gray-600 fw-bold">
            </tbody>
        </table>
    </div>

</div>
<script>
    $(".number_only").keypress(function(e) {
        if (String.fromCharCode(e.keyCode).match(/[^0-9]/g)) return false;
    });

    $(".price").keypress(function(e) {
        if (String.fromCharCode(e.keyCode).match(/[^.0-9]/g)) return false;
    });

    function licFormSubmit() {

        var form = document.getElementById('lic_form');
        const submitButton = document.getElementById('submit_button');

        event.preventDefault();
        var bank_form_error = false;

        var key_name = [
            'insurance_name',
            'policy_no',
            'policy_date',
            'amount',
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

            var forms = $('#lic_form')[0];
            // var formData = new FormData($('#lic_form')[0]);
            const formdata = new FormData(document.querySelector("form"));
            $.ajax({
                url: "{{ route('save.loan') }}",
                type: "POST",
                data: formdata,
                processData: false,
                contentType: false,
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
                            "Bank Loan added added successfully"
                        );
                        dtTable.draw();

                    }
                }
            })

        }

    }





    $('#staff_id').select2();
</script>
