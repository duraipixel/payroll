@extends('layouts.template')
@section('breadcrum')
    @include('layouts.parts.breadcrum')
@endsection
@section('content')
    <style>
        #staff_table td {
            padding-left: 10px;
        }

        #staff_table_filter {
            display: none;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.css" />
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.js"></script>
    <div class="card">

        <div class="card-header border-0 pt-6">

            <div class="card-title">

                <form id="staff_search_form">
                <div class="d-flex align-items-center position-relative my-1">
                        <div>
                            {!! searchSvg() !!}
                            <input type="text" name="datatable_search" data-kt-user-table-filter="search"
                                id="staff_datable_search" class="form-control form-control-solid w-250px ps-14"
                                placeholder="Search user" value="{{ session()->get('datatable_search') ?? '' }}">
                        </div>

                        <div class="form-group">
                            <select name="verification_status" id="verification_status" class="form-control">
                                <option value=""> All Profile Status </option>
                                <option value="pending" @if( session()->has('verification_status') && session()->get('verification_status' ) == 'pending' ) selected @endif>Pending</option>
                                <option value="approved" @if( session()->has('verification_status') && session()->get('verification_status' ) == 'approved' ) selected @endif>Approved</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <select name="datatable_institute_id" id="datatable_institute_id" class="form-control">
                                <option value=""> All Institution </option>
                                @if (isset($institutions) && !empty($institutions))
                                    @foreach ($institutions as $item)
                                        <option value="{{ $item->id }}" @if( session()->has('datatable_institute_id') && session()->get('datatable_institute_id' ) == $item->id ) selected @endif> {{ $item->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Search</button>
                            <a href="{{route('staff.list')}}" class="btn btn-success">Reset</a>
                        </div>
                    </div>
                </form>

            </div>
            @php
                $route_name = request()
                    ->route()
                    ->getName();
                
            @endphp

            @if (access()->buttonAccess($route_name, 'add_edit'))
                <div class="card-toolbar">
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('staff.register') }}" class="btn btn-primary btn-sm">
                            {!! plusSvg() !!}
                            Add User
                        </a>
                    </div>
                </div>
            @endif

        </div>

        {{-- <div class="card-body py-4">
            <div id="kt_table_users_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                <div class="table-responsive">
                    <table class="table align-middle table-hover table-bordered table-striped fs-7 no-footer"
                        id="staff_table">
                        <thead class="bg-primary">
                            <tr class="text-start text-center text-muted fw-bolder fs-7 text-uppercase gs-0">

                                <th class="text-white text-start ps-3">
                                    Staff Info
                                </th>
                                <th class="text-white text-start ps-3">
                                    Society Code
                                </th>
                                <th class="text-white text-start ps-3">
                                    Institution Code
                                </th>
                                <th class="text-white text-start ps-3">
                                    Profile Completion
                                </th>
                                <th class="text-white">
                                    Status
                                </th>
                                <th class="text-white">
                                    Actions
                                </th>
                            </tr>
                        </thead>

                        <tbody class="text-gray-600 fw-bold">
                        </tbody>
                    </table>
                </div>

            </div>
        </div> --}}
        <div class="card-body p-2">
            <div class="table-responsive">
                @include('pages.staff._table')
            </div>
        </div>
        <div class="card-footer p-2 bg-light">
            {!! $post_data->links('vendor.pagination.bootstrap-5') !!}
        </div>
    </div>
@endsection

@section('add_on_script')
    <script>
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
                            staff_Table.ajax.reload();
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

        function deleteStaff(id) {

            Swal.fire({
                text: "Are you sure you would like to delete?",
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
                        url: "{{ route('staff.delete') }}",
                        type: 'POST',
                        data: {
                            id: id
                        },
                        success: function(res) {
                            staff_Table.ajax.reload();
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
