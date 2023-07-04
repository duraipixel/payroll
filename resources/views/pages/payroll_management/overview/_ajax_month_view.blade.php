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

    <div class="container bg-primary bg-light-outline">
        <div class="py-5 mt-3">
            <div class="fs-3 fw-bold text-white"> {{ date('F Y', strtotime($date)) }} </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 p-5">
            <div class="container">

                <div class="fs-3 fw-bold text-muted "> Payout Details </div>
                @php
                    $leave_chart_data = [13, 3, 10];
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
                                    <span class="bullet bg-primary mb-1 me-2" style="background-color: #a6b7f7"></span>
                                    <span class="secondary-info fs-6">Rs 53,16,760.00</span>
                                </div>
                                <div class="card-subinfo ptl1 ms-5 text-muted small">Net Pay</div>
                            </td>
                            <td class="w-50">
                                <div>
                                    <span class="bullet bg-primary mb-1 me-2" style="background-color: #a6b7f7"></span>
                                    <span class="secondary-info fs-6">Rs 53,16,760.00</span>
                                </div>
                                <div class="card-subinfo ptl1 ms-5 text-muted small">Gross Pay</div>
                            </td>
                        <tr class="">
                            <td class="w-50 pt-3">
                                <div>
                                    <span class="bullet bg-primary mb-1 me-2" style="background-color: #a6b7f7"></span>
                                    <span class="secondary-info fs-6">Rs 16,760.00</span>
                                </div>
                                <div class="card-subinfo ptl1 ms-5 text-muted small">Total Deduction</div>
                            </td>
                            <td class="w-50">
                                <div>
                                    <span class="bullet bg-primary mb-1 me-2" style="background-color: #a6b7f7"></span>
                                    <span class="secondary-info fs-6">31</span>
                                </div>
                                <div class="card-subinfo ptl1 ms-5 text-muted small">Working Days</div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="d-flex  p-3 fs-4 border border-3 mt-5">
                <div class="w-50"> Payroll Input </div>
                <div class="payroll-radio w-50 d-flex justify-content-end">
                    <span class="@if (isset($lock_info) && $lock_info->payroll_inputs == 'unlock') active @endif pl-btn payroll_inputs" role="button"
                        onclick="setPayrollSetting('payroll_inputs', 'unlock', this)">
                        Unlock </span>
                    <span class="pl-btn @if (isset($lock_info) && $lock_info->payroll_inputs == 'lock') active @endif payroll_inputs" role="button"
                        onclick="setPayrollSetting('payroll_inputs', 'lock', this)"> Lock
                    </span>
                </div>
            </div>
            <div class="d-flex  p-3 fs-4 border border-3">
                <div class="w-50"> Employee View Release </div>
                <div class="payroll-radio w-50 d-flex justify-content-end">
                    <span class="pl-btn emp_view_release @if (isset($lock_info) && $lock_info->emp_view_release == 'unlock') active @endif" role="button"
                        onclick="setPayrollSetting('emp_view_release', 'unlock', this)"> Unlock </span>
                    <span class="pl-btn emp_view_release @if (isset($lock_info) && $lock_info->emp_view_release == 'lock') active @endif" role="button"
                        onclick="setPayrollSetting('emp_view_release', 'lock', this)"> Lock
                    </span>
                </div>
            </div>
            <div class="d-flex  p-3 fs-4 border border-3">
                <div class="w-50"> It Statement Employee View </div>
                <div class="payroll-radio w-50 d-flex justify-content-end">
                    <span class="pl-btn it_statement_view @if (isset($lock_info) && $lock_info->it_statement_view == 'unlock') active @endif"
                        role="button" onclick="setPayrollSetting('it_statement_view', 'unlock', this)"> Unlock </span>
                    <span class="pl-btn it_statement_view @if (isset($lock_info) && $lock_info->it_statement_view == 'lock') active @endif"
                        role="button" onclick="setPayrollSetting('it_statement_view', 'lock', this)"> Lock
                    </span>
                </div>
            </div>
            <div class="d-flex  p-3 fs-4 border border-3">
                <div class="w-50"> Payroll </div>
                <div class="payroll-radio w-50 d-flex justify-content-end">
                    <span class="pl-btn payroll @if (isset($lock_info) && $lock_info->payroll == 'unlock') active @endif" role="button"
                        onclick="setPayrollSetting('payroll', 'unlock', this)"> Unlock </span>
                    <span class="pl-btn payroll @if (isset($lock_info) && $lock_info->payroll == 'lock') active @endif" role="button"
                        onclick="setPayrollSetting('payroll', 'lock', this)"> Lock
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var payout_date = '{{ $date }}';
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
                    backgroundColor: ['#00A3FF', '#cf6262', '#43a43c']
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

        if ( (mode_name == 'payroll_inputs' || mode_name == 'payroll') && status == 'lock') {

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
                    payout_date: payout_date
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
                            payout_date: payout_date
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
