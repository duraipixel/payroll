<div class="card h-100 cstmzed">
    <div class="card-body p-9">
        <span class="fw-bolder text-gray-800 d-block mb-5 fs-3">Monthly Graphical Report</span>
        @php
            $month_graph_data = [$month_chart['addition'] ?? 0, $month_chart['retired'] ?? 0, $month_chart['resigned'] ?? 0];
            $month_graph_label = ['Additions', 'Retirement', 'Resignations'];
        @endphp
        <div class="d-flex flex-center me-9 mt-9 mb-5">
            <canvas id="monthly_graph"
                style="display: block; box-sizing: border-box; height:250px; width: 200px;" width="200"
                height="200"></canvas>
        </div>
        <div class="d-flex flex-wrap">
            <div class="d-flex flex-column justify-content-center flex-row-fluid pe-11 mb-5">
                <div class="d-flex fs-6 fw-bold align-items-center mb-3">
                    <div class="bullet bg-primary me-3"></div>
                    <div class="text-gray-400">Additions</div>
                    <div class="ms-auto fw-bolder text-gray-700">{{$month_chart['addition'] ?? 0}}</div>
                </div>
                <div class="d-flex fs-6 fw-bold align-items-center mb-3">
                    <div class="bullet bg-success me-3"></div>
                    <div class="text-gray-400">Retirement</div>
                    <div class="ms-auto fw-bolder text-gray-700">{{$month_chart['retired'] ?? 0}}</div>
                </div>
                <div class="d-flex fs-6 fw-bold align-items-center">
                    <div class="bullet bg-gray-300 me-3"></div>
                    <div class="text-gray-400">Resignations</div>
                    <div class="ms-auto fw-bolder text-gray-700">{{$month_chart['resigned'] ?? 0}}</div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
        console.log(' chart is running');
        var canvas = document.getElementById('monthly_graph');
        var context = canvas.getContext('2d');

        var config = {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: @json($month_graph_data),
                    backgroundColor: ['#00A3FF', '#cf6262', '#43a43c']
                }],
                labels: @json($month_graph_label)
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

</script>
