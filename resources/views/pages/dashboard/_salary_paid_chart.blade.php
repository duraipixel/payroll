<div class="card h-100 cstmzed">
    <div class="card-body p-9">
        <div class="card-header py-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder text-dark">Salary paid for the financial year</span>
            </h3>
            {{-- <div class="card-toolbar">
                <button class="btn btn-icon btn-color-gray-400 btn-active-color-primary justify-content-end"
                    data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-overflow="true">
                    <span class="svg-icon svg-icon-1">
                        Select the Distribution
                    </span>
                </button>
                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold w-200px"
                    data-kt-menu="true">
                    <div class="menu-item px-2">
                        <div class="menu-content fs-6 text-dark fw-bolder px-3 py-4">Select the Distribution </div>
                    </div>
                    <div class="separator mb-3 opacity-75"></div>
                    <div class="menu-item px-3">
                        <a href="#" class="menu-link px-3">Gross pay</a>
                    </div>
                    <div class="menu-item px-3">
                        <a href="#" class="menu-link px-3">EPF</a>
                    </div>
                    <div class="menu-item px-3">
                        <a href="#" class="menu-link px-3">ESI</a>
                    </div>
                    <div class="menu-item px-3">
                        <a href="#" class="menu-link px-3">Net Pay</a>
                    </div>
                    <div class="menu-item px-3">
                        <a href="#" class="menu-link px-3">HRA</a>
                    </div>
                    <div class="menu-item px-3">
                        <a href="#" class="menu-link px-3">DA</a>
                    </div>
                </div>
            </div> --}}
        </div>
        <div class="card-body pt-4">
            <div id="kt_charts_widget_123" class="h-400px w-100"></div>
        </div>
    </div>
