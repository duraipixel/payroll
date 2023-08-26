<!--begin::Chart widget 22-->
<div class="card h-100 cstmzed">
    <div class="card-body p-9">
        <div class="card-title">
            <h3 class="mb-5 text-gray-800">Gender Distribution Chart</h3>
        </div>
        <div class="card h-xl-100">
            <!--begin::Body-->
            <div class="card-body">
                <!--begin::Tab Content-->
                <div class="tab-content">
                    <!--begin::Tap pane-->
                    <div class="tab-pane fade show active" id="kt_chart_widgets_22_tab_content_100">
                        <!--begin::Wrapper-->
                        <div class="d-flex flex-wrap flex-md-nowrap">
                            <!--end::Items-->
                            <!--begin::Container-->
                            <div
                                class="d-flex justify-content-between flex-column w-550px w-md-750px mx-auto mx-md-0 pt-3 pb-10">
                                <!--begin::Chart-->
                                <div id="kt_chart_widgets_22_chart_100" class="mx-auto mb-4"></div>
                                <!--end::Chart-->
                                <!--begin::Labels-->
                                <div class="d-flex flex-column justify-content-center flex-row-fluid pe-11 mb-5">
                                    <!--begin::Label-->
                                    <div class="d-flex fs-6 fw-bold align-items-center mb-3">
                                        <div class="bullet bg-success me-3"></div>
                                        <div class="text-gray-400">Male</div>
                                        <div class="ms-auto fw-bolder text-gray-700">{{ $gender_calculation->total_female }}</div>
                                    </div>
                                    <!--end::Label-->
                                    <!--begin::Label-->
                                    <div class="d-flex fs-6 fw-bold align-items-center mb-3">
                                        <div class="bullet bg-primary me-3"></div>
                                        <div class="text-gray-400">Female</div>
                                        <div class="ms-auto fw-bolder text-gray-700">{{ $gender_calculation->total_male }}</div>
                                    </div>
                                    <!--end::Label-->
                                    <!--begin::Label-->
                                    <div class="d-flex fs-6 fw-bold align-items-center">
                                        <div class="bullet bg-gray-300 me-3"></div>
                                        <div class="text-gray-400">Transgenders</div>
                                        <div class="ms-auto fw-bolder text-gray-700">{{ $gender_calculation->total_other }}</div>
                                    </div>
                                    <!--end::Label-->
                                </div>
                                <!--end::Labels-->
                            </div>
                            <!--end::Container-->
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Tap pane-->

                </div>
                <!--end::Tab Content-->
            </div>
            <!--end: Card Body-->
        </div>
        <!--end::Chart widget 22-->
    </div>
</div>
<script>
    // Class definition
    var total_female = {{ $gender_calculation->total_female }};
    var total_male = {{ $gender_calculation->total_male }};
    var total_other = {{ $gender_calculation->total_other }};

    console.log(total_female, total_male, total_other);

var KTChartsWidget22023 = function () {
    // Private methods
    var initChart = function(tabSelector, chartSelector, data, initByDefault) {
        var element = document.querySelector(chartSelector);        

        if (!element) {
            return;
        }  
          
        var height = parseInt(KTUtil.css(element, 'height'));
        
        var options = {
            series: data,                 
            chart: {           
                fontFamily: 'inherit', 
                type: 'donut',
                width: 280,
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '50%',
                        labels: {
                            value: {
                                fontSize: '10px'
                            }
                        }                        
                    }
                }
            },
            colors: [
                KTUtil.getCssVariableValue('--bs-info'), 
                KTUtil.getCssVariableValue('--bs-success'), 
                KTUtil.getCssVariableValue('--bs-primary'), 
                KTUtil.getCssVariableValue('--bs-danger') 
            ],           
            stroke: {
              width: 0
            },
            labels: ['Female', 'Male', 'Transgender'],
            legend: {
                show: false,
            },
            fill: {
                type: 'false',          
            }     
        };                     

        var chart = new ApexCharts(element, options);

        var init = false;
        if( tabSelector ) {

            var tab = document.querySelector(tabSelector);
        }
        
        if (initByDefault === true) {
            chart.render();
            init = true;
        }        
        if( tabSelector ) {
            tab.addEventListener('shown.bs.tab', function (event) {
                if (init == false) {
                    chart.render();
                    init = true;
                }
            })
        }
    }

    // Public methods
    return {
        init: function () {           
            initChart('', '#kt_chart_widgets_22_chart_100', [total_female, total_male, total_other], true);
        }   
    }


    
}();


if (typeof module !== 'undefined') {
    module.exports = KTChartsWidget22023;
}

// On document ready
KTUtil.onDOMContentLoaded(function() {
    KTChartsWidget22023.init();
});
</script>