<!DOCTYPE html>

<html lang="en">

<head>
    <title> {{ config('app.name', 'AWES') }}</title>

    @include('layouts.parts.meta')
    @include('layouts.stylelinks')
    @include('layouts.scripts')
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body"
    class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed aside-enabled aside-fixed"
    style="--kt-toolbar-height:95px;--kt-toolbar-height-tablet-and-mobile:95px">

    <!--begin::Main-->
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="page d-flex flex-row flex-column-fluid">
            <!--begin::Aside-->

            @include('layouts.sidemenu')
            <!--end::Aside-->
            <!--begin::Wrapper-->
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <!--begin::Header-->
                @include('layouts.header')
                <!--end::Header-->
                <!--begin::Header-->
                @include('layouts._header_menu')
                <!--end::Header-->
                <!--begin::Content-->
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    {{-- @include('layouts.parts.toolbar') --}}
                    <!--begin::Post-->
                    <div class="post d-flex flex-column-fluid" id="kt_post">
                        <!--begin::Container-->
                        <div id="kt_content_container" class="container-xxl px-2">
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
        <div id="staff-loading">
            <img src="{{ asset('assets/images/needs/loadingbook.gif') }}" alt="">
        </div>
    </div>
    <script>
        var loadingElement = document.getElementById('staff-loading');

        function loading() {
            loadingElement.style.display = 'flex';
        }

        function unloading() {
            loadingElement.style.display = 'none';
        }
    </script>
    {{-- @include('layouts.drawer.activities') --}}

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
        {{-- @include('layouts.modal.upgrade_plan') --}}
    </div>

    <div class="modal fade" id="kt_modal_create_app" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        {{-- @include('layouts.modal.create_app') --}}
        <!--end::Modal dialog-->
    </div>

    <div class="modal fade" id="kt_dynamic_app" tabindex="-1" aria-hidden="true" style="z-index: 1051">
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
        {{-- @include('layouts.modal.offer_deal') --}}
    </div>

    <div class="modal fade" id="kt_modal_users_search" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        {{-- @include('layouts.modal.user_search') --}}
        <!--end::Modal dialog-->
    </div>

    <div class="modal fade" id="kt_modal_invite_friends" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        {{-- @include('layouts.modal.invite_friends') --}}
        <!--end::Modal dialog-->
    </div>
    @yield('add_on_script')

    <!--begin::Global Javascript Bundle(used by all pages)-->
    <script src="{{ asset('assets/js/tamil-search.js') }}"></script>
    <script src="{{ asset('assets/js/tamil-keyboard.js') }}"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Page Vendors Javascript(used by this page)-->

    <script src="{{ asset('assets/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>
    
    <script src="{{ asset('assets/js/widgets.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/custom/widgets.js') }}"></script>
 
    <script type="text/javascript">
      
    </script>
     <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
     <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
 
    <script>
        $(document).ready(function() {
            $('#employee_type').select2();
            $('#content').on('keydown', function(event) {
                if (event.which == 121) {
                    $(this).toggleClass('tamil');
                    return false;
                }
                if ($(this).hasClass('tamil')) {
                    toggleKBMode(event);
                } else {
                    return true;
                }
            });
            $('#content').on('keypress', function(event) {
                if ($(this).hasClass('tamil')) {
                    convertThis(event);
                }
            });
        });

        $(function() {

            var start = moment().subtract(29, 'days');
            var end = moment();

            function cb(start, end) {
                $('#search_home_date span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            }

            $('#search_home_date').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')]
                }
            }, cb);

            cb(start, end);


            $('input[name="search_home_date"]').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format(
                    'DD/MM/YYYY'));

                let start_date = picker.startDate.format('DD/MM/YYYY');
                let end_date = picker.endDate.format('DD/MM/YYYY');

                let requested_days = datediff(parseDate(start_date), parseDate(end_date));
                $('#no_of_days').val(requested_days + 1);

            });

            $('input[name="search_home_date"]').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });



        });
    </script>
    <script>
        $(".DA_radio_holder .radio-btn").change(function() {
            $(this).closest(".question").next().toggle(this.value === 'yes');
        });

        $(".number_only").keypress(function(e) {
            if (String.fromCharCode(e.keyCode).match(/[^0-9]/g)) return false;
        });

        $(".price").keypress(function(e) {
            if (String.fromCharCode(e.keyCode).match(/[^.0-9]/g)) return false;
        });

        function setGlobalAcademicYear(id) {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('set.academic.year') }}",
                type: 'POST',
                data: {
                    id: id
                },
                success: function(res) {
                    if (res) {
                        location.reload();
                    }
                }
            })
        }

        function setGlobalInstitution(id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('set.institution') }}",
                type: 'POST',
                data: {
                    id: id
                },
                success: function(res) {
                    if (res) {
                        location.reload();
                    }
                }
            })
        }

        function gotoStaffOverview() {
            var global_search = $('#global_search').val();
            if( global_search == '' || global_search == 'undefined' ) {
                toastr.error('Enter keywords to view Staff Overview details');
                $('#global_search').focus();
                return false;
            }
        }

        var global_search = document.getElementById('global_search');

    global_search.addEventListener('keyup', function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('get.staff') }}",
            type: 'POST',
            data: {
                query: this.value,
            },
            success: function(res) {
                console.log(res);
                if (res && res.length > 0) {
                    $('#typeadd-panel').removeClass('d-none');
                    let panel = '';
                    res.map((item) => {
                        panel +=
                            `<li class="typeahead-pane-li" onclick="return getStaffLeaveInfo(${item.id})">${item.name} - ${item.emp_code}</li>`;
                    })
                    $('#typeahead-list').html(panel);

                } else {
                    $('#typeadd-panel').addClass('d-none');

                }
            }
        })
    })
    </script>
</body>

</html>
