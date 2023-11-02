<!DOCTYPE html>

<html lang="en">

<head>
    <title> {{ config('app.name', 'AWES') }}</title>

    @include('layouts.parts.meta')
    @include('layouts.stylelinks')
    @include('layouts.scripts')
     <style>
  body {
    font-family: "Poppins";
    background:#f0f4f7;
  }
  .sidebar {
  height: 100%;
  width: 265px;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  background-color: #ffffff;
  padding-top: 16px;
  overflow-x: hidden;
}

.sidebar a {
  padding: 15px 8px 6px 16px;
  text-decoration: none;
  font-size: 15px;
  color: #818181;
  display: block;
}
.sidebar a span{
  font-size: 15px;
  padding-right:20px;

}
.sidebar a:hover {
    color: #083C90;
}
.sidebar img{
  width:50%;
  display: block;
  margin:0 auto;
}
.main {
  margin-left: 276px; /* Same as the width of the sidenav */
  padding: 0px 10px;
  background-color:#f0f4f7;
}
.main-sub{
  background-color:white;
  padding: 20px;
  margin-bottom: 45px;
}
.sidebar h4{
  text-align: center;
}

.main-sub th{
    color: #083C90;
}
.main-sub th, .main-sub td {
  text-align: center;
  padding: 16px 10px;

}
.btn-close
{
    padding: 10px 20px;
    background: #FCD9E2;
    border: #FCD9E2;
    color: #F1416C;
    font-size: 20px;
}
.btn-save{
  padding: 10px 20px;
    background: #dbf5e8;
    border: #dbf5e8;
    color: #50CD89;
    font-size: 20px;
}
.sidebar i{
  padding-right: 10px;
  
}
.border-style-cs ul{
  display: flex;
  list-style: none;
  margin:0px;
}
.border-style-cs ul li{
  margin-right:20px;
}
.fa-times:before {
    content: "\f00d";
    color: #d13333;
}
.fa-check-square-o:before {
    content: "\f046";
    color: #00C389;
}
.fa-cloud-download:before {
    content: "\f0ed";
    color: #009EF7;
}
.mange-alloance-section table{
  background: #ffffff;
  padding: 20px;
}
.mange-alloance-section th, .mange-alloance-section td {
  text-align: left;
  padding: 10px 10px;

}
.lt-btn {
    background-color: #2fb4ff70;
    color: #009EF7;
    border: #2FB4FF;
    padding: 10px 25px;
    border-radius: 4px;
    font-size: 18px;
}
@media screen and (max-height: 450px) {
  .sidebar {padding-top: 15px;}
  .sidebar a {font-size: 18px;}
}
table {
  border-collapse: collapse;
}

tr{
  border-bottom: 1px solid #F4F4F4;
}
#quantity
{
    background: #bebcbc;
    border: #bebcbc;
    padding: 15px 2px;
    margin: 10px;
    text-align: center;
}
#quantity2{
    background: #2fb4ff70;
    border: #2fb4ff70;
    padding: 15px 2px;
    margin: 10px;
    text-align: center;
}
.modal-dialog {
    width: 100%;
    margin: 30px auto !important;
}

.card {
    /*  background:#fff; */
    background: #e0e4e7;
    border-radius: 0px;
}
.cards img{
    width:50%;
    display: block;
    margin: 0 auto;
}
.cards{
    display: flex;
/*    padding: 20px;*/
}
.row{
    margin-right: 15px !important;
    margin-left: 15px !important;
}
.card-single{
    background: white;
    border-radius: 5px;
    padding: 8px 0px;
    margin: 10px;
}
.card-single span{
    font-size: 15px;
}
h2 {
    color: #083C90;
    margin-top: 10px;
}
.table-section {
    padding: 25px 39px;
}
.table-section input {
    margin: 10px;
    font-family: inherit;
    font-size: 16px;
    line-height: 2;
    padding: 7px 0px;
    background: #2fb4ff70;
    border: #2fb4ff70;
    color:#009EF7;
    text-align: center;
}
.table-section span{
font-size: 15px;
}
.card-body{
    padding:0px !important;
    margin:0px !important;
}
.badge{
background: #2fb4ff26;
margin: 0px 4px 0px 6px;
padding: 11px;
color: #009ef7;
font-weight: 600;
border-radius: 5px; 
}

  </style>
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
            @if (request()->route()->getAction()['prefix'] ?? false)
                <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                    @include('layouts.header')

                    <div class="content m-0">
                        @yield('content')
                    </div>
                    @include('layouts.footer')
                </div>
            @else
                <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                    <!--begin::Header-->
                    @include('layouts.header')
                    <!--end::Header-->
                    <!--begin::Header-->
                    @if (access()->buttonAccess('staff.list', 'add_edit'))
                     @if ( !request()->routeIs(['appointment.orders.add']))
