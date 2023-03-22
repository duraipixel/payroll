<div data-kt-stepper-element="content">
    <!--begin::Wrapper-->
    <div class="w-100">

        <!--begin::Tables Widget 13-->

        <div class="pb-0 pb-lg-0 mt-0">
            <!--begin::Title-->
            <h2 class="fw-bolder text-dark">Family Information</h2>
            <!--end::Title-->
        </div>
        <div class="tble-fnton card mt-0 mb-5 mb-xl-8">
            <!--begin::Header-->
            <div class="card-header border-0 pt-0">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bolder fs-3 mb-1">Family Details</span>
                </h3>

                <button onclick="return openFamilyForm()"
                    class="btn btn-flex h-35px bg-body btn-color-gray-700 btn-active-color-gray-900 shadow-sm fs-6 px-4 rounded-top-0 mt-5"
                    title="Click Here to add More" data-bs-toggle="tooltip" data-bs-placement="left"
                    data-bs-dismiss="click" data-bs-trigger="hover">
                    <span id="kt_engage_demos_label"><span class="svg-icon svg-icon-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2"
                                    rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor">
                                </rect>
                                <rect x="4.36396" y="11.364" width="16" height="2" rx="1"
                                    fill="currentColor"></rect>
                            </svg>
                        </span> Add New</span>
                </button>
                <button id="kt_new_family_toggle" style="display:none"
                    class="engage-demos-toggle btn btn-flex h-35px bg-body btn-color-gray-700 btn-active-color-gray-900 shadow-sm fs-6 px-4 rounded-top-0 mt-5"
                    title="Click Here to add More" data-bs-toggle="tooltip" data-bs-placement="left"
                    data-bs-dismiss="click" data-bs-trigger="hover">
                </button>

            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body py-3" id="family-list-pane">
                <!--begin::Table container-->
                @include('pages.staff.registration.family.family_list')
                <!--end::Table container-->
            </div>
            <!--begin::Body-->
        </div>
        <!--end::Tables Widget 13-->

        <!--begin::Pricing-->
        <div class="card card-flush py-0">
            <!--begin::Card header-->
            <div class="pt-10">
                <div class="card-title">
                    <h2>AEWS Details</h2>
                </div>
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="pt-5">

                <!--begin::Input group-->
                <div class="fv-row mb-10">
                    <!--begin::Label-->
                    <label class="fs-6 fw-bold mb-2">Are you in AEWS? whether concession is required
                        ?
                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                            title="Select a discount type that will be applied to this product"></i></label>
                    <!--End::Label-->
                    <!--begin::Row-->
                    <div class="row row-cols-1 row-cols-md-3 row-cols-lg-1 row-cols-xl-3 g-9" data-kt-buttons="true"
                        data-kt-buttons-target="[data-kt-button='true']">
                        <!--begin::Col-->
                        <div class="col">
                            <!--begin::Option-->
                            <label
                                class="btn btn-outline btn-outline-dashed btn-outline-default active d-flex text-start p-6"
                                data-kt-button="true">
                                <!--begin::Radio-->
                                <span
                                    class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                                    <input class="form-check-input" type="radio" name="discount_option" value="1"
                                        checked="checked" />
                                </span>
                                <!--end::Radio-->
                                <!--begin::Info-->
                                <span class="ms-5">
                                    <span class="fs-4 fw-bolder text-gray-800 d-block">Yes
                                        Needed</span>
                                </span>
                                <!--end::Info-->
                            </label>
                            <!--end::Option-->
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col">
                            <!--begin::Option-->
                            <label class="btn btn-outline btn-outline-dashed btn-outline-default d-flex text-start p-6"
                                data-kt-button="true">
                                <!--begin::Radio-->
                                <span
                                    class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                                    <input class="form-check-input" type="radio" name="discount_option"
                                        value="2" />
                                </span>
                                <!--end::Radio-->
                                <!--begin::Info-->
                                <span class="ms-5">
                                    <span class="fs-4 fw-bolder text-gray-800 d-block">No,
                                        Thanks.</span>
                                </span>
                                <!--end::Info-->
                            </label>
                            <!--end::Option-->
                        </div>
                        <!--end::Col-->

                    </div>
                    <!--end::Row-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="mb-10 fv-row" id="kt_ecommerce_add_product_discount_percentage">


                    <div class="row">
                        <!--begin::Input group-->
                        <div class="col-lg-1 mb-5">
                            <!--begin::Label-->
                            <label class="form-label"></label>
                            <span class="fs-4 pt-5 fw-bolder text-gray-800 d-block">Anual fees</span>
                            <!--end::Label-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="col-lg-2 mb-5">
                            <!--begin::Label-->
                            <label class="form-label">Amount</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input name="business_name" class="form-control form-control-lg form-control-solid"
                                placeholder="10000" readonly="" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="col-lg-1 mb-5">
                            <!--begin::Label-->
                            <label class="form-label required">Concession %</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input name="business_name" class="form-control form-control-lg form-control-solid" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="col-lg-2 mb-5">
                            <!--begin::Label-->
                            <label class="form-label required">Amount after Concession</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input name="business_name" class="form-control form-control-lg form-control-solid" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                    </div>


                    <div class="row">
                        <!--begin::Input group-->
                        <div class="col-lg-1 mb-5">
                            <!--begin::Label-->
                            <span class="fs-4 pt-3 fw-bolder text-gray-800 d-block">Exam fees</span>
                            <!--end::Label-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="col-lg-2 mb-5">
                            <!--begin::Label-->
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input name="business_name" class="form-control form-control-lg form-control-solid"
                                placeholder="15000" readonly="" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="col-lg-1 mb-5">
                            <!--begin::Label-->
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input name="business_name" class="form-control form-control-lg form-control-solid" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="col-lg-2 mb-5">
                            <!--begin::Label-->
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input name="business_name" class="form-control form-control-lg form-control-solid" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                    </div>


                    <div class="row">
                        <!--begin::Input group-->
                        <div class="col-lg-1 mb-5">
                            <!--begin::Label-->
                            <span class="fs-4 pt-3 fw-bolder text-gray-800 d-block">Lab fees</span>
                            <!--end::Label-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="col-lg-2 mb-5">
                            <!--begin::Label-->
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input name="business_name" class="form-control form-control-lg form-control-solid"
                                placeholder="10000" readonly="" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="col-lg-1 mb-5">
                            <!--begin::Label-->
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input name="business_name" class="form-control form-control-lg form-control-solid" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="col-lg-2 mb-5">
                            <!--begin::Label-->
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input name="business_name" class="form-control form-control-lg form-control-solid" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                    </div>


                    <div class="row">
                        <!--begin::Input group-->
                        <div class="col-lg-1 mb-5">
                            <!--begin::Label-->
                            <span class="fs-4 pt-3 fw-bolder text-gray-800 d-block"><b>Total</b></span>
                            <!--end::Label-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="col-lg-2 mb-5">
                            <!--begin::Label-->
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input name="business_name" class="form-control form-control-lg form-control-solid"
                                placeholder="35000" readonly="" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="col-lg-1 mb-5">
                            <!--begin::Label-->
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input name="business_name" class="form-control form-control-lg form-control-solid" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="col-lg-2 mb-5">
                            <!--begin::Label-->
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input name="business_name" class="form-control form-control-lg form-control-solid" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                    </div>


                    <div class="row">
                        <!--begin::Input group-->
                        <div class="col-lg-1 mb-5">
                            <!--begin::Label-->
                            <span class="fs-4 pt-3 fw-bolder text-gray-800 d-block"><b>Remarks</b></span>
                            <!--end::Label-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="col-lg-5 mb-5">
                            <!--begin::Label-->
                            <!--end::Label-->
                            <!--begin::Input-->
                            <!--begin::Input-->
                            <textarea name="business_description" class="form-control form-control-lg form-control-solid" rows="3"></textarea>
                            <!--end::Input-->
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                    </div>


                    <div class="row">
                        <!--begin::Input group-->
                        <div class="col-lg-1 mb-5">
                            <!--begin::Label-->
                            <span class="fs-4 pt-3 fw-bolder text-gray-800 d-block"><b> </b></span>
                            <!--end::Label-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="col-lg-5 mb-5">
                            <!--begin::Label-->
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div class="d-flex mb-4">

                                <a href="#" class="btn btn-sm btn-primary me-3" data-bs-toggle="modal"
                                    data-bs-target="#kt_modal_new_target"><span class="navi-icon">
                                        <i class="la la-print"></i>
                                    </span> Print </a>
                                <a href="#" class="btn btn-sm btn-primary me-3" data-bs-toggle="modal"
                                    data-bs-target="#kt_modal_new_target"><span class="navi-icon">
                                        <i class="la la-upload"></i>
                                    </span> Upload </a>
                                <a href="#" class="btn btn-sm btn-primary me-3" data-bs-toggle="modal"
                                    data-bs-target="#kt_modal_new_target"><span class="navi-icon">
                                        <i class="la la-send"></i>
                                    </span> Send Copy for Approval </a>
                            </div>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                    </div>


                    <div class="row">
                        <!--begin::Input group-->
                        <div class="col-lg-1 mb-5">
                            <!--begin::Label-->
                            <span class="fs-4 pt-3 fw-bolder text-gray-800 d-block"><b>
                                    Status</b></span>
                            <!--end::Label-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="col-lg-5 mb-5">
                            <!--begin::Label-->
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div class="d-flex mb-4">
                                <div class="min-w-165px">
                                    <span class="badge badge-light-success"
                                        style="padding: 1rem 2.5rem;border-radius:1rem;">Approved</span>
                                    <span class="badge badge-light-danger"
                                        style="padding: 1rem 2.5rem;border-radius:1rem;">Rejected</span>
                                    <span class="badge badge-light-warning"
                                        style="padding: 1rem 2.5rem;border-radius:1rem;">Pending</span>
                                </div>
                            </div>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                    </div>


                    <!--begin::Tables Widget 13-->
                    <div class="tble-fnton card mt-10 mb-5 mb-xl-8">
                        <!--begin::Header-->
                        <div class="card-header border-0 pt-0">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bolder fs-3 mb-1">Nominee required</span>
                            </h3>

                            <button onclick="return openNomineeForm()"
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
                                    </span> Add New </span>
                            </button>
                            <button id="kt_new_nominiee_toggle" style="display: none"
                                class="engage-demos-toggle btn btn-flex h-35px bg-body btn-color-gray-700 btn-active-color-gray-900 shadow-sm fs-6 px-4 rounded-top-0 mt-5"
                                title="Click Here to add More" data-bs-toggle="tooltip" data-bs-placement="left"
                                data-bs-dismiss="click" data-bs-trigger="hover">
                            </button>
                          
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body py-3" id="nominee-list-pane">
                            <!--begin::Table container-->
                           
                            <!--end::Table container-->
                        </div>
                        <!--begin::Body-->
                    </div>
                    <!--end::Tables Widget 13-->

                    <!--begin::Tables Widget 13-->
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
                    <!--end::Tables Widget 13-->
                    <!--begin::Heading-->

                </div>
                <!--end::Input group-->
            </div>
            <!--end::Card header-->
        </div>
        <!--end::Pricing-->
    </div>
    <!--end::Wrapper-->
