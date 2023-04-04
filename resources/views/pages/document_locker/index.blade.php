<!--begin::Navbar-->
@extends('layouts.template')
@section('breadcrum')
    @include('layouts.parts.breadcrum')
@endsection
@section('content')
    <!--begin::Card-->
    <div class="card">
        <div class="card-title">
            <h4 class="ms-10 mt-10"><strong>Search Staff</strong></h4>
        </div>
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
             
            <!--begin::Card title-->
            <div class="card-title">
               
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1">
                    <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                    <span class="svg-icon svg-icon-1 position-absolute ms-6">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1"
                                transform="rotate(45 17.0365 15.1223)" fill="currentColor"></rect>
                            <path
                                d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                fill="currentColor"></path>
                        </svg>
                    </span>
                    
                    <!--end::Svg Icon-->
                    <input type="text" data-kt-user-table-filter="search" id="institution_datable_search123"
                        class="typeahead  form-control form-control-solid w-300px ps-14" placeholder="Search Staff Name or Staff ID">
                    <select class="form-select ms-4" id="search_institutions" style="width:140px;" >
                        <option>Institutions</option>
                        <option>Select SelectSelectSelectSelectSelectSelectSelect </option>
                    </select>
                    <select class="form-select ms-4" id="search_institutions w-200px" style="width:140px;" >
                        <option>Staff Type </option>
                        <option>Select SelectSelectSelectSelectSelectSelectSelect </option>
                    </select>
                    <select class="form-select ms-4" id="search_institutions w-200px" style="width:140px;" >
                        <option>Designation</option>
                        <option>Select SelectSelectSelectSelectSelectSelectSelect </option>
                    </select>
                    <select class="form-select ms-4" id="search_institutions w-200px" style="width:140px;" >
                        <option>Gender </option>
                        <option>Select SelectSelectSelectSelectSelectSelectSelect </option>
                    </select>
                    <button type="button" class="btn btn-primary ms-7">Search</button>
                    </div>
                <!--end::Search-->
            </div>
            <div class="card-title">
                <h4 class="mt-5"><strong>Document Locker</strong></h4>
            </div>
            <div class="count_deatils mt-5">
                <div class="row">
                    <div class="col-md-4 staff_count_dl">
                        <p class="ss_count_text">Total Number of Staff</p>
                        <p class="ss_count">650 </p>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z"/></svg>
                    </div>
                    <div class="col-md-4 staff_count_dl">
                        <p class="ss_count_text">Total Number of Documents Uploaded</p>
                        <p class="ss_count1">650 </p>
                    </div>
                    <div class="col-md-4 staff_count_dl ">
                        <p class="ss_count_text">Documents Review Pending </p>
                        <p class="ss_count1">650 </p>
                    </div>
                </div>
            </div>
            <!--begin::Card title-->
            <!--begin::Card toolbar-->
            

        <div class="card-body py-4">
            <div id="kt_table_users_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                <div class="table-responsive">
                    <table class="table align-middle table-hover table-row-dashed fs-6 dataTable no-footer"
                        id="document_locker_table">
                        <thead>
                            <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">

                                <th class="min-w-125px sorting" tabindex="0" aria-controls="kt_table_users" rowspan="1"
                                    colspan="1" style="width: 355.733px;"
                                    aria-label="User: activate to sort column ascending">
                                    Name
                                </th>

                                <th class="min-w-125px sorting" tabindex="0" aria-controls="kt_table_users" rowspan="1"
                                    colspan="1" style="width: 198.7px;"
                                    aria-label="Last login: activate to sort column ascending">
                                    Code
                                </th>
                                <th class="min-w-125px sorting" tabindex="0" aria-controls="kt_table_users" rowspan="1"
                                    colspan="1" style="width: 198.7px;"
                                    aria-label="Last login: activate to sort column ascending">
                                    Society
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
        <!--end::Card body-->
    </div>
    <!--end::Card-->
@endsection

@section('add_on_script')

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>

    <script>
        var dtTable = $('#institution_table').DataTable({

            processing: true,
            serverSide: true,
            type: 'POST',
            ajax: {
                "url": "{{ route('institutions') }}",
                /*"data": function(d) {
                    d.datatable_search = $('#institution_datable_search').val();
                }*/
            },

            columns: [{
                    data: 'name',
                    name: 'name'
                },

                {
                    data: 'code',
                    name: 'code'
                },
                {
                    data: 'society',
                    data: 'society'
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

      

            $('#search-form').on('submit', function(e) {
                dtTable.draw();
                e.preventDefault();
            });
        $('#search-form').on('reset', function(e) {
            $('select[name=filter_status]').val(0).change();

            dtTable.draw();
            e.preventDefault();
        });

        function institutionChangeStatus(id, status) {

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
                        url: "{{ route('institutions.change.status') }}",
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

        $('#kt_common_add_form').on('hidden.bs.modal', function() {
            $(this).find('form').trigger('reset');
        })

        function getInstituteModal( id = '') {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('institutions.add_edit') }}",
                type: 'POST',
                data: {
                    id: id,
                },
                success: function(res) {
                    $('#kt_dynamic_app').modal('show');
                    $('#kt_dynamic_app').html(res);
                }
            })

        }

        function deleteInstitution(id) {
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
                        url: "{{ route('institutions.delete') }}",
                        type: 'POST',
                        data: {
                            id: id,
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
       
        var route = "{{ url('autocomplete-search') }}";
        $('#institution_datable_search123').typeahead({
            source: function (query, process) {
                return $.get(route, {
                    query: query
                }, function (data) {
                    return process(data);
                });
            }
        });


    </script>
@endsection
