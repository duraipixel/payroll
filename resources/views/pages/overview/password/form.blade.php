 <div class="card mb-5 mb-xl-10" id="kt_referrals_2024_tab">
                        
    <div class="row">
       <div class="col-lg-6 m-auto">
          <div class="cursor-pointer">
           
          </div>
          <div class="card-body cstmzed-witpad">
             <form id="dynamic_form">
                 @csrf

                  @if( auth()->user()->id == $info->id )
                 <input type="hidden" name="id" value="{{ auth()->user()->id }}">

                 <div class="row mb-7 ">
                     <label class="col-lg-5 fw-semibold text-muted required">Old Password</label>
                     <div class="col-lg-7">
                         <input type="password" class="form-control" name="old_password" id="old_password" required >
                     </div>
                 </div>
                 @else
            <input type="hidden" name="id" value="{{ $info->id }}">
        <input type="hidden" class="form-control" name="old_password" id="old_password" value='test'>
                 @endif
                 <div class="row mb-7">
                     <label class="col-lg-5 fw-semibold text-muted required">Password</label>
                     <div class="col-lg-7">
                     <input type="password" class="form-control" name="password"  id="password" required >
                     </div>
                 </div>
                 <div class="row mb-7">
                     <label class="col-lg-5 fw-semibold text-muted required">Change Password</label>
                     <div class="col-lg-7">
                     <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" required >
                     </div>
                 </div>
                  @if( auth()->user()->id == $info->id )
                  <input type="hidden" name="type" value="old">
                  @else
                  <input type="hidden" name="type" value="new">
                  @endif
                 <div class="form-group mb-10 text-end">
                     <button type="button" class="btn btn-light-primary" id="form-cancel-btn"> Cancel </button>
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
          </div>
       </div>
    </div>
 </div>

 <script>
    var password_form_btn = document.getElementById('form-submit-btn');
    var password_cancel_form_btn = document.getElementById('form-cancel-btn');

    password_form_btn.addEventListener('click', function(e) {
        e.preventDefault();
        const submitButton = document.getElementById('form-submit-btn');
        var accountPasswordErrors = false;
        let key_name = [
            'old_password',
            'password',
            'password_confirmation'
           
        ];
        $('.changepassword-form-errors').remove();
        $('.form-control,.form-select').removeClass('border-danger');

        key_name.forEach(element => {
            var name_input = document.getElementById(element).value;

            if (name_input == '' || name_input == undefined) {
                accountPasswordErrors = true;
                var name_input_error =
                    '<div class="fv-plugins-message-container invigilation-form-errors invalid-feedback"><div data-validator="notEmpty">' +
                    element.replace('_', ' ').toUpperCase() + ' is required</div></div>';
                $('#' + element).addClass('border-danger')
                $('#' + element).focus();
            }
        });

        if( !accountPasswordErrors ){
            var forms = $('#dynamic_form')[0];
                    var formData = new FormData(forms);
            $.ajax({
                        url:"{{ route('overview.save') }}",
                        type:"POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(res) {
                            submitButton.disabled = false;
                            if( res.error == 0 ) {
                                toastr.success(res.message);
                                document.getElementById("dynamic_form").reset();
                            } else{
                                if( res.message ) {
                                    res.message.forEach(element => {
                                        toastr.error("Error", element);
                                    });
                                }
                               
                            }
                        }
                    })
        }

    })
    password_cancel_form_btn.addEventListener('click',function(){
        document.getElementById("dynamic_form").reset();
    })
 </script>