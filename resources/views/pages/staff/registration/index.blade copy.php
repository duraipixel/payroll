 <!--begin::Navbar-->
 @extends('layouts.template')
 @section('content')
 <link rel="stylesheet" href="{{ asset('assets/css/registration.css') }}">
     <script src="{{ asset('assets/js/tamil-search.js') }}"></script>
     <script src="{{ asset('assets/js/tamil-keyboard.js') }} "></script>
     <!--begin::Card-->
     <div class="card">
         <!--begin::Card body-->
         <div class="card-body">
             <!--begin::Stepper-->
             <div class="stepper stepper-links d-flex flex-column pt-0" id="kt_create_account_stepper">
                 <!--begin::Nav-->
                 <div class="stepper-nav mb-5">
                     <!--begin::Step 1-->
                     <div class="stepper-item current" data-kt-stepper-element="nav">
                         <div class="steppers mr-4 flex-shrink-0 text-center">
                             <i class="icon-xl la la-user-check"></i>
                         </div>
                         <h3 class="stepper-title">Personal Information</h3>
                     </div>
                     <!--end::Step 1-->
                     <!--begin::Step 2-->
                     <div class="stepper-item" data-kt-stepper-element="nav">
                         <div class="steppers mr-4 flex-shrink-0 text-center">
                             <i class="icon-xl la la-edit"></i>
                         </div>
                         <h3 class="stepper-title">KYC Information</h3>
                     </div>
                     <!--end::Step 2-->
                     <!--begin::Step 3-->
                     <div class="stepper-item" data-kt-stepper-element="nav">
                         <div class="steppers mr-4 flex-shrink-0 text-center">
                             <i class="icon-xl la la-user-tag"></i>
                         </div>
                         <h3 class="stepper-title">Employee Position</h3>
                     </div>
                     <!--end::Step 3-->
                     <!--begin::Step 4-->
                     <div class="stepper-item" data-kt-stepper-element="nav">
                         <div class="steppers mr-4 flex-shrink-0 text-center">
                             <i class="icon-xl la la-book-open"></i>
                         </div>
                         <h3 class="stepper-title">Education Qualification</h3>
                     </div>
                     <!--end::Step 4-->
                     <!--begin::Step 5-->
                     <div class="stepper-item" data-kt-stepper-element="nav">
                         <div class="steppers mr-4 flex-shrink-0 text-center">
                             <i class="icon-xl la la-users"></i>
                         </div>
                         <h3 class="stepper-title">Family Information</h3>
                     </div>
                     <!--end::Step 5-->
                     <!--begin::Step 6-->
                     <div class="stepper-item" data-kt-stepper-element="nav">
                         <div class="steppers mr-4 flex-shrink-0 text-center">
                             <i class="icon-xl la la-briefcase-medical"></i>
                         </div>
                         <h3 class="stepper-title">Medical Information</h3>
                     </div>
                     <!--end::Step 6-->
                     <!--begin::Step 7-->
                     <div class="stepper-item" data-kt-stepper-element="nav">
                         <div class="steppers mr-4 flex-shrink-0 text-center">
                             <i class="icon-xl la fab la-wpforms"></i>
                         </div>
                         <h3 class="stepper-title">Appointment Information</h3>
                     </div>
                     <!--end::Step 7-->
                 </div>
                 <!--end::Nav-->
                 <!--begin::Form-->
                 <form class="mx-auto w-100 pt-5 pb-10" novalidate="novalidate" id="kt_create_account_form">
                     <!--begin::Step 1-->
                     @include('pages.staff.registration.personal_info')
                     <!--end::Step 1-->
                     <!--begin::Step 2-->
                     @include('pages.staff.registration.kyc')
                     <!--end::Step 2-->
                     <!--begin::Step 3-->
                     @include('pages.staff.registration.employee_details')
                     <!--end::Step 3-->
                     <!--begin::Step 4-->
                     @include('pages.staff.registration.education_details')
                     <!--end::Step 4-->
                     <!--begin::Step 5-->
                     @include('pages.staff.registration.family_information')
                     <!--end::Step 5-->
                     <!--begin::Step 6-->
                     @include('pages.staff.registration.medical_info')
                     <!--end::Step 6-->
                     <!--begin::Step 7-->
                     @include('pages.staff.registration.appointment_details')
                     <!--end::Step 7-->
                     <!--begin::Actions-->
                     <div class="d-flex flex-stack pt-15">
                         <!--begin::Wrapper-->
                         <div class="mr-2">
                             <button type="button" class="btn btn-lg btn-light-primary me-3"
                                 data-kt-stepper-action="previous">
                                 <!--begin::Svg Icon | path: icons/duotune/arrows/arr063.svg-->
                                 <span class="svg-icon svg-icon-4 me-1">
                                     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                         viewBox="0 0 24 24" fill="none">
                                         <rect opacity="0.5" x="6" y="11" width="13" height="2"
                                             rx="1" fill="currentColor" />
                                         <path
                                             d="M8.56569 11.4343L12.75 7.25C13.1642 6.83579 13.1642 6.16421 12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75L5.70711 11.2929C5.31658 11.6834 5.31658 12.3166 5.70711 12.7071L11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25C13.1642 17.8358 13.1642 17.1642 12.75 16.75L8.56569 12.5657C8.25327 12.2533 8.25327 11.7467 8.56569 11.4343Z"
                                             fill="currentColor" />
                                     </svg>
                                 </span>
                                 <!--end::Svg Icon-->Previous
                             </button>
                         </div>
                         <!--end::Wrapper-->
                         <!--begin::Wrapper-->
                         <div>
                             <button type="button" class="btn btn-lg btn-primary me-3" data-kt-stepper-action="submit">
                                 <span class="indicator-label">Save as Draft
                                     <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                                     <span class="svg-icon svg-icon-3 ms-2 me-0">
                                         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none">
                                             <rect opacity="0.5" x="18" y="13" width="13"
                                                 height="2" rx="1" transform="rotate(-180 18 13)"
                                                 fill="currentColor" />
                                             <path
                                                 d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                                                 fill="currentColor" />
                                         </svg>
                                     </span>
                                     <!--end::Svg Icon-->
                                 </span>
                                 <span class="indicator-progress"> Please wait...
                                     <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                 </span>
                             </button>
                             <button type="button" class="btn btn-lg btn-primary me-3" data-kt-stepper-action="submit">
                                 <span class="indicator-label">Save
                                     <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                                     <span class="svg-icon svg-icon-3 ms-2 me-0">
                                         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none">
                                             <rect opacity="0.5" x="18" y="13" width="13"
                                                 height="2" rx="1" transform="rotate(-180 18 13)"
                                                 fill="currentColor" />
                                             <path
                                                 d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                                                 fill="currentColor" />
                                         </svg>
                                     </span>
                                     <!--end::Svg Icon-->
                                 </span>
                                 <span class="indicator-progress">Please wait...
                                     <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                             </button>
                             <button type="button" class="btn btn-lg btn-primary" data-kt-stepper-action="next">Next
                                 <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                                 <span class="svg-icon svg-icon-4 ms-1 me-0">
                                     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                         viewBox="0 0 24 24" fill="none">
                                         <rect opacity="0.5" x="18" y="13" width="13"
                                             height="2" rx="1" transform="rotate(-180 18 13)"
                                             fill="currentColor" />
                                         <path
                                             d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                                             fill="currentColor" />
                                     </svg>
                                 </span>
                                 <!--end::Svg Icon-->
                             </button>
                         </div>
                         <!--end::Wrapper-->
                     </div>
                     <!--end::Actions-->
                 </form>
                 <!--end::Form-->
             </div>
             <!--end::Stepper-->
         </div>
         <!--end::Card body-->
     </div>
     <!--end::Card-->
 @endsection

 @section('add_on_script')
     <script>
         var hostUrl = "../assets/index.html";
     </script>

     <script src="{{ asset('assets/js/plugins/datatables.bundle.js') }}"></script>
     <script src="{{ asset('assets/js/custom/formrepeater/formrepeater.bundle.js') }}"></script>

     <script src="{{ asset('assets/js/widgets.bundle.js') }}"></script>
     <script src="{{ asset('assets/js/custom/widgets.js') }}"></script>

     <script src="{{ asset('assets/js/custom/utilities/modals/create-account.js') }}"></script>
     <script src="{{ asset('assets/js/custom/apps/save-product.js') }}"></script>
     <script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>

     <script>
        $('#classes, #reporting_manager_id').select2();

        function openAddModel(form_type) {
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('modal.open') }}",
                type: 'POST',
                data: {
                    form_type: form_type
                },
                success: function(res) {
                    $('#kt_dynamic_app').modal('show');
                    $('#kt_dynamic_app').html(res);
                }
            })
        }

        function getInstituteCode(id) {
            var institute_id = $(id).val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('institute.staff.code') }}",
                type: "POST",
                data: {institute_id:institute_id},
                success: function(res) {
                    if( res ) {
                        $('#institute_code').val(res);
                    } else {

                        $('#institute_code').val('');
                    }
                }
            })
        }
     </script>
 @endsection
