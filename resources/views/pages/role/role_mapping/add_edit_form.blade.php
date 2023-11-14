<form action="" class="" id="dynamic_form">
    <input type="hidden" name="id" value="{{ $info->id ?? '' }}">
    <input type="hidden" name="form_type" id="form_type" value="{{ $from ?? '' }}">
    <div class="fv-row form-group mb-10">
        <label class="form-label required" for="">
            Select Staff
        </label>
        <div >
            <select name="staff_id" class="form-control" id="staff_id">
                <option value="">--Select Staff--</option>
                @foreach ($staff_details as $key=>$val)
                <option value="{{ $val->id }}" @if(isset($info->staff_id) && $info->staff_id == $val->id) selected @endif>{{ $val['name']  }}</option>
                @endforeach
            </select>
        </div>
    </div>
   
    <div class="fv-row form-group mb-10">
        <label class="form-label required" for="">
            Select Role 
        </label>
        <div >
            <select name="role_id" class="form-control" id="role_id">
                <option value="">--Select Role--</option>
                @foreach ($role as $key=>$role_val)
                <option value="{{ $role_val->id }}" @if(isset($info->role_id) && $info->role_id == $role_val->id) selected @endif>{{ $role_val['name']  }}</option>
                @endforeach
            </select>
        </div>
    </div>

    
    @if(isset($from) && !empty($from))
    <div class="fv-row form-group mb-10">
        <label class="form-label" for="">
            Status
        </label>
        <div >
            <input type="radio" id="active" class="form-check-input" value="1" name="status" @if(isset($info->status) && $info->status == 'active') checked @elseif(!isset($info->status)) checked @endif >
            <label class="pe-3" for="active">Active</label>
            <input type="radio" id="inactive" class="form-check-input" value="0" name="status" @if(isset($info->status) && $info->status != 'active') checked  @endif >
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
    var from = '{{ $from ?? '' }}';

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
                    'staff_id': {
						validators: {
							notEmpty: {
								message: 'Select Staff is Required'
							},
						}
					},
                    'role_id': {
						validators: {
							notEmpty: {
								message: 'Select Role is Required'
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
                            url:"{{ route('save.role-mapping') }}",
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
                                    $('#kt_dynamic_app').modal('hide');
                                    if (from) {
                                            dtTable.draw();
                                        } else {
                                    if( res.inserted_data ) {
                                       
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
$('#staff_id').select2({
  
});
</script>