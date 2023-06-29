<form action="" class="" id="dynamic_form">
    <input type="hidden" name="id" value="{{ $info->id ?? '' }}">
    <input type="hidden" name="staff_id" id="staff_id" value="{{ $staff_id ?? '' }}">
    <div class="fv-row form-group mb-10">
        <div class="row">
            <div class="col-sm-6">
                <label class="form-label required" for="">
                    Rent Amount
                </label>
                <div>
                    <input type="text" class="form-control price" name="amount" id="amount"
                        value="{{ $info->amount ?? '' }}" onkeyup="getAnnumAmount(this.value)" required>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="fv-row form-group mb-10">
                    <label class="form-label required" for="">
                        Annual Rent Amount
                    </label>
                    <div>
                        <input type="text" class="form-control price" name="annual_rent" id="annual_rent"
                            value="{{ $info->annual_rent ?? '' }}" readonly>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="fv-row form-group mb-10">
                    <label class="form-label" for="">
                        Rent Receipt
                    </label>
                    <div>
                        <input type="file" class="form-control" name="document" id="document">
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="fv-row form-group mb-10">
                    <label class="form-label" for="">
                        Remarks
                    </label>
                    <div>
                        <textarea name="remarks" id="remarks" class="form-control" cols="30" rows="3"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>   
    
    <div class="form-group mb-3 text-end">
        <button type="button" class="btn btn-light-primary" data-bs-dismiss="modal"> Cancel </button>
        <button type="button" class="btn btn-primary" id="form-submit-btn">
            <span class="indicator-label">
                Submit
            </span>
            <span class="indicator-progress">
                Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
            </span>
        </button>
    </div>
</form>

<script>
    function getAnnumAmount(amount) {
        let rent = parseFloat(amount || 0);
        if( rent ) {
            $('#annual_rent').val(rent*12);
        }
    }

    $(".price").keypress(function(e) {
        if (String.fromCharCode(e.keyCode).match(/[^.0-9]/g)) return false;
    });

    var KTAppEcommerceSavePlace = function() {

        const handleSubmit = () => {

            let validator;

            const form = document.getElementById('dynamic_form');
            const submitButton = document.getElementById('form-submit-btn');

            validator = FormValidation.formValidation(
                form, {
                    fields: {
                        'amount': {
                            validators: {
                                notEmpty: {
                                    message: 'Rent amount is required'
                                },
                            }
                        },
                    },
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
                        bootstrap: new FormValidation.plugins.Bootstrap5({
                            rowSelector: '.fv-row',
                            eleInvalidClass: '',
                            eleValidClass: ''
                        })
                    }
                }
            );

            submitButton.addEventListener('click', e => {
                e.preventDefault();

                if (validator) {
                    validator.validate().then(function(status) {

                        if (status == 'Valid') {

                            var forms = $('#dynamic_form')[0];
                            var formData = new FormData(forms);
                            $.ajax({
                                url: "{{ route('staff.rent.save') }}",
                                type: "POST",
                                data: formData,
                                processData: false,
                                contentType: false,
                                success: function(res) {

                                    submitButton.disabled = false;
                                    submitButton.removeAttribute(
                                        'data-kt-indicator');
                                    if (res.error == 1) {
                                        if (res.message) {
                                            res.message.forEach(element => {
                                                toastr.error("Error",
                                                    element);
                                            });
                                        }
                                    } else {
                                        toastr.success("Rent added successfully");
                                        $('#kt_dynamic_app').modal('hide');
                                        staffRentList();
                                    }
                                }
                            })

                        }
                    });
                }
            })
        }

        return {
            init: function() {
                handleSubmit();
            }
        };
    }();

    KTUtil.onDOMContentLoaded(function() {
        KTAppEcommerceSavePlace.init();
    });
</script>
