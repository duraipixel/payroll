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
        animation:to-right-2 0.4s linear forwards;

    }
</style>
<div id="payroll_overview_data">

    <div class="container bg-primary bg-light-outline">
        <div class="py-5 mt-3">
            <div class="fs-3 fw-bold text-white"> {{ date('F Y', strtotime($date)) }} </div>
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
<script>
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
