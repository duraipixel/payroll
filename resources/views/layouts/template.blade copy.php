<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        {{ config('app.name', 'AWES') }}
    </title>
    @include('layouts.parts.meta')
    @include('layouts.stylelinks')
    @include('layouts.scripts')
</head>

<body id="kt_body"
    class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed aside-enabled aside-fixed"
    style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px">
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5FS8GGP" height="0" width="0"
            style="display:none;visibility:hidden"></iframe>
    </noscript>

    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="page d-flex flex-row flex-column-fluid">
            @include('layouts.parts.aside')

            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">

                @include('layouts.header')
                
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

                        {{-- <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
                            <a href="../index.html" class="d-lg-none">
                                <img alt="Logo" src="{{ asset('assets/images/needs/logo-2.svg') }}"
                                    class="h-30px" />
                            </a>
                        </div> --}}

                        @include('layouts.topbar')
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Container-->
                   
                </div>

                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <!--begin::Toolbar-->
                    @include('layouts.parts.toolbar')

                    <div class="post d-flex flex-column-fluid" id="kt_post">
                        <!--begin::Container-->
                        <div id="kt_content_container" class="container-xxl">
                            @yield('content')
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Post-->
                </div>
                <!--end::Content-->
                <!--begin::Footer-->
                @include('layouts.footer')
                <!--end::Footer-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
        <div id="loading" >
            <img src="{{ asset('assets/images/needs/loadingbook.gif') }}" alt="">
        </div>
    </div>

    @include('layouts.drawer.activities')

    @include('layouts.drawer.chat')

    {{-- @include('layouts.drawer.engage') --}}

    <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
        <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
        <span class="svg-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1"
                    transform="rotate(90 13 6)" fill="currentColor" />
                <path
                    d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z"
                    fill="currentColor" />
            </svg>
        </span>
        <!--end::Svg Icon-->
    </div>

    <div class="modal fade" id="kt_modal_upgrade_plan" tabindex="-1" aria-hidden="true">
        @include('layouts.modal.upgrade_plan')
    </div>

    <div class="modal fade" id="kt_modal_create_app" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        @include('layouts.modal.create_app')
        <!--end::Modal dialog-->
    </div>

    <div class="modal fade" id="kt_dynamic_app" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        @include('layouts.modal.dynamic_modal')
        <!--end::Modal dialog-->
    </div>

    <div class="modal fade" id="kt_dynamic_rightside" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        @include('layouts.modal.dynamic_side_modal')
        <!--end::Modal dialog-->
    </div>

    <div class="modal fade" id="kt_modal_offer_a_deal" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        @include('layouts.modal.offer_deal')
    </div>

    <div class="modal fade" id="kt_modal_users_search" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        @include('layouts.modal.user_search')
        <!--end::Modal dialog-->
    </div>

    <div class="modal fade" id="kt_modal_invite_friends" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        @include('layouts.modal.invite_friends')
        <!--end::Modal dialog-->
    </div>
    @yield('add_on_script')
</body>

</html>
