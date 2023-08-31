<!--begin::Navbar-->
@extends('layouts.template')
@section('breadcrum')
    @include('layouts.parts.breadcrum')
@endsection
@section('content')
    <style>
        #reporting_table td {
            padding-left: 10px;
            padding-right: 3px;
        }
    </style>
    <div class="card">
        <div class="px-3 mt-5 mx-9">
            <h3>
                Staff List Based on Reporting Managers
            </h3>
        </div>
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <div class="d-flex align-items-center position-relative my-1">
                    
                    <div class="form-group mx-3 w-300px">
                        <label for="" class="fs-6">Reporting Managers</label>
                        <select name="staff_id" id="staff_id" class="form-control form-control-sm">
                            <option value="">All</option>
                            @isset($employees)
                                @foreach ($employees as $item)
                                    <option value="{{ $item->manager->id }}" @if (isset($staff_id) && $staff_id == $item->id) selected @endif>
                                        {{ $item->manager->name }} - {{ $item->manager->institute_emp_code }}
                                    </option>
                                @endforeach
                            @endisset
                        </select>

                    </div>
                </div>
            </div>
            <div class="card-toolbar">
                <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">

                

                </div>


            </div>
        </div>

        <div class="card-body py-4">
            <div id="kt_table_users_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                <div class="table-responsive">
                    <form id="revision_form">
                        @csrf
                        <table class="table align-middle  table-hover table-bordered table-striped fs-7 no-footer"
                            id="reporting_table">
                            <thead class="bg-primary">
                                <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                                   
                                    <th class="px-3 text-white">
                                        Emp Code
                                    </th>
                                    <th class="px-3 text-white">
                                        Emp Name
                                    </th>
                                    <th class="px-3 text-white">
                                        Added At
                                    </th>
                                    <th class="px-3 text-white">
                                        Reporting Manager
                                    </th>
                                    <th class="px-3 text-white">
                                        Reporting Manager Code
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="text-gray-600 fw-bold">
                            </tbody>
                        </table>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('add_on_script')
    <script>
        $('#staff_id').select2({
            theme: 'bootstrap-5'
        });

        var dtTable = $('#reporting_table').DataTable({

            processing: true,
            serverSide: true,
            type: 'POST',
            ajax: {
                "url": "{{ route('reporting.staff.list') }}",
                "data": function(d) {
                    d.staff_id = $('#staff_id').val();
                }
            },
            columns: [
               
                {
                    data: 'institute_emp_code',
                    name: 'institute_emp_code'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'created_at',
                    data: 'created_at'
                },
                {
                    data: 'reporting.name',
                    data: 'reporting.name'
                },
                {
                    data: 'reporting.institute_emp_code',
                    data: 'reporting.institute_emp_code'
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
            "order": [],
            "columnDefs": [{
                "targets": [0], //first column / numbering column
                "orderable": false, //set not orderable
            }, ],
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

        $('#staff_id').change(function() {
            dtTable.draw();
        })
        
    </script>
@endsection
