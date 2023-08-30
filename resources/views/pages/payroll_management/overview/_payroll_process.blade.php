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
        <div class="card-header mt-10 text-center">
            <h3> Payroll Processing for Month {{ date('d/M/Y', strtotime($date)) }} </h3>
            @php
                $month = date('F', strtotime($date));
                $month_length = date('t', strtotime($payroll_date));
            @endphp
        </div>
        <div class="card-body py-4" id="dynamic_content_test">
            <div class="text-end">
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
                                <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="px-3 text-primary sticky-col first-col">
                                        <div>
                                            <input role="button" type="radio" name="change_revision" value="none"
                                                id="select_all">
                                        </div>
                                    </th>
                                    <th class="px-3 text-primary sticky-col second-col">
                                        Emp Code
                                    </th>
                                    <th class="px-3 text-primary sticky-col third-col">
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
                                        {{-- <th class="px-3 text-white">
                                            Tax
                                        </th>
                                        <th class="px-3 text-white">
                                            Prof.Tax
                                        </th> --}}
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
                                @if (isset($payout_data) && !empty($payout_data))
                                    @foreach ($payout_data as $item)
                                        <tr>
                                            <td class="sticky-col first-col px-3">
                                                <input type="radio" name="change_revision" value="{{ $item->id }}">
                                            </td>
                                            <td class="sticky-col second-col px-3">
                                                {{ $item->society_emp_code ?? '' }}
                                            </td>
                                            <td class="sticky-col third-col px-3">
                                                {{ $item->name ?? '' }}
                                            </td>
                                            <td class="px-3">
                                                {{ $item->firstAppointment->joining_date ?? '' }}
                                            </td>
                                            <td class="px-3">
                                                {{ $working_day ?? 0 }}
                                            </td>
                                            <td class="px-3">
                                                {{ $item->workedDays->count() ?? 0 }}
                                            </td>
                                            @php
                                                $gross = $item->currentSalaryPattern->gross_salary;
                                                $deduction = 0;
                                                $earnings = 0;
                                            @endphp
                                            @if (isset($earings_field) && !empty($earings_field))
                                                @foreach ($earings_field as $eitem)
                                                    <td class="px-3">

                                                        @php
                                                            $show_earning_total = 0;
                                                            $earn_total = getStaffPatterFieldAmount($item->id, $item->currentSalaryPattern->id, '', $eitem->name, 'EARNINGS', $eitem->short_name) ?? 0;
                                                            $show_earning_total += $earn_total;
                                                            // echo strtolower(Str::singular($eitem->short_name));
                                                            $e_name = $eitem->short_name == 'Bonus' ? 'bonus': strtolower(Str::singular($eitem->short_name));
                                                            $other_earnings = getEarningInfo($item->id, $e_name, $date);
                                                            $show_earning_total += $other_earnings->amount ?? 0;
                                                            $earnings += $show_earning_total;
                                                        @endphp
                                                        {{ $show_earning_total }}
                                                    </td>
                                                @endforeach
                                                <td class="px-3">
                                                    {{-- {{ $item->currentSalaryPattern->gross_salary }} --}}
                                                    {{ $earnings }}
                                                </td>
                                            @endif
                                            @if (isset($deductions_field) && !empty($deductions_field))
                                                @foreach ($deductions_field as $sitem)
                                                    @if ($sitem->short_name == 'IT')
                                                        <td class="px-3">
                                                            {{ staffMonthTax($item->id, strtolower($month)) }}
                                                            @php
                                                                $deduction += staffMonthTax($item->id, strtolower($month));
                                                            @endphp
                                                        </td>
                                                    @elseif(trim(strtolower($sitem->short_name)) == 'other')
                                                        <td class="px-3">
                                                           
                                                            @php
                                                                $other_amount = getStaffPatterFieldAmount($item->id, $item->currentSalaryPattern->id, '', $sitem->name, 'DEDUCTIONS');
                                                                /**
                                                                 * get leave deduction amount
                                                                 */
                                                                $leave_amount_day = getStaffLeaveDeductionAmount($item->id, $date) ?? 0;
                                                                $leave_amount = 0;
                                                                if ($leave_amount_day) {
                                                                    $leave_amount = getDaySalaryAmount($gross, $month_length);
                                                                    $leave_amount = $leave_amount * $leave_amount_day;
                                                                }
                                                                $other_amount += $leave_amount;
                                                            @endphp
                                                            {{ $other_amount }}
                                                            @php
                                                                $deduction += $other_amount;
                                                            @endphp
                                                        </td>
                                                    @elseif(trim(strtolower($sitem->short_name)) == 'bank loan')
                                                        <td class="px-3">
                                                            @php
                                                                $bank_loan_amount = getStaffPatterFieldAmount($item->id, $item->currentSalaryPattern->id, '', $sitem->name, 'DEDUCTIONS');
                                                                /**
                                                                 * get leave deduction amount
                                                                 */
                                                                $other_bank_loan_amount = getBankLoansAmount($item->id, $date);
                                                                
                                                                $bank_loan_amount += $other_bank_loan_amount['total_amount'] ?? 0;
                                                            @endphp
                                                            {{ $bank_loan_amount }}
                                                            @php
                                                                $deduction += $bank_loan_amount;
                                                            @endphp
                                                        </td>
                                                    @elseif(trim(strtolower($sitem->short_name)) == 'lic')
                                                        <td class="px-3">
                                                            @php
                                                                $insurance_amount = getStaffPatterFieldAmount($item->id, $item->currentSalaryPattern->id, '', $sitem->name, 'DEDUCTIONS');
                                                                /**
                                                                 * get leave deduction amount
                                                                 */
                                                                $other_insurance_amount = getInsuranceAmount($item->id, $date);
                                                                
                                                                $insurance_amount += $other_insurance_amount['total_amount'] ?? 0;
                                                            @endphp
                                                            {{ $insurance_amount }}
                                                            @php
                                                                $deduction += $insurance_amount;
                                                            @endphp
                                                        </td>
                                                    @else
                                                        <td class="px-3">

                                                            @php
                                                                $old_deduct_amount = getStaffPatterFieldAmount($item->id, $item->currentSalaryPattern->id, '', $sitem->name, 'DEDUCTIONS');
                                                            
                                                                if( strtolower(Str::singular($sitem->short_name)) == 'other') {
                                                                    /**
                                                                     * get leave deduction amount
                                                                     */
                                                                    $leave_amount_day = getStaffLeaveDeductionAmount($item->id, $date) ?? 0;
                                                                    
                                                                    $leave_amount = 0;
                                                                    if ($leave_amount_day) {
                                                                    
                                                                        $leave_amount = getDaySalaryAmount($earnings, $month_length);
                                                                        // echo $leave_amount;
                                                                        $leave_amount = $leave_amount * $leave_amount_day;
                                                                    }
                                                                    $old_deduct_amount += $leave_amount;
                                                                }

                                                                $deduction += $old_deduct_amount;


                                                                $other_deductions = getDeductionInfo($item->id, strtolower(Str::singular($sitem->short_name)), $date);
                                                                $deduction += $other_deductions->amount ?? 0;
                                                                
                                                                $show_amount = ($old_deduct_amount ?? 0) + ($other_deductions->amount ?? 0);
                                                            @endphp
                                                            {{ $show_amount }}
                                                        </td>
                                                    @endif
                                                @endforeach
                                                <td class="px-3">
                                                    {{ $deduction }}
                                                    <br>
                                                    {{-- {{ $item->currentSalaryPattern->total_deductions ?? 0 }} --}}
                                                </td>
                                            @endif
                                            <td class="px-3">
                                                @php
                                                    $net_pay = $earnings - $deduction;
                                                    $total_net_pay = $total_net_pay + $net_pay;
                                                @endphp
                                                {{ $net_pay }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>

                        </table>
                        <input type="hidden" name="total_net_pay" value="{{ $total_net_pay }}">
                    </form>
                </div>
                <div class="w-100 text-end mt-3">
                    <label for="" class="text-end fs-3 fw-bold">
                        Total Pay : Rs. {{ $total_net_pay }}
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
                        },
                        success: function(res) {
                            $('#payroll-loading').addClass('d-none');

                            if (res.error == 1) {
                                toastr.error('Error', res.message);
                            } else {
                                toastr.success('Success', res.message);
                                $('#dynamic_content_test').html(res.html);
                            }

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
