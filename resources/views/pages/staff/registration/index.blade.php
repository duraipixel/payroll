<!--begin::Navbar-->
@extends('layouts.template')
@section('breadcrum')
    @include('layouts.parts.breadcrum')
@endsection
@section('content')
    @if (isset($staff_details) && !empty($staff_details))
        <script>
            var formStep = '{{ $step }}';
            formStep = parseInt(formStep) - 1;
            // formStep = 0;
        </script>
    @else
        <script>
            var formStep = 0;
        </script>
    @endif
    <link rel="stylesheet" href="{{ asset('assets/css/registration.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/bd-wizard.css') }}">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>


    <!--begin::Card-->
    <div class="card">
        <!--begin::Card body-->
        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success text-center">
                    {{ session('status') }}
                </div>
            @endif
            <!--begin::Stepper-->
            <div id="wizard">
                <h3>
                    <div class="media">
                        <div class="bd-wizard-step-icon text-center">
                            <i class="icon-xl la la-user-check"></i>
                        </div>
                        <div class="media-body text-center">
                            <div class="bd-wizard-step-title">Personal Information</div>
                        </div>
                    </div>
                </h3>
                <section>
                    <div class="">
                        <input type="hidden" name="staff_id" id="outer_staff_id" value="{{ $staff_details->id ?? '' }}">
                        @include('pages.staff.registration.personal_info')
                    </div>
                </section>
                <h3>
                    <div class="media">
                        <div class="bd-wizard-step-icon text-center">
                            <i class="icon-xl la la-edit"></i>
                        </div>
                        <div class="media-body text-center">
                            <div class="bd-wizard-step-title">KYC Information</div>
                        </div>
                    </div>
                </h3>
                <section>
                    <div class="">
                        @include('pages.staff.registration.kyc')
                    </div>
                </section>
                <h3>
                    <div class="media">
                        <div class="bd-wizard-step-icon text-center">
                            <i class="icon-xl la la-user-tag"></i>
                        </div>
                        <div class="media-body text-center">
                            <div class="bd-wizard-step-title">Employee Position </div>
                        </div>
                    </div>
                </h3>
                <section>
                    <div class="">
                        @include('pages.staff.registration.employee_details')
                    </div>
                </section>
                <h3>
                    <div class="media">
                        <div class="bd-wizard-step-icon text-center">
                            <i class="icon-xl la la-book-open"></i>
                        </div>
                        <div class="media-body text-center">
                            <div class="bd-wizard-step-title">Education Qualification</div>
                        </div>
                    </div>
                </h3>
                <section>
                    <div class="">
                        @include('pages.staff.registration.education_details')
                    </div>
                </section>

                <h3>
                    <div class="media">
                        <div class="bd-wizard-step-icon text-center">
                            <i class="icon-xl la la-users"></i>
                        </div>
                        <div class="media-body text-center">
                            <div class="bd-wizard-step-title">Family Information</div>
                        </div>
                    </div>
                </h3>
                <section>
                    <div class="">
                        @include('pages.staff.registration.family_information')
                    </div>
                </section>

                <h3>
                    <div class="media">
                        <div class="bd-wizard-step-icon text-center">
                            <i class="icon-xl la la-briefcase-medical"></i>
                        </div>
                        <div class="media-body text-center">
                            <div class="bd-wizard-step-title"> Medical Information </div>
                        </div>
                    </div>
                </h3>
                <section>
                    <div class="">
                        @include('pages.staff.registration.medical_info')
                    </div>
                </section>

                <h3>
                    <div class="media">
                        <div class="bd-wizard-step-icon text-center">
                            <i class="icon-xl la la-briefcase-medical"></i>
                        </div>
                        <div class="media-body text-center">
                            <div class="bd-wizard-step-title"> Appointment Information </div>
                        </div>
                    </div>
                </h3>
                <section>
                    <div class="">
                        @include('pages.staff.registration.appointment_details')
                    </div>
                </section>
            </div>
            <!--end::Stepper-->
        </div>
        <!--end::Card body-->
    </div>
    <script>
        function goToNext() {
            return false;
        }

        async function checkGoFurther(form_no) {
            
            switch (form_no) {
                case 0:
                    return await validatePersonalForm();
                    break;

                case 1:
                    return await validateKycForm();
                    break;
                case 2:
                    return await validateEmployeePosition();
                    break;

                case 3:
                    return await validateEducationDetails();
                    break;

                case 4:
                    return await validateFamilyPhase();
                    break;

                case 5:
                    return await validateMedicalForm();
                    break;

                case 6:
                    return await validateAppointmentForm();
                    break;

                case 7:

                    break;

                default:
                    break;
            }
            console.log(form_no, 'form_no');
            return true;
        }
    </script>
    <script src="{{ asset('assets/js/jquery.steps.min.js') }}"></script>
    <script src="{{ asset('assets/js/bd-wizard.js') }}"></script>
    <!--end::Card-->
@endsection

@section('add_on_script')
    <script src="{{ asset('assets/js/plugins/datatables.bundle.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/custom/formrepeater/formrepeater.bundle.js') }}"></script> --}}

    <script src="{{ asset('assets/js/widgets.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/custom/widgets.js') }}"></script>

    {{-- <script src="{{ asset('assets/js/custom/utilities/modals/create-account.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/js/custom/apps/save-product.js') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>

    <script>
        $('#classes, #reporting_manager_id').select2();


        function openAddModel(form_type) {

            var bank = '';
            if (form_type == 'bankbranch') {
                var bank_id = $('#bank_id').val();
                if (bank_id == '' || bank_id == undefined || bank_id == null) {
                    toastr.error('Error', 'Bank is required');
                    return false;
                } else {
                    bank = bank_id;
                }
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('modal.open') }}",
                type: 'POST',
                data: {
                    form_type: form_type,
                    bank_id: bank
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
                data: {
                    institute_id: institute_id
                },
                success: function(res) {
                    if (res) {
                        $('#institute_code').val(res);
                    } else {
                        $('#institute_code').val('');
                    }
                }
            })
        }
    </script>
@endsection