</div>
<script>
    var financial_chart = @json($financial_chart);
    console.log('financial_chart', financial_chart);

    // Class definition
    var KTChartsWidget_Salary = (function() {
        // Private methods
        var initChart = function() {
            // Check if amchart library is included
            if (typeof am5 === "undefined") {
                return;
            }

            var element = document.getElementById("kt_charts_widget_123");

            if (!element) {
                return;
            }

            am5.ready(function() {
                // Create root element
                // https://www.amcharts.com/docs/v5/getting-started/#Root_element
                var root = am5.Root.new(element);

                // Set themes
                // https://www.amcharts.com/docs/v5/concepts/themes/
                root.setThemes([am5themes_Animated.new(root)]);

                // Create chart
                // https://www.amcharts.com/docs/v5/charts/xy-chart/
                var chart = root.container.children.push(
                    am5xy.XYChart.new(root, {
                        panX: false,
                        panY: false,
                        layout: root.verticalLayout,
                    })
                );

                var chart_arr = [];
                if (financial_chart) {

                    financial_chart.map((item) => {
                        var letValues = {
                            year: item.formatted_date,
                            expense: item.expense,
                            income: parseFloat(item.expense),
                            columnSettings: {
                                fill: am5.color(KTUtil.getCssVariableValue(
                                    "--bs-primary")),
                            },
                        };
                        chart_arr.push(letValues);
                    });
                }
                console.log(chart_arr, 'chart_arr');

                var data = chart_arr;

                // Create axes
                // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
                var xAxis = chart.xAxes.push(
                    am5xy.CategoryAxis.new(root, {
                        categoryField: "year",
                        renderer: am5xy.AxisRendererX.new(root, {}),
                        //tooltip: am5.Tooltip.new(root, {}),
                    })
                );

                xAxis.data.setAll(data);

                xAxis.get("renderer").labels.template.setAll({
                    paddingTop: 20,
                    fontWeight: "400",
                    fontSize: 11,
                    fill: am5.color(KTUtil.getCssVariableValue("--bs-gray-500")),
                });

                xAxis.get("renderer").grid.template.setAll({
                    disabled: true,
                    strokeOpacity: 0,
                });

                var yAxis = chart.yAxes.push(
                    am5xy.ValueAxis.new(root, {
                        min: 0,
                        extraMax: 0.1,
                        renderer: am5xy.AxisRendererY.new(root, {}),
                    })
                );

                yAxis.get("renderer").labels.template.setAll({
                    paddingTop: 0,
                    fontWeight: "400",
                    fontSize: 11,
                    fill: am5.color(KTUtil.getCssVariableValue("--bs-gray-500")),
                });

                yAxis.get("renderer").grid.template.setAll({
                    stroke: am5.color(KTUtil.getCssVariableValue("--bs-gray-300")),
                    strokeWidth: 1,
                    strokeOpacity: 1,
                    strokeDasharray: [3],
                });

                // Add series
                // https://www.amcharts.com/docs/v5/charts/xy-chart/series/

                var series1 = chart.series.push(
                    am5xy.ColumnSeries.new(root, {
                        name: "Expenses",
                        xAxis: xAxis,
                        yAxis: yAxis,
                        valueYField: "expense",
                        categoryXField: "year",
                        tooltip: am5.Tooltip.new(root, {
                            pointerOrientation: "horizontal",
                            labelText: "{name} in {categoryX}: {valueY} {info}",
                        }),
                    })
                );

                series1.columns.template.setAll({
                    tooltipY: am5.percent(50),
                    templateField: "columnSettings",
                });

                series1.data.setAll(data);

                var series2 = chart.series.push(
                    am5xy.LineSeries.new(root, {
                        name: "Income",
                        xAxis: xAxis,
                        yAxis: yAxis,
                        valueYField: "income",
                        categoryXField: "year",
                        fill: am5.color(KTUtil.getCssVariableValue("--bs-success")),
                        stroke: am5.color(KTUtil.getCssVariableValue("--bs-success")),
                        // tooltip: am5.Tooltip.new(root, {
                        //     pointerOrientation: "horizontal",
                        //     labelText: "{name} in {categoryX}: {valueY} {info}",
                        // }),
                    })
                );

                series2.strokes.template.setAll({
                    stroke: am5.color(KTUtil.getCssVariableValue("--bs-success")),
                });

                series2.strokes.template.setAll({
                    strokeWidth: 3,
                    templateField: "strokeSettings",
                });

                series2.data.setAll(data);

                series2.bullets.push(function() {
                    return am5.Bullet.new(root, {
                        sprite: am5.Circle.new(root, {
                            strokeWidth: 3,
                            stroke: am5.color(KTUtil.getCssVariableValue(
                                "--bs-success")),
                            radius: 5,
                            fill: am5.color(KTUtil.getCssVariableValue(
                                "--bs-light-success")),
                        }),
                    });
                });

                series1.columns.template.setAll({
                    strokeOpacity: 0,
                    cornerRadiusBR: 0,
                    cornerRadiusTR: 6,
                    cornerRadiusBL: 0,
                    cornerRadiusTL: 6,
                });

                chart.set("cursor", am5xy.XYCursor.new(root, {}));

                chart.get("cursor").lineX.setAll({
                    visible: false
                });
                chart.get("cursor").lineY.setAll({
                    visible: false
                });

                // Add legend
                // https://www.amcharts.com/docs/v5/charts/xy-chart/legend-xy-series/
                var legend = chart.children.push(
                    am5.Legend.new(root, {
                        centerX: am5.p50,
                        x: am5.p50,
                    })
                );
                legend.data.setAll(chart.series.values);

                // Make stuff animate on load
                // https://www.amcharts.com/docs/v5/concepts/animations/
                chart.appear(1000, 100);
                series1.appear();
            }); // end am5.ready()
        };

        // Public methods
        return {
            init: function() {
                initChart();
            },
        };
    })();

    // Webpack support
    if (typeof module !== "undefined") {
        module.exports = KTChartsWidget_Salary;
    }

    // On document ready
    KTUtil.onDOMContentLoaded(function() {
        KTChartsWidget_Salary.init();
    });
</script>
