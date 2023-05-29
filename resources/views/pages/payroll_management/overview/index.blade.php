@extends('layouts.template')
@section('breadcrum')
    @include('layouts.parts.breadcrum')
@endsection
@section('content')
    <style>

    </style>
    <div class="card">
        <div class="month_row d-flex">
            @for ($i = 0; $i < 12; $i++)
                <div id="payroll_month_{{ $i + 1 }}"
                    class="payroll_month @if (date('m') == $i + 1) active @endif"
                    onclick="getPayrollOverviewInfo({{ $i + 1 }})">
                    <div class="month_name">{{ date('M', mktime(0, 0, 0, $i + 1, 10)) }}</div>
                    <div class="year">{{ date('Y') }}</div>
                </div>
            @endfor
        </div>
    </div>
    <div class="card mt-3">
        <div class="payroll_info">
            <div class="container bg-primary bg-light-outline">
                <div class="py-5 mt-3">
                    <div class="fs-3 fw-bold text-white"> September </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 p-5">
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
                <div class="col-sm-4"></div>
                <div class="col-sm-4"></div>
            </div>
        </div>
    </div>
@endsection

@section('add_on_script')
    <script>
        function getPayrollOverviewInfo(month_no) {
            $('.payroll_month').removeClass('active');
            $('#payroll_month_' + month_no).addClass('active');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('payroll.get.month.chart') }}",
                type: 'POST',
                data: {
                    month_no: month_no,
                },
                success: function(res) {

                },
                error: function(xhr, err) {
                    if (xhr.status == 403) {
                        toastr.error(xhr.statusText, 'UnAuthorized Access');
                    }
                }
            });

        }

        $(document).ready(function() {
            var canvas = document.getElementById('leave_chart');
            var context = canvas.getContext('2d');

            var config = {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: @json($leave_chart_data),
                        backgroundColor: ['#00A3FF', '#cf6262', '#50CD89']
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
    </script>
@endsection
