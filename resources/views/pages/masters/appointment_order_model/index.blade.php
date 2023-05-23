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
                <input type="text" data-kt-user-table-filter="search" id="appointment_order_dataTable_search"
                    class="form-control form-control-solid w-250px ps-14" placeholder="Search School">
            </div>
        </div>
        <div class="card-toolbar">
            <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">

                @php
                $route_name = request()->route()->getName();               
                @endphp
                @if( access()->buttonAccess($route_name,'add_edit') )
                    <a class="btn btn-primary btn-sm" id="add_modal" href="{{ route('appointment.orders.add') }}" >
                    {!! plusSvg() !!} Add Appointment Order
                </a>
                @endif
                {{-- <button type="button" class="btn btn-primary btn-sm" id="add_modal" onclick="getAppointmentOrderModal()">
                    {!! plusSvg() !!} Add Appointment Order
                </button> --}}

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
                    id="appointment_order_table">
                    <thead class="bg-primary">
                        <tr class="text-start text-center text-muted fw-bolder fs-7 text-uppercase gs-0">
                            <th class="text-center text-white" >
                            Date
                        </th>
                            <th class="text-center text-white" >
                                Appointment Order Name
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
    <!--end::Card body-->
</div>


@endsection

@section('add_on_script')

<script>
    var dtTable = $('#appointment_order_table').DataTable({

        processing: true,
        serverSide: true,
        order: [[0, "DESC"]],
        type: 'POST',
        ajax: {
            "url": "{{ route('appointment.orders') }}",
            "data": function(d) {
                d.datatable_search = $('#appointment_order_dataTable_search').val();
            }
        },

        columns: [
            {
                data: 'created_at',
                name: 'created_at',
            },
            {
                data: 'name',
                name: 'name'
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

        document.querySelector('#appointment_order_dataTable_search').addEventListener("keyup", function(e) {
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
        
</script>

@endsection