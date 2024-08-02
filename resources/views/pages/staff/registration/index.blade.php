<!--begin::Navbar-->
@extends('layouts.template')
@section('breadcrum')
    @include('layouts.parts.breadcrum')
@endsection
@section('content')
    <link rel="stylesheet" href="{{ asset('assets/css/registration.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bd-wizard.css') }}">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <style type="text/css">
        .popup {
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.4);
  display: none;
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  text-align: center;
  position: fixed;
  .popup__content {
    width: 80%;
    overflow:auto;
    padding: 50px;
    background: white;
    color: black;
    position: relative;
    top: 50%;
    left: 59%;
    transform: translate(-50%, -50%);
    box-sizing: border-box;
    .close {
      position: absolute;
      right: 20px;
      top: 20px;
      width: 20px;
      display: block;
      span {
        cursor: pointer;
        position: fixed;
        width: 20px;
        height: 3px;
        background: #099ccc;
        &:nth-child(1) {
          transform: rotate(45deg);
        }
        &:nth-child(2) {
          transform: rotate(135deg);
        }
      }
    }
  }
}
    </style>
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
    @if (session('status'))
        <div class="alert alert-success text-center">
            {{ session('status') }}
        </div>
    @endif
    <!--begin::Stepper-->
    @if( isset( $staff_details ) && !empty( $staff_details ))
    <div class="row">
        <div class="col-sm-12">
            <div class="mb-2 d-flex justify-content-between">
                <div class="p-2 px-4 border border-2 w-200px">
                    <div class="fw-bold">
                        Staff Name:
                    </div>
                    <div class="badge badge-light-info fs-6">
                        {{ $staff_details->name }}
                    </div>
                </div>
                <div class="p-2 px-4 border border-2 w-200px">
                    <div class="fw-bold">
                        Society Code:
                    </div>
                    <div class="badge badge-light-success fs-6">
                        {{ $staff_details->society_emp_code ?? 'n/a' }}
                    </div>
                </div>
                <div class="p-2 px-4 border border-2 w-200px">
                    <div class="fw-bold">
                       Institute Code:
                    </div>
                    <div class="badge badge-light-danger fs-6">
                        {{ $staff_details->institute_emp_code ?? 'n/a' }}
                    </div>
                </div>
                <div class="p-2 px-4 border border-2 w-200px">
                    <div class="fw-bold">
                        Designation
                    </div>
                    <div class="badge badge-light-warning fs-6">
                        {{ $staff_details->position->designation->name ?? 'n/a' }}
                    </div>
                </div>
                <div class="p-2 px-4 border border-2 w-200px">
                    <div class="fw-bold">
                        Nature of Work
                    </div>
                    <div class="badge badge-light-primary fs-6">
                      
                        {{ $staff_details->appointment->employment_nature->name ?? 'n/a' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <div id="wizard" class="wizard-section border shadow">
        <h3>
            <div class="media">
                <div class="bd-wizard-step-icon text-center">
                    <i class="icon-xl la la-user-check"></i>
                </div>
                <div class="media-body text-center">
                    <div class="bd-wizard-step-title">Personal information</div>
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
                    <div class="bd-wizard-step-title">KYC  &nbsp; information</div>
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
                    <div class="bd-wizard-step-title">Education & Qualification</div>
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
                    <div class="bd-wizard-step-title">Family information</div>
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
                    <div class="bd-wizard-step-title"> Other Information</div>
                </div>
            </div>
        </h3>
        <section>
            <div class="">
                @include('pages.staff.registration.other_information.index')
            </div>
        </section>
         <h3>
            <div class="media">
                <div class="bd-wizard-step-icon text-center">
                    <i class="icon-xl la la-briefcase-medical"></i>
                </div>
                <div class="media-body text-center">
                    <div class="bd-wizard-step-title"> EL Summary</div>
                </div>
            </div>
        </h3>
        <section>
            <div class="">
                 @if (access()->hasAccess('staff.el.summary', 'view'))
                @include('pages.staff.registration.el_information.index')
                @endif
            </div>
        </section>
        <h3>
            <div class="media">
                <div class="bd-wizard-step-icon text-center">
                    <i class="icon-xl la la-briefcase-medical"></i>
                </div>
                <div class="media-body text-center">
                    <div class="bd-wizard-step-title"> Appointment Information</div>
                </div>
            </div>
        </h3>
        <section>
            <div class="">
                @include('pages.staff.registration.appointment_details')
            </div>
        </section>
    </div>

    <script>
    async function ValidationEl() {
     return false;
    }
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
                    return await ValidationSchemeSetCurrent();
                    break;
                case 7:
                    return await ValidationEl();
                    break;
                case 8:
                    return await validateAppointmentForm();
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
        $('#classes').select2({ theme: 'bootstrap-5'});
        

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

        window.scrollTo({ top: 0, behavior: 'smooth' });
    </script>
@endsection
