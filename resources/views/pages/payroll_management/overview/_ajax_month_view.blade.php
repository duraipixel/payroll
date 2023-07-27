<style>
    @keyframes to-right-1 {
        from {
            right: calc(100% - 100px);
            ;
        }

        to {
            right: 0px;
        }
    }

    @keyframes to-right-2 {
        from {
            transform: translateX(100%);
        }

        to {
            transform: translateX(0%);
        }
    }

    #payroll_overview_data {
        animation: to-right-2 0.4s linear forwards;

    }

    .pl-btn {
        padding: 5px;
        font-size: 12px;
        width: 66px;
        align-items: center;
        display: flex;
        justify-content: center;
        background: #f7f3f3;
        box-shadow: 1px 1px 1px 1px #f0efef;
    }

    .active.pl-btn {
        background: green;
        color: white;
        box-shadow: 1px 1px 1px 1px green;
    }
</style>
<div id="payroll_overview_data">
    @if (isset($payroll) && !empty($payroll))
        @php
            $month_start_no = date('m', strtotime($date) );
        @endphp
        <div class="container bg-primary bg-light-outline">
            <div class="py-5 mt-3 d-flex justify-content-between align-items-center">
                <div class="fs-3 fw-bold text-white"> 
                    {{ date('F Y', strtotime($date)) }} 
                    <div>
                        @if( isset($payroll->payroll_date) && !empty( $payroll->payroll_date) )
                        <label class="badge badge-light-success"> Payroll processed on {{ date('d/M/Y', strtotime($payroll->payroll_date)) }} </label>
                        @else 
                        <label class="badge badge-light-danger"> Payroll not processed </label>
                        @endif
                    </div>
                </div>
                <div>
                    @if( isset( $lock_info->payroll_lock ) && !empty( $lock_info->payroll_lock ) ) 
                    <label class="badge badge-light-danger">Payroll Locked on {{ date('d/M/Y H:i A', strtotime($lock_info->payroll_lock)) }}</label>
                    @else
                    <button class="btn btn-light-success" id="process_payroll_btn" onclick="processPayroll('{{ $date }}')">
                        Process Payroll
                    </button>
                    @endif
                   
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 p-5">
                <div class="container">

                    <div class="fs-3 fw-bold text-muted "> 
                        Payout Details 
                        <a href="{{ route('payroll.list') }}" class="small float-end" > 
                            <i class="fa fa-eye"></i>
                            View Details 
                        </a>

                    </div>
                    @php
                        $leave_chart_data = [ $payroll->salaryStaff->sum('net_salary') ?? 0 , $payroll->salaryStaff->sum('gross_salary') ?? 0, $payroll->salaryStaff->sum('total_deductions') ?? 0];
                        $leave_chart_label = ['Net Pay', 'Gross Pay', 'Deductions'];
                    @endphp
                    <div class="d-flex flex-center me-9 my-5">
                        <canvas id="leave_chart" style="height: 200px; width: 100%;"></canvas>
                    </div>
                    <div>
                        <table class="w-100">
                            <tr>
                                <td class="w-50">
                                    <div>
                                        <span class="bullet bg-info mb-1 me-2"
                                            style="background-color: #8ca1ed"></span>
                                        <span class="secondary-info fs-6">Rs {{ $payroll->salaryStaff->sum('net_salary') ?? 0 }}</span>
                                    </div>
                                    <div class="card-subinfo ptl1 ms-5 text-muted small">Net Pay</div>
                                </td>
                                <td class="w-50">
                                    <div>
                                        <span class="bullet bg-success mb-1 me-2"
                                            style="background-color: #34c349"></span>
                                        <span class="secondary-info fs-6">Rs {{ $payroll->salaryStaff->sum('gross_salary') ?? 0 }}</span>
                                    </div>
                                    <div class="card-subinfo ptl1 ms-5 text-muted small">Gross Pay</div>
                                </td>
                            <tr class="">
                                <td class="w-50 pt-3">
                                    <div>
                                        <span class="bullet bg-danger mb-1 me-2"
                                            style="background-color: #ad5b2b"></span>
                                        <span class="secondary-info fs-6">Rs {{ $payroll->salaryStaff->sum('total_deductions') ?? 0 }}</span>
                                    </div>
                                    <div class="card-subinfo ptl1 ms-5 text-muted small">Total Deduction</div>
                                </td>
                                <td class="w-50">
                                    <div>
                                        <span class="bullet bg-primary mb-1 me-2"
                                            style="background-color: #a6b7f7"></span>
                                        <span class="secondary-info fs-6">{{ $working_days ?? 0 }}</span>
                                    </div>
                                    <div class="card-subinfo ptl1 ms-5 text-muted small">Working Days</div>
                                </td>
                            </tr>
                            <tr class="">
                                <td class="w-50 pt-3">
                                    <div>
                                        <span class="bullet bg-primary mb-1 me-2"
                                            style="background-color: #a6b7f7"></span>
                                        <span class="secondary-info fs-6">{{ $payroll->salaryStaff->count() ?? 0 }}</span>
                                    </div>
                                    <div class="card-subinfo ptl1 ms-5 text-muted small">Paid Employee</div>
                                </td>
                                <td class="w-50">
                                  
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="d-flex  p-3 fs-4 border border-3 mt-5 align-items-center">
                    <div class="w-50">
                        Payroll Input
                        <div>
                            <div class="small badge badge-light-info"> Salary Creation </div>
                            {{-- <div class="small badge badge-light-info"> Salary Revision </div> --}}
                            <div class="small badge badge-light-info"> Hold Salary </div>
                        </div>
                    </div>
                    <div class="payroll-radio w-50 h-25 d-flex justify-content-end">
                        <span class="@if (isset($lock_info) && $lock_info->payroll_inputs == 'unlock') active @endif pl-btn payroll_inputs"
                            role="button" onclick="setPayrollSetting('payroll_inputs', 'unlock', this)">
                            Unlock </span>
                        <span class="pl-btn @if (isset($lock_info) && $lock_info->payroll_inputs == 'lock') active @endif payroll_inputs"
                            role="button" onclick="setPayrollSetting('payroll_inputs', 'lock', this)"> Lock
                        </span>
                    </div>
                </div>
                <div class="d-flex p-3 fs-4 border border-3 align-items-center">
                    <div class="w-50"> 
                        Employee View Release 
                        <div>
                            <div class="small badge badge-light-info"> Publish Payslip </div>
                        </div>
                    </div>
                    <div class="payroll-radio w-50 h-25 d-flex justify-content-end">
                        <span class="pl-btn emp_view_release @if (isset($lock_info) && $lock_info->emp_view_release == 'unlock') active @endif"
                            role="button" onclick="setPayrollSetting('emp_view_release', 'unlock', this)"> Unlock
                        </span>
                        <span class="pl-btn emp_view_release @if (isset($lock_info) && $lock_info->emp_view_release == 'lock') active @endif"
                            role="button" onclick="setPayrollSetting('emp_view_release', 'lock', this)"> Lock
                        </span>
                    </div>
                </div>
                {{-- <div class="d-flex  p-3 fs-4 border border-3 align-items-center">
                    <div class="w-50"> 
                        It Statement Employee View 
                        <div>
                            <div class="small badge badge-light-info"> Add, Update, Delete Income Tax Income, Deduction and others  </div>
                        </div>
                    </div>
                    <div class="payroll-radio w-50 h-25 d-flex justify-content-end">
                        <span class="pl-btn it_statement_view @if (isset($lock_info) && $lock_info->it_statement_view == 'unlock') active @endif"
                            role="button" onclick="setPayrollSetting('it_statement_view', 'unlock', this)"> Unlock
                        </span>
                        <span class="pl-btn it_statement_view @if (isset($lock_info) && $lock_info->it_statement_view == 'lock') active @endif"
                            role="button" onclick="setPayrollSetting('it_statement_view', 'lock', this)"> Lock
                        </span>
                    </div>
                </div> --}}
                <div class="d-flex p-3 fs-4 border border-3 align-items-center">
                    <div class="w-50">
                        Payroll Statement
                        <div>
                            <div class="small badge badge-light-info"> View and Export Payroll Statement </div>
                        </div>
                    </div>
                    <div class="payroll-radio w-50 h-25 d-flex justify-content-end">
                        <span class="pl-btn payroll @if (isset($lock_info) && $lock_info->payroll == 'unlock') active @endif" role="button"
                            onclick="setPayrollSetting('payroll', 'unlock', this)"> Unlock </span>
                        <span class="pl-btn payroll @if (isset($lock_info) && $lock_info->payroll == 'lock') active @endif" role="button"
                            onclick="setPayrollSetting('payroll', 'lock', this)"> Lock
                        </span>
                    </div>
                </div>
                    <div class="d-flex p-3 fs-4 border border-3 align-items-center">
                        <div class="w-50">
                            Payroll Process
                           
                        </div>
                        <div class="payroll-radio w-50 h-25 d-flex justify-content-end">
                            <span class="pl-btn payroll @if (isset($lock_info) && $lock_info->payroll_lock == null) active @endif" role="button"
                                onclick="setPayrollSetting('payroll_lock', 'unlock', this)"> Unlock </span>
                            <span class="pl-btn payroll @if (isset($lock_info) && !empty($lock_info->payroll_lock)) active @endif" role="button"
                                onclick="setPayrollSetting('payroll_lock', 'lock', this)"> Lock
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            var payout_date = '{{ $date }}';
            var payout_id = '{{ $payroll->id ?? 0 }}';
            $(document).ready(function() {
                $("#payroll_overview_container").animate({
                    right: '0%'
                }, 'slow');
                var canvas = document.getElementById('leave_chart');
                var context = canvas.getContext('2d');

                var config = {
                    type: 'doughnut',
                    data: {
                        datasets: [{
                            data: @json($leave_chart_data),
                            backgroundColor: [ '#00A3FF', '#43a43c','#cf6262',]
                        }],
                        labels: @json($leave_chart_label)
                    },
                    options: {
                        chart: {
                            fontFamily: 'inherit'
                        },
                        cutout: '65%',
                        cutoutPercentage: 70,
                        responsive: true,
                        maintainAspectRatio: false,
                        title: {
                            display: false
                        },
                        animation: {
                            animateScale: true,
                            animateRotate: true
                        },
                        tooltips: {
                            enabled: true,
                            intersect: false,
                            mode: 'nearest',
                            bodySpacing: 30,
                            yPadding: 30,
                            xPadding: 30,
                            caretPadding: 0,
                            displayColors: false,
                            backgroundColor: '#20D489',
                            titleFontColor: '#ffffff',
                            cornerRadius: 5,
                            footerSpacing: 0,
                            titleSpacing: 20
                        },
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                };
                var myDoughnut = new Chart(canvas, config);

            })

            function setPayrollSetting(mode_name, status, element) {

                if ((mode_name == 'payroll_inputs' && mode_name == 'payroll') && status == 'lock') {

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url: "{{ route('payroll.open.permission') }}",
                        type: 'POST',
                        data: {
                            status: status,
                            mode: mode_name,
                            payout_date: payout_date,
                            payout_id: payout_id
                        },
                        success: function(res) {
                            $('#kt_dynamic_app').modal('show');
                            $('#kt_dynamic_app').html(res);
                        },
                        error: function(xhr, err) {
                            if (xhr.status == 403) {
                                toastr.error(xhr.statusText, 'UnAuthorized Access');
                            }
                        }
                    });

                } else {
                    var msg = '';
                    if (mode_name == 'emp_view_release') {
                        msg = 'Employee View Release';
                    } else if (mode_name == 'payroll_inputs') {
                        msg = 'Payroll Inputs';
                    } else if (mode_name == 'payroll') {
                        msg = 'Payroll';
                    } else if( mode_name == 'payroll_lock') {
                        msg = 'Payroll Lock';
                    } else { 
                        msg = 'It Statement Employee View';
                    }

                    Swal.fire({
                        text: "Are you sure you would like to " + status + " " + msg + '?',
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
                                url: "{{ route('payroll.set.permission') }}",
                                type: 'POST',
                                data: {
                                    status: status,
                                    mode: mode_name,
                                    payout_date: payout_date,
                                    payout_id: payout_id
                                },
                                success: function(res) {
                                    // dtTable.ajax.reload();
                                    $('.' + mode_name).removeClass('active');
                                    $(element).addClass('active');
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
                                    getPayrollOverviewInfo('{{ $date }}', '{{ $month_start_no }}');
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

            }
        </script>
    @else
        <div class="container h-400px justify-content-center">
            @if (isset($previous_payroll) && !empty($previous_payroll))
                <div class="h-400px d-flex justify-content-center align-items-center d-none" id="payroll-loading">
                    <img src="{{ asset('assets/images/payroll-loading.gif') }}" width="200" alt="">
                    <div class="text-muted">
                        Please wait while creating Payroll
                    </div>
                </div>

                <div class="h-400px d-flex justify-content-center align-items-center" id="payroll-content-create">

                    <button class="btn btn-primary" type="button"
                        onclick="return createPayroll('{{ $date }}')"> Create
                        {{ date('F Y', strtotime($date)) }} Payroll </button>
                </div>
            @else
                <div class="h-400px d-flex justify-content-center align-items-center" id="payroll-content-create">
                    <label class="alert alert-danger"> Previous month Payroll not created </label>
                </div>
            @endif

        </div>
    @endif
</div>
<script>
    function createPayroll(payroll_date) {

        Swal.fire({
            text: "Are you sure you would like to start payroll process?",
            icon: "warning",
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonText: "Yes, Do it!",
            cancelButtonText: "No, return",
            customClass: {
                confirmButton: "btn btn-danger",
                cancelButton: "btn btn-active-light"
            }
        }).then(function(result) {
            if (result.value) {
                $('#payroll-content-create').addClass('d-none');
                $('#payroll-loading').removeClass('d-none');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ route('payroll.create') }}",
                    type: 'POST',
                    data: {
                        payroll_date: payroll_date
                    },
                    success: function(res) {

                        getPayrollOverviewInfo(res.date, res.month_no)
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

    function processPayroll(date) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('payroll.process.modal') }}",
            type: 'POST',
            data: {
                date:date,
                payout_id: payout_id
            },
            beforeSend: function(){
                $('#process_payroll_btn').attr('disabled', true);
            },
            success: function(res) {
                $('#process_payroll_btn').attr('disabled', false);
                $('#kt_dynamic_app').modal('show');
                $('#kt_dynamic_app').html(res);
            },
            error: function(xhr, err) {
                if (xhr.status == 403) {
                    toastr.error(xhr.statusText, 'UnAuthorized Access');
                }
            }
        });
    }
</script>
