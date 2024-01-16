<form action="" class="" id="dynamic_form">
    <input type="hidden" name="id" value="{{ $info->id ?? '' }}">
    <input type="hidden" name="form_type" id="form_type" value="{{ $from ?? '' }}">
    <div class="row">
        <div class="col-6">
            <div class="fv-row form-group mb-10">
                <label class="form-label required" for="">
                    Select Institute
                </label>
                <div >
                    <select name="institute_id" class="form-control" id="institute_id">
                        <option value="">--Select Institute--</option>
                        @foreach ($institute as $key=>$val)
                        <option value="{{ $val->id }}" @if(isset($info->institute_id) && $info->institute_id == $val->id) selected @endif>{{ $val['name']  }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="fv-row form-group mb-10">
                <label class="form-label required" for="">
                    Select Type 
                </label>
                <div >
                    <select name="type" class="form-control" id="type" onchange="return typeCheck();">
                        <option value="">--Select Announcement Type--</option>
                        <option data-id="1"
                        @if(isset($info->announcement_type) && $info->announcement_type == 'Full Time') selected @endif
                         value="Full Time">Full Time</option>
                        <option  data-id="2" 
                        @if(isset($info->announcement_type) && $info->announcement_type == 'Short Period') selected @endif
                        value="Short Period">Short Period</option>
                    
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="row" id="full_time_show"
    @if(empty($info->announcement_type) || $info->announcement_type == 'Full Time') style="display:none;" @endif
     >
        <div class="col-6">
            <div class="fv-row form-group mb-10">
            <label class="form-label required" for="">
               From Date
            </label>
            <div> 
                <input type="date" class="form-control" name="from_date" value="{{ $info->from_date ?? '' }}" id="from_date"  >
            </div>
            </div>
        </div>
        <div class="col-6">
            <div class="fv-row form-group mb-10">
            <label class="form-label required" for="">
               To Date
            </label>
            <div> 
                <input type="date" class="form-control" name="to_date" value="{{ $info->to_date ?? '' }}" id="to_date"  >
            </div>
        </div>
        </div>
    </div>
     <div class="row">
        <div class="col-6">
            <div class="fv-row form-group mb-10">
            <label class="form-label required" for="">
              Message
             </label>
             <div> 
                 <textarea class="form-control" name="an_message"   id="an_message" required >
                    {{ $info->message??''}} </textarea>
                </div>
            </div>
        </div>
        <div class="col-6">
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
        </div>
    </div>
    <div class="row">
         <div class="col-6">
            <div class="fv-row form-group mb-10">
                <label class="form-label" for="">
                    Upload Type
                </label>
                <div >
                    <input type="radio" id="link" class="form-check-input" value="link" name="upload_type" @if(isset($info->upload_type) && $info->upload_type == 'link') checked  @endif >
                    <label class="pe-3" for="active">Link</label>
                    <input type="radio" id="file" class="form-check-input" value="file" name="upload_type" @if(isset($info->upload_type) && $info->upload_type == 'file') checked  @endif>
                    <label for="inactive">Image</label>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="fv-row form-group mb-10">
            <label class="form-label" for="">
             </label>
            <div class="link  @if(isset($info->upload_type) && $info->upload_type == 'link') d_block  @else d_none @endif" > 
                 <input type="link" name="link" class="form-control"  @if(isset($info->upload_type) && $info->upload_type == 'link') value="{{$info->upload_data}}"  @endif  >
                 @if(isset($info->upload_type) && $info->upload_type == 'link')
                 <a onclick="mypopup()"><i class="fa fa-eye" aria-hidden="true"></i>
                        </a>
                   @endif 
             </div>
             <div class="file  @if(isset($info->upload_type) && $info->upload_type == 'file') d_block @else d_none @endif"> 
                 <input type="file" name="file" class="form-control" value="">
                  @if(isset($info->upload_type) && $info->upload_type == 'file')
                  <a onclick="mypopup()"><i class="fa fa-eye" aria-hidden="true"></i>
                        </a>
                  @endif 
             </div>
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
<div class="modal fade" id="kt_popup" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-900px">
        <div class="modal-dialog modal-dialog-centered mw-900px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                            transform="rotate(-45 6 17.3137)" fill="currentColor" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1"
                            transform="rotate(45 7.41422 6)" fill="currentColor" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body py-lg-10 px-lg-10" id="dynamic_content">
                <!--begin::Stepper-->
                            @if(isset($info->upload_type) && $info->upload_type == 'link')
            <iframe class="mt-3" src="{{$info->upload_data}}" title="{{ $info->message??''}}" sandbox="allow-popups">
                  </iframe>
            @endif
            @if(isset($info->upload_type) && $info->upload_type == 'file')
                  <img src="{{url('public/storage/' .$info->upload_data)}}" >
                        
            @endif
                <!--end::Stepper-->
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
</div>
</div>
<script>
    function typeCheck()
    {
        var type_id=$('#type option:selected').data('id');
        if(type_id==2)
        {
            $("#full_time_show").show();
        }
        else
        {
            $("#full_time_show").hide();
            $("#from_date").val('');
            $("#to_date").val('');
        }       
    }
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
                    'institute_id': {
						validators: {
							notEmpty: {
								message: 'Select Institute is Required'
							},
						}
					},
                    'type': {
						validators: {
							notEmpty: {
								message: 'Select Type is Required'
							},
						}
					},'radio': {
                        validators: {
                            notEmpty: {
                                message: 'Upload type filed is Required'
                            },
                        }
                    },
                    'an_message': {
						validators: {
							notEmpty: {
								message: 'Message is Required'
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
                            url:"{{ route('save.announcement') }}",
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
                                    toastr.success("Announcement added successfully");
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
$('input[name=upload_type]').on('click',function(){
   if(this.value=='file'){
    $('.link').removeClass('d_block');
    $('.link').addClass('d_none');
    $('.file').addClass('d_block');
}
if(this.value=='link'){
    $('.file').removeClass('d_block');
    $('.file').addClass('d_none');
    $('.link').addClass('d_block');
}
});
KTUtil.onDOMContentLoaded(function () {
    KTAppEcommerceSaveBranch.init();
});
    
    
</script>