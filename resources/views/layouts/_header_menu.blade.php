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
<div id="kt_header" style="display:block;height:auto;z-index:990;" class="header align-items-stretch shadow">
    <div class="row p-4">
        <div class="col-md-6">
            <div class="input-group">
                <select name="employee_type" id="employee_type">
                    <option value="">Select Type</option>
                    <option value="staff" selected>Staff</option>
                    <option value="student">Student</option>
                </select>
                <div class="menu-item position-relative">
                    <span class="svg-icon svg-icon-3 svg-icon-gray-500 position-absolute top-50 translate-middle ms-6">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none">
                            <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2"
                                rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                            <path
                                d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                fill="currentColor" />
                        </svg>
                    </span>

                    <input type="text" class="form-control ps-10 w-300px rounded-0" name="global_search"
                        id="global_search" value="" placeholder="Staff Name , Employee Code, Email, Mobile No" />
                    <input type="hidden" name="search_staff_id" id="search_staff_id" value="">
                    <div class="typeahead-pane-search d-none" id="typeadd-search-panel1">
                        <ul type="none" class="typeahead-pane-search-ul" id="typeahead-search-list">
                        </ul>
                    </div>
                </div>
                <button class="btn btn-primary btn-primary" onclick="return gotoStaffOverview()"> View </button>
            </div>
        </div>
        <div class="col-md-6">
            <div class="input-group w-100">
                @php $institute = getAllInstitute();@endphp
                <select name="status" class="form-select" onchange="setGlobalInstitution(this.value)">
                    <option value=""> - Select Institution - </option>
                    @isset($institute)
                        @foreach ($institute as $item)
                            <option value="{{ $item->id }}" @if (session()->get('staff_institute_id') == $item->id) selected @endif>
                                {{ $item->name }}</option>
                        @endforeach
                    @endisset
                </select>
                <select name="status" onchange="return setGlobalAcademicYear(this.value)" class="form-select">
                    @isset($global_academic_year)
                        @foreach ($global_academic_year as $item)
                            <option value="{{ $item->id }}" @if (session()->get('academic_id') == $item->id) selected @endif>
                                {{ $item->from_year . ' - ' . $item->to_year }} </option>
                        @endforeach

                    @endisset
                </select>
                @if (request()->routeIs(['home']))
                    <input type="text" name="search_home_date" id="search_home_date" class="form-control  w-200px">
                @endif
            </div>
        </div>
    </div> 
</div>
