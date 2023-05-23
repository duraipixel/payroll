@extends('layouts.template')
@section('breadcrum')
    @include('layouts.parts.breadcrum')
@endsection
@section('content')
    <div class="card">

        <div class="card-header border-0 pt-6">

            <div class="card-title">

                <div class="d-flex align-items-center position-relative my-1">

                    {!! searchSvg() !!}
                    <input type="text" name="datatable_search" data-kt-user-table-filter="search"
                        id="staff_datable_search" class="form-control form-control-solid w-250px ps-14"
                        placeholder="Search user">
                </div>

            </div>
            @php
            $route_name = request()->route()->getName();               
        @endphp
       
         @if( access()->buttonAccess($route_name,'add_edit') )
            <div class="card-toolbar">
                <div class="d-flex justify-content-end" >
                    <a href="{{ route('staff.register') }}" class="btn btn-primary btn-sm" >
                        {!! plusSvg() !!}
                        Add User
                    </a>
                </div>
            </div>
            @endif

        </div>

        <div class="card-body py-4">
            <div id="kt_table_users_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                <div class="table-responsive">
                    <table class="table align-middle text-center table-hover table-bordered table-striped fs-7 no-footer"
                        id="staff_table">
                        <thead class="bg-primary">
                            <tr class="text-start text-center text-muted fw-bolder fs-7 text-uppercase gs-0">
                                <th class="text-center text-white" >
                                    Staff Info
                                </th>
                                <th class="text-center text-white" >
                                    Society Code
                                </th>
                                <th class="text-center text-white" >
                                    Institution Code
                                </th>
                                <th class="text-center text-white" >
                                    Emp Code
                                </th>
                                <th class="text-center text-white" >
                                    Profile Compleation
                                </th>
                                <th class="text-center text-white" >
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
                    data: 'society_emp_code',
                    name: 'society_emp_code'
                },
                {
                    data: 'institute_emp_code',
                    name: 'institute_emp_code'
                },
                {
                    data: 'emp_code',
                    name: 'emp_code'
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
