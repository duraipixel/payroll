<form action="" class="" id="dynamic_form">
    <input type="hidden" name="id" value="{{ $info->id ?? '' }}">
    <div class="row">
        <div class="col-sm-6">
            <div class="fv-row form-group mb-2">
                <label class="form-label required" for="">
                    Block Name
                </label>
                <div >
                    <input type="text" class="form-control" name="block_name" value="{{  $info->name ?? '' }}" id="block_name" required >
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="fv-row form-group mb-2">
                <label class="form-label required">Institution</label>
                <div class="position-relative">
                    <select name="institute_id" autofocus id="institute_id" class="form-select form-select-lg select2-option">
                        <option value="">--Select Institution--</option>
                        @isset($institution)
                            @foreach ($institution as $item)
                                <option value="{{ $item->id }}" @if (isset($info->institute_id) && $info->institute_id == $item->id) selected @endif>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        @endisset
                    </select>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="fv-row form-group mb-2">
                <label class="form-label">Place of work</label>
                <div class="position-relative">
                    <select name="place_of_work_id" autofocus id="place_of_work_id" class="form-select form-select-lg select2-option">
                        <option value="">--Select Work--</option>
                        @isset($placeOfWork)
                            @foreach ($placeOfWork as $item)
                                <option value="{{ $item->id }}" @if (isset($info->place_of_work_id) && $info->place_of_work_id == $item->id) selected @endif>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        @endisset
                    </select>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="fv-row form-group mb-3 teaching" style="">
                <label class="form-label required">Class</label>
                <div class="position-relative">
                    <select id="classes" name="class_id[]" class="form-control big_box select2-option classes"
                        placeholder="" multiple>
                        @isset($class)
                            @foreach ($class as $item)
                                <option value="{{ $item->id }}" @if (isset($info->class) && in_array($item->id, $info->class)) selected @endif>
                                    {{ $item->name }}</option>
                            @endforeach
                        @endisset
                    </select>
                   
                </div>
            </div>
        </div>
    </div>
    
    
    
    <div class="fv-row form-group mb-2">
        <label class="form-label" for="">
           Description
        </label>
        <div >
            <textarea name="description" class="form-control" id="description" cols="30" rows="4">{{ $info->description ?? '' }}</textarea>
        </div>
    </div>
    <div class="fv-row form-group mb-2">
        <label class="form-label" for="">
            Status
        </label>
        <div >
            <input type="checkbox" class="form-check-input" value="1" name="status" @if(isset($info->status) && $info->status == 'active') checked  @endif >
        </div>
    </div>
    <div class="form-group mb-2 text-end">
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
var KTAppEcommerceSaveBlocks = function () {

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
                    'block_name': {
						validators: {
							notEmpty: {
								message: 'Block Name is required'
							},
						}
					},
                    'institute_id': {
						validators: {
							notEmpty: {
								message: 'Institution Name is required'
							},
						}
					},
                    'class_id[]': {
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
                            url:"{{ route('save.blocks') }}",
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
                                    toastr.success("Block added successfully");
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
    KTAppEcommerceSaveBlocks.init();
});
    
    
</script>