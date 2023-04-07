<div id="kt_header" class="header align-items-stretch maa-header">
    <!--begin::Container-->
    <div class="container-fluid d-flex align-items-stretch justify-content-between">
        <div class="col-6">
            <div class="text-light">
                <h1>AMALORPAVAM PAYROLL SYSTEM v1.0</h1>
            </div>
        </div>
        <div class="col-6">
            <div class="text-light lst-typ text-end">
                <ul>
                    <li><img alt="Logo" src="{{ asset('assets/media/logos/user-logo.png') }}"
                            class="h-45px logo" /></li>
                    <li><img alt="Logo" src="{{ asset('assets/media/logos/user-logo-1.png') }}"
                            class="h-45px logo" /></li>
                    <li>
                        <div class="cursor-pointer symbol symbol-30px symbol-md-40px" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                            @if( isset(auth()->user()->image) && !empty( auth()->user()->image ) )
                                <img alt="user" src="{{ asset('/') . auth()->user()->image }}" />
                            @else                    
                                <img alt="user" src="{{ asset('assets/images/no_Image.jpg') }}" />
                            @endif
                        </div>
                        <!--begin::User account menu--> 
                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-primary fw-bold py-4 fs-6 w-275px" data-kt-menu="true">
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <div class="menu-content d-flex align-items-center px-3">
                                    <!--begin::Avatar-->
                                    <div class="symbol symbol-50px me-5">
                        
                                        @if( isset(auth()->user()->image) && !empty( auth()->user()->image ) )
                                            <img alt="Logo" src="{{ asset('/') . auth()->user()->image }}" />
                                        @else                    
                                            <img alt="Logo" src="{{ asset('assets/images/no_Image.jpg') }}" />
                                        @endif
                                    </div>
                                    <!--end::Avatar-->
                                    <!--begin::Username-->
                                    <div class="d-flex flex-column">
                                        <div class="fw-bolder d-flex align-items-center fs-5">
                                            {{ auth()->user()->name ?? '' }}
                                            
                                        </div>
                                        <a href="#" class="fw-bold text-muted text-hover-primary fs-7">{{ auth()->user()->email ?? '' }}</a>
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
                                <a href="{{ route('logout') }}" class="menu-link px-5"  onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">Sign Out</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form> 
                            </div>
                        </div>
                    </li>
                    
                </ul>
            </div>
        </div>
    </div>
    <!--end::Wrapper-->
</div>