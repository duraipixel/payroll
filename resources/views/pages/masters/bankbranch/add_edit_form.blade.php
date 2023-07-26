<form action="" class="" id="dynamic_form">
   
    <div class="fv-row form-group mb-10">
        <label class="form-label required" for="">
            Bank
        </label>
        <div >
            <input type="text" class="form-control" name="bank_name" id="bank_name" value="{{ $banks->name }}" readonly >
            <input type="hidden" name="bank_id" id="bank_id" value="{{ $banks->id }}">
        </div>
    </div>
   
    <div class="fv-row form-group mb-10">
        <label class="form-label required" for="">
            Branch 
        </label>
        <div >
            <input type="text" class="form-control" name="name" id="name" >
        </div>
    </div>
    <div class="fv-row form-group mb-10">
        <label class="form-label" for="">
            IFSC Code
        </label>
        <div >
            <input type="text" class="form-control" name="ifsc_code" id="ifsc_code" >
        </div>
    </div>
    <div class="form-group mb-10">
        <label class="form-label" for="">
            Address
        </label>
        <div >
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

var KTAppEcommerceSaveBranch = function () {

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
                    'name': {
						validators: {
							notEmpty: {
								message: 'Branch Name is required'
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
                            url:"{{ route('save.bank-branch') }}",
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
                                    toastr.success("Bank Branch added successfully");
                                    if( res.inserted_data ) {
                                        $('#kt_dynamic_app').modal('hide');
                                        var option = '';
                                        res.branch_data.forEach(element => {
                                            let selected = '';
                                            if( res.inserted_data.id == element.id ) {
                                                selected = 'selected';
                                            }
                                            option += `<option value="${element.id}" ${selected}>${element.name}</option>`;
                                        });
                                        $('#branch_id').html(option);
                                        
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
    KTAppEcommerceSaveBranch.init();
});
    
    
</script>