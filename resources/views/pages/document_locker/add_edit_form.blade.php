<form action="" class="" id="dynamic_form">
    <input type="hidden" name="id" value="{{ $info->id ?? '' }}">
    <input type="hidden" name="form_type" id="form_type" value="{{ $from ?? '' }}">
    <input type="hidden" name="user_id" id="user" value="{{ $user ?? '' }}">
    <div class="fv-row form-group mb-10">
        <label class="form-label required" for="">
            Document Type
        </label>
        <div>
        <select class="form-control" name="document_type">
        <option value="" selected>Choose Document Type</option>
        @foreach($document_types as $document_type)
        <option value="{{$document_type->id}}">{{$document_type->name}}</option>
       @endforeach
    </select>
        </div>
    </div>
     <div class="fv-row form-group mb-10">
        <label class="form-label required" for="">
            Document Name
        </label>
        <div >
            <input type="text" id="document_name" class="form-control"name="document_name" >
        </div>
    </div>
      <div class="fv-row form-group mb-10">
        <label class="form-label required" for="">
          Document
        </label>
        <div >
            <input type="file" id="document" class="form-control" name="document" >
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
    var from = '{{ $from ?? '' }}';

var KTAppEcommerceSavePlace = function () {

    const handleSubmit = () => {
        
        let validator;
        
        const form = document.getElementById('dynamic_form');
        const submitButton = document.getElementById('form-submit-btn');

        validator = FormValidation.formValidation(
            form,
            {
                fields: {
                    'document_name': {
						validators: {
							notEmpty: {
								message: 'Document Name is required'
							},
						}
					},'document_type': {
                        validators: {
                            notEmpty: {
                                message: 'Document Type is required'
                            },
                        }
                    },'document': {
                        validators: {
                            notEmpty: {
                                message: 'Document  is required'
                            },
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
        
        submitButton.addEventListener('click', e => {
            e.preventDefault();
            
            if (validator) {
                validator.validate().then(function (status) {

                    if (status == 'Valid') {

                        var forms = $('#dynamic_form')[0];
                        var formData = new FormData(forms);
                        $.ajax({
                            url:"{{ route('user.document_locker.save') }}",
                            type:"POST",
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(res) {
                                
                                submitButton.disabled = false;
                                submitButton.removeAttribute('data-kt-indicator');
                                if( res.error == 1 ) {
                                    if( res.message ) {
                                        res.message.forEach(element => {
                                            toastr.error("Error", element);
                                        });
                                    }
                                } else{
                                    toastr.success("Other Document  added successfully");
                                    $('#kt_dynamic_app').modal('hide');
                                 location.reload();
                                    if (from) {
                                            dtTable.draw();
                                        } else {
                                    if( res.inserted_data ) {
                                       
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
    KTAppEcommerceSavePlace.init();
});
    
    
</script>