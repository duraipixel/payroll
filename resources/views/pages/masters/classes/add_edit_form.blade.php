<form action="" class="" id="dynamic_form">
   
    <div class="fv-row form-group mb-10">
        <label class="form-label required" for="">
            Class Name
        </label>
        <div >
            <input type="text" class="form-control" name="class_name" id="class_name" required >
        </div>
    </div>
   
    <div class="form-group mb-10">
       
    </div>
    <div class="form-group mb-10 text-end">
        <button type="button" class="btn btn-light-primary"> Cancel </button>
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

var KTAppEcommerceSaveInstitute = function () {

    const handleSubmit = () => {
        // Define variables
        let validator;
        // Get elements
        const form = document.getElementById('dynamic_form');
        const submitButton = document.getElementById('form-submit-btn');

        validator = FormValidation.formValidation(
            form,
            {
                fields: {
                    'class_name': {
						validators: {
							notEmpty: {
								message: 'Class Name is required'
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
                validator.validate().then(function (status) {
                    console.log('validated!');

                    if (status == 'Valid') {

                        var forms = $('#dynamic_form')[0];
                        var formData = new FormData(forms);
                        $.ajax({
                            url:"{{ route('save.class') }}",
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
                                    toastr.success("Divisions added successfully");
                                    if( res.inserted_data ) {
                                        $('#kt_dynamic_app').modal('hide');
                                        $('#classes').append(`<option value="${res.inserted_data.id}">${res.inserted_data.name}</option>`)
                                        var classes = $('#classes').val();
                                        // var category = $('#classes').select2("val");
                                        classes.push(res.inserted_data.id.toString());

                                        console.log(classes, 'classes');
                                        $('#classes').val(classes).trigger('change');
                                        // console.log(category, 'category');
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
        init: function () {
            handleSubmit();
        }
    };
}();

KTUtil.onDOMContentLoaded(function () {
    KTAppEcommerceSaveInstitute.init();
});
    
    
</script>