<div id="kt_header" class="d-flex justify-content-center border-bottom py-3 shadow"style="background:white;">
      <div class="row col-md-12">
<h4 style="color:black;">Search Staff</h4>
        <div class="row col-md-12">

            <div class="col-md-3"> <div class="input-group">

                <div class="menu-item position-relative">

                    <input type="text" class="form-control ps-10 w-300px rounded-0 global_search" name="global_search"
                    id="global_search" value="{{request()->global_search}}" placeholder="Search for Staff By Name or Staff ID" />
                    <input type="hidden" name="search_staff_id" id="search_staff_id" value="">
                    <div class="typeahead-pane-search d-none" id="typeadd-search-panel1">
                        <ul type="none" class="typeahead-pane-search-ul" id="typeahead-search-list">
                        </ul>
                    </div>
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
            </div>

        </div></div> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <div class="col-md-2">
            <select name="staff_type" id="staff_type"
            class="form-select form-select-lg select2-option">>
            <option value="">Staff Type</option>
            @isset($staff_category)
            @foreach ($staff_category as $category)
            <option value="{{ $category->id }}"
                {{ request()->staff_type == $category->id  ? 'selected' : ''}}>
                {{ $category->name }}
            </option>
            @endforeach
            @endisset
        </select>
    </div>     &nbsp;
    <div class="col-md-2">
        <select name="designation"  id="designation"
        class="form-select form-select-lg select2-option">
        <option value="">Designation</option>
        @isset($designation)
        @foreach ($designation as $design)
        <option value="{{ $design->id }}"    {{ request()->designation == $design->id  ? 'selected' : ''}}>
            {{ $design->name }}
        </option>
        @endforeach
        @endisset
    </select></div>
    <div class="col-md-2">
        <select name="gender"  id="gender"
        class="form-select form-select-lg select2-option">
        <option value="">Gender</option>
        <option value="male" {{ request()->gender == 'male'  ? 'selected' : ''}}>Male</option>
        <option value="female" {{ request()->gender == 'female'  ? 'selected' : ''}}>Female</option>
        <option value="others" {{ request()->gender == 'others'  ? 'selected' : ''}}>Others</option>
    </select></div>
    <div class="col-md-1">

        <button type="submit" class="btn btn-primary">Search</button>&nbsp;
    </div>
    <div class="col-md-1">
        <a href={{url('leaves/overview/list')}} class="btn btn-primary">Clear</a>
    </div>
        </div>
     
 </div>

</div>
@endif

                    @endif
                    <!--end::Header-->
                    <!--begin::Content-->
                    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">

                        <!--abegin::Post-->
                        <div class="post p-3" id="kt_post">
                            <!--begin::Container-->
                            <div id="kt_content_container">
                           <!-- ..... -->
    <div class="card mb-2">
        <h4 style="color:black;">Leave Management</h4>
        <div class="card-body my-style-pt py-1">
            <div class="">
               <div class="cards">
<div class="row card-single">
    <div class="col-lg-6">
        <span>Total Number of working days</span>
        <h2>274</h2>
    </div>
    <div class="col-lg-6">
        <img src="{{url('assets/logo/Group 1580.png')}}">
    </div>
</div>
<div class="row card-single">
    <div class="col-lg-6">
        <span>Total Number of Leaves</span>
        <h2>{{$total}}</h2>
    </div>
    <div class="col-lg-6">
        <img src="{{url('assets/logo/Group 1581.png')}}">
    </div>
</div>
<div class="row card-single">
    <div class="col-lg-6">
        <span>Employee Leave Requests Pending </span>
        <h2>{{$pending}}</h2>
    </div>
    <div class="col-lg-6">
        <img src="{{url('assets/logo/Group 1582.png')}}">
    </div>
</div>

</div>
               
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body py-4">
            <div class="row">
                 <div class="card-body py-4">
            <div id="kt_table_users_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                <div class="table-responsive">
                    <table class="table align-middle table-hover table-bordered table-striped fs-7 no-footer"
                        id="staff_table">
                        <thead class="bg-primary">
                            <tr class="text-start text-center text-muted fw-bolder fs-7 text-uppercase gs-0">

                                <th class="text-white text-start ps-3" rowspan="2">
                                    Staff ID
                                </th>
                                <th class="text-white text-start ps-3" rowspan="2">
                                    Staff Name
                                </th>
                                <th class="text-white text-start ps-3" rowspan="2">
                                     Staff Type
                                </th>
                                <th class="text-white"colspan="5">Leave Taken</th>
                                 <th class="text-white" rowspan="2">
                                    LOP
                                </th>
                                 <th class="text-white" rowspan="2">
                                    Extened Leave
                                </th>
                                <th class="text-white" rowspan="2">
                                    Actions
                                </th>
                            </tr>
                             <tr>
                @if(isset($leavehead))
                  @foreach($leavehead as $key=>$head)
                <th class="text-white"  >{{$head->name}}</th>
                @endforeach
                @endif
            </tr>
                        </thead>

                        <tbody class="text-gray-600 fw-bold">
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
            </div>
        </div>
    </div>
