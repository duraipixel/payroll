@extends('layouts.template')
@section('breadcrum')
    @include('layouts.parts.breadcrum')
@endsection
@section('content')
    <div class="card">
        <form action="{{ route('reports.month.wise.variation') }}" class="input-group w-auto d-inline"
                        method="GET">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <div class="d-flex align-items-center position-relative my-1">
                    {!! searchSvg() !!}
                    <input type="text" data-kt-user-table-filter="search" id="bank_loan_datatable_search"
                        class="form-control form-control-solid w-250px ps-14" placeholder="Search User">
                </div>
            </div>
            <div class="card-toolbar">
                <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                    @php
                        $route_name = request()
                            ->route()
                            ->getName();
                    @endphp
                    <!-- @if (access()->buttonAccess($route_name, 'export'))
                        <a type="button" class="btn btn-light-primary btn-sm me-3" href="{{ route('other-income.export') }}">
                            {!! exportSvg() !!}
                            Export
                        </a>
                    @endif -->
                </div>
                 <button onclick="this.form.action = '{{ route('reports.salary.export') }}'" type="submit"
                            class="btn btn-sm btn-success"><i class="fa fa-table me-2"></i>Export</button>
                            &nbsp;&nbsp;
  <select name="month" class="form-select form-select-sm w-auto d-inline" id="month">
                            <option value="">-- select month -- </option>
                            @for ($m = 1; $m <= 12; $m++)
                                <option value="{{ $m }}" {{ $m == $month ? 'selected' : '' }}>
                                    {{ date('F', mktime(0, 0, 0, $m, 1)) }}</option>
                            @endfor
    </select>
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
</form>
        <div class="card-body py-4">
            <div id="kt_table_users_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                <div class="table-responsive">
                    <table class="table align-middle text-center table-hover table-bordered table-striped fs-7 no-footer"
                        id="data_table">
                        <thead class="bg-primary">

                            <th class="text-white text-start" >
                                S.No
                            </th>
                           
                            
                             <th class="text-white text-start" >
                               NAME
                            </th>
                             <th class="text-white text-start" >
                           DESIGINATION
                            </th>
                             <th class="text-white" >BASIC</th>
                <th class="text-white" >BASIC DA</th>
                <th class="text-white" >HRA</th>
                <th class="text-white" >TA</th>
                <th class="text-white" >PBA</th>
                <th class="text-white" >PBA DA</th>
                <th class="text-white" >DSA</th>
                <th class="text-white" >MNA</th>
                <th class="text-white" >ARR</th>
                <th class="text-white" >OTHERS</th>
                <th class="text-white" >Bonus</th>
                <th class="text-white" >GROSS</th>
                            <th class="text-white">
                              Deduction in Gross (LOP)
                            </th>
                             <th class="text-white">
                             Net Gross 
                            </th>
                           
                 <th class="text-white" >EPF</th>
                <th class="text-white" >ESI</th>
                <th class="text-white" >LIC</th>
                <th class="text-white" >BANKLOAN</th>
                <th class="text-white" >LOAN</th>
                <th class="text-white" >Income Tax</th>
                <th class="text-white" >Prof Tax</th>
                <th class="text-white" >OTHERS</th>
                <th class="text-white" >DED</th> 
                <th class="text-white">
                          NET SALARY
                            </th>
                             <th class="text-white">
                          Bank
                            </th>
                              <th class="text-white">
                           Account NO
                            </th>
                              <th class="text-white">
                          IFSC
                            </th>
                            
                             <th class="text-white">
                         ESI No
                            </th>
                            <th class="text-white">
                        ESI Name
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
        var dtTable = $('#data_table').DataTable({

            processing: true,
            serverSide: true,
            scrollX: true,
            order: [
                [0, "DESC"]
            ],
            
            ajax: {
                "url": "{{ route('reports.month.wise.variation') }}",
                "method":"POST",
                headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                "data": function(d) {
                    d.datatable_search = $('#data_search').val();
                     d.month = $('#month').val();
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
                    data: 'name',
                    name: 'NAME'
                },{
                    data: 'designation',
                    name: 'DESIGNATION'
                },
                {
                data: 'BASIC',
                name: 'BASIC'
                },
                {
                data: 'BASIC DA',
                name: 'BASIC DA'
                },
                {
                data: 'HRA',
                name: 'HRA'
                },
                {
                data: 'TA',
                name: 'TA'
                },
                {
                data: 'PBA',
                name: 'PBA'
                },
                {
                data: 'PBA DA',
                name: 'PBA DA'
                },
                {
                data: 'DSA',
                name: 'DSA'
                },
                {
                data: 'MNA',
                name: 'MNA'
                },
                {
                data: 'ARR',
                name: 'ARR'
                },
                {
                data: 'OTHERS',
                name: 'OTHERS'
                },
                {
                data: 'Bonus',
                name: 'Bonus'
                },

                {
                data: 'GROSS',
                name: 'GROSS'
                },
                {
                data: 'Deduction in Gross (LOP)',
                name: 'Deduction in Gross (LOP)'
                },{
                data: 'Net Gross',
                name: 'Net Gross'
                },
                {
                data: 'EPF',
                name: 'EPF'
                },
                {
                data: 'ESI',
                name: 'ESI'
                },
                {
                data: 'LIC',
                name: 'LIC'
                },
                {
                data: 'BANKLOAN',
                name: 'BANKLOAN'
                },
                {
                data: 'LOAN',
                name: 'LOAN'
                },
                {
                data: 'Income Tax',
                name: 'Income Tax'
                },
                {
                data: 'ProfTax',
                name: 'Prof Tax'
                },
                {
                data: 'OTHERS1',
                name: 'OTHERS'
                },
                {
                data: 'DED',
                name: 'DED'
                },
                {
                data: 'NET SALARY',
                name: 'NET SALARY'
                },{
                data: 'Bank',
                name: 'Bank'
                },{
                data: 'account_number',
                name: 'Account NO'
                },{
                data: 'ifsc_code',
                name: 'IFSC'
                }
                ,{
                data: 'ESI No',
                name: 'ESI No'
                },{
                data: 'ESI Name',
                name: 'ESI Name'
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

        document.querySelector('#data_search').addEventListener("keyup", function(e) {
            dtTable.draw();
        });
         document.querySelector('#month').addEventListener("change", function(e) {
            dtTable.draw();
        });
    </script>
@endsection
