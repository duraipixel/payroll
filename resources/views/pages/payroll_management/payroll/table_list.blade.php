<div class="card">
    <style>
        #revision_table td {
            padding-left: 10px;
            padding-right: 3px;
        }

        .sticky-col {
            position: -webkit-sticky;
            position: sticky;
            background-color: white !important;
        }

        .first-col {
            width: 150px;
            min-width: 150px;
            max-width: 150px;
            left: 0px;
        }

        .second-col {
            width: 150px;
            min-width: 150px;
            max-width: 150px;
            left: 150px;
        }

        .third-col {
            width: 200px;
            min-width: 200px;
            max-width: 200px;
            left: 300px;
        }
    </style>
    {{-- @if( !payrollCheck( $dates, 'payroll' )) --}}
    {{-- <div class="card-header border-0 pt-6">
        <div class="alert alert-danger">
            Payroll statement settings locked. Please unlock to view statements
        </div>
    </div>
    @else --}}
    <div class="card-header border-0 pt-6">
        <div class="card-title">
            <div class="d-flex align-items-center position-relative my-1">
                <input type="hidden" name="payroll_id" id="payroll_id" value="{{ $payroll_id ?? '' }}">
                <div class="form-group mx-3 w-300px">
                    <label for="" class="fs-6"> Select Employee </label>
                    <select name="staff_id" id="staff_id" class="form-control form-control-sm"
                        onchange="getTableDataPayrollList()">
                        <option value=""> All </option>
                        @isset($employees)
                            @foreach ($employees as $item)
                                <option value="{{ $item->id }}" @if (isset($staff_id) && $staff_id == $item->id) selected @endif>
                                    {{ $item->name }} - {{ $item->society_emp_code }}
                                </option>
                            @endforeach
                        @endisset
                    </select>
                </div>
                {{-- <div class="form-group">
                    <label for="" class="fs-6"> Employee Nature </label>
                    <div>
                        <select name="nature_id" id="nature_id" class="form-control form-control-sm">
                            <option value="">All</option>
                            @if (isset($employee_nature) && !empty($employee_nature))
                                @foreach ($employee_nature as $item)
                                    <option value="{{ $item->id }}"> {{ $item->name ?? '' }} </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div> --}}
            </div>
        </div>
        <div class="card-toolbar">
            <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                <button type="button" class="btn btn-light-success me-3 btn-sm" onclick="exportExcelPayroll()">
                    Export to Excel
                </button>
            </div>
        </div>
    </div>

    <div class="card-body py-4">
        <div class="dataTables_wrapper dt-bootstrap4 no-footer" id="dataTagForPayroll">
        @php
if (isset($earings_field) && !empty($earings_field)){
foreach ($earings_field as $eitem){
${$eitem->short_name}=0;
}
}
if (isset($deductions_field) && !empty($deductions_field)){
foreach ($deductions_field as $sitem){
 ${$sitem->short_name}=0;
}
}
@endphp 
<div class="table-responsive">
    <table class="table align-middle  table-hover table-bordered table-striped fs-7 no-footer" id="revision_table">
        <thead class="bg-primary">
            <tr class="text-start text-muted fw-bolder fs-7 text-uppercase align-middle gs-0">
                <th class="px-3 text-primary sticky-col first-col">
                  So No
                </th>
                <th class="px-3 text-primary sticky-col first-col">
                    Emp Code
                </th>
                <th class="px-3 text-primary sticky-col second-col">
                    Name
                </th>
                <th class="px-3 text-white">
                    Join Date
                </th>

                <th class="px-3 text-white">
                    Workdays
                </th>
                @if (isset($earings_field) && !empty($earings_field))
                    @foreach ($earings_field as $eitem)
                        <th class="px-3 text-white">
                            {{ $eitem->short_name }}
                        </th>
                    @endforeach
                    <th class="px-3 text-white">
                        Gross
                    </th>
                @endif
                @if (isset($deductions_field) && !empty($deductions_field))
                    @foreach ($deductions_field as $sitem)
                        <th class="px-3 text-white">
                            {{ $sitem->short_name }}
                        </th>
                    @endforeach
                    <th class="px-3 text-white">
                        Total Deduction
                    </th>
                @endif
                <th class="px-3 text-white w-100px">Net Pay</th>
            </tr>
        </thead>

        <tbody class="text-gray-600 fw-bold">
            @php
                $total_net_pay = 0;
                $gross_salary=0;
                $net_salary=0;
                $total_deductions=0;
            @endphp
            @if (isset($salary_info) && !empty($salary_info))
                @foreach ($salary_info as $key=>$item)
                    <tr>
                         <td class="sticky-col first-col px-3">
                            {{ $key+1 }}
                        </td>
                        <td class="sticky-col first-col px-3">
                            {{ $item->staff->society_emp_code ?? '' }}
                        </td>
                        <td class="sticky-col second-col px-3">
                         
                    <a href="{{ url('payroll/download',$item->id) }}" target="_blank">
                                <i class="fa fa-file-pdf text-danger px-1"></i>
                            </a>
                   
                            {{ $item->staff->name ?? '' }}
                        </td>
                        <td class="px-3">
                            {{ $item->staff->firstAppointment->joining_date ?? '' }}
                        </td>

                        <td class="px-3">
                            {{ $item->working_days ?? 0 }}
                        </td>
                        @if (isset($earings_field) && !empty($earings_field))
                            @foreach ($earings_field as $eitem)
                            <td class="px-3">
                                @php
                                ${$eitem->short_name}+=getStaffSalaryFieldAmount($item->staff->id, $item->id, '', $eitem->name);
                                @endphp
                               {{ amountFormat(getStaffSalaryFieldAmount($item->staff->id, $item->id, '', $eitem->name))}}
                            </td>
                            @endforeach
                            <td class="px-3">
                                {{ amountFormat($item->gross_salary) }}
                            </td>
                        @endif
                        @if (isset($deductions_field) && !empty($deductions_field))
                            @foreach ($deductions_field as $sitem)
                            @php
                            ${$sitem->short_name}+=getStaffSalaryFieldAmount($item->staff->id, $item->id, '', $sitem->name, 'DEDUCTIONS');
                            @endphp
                                <td class="px-3">
                                    {{ amountFormat(getStaffSalaryFieldAmount($item->staff->id, $item->id, '', $sitem->name, 'DEDUCTIONS')) }}
                                </td>
                            @endforeach
                            <td class="px-3">
                                {{ amountFormat($item->total_deductions) }}
                            </td>
                        @endif
                        <td class="px-3">
                            {{ amountFormat($item->net_salary) }}
                        </td>
                    </tr>
                    @php
                    $gross_salary +=$item->gross_salary;
                    $net_salary +=$item->net_salary;
                    $total_deductions+=$item->total_deductions;
                    @endphp
                @endforeach
                @if(count($salary_info)>0)
                  <tr>
                    <td class="sticky-col first-col px-3"></td>
                    <td class="sticky-col first-col px-3"></td>
                    <td class="sticky-col first-col px-3"></td>
                    <td></td>
                    <td></td>
                    @if (isset($earings_field) && !empty($earings_field))
                    @foreach ($earings_field as $eitem)
                    <td>{{ amountFormat(${$eitem->short_name}) }}</td>
                    @endforeach
                    @endif
                    <td>{{amountFormat($gross_salary)}}</td>
                    @if (isset($deductions_field) && !empty($deductions_field))
                     @foreach ($deductions_field as $sitem)
                     <td>{{ amountFormat(${$sitem->short_name}) }}</td> 
                     @endforeach
                     @endif
                    <td>{{amountFormat($total_deductions)}}</td>
                    <td>{{amountFormat($net_salary)}}</td>
                  </tr>
                  @endif
            @else 
                <tr>
                    <td> No Payroll records </td>
                </tr>
            @endif
        </tbody>

    </table>
