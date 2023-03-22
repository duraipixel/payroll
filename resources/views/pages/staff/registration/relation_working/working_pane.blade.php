<div class="tble-fnton card mt-10 mb-5 mb-xl-8">
    <!--begin::Header-->
    <div class="card-header border-0 pt-0">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bolder fs-3 mb-1">Relation working in
                AEWS</span>
        </h3>

        <button id="kt_new_aews_toggle"
            class="engage-demos-toggle btn btn-flex h-35px bg-body btn-color-gray-700 btn-active-color-gray-900 shadow-sm fs-6 px-4 rounded-top-0 mt-5"
            title="Click Here to add More" data-bs-toggle="tooltip" data-bs-placement="left"
            data-bs-dismiss="click" data-bs-trigger="hover">
            <span id="kt_engage_demos_label"><span class="svg-icon svg-icon-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none">
                        <rect opacity="0.5" x="11.364" y="20.364" width="16"
                            height="2" rx="1" transform="rotate(-90 11.364 20.364)"
                            fill="currentColor"></rect>
                        <rect x="4.36396" y="11.364" width="16" height="2"
                            rx="1" fill="currentColor"></rect>
                    </svg>
                </span> Add New</span>
        </button>
        <!--begin::Help drawer-->
        <div id="kt_help" class="bg-body" data-kt-drawer="true" data-kt-drawer-name="help"
            data-kt-drawer-activate="true" data-kt-drawer-overlay="true"
            data-kt-drawer-width="{default:'350px', 'md': '725px'}" data-kt-drawer-direction="end"
            data-kt-drawer-toggle="#kt_new_aews_toggle" data-kt-drawer-close="#kt_help_close">
            <!--begin::Card-->
            <div class="card shadow-none rounded-0 w-100">
                <!--begin::Header-->
                <div class="card-header" id="kt_help_header">
                    <h5 class="card-title fw-bold text-gray-600">Add your
                        Relation working in AEWS</h5>
                    <div class="card-toolbar">
                        <button type="button"
                            class="btn btn-sm btn-icon explore-btn-dismiss me-n5"
                            id="kt_help_close">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none">
                                    <rect opacity="0.5" x="6" y="17.3137"
                                        width="16" height="2" rx="1"
                                        transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                    <rect x="7.41422" y="6" width="16"
                                        height="2" rx="1"
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
                            <label class="form-label required">Relation
                                Name</label>
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
                            <label class="form-label required">Relationship
                                Type</label>
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
                            <label class="form-label required">Emp Code</label>
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
                            <label class="form-label required">Institution</label>
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
                            <label class="form-label required">Place of
                                Work</label>
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
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                height="24" viewBox="0 0 24 24"
                                                fill="none">
                                                <rect opacity="0.5" x="18"
                                                    y="13" width="13" height="2"
                                                    rx="1" transform="rotate(-180 18 13)"
                                                    fill="currentColor"></rect>
                                                <path
                                                    d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                                                    fill="currentColor"></path>
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <span class="indicator-progress">Please
                                        wait...
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
            <table class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3">
                <!--begin::Table head-->
                <thead>
                    <tr class="fw-bolder text-muted">
                        <th class="min-w-50px">Relation Name</th>
                        <th class="min-w-140px">Relationship </th>
                        <th class="min-w-120px">Emp Code</th>
                        <th class="min-w-120px">Institution</th>
                        <th class="min-w-120px">Place of Work </th>
                        <th class="min-w-100px text-end">Actions</th>
                    </tr>
                </thead>
                <!--end::Table head-->
                <!--begin::Table body-->
                <tbody>
                    <tr>
                        <td class="text-dark fw-bolder text-hover-primary fs-6">
                            John </td>
                        <td class="text-dark fw-bolder text-hover-primary fs-6">
                            Brother</td>
                        <td class="text-dark fw-bolder text-hover-primary fs-6">
                            18/08/1994</td>
                        <td class="text-dark fw-bolder text-hover-primary fs-6">
                            Male</td>
                        <td class="text-dark fw-bolder text-hover-primary fs-6">
                            Male</td>
                        <td class="text-end">
                            <a href="#"
                                class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                                <span class="svg-icon svg-icon-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none">
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
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none">
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