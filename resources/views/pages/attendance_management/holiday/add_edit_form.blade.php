<form action="" class="" id="dynamic_form">
    <input type="hidden" name="id" value="{{ $info->id ?? '' }}">
    
    <div class="row form-group ">
        <div class="col-md-6">
            <label class="form-label required" for="">
                Title
            </label>
            <div > 
                <input type="text" class="form-control" name="title" value="{{ $info->title ?? '' }}" placeholder="Title" id="title" required >
            </div>
        </div>
        <div class="col-md-6">
            <div class="fv-row form-group mb-10">
                <label class="form-label required" for="">
                    Academic Year
                </label>
                    <div class="position-relative">
                        <select name="academic_year" autofocus id="academic_year" class="form-select form-select-lg select2-option">
                            <option value="">--Select Year--</option>
                            @isset($years)
                            @foreach ($years as $item)
                                <option value="{{ $item }}" @if (isset($info->academic_year) && $info->academic_year == $item) selected @endif>
                                    {{ $item }}
                                </option>
                            @endforeach
                        @endisset
                        </select>
                    </div>
            </div>
        </div>
    </div>


    
    <div class="row form-group ">
        <div class="col-md-6">
            <label class="form-label required" for="">
                Date
            </label>
            <div> 
                <input type="date" class="form-control" name="date" value="{{ $info->date ?? '' }}" id="date" required >
            </div>
        </div>
        <div class="col-md-6">
            <label class="form-label required" for="">
                Day
            </label>
            <div> 
                <select name="day" autofocus id="day" class="form-select form-select-lg select2-option">
                    <option value="">--Select Day--</option>
                    @isset($days)
                    @foreach ($days as $item)
                        <option value="{{ $item }}" @if (isset($info->day) && $info->day == $item) selected @endif>
                            {{ $item }}
                        </option>
                    @endforeach
                @endisset
                </select>
            </div>
        </div>
       
    </div>
    <br>
    <div class="row form-group">
       <div class="col-md-6">
            <label class="form-label" for="">
                Is open to all
            </label>
            <div >
                <input type="checkbox" class="form-check-input" value="1" name="is_open_to_all" @if(isset($info->is_open_to_all) && $info->is_open_to_all == 'yes') checked  @endif >
            </div>
       </div>
       <div class="col-md-6">
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

var KTAppEcommerceSaveHoliday = function () {

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
                    'title': {
						validators: {
							notEmpty: {
								message: 'Holiday Name is required'
							},
						}
					},
                    'academic_year': {
						validators: {
							notEmpty: {
								message: 'Academic Year is required'
							},
						}
					},
                    'date': {
						validators: {
							notEmpty: {
								message: 'Date is required'
							},
						}
					},
                    
                    'day': {
						validators: {
							notEmpty: {
								message: 'Day is required'
							},
						}
					},
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        // rowSelector: '.fv-row',
                        eleInvalidClass: '',
                        eleValidClass: ''
                    })
                }
            }
        );

        // Handle submit button
        submitButton.addEventListener('click', e => {
            e.preventDefault();
            console.log("111");
            // Validate form before submit
            if (validator) {
                validator.validate().then(function (status) {

                    if (status == 'Valid') {

                        var forms = $('#dynamic_form')[0];
                        var formData = new FormData(forms);
                        $.ajax({
                            url:"{{ route('save.holiday') }}",
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
                                    toastr.success("Holiday added successfully");
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
    KTAppEcommerceSaveHoliday.init();
});
    
    
</script>