<div id="kt_header" style="" class="header align-items-stretch">
    <!--begin::Container-->
    <div class="container-fluid d-flex align-items-stretch justify-content-between">
        <!--begin::Aside mobile toggle-->
        <div class="d-flex align-items-center d-lg-none ms-n2 me-2" title="Show aside menu">
            <div class="btn btn-icon btn-active-light-primary w-30px h-30px w-md-40px h-md-40px"
                id="kt_aside_mobile_toggle">
                <!--begin::Svg Icon | path: icons/duotune/abstract/abs015.svg-->
                <span class="svg-icon svg-icon-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none">
                        <path
                            d="M21 7H3C2.4 7 2 6.6 2 6V4C2 3.4 2.4 3 3 3H21C21.6 3 22 3.4 22 4V6C22 6.6 21.6 7 21 7Z"
                            fill="currentColor" />
                        <path opacity="0.3"
                            d="M21 14H3C2.4 14 2 13.6 2 13V11C2 10.4 2.4 10 3 10H21C21.6 10 22 10.4 22 11V13C22 13.6 21.6 14 21 14ZM22 20V18C22 17.4 21.6 17 21 17H3C2.4 17 2 17.4 2 18V20C2 20.6 2.4 21 3 21H21C21.6 21 22 20.6 22 20Z"
                            fill="currentColor" />
                    </svg>
                </span>
                <!--end::Svg Icon-->
            </div>
        </div>
        <!--end::Aside mobile toggle-->
        <!--begin::Mobile logo-->
        <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
            <a href="../index.html" class="d-lg-none">
                <img alt="Logo" src="{{ asset('assets/media/logos/favicon.ico') }}" class="h-30px" />
            </a>
        </div>
        <!--end::Mobile logo-->
        <!--begin::Wrapper-->
        <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1">
            <!--begin::Navbar-->
            <!--begin::Menu wrapper-->
            <div class="col-6 header-menu align-items-stretch" data-kt-drawer="true"
                data-kt-drawer-name="header-menu" data-kt-drawer-activate="{default: true, lg: false}"
                data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}"
                data-kt-drawer-direction="end" data-kt-drawer-toggle="#kt_header_menu_mobile_toggle"
                data-kt-swapper="true" data-kt-swapper-mode="prepend"
                data-kt-swapper-parent="{default: '#kt_body', lg: '#kt_header_nav'}">
                <!--begin::Menu-->
                <div class="menu menu-lg-rounded menu-lg-row menu-state-bg menu-title-gray-700 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-400 fw-bold my-5 my-lg-0 align-items-stretch"
                    id="#kt_header_menu" data-kt-menu="true">
                    <div class="menu-item d-flex my-0">
                        <!--begin::Select-->
                        <select name="status" data-control="select2" data-hide-search="true"
                            data-placeholder="Filter"
                            class="form-select form-select-sm border-body bg-body w-200px me-5">
                            <option value="1">Select Type</option>
                            <option value="2">Student</option>
                            <option value="3">Staff</option>
                        </select>
                        <!--end::Select-->
                    </div>

                    <div class="menu-item position-relative">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                        <span
                            class="svg-icon svg-icon-3 svg-icon-gray-500 position-absolute top-50 translate-middle ms-6">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546"
                                    height="2" rx="1"
                                    transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                <path
                                    d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                    fill="currentColor" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                        <input type="text" class="form-control form-control-solid ps-10"
                            name="search" value="" placeholder="Search" />
                    </div>
                </div>
            </div>
            <!--end::Menu-->
            <!--begin::Menu-->
            <div class="col-6 menu menu-lg-rounded menu-lg-row menu-state-bg menu-title-gray-700 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-400 fw-bold my-5 my-lg-0 align-items-stretch justify-content-end"
                id="#kt_header_menu" data-kt-menu="true">
                <div class="menu-item d-flex my-0">
                    <!--end::Select-->
                    <!--begin::Select-->
                    <select name="status" data-control="select2" data-hide-search="true"
                        data-placeholder="Export"
                        class="form-select form-select-sm border-body bg-body w-200px">
                        <option value="1">Instution Type</option>
                        <option value="1">Amalarpavam</option>
                        <option value="3">Amalarpavam CBSE</option>
                    </select>
                    <!--end::Select-->
                </div>

                <div class="menu-item d-flex my-0">
                    <!--begin::Select-->
                    <select name="status" data-control="select2" data-hide-search="true"
                        data-placeholder="Filter"
                        class="form-select form-select-sm border-body bg-body w-150px me-5">
                        <option value="1">Academic year</option>
                        <option value="2">2016 - 2017</option>
                        <option value="3">2017 - 2018</option>
                        <option value="4">2019 - 2020</option>
                        <option value="5">2021 - 2022</option>
                        <option value="6">2022 - 2023</option>
                    </select>
                    <!--end::Select-->
                </div>

            </div>
            <!--end::Menu wrapper-->
        </div>
        <!--end::Navbar-->

    </div>
    <!--end::Wrapper-->
</div>