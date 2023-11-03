@extends('layouts.template')
@section('breadcrum')
    @include('layouts.parts.breadcrum')
@endsection
@section('content')
    <div class="card">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                
            </div>
            <div class="card-toolbar">
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
                        id="bank_loan_table">
                        <thead class="bg-primary">

                            <th class="text-center text-white">
                                S.No
                            </th>
                            <th class="text-center text-white">
                               Sender 
                            </th>
                             <th class="text-center text-white">
                               Module
                            </th>
                             <th class="text-center text-white">
                                 Message
                            </th>
                             <th class="text-center text-white">
                               Read Status
                            </th>
                             <th class="text-center text-white">
                                Created At
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
        var dtTable = $('#bank_loan_table').DataTable({

            processing: true,
            serverSide: true,
            order: [
                [0, "DESC"]
            ],
            type: 'POST',
            ajax: {
                "url": "{{ route('notification.list') }}",
                "data": function(d) {
                   
                }
            },

             columns: [

                {
                    data: 'DT_RowIndex',
                    name: 'S.No',
                    orderable: false, 
                    searchable: false
                },
                {
                    data: 'sender',
                    name: 'Sender'
                },
                {
                    data: 'module',
                    name: 'Module'
                },
                {
                    data: 'message',
                    name: 'Message'
                },
                {
                    data: 'read_status',
                    name: 'Read Status'
                },
                {
                    data: 'created_at',
                    name: 'Created At'
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
                    [25, 50, 100, 200, 500, -1],
                    [25, 50, 100, 200, 500, "All"]
                ]
        });

        $('.dataTables_wrapper').addClass('position-relative');
        $('.dataTables_info').addClass('position-absolute');
        $('.dataTables_filter label input').addClass('form-control form-control-solid w-250px ps-14');
        $('.dataTables_filter').addClass('position-absolute end-0 top-0');
        $('.dataTables_length label select').addClass('form-control form-control-solid');
    </script>
@endsection
