<div data-kt-stepper-element="content">
    
    <div class="w-100">
        
        <div class="pb-5 pb-lg-5">
            <h2 class="fw-bolder text-dark">Employee Details</h2>
        </div>
       
        <div class="row">
            <div class="col-lg-4 mb-5">
                <label class="form-label required">Designation</label>
                <div class="position-relative">
                    <select name="designation_id" autofocus id="designation_id"
                        class="form-select form-select-lg select2-option">
                        <option value="">--Select Designation--</option>
                        @isset($designation)
                            @foreach ($designation as $item)
                                <option value="{{ $item->id }}" @if (isset($staff_details->personal) && $staff_details->personal->mother_tongue == $item->id) selected @endif>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        @endisset
                    </select>
                    <span class="position-absolute btn btn-success btn-md top-0 end-0"
                        onclick="return openAddModel('designation')">
                        <i class="fa fa-plus"></i>
                    </span>
                </div>
            </div>

            <div class="col-lg-4 mb-5">
                <label class="form-label required">Department</label>
                <div class="position-relative">
                    <select name="department_id" autofocus id="department_id"
                        class="form-select form-select-lg select2-option">
                        <option value="">--Select Department--</option>
                        @isset($department)
                            @foreach ($department as $item)
                                <option value="{{ $item->id }}" @if (isset($staff_details->personal) && $staff_details->personal->mother_tongue == $item->id) selected @endif>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        @endisset
                    </select>
                    <span class="position-absolute btn btn-success btn-md top-0 end-0"
                        onclick="return openAddModel('department')">
                        <i class="fa fa-plus"></i>
                    </span>
                </div>
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="col-lg-4 mb-5">
                <label class="form-label required">Subject</label>
                <div class="position-relative">
                    <select name="subject[]" autofocus id="subject" multiple
                        class="form-select form-select-lg select2-option">
                        <option value="">--Select Subject--</option>
                        @isset($subjects)
                            @foreach ($subjects as $item)
                                <option value="{{ $item->id }}" @if (isset($staff_details->personal) && $staff_details->personal->mother_tongue == $item->id) selected @endif>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        @endisset
                    </select>
                    <span class="position-absolute btn btn-success btn-md top-0 end-0"
                        onclick="return openAddModel('subject')">
                        <i class="fa fa-plus"></i>
                    </span>
                </div>
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <input type="hidden" name="id" id="staff_id" value="{{ $staff_details->id ?? '' }}">
            <div class="col-lg-4 mb-5">
                <label class="form-label required">Attendance Scheme</label>
                <div class="position-relative">
                    <select name="scheme_id" autofocus id="scheme_id"
                        class="form-select form-select-lg select2-option">
                        <option value="">--Select Scheme--</option>
                        @isset($scheme)
                            @foreach ($scheme as $item)
                                <option value="{{ $item->id }}" @if (isset($staff_details->personal) && $staff_details->personal->mother_tongue == $item->id) selected @endif>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        @endisset
                    </select>
                    <span class="position-absolute btn btn-success btn-md top-0 end-0"
                        onclick="return openAddModel('scheme')">
                        <i class="fa fa-plus"></i>
                    </span>
                </div>
            </div>
            
            <hr class="bg-lt-clr mt-3">
            </hr>
            <!--begin::Tables Widget 13-->
            <div class="card mb-0 mb-xl-0 wdth-40percent">
                <!--begin::Header-->
                <div class="card-header border-0 pt-0">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder fs-3 mb-1">Subject studied upto </span>
                    </h3>
                </div>
          
                <div class="card-body py-0">
                    <!--begin::Table container-->
                    <div class="table-responsive" id="studied_pane">
                        <!--begin::Table-->
                        @include('pages.staff.registration.emp_position.studied_subject_pane')
                        <!--end::Table-->
                    </div>
                    <!--end::Table container-->
                </div>
                <!--begin::Body-->
            </div>

            <!--begin::Tables Widget 13-->
            <div class="tble-fnton mt-5 card mb-5 mb-xl-8">
                <!--begin::Header-->
                <div class="card-header border-0 pt-0">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder fs-3 mb-1">Invigilation Duty Details</span>
                    </h3>

                    <button id="kt_new_data_toggle_duty"
                        class="engage-demos-toggle btn btn-flex h-35px bg-body btn-color-gray-700 btn-active-color-gray-900 shadow-sm fs-6 px-4 rounded-top-0 mt-5"
                        title="Click Here to add More" data-bs-toggle="tooltip"
                        data-bs-placement="left" data-bs-dismiss="click" data-bs-trigger="hover">
                        <span id="kt_engage_demos_label"><span class="svg-icon svg-icon-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none">
                                    <rect opacity="0.5" x="11.364" y="20.364"
                                        width="16" height="2" rx="1"
                                        transform="rotate(-90 11.364 20.364)" fill="currentColor">
                                    </rect>
                                    <rect x="4.36396" y="11.364" width="16"
                                        height="2" rx="1" fill="currentColor"></rect>
                                </svg>
                            </span> Add New</span>
                    </button>
                    <!--begin::Help drawer-->
                   
                    <!--end::Help drawer-->
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body py-3" id="invigilation-pane">
                    <!--begin::Table container-->
                    @include('pages.staff.registration.emp_position.invigilation_list')
                    <!--end::Table container-->
                </div>
                <!--begin::Body-->
            </div>
            <!--end::Tables Widget 13-->



            <!--begin::Tables Widget 13-->
            <div class="tble-fnton mt-5 card mb-5 mb-xl-8">
                <!--begin::Header-->
                <div class="card-header border-0 pt-0">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder fs-3 mb-1">Training Details</span>
                    </h3>

                    <button id="kt_new_data_toggle_train"
                        class="engage-demos-toggle btn btn-flex h-35px bg-body btn-color-gray-700 btn-active-color-gray-900 shadow-sm fs-6 px-4 rounded-top-0 mt-5"
                        title="Click Here to add More" data-bs-toggle="tooltip"
                        data-bs-placement="left" data-bs-dismiss="click" data-bs-trigger="hover">
                        <span id="kt_engage_demos_label"><span class="svg-icon svg-icon-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none">
                                    <rect opacity="0.5" x="11.364" y="20.364"
                                        width="16" height="2" rx="1"
                                        transform="rotate(-90 11.364 20.364)" fill="currentColor">
                                    </rect>
                                    <rect x="4.36396" y="11.364" width="16"
                                        height="2" rx="1" fill="currentColor"></rect>
                                </svg>
                            </span> Add New</span>
                    </button>
                    <!--begin::Help drawer-->
                    <div id="kt_help" class="bg-body" data-kt-drawer="true"
                        data-kt-drawer-name="help" data-kt-drawer-activate="true"
                        data-kt-drawer-overlay="true"
                        data-kt-drawer-width="{default:'350px', 'md': '725px'}"
                        data-kt-drawer-direction="end"
                        data-kt-drawer-toggle="#kt_new_data_toggle_train"
                        data-kt-drawer-close="#kt_help_close">
                        <!--begin::Card-->
                        <div class="card shadow-none rounded-0 w-100">
                            <!--begin::Header-->
                            <div class="card-header" id="kt_help_header">
                                <h5 class="card-title fw-bold text-gray-600">Add your Training
                                    Details</h5>
                                <div class="card-toolbar">
                                    <button type="button"
                                        class="btn btn-sm btn-icon explore-btn-dismiss me-n5"
                                        id="kt_help_close">
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                        <span class="svg-icon svg-icon-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                height="24" viewBox="0 0 24 24"
                                                fill="none">
                                                <rect opacity="0.5" x="6"
                                                    y="17.3137" width="16" height="2"
                                                    rx="1"
                                                    transform="rotate(-45 6 17.3137)"
                                                    fill="currentColor" />
                                                <rect x="7.41422" y="6"
                                                    width="16" height="2" rx="1"
                                                    transform="rotate(45 7.41422 6)"
                                                    fill="currentColor" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </button>
                                </div>
                            </div>
                            <!--end::Header-->

                            <!--begin::Body-->
                            <div class="card-body p-5" id="kt_help_body">
                                <div class="row">

                                    <!--begin::Input group-->
                                    <div class="col-lg-6 mb-5">
                                        <label class="required fs-6 fw-bold mb-2">From</label>
                                        <!--begin::Input-->
                                        <div class="position-relative d-flex align-items-center">
                                            <!--begin::Icon-->
                                            <!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
                                            <span class="svg-icon svg-icon-2 position-absolute mx-4">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none">
                                                    <path opacity="0.3"
                                                        d="M21 22H3C2.4 22 2 21.6 2 21V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5V21C22 21.6 21.6 22 21 22Z"
                                                        fill="currentColor" />
                                                    <path
                                                        d="M6 6C5.4 6 5 5.6 5 5V3C5 2.4 5.4 2 6 2C6.6 2 7 2.4 7 3V5C7 5.6 6.6 6 6 6ZM11 5V3C11 2.4 10.6 2 10 2C9.4 2 9 2.4 9 3V5C9 5.6 9.4 6 10 6C10.6 6 11 5.6 11 5ZM15 5V3C15 2.4 14.6 2 14 2C13.4 2 13 2.4 13 3V5C13 5.6 13.4 6 14 6C14.6 6 15 5.6 15 5ZM19 5V3C19 2.4 18.6 2 18 2C17.4 2 17 2.4 17 3V5C17 5.6 17.4 6 18 6C18.6 6 19 5.6 19 5Z"
                                                        fill="currentColor" />
                                                    <path
                                                        d="M8.8 13.1C9.2 13.1 9.5 13 9.7 12.8C9.9 12.6 10.1 12.3 10.1 11.9C10.1 11.6 10 11.3 9.8 11.1C9.6 10.9 9.3 10.8 9 10.8C8.8 10.8 8.59999 10.8 8.39999 10.9C8.19999 11 8.1 11.1 8 11.2C7.9 11.3 7.8 11.4 7.7 11.6C7.6 11.8 7.5 11.9 7.5 12.1C7.5 12.2 7.4 12.2 7.3 12.3C7.2 12.4 7.09999 12.4 6.89999 12.4C6.69999 12.4 6.6 12.3 6.5 12.2C6.4 12.1 6.3 11.9 6.3 11.7C6.3 11.5 6.4 11.3 6.5 11.1C6.6 10.9 6.8 10.7 7 10.5C7.2 10.3 7.49999 10.1 7.89999 10C8.29999 9.90003 8.60001 9.80003 9.10001 9.80003C9.50001 9.80003 9.80001 9.90003 10.1 10C10.4 10.1 10.7 10.3 10.9 10.4C11.1 10.5 11.3 10.8 11.4 11.1C11.5 11.4 11.6 11.6 11.6 11.9C11.6 12.3 11.5 12.6 11.3 12.9C11.1 13.2 10.9 13.5 10.6 13.7C10.9 13.9 11.2 14.1 11.4 14.3C11.6 14.5 11.8 14.7 11.9 15C12 15.3 12.1 15.5 12.1 15.8C12.1 16.2 12 16.5 11.9 16.8C11.8 17.1 11.5 17.4 11.3 17.7C11.1 18 10.7 18.2 10.3 18.3C9.9 18.4 9.5 18.5 9 18.5C8.5 18.5 8.1 18.4 7.7 18.2C7.3 18 7 17.8 6.8 17.6C6.6 17.4 6.4 17.1 6.3 16.8C6.2 16.5 6.10001 16.3 6.10001 16.1C6.10001 15.9 6.2 15.7 6.3 15.6C6.4 15.5 6.6 15.4 6.8 15.4C6.9 15.4 7.00001 15.4 7.10001 15.5C7.20001 15.6 7.3 15.6 7.3 15.7C7.5 16.2 7.7 16.6 8 16.9C8.3 17.2 8.6 17.3 9 17.3C9.2 17.3 9.5 17.2 9.7 17.1C9.9 17 10.1 16.8 10.3 16.6C10.5 16.4 10.5 16.1 10.5 15.8C10.5 15.3 10.4 15 10.1 14.7C9.80001 14.4 9.50001 14.3 9.10001 14.3C9.00001 14.3 8.9 14.3 8.7 14.3C8.5 14.3 8.39999 14.3 8.39999 14.3C8.19999 14.3 7.99999 14.2 7.89999 14.1C7.79999 14 7.7 13.8 7.7 13.7C7.7 13.5 7.79999 13.4 7.89999 13.2C7.99999 13 8.2 13 8.5 13H8.8V13.1ZM15.3 17.5V12.2C14.3 13 13.6 13.3 13.3 13.3C13.1 13.3 13 13.2 12.9 13.1C12.8 13 12.7 12.8 12.7 12.6C12.7 12.4 12.8 12.3 12.9 12.2C13 12.1 13.2 12 13.6 11.8C14.1 11.6 14.5 11.3 14.7 11.1C14.9 10.9 15.2 10.6 15.5 10.3C15.8 10 15.9 9.80003 15.9 9.70003C15.9 9.60003 16.1 9.60004 16.3 9.60004C16.5 9.60004 16.7 9.70003 16.8 9.80003C16.9 9.90003 17 10.2 17 10.5V17.2C17 18 16.7 18.4 16.2 18.4C16 18.4 15.8 18.3 15.6 18.2C15.4 18.1 15.3 17.8 15.3 17.5Z"
                                                        fill="currentColor" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                            <!--end::Icon-->
                                            <!--begin::Datepicker-->
                                            <input class="form-control form-control-solid ps-12"
                                                placeholder="Select a date" name="due_date" />
                                            <!--end::Datepicker-->
                                        </div>
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="col-lg-6 mb-5">
                                        <label class="required fs-6 fw-bold mb-2">To</label>
                                        <!--begin::Input-->
                                        <div class="position-relative d-flex align-items-center">
                                            <!--begin::Icon-->
                                            <!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
                                            <span class="svg-icon svg-icon-2 position-absolute mx-4">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none">
                                                    <path opacity="0.3"
                                                        d="M21 22H3C2.4 22 2 21.6 2 21V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5V21C22 21.6 21.6 22 21 22Z"
                                                        fill="currentColor" />
                                                    <path
                                                        d="M6 6C5.4 6 5 5.6 5 5V3C5 2.4 5.4 2 6 2C6.6 2 7 2.4 7 3V5C7 5.6 6.6 6 6 6ZM11 5V3C11 2.4 10.6 2 10 2C9.4 2 9 2.4 9 3V5C9 5.6 9.4 6 10 6C10.6 6 11 5.6 11 5ZM15 5V3C15 2.4 14.6 2 14 2C13.4 2 13 2.4 13 3V5C13 5.6 13.4 6 14 6C14.6 6 15 5.6 15 5ZM19 5V3C19 2.4 18.6 2 18 2C17.4 2 17 2.4 17 3V5C17 5.6 17.4 6 18 6C18.6 6 19 5.6 19 5Z"
                                                        fill="currentColor" />
                                                    <path
                                                        d="M8.8 13.1C9.2 13.1 9.5 13 9.7 12.8C9.9 12.6 10.1 12.3 10.1 11.9C10.1 11.6 10 11.3 9.8 11.1C9.6 10.9 9.3 10.8 9 10.8C8.8 10.8 8.59999 10.8 8.39999 10.9C8.19999 11 8.1 11.1 8 11.2C7.9 11.3 7.8 11.4 7.7 11.6C7.6 11.8 7.5 11.9 7.5 12.1C7.5 12.2 7.4 12.2 7.3 12.3C7.2 12.4 7.09999 12.4 6.89999 12.4C6.69999 12.4 6.6 12.3 6.5 12.2C6.4 12.1 6.3 11.9 6.3 11.7C6.3 11.5 6.4 11.3 6.5 11.1C6.6 10.9 6.8 10.7 7 10.5C7.2 10.3 7.49999 10.1 7.89999 10C8.29999 9.90003 8.60001 9.80003 9.10001 9.80003C9.50001 9.80003 9.80001 9.90003 10.1 10C10.4 10.1 10.7 10.3 10.9 10.4C11.1 10.5 11.3 10.8 11.4 11.1C11.5 11.4 11.6 11.6 11.6 11.9C11.6 12.3 11.5 12.6 11.3 12.9C11.1 13.2 10.9 13.5 10.6 13.7C10.9 13.9 11.2 14.1 11.4 14.3C11.6 14.5 11.8 14.7 11.9 15C12 15.3 12.1 15.5 12.1 15.8C12.1 16.2 12 16.5 11.9 16.8C11.8 17.1 11.5 17.4 11.3 17.7C11.1 18 10.7 18.2 10.3 18.3C9.9 18.4 9.5 18.5 9 18.5C8.5 18.5 8.1 18.4 7.7 18.2C7.3 18 7 17.8 6.8 17.6C6.6 17.4 6.4 17.1 6.3 16.8C6.2 16.5 6.10001 16.3 6.10001 16.1C6.10001 15.9 6.2 15.7 6.3 15.6C6.4 15.5 6.6 15.4 6.8 15.4C6.9 15.4 7.00001 15.4 7.10001 15.5C7.20001 15.6 7.3 15.6 7.3 15.7C7.5 16.2 7.7 16.6 8 16.9C8.3 17.2 8.6 17.3 9 17.3C9.2 17.3 9.5 17.2 9.7 17.1C9.9 17 10.1 16.8 10.3 16.6C10.5 16.4 10.5 16.1 10.5 15.8C10.5 15.3 10.4 15 10.1 14.7C9.80001 14.4 9.50001 14.3 9.10001 14.3C9.00001 14.3 8.9 14.3 8.7 14.3C8.5 14.3 8.39999 14.3 8.39999 14.3C8.19999 14.3 7.99999 14.2 7.89999 14.1C7.79999 14 7.7 13.8 7.7 13.7C7.7 13.5 7.79999 13.4 7.89999 13.2C7.99999 13 8.2 13 8.5 13H8.8V13.1ZM15.3 17.5V12.2C14.3 13 13.6 13.3 13.3 13.3C13.1 13.3 13 13.2 12.9 13.1C12.8 13 12.7 12.8 12.7 12.6C12.7 12.4 12.8 12.3 12.9 12.2C13 12.1 13.2 12 13.6 11.8C14.1 11.6 14.5 11.3 14.7 11.1C14.9 10.9 15.2 10.6 15.5 10.3C15.8 10 15.9 9.80003 15.9 9.70003C15.9 9.60003 16.1 9.60004 16.3 9.60004C16.5 9.60004 16.7 9.70003 16.8 9.80003C16.9 9.90003 17 10.2 17 10.5V17.2C17 18 16.7 18.4 16.2 18.4C16 18.4 15.8 18.3 15.6 18.2C15.4 18.1 15.3 17.8 15.3 17.5Z"
                                                        fill="currentColor" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                            <!--end::Icon-->
                                            <!--begin::Datepicker-->
                                            <input class="form-control form-control-solid ps-12"
                                                placeholder="Select a date" name="due_date" />
                                            <!--end::Datepicker-->
                                        </div>
                                        <!--end::Input-->
                                    </div>
                                    <!--begin::Input group-->
                                    <div class="col-lg-6 mb-5">
                                        <!--begin::Label-->
                                        <label class="form-label required"> Name of the
                                            Trainer</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input name="business_name"
                                            class="form-control form-control-lg form-control-solid" />
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="col-lg-6 mb-5">
                                        <!--begin::Label-->
                                        <label class="form-label required"> Topic of the
                                            Training</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input name="business_name"
                                            class="form-control form-control-lg form-control-solid" />
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="col-lg-6 mb-5">
                                        <!--begin::Label-->
                                        <label class="form-label required">Remarks </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input name="business_name"
                                            class="form-control form-control-lg form-control-solid" />
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <div class="d-flex flex-stack pt-5">
                                        <!--begin::Wrapper-->
                                        <div>
                                            <button type="button"
                                                class="btn btn-lg btn-primary me-3 d-inline-block"
                                                data-kt-stepper-action="submit">
                                                <span class="indicator-label">Add
                                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                                                    <span class="svg-icon svg-icon-3 ms-2 me-0">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            width="24" height="24"
                                                            viewBox="0 0 24 24" fill="none">
                                                            <rect opacity="0.5" x="18"
                                                                y="13" width="13"
                                                                height="2" rx="1"
                                                                transform="rotate(-180 18 13)"
                                                                fill="currentColor"></rect>
                                                            <path
                                                                d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                                                                fill="currentColor"></path>
                                                        </svg>
                                                    </span>
                                                    <!--end::Svg Icon-->
                                                </span>
                                                <span class="indicator-progress">Please wait...
                                                    <span
                                                        class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                            </button>
                                        </div>
                                        <!--end::Wrapper-->
                                    </div>
                                </div>

                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Card-->
                    </div>
                    <!--end::Help drawer-->
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body py-3">
                    <!--begin::Table container-->
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table
                            class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3">
                            <!--begin::Table head-->
                            <thead>
                                <tr class="fw-bolder text-muted">
                                    <th class="min-w-50px">Sl.No</th>
                                    <th class="min-w-140px">Date From</th>
                                    <th class="min-w-120px">Date to</th>
                                    <th class="min-w-120px">Name of the Trainer</th>
                                    <th class="min-w-120px">Topic</th>
                                    <th class="min-w-120px">Remarks</th>
                                    <th class="min-w-100px text-end">Actions</th>
                                </tr>
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody>
                                <tr>
                                    <td>
                                        <a href="#"
                                            class="text-dark fw-bolder text-hover-primary fs-6">1</a>
                                    </td>
                                    <td class="text-dark fw-bolder text-hover-primary fs-6">Brazil
                                    </td>
                                    <td class="text-dark fw-bolder text-hover-primary fs-6">Anna
                                        University</td>
                                    <td class="text-dark fw-bolder text-hover-primary fs-6">2022</td>
                                    <td class="text-dark fw-bolder text-hover-primary fs-6">Tamil
                                    </td>
                                    <td class="text-dark fw-bolder text-hover-primary fs-6">English
                                    </td>
                                    <td class="text-end">
                                        <a href="#"
                                            class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                            <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                                            <span class="svg-icon svg-icon-3">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none">
                                                    <path opacity="0.3"
                                                        d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z"
                                                        fill="currentColor" />
                                                    <path
                                                        d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z"
                                                        fill="currentColor" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                        </a>
                                        <a href="#"
                                            class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm">
                                            <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                                            <span class="svg-icon svg-icon-3">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none">
                                                    <path
                                                        d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z"
                                                        fill="currentColor" />
                                                    <path opacity="0.5"
                                                        d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z"
                                                        fill="currentColor" />
                                                    <path opacity="0.5"
                                                        d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z"
                                                        fill="currentColor" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
                    </div>
                    <!--end::Table container-->
                </div>
                <!--begin::Body-->
            </div>
            <!--end::Tables Widget 13-->


            <!--end::Tables Widget 13-->
            <!--begin::Input group-->
            <div class="col-lg-4 mb-5 d-none">
                <!--begin::Label-->
                <label class="fs-6 fw-bold form-label required">Contact Email</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input name="business_email"
                    class="form-control form-control-lg form-control-solid"
                    value="corp@support.com" />
                <!--end::Input-->
            </div>
        </div>
        <!--end::Input group-->
    </div>
    <!--end::Wrapper-->
</div>
<div id="kt_help" class="bg-body" data-kt-drawer="true"
data-kt-drawer-name="help" data-kt-drawer-activate="true"
data-kt-drawer-overlay="true"
data-kt-drawer-width="{default:'350px', 'md': '725px'}"
data-kt-drawer-direction="end"
data-kt-drawer-toggle="#kt_new_data_toggle_duty"
data-kt-drawer-close="#kt_help_close">
<!--begin::Card-->
@include('pages.staff.registration.emp_position.add_invigilation')
<!--end::Card-->
</div>