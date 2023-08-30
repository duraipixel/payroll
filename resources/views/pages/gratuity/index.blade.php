@extends('layouts.template')
@section('breadcrum')
    @include('layouts.parts.breadcrum')
@endsection
@section('content')
    <div class="card">
        <div class="mx-9 pt-9">

            <h3>{{ $page_title }}</h3>
        </div>
        <div class="card-header border-0 pt-6">

            <div class="card-title">
                <div class="d-flex align-items-center position-relative my-1">
                    {!! searchSvg() !!}
                    <input type="text" data-kt-user-table-filter="search" id="bank_dataTable_search"
                        class="form-control form-control-solid w-250px ps-14" placeholder="Search here..">
                </div>
            </div>
            <div class="card-toolbar">
                <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                    @php
                        $route_name = request()
                            ->route()
                            ->getName();
                    @endphp
                    @if (access()->buttonAccess($route_name, 'export'))
                        <a type="button" class="btn btn-light-primary me-3 btn-sm"
                            href="{{ route('career.export', ['type' => $page_type]) }}">
                            {!! exportSvg() !!}
                            Export
                        </a>
                    @endif
                    @if (access()->buttonAccess($route_name, 'add_edit'))
                        <a href="{{ route('gratuity.add_edit', ['type' => $page_type]) }}" class="btn btn-primary btn-sm">
                            {!! plusSvg() !!} Add {{ $title }} </a>
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
        </div>

        <div class="card-body py-4">
            <div id="kt_table_users_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                <div class="table-responsive">
                    <table class="table align-middle text-center table-hover table-bordered table-striped fs-7 no-footer"
                        id="board_table">
                        <thead class="bg-primary">
                            <tr class="text-start text-center text-muted fw-bolder fs-7 text-uppercase gs-0">
                                <th class="text-center text-white">
                                    Added At
                                </th>
                                <th class="text-center text-white">
                                    Emp Name
                                </th>
                                <th class="text-center text-white">
                                    Emp Code
                                </th>
                                <th class="text-center text-white">
                                    Cause of ending Service
                                </th>
                                <th class="text-center text-white">
                                    Gross Service
                                </th>
                                <th class="text-white">
                                    Total Emoluments
                                </th>
                                <th class="text-white">
                                    Total Payable of Gratuity
                                </th>
                                <th class="text-center text-white">
                                    Verification Status
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
    </div>
@endsection

@section('add_on_script')
    <script>
        var dtTable_o = $('#board_table').DataTable({

            processing: true,
            serverSide: true,
            order: [
                [0, "DESC"]
            ],
            type: 'POST',
            ajax: {
                "url": "{{ route('gratuity', ['type' => $page_type]) }}",
                "data": function(d) {
                    d.datatable_search = $('#bank_dataTable_search').val();
                    d.page_type = '{{ $page_type }}';
                }
            },

            columns: [{
                    data: 'created_at',
                    name: 'created_at',
                },
                {
                    data: 'staff.name',
                    name: 'name'
                },
                {
                    data: 'staff.institute_emp_code',
                    name: 'emp_code'
                },
                {
                    data: 'cause_of_ending_service',
                    name: 'cause_of_ending_service'
                },
                {
                    data: 'gross_service',
                    name: 'gross_service'
                },
                {
                    data: 'total_emuluments',
                    name: 'total_emuluments'
                },
                {
                    data: 'total_payable_gratuity',
                    name: 'total_payable_gratuity'
                },
                {
                    data: 'verification_status',
                    name: 'verification_status'
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

        $('.dataTables_wrapper').addClass('position-relative');
        $('.dataTables_info').addClass('position-absolute');
        $('.dataTables_filter label input').addClass('form-control form-control-solid w-250px ps-14');
        $('.dataTables_filter').addClass('position-absolute end-0 top-0');
        $('.dataTables_length label select').addClass('form-control form-control-solid');

        document.querySelector('#bank_dataTable_search').addEventListener("keyup", function(e) {
                dtTable_o.draw();
            }),

            $('#search-form').on('submit', function(e) {
                dtTable_o.draw();
                e.preventDefault();
            });


        function carreerChangeStatus(id, status) {

            Swal.fire({
                text: "Are you sure you would like to change status?",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Yes, Change it!",
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
                        url: "{{ route('career.change.status') }}",
                        type: 'POST',
                        data: {
                            id: id,
                            status: status
                        },
                        success: function(res) {
                            dtTable_o.ajax.reload();
                            Swal.fire({
                                title: "Updated!",
                                text: res.message,
                                icon: "success",
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-success"
                                },
                                timer: 3000
                            });

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

        function deleteCareer(id) {
            Swal.fire({
                text: "Are you sure you would like to delete record?",
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
                        url: "{{ route('career.delete') }}",
                        type: 'POST',
                        data: {
                            id: id,
                        },
                        success: function(res) {
                            dtTable_o.ajax.reload();
                            Swal.fire({
                                title: "Updated!",
                                text: res.message,
                                icon: "success",
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-success"
                                },
                                timer: 3000
                            });

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
