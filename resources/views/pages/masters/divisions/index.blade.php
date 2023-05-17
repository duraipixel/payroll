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
                <input type="text" data-kt-user-table-filter="search" id="division_datable_search"
                    class="form-control form-control-solid w-250px ps-14" placeholder="Search Division">
            </div>
        </div>
        <div class="card-toolbar">
            <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
            @php
                $route_name = request()->route()->getName();               
            @endphp
            @if( access()->buttonAccess($route_name,'export') )
                <a type="button" class="btn btn-light-primary me-3 btn-sm" href="{{ route('division.export') }}">
                    {!! exportSvg() !!}Export
                </a>
            @endif
            @if( access()->buttonAccess($route_name,'add_edit') )
                <button type="button" class="btn btn-primary btn-sm" id="add_modal" onclick="getDivisionsModal()">
                    {!! plusSvg() !!} Add Division
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
    </div>

    <div class="card-body py-4">
        <div id="kt_table_users_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
            <div class="table-responsive">
                <table class="table align-middle text-center table-hover table-bordered table-striped fs-7 no-footer"
                    id="division_table">
                    <thead class="bg-primary">
                        <tr class="text-start text-center text-muted fw-bolder fs-7 text-uppercase gs-0">
                            <th class="text-center text-white" >
                            Date
                        </th>
                            <th class="text-center text-white" >
                                Division Name
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
    var dtTable = $('#division_table').DataTable({

        processing: true,
        serverSide: true,
        order: [[0, "DESC"]],
        type: 'POST',
        ajax: {
            "url": "{{ route('division') }}",
            "data": function(d) {
                d.datatable_search = $('#division_datable_search').val();
            }
        },

        columns: [
            {
                data: 'created_at',
                name: 'created_at',
            },
            {
                data: 'name',
                name: 'name',
                bSortable: true,
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

        document.querySelector('#division_datable_search').addEventListener("keyup", function(e) {
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
        function getDivisionsModal( id = '') {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var formMethod = "addEdit" ;
            $.ajax({
                url: "{{ route('division.add_edit') }}",
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
        function divisionsChangeStatus(id, status) {

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
            url: "{{ route('division.change.status') }}",
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
        function deleteDivisions(id) {
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
                        url: "{{ route('division.delete') }}",
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
</script>

@endsection
