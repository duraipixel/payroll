<div data-kt-stepper-element="content">
    <form id="kyc-form">
        @csrf
        <!--begin::Wrapper-->
        <div class="w-100">
            <!--begin::Heading-->
            <div class="pb-5 pb-lg-5">
                <!--begin::Title-->
                <h2 class="fw-bolder text-dark">KYC Details</h2>
                <!--end::Title-->
            </div>
            <!--end::Heading-->
            <div class="row">
                <div class="col-md-4 fv-row mb-5">
                    <label class="required fs-6 fw-bold mb-2">Date of Birth</label>
                    <!--begin::Input-->
                    <div class="position-relative d-flex align-items-center">
                        <!--begin::Icon-->
                        <!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
                        <span class="svg-icon svg-icon-2 position-absolute mx-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
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
                        <input class="form-control form-control-solid ps-12" placeholder="Select a date"
                            name="due_date" />
                        <!--end::Datepicker-->
                    </div>
                    <!--end::Input-->
                </div>
                <!--begin::Input group-->
                <div class="mb-5 col-lg-4 fv-row">
                    <!--begin::Wrapper-->
                    <div class="d-inline-block flex-stack">

                        <!--begin::Checkboxes-->
                        <!--begin::Label-->
                        <div class="fw-bold me-5">
                            <label class="fs-6">Gender</label>
                        </div>
                        <!--end::Label-->
                        <div class="d-block mt-5 align-items-center cstm-zeed">
                            <!--begin::Checkbox-->
                            <label class="form-check form-check-custom form-check-solid me-10">
                                <input class="form-check-input h-20px w-20px" type="radio"
                                    name="communication[]" value="Male" />
                                <span class="form-check-label fw-bold">Male</span>
                            </label>
                            <!--end::Checkbox-->
                            <!--begin::Checkbox-->
                            <label class="form-check form-check-custom form-check-solid me-10">
                                <input class="form-check-input h-20px w-20px" type="radio"
                                    name="communication[]" value="Female" />
                                <span class="form-check-label fw-bold">Female</span>
                            </label>
                            <!--end::Checkbox-->
                            <!--begin::Checkbox-->
                            <label class="form-check form-check-custom form-check-solid">
                                <input class="form-check-input h-20px w-20px" type="radio"
                                    name="communication[]" value="Others" />
                                <span class="form-check-label fw-bold">Others</span>
                            </label>
                            <!--end::Checkbox-->
                        </div>
                        <!--end::Checkboxes-->
                    </div>
                    <!--end::Wrapper-->
                </div>
                <!--end::Input group-->
                <div class="col-md-4 fv-row mb-5">
                    <label class="required fs-6 fw-bold mb-2">Date of Joining</label>
                    <!--begin::Input-->
                    <div class="position-relative d-flex align-items-center">
                        <!--begin::Icon-->
                        <!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
                        <span class="svg-icon svg-icon-2 position-absolute mx-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
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
                        <input class="form-control form-control-solid ps-12" placeholder="Select a date"
                            name="due_date" />
                        <!--end::Datepicker-->
                    </div>
                    <!--end::Input-->
                </div>
                <!--begin::Input group-->
                <div class="col-lg-4 mb-5">
                    <!--begin::Label-->
                    <label class="form-label required">Marital Status</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <select name="marr_type" class="form-select form-select-lg form-select-solid"
                        data-control="select2" data-placeholder="Select Type" data-allow-clear="true"
                        data-hide-search="true">
                        <option></option>
                        <option value="1">Married</option>
                        <option value="1">Single</option>
                        <option value="1">Divorced</option>
                    </select>
                    <!--end::Input-->
                </div>
                <!--end::Input group-->
                <div class="col-md-4 fv-row mb-5">
                    <label class="fs-6 fw-bold mb-2">Marriage Date</label>
                    <!--begin::Input-->
                    <div class="position-relative d-flex align-items-center">
                        <!--begin::Icon-->
                        <!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
                        <span class="svg-icon svg-icon-2 position-absolute mx-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
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
                        <input class="form-control form-control-solid ps-12" placeholder="Select a date"
                            name="due_date" />
                        <!--end::Datepicker-->
                    </div>
                    <!--end::Input-->
                </div>
                <!--begin::Input group-->
                <div class="col-lg-4 mb-5">
                    <!--begin::Label-->
                    <label class="form-label required">Mother Tongue</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input name="business_name"
                        class="form-control form-control-lg form-control-solid" />
                    <!--end::Input-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="col-lg-4 mb-5">
                    <!--begin::Label-->
                    <label class="form-label required">Place of Birth</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input name="business_name"
                        class="form-control form-control-lg form-control-solid" />
                    <!--end::Input-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="col-lg-4 mb-5">
                    <!--begin::Label-->
                    <label class="form-label required">Nationality </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input name="business_name"
                        class="form-control form-control-lg form-control-solid" />
                    <!--end::Input-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="col-lg-4 mb-5">
                    <!--begin::Label-->
                    <label class="form-label required">Religion</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <select name="business_type" class="form-select form-select-lg form-select-solid"
                        data-control="select2" data-placeholder="Select Type" data-allow-clear="true"
                        data-hide-search="true">
                        <option></option>
                        <option value="1">Christian</option>
                        <option value="1">Muslims</option>
                        <option value="1">Hindu</option>
                        <option value="1">Sikhs</option>
                        <option value="1">Buddhists</option>
                        <option value="1">Jains</option>
                    </select>
                    <!--end::Input-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="col-lg-4 mb-5">
                    <!--begin::Label-->
                    <label class="form-label required">Caste</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <select name="business_type" class="form-select form-select-lg form-select-solid"
                        data-control="select2" data-placeholder="Select Type" data-allow-clear="true"
                        data-hide-search="true">
                        <option></option>
                        <option value="1">Caste - 1</option>
                        <option value="1">Caste - 2</option>
                        <option value="1">Caste - 3</option>
                        <option value="1">Caste - 4</option>
                        <option value="1">Caste - 5</option>
                    </select>
                    <!--end::Input-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="col-lg-4 mb-5">
                    <!--begin::Label-->
                    <label class="form-label required">Community</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <select name="business_type" class="form-select form-select-lg form-select-solid"
                        data-control="select2" data-placeholder="Select Type" data-allow-clear="true"
                        data-hide-search="true">
                        <option></option>
                        <option value="1">Community - 1</option>
                        <option value="1">Community - 2</option>
                        <option value="1">Community - 3</option>
                        <option value="1">Community - 4</option>
                        <option value="1">Community - 5</option>
                    </select>
                    <!--end::Input-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="col-lg-4 mb-5">
                    <!--begin::Label-->
                    <label class="form-label required">Email Id</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input name="business_name"
                        class="form-control form-control-lg form-control-solid" />
                    <!--end::Input-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="col-lg-4 mb-5">
                    <!--begin::Label-->
                    <label class="form-label required">Phone No.</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input name="business_name"
                        class="form-control form-control-lg form-control-solid" />
                    <!--end::Input-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="col-lg-4 mb-5">
                    <!--begin::Label-->
                    <label class="form-label required">Mobile No - 1</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input name="business_name"
                        class="form-control form-control-lg form-control-solid" />
                    <!--end::Input-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="col-lg-4 mb-5">
                    <!--begin::Label-->
                    <label class="form-label required">Mobile No - 2</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input name="business_name"
                        class="form-control form-control-lg form-control-solid" />
                    <!--end::Input-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="col-lg-4 mb-5">
                    <!--begin::Label-->
                    <label class="form-label required">Whatsapp No.</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input name="business_name"
                        class="form-control form-control-lg form-control-solid" />
                    <!--end::Input-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="col-lg-4 mb-5">
                    <!--begin::Label-->
                    <label class="form-label required">Emergency No.</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input name="business_name"
                        class="form-control form-control-lg form-control-solid" />
                    <!--end::Input-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="col-lg-6 mb-5">
                    <!--end::Label-->
                    <label class="form-label">Contact Address</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <textarea name="business_description" class="form-control form-control-lg form-control-solid" rows="3"></textarea>
                    <!--end::Input-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="col-lg-6 mb-5">
                    <!--end::Label-->
                    <label class="form-label">Permanent Address</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <textarea name="business_description" class="form-control form-control-lg form-control-solid" rows="3"></textarea>
                    <!--end::Input-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-5">
                    <!--begin::Col-->
                    <div class="col-md-12 fv-row">
                        <!--begin::Label-->
                        <label class="required fs-6 fw-bold form-label mb-2">Bank Details</label>
                        <!--end::Label-->
                        <!--begin::Row-->
                        <div class="row fv-row">
                            <!--begin::Col-->
                            <div class="col-3">
                                <input name="business_email"
                                    class="form-control form-control-lg form-control-solid"
                                    placeholder="Bank Name" />
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-3">
                                <input name="business_email"
                                    class="form-control form-control-lg form-control-solid"
                                    placeholder="Branch Name" />
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-3">
                                <input name="business_email"
                                    class="form-control form-control-lg form-control-solid"
                                    placeholder="IFSC Code" />
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-3">
                                <input name="business_email"
                                    class="form-control form-control-lg form-control-solid"
                                    placeholder="Account Number" />
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->

                <!--begin::Input group-->
                <div class="row mb-5">
                    <!--begin::Col-->
                    <div class="col-md-4 fv-row">
                        <!--begin::Label-->
                        <label class="required fs-6 fw-bold form-label mb-2">Bank Passbook</label>
                        <!--end::Label-->
                        <!--begin::Row-->
                        <div class="row fv-row">
                            <!--begin::Col-->
                            <div class="col-12">
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label text-lg-right">Upload
                                        File:</label>
                                    <div class="col-lg-6">
                                        <div class="uppy" id="kt_uppy_5">
                                            <div class="uppy-wrapper">
                                                <div class="uppy-Root uppy-FileInput-container"><input
                                                        class="uppy-FileInput-input uppy-input-control"
                                                        style="" type="file" name="files[]"
                                                        multiple=""
                                                        id="kt_uppy_5_input_control"><label
                                                        class="uppy-input-label btn btn-light-primary btn-sm btn-bold"
                                                        for="kt_uppy_5_input_control">Attach files</label>
                                                </div><span class="form-text text-dark">Maximum file size
                                                    1MB</span>
                                            </div>
                                            <div class="uppy-list"></div>
                                            <div class="uppy-status">
                                                <div class="uppy-Root uppy-StatusBar is-waiting"
                                                    aria-hidden="true" dir="ltr">
                                                    <div class="uppy-StatusBar-progress"
                                                        style="width: 0%;" role="progressbar"
                                                        aria-valuemin="0" aria-valuemax="100"
                                                        aria-valuenow="0"></div>
                                                    <div class="uppy-StatusBar-actions"></div>
                                                </div>
                                            </div>
                                            <div class="uppy-informer uppy-informer-min">
                                                <div class="uppy uppy-Informer" aria-hidden="true">
                                                    <p role="alert"> </p>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-4">
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-4">
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-md-4 fv-row">
                        <!--begin::Label-->
                        <label class="required fs-6 fw-bold form-label mb-2">Canceled Cheque</label>
                        <!--end::Label-->
                        <!--begin::Row-->
                        <div class="row fv-row">
                            <!--begin::Col-->
                            <div class="col-12">
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label text-lg-right">Upload
                                        File:</label>
                                    <div class="col-lg-6">
                                        <div class="uppy" id="kt_uppy_5">
                                            <div class="uppy-wrapper">
                                                <div class="uppy-Root uppy-FileInput-container"><input
                                                        class="uppy-FileInput-input uppy-input-control"
                                                        style="" type="file" name="files[]"
                                                        multiple=""
                                                        id="kt_uppy_5_input_control"><label
                                                        class="uppy-input-label btn btn-light-primary btn-sm btn-bold"
                                                        for="kt_uppy_5_input_control">Attach files</label>
                                                </div><span class="form-text text-dark">Maximum file size
                                                    1MB</span>
                                            </div>
                                            <div class="uppy-list"></div>
                                            <div class="uppy-status">
                                                <div class="uppy-Root uppy-StatusBar is-waiting"
                                                    aria-hidden="true" dir="ltr">
                                                    <div class="uppy-StatusBar-progress"
                                                        style="width: 0%;" role="progressbar"
                                                        aria-valuemin="0" aria-valuemax="100"
                                                        aria-valuenow="0"></div>
                                                    <div class="uppy-StatusBar-actions"></div>
                                                </div>
                                            </div>
                                            <div class="uppy-informer uppy-informer-min">
                                                <div class="uppy uppy-Informer" aria-hidden="true">
                                                    <p role="alert"> </p>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-4">
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-4">
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="row mb-10">
                    <!--begin::Col-->
                    <div class="col-md-12 mb-7 fv-row">
                        <!--begin::Label-->
                        <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                            <span class="">UAN Details</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Row-->
                        <div class="row fv-row">
                            <!--begin::Col-->
                            <div class="col-4">
                                <input name="business_email"
                                    class="form-control form-control-lg form-control-solid"
                                    placeholder="Number" />
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-4">
                                <input name="business_email"
                                    class="form-control form-control-lg form-control-solid"
                                    placeholder="Start Date" />
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-4">
                                <input name="business_email"
                                    class="form-control form-control-lg form-control-solid"
                                    placeholder="Area" />
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-md-12 fv-row">
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold form-label mb-2">ESI</label>
                        <!--end::Label-->
                        <!--begin::Row-->
                        <div class="row fv-row">
                            <!--begin::Col-->
                            <div class="col-3">
                                <input name="business_email"
                                    class="form-control form-control-lg form-control-solid"
                                    placeholder="Number" />
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-3">
                                <input name="business_email"
                                    class="form-control form-control-lg form-control-solid"
                                    placeholder="Start  Date" />
                            </div>
                            <!--end::Col-->
                            <div class="col-3">
                                <input name="business_email"
                                    class="form-control form-control-lg form-control-solid"
                                    placeholder="End Date" />
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-3">
                                <input name="business_email"
                                    class="form-control form-control-lg form-control-solid"
                                    placeholder="Area" />
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->
                    </div>
                    <!--end::Col-->
                </div>
                <!--begin::Input group-->
                <div class="col-lg-4 mb-5 d-none">
                    <!--begin::Label-->
                    <label class="fs-6 fw-bold form-label required">Contact Email</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input name="business_email" class="form-control form-control-lg form-control-solid"
                        value="corp@support.com" />
                    <!--end::Input-->
                </div>
            </div>
            <!--end::Input group-->
        </div>
        <!--end::Wrapper-->
    </form>
</div>