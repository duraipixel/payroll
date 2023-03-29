@extends('layouts.template')
@section('breadcrum')
    @include('layouts.parts.breadcrum')
@endsection
@section('content')
    <div class="card">

        <div class="card-header border-0 pt-6">

            <div class="card-title">

                <div class="d-flex align-items-center position-relative my-1">

                    <span class="svg-icon svg-icon-1 position-absolute ms-6">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1"
                                transform="rotate(45 17.0365 15.1223)" fill="currentColor"></rect>
                            <path
                                d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                fill="currentColor"></path>
                        </svg>
                    </span>

                    <input type="text" name="datatable_search" data-kt-user-table-filter="search"
                        id="staff_datable_search" class="form-control form-control-solid w-250px ps-14"
                        placeholder="Search user">
                </div>

            </div>

            <div class="card-toolbar">
                <div class="d-flex justify-content-end" >
                    <a href="{{ route('staff.register') }}" class="btn btn-primary" >
                        {!! plusSvg() !!}
                        Add User
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body py-4">
            <div id="kt_table_users_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                <div class="table-responsive">
                    <table class="table align-middle table-hover table-row-dashed fs-6 dataTable no-footer"
                        id="staff_table">
                        <thead>
                            <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">

                                <th class="min-w-125px sorting" tabindex="0" aria-controls="kt_table_users" rowspan="1"
                                    colspan="1" style="width: 355.733px;"
                                    aria-label="User: activate to sort column ascending">
                                    Staff Info
                                </th>
                                <th class="min-w-125px sorting" tabindex="0" aria-controls="kt_table_users" rowspan="1"
                                    colspan="1" style="width: 198.7px;"
                                    aria-label="Role: activate to sort column ascending">
                                    Email
                                </th>
                                <th class="min-w-125px sorting" tabindex="0" aria-controls="kt_table_users" rowspan="1"
                                    colspan="1" style="width: 198.7px;"
                                    aria-label="Last login: activate to sort column ascending">
                                    Emp Code
                                </th>
                                <th class="min-w-125px sorting" tabindex="0" aria-controls="kt_table_users" rowspan="1"
                                    colspan="1" style="width: 198.7px;"
                                    aria-label="Two-step: activate to sort column ascending">
                                    Institute
                                </th>
                                <th class="min-w-125px sorting" tabindex="0" aria-controls="kt_table_users" rowspan="1"
                                    colspan="1" style="width: 258.4px;"
                                    aria-label="Joined Date: activate to sort column ascending">
                                    Profile Compleation
                                </th>
                                <th class="min-w-125px sorting" tabindex="0" aria-controls="kt_table_users" rowspan="1"
                                    colspan="1" style="width: 258.4px;"
                                    aria-label="Joined Date: activate to sort column ascending">
                                    Status
                                </th>
                                <th class="text-end min-w-100px sorting_disabled" rowspan="1" colspan="1"
                                    style="width: 160.017px;" aria-label="Actions">
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
        var dtTable = $('#staff_table').DataTable({

            processing: true,
            serverSide: true,
            type: 'POST',
            ajax: {
                "url": "{{ route('staff.list') }}",
                "data": function(d) {
                    d.datatable_search = $('#staff_datable_search').val();
                }
            },

            columns: [{
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'emp_code',
                    name: 'emp_code'
                },
                {
                    data: 'institute_name',
                    name: 'institute_name'
                },
                {
                    data: 'verification_status',
                    name: 'verification_status'
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

        $('.dataTables_wrapper').addClass('position-relative');
        $('.dataTables_info').addClass('position-absolute');
        $('.dataTables_filter label input').addClass('form-control form-control-solid w-250px ps-14');
        $('.dataTables_filter').addClass('position-absolute end-0 top-0');
        $('.dataTables_length label select').addClass('form-control form-control-solid');

        document.querySelector('#staff_datable_search').addEventListener("keyup", function(e) {
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

        function staffChangeStatus(id, status) {
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
                        url: "{{ route('staff.change.status') }}",
                        type: 'POST',
                        data: {
                            id: id,
                            status: status
                        },
                        success: function(res) {
                            dtTable.ajax.reload();
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
