@extends('layouts.template')
@section('breadcrum')
    @include('layouts.parts.breadcrum')
@endsection
@section('content')
    <style>
        .modal-open .daterangepicker {
            z-index: 3001;
        }
    </style>
    <div class="card">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <div class="d-flex align-items-center position-relative my-1"  style="padding-right: 10px;">
                    {!! searchSvg() !!}
                    <input type="text" data-kt-user-table-filter="search" id="leave_dataTable_search"
                        class="form-control form-control-solid w-250px ps-14" placeholder="Search Leave Request">
                </div>
           
                <div style="padding-right: 10px;"> 
        <select name="leave_status" autofocus id="leave_status" class="form-select form-select-lg select2-option">
         <option value="">--Select Leave Status--</option>
         <option value="all"> All </option>
         <option value="pending">Pending</option>
         <option value="approved">Approved</option>
         <option value="rejected">Rejected</option>
        </select>

            </div>
            <div  style="padding-right: 10px;">
         <input type="date" id="from_date"
            class="form-control form-control-solid w-250px ps-14">
           
            </div>
            <div  style="padding-right: 10px;">  <input type="date" id="to_date"
            class="form-control form-control-solid w-250px ps-14" placeholder="To date">
            </div>
            </div>
            <div class="card-toolbar" style="padding-left: 876px;">
                <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">

                    @php
                        $route_name = request()
                            ->route()
                            ->getName();
                    @endphp
                    @if (access()->buttonAccess($route_name, 'add_edit'))
                        <button type="button" class="btn btn-primary btn-sm" id="add_modal"
                            onclick="window.location.href = '{{ route('leaves.add') }}'">
                            {!! plusSvg() !!} Request Leave
                        </button>
                    @endif
                </div>

                <div class="d-flex justify-content-end align-items-center d-none" data-kt-user-table-toolbar="selected">
                    <div class="fw-bolder me-5">
                        <span class="me-2" data-kt-user-table-select="selected_count"></span>Selected
                    </div>
                    <button type="button" class="btn btn-danger" data-kt-user-table-select="delete_selected">Delete
                        Selected
                    </button>
                </div>
            </div>
            <!--end::Card toolbar-->
        </div>

        <div class="card-body py-4">
            <div id="kt_table_users_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                <div class="table-responsive">
                    <table class="table align-middle text-center table-hover table-bordered table-striped fs-7 no-footer"
                        id="leave_table">
                        <thead class="bg-primary">
                            <tr class="text-start text-center text-muted fw-bolder fs-7 text-uppercase gs-0">
                                <th class="text-center text-white">
                                    Application Date
                                </th>
                                <th class="text-center text-white">
                                    Name
                                </th>
                                 <th class="text-center text-white">
                                   Institute Code
                                </th>
                                <th class="text-center text-white">
                                    Designation
                                </th>
                                 <th class="text-center text-white">
                                    Leave Category
                                </th>
                                <th class="text-center text-white">
                                   From Date
                                </th>
                                <th class="text-center text-white">
                                    To Date
                                </th>
                               
                                <th class="text-center text-white">
                                    Days Requested
                                </th>
                                <th class="text-center text-white">
                                    Days Granted
                                </th>
                                <th class="text-center text-white">
                                    Status
                                </th>
                                <th class="text-center text-white">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 fw-bold">
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
        <!--end::Card body-->
    </div>
@endsection

@section('add_on_script')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <script>
        var dtTable = $('#leave_table').DataTable({

            processing: true,
            serverSide: true,
            order: [
                [0, "DESC"]
            ],
            type: 'POST',
            ajax: {
                "url": "{{ route('leaves.list') }}",
                "data": function(d) {
                    d.datatable_search = $('#leave_dataTable_search').val();
                    d.leave_status = $('#leave_status').val();
                    d.from_date = $('#from_date').val();
                    d.to_date = $('#to_date').val();
                }
            },

            columns: [{
                    data: 'created_at',
                    name: 'created_at',
                },
                {
                    data: 'staff_name',
                    name: 'staff_name'
                },
                {
                    data: 'institute_code',
                    name: 'institute_code'
                },
                {
                    data: 'designation',
                    name: 'designation'
                },
                {
                    data: 'leave_category',
                    name: 'leave_category'
                },
                {
                    data: 'from_date',
                    name: 'from_date'
                },
                {
                    data: 'to_date',
                    name: 'to_date'
                },
                {
                    data: 'no_of_days',
                    name: 'no_of_days'
                },{
                    data: 'granted_days',
                    name: 'granted_days'
                },
                {
                    data: 'status',
                    name: 'status'
                },

                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ],
            language: {
                paginate: {
                    next: '<i class="fa fa-angle-right"></i>', // or '→'
                    previous: '<i class="fa fa-angle-left"></i>' // or '←' 
                }
            },
            "aaSorting": [],
            "pageLength": 25
        });
        document.querySelector('#leave_status').addEventListener("change", function(e) {
            dtTable.ajax.reload();
        });
        $('.dataTables_wrapper').addClass('position-relative');
        $('.dataTables_info').addClass('position-absolute');
        $('.dataTables_filter label input').addClass('form-control form-control-solid w-250px ps-14');
        $('.dataTables_filter').addClass('position-absolute end-0 top-0');
        $('.dataTables_length label select').addClass('form-control form-control-solid');

        document.querySelector('#leave_dataTable_search').addEventListener("keyup", function(e) {
                dtTable.draw();
            }),

            $('#search-form').on('submit', function(e) {
                dtTable.draw();
                e.preventDefault();
            });

        $('#search-form').on('reset', function(e) {
            $('select[name=filter_status]').val(0).change();

            dtTable.draw();
            e.preventDefault();
        });
         $('#from_date, #to_date').on('change', function(e) {
            dtTable.draw();
            e.preventDefault();
        });
        function deleteLeave(id) {
            Swal.fire({
                text: "Are you sure you would like to delete Leave?",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Yes, Delete it!",
                cancelButtonText: "No, return",
                customClass: {
                    confirmButton: "btn btn-danger",
                    cancelButton: "btn btn-active-light"
                }
            }).then(function(result) {
                if (result.value) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url: "{{ route('delete.leaves') }}",
                        type: 'POST',
                        data: {
                            id: id,
                        },
                        success: function(res) {
                            if (res.error == 1) {
                                Swal.fire({
                                    title: "Cannot Delete!",
                                    text: res.message,
                                    icon: "danger",
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn btn-danger"
                                    },
                                    timer: 3000
                                });
                            } else {
                                dtTable.ajax.reload();
                                Swal.fire({
                                    title: "Deleted!",
                                    text: res.message,
                                    icon: "success",
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn btn-success"
                                    },
                                    timer: 3000
                                });
                            }


                        },
                        error: function(xhr, err) {
                            if (xhr.status == 403) {
                                toastr.error(xhr.statusText, 'UnAuthorized Access');
                            }
                        }
                    });
                }
            });
        }
    </script>
@endsection
