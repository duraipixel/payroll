<form action="" class="" id="dynamic_form">
    <input type="hidden" name="id" value="{{ $info->id ?? '' }}">
    <input type="hidden" name="form_type" id="form_type" value="{{ $from ?? '' }}">
    <div class="fv-row form-group mb-10">
        <label class="form-label required" for="">
            Department Name
        </label>
        <div >
            <input type="text" class="form-control" name="department_name" id="department_name" value="{{ $info->name ?? '' }}" required >
        </div>
    </div>
    <div class="fv-row form-group mb-10">
        <label class="form-label" for="">
            Is Teaching
        </label>
        <div >
            <div class="mx-5 cstm-zeed">

                <label class="form-check form-check-custom form-check-solid me-10">
                    <input class="form-check-input h-20px w-20px" type="radio" name="is_teaching" value="yes" @if ( isset($info->is_teaching) && $info->is_teaching == 'yes' ) checked @elseif(isset($info->is_teaching) && !empty($info->is_teaching)) @else checked @endif />
                    <span class="form-check-label fw-bold">Yes</span>
                </label>
                <label class="form-check form-check-custom form-check-solid me-10">
                    <input class="form-check-input h-20px w-20px" type="radio" name="is_teaching" value="no" @if ( isset($info->is_teaching) && $info->is_teaching == 'no' ) checked @endif />
                    <span class="form-check-label fw-bold"> No </span>
                </label>

            </div>
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
var KTAppEcommerceSaveDepartment = function () {

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
                    'department_name': {
						validators: {
							notEmpty: {
								message: 'Department Name is required'
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
                            url:"{{ route('save.department') }}",
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
                                    toastr.success("Department added successfully");
                                    $('#kt_dynamic_app').modal('hide');
                                    if (from) {
                                            dtTable.draw();
                                        } else {
                                    if( res.inserted_data ) {
                                        $('#department_id').append(`<option value="${res.inserted_data.id}">${res.inserted_data.name}</option>`)
                                        $('#department_id').val(res.inserted_data.id).trigger('change');
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
    KTAppEcommerceSaveDepartment.init();
});
    
    
</script>