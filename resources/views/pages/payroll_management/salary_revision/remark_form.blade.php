<form class="" id="dynamic_form">
    @csrf
    {{-- <input type="hidden" name="revision[]" value="<?php print_r($revision ?? ''); ?>"> --}}
    <input type="hidden" name="status" value="{{ $status ?? '' }}">
    <input type="hidden" name="revision_status" value="{{ $revision_status ?? '' }}">

    <div class="row form-group ">
        <div class="col-md-12">
            <label class="form-label required" for="">
                Remarks
            </label>
            <div>
                <textarea name="remarks" id="remarks" class="form-control" cols="10" rows="4"></textarea>
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
    var KTAppEcommerceSaveHoliday = function() {

        const handleSubmit = () => {
            // Define variables
            let validator;
            // Get elements
            const form = document.getElementById('dynamic_form');
            const submitButton = document.getElementById('form-submit-btn');

            validator = FormValidation.formValidation(
                form, {
                    fields: {
                        'remarks': {
                            validators: {
                                notEmpty: {
                                    message: 'Remarks is required'
                                },
                            }
                        },
                    },
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
                        bootstrap: new FormValidation.plugins.Bootstrap5({
                            // rowSelector: '.fv-row',
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
                            var list = $("input[name='revision[]']:checked").map(function() {
                                return this.value;
                            }).get();
                            var formData = new FormData(forms);
                            formData.append('revision', list);
                            $.ajax({
                                url: "{{ route('salary.revision.status.change') }}",
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
                                            toastr.error("Error",
                                            res.message);
                                           
                                        }
                                    } else {
                                        toastr.success(res.message);
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
        KTAppEcommerceSaveHoliday.init();
    });
</script>
