<div class="modal-dialog modal-dialog-centered ">

    <div class="modal-content">
        <div class="modal-header">
            <h2>{{ isset($title) ? ucwords(str_replace(['-', '_'], ' ', $title)) : 'Add Form' }}</h2>
            <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                {!! cancelSvg() !!}
            </div>
        </div>

        <div class="modal-body " id="">
            <form action="" class="p-3 toplevel_form" id="toplevel_form" autocomplete="off" enctype="multipart/form-data">
                <div class="fv-row form-group mb-3 row">
                    <div class="col-sm-5">
                        <label class="form-label required mt-1" for=""> Select Manager </label>
                    </div>
                    <div class="col-sm-7">
                        <select name="manager_id" id="manager_id" class="form-control select2-option">
                            @isset($managers)
                                @foreach ($managers as $item)
                                    <option value="{{ $item->id }}">{{ $item->name . ' - ' . $item->emp_code }}</option>
                                @endforeach
                            @endisset
                        </select>
                    </div>
                </div>

                <div class="form-group mt-7 text-end">
                    <button type="button" class="btn btn-light-primary" data-bs-dismiss="modal"> Cancel </button>
                    <button type="button" class="btn btn-primary" id="form-submit-btn">
                        <span class="indicator-label">
                            Assign
                        </span>
                        <span class="indicator-progress">
                            Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.select2-option').select2({ theme: 'bootstrap-5'});
    })

    var KTAppEcommerceSaveBranch = function() {

        const handleSubmit = () => {

            let validator;

            const form = document.getElementById('toplevel_form');
            const submitButton = document.getElementById('form-submit-btn');

            validator = FormValidation.formValidation(
                form, {
                    fields: {
                        'manager_id': {
                            validators: {
                                notEmpty: {
                                    message: 'Manager is required'
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
                            submitButton.disabled = true;
                            var forms = $('#toplevel_form')[0];
                            var formData = new FormData(forms);
                            $.ajax({
                                url: "{{ route('reporting.toplevel.assign') }}",
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
                                            "Top Level Assigned successfully");
                                        $('#kt_dynamic_app').modal('hide');
                                        location.reload();
                                        
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
        KTAppEcommerceSaveBranch.init();
    });
</script>
