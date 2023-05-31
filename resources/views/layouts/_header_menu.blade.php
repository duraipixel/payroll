<style>
    .typeahead-pane-search {
        position: absolute;
        width: 100%;
        background: #ffffff;
        margin: 0;
        padding: 0;
        border-radius: 6px;
        box-shadow: 1px 2px 3px 2px #ddd;
        z-index: 1;
        top: 56px;
    }

    .typeahead-pane-search-ul {
        width: 100%;
        padding: 0;
        height: 400px;
        overflow-y: auto;
    }

    .typeahead-pane-li {
        padding: 8px 15px;
        width: 100%;
        margin: 0;
        border-bottom: 1px solid #2e3d4638;
    }

    .typeahead-pane-li:hover {
        background: #3a81bf;
        color: white;
        cursor: pointer;
    }
</style>
<div id="kt_header" style="display:block;height:auto;z-index:990;" class="header align-items-stretch">
    <div class="container-fluid d-flex align-items-stretch justify-content-between">
        <div class="menu menu-lg-rounded menu-lg-row menu-state-bg menu-title-gray-700 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-400 fw-bold my-5 my-lg-0 align-items-stretch"
            id="#kt_header_menu" data-kt-menu="true">
            <div class="menu-item d-flex my-0 custom_select w-200px py-3">
                <select name="employee_type" id="employee_type"
                    class="form-select form-select-sm border-body bg-body w-200px me-5">
                    <option value="">Select Type</option>
                    <option value="staff" selected>Staff</option>
                    <option value="student">Student</option>
                </select>
            </div>

            <div class="menu-item position-relative">
                <span class="svg-icon svg-icon-3 svg-icon-gray-500 position-absolute top-50 translate-middle ms-9">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none">
                        <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1"
                            transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                        <path
                            d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                            fill="currentColor" />
                    </svg>
                </span>

                <input type="text" class="form-control ps-10 mx-3 w-400px" name="global_search" id="global_search"
                    value="" placeholder="Staff Name , Employee Code, Email, Mobile No" />
                <input type="hidden" name="search_staff_id" id="search_staff_id" value="">
                <div class="typeahead-pane-search d-none" id="typeadd-search-panel1">
                    <ul type="none" class="typeahead-pane-search-ul" id="typeahead-search-list">
                    </ul>
                </div>
                <button class="btn btn-primary btn-light-primary" onclick="return gotoStaffOverview()"> View </button>
            </div>
        </div>

        <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
            <a href="../index.html" class="d-lg-none">
                <img alt="Logo" src="{{ asset('assets/media/logos/favicon.ico') }}" class="h-30px" />
            </a>
        </div>

        <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1">

            <div class="col-6 header-menu align-items-stretch" data-kt-drawer="true" data-kt-drawer-name="header-menu"
                data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
                data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="end"
                data-kt-drawer-toggle="#kt_header_menu_mobile_toggle" data-kt-swapper="true"
                data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_body', lg: '#kt_header_nav'}">

            </div>

            <div class="col-6 menu menu-lg-rounded menu-lg-row menu-state-bg menu-title-gray-700 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-400 fw-bold my-5 my-lg-0 align-items-stretch justify-content-end"
                id="#kt_header_menu" data-kt-menu="true">
                <div class="menu-item d-flex my-0">

                    @php
                        $institute = getAllInstitute();
                    @endphp
                    <select name="status" class="form-select form-select-sm border-body bg-body w-200px"
                        onchange="setGlobalInstitution(this.value)">
                        <option value=""> - Select Institution - </option>
                        @isset($institute)
                            @foreach ($institute as $item)
                                <option value="{{ $item->id }}" @if (session()->get('staff_institute_id') == $item->id) selected @endif>
                                    {{ $item->name }}</option>
                            @endforeach
                        @endisset
                    </select>

                </div>

                <div class="menu-item d-flex my-0">

                    <select name="status" onchange="return setGlobalAcademicYear(this.value)"
                        class="form-control form-select form-select-sm border-body bg-body w-150px me-5">
                        @isset($global_academic_year)
                            @foreach ($global_academic_year as $item)
                                <option value="{{ $item->id }}" @if (session()->get('academic_id') == $item->id) selected @endif>
                                    {{ $item->from_year . ' - ' . $item->to_year }} </option>
                            @endforeach

                        @endisset
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid d-flex align-items-stretch justify-content-between py-3">
        @yield('breadcrum')
        <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
            <a href="../index.html" class="d-lg-none">
                <img alt="Logo" src="{{ asset('assets/media/logos/favicon.ico') }}" class="h-30px" />
            </a>
        </div>
        <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1">
            <div class="col-6 header-menu align-items-stretch" data-kt-drawer="true" data-kt-drawer-name="header-menu"
                data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
                data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="end"
                data-kt-drawer-toggle="#kt_header_menu_mobile_toggle" data-kt-swapper="true"
                data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_body', lg: '#kt_header_nav'}">

            </div>
            <div class="col-3">
                @if (request()->routeIs(['home']))
                    <input type="text" name="search_home_date" id="search_home_date" class="form-control h-35px">
                @endif
                {{-- <div class="menu-item d-flex my-0">
                   
                    @php
                        $institute = getAllInstitute();
                    @endphp
                    <select name="status" class="form-select form-select-sm border-body bg-body w-200px"
                        onchange="setGlobalInstitution(this.value)">
                        <option value=""> - Select Institution - </option>
                        @isset($institute)
                            @foreach ($institute as $item)
                                <option value="{{ $item->id }}" @if (session()->get('staff_institute_id') == $item->id) selected @endif>
                                    {{ $item->name }}</option>
                            @endforeach
                        @endisset
                    </select>
                </div>

                <div class="menu-item d-flex my-0">

                    <select name="status" onchange="return setGlobalAcademicYear(this.value)"
                        class="form-control form-select form-select-sm border-body bg-body w-150px me-5">
                        @isset($global_academic_year)
                            @foreach ($global_academic_year as $item)
                                <option value="{{ $item->id }}" @if (session()->get('academic_id') == $item->id) selected @endif>
                                    {{ $item->from_year . ' - ' . $item->to_year }} </option>
                            @endforeach

                        @endisset
                    </select>
                </div> --}}
            </div>
        </div>
    </div>
</div>
