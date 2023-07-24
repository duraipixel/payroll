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
    <div class="card">
        <div class="card-header mt-10 text-center">
            <h3> Payroll Processing for Month {{ date('d/M/Y', strtotime($date)) }} </h3>
            @php
                $month = date('F', strtotime($date));
            @endphp
        </div>
        <div class="card-body py-4">
            <div class="text-end">
                <button class="btn btn-info my-3" type="button" onclick="return changeSalaryDetails('{{ $date }}')"> Change Salary Details </button>
            </div>
            <div id="kt_table_users_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                <div class="table-responsive">
                    <form id="revision_form">
                        @csrf
                        <table class="table align-middle  table-hover table-bordered table-striped fs-7 no-footer"
                            id="revision_table">
                            <thead class="bg-primary">
                                <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="px-3 text-primary sticky-col first-col">
                                        <div>
                                            <input role="button" type="radio" name="change_revision" value="none" id="select_all">
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
                                            @endphp
                                            @if (isset($earings_field) && !empty($earings_field))
                                                @foreach ($earings_field as $eitem)
                                                    <td class="px-3">
                                                        {{ getStaffPatterFieldAmount($item->id, $item->currentSalaryPattern->id, '', $eitem->name) }}
                                                    </td>
                                                @endforeach
                                                <td class="px-3">
                                                    {{ $item->currentSalaryPattern->gross_salary }}
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
                                                    @else
                                                        <td class="px-3">
                                                            {{ getStaffPatterFieldAmount($item->id, $item->currentSalaryPattern->id, '', $sitem->name, 'DEDUCTIONS') }}
                                                            @php
                                                                $deduction += getStaffPatterFieldAmount($item->id, $item->currentSalaryPattern->id, '', $sitem->name, 'DEDUCTIONS');
                                                            @endphp
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
                                                    $net_pay = $gross - $deduction;
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
                    $.ajax({
                        url: "{{ route('payroll.continue.processing') }}",
                        type: 'POST',
                        data: {
                            id: pattern_id
                        },
                        success: function(res) {
                            if (res.error == 0) {
                                Swal.fire({
                                    title: "Deleted!",
                                    text: res.message,
                                    icon: "success",
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn btn-success"
                                    },
                                    timer: 3000
                                });
                                getSalaryHeadFields(res.staff_id);
                            } else {
                                Swal.fire({
                                    title: "Can not Delete!",
                                    text: res.message,
                                    icon: "warning",
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn btn-danger"
                                    },
                                    timer: 3000
                                });
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
            
            if( change_revision == '' || change_revision == 'undefined' || change_revision == 'none' || typeof(change_revision) == 'undefined' ) {
                toastr.error('Error', 'Please select Employee to continue');
                return false;
            } else {
                
                let urls = "{{ url('salary/creation/') }}"+'/'+change_revision;
                console.log(urls);
                // window.open(urls);
                location.href=urls;
            }
        }
    </script>
@endsection