<!-- ..... -->

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
            @endif
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

    <script type="text/javascript"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <script>
        $(document).ready(function() {
            $('#employee_type').select2({
                theme: 'bootstrap-5',
            });
            $('#academic_year').select2({
                theme: 'bootstrap-5',
            });
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
            console.log(end, 'end');

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
                },
                locale: {
                    format: 'DD/MM/YYYY'
                }
            }, cb);

            cb(start, end);


            $('input[name="search_home_date"]').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format(
                    'DD/MM/YYYY'));

                let start_date = picker.startDate.format('DD/MM/YYYY');
                let end_date = picker.endDate.format('DD/MM/YYYY');

                getDashboardView(start_date, end_date)


            });

            $('input[name="search_home_date"]').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });



        });
    </script>
    <script>

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
            var search_staff_id = $('#search_staff_id').val();
            if (global_search == '' || global_search == 'undefined') {
                toastr.error('Enter keywords to view Staff Overview details');
                $('#global_search').focus();
                return false;
            } else {
                let url_staff = "{{ url('/staff/print') }}";
                window.open(url_staff + '/' + search_staff_id, '_blank');
            }
        }


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
                        $('#typeadd-search-panel1').removeClass('d-none');
                        let panel = '';
                        res.map((item) => {
                            panel +=
                                `<li class="typeahead-pane-li" onclick="return setGlobalSearchValue(${item.id}, '${item.name} - ${item.emp_code}')">${item.name} - ${item.institute_emp_code}</li>`;
                        })
                        $('#typeahead-search-list').html(panel);

                    } else {
                        // $('#typeadd-search-panel1').addClass('d-none');
                        // $('#search_staff_id').val('');
                        // $('#global_search').val('');
                        $('#typeahead-search-list').html(
                            `<li class="typeahead-pane-li" >No Records </li>`);
                    }
                }
            })
        })

        function setGlobalSearchValue(id, name) {
            $('#global_search').val(name);
            $('#search_staff_id').val(id);
            $('#typeadd-search-panel1').addClass('d-none');
         staff_Table.ajax.reload();
        }
         $('#staff_type').select2({
            selectOnClose: true,
            theme: 'bootstrap-5'
        });
         $('#designation').select2({
            selectOnClose: true,
            theme: 'bootstrap-5'
        });
         $('#gender').select2({
            selectOnClose: true,
            theme: 'bootstrap-5'
        });

     var staff_Table = $('#staff_table').DataTable({
            processing: true,
            serverSide: true,
            order: [[1, "ASC"]],
            type: 'POST',
            "ajax": {
                "url": "{{ route('leaves.overview.list') }}",
                "dataType": "json",
                "data": function(d) {
                    d._token = "{{ csrf_token() }}",
                        d.datatable_institute_id = $('#datatable_institute_id').val(),
                    d.global_search = $('#search_staff_id').val(),
                     d.staff_type = $('#staff_type').val(),
                      d.designation = $('#designation').val(),
                       d.gender = $('#gender').val()
                    
                }
            },
            "columns": [{
                    "data": "institute_emp_code"
                },
                {
                    "data": "name"
                },
                {
                    "data": "emp_code"

                },{ 
                    "data": "Casual Leave"
                   
                },
                { 
                    "data": "Earned Leave"
                   
                }
                ,{ 
                    "data": "Maternity Leave"
                   
                }
                ,{ 
                    "data": "Extra Ordinary Leave"
                   
                }
                ,{ 
                    "data": "Granted Leave"
                   
                },{ 
                    "data": "lop",
                    "name":"LOP"
                   
                },{ 
                    "data": "extened_leave",
                    "name":"Extened Leave"
                   
                },
                {
                    "data": "action"
                
                },
            ],
        language: {
            paginate: {
                next: '<i class="fa fa-angle-right"></i>', // or '→'
                previous: '<i class="fa fa-angle-left"></i>' // or '←' 
            }
        },
            "aLengthMenu": [
                [10,25, 50, 100, 200, 500, -1],
                [10,25, 50, 100, 200, 500, "All"]
            ]

        });
     $("#staff_type").change(function(){
        staff_Table.ajax.reload();
     }); 
     $("#gender").change(function(){
        staff_Table.ajax.reload();
     }); 
     $("#designation").change(function(){
        staff_Table.ajax.reload();
     }); 
         
       
    </script>
</body>

</html>