</div>
<!--begin::Help drawer-->
<div id="kt_help" class="bg-body" data-kt-drawer="true" data-kt-drawer-name="help" data-kt-drawer-activate="true"
    data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'350px', 'md': '725px'}"
    data-kt-drawer-direction="end" data-kt-drawer-toggle="#kt_new_family_toggle"
    data-kt-drawer-close="#kt_help_close">
    @include('pages.staff.registration.family.family_form')
</div>
<!--end::Help drawer-->

  <!--begin::Help drawer-->
  <div id="kt_help" class="bg-body" data-kt-drawer="true" data-kt-drawer-name="help"
  data-kt-drawer-activate="true" data-kt-drawer-overlay="true"
  data-kt-drawer-width="{default:'350px', 'md': '725px'}" data-kt-drawer-direction="end"
  data-kt-drawer-toggle="#kt_new_nominiee_toggle" data-kt-drawer-close="#kt_help_close">
  <!--begin::Card-->
  @include('pages.staff.registration.nominee.nominee_form')
  <!--end::Card-->
</div>
<!--end::Help drawer-->
<script>
    function openFamilyForm() {
        $('#kt_new_family_toggle').click();

        setTimeout(() => {
            $('#family-form-title').html('Add Your Family Details');
            $('#family_member_name').val('');
            $('#dob').val('');
            $('#gender').val('');
            $('#age').val('');
            $('#staff_relationship_id').val('').trigger('change');
            $('#qualification_id').val('').trigger('change');
            $('#premises').val('');
            $('#family_contact_no').val('');
            $('#blood_group_id').val('').trigger('change');
            $('#family_nationality').val('').trigger('change');
            $('#family_remarks').val('');
            $('#relation_register_no').val('');
            $('#relation_standard').val('');
            $('#family_residential_address').val('');
            $('#occupation_address').val('');

        }, 100);

        event.preventDefault();
    }

    function editFamilyForm(staff_id, family_id) {
        $('#kt_new_family_toggle').click();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('form.family.content') }}",
            type: "POST",
            data: {
                family_id: family_id
            },
            success: function(res) {

                $('#family_form').html(res);
                $('#family-form-title').html('Update Your Family Details');
            }
        })
    }

    function deleteFamilyForm(staff_id, family_id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('staff.family.delete') }}",
                    type: "POST",
                    data: {
                        family_id: family_id
                    },
                    success: function(res) {

                        staffFamilyMemberList(staff_id);

                        Swal.fire(
                            'Deleted!',
                            'Your Duty data has been deleted.',
                            'success'
                        )
                    }
                })

            }
        })
    }

    function submitFamilyMemberForm() {
        var memberFormErrors = false;
        let key_name = [
            'staff_relationship_id',
            'family_member_name',
            'dob',
            'gender',
            'age',
            'qualification_id',
            'family_contact_no',
            'blood_group_id',
            'family_nationality'
        ];
        $('.family-form-errors').remove();
        $('.form-control,.form-select').removeClass('border-danger');

        key_name.forEach(element => {
            var name_input = document.getElementById(element).value;

            if (name_input == '' || name_input == undefined) {
                memberFormErrors = true;
                var name_input_error =
                    '<div class="fv-plugins-message-container family-form-errors invalid-feedback"><div data-validator="notEmpty">' +
                    element.replace('_', ' ').toUpperCase() + ' is required</div></div>';
                // $('#' + element).after(name_input_error);
                $('#' + element).addClass('border-danger')
                $('#' + element).focus();
            }
        });

        if (!memberFormErrors) {
            var staff_id = $('#outer_staff_id').val();
            var forms = $('#family_form')[0];
            var formData = new FormData(forms);
            formData.append('staff_id', staff_id);
            $.ajax({
                url: "{{ route('staff.member.save') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    // Disable submit button whilst loading
                    if (res.error == 1) {
                        if (res.message) {
                            res.message.forEach(element => {
                                toastr.error("Error",
                                    element);
                            });
                        }
                    } else {
                        toastr.success(
                            "Family Member Details added successfully"
                        );
                        $('#kt_help_close').click();
                        staffFamilyMemberList(staff_id);
                    }
                }
            })
        }
    }


    function staffFamilyMemberList(staff_id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('staff.member.list') }}",
            type: "POST",
            data: {
                staff_id: staff_id
            },
            success: function(res) {
                $('#family-list-pane').html(res);
            }
        })
    }



    function validateFamilyPhase() {
        event.preventDefault();
        var emp_position_errors = false;

        var key_name = [
            'designation_id',
            'department_id',
            'subject',
            'scheme_id',
            'nationality_id',
            'religion_id',
            'caste_id',

        ];

        $('.kyc-form-errors').remove();
        $('.form-control,.form-select').removeClass('border-danger');

        const pattern = /_/gi;
        const replacement = " ";

        key_name.forEach(element => {
            var name_input = document.getElementById(element).value;

            if (name_input == '' || name_input == undefined) {

                emp_position_errors = true;
                var elementValues = element.replace(pattern, replacement);
                var name_input_error =
                    '<div class="fv-plugins-message-container kyc-form-errors invalid-feedback"><div data-validator="notEmpty">' +
                    elementValues.toUpperCase() + ' is required</div></div>';
                // $('#' + element).after(name_input_error);
                $('#' + element).addClass('border-danger')
                $('#' + element).focus();
            }
        });

        if (!emp_position_errors) {

            var forms = $('#position_form')[0];
            var formData = new FormData(forms);
            $.ajax({
                url: "{{ route('staff.save.employee_position') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                async: false,
                beforeSend: function() {
                    loading();
                },
                success: function(res) {
                    unloading();

                    if (res.error == 1) {
                        if (res.message) {
                            res.message.forEach(element => {
                                toastr.error("Error", element);
                            });
                        }
                        // console.log('form erorro occurres');
                        return true;

                    } else {
                        event.preventDefault();
                        console.log('form submit success');
                        return false;
                    }
                    console.log('resoponse recevied');
                }
            })
        } else {

            return true;
        }
    }
</script>
