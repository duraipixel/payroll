"use strict";

// Class definition
var KTProjectList = function () {    
    var initChart = function () {
        // init chart
        var element = document.getElementById("kt_project_list_chart-1");

        if (!element) {
            return;
        }

        var config = {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [120, 110, 10],
                    backgroundColor: ['#00A3FF', '#50CD89', '#E4E6EF']
                }],
                labels: ['Working Days', 'Present', 'Absent']
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

        var ctx = element.getContext('2d');
        var myDoughnut = new Chart(ctx, config);
    }

    // Public methods
    return {
        init: function () {
            initChart();
        }
    }
}();

// On document ready
KTUtil.onDOMContentLoaded(function() {
    KTProjectList.init();
});