</div>
<div class="p3">
    Total Generated : {{ $salary_count }}
</div>
<div class="row">
<section id="paginations" class="section table-footer footer-form px-4 pagination">
  <div>
    <div class="paginate">
      <div class="btn-toolbar justify-content-between" role="toolbar" aria-label="pagination">
        <div class="btn-group" role="group" aria-label="First group">
          <button type="button" class="btn btn-outline-secondary btn-light btn-sm down" id="down" value={{$page}}>
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
    <path fill-rule="evenodd" d="M11.5 8a.5.5 0 0 1-.5-.5H5.707l2.646-2.646a.5.5 0 1 1-.708-.708l-3 3a.5.5 0 0 1 0 .708l3 3a.5.5 0 1 1 .708-.708L5.707 8H11a.5.5 0 0 1 .5-.5z"/>
</svg>

        

          </button>
          <button type="button" class="btn btn-outline-secondary btn-light btn-sm">
            <span id="from"></span> @if($pageNumber===0) 0 @else {{$page  ?? 0}} @endif of {{$pageNumber}}<span id="to"></span>
          </button>
          <button type="button" class="btn btn-outline-secondary btn-light btn-sm up" id="up" value={{$page}}>
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-short" viewBox="0 0 16 16">
    <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8"/>
</svg>

          </button>
        </div>
      </div>
    </div>
  </div>
</section>
   
</div> 


        </div>
    </div>
    
    <script>
        $('#staff_id').select2({
            theme: 'bootstrap-5'
        })
      
        var month_no = '{{ $month_no }}';
        var dates = '{{ $dates }}';

        $('#up').on('click', function () {
         
            var p =parseInt(this.value);
             p +=1;
            getPayrollProcessedList(dates, month_no,p);
        });
        $('#down').on('click', function () {
            var p =parseInt(this.value);
             p -=1;
            getPayrollProcessedList(dates, month_no,p);
        });
      

        function getTableDataPayrollList() {

            var staff_id = $('#staff_id').val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('payroll.processed.list') }}",
                type: 'POST',
                data: {
                    month_no: month_no,
                    dates: dates,
                    staff_id:staff_id,
                },beforeSend:function() {
                    loading();
                },
                success: function(res) {
                    unloading();
                    $('#payroll_processed_containter').html(res);
                },
                error: function(xhr, err) {
                    if (xhr.status == 403) {
                        toastr.error(xhr.statusText, 'UnAuthorized Access');
                    }
                }
            });

        }

        function exportExcelPayroll() {

            var payroll_id = $('#payroll_id').val();
            var staff_id = $('#staff_id').val();

            if( payroll_id == '' || payroll_id == undefined || payroll_id == 'undefined' ) {
                toastr.error('Error', 'Payroll data not found');
            } else {

                var pay_url = "{{ url('payroll/statement/export') }}" + '/' + payroll_id + '/' + staff_id;
                window.open(pay_url, '_blank')
            }
       

        }
        
        function getPayrollProcessedList(dates, month_no,page='') {

$('.payroll_month').removeClass('active');
$('#payroll_month_' + month_no).addClass('active');

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$.ajax({
    url: "{{ route('payroll.processed.list') }}",
    type: 'POST',
    data: {
        month_no: month_no,
        dates:dates,
        page:page,
    },
    beforeSend:function() {
        loading();
    },
    success: function(res) {
        unloading();
         $('#payroll_processed_containter').html( res );
    },
    error: function(xhr, err) {
        if (xhr.status == 403) {
            toastr.error(xhr.statusText, 'UnAuthorized Access');
        }
    }
});

}

    </script>
   
{{-- @endif --}}