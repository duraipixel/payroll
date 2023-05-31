<form id="dynamic_form">

    <input type="hidden" name="id" value="{{ $info->id ?? '' }}">
    <input type="hidden" name="form_type" id="form_type" value="{{ $from ?? '' }}">
    <div class="fv-row form-group mb-10">
        <label class="form-label required" for="">
            Language
        </label>
        <div>
            <input type="text" class="form-control" name="language" id="language" value="{{ $info->name ?? '' }}"
                required>
        </div>
    </div>

    @if (isset($from) && !empty($from))
        <div class="fv-row form-group mb-10">
            <label class="form-label" for="">
                Status
            </label>
            <div>
                <input type="radio" id="active" class="form-check-input" value="1" name="status"
                    @if (isset($info->status) && $info->status == 'active') checked @elseif(!isset($info->status)) checked @endif>
                <label class="pe-3" for="active">Active</label>
                <input type="radio" id="inactive" class="form-check-input" value="0" name="status"
                    @if (isset($info->status) && $info->status != 'active') checked @endif>
                <label for="inactive">Inactive</label>
            </div>
        </div>
    @endif
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
    // $(document).ready(function() {
    //     $(window).keydown(function(event) {
    //         if (event.keyCode == 13) {
    //             event.preventDefault();
    //             return false;
    //         }
    //     });
    // });

    var fromData = '{{ $from ?? '' }}';
    var KTAppEcommerceSaveLanguage = function() {

        const handleSubmit = () => {
            // Define variables
            let validator;
            // Get elements
            const form = document.getElementById('dynamic_form');
            const submitButton = document.getElementById('form-submit-btn');

            validator = FormValidation.formValidation(
                form, {
                    fields: {
                        'language': {
                            validators: {
                                notEmpty: {
                                    message: 'Language is required'
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
                                url: "{{ route('save.language') }}",
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
                                            "Language added successfully");
                                        $('#kt_dynamic_app').modal('hide');
                                        if (fromData) {
                                            dtTable.draw();
                                        } else {
                                            if (res.inserted_data) {

                                                $('#language_id').append(
                                                    `<option value="${res.inserted_data.id}">${res.inserted_data.name}</option>`
                                                    )
                                                $('#language_id').val(res
                                                    .inserted_data.id).trigger(
                                                    'change');
                                            }
                                        }

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
        KTAppEcommerceSaveLanguage.init();
    });
</script>
