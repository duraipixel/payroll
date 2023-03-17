<form id="dynamic_form">
    @csrf
    <div class="fv-row form-group mb-10">
        <label class="form-label required" for="">
            Society
        </label>
        <div>
            <select name="society_id" id="society_id" class="form-control" required>
                <option value="">--select--</option>
                @isset($society)
                    @foreach ($society as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                @endisset
            </select>
        </div>
    </div>
    <div class="fv-row form-group mb-10">
        <label class="form-label required" for="">
            Institute Name
        </label>
        <div>
            <input type="text" class="form-control" name="institute_name" id="institute_name" required>
        </div>
    </div>
    <div class="fv-row form-group mb-10">
        <label class="form-label required" for="">
            Institute Code
        </label>
        <div>
            <input type="text" class="form-control" name="institute_code" id="institute_code" required>
        </div>
    </div>
    <div class="form-group mb-10">
        <label class="form-label" for="">
            Institute Address
        </label>
        <div>
            <textarea class="form-control" name="address" id="address"></textarea>
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
    var KTAppEcommerceSaveInstitute = function() {

        const handleSubmit = () => {
            // Define variables
            let validator;
            // Get elements
            const form = document.getElementById('dynamic_form');
            const submitButton = document.getElementById('form-submit-btn');

            validator = FormValidation.formValidation(
                form, {
                    fields: {
                        'society_id': {
                            validators: {
                                notEmpty: {
                                    message: 'Society is required'
                                },
                            }
                        },
                        'institute_name': {
                            validators: {
                                notEmpty: {
                                    message: 'Institute Name is required'
                                }
                            }
                        },
                        'institute_code': {
                            validators: {
                                notEmpty: {
                                    message: 'Institute Code is required'
                                }
                            }
                        }
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
                submitButton.disabled = true;
                submitButton.setAttribute('data-kt-indicator', 'on');

                // Validate form before submit
                if (validator) {
                    validator.validate().then(function(status) {


                        if (status == 'Valid') {
                            var forms = $('#dynamic_form')[0];
                            var formData = new FormData(forms);
                            $.ajax({
                                url:"{{ route('save.institute') }}",
                                type:"POST",
                                data: formData,
                                processData: false,
                                contentType: false,
                                success: function(res) {
                                    // Disable submit button whilst loading
                                    
                                    submitButton.disabled = false;
                                    submitButton.removeAttribute('data-kt-indicator');
                                    if( res.error == 1 ) {
                                        if( res.message ) {
                                            res.message.forEach(element => {
                                                toastr.error("Error", element);
                                            });
                                        }
                                    } else{
                                        toastr.success("Institution added successfully");
                                        if( res.inserted_data ) {
                                            $('#kt_dynamic_app').modal('hide');
                                            
                                            $('#institute_name').append(`<option value="${res.inserted_data.id}">${res.inserted_data.name}</option>`)
                                            $('#institute_name').val(res.inserted_data.id)

                                            if( res.code ) {
                                                $('#institute_code').val(res.code);
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
        KTAppEcommerceSaveInstitute.init();
    });
</script>
