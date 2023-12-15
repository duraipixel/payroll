@extends('layouts.template')
@section('breadcrum')
    @include('layouts.parts.breadcrum')
@endsection
@section('content')
    <div class="card">
         <form action="{{ route('reports.arrears.report') }}" class="input-group w-auto d-inline"
                        method="GET">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <div class="d-flex align-items-center position-relative my-1">
                    {!! searchSvg() !!}
                   <input type="text" data-kt-user-table-filter="search" id="data_search" name="data_search"
                        class="form-control form-control-solid w-250px ps-14" placeholder="Search User" value="{{request()->data_search}}">
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
                <!-- @if (access()->buttonAccess($route_name, 'export'))
                 <button onclick="this.form.action = '{{ route('reports.arrear.export') }}'" type="submit"
                            class="btn btn-sm btn-success"><i class="fa fa-table me-2"></i>Export</button>
                      @endif -->
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
                        id="bank_loan_table">
                        <thead class="bg-primary">

                            <th class="text-white text-start ps-3" rowspan="2">
                                S.No
                            </th>
                             <th class="text-white text-start ps-3" rowspan="2">
                                DOJ
                            </th>
                             <th class="text-white text-start ps-3" rowspan="2">
                                Emp ID
                            </th>
                             <th class="text-white text-start ps-3" rowspan="2">
                                Name
                            </th>
                             <th class="text-white text-start ps-3" rowspan="2">
                                DESIGNATION
                            </th>
                             <th class="text-white text-start ps-3" colspan="3">
                                 Casual Leave (CL)
                             </th>
                             <th class="text-white text-start ps-3" colspan="2">
                                Granted Leave (GL)
                             </th>
                              <th class="text-white text-start ps-3" colspan="5">
                               Earned Leave (EL)
                             </th>
                              <th class="text-white text-start ps-3" colspan="3">
                             Matrenity Leave (ML) - 90 days
                             </th>
                              <th class="text-white text-start ps-3" colspan="3">
                           EOL (Loss of Pay)
                             </th>
                              </tr>
            <tr>
                <th class="text-white" >Eligible</th>
                <th class="text-white" >Availed</th>
                <th class="text-white" >Balance</th>
                <th class="text-white" >Sanctioned</th>
                <th class="text-white" >Balance</th>

        <th class="text-white" >Accumalted</th>
        <th class="text-white" >Current yr</th>
        <th class="text-white" >Total (L+M)</th>
        <th class="text-white" >Availed</th>
        <th class="text-white" >Balance</th>

        <th class="text-white" >Eligible</th>
        <th class="text-white" >Availed</th>
        <th class="text-white" >Balance</th>

        <th class="text-white" >Eligible</th>
        <th class="text-white" >Amount deducted</th>
        <th class="text-white" >Reason</th>

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
                "url": "{{ route('leave.report') }}",
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
                    data: 'doj',
                    name: 'DOJ'
                },
                {
                    data: 'emp_id',
                    name: 'Emp ID'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'designation',
                    name: 'DESIGNATION'
                },
                {
                    data: 'cl_eligible',
                    name: 'Eligible'
                },{
                    data: 'cl_availed',
                    name: 'Availed'
                },{
                    data: 'cl_balance',
                    name: 'Balance'
                },{
                    data: 'gl_sanctioned',
                    name: 'Sanctioned'
                },{
                    data: 'gl_availed',
                    name: 'Availed'
                },{
                    data: 'eol_reason',
                    name: 'Accumalted'
                },{
                    data: 'eol_reason',
                    name: 'current yr'
                },{
                    data: 'eol_reason',
                    name: 'Total'
                },{
                    data: 'el_availed',
                    name: 'Availed'
                },{
                    data: 'el_balance',
                    name: 'Balance'
                },{
                    data: 'ml_eligible',
                    name: 'Eligible'
                },{
                    data: 'ml_availed',
                    name: 'Availed'
                },{
                    data: 'ml_balance',
                    name: 'Balance'
                },{
                    data: 'eol_availed',
                    name: 'Availed'
                },{
                    data: 'eol_amount',
                    name: 'Amount deducted'
                },{
                    data: 'eol_reason',
                    name: 'Reason'
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
