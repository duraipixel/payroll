<form action="" class="" id="dynamic_form">
    <input type="hidden" name="id" id="id" value="{{ $info->id ?? '' }}">
    <div class="row">
        <div class="col-sm-12">
            <div class="fv-row form-group mb-10">
                <label class="form-label required" for="">
                    Tax Scheme Name
                </label>
                <div>
                    <input type="text" class="form-control" name="scheme" value="{{ $info->name ?? '' }}"
                        id="scheme" required>
                </div>
            </div>

        </div>
        <div class="col-sm-6">
            <div class="fv-row form-group mb-10">
                <label class="form-label" for="">
                    Status
                </label>
                <div>
                    <input type="radio" id="active" class="form-check-input" value="active" name="status"
                        @if (isset($info->status) && $info->status == 'active') checked @elseif(!isset($info->status)) checked @endif>
                    <label class="pe-3" for="active">Active</label>
                    <input type="radio" id="inactive" class="form-check-input" value="inactive" name="status"
                        @if (isset($info->status) && $info->status != 'active') checked @endif>
                    <label for="inactive">Inactive</label>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="fv-row form-group mb-10">
                <label class="form-label" for="">
                    Is Current Scheme
                </label>
                <div>
                    <input type="radio" id="yes" class="form-check-input" value="yes" name="is_current"
                        @if (isset($info->is_current) && $info->is_current == 'yes') checked @elseif(!isset($info->is_current)) checked @endif>
                    <label class="pe-3" for="yes">Yes</label>
                    <input type="radio" id="no" class="form-check-input" value="no" name="is_current"
                        @if (isset($info->is_current) && $info->is_current == 'no') checked @endif>
                    <label for="no">No</label>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group mb-10 text-end">
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
    var KTAppEcommerceSaveReligion = function() {

        const handleSubmit = () => {
            // Define variables
            let validator;
            // Get elements
            const form = document.getElementById('dynamic_form');
            const submitButton = document.getElementById('form-submit-btn');

            validator = FormValidation.formValidation(
                form, {
                    fields: {
                        'scheme': {
                            validators: {
                                notEmpty: {
                                    message: 'Tax Scheme is required'
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

            // Handle submit button
            submitButton.addEventListener('click', e => {
                e.preventDefault();

                // Validate form before submit
                if (validator) {
                    validator.validate().then(function(status) {

                        if (status == 'Valid') {

                            var forms = $('#dynamic_form')[0];
                            var formData = new FormData(forms);
                            $.ajax({
                                url: "{{ route('taxscheme.save') }}",
                                type: "POST",
                                data: formData,
                                processData: false,
                                contentType: false,
                                success: function(res) {
                                    // Disable submit button whilst loading
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
                                        toastr.success(
                                            "Tax Schemes added successfully");
                                        $('#kt_dynamic_app').modal('hide');

                                        dtTable.draw();

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
        KTAppEcommerceSaveReligion.init();
    });
</script>
