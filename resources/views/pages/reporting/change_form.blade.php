<div class="modal-dialog modal-dialog-centered modal-lg">
    <style>
        .reportee-pane~.select2-option {
            z-index: 2085 !important;
        }
    </style>
    <div class="modal-content">
        <div class="modal-header">
            <h2>{{ isset($title) ? ucwords(str_replace(['-', '_'], ' ', $title)) : 'Add Form' }}</h2>
            <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                {!! cancelSvg() !!}
            </div>
        </div>

        <div class="modal-body " id="">
            <form action="" class="p-3" id="manager_form" autocomplete="off" enctype="multipart/form-data">
                <div class="fv-row form-group mb-3 row">
                    <div class="col-sm-5">
                        <label class="form-label required mt-1" for=""> Select Manager to change or replace
                        </label>
                    </div>
                    <div class="col-sm-7">
                        <select name="from_id" id="from_id" class="form-control reportee-pane form-control-sm w-100">
                            <option value=""> --select --</option>
                            @isset($reportee)
                                @foreach ($reportee as $ritem)
                                    <option value="{{ $ritem->manager_id }}">
                                        {{ $ritem->manager->name . ' - ' . $ritem->manager->emp_code }}</option>
                                @endforeach
                            @endisset
                        </select>
                    </div>
                </div>
                <div class="fv-row form-group mb-3 row">
                    <div class="col-sm-5">
                        <label class="form-label required mt-1" for=""> Select Manager to Take over </label>
                    </div>
                    <div class="col-sm-7">
                        <select name="to_id" id="to_id" class="form-control form-control-sm w-100">
                            <option value=""> --select --</option>
                            @isset($reportee)
                                @foreach ($reportee as $ritem)
                                    <option value="{{ $ritem->manager_id }}">
                                        {{ $ritem->manager->name . ' - ' . $ritem->manager->emp_code }}</option>
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
        $('.select2-option').select2({
            theme: 'bootstrap-5'
        });
    })

    var KTAppEcommerceSaveBranch = function() {

        const handleSubmit = () => {

            let validator;

            const form = document.getElementById('manager_form');
            const submitButton = document.getElementById('form-submit-btn');

            validator = FormValidation.formValidation(
                form, {
                    fields: {
                        'from_id': {
                            validators: {
                                notEmpty: {
                                    message: 'Change Manager is required'
                                },
                            }
                        },
                        'to_id': {
                            validators: {
                                notEmpty: {
                                    message: 'Take over Manager is required'
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
                            var forms = $('#manager_form')[0];
                            var formData = new FormData(forms);
                            $.ajax({
                                url: "{{ route('reporting.manager.change') }}",
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
                                        toastr.error('Error', res.message);
                                    } else {
                                        toastr.success('success', res.message);
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
    $('.form-select-option').select2({
        dropdownParent: $('#kt_dynamic_app'),
        theme: 'bootstrap-5',
        width: '100%'
    });
</script>
