<div id="kt_aside" class="aside aside-dark aside-hoverable" data-kt-drawer="true" data-kt-drawer-name="aside"
    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
    data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start"
    data-kt-drawer-toggle="#kt_aside_mobile_toggle">
    <div class="aside-logo flex-column-auto" id="kt_aside_logo">
        <a href="" class="d-flex py-3 align-items-center">
            <img alt="Logo" src="{{ asset('assets/media/logos/user-logo.png') }}" width="100px" class="me-2" />
            <img alt="Logo" src="{{ asset('assets/media/logos/user-logo-1.png') }}" width="100px" class="ms-2" />
        </a>
    </div>

    <div class="aside-menu flex-column-fluid">
        <!--begin::Aside Menu-->
        <div class="hover-scroll-overlay-y" id="kt_aside_menu_wrapper" data-kt-scroll="true"
            data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto"
            data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-wrappers="#kt_aside_menu"
            data-kt-scroll-offset="0">
            <!--begin::Menu-->
            <div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500"
                id="#kt_aside_menu" data-kt-menu="true">
                <div class="menu-item menu-accordion">
                    <a href="{{ route('home') }}" class="menu-link">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none">
                                    <rect x="2" y="2" width="9" height="9" rx="2"
                                        fill="currentColor" />
                                    <rect opacity="0.3" x="13" y="2" width="9" height="9"
                                        rx="2" fill="currentColor" />
                                    <rect opacity="0.3" x="13" y="13" width="9" height="9"
                                        rx="2" fill="currentColor" />
                                    <rect opacity="0.3" x="2" y="13" width="9" height="9"
                                        rx="2" fill="currentColor" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title">Dashboards</span>
                    </a>

                </div>
                @if (access()->hasAccess(['overview', 'logs', 'account.settings']))
                    <div data-kt-menu-trigger="click"
                        class="menu-item menu-accordion @if (request()->routeIs(['overview', 'logs', 'account.settings'])) hover show @endif">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <!--begin::Svg Icon | path: icons/duotune/communication/com013.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <path
                                            d="M6.28548 15.0861C7.34369 13.1814 9.35142 12 11.5304 12H12.4696C14.6486 12 16.6563 13.1814 17.7145 15.0861L19.3493 18.0287C20.0899 19.3618 19.1259 21 17.601 21H6.39903C4.87406 21 3.91012 19.3618 4.65071 18.0287L6.28548 15.0861Z"
                                            fill="currentColor" />
                                        <rect opacity="0.3" x="8" y="3" width="8" height="8"
                                            rx="4" fill="currentColor" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </span>
                            <span class="menu-title">Account</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div class="menu-sub menu-sub-accordion menu-active-bg">
                            @if (access()->hasAccess('overview', 'view'))
                                <div class="menu-item">
                                    <a class="menu-link @if (request()->routeIs(['overview'])) active @endif"
                                        href="{{ route('overview') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Overview</span>
                                    </a>
                                </div>
                            @endif

                            @if (access()->hasAccess('logs', 'view'))
                                <div class="menu-item">
                                    <a class="menu-link @if (request()->routeIs(['logs'])) active @endif"
                                        href="{{ route('logs') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Logs</span>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
                @if (access()->hasAccess(['role', 'role-mapping', 'user.permission']))
                    <div data-kt-menu-trigger="click"
                        class="menu-item menu-accordion
                @if (request()->routeIs(['user.permission', 'role', 'role-mapping'])) hover show @endif">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <!--begin::Svg Icon | path: icons/duotune/technology/teh004.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <path opacity="0.3"
                                            d="M21 10.7192H3C2.4 10.7192 2 11.1192 2 11.7192C2 12.3192 2.4 12.7192 3 12.7192H6V14.7192C6 18.0192 8.7 20.7192 12 20.7192C15.3 20.7192 18 18.0192 18 14.7192V12.7192H21C21.6 12.7192 22 12.3192 22 11.7192C22 11.1192 21.6 10.7192 21 10.7192Z"
                                            fill="currentColor" />
                                        <path
                                            d="M11.6 21.9192C11.4 21.9192 11.2 21.8192 11 21.7192C10.6 21.4192 10.5 20.7191 10.8 20.3191C11.7 19.1191 12.3 17.8191 12.7 16.3191C12.8 15.8191 13.4 15.4192 13.9 15.6192C14.4 15.7192 14.8 16.3191 14.6 16.8191C14.2 18.5191 13.4 20.1192 12.4 21.5192C12.2 21.7192 11.9 21.9192 11.6 21.9192ZM8.7 19.7192C10.2 18.1192 11 15.9192 11 13.7192V8.71917C11 8.11917 11.4 7.71917 12 7.71917C12.6 7.71917 13 8.11917 13 8.71917V13.0192C13 13.6192 13.4 14.0192 14 14.0192C14.6 14.0192 15 13.6192 15 13.0192V8.71917C15 7.01917 13.7 5.71917 12 5.71917C10.3 5.71917 9 7.01917 9 8.71917V13.7192C9 15.4192 8.4 17.1191 7.2 18.3191C6.8 18.7191 6.9 19.3192 7.3 19.7192C7.5 19.9192 7.7 20.0192 8 20.0192C8.3 20.0192 8.5 19.9192 8.7 19.7192ZM6 16.7192C6.5 16.7192 7 16.2192 7 15.7192V8.71917C7 8.11917 7.1 7.51918 7.3 6.91918C7.5 6.41918 7.2 5.8192 6.7 5.6192C6.2 5.4192 5.59999 5.71917 5.39999 6.21917C5.09999 7.01917 5 7.81917 5 8.71917V15.7192V15.8191C5 16.3191 5.5 16.7192 6 16.7192ZM9 4.71917C9.5 4.31917 10.1 4.11918 10.7 3.91918C11.2 3.81918 11.5 3.21917 11.4 2.71917C11.3 2.21917 10.7 1.91916 10.2 2.01916C9.4 2.21916 8.59999 2.6192 7.89999 3.1192C7.49999 3.4192 7.4 4.11916 7.7 4.51916C7.9 4.81916 8.2 4.91918 8.5 4.91918C8.6 4.91918 8.8 4.81917 9 4.71917ZM18.2 18.9192C18.7 17.2192 19 15.5192 19 13.7192V8.71917C19 5.71917 17.1 3.1192 14.3 2.1192C13.8 1.9192 13.2 2.21917 13 2.71917C12.8 3.21917 13.1 3.81916 13.6 4.01916C15.6 4.71916 17 6.61917 17 8.71917V13.7192C17 15.3192 16.8 16.8191 16.3 18.3191C16.1 18.8191 16.4 19.4192 16.9 19.6192C17 19.6192 17.1 19.6192 17.2 19.6192C17.7 19.6192 18 19.3192 18.2 18.9192Z"
                                            fill="currentColor" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </span>
                            <span class="menu-title">Authentication</span>
                            <span class="menu-arrow"></span>
                        </span>

                        <div class="menu-sub menu-sub-accordion menu-active-bg">
                            @if (access()->hasAccess('role', 'view'))
                                <div class="menu-item">
                                    <a class="menu-link  @if (request()->routeIs(['role'])) active @endif"
                                        href="{{ route('role') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Roles</span>
                                    </a>
                                </div>
                            @endif
                            @if (access()->hasAccess('role-mapping', 'view'))
                                <div class="menu-item">
                                    <a class="menu-link  @if (request()->routeIs(['role-mapping'])) active @endif"
                                        href="{{ route('role-mapping') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Role Mappings</span>
                                    </a>
                                </div>
                            @endif
                            @if (access()->hasAccess('user.permission', 'view'))
                                <div class="menu-item">
                                    <a class="menu-link @if (request()->routeIs(['user.permission'])) active @endif"
                                        href="{{ route('user.permission') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Permissions</span>
                                    </a>
                                </div>
                            @endif

                        </div>
                    </div>
                @endif

                @if (access()->hasAccess(['staff.register', 'staff.list', 'staff.bulk']))
                    <div data-kt-menu-trigger="click"
                        class="menu-item menu-accordion @if (request()->routeIs(['staff.register', 'staff.list', 'staff.bulk'])) hover show @endif">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="fa fa-users"></i>

                            </span>
                            <span class="menu-title">Staff Management</span>
                            <span class="menu-arrow"></span>
                        </span>

                        <div class="menu-sub menu-sub-accordion menu-active-bg">
                            @if (access()->hasAccess('staff.register', 'view'))
                                <div class="menu-item">
                                    <a class="menu-link  @if (request()->routeIs(['staff.register'])) active @endif"
                                        href="{{ route('staff.register') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Register</span>
                                    </a>
                                </div>
                            @endif
                            @if (access()->hasAccess('staff.list', 'view'))
                                <div class="menu-item">
                                    <a class="menu-link  @if (request()->routeIs(['staff.list'])) active @endif"
                                        href="{{ route('staff.list') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Staff List</span>
                                    </a>
                                </div>
                            @endif

                            {{-- <div class="menu-item">
                                <a class="menu-link" href="javascript:void(0)">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Staff Transfer</span>
                                </a>
                            </div> --}}

                            @if (access()->hasAccess('staff.bulk', 'view'))
                                <div class="menu-item">
                                    <a class="menu-link @if (request()->routeIs(['staff.bulk'])) active @endif"
                                        href="{{ route('staff.bulk') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Bulk Upload</span>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
                @if (access()->hasAccess(['announcement']))
                    <div class="menu-item ">
                        <span class="menu-link @if (request()->routeIs(['announcement'])) active @endif">
                            <span class="menu-icon">

                                <i class="fa fa-bullhorn"></i>

                            </span>
                            <span class="menu-title">
                                <a class="text-white" href="{{ route('announcement') }}">
                                    Announcement</span>
                            </a>

                        </span>
                    </div>
                @endif
                @if (access()->hasAccess(['appointment.orders']))
                    <div class="menu-item ">
                        <span class="menu-link @if (request()->routeIs(['appointment.orders'])) active @endif">
                            <span class="menu-icon">
                                <i class="fa fa-file"></i>
                            </span>

                            <span class="menu-title">
                                <a class="text-white" href="{{ route('appointment.orders') }}">
                                    Appointment Orders</span>
                            </a>
                        </span>
                    </div>
                @endif
                {{-- Reporting Structure --}}
                @if (access()->hasAccess(['reporting.list']))
                    <div data-kt-menu-trigger="click"
                        class="menu-item menu-accordion @if (request()->routeIs(['reporting.list'])) hover show @endif">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="fa fa-folder-tree"></i>
                            </span>
                            <span class="menu-title">Reporting Management</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div class="menu-sub menu-sub-accordion menu-active-bg">
                            <div class="menu-item">
                                <a class="menu-link  @if (request()->routeIs(['reporting.list'])) active @endif"
                                    href="{{ route('reporting.list') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Overview</span>
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
                @if (access()->hasAccess(['user.document_locker']))
                    <!-- Document locker Start-->
                    <div data-kt-menu-trigger="click"
                        class="menu-item menu-accordion @if (request()->routeIs(['user.document_locker'])) hover show @endif">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="fa fa-box-open"></i>
                            </span>
                            <span class="menu-title">Document Locker</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div class="menu-sub menu-sub-accordion menu-active-bg">
                            @if (access()->hasAccess('user.document_locker', 'view'))
                                <div class="menu-item">
                                    <a class="menu-link @if (request()->routeIs(['user.document_locker'])) active @endif "
                                        href="{{ route('user.document_locker') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Overview</span>
                                    </a>
                                </div>
                            @endif

                        </div>
                    </div>
                    <!-- Document locker End-->
                @endif


                @if (access()->hasAccess(['att-manual-entry', 'scheme', 'appointment.orders.add']))
                    <div data-kt-menu-trigger="click"
                        class="menu-item menu-accordion @if (request()->routeIs(['att-manual-entry', 'scheme', 'appointment.orders.add'])) hover show @endif">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="fa fa-chalkboard-teacher"></i>
                            </span>
                            <span class="menu-title">Attendance Management</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div class="menu-sub menu-sub-accordion menu-active-bg">
                            <div class="menu-item">
                                <a class="menu-link @if (request()->routeIs(['att-manual-entry'])) active @endif"
                                    href="{{ route('attendance.overview') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Overview</span>
                                </a>
                            </div>
                        </div>
                        <div class="menu-sub menu-sub-accordion menu-active-bg">
                            @if (access()->hasAccess('att-manual-entry', 'view'))
                                <div class="menu-item">
                                    <a class="menu-link @if (request()->routeIs(['att-manual-entry'])) active @endif"
                                        href="{{ route('att-manual-entry') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Attendance Entry</span>
                                    </a>
                                </div>
                            @endif
                        </div>
                        <div class="menu-sub menu-sub-accordion menu-active-bg">
                            @if (access()->hasAccess('scheme', 'view'))
                                <div class="menu-item">
                                    <a class="menu-link @if (request()->routeIs(['scheme', 'appointment.orders.add'])) active @endif"
                                        href="{{ route('scheme') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Attence Schemes</span>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
                @if (access()->hasAccess([
                        'leaves.overview',
                        'leave-mapping',
                        'leave-status',
                        'leave-head',
                        'leaves.list',
                        'holiday',
                        'leaves.set.workingday',
                    ]))
                    <div data-kt-menu-trigger="click"
                        class="menu-item menu-accordion  @if (request()->routeIs([
                                'leave-mapping',
                                'leave-status',
                                'leave-head',
                                'leaves.list',
                                'holiday',
                                'leaves.overview',
                                'leaves.set.workingday',
                            ])) hover show @endif">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="fas fa-bed"></i>
                            </span>
                            <span class="menu-title">Leave Management</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div class="menu-sub menu-sub-accordion menu-active-bg">
                            <div class="menu-item">
                                <a class="menu-link @if (request()->routeIs(['leaves.overview'])) active @endif"
                                    href="{{ route('leaves.overview') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Overview</span>
                                </a>
                            </div>
                        </div>
                        @if (access()->hasAccess('leaves.list', 'view'))
                            <div class="menu-sub menu-sub-accordion menu-active-bg">

                                <div class="menu-item">
                                    <a class="menu-link @if (request()->routeIs(['leaves.list'])) active @endif"
                                        href="{{ route('leaves.list') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Request Leave</span>
                                    </a>
                                </div>
                            </div>
                        @endif
                        @if (access()->hasAccess('leave-status', 'view'))
                            <div class="menu-sub menu-sub-accordion menu-active-bg">
                                <div class="menu-item">
                                    <a class="menu-link @if (request()->routeIs(['leave-status'])) active @endif"
                                        href="{{ route('leave-status') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Leave Status</span>
                                    </a>
                                </div>
                            </div>
                        @endif
                        @if (access()->hasAccess('leave-head', 'view'))
                            <div class="menu-sub menu-sub-accordion menu-active-bg">
                                <div class="menu-item">
                                    <a class="menu-link @if (request()->routeIs(['leave-head'])) active @endif"
                                        href="{{ route('leave-head') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Leave Head</span>
                                    </a>
                                </div>
                            </div>
                        @endif
                        @if (access()->hasAccess('leave-mapping', 'view'))
                            <div class="menu-sub menu-sub-accordion menu-active-bg">
                                <div class="menu-item">
                                    <a class="menu-link @if (request()->routeIs(['leave-mapping'])) active @endif"
                                        href="{{ route('leave-mapping') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Leave Mapping</span>
                                    </a>
                                </div>
                            </div>
                        @endif
                        <div class="menu-sub menu-sub-accordion menu-active-bg">
                            <div class="menu-item">
                                <a class="menu-link @if (request()->routeIs(['leaves.set.workingday'])) active @endif"
                                    href="{{ route('leaves.set.workingday') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Set Working Day</span>
                                </a>
                            </div>
                        </div>
                        {{-- @if (access()->hasAccess('holiday', 'view'))
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        <div class="menu-item">
                            <a class="menu-link @if (request()->routeIs(['holiday'])) active @endif"
                                href="{{ route('holiday') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Holidays</span>
                            </a>
                        </div>
                    </div>
                    @endif --}}

                    </div>
                @endif
                @php
                    $payroll_menu = ['salary-head', 'salary-field', 'salary.creation', 'salary.loan', 'salary.lic', 'professional-tax', 'payroll.overview', 'payroll.list', 'holdsalary', 'salary.revision', 'it.tabulation', 'taxscheme', 'taxsection', 'taxsection-item', 'it', 'other-income', 'it-calculation'];
                @endphp
                @if (access()->hasAccess($payroll_menu))
                    <div data-kt-menu-trigger="click"
                        class="menu-item menu-accordion
                @if (request()->routeIs($payroll_menu)) hover show @endif">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="fas fa-money-check"></i>
                            </span>
                            <span class="menu-title">Payroll Management</span>
                            <span class="menu-arrow"></span>
                        </span>
                        @if (access()->hasAccess('payroll.overview', 'view'))
                            <div class="menu-sub menu-sub-accordion menu-active-bg">
                                <div class="menu-item">
                                    <a class="menu-link  @if (request()->routeIs(['payroll.overview'])) active @endif"
                                        href="{{ route('payroll.overview') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title"> Overview </span>
                                    </a>
                                </div>
                            </div>
                        @endif
                        @if (access()->hasAccess('payroll.list', 'view'))
                            <div class="menu-sub menu-sub-accordion menu-active-bg">
                                <div class="menu-item">
                                    <a class="menu-link  @if (request()->routeIs(['payroll.list'])) active @endif"
                                        href="{{ route('payroll.list') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title"> Payroll </span>
                                    </a>
                                </div>
                            </div>
                        @endif
                        @if (access()->hasAccess('salary.creation', 'view'))
                            <div class="menu-sub menu-sub-accordion menu-active-bg">
                                <div class="menu-item">
                                    <a class="menu-link  @if (request()->routeIs(['salary.creation'])) active @endif"
                                        href="{{ route('salary.creation') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Salary Creation</span>
                                    </a>
                                </div>
                            </div>
                        @endif
                        @if (access()->hasAccess('salary.revision', 'view'))
                            <div class="menu-sub menu-sub-accordion menu-active-bg">
                                <div class="menu-item">
                                    <a class="menu-link  @if (request()->routeIs(['salary.revision'])) active @endif"
                                        href="{{ route('salary.revision') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Salary Approval
                                            {{-- @if(  pendingRevisionCount() )
                                            <small class="badge badge-circlebadge badge-danger badge-circle fs-15 mx-2">{{pendingRevisionCount()}}</small>
                                            @endif --}}
                                        </span>
                                    </a>
                                </div>
                            </div>
                        @endif
                        @if (access()->hasAccess('holdsalary', 'view'))
                            <div class="menu-sub menu-sub-accordion menu-active-bg">
                                <div class="menu-item">
                                    <a class="menu-link  @if (request()->routeIs(['holdsalary'])) active @endif"
                                        href="{{ route('holdsalary') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Hold Salary</span>
                                    </a>
                                </div>
                            </div>
                        @endif
                        @if (access()->hasAccess('it', 'view'))
                            <div class="menu-sub menu-sub-accordion menu-active-bg">
                                <div class="menu-item">
                                    <a class="menu-link  @if (request()->routeIs(['it'])) active @endif"
                                        href="{{ route('it') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Income Tax</span>
                                    </a>
                                </div>
                            </div>
                        @endif
                        @if (access()->hasAccess('it-calculation', 'view'))
                            <div class="menu-sub menu-sub-accordion menu-active-bg">
                                <div class="menu-item">
                                    <a class="menu-link  @if (request()->routeIs(['it-calculation'])) active @endif"
                                        href="{{ route('it-calculation') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Income Tax Calculation </span>
                                    </a>
                                </div>
                            </div>
                        @endif
                        @if (access()->hasAccess('salary.loan', 'view'))
                            <div class="menu-sub menu-sub-accordion menu-active-bg">
                                <div class="menu-item">
                                    <a class="menu-link  @if (request()->routeIs(['salary.loan'])) active @endif"
                                        href="{{ route('salary.loan') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Bank Loan</span>
                                    </a>
                                </div>
                            </div>
                        @endif
                        @if (access()->hasAccess('salary.lic', 'view'))
                            <div class="menu-sub menu-sub-accordion menu-active-bg">
                                <div class="menu-item">
                                    <a class="menu-link  @if (request()->routeIs(['salary.lic'])) active @endif"
                                        href="{{ route('salary.lic') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">LIC</span>
                                    </a>
                                </div>
                            </div>
                        @endif
                        @if (access()->hasAccess('other-income', 'view'))
                            <div class="menu-sub menu-sub-accordion menu-active-bg">
                                <div class="menu-item">
                                    <a class="menu-link  @if (request()->routeIs(['other-income'])) active @endif"
                                        href="{{ route('other-income') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Other Income</span>
                                    </a>
                                </div>
                            </div>
                        @endif
                        @if (access()->hasAccess('professional-tax', 'view'))
                            <div class="menu-sub menu-sub-accordion menu-active-bg">
                                <div class="menu-item">
                                    <a class="menu-link  @if (request()->routeIs(['professional-tax'])) active @endif"
                                        href="{{ route('professional-tax') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Professional Tax</span>
                                    </a>
                                </div>
                            </div>
                        @endif
                        @if (access()->hasAccess('it.tabulation', 'view'))
                            <div class="menu-sub menu-sub-accordion menu-active-bg">
                                <div class="menu-item">
                                    <a class="menu-link  @if (request()->routeIs(['it.tabulation'])) active @endif"
                                        href="{{ route('it.tabulation') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Income Tax Tabulation</span>
                                    </a>
                                </div>
                            </div>
                        @endif
                        @if (access()->hasAccess('salary-head', 'view'))
                            <div class="menu-sub menu-sub-accordion menu-active-bg">
                                <div class="menu-item">
                                    <a class="menu-link  @if (request()->routeIs(['salary-head'])) active @endif"
                                        href="{{ route('salary-head') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Salary Heads</span>
                                    </a>
                                </div>
                            </div>
                        @endif
                        @if (access()->hasAccess('salary-field', 'view'))
                            <div class="menu-sub menu-sub-accordion menu-active-bg">
                                <div class="menu-item">
                                    <a class="menu-link  @if (request()->routeIs(['salary-field'])) active @endif"
                                        href="{{ route('salary-field') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Salary Fields</span>
                                    </a>
                                </div>
                            </div>
                        @endif
                        @if (access()->hasAccess('taxscheme', 'view'))
                            <div class="menu-sub menu-sub-accordion menu-active-bg">
                                <div class="menu-item">
                                    <a class="menu-link  @if (request()->routeIs(['taxscheme'])) active @endif"
                                        href="{{ route('taxscheme') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Tax Schemes</span>
                                    </a>
                                </div>
                            </div>
                        @endif
                        @if (access()->hasAccess('taxsection', 'view'))
                            <div class="menu-sub menu-sub-accordion menu-active-bg">
                                <div class="menu-item">
                                    <a class="menu-link  @if (request()->routeIs(['taxsection'])) active @endif"
                                        href="{{ route('taxsection') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Scheme Section</span>
                                    </a>
                                </div>
                            </div>
                        @endif
                        @if (access()->hasAccess('taxsection-item', 'view'))
                            <div class="menu-sub menu-sub-accordion menu-active-bg">
                                <div class="menu-item">
                                    <a class="menu-link  @if (request()->routeIs(['taxsection-item'])) active @endif"
                                        href="{{ route('taxsection-item') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Scheme Section Item</span>
                                    </a>
                                </div>
                            </div>
                        @endif

                    </div>
                @endif
                @if (access()->hasAccess(['salary-head']))
                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="fa fa-handshake"></i>
                            </span>
                            <span class="menu-title">Gratuity calculations</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div class="menu-sub menu-sub-accordion menu-active-bg">
                            <div class="menu-item">
                                <a class="menu-link" href="javascript:void(0)">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Resigned Staff</span>
                                </a>
                            </div>
                        </div>
                        <div class="menu-sub menu-sub-accordion menu-active-bg">
                            <div class="menu-item">
                                <a class="menu-link" href="javascript:void(0)">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Retired Staff</span>
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
                {{-- Block Mapping Start --}}
                {{-- @if (access()->hasAccess(['blocks']))
                    <div data-kt-menu-trigger="click"
                        class="menu-item menu-accordion @if (request()->routeIs(['blocks'])) hover show @endif">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="fab fa-playstation"></i>
                            </span>
                            <span class="menu-title">Block Mapping</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div class="menu-sub menu-sub-accordion menu-active-bg">
                            @if (access()->hasAccess('blocks', 'view'))
                                <div class="menu-item">
                                    <a class="menu-link @if (request()->routeIs(['blocks'])) active @endif"
                                        href="{{ route('blocks') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Blocks</span>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif --}}

                {{-- Block Mappting End --}}
                @if (access()->hasAccess([
                        'bank',
                        'bank-branch',
                        'blood_group',
                        'caste',
                        'class',
                        'community',
                        'department',
                        'designation',
                        'division',
                        'document_type',
                        'duty-class',
                        'duty-type',
                        'professional_type',
                        'nature-of-employeement',
                        'institutions',
                        'language',
                        'nationality',
                        'place',
                        'other-school',
                        'workplace',
                        'qualification',
                        'relationship',
                        'religion',
                        'staff-category',
                        'subject',
                        'teaching-type',
                        'training-topic',
                        'board',
                    ]))
                    <div data-kt-menu-trigger="click"
                        class="menu-item menu-accordion
                @if (request()->routeIs([
                        'bank',
                        'bank-branch',
                        'blood_group',
                        'caste',
                        'class',
                        'community',
                        'department',
                        'designation',
                        'division',
                        'document_type',
                        'duty-class',
                        'duty-type',
                        'professional_type',
                        'nature-of-employeement',
                        'institutions',
                        'language',
                        'nationality',
                        'place',
                        'other-school',
                        'workplace',
                        'qualification',
                        'relationship',
                        'religion',
                        'staff-category',
                        'subject',
                        'teaching-type',
                        'training-topic',
                        'board',
                    ])) hover show @endif">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen022.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <path
                                            d="M18 21.6C16.6 20.4 9.1 20.3 6.3 21.2C5.7 21.4 5.1 21.2 4.7 20.8L2 18C4.2 15.8 10.8 15.1 15.8 15.8C16.2 18.3 17 20.5 18 21.6ZM18.8 2.8C18.4 2.4 17.8 2.20001 17.2 2.40001C14.4 3.30001 6.9 3.2 5.5 2C6.8 3.3 7.4 5.5 7.7 7.7C9 7.9 10.3 8 11.7 8C15.8 8 19.8 7.2 21.5 5.5L18.8 2.8Z"
                                            fill="currentColor"></path>
                                        <path opacity="0.3"
                                            d="M21.2 17.3C21.4 17.9 21.2 18.5 20.8 18.9L18 21.6C15.8 19.4 15.1 12.8 15.8 7.8C18.3 7.4 20.4 6.70001 21.5 5.60001C20.4 7.00001 20.2 14.5 21.2 17.3ZM8 11.7C8 9 7.7 4.2 5.5 2L2.8 4.8C2.4 5.2 2.2 5.80001 2.4 6.40001C2.7 7.40001 3.00001 9.2 3.10001 11.7C3.10001 15.5 2.40001 17.6 2.10001 18C3.20001 16.9 5.3 16.2 7.8 15.8C8 14.2 8 12.7 8 11.7Z"
                                            fill="currentColor"></path>
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </span>
                            <span class="menu-title"> Master Data </span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div class="menu-sub menu-sub-accordion menu-active-bg">

                            @if (access()->hasAccess('bank', 'view'))
                                <div class="menu-item">
                                    <a class="menu-link @if (request()->routeIs(['bank'])) active @endif"
                                        href="{{ route('bank') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Bank</span>
                                    </a>
                                </div>
                            @endif
                            @if (access()->hasAccess('bank-branch', 'view'))
                                <div class="menu-item">
                                    <a class="menu-link @if (request()->routeIs(['bank-branch'])) active @endif"
                                        href="{{ route('bank-branch') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title"> Bank Branches</span>
                                    </a>
                                </div>
                            @endif
                            @if (access()->hasAccess('blood_group', 'view'))
                                <div class="menu-item">
                                    <a class="menu-link @if (request()->routeIs(['blood_group'])) active @endif"
                                        href="{{ route('blood_group') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title"> Blood Groups </span>
                                    </a>
                                </div>
                            @endif
                            @if (access()->hasAccess('caste', 'view'))
                                <div class="menu-item">
                                    <a class="menu-link @if (request()->routeIs(['caste'])) active @endif"
                                        href="{{ route('caste') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title"> Caste </span>
                                    </a>
                                </div>
                            @endif
                            @if (access()->hasAccess('class', 'view'))
                                <div class="menu-item">
                                    <a class="menu-link @if (request()->routeIs(['class'])) active @endif"
                                        href="{{ route('class') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title"> Classes </span>
                                    </a>
                                </div>
                            @endif
                            @if (access()->hasAccess('community', 'view'))
                                <div class="menu-item">
                                    <a class="menu-link @if (request()->routeIs(['community'])) active @endif"
                                        href="{{ route('community') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title"> Community </span>
                                    </a>
                                </div>
                            @endif
                            @if (access()->hasAccess('department', 'view'))
                                <div class="menu-item">
                                    <a class="menu-link @if (request()->routeIs(['department'])) active @endif"
                                        href="{{ route('department') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title"> Departments </span>
                                    </a>
                                </div>
                            @endif
                            @if (access()->hasAccess('designation', 'view'))
                                <div class="menu-item">
                                    <a class="menu-link @if (request()->routeIs(['designation'])) active @endif"
                                        href="{{ route('designation') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title"> Designations </span>
                                    </a>
                                </div>
                            @endif
                            @if (access()->hasAccess('division', 'view'))
                                <div class="menu-item">
                                    <a class="menu-link @if (request()->routeIs(['division'])) active @endif"
                                        href="{{ route('division') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title"> Divisions </span>
                                    </a>
                                </div>
                            @endif
                            @if (access()->hasAccess('document_type', 'view'))
                                <div class="menu-item">
                                    <a class="menu-link @if (request()->routeIs(['document_type'])) active @endif"
                                        href="{{ route('document_type') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title"> Document Types </span>
                                    </a>
                                </div>
                            @endif
                            @if (access()->hasAccess('duty-class', 'view'))
                                <div class="menu-item">
                                    <a class="menu-link @if (request()->routeIs(['duty-class'])) active @endif"
                                        href="{{ route('duty-class') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title"> Duty Class </span>
                                    </a>
                                </div>
                            @endif
                            @if (access()->hasAccess('duty-type', 'view'))
                                <div class="menu-item">
                                    <a class="menu-link @if (request()->routeIs(['duty-type'])) active @endif"
                                        href="{{ route('duty-type') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title"> Duty Types </span>
                                    </a>
                                </div>
                            @endif
                            @if (access()->hasAccess('professional_type', 'view'))
                                <div class="menu-item">
                                    <a class="menu-link @if (request()->routeIs(['professional_type'])) active @endif"
                                        href="{{ route('professional_type') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title"> Education Types </span>
                                    </a>
                                </div>
                            @endif
                            @if (access()->hasAccess('nature-of-employeement', 'view'))
                                <div class="menu-item">
                                    <a class="menu-link @if (request()->routeIs(['nature-of-employeement'])) active @endif"
                                        href="{{ route('nature-of-employeement') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title"> Employment Nature </span>
                                    </a>
                                </div>
                            @endif
                            @if (access()->hasAccess('institutions', 'view'))
                                <div class="menu-item">
                                    <a class="menu-link @if (request()->routeIs(['institutions'])) active @endif"
                                        href="{{ route('institutions') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title"> Institutions </span>
                                    </a>
                                </div>
                            @endif
                            @if (access()->hasAccess('language', 'view'))
                                <div class="menu-item">
                                    <a class="menu-link @if (request()->routeIs(['language'])) active @endif"
                                        href="{{ route('language') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title"> Languages </span>
                                    </a>
                                </div>
                            @endif
                            @if (access()->hasAccess('nationality', 'view'))
                                <div class="menu-item">
                                    <a class="menu-link @if (request()->routeIs(['nationality'])) active @endif"
                                        href="{{ route('nationality') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title"> Nationality </span>
                                    </a>
                                </div>
                            @endif
                            @if (access()->hasAccess('place', 'view'))
                                <div class="menu-item">
                                    <a class="menu-link @if (request()->routeIs(['place'])) active @endif"
                                        href="{{ route('place') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title"> Other School Place </span>
                                    </a>
                                </div>
                            @endif
                            @if (access()->hasAccess('other-school', 'view'))
                                <div class="menu-item">
                                    <a class="menu-link @if (request()->routeIs(['other-school'])) active @endif"
                                        href="{{ route('other-school') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title"> Other Schools </span>
                                    </a>
                                </div>
                            @endif
                            @if (access()->hasAccess('workplace', 'view'))
                                <div class="menu-item">
                                    <a class="menu-link @if (request()->routeIs(['workplace'])) active @endif"
                                        href="{{ route('workplace') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title"> Place Of Works </span>
                                    </a>
                                </div>
                            @endif
                            @if (access()->hasAccess('qualification', 'view'))
                                <div class="menu-item">
                                    <a class="menu-link @if (request()->routeIs(['qualification'])) active @endif"
                                        href="{{ route('qualification') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title"> Qualifications </span>
                                    </a>
                                </div>
                            @endif
                            @if (access()->hasAccess('relationship', 'view'))
                                <div class="menu-item">
                                    <a class="menu-link @if (request()->routeIs(['relationship'])) active @endif"
                                        href="{{ route('relationship') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title"> Relationship Types </span>
                                    </a>
                                </div>
                            @endif
                            @if (access()->hasAccess('religion', 'view'))
                                <div class="menu-item">
                                    <a class="menu-link @if (request()->routeIs(['religion'])) active @endif"
                                        href="{{ route('religion') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title"> Religions </span>
                                    </a>
                                </div>
                            @endif
                            @if (access()->hasAccess('staff-category', 'view'))
                                <div class="menu-item">
                                    <a class="menu-link @if (request()->routeIs(['staff-category'])) active @endif"
                                        href="{{ route('staff-category') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title"> Staff Category </span>
                                    </a>
                                </div>
                            @endif
                            @if (access()->hasAccess('subject', 'view'))
                                <div class="menu-item">
                                    <a class="menu-link @if (request()->routeIs(['subject'])) active @endif"
                                        href="{{ route('subject') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title"> Subjects </span>
                                    </a>
                                </div>
                            @endif
                            @if (access()->hasAccess('teaching-type', 'view'))
                                <div class="menu-item">
                                    <a class="menu-link @if (request()->routeIs(['teaching-type'])) active @endif"
                                        href="{{ route('teaching-type') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title"> Teaching Types </span>
                                    </a>
                                </div>
                            @endif
                            @if (access()->hasAccess('training-topic', 'view'))
                                <div class="menu-item">
                                    <a class="menu-link @if (request()->routeIs(['training-topic'])) active @endif"
                                        href="{{ route('training-topic') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title"> Training Topics </span>
                                    </a>
                                </div>
                            @endif
                            @if (access()->hasAccess('board', 'view'))
                                <div class="menu-item">
                                    <a class="menu-link @if (request()->routeIs(['board'])) active @endif"
                                        href="{{ route('board') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title"> University/Boards </span>
                                    </a>
                                </div>
                            @endif

                        </div>
                    </div>
                @endif
                @if (access()->hasAccess(['reports.profile']))
                    @foreach (reportMenu() as $name => $reports)
                    @php
                        $in_routes = array_column($reports, 'route');
                    @endphp
                        <div data-kt-menu-trigger="click" class="menu-item menu-accordion @if( request()->routeIs($in_routes)) hover show @endif">
                            <span class="menu-link">
                                <span class="menu-icon">
                                    <i class="fa fa-print"></i>
                                </span>
                                <span class="menu-title">{{ ucfirst($name) }}</span>
                                <span class="menu-arrow"></span>
                            </span>
                            <div class="menu-sub menu-sub-accordion menu-active-bg">
                                @if (count($reports))
                                    @foreach ($reports as $report)
                                        <div class="menu-item">
                                            <a class="menu-link @if (request()->routeIs([$report['route']])) active @endif" href="{{ route($report['route']) }}">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">{{ $report['name'] }}</span>
                                            </a>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <!--end::Menu-->
        </div>
        <!--end::Aside Menu-->
    </div>
    <!--end::Aside menu-->

</div>
