`   <div class="card shadow-none rounded-0 w-100">
    <!--begin::Header-->
    <div class="card-header" id="kt_help_header">
        <h5 class="card-title fw-bold text-gray-600">Add your Certificate Request
        </h5>
        <div class="card-toolbar">
            <button type="button" class="btn btn-sm btn-icon explore-btn-dismiss me-n5" id="kt_help_close">
                <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                <span class="svg-icon svg-icon-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none">
                        <rect opacity="0.5" x="6" y="17.3137" width="16" height="2"
                            rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                        <rect x="7.41422" y="6" width="16" height="2" rx="1"
                            transform="rotate(45 7.41422 6)" fill="currentColor" />
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
                <!--begin::Label-->
                <label class="form-label required">Certificate Type</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input name="business_name" class="form-control form-control-lg form-control-solid" />
                <!--end::Input-->
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="col-lg-6 mb-5">
                <!--begin::Label-->
                <label class="form-label required">Date of request</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input name="business_name" class="form-control form-control-lg form-control-solid" />
                <!--end::Input-->
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="col-lg-6 mb-5">
                <!--begin::Label-->
                <label class="form-label required">Purpose</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input name="business_name" class="form-control form-control-lg form-control-solid" />
                <!--end::Input-->
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="col-lg-6 mb-5">
                <!--begin::Label-->
                <label class="form-label required">Date of issue</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input name="business_name" class="form-control form-control-lg form-control-solid" />
                <!--end::Input-->
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="col-lg-6 mb-5">
                <!--begin::Label-->
                <label class="form-label required">Date of return</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input name="business_name" class="form-control form-control-lg form-control-solid" />
                <!--end::Input-->
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="col-lg-6 mb-5">
                <!--begin::Label-->
                <label class="form-label required">Remarks</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input name="business_name" class="form-control form-control-lg form-control-solid" />
                <!--end::Input-->
            </div>
            <!--end::Input group-->




            <!--begin::Input group-->
            <div class="col-lg-6 mb-5">
                <div class="form-group row">
                    <label class="col-lg-12 col-form-label text-lg-right">Upload
                        File:</label>
                    <div class="col-lg-12">
                        <div class="uppy" id="kt_uppy_5">
                            <div class="uppy-wrapper">
                                <div class="uppy-Root uppy-FileInput-container">
                                    <input class="uppy-FileInput-input uppy-input-control" style=""
                                        type="file" name="files[]" multiple=""
                                        id="kt_uppy_5_input_control"><label
                                        class="uppy-input-label btn btn-light-primary btn-sm btn-bold"
                                        for="kt_uppy_5_input_control">Attach
                                        files</label>
                                </div><span class="form-text text-dark">Maximum file size
                                    1MB</span>
                            </div>
                            <div class="uppy-list"></div>
                            <div class="uppy-status">
                                <div class="uppy-Root uppy-StatusBar is-waiting" aria-hidden="true"
                                    dir="ltr">
                                    <div class="uppy-StatusBar-progress" style="width: 0%;" role="progressbar"
                                        aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"></div>
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
            <!--end::Input group-->



            <div class="d-flex flex-stack pt-5">
                <!--begin::Wrapper-->
                <div>
                    <button type="button" class="btn btn-primary"
                        data-kt-stepper-action="submit">
                        <span class="indicator-label">Add
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                            <span class="svg-icon svg-icon-3 ms-2 me-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none">
                                    <rect opacity="0.5" x="18" y="13" width="13"
                                        height="2" rx="1" transform="rotate(-180 18 13)"
                                        fill="currentColor"></rect>
                                    <path
                                        d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                                        fill="currentColor"></path>
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>
                <!--end::Wrapper-->
            </div>
        </div>

    </div>
    <!--end::Body-->
</div>