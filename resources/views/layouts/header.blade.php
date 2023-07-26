<div id="kt_header" class="header align-items-stretch maa-header" style="z-index:9 !important;">
    <div class="container-fluid d-flex align-items-center justify-content-center px-3">
        <div class="input-group">
            <div id="kt_aside_toggle" class="btn btn-primary btn-icon" data-kt-toggle="true"
                data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="aside-minimize">
                <span class="svg-icon svg-icon-1 rotate-180">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none">
                        <path opacity="0.5"
                            d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z"
                            fill="currentColor" />
                        <path
                            d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z"
                            fill="currentColor" />
                    </svg>
                </span>
            </div>
            {{-- <h1 class="h3 m-0 lead text-dark fw-bold form-control border-0">AMALORPAVAM PAYROLL SYSTEM v1.0</h1> --}}
            @php $institute = getAllInstitute();@endphp
            <select name="status" class="form-select" onchange="setGlobalInstitution(this.value)">
                {{-- <option value=""> - Select Institution - </option> --}}
                @isset($institute)
                    @foreach ($institute as $item)
                        <option value="{{ $item->id }}" @if (session()->get('staff_institute_id') == $item->id) selected @endif>
                            {{ $item->name }}</option>
                    @endforeach
                @endisset
            </select>
            <select name="academic_year" id="academic_year" onchange="return setGlobalAcademicYear(this.value)" class="form-select">
                @if(getGlobalAcademicYear())
                    @foreach (getGlobalAcademicYear() as $item)
                        <option value="{{ $item->id }}" @if (session()->get('academic_id') == $item->id) selected @endif>
                            {{ $item->from_year . ' - ' . $item->to_year }} </option>
                    @endforeach
                @endif
            </select>
            @if (request()->routeIs(['home']))
                <input type="text" name="search_home_date" id="search_home_date"  class="border outline-0 px-3">
            @endif
            <div class="btn p-0 px-2 btn-light d-flex align-items-center justify-content-center">
                <div>
                    <div class="cursor-pointer symbol symbol-30px symbol-md-30px" data-kt-menu-trigger="click"
                        data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                        @if (isset(auth()->user()->image) && !empty(auth()->user()->image))
                            <img alt="user" src="{{ asset('/') . auth()->user()->image }}" />
                        @else
                            <img alt="user" src="https://cdn-icons-png.flaticon.com/512/149/149071.png" />
                        @endif
                    </div>
                    <!--begin::User account menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-primary fw-bold py-4 fs-6 w-275px"
                        data-kt-menu="true">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <div class="menu-content d-flex align-items-center px-3">
                                <!--begin::Avatar-->
                                <div class="symbol symbol-50px me-5">

                                    @if (isset(auth()->user()->image) && !empty(auth()->user()->image))
                                        <img alt="Logo" src="{{ asset('/') . auth()->user()->image }}" />
                                    @else
                                        <img alt="Logo"
                                            src="https://cdn-icons-png.flaticon.com/512/149/149071.png" />
                                    @endif
                                </div>
                                <!--end::Avatar-->
                                <!--begin::Username-->
                                <div class="d-flex flex-column">
                                    <div class="fw-bolder d-flex align-items-center fs-5 text-black">
                                        {{ auth()->user()->name ?? '' }}

                                    </div>
                                    <a href="#"
                                        class="fw-bold text-muted text-hover-primary fs-7">{{ auth()->user()->email ?? '' }}</a>
                                </div>
                                <!--end::Username-->
                            </div>
                        </div>

                        <div class="separator my-2"></div>

                        {{-- <div class="menu-item px-5">
                        <a href="" class="menu-link px-5">My Profile</a>
                    </div>
                    <div class="separator my-2"></div>
                    <div class="menu-item px-5 my-1">
                        <a href="" class="menu-link px-5">Change Password</a>
                    </div> --}}
                        <div class="menu-item px-5">
                            <a href="{{ route('logout') }}" class="menu-link px-5"
                                onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">Sign
                                Out</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
