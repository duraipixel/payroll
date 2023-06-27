<form action="" class="" id="dynamic_form">
    <input type="hidden" name="id" value="{{ $info->id ?? '' }}">
    <div class="fv-row form-group mb-10">
        <label class="form-label required" >
            Other Income Name
        </label>
        <div>
            <input type="text" class="form-control" name="name" id="name" value="{{ $info->name ?? '' }}"
                required>
        </div>
    </div>
    <div class="fv-row form-group mb-10">
        <label class="form-label" for="">
            Status
        </label>
        <div>
            <input type="radio" id="active" class="form-check-input" value="active" name="status"
                @if (isset($info->status) && $info->status == 'active') checked @elseif(!isset($info->status)) checked @endif>
            <label class="pe-3" for="active">Active</label>
            <input type="radio" id="inactive" class="form-check-input" value="inactive" name="status"
                @if (isset($info->status) && $info->status == 'inactive') checked @endif>
            <label for="inactive">Inactive</label>
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
    var KTAppEcommerceSaveSubject = function() {

        const handleSubmit = () => {
            
            let validator;
            
            const form = document.getElementById('dynamic_form');
            const submitButton = document.getElementById('form-submit-btn');

            validator = FormValidation.formValidation(
                form, {
                    fields: {
                        'name': {
                            validators: {
                                notEmpty: {
                                    message: 'Other Income Name is required'
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
                // Validate form before submit
                if (validator) {
                    validator.validate().then(function(status) {

                        if (status == 'Valid') {

                            var forms = $('#dynamic_form')[0];
                            var formData = new FormData(forms);
                            $.ajax({
                                url: "{{ route('other-income.save') }}",
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
                                        toastr.success(
                                            "Other Income added successfully");
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
        KTAppEcommerceSaveSubject.init();
    });
</script>
