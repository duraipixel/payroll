@extends('layouts.template')
@section('breadcrum')
    @include('layouts.parts.breadcrum')
@endsection
@section('content')
    <style>
        .canvasjs-chart-credit {
            display: none !important;
        }
    </style>
    <div class="card mt-3">

        <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
            <div class="post d-flex flex-column-fluid" id="kt_post">
                <div id="dashboard_view" class="px-3">
                    @include('pages.dashboard.dynamic_view')
                </div>
            </div>
        </div>

        <style>
            #chartdiv_data {
                width: 100%;
                height: 300px;
            }
        </style>
    @endsection

    @section('add_on_script')
        <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
        <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
        <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>

        <script>
            am5.ready(function() {

                var root = am5.Root.new("chartdiv_data");

                root.setThemes([
                    am5themes_Animated.new(root)
                ]);

                var chart = root.container.children.push(am5xy.XYChart.new(root, {
                    panX: false,
                    panY: false,
                    layout: root.verticalLayout
                }));

                var legend = chart.children.push(
                    am5.Legend.new(root, {
                        centerX: am5.p50,
                        x: am5.p50
                    })
                );

                var data = [{
                    "year": "2021",
                    "europe": 2.5,
                    "namerica": 2.5
                }, {
                    "year": "2022",
                    "europe": 2.6,
                    "namerica": 2.7
                }, {
                    "year": "2023",
                    "europe": 2.8,
                    "namerica": 2.9
                }]

                var xRenderer = am5xy.AxisRendererX.new(root, {
                    cellStartLocation: 0.1,
                    cellEndLocation: 0.9
                })

                var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
                    categoryField: "year",
                    renderer: xRenderer,
                    tooltip: am5.Tooltip.new(root, {})
                }));

                xRenderer.grid.template.setAll({
                    location: 1
                })

                xAxis.data.setAll(data);

                var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
                    renderer: am5xy.AxisRendererY.new(root, {
                        strokeOpacity: 0.1
                    })
                }));

                function makeSeries(name, fieldName) {
                    var series = chart.series.push(am5xy.ColumnSeries.new(root, {
                        name: name,
                        xAxis: xAxis,
                        yAxis: yAxis,
                        valueYField: fieldName,
                        categoryXField: "year"
                    }));

                    series.columns.template.setAll({
                        tooltipText: "{name}, {categoryX}:{valueY}",
                        width: am5.percent(90),
                        tooltipY: 0,
                        strokeOpacity: 0
                    });

                    series.data.setAll(data);

                    series.appear();

                    series.bullets.push(function() {
                        return am5.Bullet.new(root, {
                            locationY: 0,
                            sprite: am5.Label.new(root, {
                                text: "{valueY}",
                                fill: root.interfaceColors.get("alternativeText"),
                                centerY: 0,
                                centerX: am5.p50,
                                populateText: true
                            })
                        });
                    });

                    legend.data.push(series);
                }

                makeSeries("Europe", "europe");
                makeSeries("North America", "namerica");

                chart.appear(1000, 100);

            });
        </script>
    @endsection
