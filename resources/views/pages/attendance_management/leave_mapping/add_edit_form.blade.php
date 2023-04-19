<form action="" class="" id="dynamic_form">
    <input type="hidden" name="id" value="{{ $info->id ?? '' }}">
    <div class="col-sm-12">
        <div class="fv-row form-group mb-2">
            <label class="form-label required">Nature of Employment </label>
            <div class="position-relative">
              
                <select name="nature_of_employment_id" autofocus id="nature_of_employment_id" class="form-select form-select-lg select2-option">
                    <option value="">--Select Nature of employment--</option>
                    @isset($employment_nature)
                        @foreach ($employment_nature as $item)
                            <option value="{{ $item->id }}" @if (isset($info->nature_of_employment_id) && $info->nature_of_employment_id == $item->id) selected @endif>
                                {{ $item->name }}
                            </option>
                        @endforeach
                    @endisset
                </select>
            </div>
        </div>
    </div>
    <div class="col-sm-12 mt-7">
        <div class="fv-row form-group mb-2">
            <label class="form-label required">Leave Heads</label>
            <div class="position-relative">
              
                <select name="leave_head_id" autofocus id="leave_head_id" class="form-select form-select-lg select2-option">
                    <option value="">--Select Leave Heads--</option>
                    @isset($leave_heads)
                        @foreach ($leave_heads as $item)
                            <option value="{{ $item->id }}" @if (isset($info->leave_head_id) && $info->leave_head_id == $item->id) selected @endif>
                                {{ $item->name }}
                            </option>
                        @endforeach
                    @endisset
                </select>
            </div>
        </div>
    </div>
    <div class="fv-row form-group mb-10 mt-7">
        <label class="form-label required" for="">
            No of Leave Days
        </label>
        <div > 
            <input type="text" class="form-control" name="leave_days" value="{{ $info->leave_days ?? '' }}" id="leave_days" required >
        </div>
    </div>

    <div class="fv-row form-group mb-10 mt-7">
        <label class="form-label required" for="">
          Is Carry Forward
        </label>
        <div > 
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="carry_forward" id="inlineRadio1" value="yes"
                @if (isset($info->carry_forward) && $info->carry_forward == 'yes') @checked(true) @endif>
                <label class="form-check-label" for="inlineRadio1">Yes</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="carry_forward" id="inlineRadio2" value="no"
                @if (isset($info->carry_forward) && $info->carry_forward == 'no') @checked(true) @endif>
                <label class="form-check-label" for="inlineRadio2">No</label>
              </div>
        </div>
    </div>
  
    <div class="fv-row form-group mb-10 mt-7">
        <label class="form-label" for="">
            Status
        </label>
        <div >
            <input type="checkbox" class="form-check-input" value="1" name="status" @if(isset($info->status) && $info->status == 'active') checked  @endif >
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

var KTAppEcommerceSaveLeaveMapping = function () {

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
                    'nature_of_employment_id': {
						validators: {
							notEmpty: {
								message: 'Nature of employment  is required'
							},
						}
					},
                    'leave_head_id': {
						validators: {
							notEmpty: {
								message: 'Leave Head Name is required'
							},
						}
					},
                    'leave_days': {
						validators: {
							notEmpty: {
								message: 'No of Leave Days is required'
							},
						}
					},
                    'carry_forward': {
						validators: {
							notEmpty: {
								message: 'Carry Forward is required'
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
                            url:"{{ route('save.leave-mapping') }}",
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
                                    toastr.success("Leave Mapping added successfully");
                                    $('#kt_dynamic_app').modal('hide');
                                    dtTable.draw();

                               
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
    KTAppEcommerceSaveLeaveMapping.init();
});
    
    
</script>