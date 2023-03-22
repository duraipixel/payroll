<form action="" class="" id="dynamic_form">
   
    <div class="fv-row form-group mb-10">
        <label class="form-label required" for="">
            Relationship Name
        </label>
        <div>
            <input type="text" class="form-control" name="relationship_name" id="relationship_name" required >
        </div>
    </div>
   
    <div class="form-group mb-10">
       
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

var KTAppEcommerceSavePlace = function () {

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
                    'relationship_name': {
						validators: {
							notEmpty: {
								message: 'Relationship Name is required'
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

                    if (status == 'Valid') {

                        var forms = $('#dynamic_form')[0];
                        var formData = new FormData(forms);
                        $.ajax({
                            url:"{{ route('save.relationship') }}",
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
                                    toastr.success("Relationship added successfully");
                                    if( res.inserted_data ) {
                                        $('#kt_dynamic_app').modal('hide');
                                        $('#staff_relationship_id').append(`<option value="${res.inserted_data.id}">${res.inserted_data.name}</option>`)
                                        $('#staff_relationship_id').val(res.inserted_data.id).trigger('change');
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
    KTAppEcommerceSavePlace.init();
});
    
    
</script>