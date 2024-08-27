@extends('layouts.template')
@section('breadcrum')
    @include('layouts.parts.breadcrum')
@endsection
@section('content')
    <style>
        .sticky-col {
            position: -webkit-sticky;
            position: sticky;
            background-color: white !important;
        }

        .first-col {
            width: 35px;
            min-width: 35px;
            max-width: 35px;
            left: 0px;
        }

        .second-col {
            width: 150px;
            min-width: 150px;
            max-width: 150px;
            left: 35px;
        }

        .third-col {
            width: 200px;
            min-width: 200px;
            max-width: 200px;
            left: 150px;
        }
    </style>
    <div class="card position-relative">
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
        <div class="card-header mt-10 text-center">
            <h3> Payroll Processing for Month {{ date('d/M/Y', strtotime($date)) }} </h3>
            @php
                $month = date('F', strtotime($date));
                $month_length = date('t', strtotime($payroll_date));
            @endphp
        </div>
        <div class="card-body py-4" id="dynamic_content_test">
        <div class="text-end">
        <form method="POST" id="exportForm"  action="{{ route('reports.payroll.temp.export') }}">
            @csrf
            <input type="hidden" name="date" value="{{ $date }}">
            <input type="hidden" name="payout_data" value="{{ $date }}">
            <input type="hidden" name="payout_id" value="{{ $payout_id }}">
            <input type="hidden" name="process_it" value="{{ $process_it }}">
            <input type="hidden" name="working_day" value="{{ $working_day }}">
            <button type="submit" class="btn btn-sm btn-success">
                <i class="fa fa-table me-2"></i>Export
            </button>
        </form>
        &nbsp;&nbsp; &nbsp;&nbsp;
        <button class="btn btn-info my-3" type="button" onclick="return changeSalaryDetails('{{ $date }}')">
                    Change Salary Details </button>
            </div>
            <div id="kt_table_users_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                <div class="table-responsive">
                    <form id="revision_form">
                        @csrf
                        <input type="hidden" name="date" value="{{ $date }}">
                        <input type="hidden" name="payout_id" value="{{ $payout_id }}">
                        <input type="hidden" name="process_it" value="{{ $process_it }}">
                        <input type="hidden" name="working_day" value="{{ $working_day }}">
    <table class="table align-middle  table-hover table-bordered table-striped fs-7 no-footer"
                        id="revision_table">
        <thead class="bg-primary">
            <tr class="text-start text-muted fw-bolder fs-7 text-uppercase align-middle gs-0">
                <th class="px-11 text-white">
                    Emp Code
                </th>
                <th class="px-3 text-white">
                    Name
                </th>
                <th class="px-3 text-white">
                    Join Date
                </th>
                <th class="px-3 text-white">
                                        Days in Month
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
            @endphp
            @if (isset($salary_info) && !empty($salary_info))
                @foreach ($salary_info as $item)
                    <tr>
                        <td class="sticky-col first-col px-3">
                            {{ $item->staff->institute_emp_code ?? '' }}
                        </td>
                        <td class="sticky-col second-col px-3">
                 
                            {{ $item->staff->name ?? '' }}
                        </td>
                        <td class="px-3">
                            {{ $item->staff->firstAppointment->joining_date ?? '' }}
                        </td>
                        <td class="px-3">
                                                {{ $working_day ?? 0 }}
                           </td>
                           <td class="px-3">
                                                {{ $working_day ?? 0 }}
                           </td>
                                            
                        @if (isset($earings_field) && !empty($earings_field))
                            @foreach ($earings_field as $eitem)
                           
                                <td class="px-3">
                                @if(isset($item->staff))
                                    {{ amountFormat(getStaffSalaryFieldAmount($item->staff->id, $item->id, '', $eitem->name)) }}
                                    @endif
                                </td>
                           
                            @endforeach
                          
                            <td class="px-3">
                            @if(isset($item->gross_salary))
                                {{ amountFormat($item->gross_salary) }}
                                @endif
                            </td>
                           
                        @endif
                        @if (isset($deductions_field) && !empty($deductions_field))
                            @foreach ($deductions_field as $sitem)
                           
                                <td class="px-3">
                                @if(isset($item->staff))
                                    {{ amountFormat(getStaffSalaryFieldAmount($item->staff->id, $item->id, '', $sitem->name, 'DEDUCTIONS')) }}
                                    @endif
                                </td>
                               
                            @endforeach
                            <td class="px-3">
                            @if(isset($item->total_deductions))
                                {{ amountFormat($item->total_deductions) }}
                                @endif
                            </td>
                        @endif
                        <td class="px-3">
                            {{ RsFormat($item->net_salary) }}
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
                        <input type="hidden" name="total_net_pay" value="{{ $total_pay }}">
                    </form>
                </div>
                <div class="w-100 text-end mt-3">
                <label for="" class="text-end fs-3 fw-bold">
                        Total Users : Rs. {{ count($salary_info)}}
                    </label>
                    <br>
                    <label for="" class="text-end fs-3 fw-bold">
                        Total Pay : Rs. {{ $total_pay}}
                    </label>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <button class="btn btn-success" type="button" onclick="continuePayrollProcess()"> Confirm &
                            Continue Process </button>
                        <a class="btn btn-dark" href="{{ route('payroll.overview') }}"> Cancel </a>
                    </div>

                </div>
            </div>
        </div>
        <div class="position-absolute w-100 h-100 bg-white d-none" id="payroll-loading">

            <div class="h-400px d-flex justify-content-center align-items-center bg-white">
                <img src="{{ asset('assets/images/payroll-loading.gif') }}" width="200" alt="">
                <div class="text-muted">
                    Please wait while creating Payroll
                </div>
            </div>
        </div>
    </div>
@endsection

@section('add_on_script')
    <script>
        document.getElementById('exportForm').addEventListener('submit', function(event) {
    // Set the target attribute to _blank to open in a new tab
    this.target = '_blank';
     });
        function continuePayrollProcess() {
            Swal.fire({
                text: "Are you sure you would like to Continue Payroll Process?",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Yes, Do  it!",
                cancelButtonText: "No, return",
                customClass: {
                    confirmButton: "btn btn-success",
                    cancelButton: "btn btn-active-light"
                }
            }).then(function(result) {
                if (result.value) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    var formData = $('#revision_form').serialize();

                    $.ajax({
                        url: "{{ route('payroll.continue.processing') }}",
                        type: 'POST',
                        data: formData,
                        beforeSend: function() {
                            $('#payroll-loading').removeClass('d-none');
                            loading();
                        },
                        success: function(res) {
                            unloading();
                            $('#payroll-loading').addClass('d-none');

                            if (res.error == 1) {
                                toastr.error('Error', res.message);
                            } else {
                                toastr.success('Success', res.message);
                                window.location.href = "{{ url('payroll/processing/continue/') }}/"+ res.payout_id;
                            }

                        },
                        error: function(xhr, err) {
                            unloading();
                            if (xhr.status == 403) {
                                toastr.error(xhr.statusText, 'UnAuthorized Access');
                            }
                        }
                    });
                }
            });
        }

        function changeSalaryDetails(date) {

            var change_revision = $('input[name="change_revision"]:checked').val();

            if (change_revision == '' || change_revision == 'undefined' || change_revision == 'none' || typeof(
                    change_revision) == 'undefined') {
                toastr.error('Error', 'Please select Employee to continue');
                return false;
            } else {

                let urls = "{{ url('salary/creation/') }}" + '/' + change_revision;
                console.log(urls);
                // window.open(urls);
                location.href = urls;
            }
        }
    </script>
@endsection
