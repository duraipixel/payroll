<div id="kt_header" style="z-index:auto" class="header align-items-stretch">
    <!--begin::Container-->
    <div class="container-fluid d-flex align-items-stretch justify-content-between">
        <!--begin::Aside mobile toggle-->
        @yield('breadcrum')
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
                {{-- <div class="menu menu-lg-rounded menu-lg-row menu-state-bg menu-title-gray-700 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-400 fw-bold my-5 my-lg-0 align-items-stretch"
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
                </div> --}}
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
                    <select name="status" onchange="return setGlobalAcademicYear(this.value)" class="form-control form-select form-select-sm border-body bg-body w-150px me-5">
                        @isset($global_academic_year)
                            @foreach ($global_academic_year as $item)
                            <option value="{{ $item->id }}" @if( session()->get('academic_id') == $item->id ) selected @endif> {{ $item->from_year.' - '.$item->to_year }} </option>        
                            @endforeach
                            
                        @endisset
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