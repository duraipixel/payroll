@extends('layouts.template')
@section('breadcrum')
    @include('layouts.parts.breadcrum')
@endsection
@section('content')
<style>
    #role_mapping_table td {
        padding: 5px;
    }
    #role_mapping_table th {
        padding: 5px;
    }

</style>
<div class="card">
    <div class="card-header border-0 pt-6">
        <div class="card-title">
            <div class="d-flex align-items-center position-relative my-1">
                {!! searchSvg() !!}
                <input type="text" data-kt-user-table-filter="search" id="role_mapping_dataTable_search"
                    class="form-control form-control-solid w-250px ps-14" placeholder="Search ">
            </div>
        </div>
        <div class="card-toolbar">
            <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
            @php
                $route_name = request()->route()->getName();               
            @endphp
            @if( access()->buttonAccess($route_name,'export') )
                <a type="button" class="btn btn-light-primary me-3 btn-sm" href="{{ route('role-mapping.export') }}">
                    {!! exportSvg() !!} 
                    Export
                </a>
            @endif
            @if( access()->buttonAccess($route_name,'add_edit') )
                <button type="button" class="btn btn-primary btn-sm" id="add_modal" onclick="getRoleMappingModal()">
                    {!! plusSvg() !!} Add Role Mapping
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
                <table class="table align-middle  table-hover table-bordered table-striped fs-7 no-footer"
                    id="role_mapping_table">
                    <thead class="bg-primary">
                        <tr class="text-start  text-muted fw-bolder fs-7 text-uppercase gs-0">
                            
                            <th class=" text-white" >
                                Staff Name
                            </th>
                            <th class=" text-white" >
                               Role
                            </th>
                            <th class=" text-white" >
                              Role Created By
                            </th>                           
                            <th class=" text-white">
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
    var dtTable = $('#role_mapping_table').DataTable({

        processing: true,
        serverSide: true,
        order: [[0, "DESC"]],
        type: 'POST',
        ajax: {
            "url": "{{ route('role-mapping') }}",
            "data": function(d) {
                d.datatable_search = $('#role_mapping_dataTable_search').val();
            }
        },

        columns: [
           
            {
                data:'staff_name',
                name:'staff_name',
            },
            {
                data: 'role_name',
                name: 'role_name'
            },
          
            {
                data: 'created_by_name',
                name: 'created_by_name'
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
        "pageLength": 25,
        "aLengthMenu": [
                [25, 50, 100, 200, -1],
                [25, 50, 100, 200, "All"]
            ]
        });

        $('.dataTables_wrapper').addClass('position-relative');
        $('.dataTables_info').addClass('position-absolute');
        $('.dataTables_filter label input').addClass('form-control form-control-solid w-250px ps-14');
        $('.dataTables_filter').addClass('position-absolute end-0 top-0');
        $('.dataTables_length label select').addClass('form-control form-control-solid');

        document.querySelector('#role_mapping_dataTable_search').addEventListener("keyup", function(e) {
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
        function getRoleMappingModal( id = '') {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var formMethod = "addEdit" ;
            $.ajax({
                url: "{{ route('role-mapping.add_edit') }}",
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
        function branchChangeStatus(id, status) {

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
            url: "{{ route('role-mapping.change.status') }}",
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
        function deleteRoleMapping(id) {
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
                        url: "{{ route('role-mapping.delete') }}",
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
