<form action="" class="" id="dynamic_form">
    <input type="hidden" name="id" value="{{ $info->id ?? '' }}">
    <input type="hidden" name="form_type" id="form_type" value="{{ $from ?? '' }}">
    <div class="fv-row form-group mb-10">
        <label class="form-label required" for="">
            Bank Name
        </label>
        <div > 
            <input type="text" class="form-control" name="bank_name" value="{{ $info->name ?? '' }}" id="bank_name" required >
        </div>
    </div>
   
    <div class="form-group mb-10">
        <label class="form-label" for="">
            Bank Code
        </label>
        <div >
            <input type="text" class="form-control" name="code" value="{{ $info->bank_code ?? '' }}" id="code" >
        </div>
    </div>
    <div class="form-group mb-10">
        <label class="form-label" for="">
            Bank Short Name
        </label>
        <div >
            <input type="text" class="form-control" name="short_name" value="{{ $info->short_name ?? '' }}" id="short_name" >
        </div>
    </div>
    @if(isset($from) && !empty($from))
    <div class="fv-row form-group mb-10">
        <label class="form-label" for="">
            Status
        </label>
        <div >
            <input type="checkbox" class="form-check-input" value="1" name="status" @if(isset($info->status) && $info->status == 'active') checked  @endif >
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
    var from = '{{ $from ?? '' }}';

var KTAppEcommerceSaveReligion = function () {

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
                    'bank_name': {
						validators: {
							notEmpty: {
								message: 'Bank Name is required'
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
                            url:"{{ route('save.bank') }}",
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
                                    toastr.success("Bank added successfully");
                                    $('#kt_dynamic_app').modal('hide');

                                    if (from) {
                                            dtTable.draw();
                                        } else {
                                    if( res.inserted_data ) {
                                        $('#bank_id').append(`<option value="${res.inserted_data.id}">${res.inserted_data.name}</option>`)
                                        $('#bank_id').val(res.inserted_data.id).trigger('change');
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
        init: function () {
            handleSubmit();
        }
    };
}();

KTUtil.onDOMContentLoaded(function () {
    KTAppEcommerceSaveReligion.init();
});
    
    
</script>