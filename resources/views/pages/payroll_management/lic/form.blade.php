<form id="lic_form" enctype="multipart/form-data">
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <input type="hidden" name="staff_id" id="staff_id" value="{{ $id ?? ($info->staff_id ?? '') }}">
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
                <input type="date" name="policy_date" id="policy_date" value="{{ $info->maturity_date ?? '' }}"
                    class="form-control">
            </div>
        </div>

        <div class="col-sm-4 mt-5">
            <div class="form-group">
                <label for="" class="required">
                    Amount
                </label>
                <input type="text" name="amount" value="{{ $info->amount ?? '' }}" id="amount"
                    class="form-control price">
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
                        <a href="{{ asset('public' . Storage::url($info->file)) }}" class="" target="_blank">
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
</form>
<script>
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



            var formData = new FormData();
            formData.append('staff_id', $('#staff_id').val());
            formData.append('id', $('#id').val());
            formData.append('insurance_name', $('#insurance_name').val());
            formData.append('policy_no', $('#policy_no').val());
            formData.append('policy_date', $('#policy_date').val());
            formData.append('amount', $('#amount').val());
            formData.append('document', $('input[type=file]')[0].files[0]);

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
