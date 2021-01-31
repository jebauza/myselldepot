<template>
    <div class="card">

        <div class="card-header">

            <div class="row">

                <div class="col-sm-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>150</h3>

                            <p>New Orders</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>44</h3>

                            <p>User Registrations</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">CPU Traffic</span>
                            <span class="info-box-number">
                            10
                            <small>%</small>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Likes</span>
                            <span class="info-box-number">41,410</span>
                        </div>

                    </div>
                </div>

                <div class="clearfix hidden-md-up"></div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Sales</span>
                            <span class="info-box-number">760</span>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">New Members</span>
                            <span class="info-box-number">2,000</span>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <div class="card-body" v-loading.fullscreen.lock="fullscreenLoading">
            <div class="container-fluid">

                <div class="row">
                    <!-- BAR CHART SELL PRODUCT -->
                    <div v-show="!chartsLoading.productRankingChart" class="col-12">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Productos más vendidos</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="chart"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                                    <canvas id="productRankingChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 359px;" width="359" height="250" class="chartjs-render-monitor"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header border-0">
                                <div class="d-flex justify-content-between">
                                    <h3 class="card-title">Online Store Visitors</h3>
                                    <a href="javascript:void(0);">View Report</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-flex">
                                    <p class="d-flex flex-column">
                                        <span class="text-bold text-lg">820</span>
                                        <span>Visitors Over Time</span>
                                    </p>
                                    <p class="ml-auto d-flex flex-column text-right">
                                        <span class="text-success">
                                            <i class="fas fa-arrow-up"></i> 12.5%
                                        </span>
                                        <span class="text-muted">Since last week</span>
                                    </p>
                                </div>
                                <!-- /.d-flex -->

                                <div class="position-relative mb-4"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                                    <canvas id="visitors-chart" height="200" style="display: block; width: 835px; height: 200px;" width="835" class="chartjs-render-monitor"></canvas>
                                </div>

                                <div class="d-flex flex-row justify-content-end">
                                    <span class="mr-2">
                                        <i class="fas fa-square text-primary"></i> This Week
                                    </span>

                                    <span>
                                        <i class="fas fa-square text-gray"></i> Last Week
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">

                    <!-- AREA CHART -->
                    <div class="col-sm-6">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Area Chart</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="chart"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                                    <canvas id="areaChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 360px;" width="360" height="250" class="chartjs-render-monitor"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- LINE CHART -->
                    <div class="col-sm-6">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Line Chart</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="chart"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                                    <canvas id="lineChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 442px;" width="442" height="250" class="chartjs-render-monitor"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- DONUT CHART -->
                    <div class="col-sm-6">
                        <div class="card card-danger">
                            <div class="card-header">
                                <h3 class="card-title">Donut Chart</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                                </div>
                            </div>
                            <div class="card-body"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                                <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 360px;" width="360" height="250" class="chartjs-render-monitor"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- PIE CHART -->
                    <div class="col-sm-6">
                        <div class="card card-danger">
                            <div class="card-header">
                                <h3 class="card-title">Pie Chart</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                                </div>
                            </div>
                            <div class="card-body"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                                <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 360px;" width="360" height="250" class="chartjs-render-monitor"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- BAR CHART -->
                    <div class="col-sm-6">
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">Bar Chart</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="chart"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                                    <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 359px;" width="359" height="250" class="chartjs-render-monitor"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- STACKED BAR CHART -->
                    <div class="col-sm-6">
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">Stacked Bar Chart</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="chart"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                                    <canvas id="stackedBarChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block;" width="359" height="250" class="chartjs-render-monitor"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</template>

<script>
import Chart from 'chart.js';

export default {
    mounted() {
        this.getProductRankingChart();
        this.getAreaChart();
        this.getLineChart();
        this.getDonutChart();
        this.getPieChart();
        this.getBarChart();
        this.getStackedBarChart();
        this.getVisitorsChart();
    },

    data() {
        return {
            chartsLoading: {
                productRankingChart: false
            }

        }
    },

    methods: {
        getProductRankingChart() {
            const url = 'cmsapi/dashboard/chart/product-sales-ranking';
            this.chartsLoading.productRankingChart = true;

            axios.get(url)
            .then(res => {
                let productNames = [];
                let quantitiesSold = [];
                let colors = [];
                res.data.map(product => {
                    productNames.push(product.name);
                    quantitiesSold.push(parseInt(product.quantity_sold));

                    let param1 = Math.floor(Math.random() * 256); // 0 - 255
                    let param2 = Math.floor(Math.random() * 256); // 0 - 255
                    let param3 = Math.floor(Math.random() * 256); // 0 - 255
                    colors.push(`rgba(${param1}, ${param2}, ${param3}, 0.5)`);
                });

                let ctx = document.getElementById('productRankingChart').getContext('2d');
                let productRankingChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: productNames,
                        datasets: [{
                            data: quantitiesSold,
                            backgroundColor: colors,
                            borderColor: colors,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        // datasetFill: false,
                        legend: {
                            display: false
                        }
                    }
                });

                this.chartsLoading.productRankingChart = false;
            })
            .catch(err => {
                this.chartsLoading.productRankingChart = false;
                console.error(err);
            });
        },
        getAreaChart() {
            let ctx = document.getElementById('areaChart').getContext('2d');
            let areaChar = new Chart(ctx, {
                type: 'line',
                data: {
                    labels  : ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                    datasets: [
                        {
                            label               : 'Digital Goods',
                            backgroundColor     : 'rgba(60,141,188,0.9)',
                            borderColor         : 'rgba(60,141,188,0.8)',
                            pointRadius          : false,
                            pointColor          : '#3b8bba',
                            pointStrokeColor    : 'rgba(60,141,188,1)',
                            pointHighlightFill  : '#fff',
                            pointHighlightStroke: 'rgba(60,141,188,1)',
                            data                : [28, 48, 40, 19, 86, 27, 90]
                        },
                        {
                            label               : 'Electronics',
                            backgroundColor     : 'rgba(210, 214, 222, 1)',
                            borderColor         : 'rgba(210, 214, 222, 1)',
                            pointRadius         : false,
                            pointColor          : 'rgba(210, 214, 222, 1)',
                            pointStrokeColor    : '#c1c7d1',
                            pointHighlightFill  : '#fff',
                            pointHighlightStroke: 'rgba(220,220,220,1)',
                            data                : [65, 59, 80, 81, 56, 55, 40]
                        },
                    ]
                },
                options: {
                    maintainAspectRatio : false,
                    responsive : true,
                    legend: {
                        display: false
                    },
                    scales: {
                        xAxes: [{
                            gridLines : {
                                display : false,
                            }
                        }],
                        yAxes: [{
                            gridLines : {
                                display : false,
                            }
                        }]
                    }
                }
            });
        },
        getLineChart() {
            let ctx = document.getElementById('lineChart').getContext('2d');
            let lineChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels  : ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                    datasets: [
                        {
                            label               : 'Digital Goods',
                            backgroundColor     : 'rgba(60,141,188,0.9)',
                            borderColor         : 'rgba(60,141,188,0.8)',
                            pointRadius          : false,
                            pointColor          : '#3b8bba',
                            pointStrokeColor    : 'rgba(60,141,188,1)',
                            pointHighlightFill  : '#fff',
                            pointHighlightStroke: 'rgba(60,141,188,1)',
                            data                : [28, 48, 40, 19, 86, 27, 90],
                            fill: false
                        },
                        {
                            label               : 'Electronics',
                            backgroundColor     : 'rgba(210, 214, 222, 1)',
                            borderColor         : 'rgba(210, 214, 222, 1)',
                            pointRadius         : false,
                            pointColor          : 'rgba(210, 214, 222, 1)',
                            pointStrokeColor    : '#c1c7d1',
                            pointHighlightFill  : '#fff',
                            pointHighlightStroke: 'rgba(220,220,220,1)',
                            data                : [65, 59, 80, 81, 56, 55, 40],
                            fill: false
                        },
                    ]
                },
                options: {
                    maintainAspectRatio : false,
                    responsive : true,
                    legend: {
                        display: false
                    },
                    scales: {
                        xAxes: [{
                            gridLines : {
                                display : false,
                            }
                        }],
                        yAxes: [{
                            gridLines : {
                                display : false,
                            }
                        }]
                    },
                    datasetFill: false
                }
            });
        },
        getDonutChart() {
            let ctx = document.getElementById('donutChart').getContext('2d');
            let donutChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: [
                        'Chrome',
                        'IE',
                        'FireFox',
                        'Safari',
                        'Opera',
                        'Navigator',
                    ],
                    datasets: [
                        {
                            data: [700,500,400,600,300,100],
                            backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
                        }
                    ]
                },
                options: {
                    maintainAspectRatio : false,
                    responsive : true,
                }
            });
        },
        getPieChart() {
            let ctx = document.getElementById('pieChart').getContext('2d');
            let pieChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: [
                        'Chrome',
                        'IE',
                        'FireFox',
                        'Safari',
                        'Opera',
                        'Navigator',
                    ],
                    datasets: [
                        {
                            data: [700,500,400,600,300,100],
                            backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
                        }
                    ]
                },
                options: {
                    maintainAspectRatio : false,
                    responsive : true,
                }
            });
        },
        getBarChart() {
            let ctx = document.getElementById('barChart').getContext('2d');
            let barChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels  : ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                    datasets: [
                        {
                            label               : 'Digital Goods',
                            backgroundColor     : 'rgba(60,141,188,0.9)',
                            borderColor         : 'rgba(60,141,188,0.8)',
                            pointRadius          : false,
                            pointColor          : '#3b8bba',
                            pointStrokeColor    : 'rgba(60,141,188,1)',
                            pointHighlightFill  : '#fff',
                            pointHighlightStroke: 'rgba(60,141,188,1)',
                            data                : [28, 48, 40, 19, 86, 27, 90]
                        },
                        {
                            label               : 'Electronics',
                            backgroundColor     : 'rgba(210, 214, 222, 1)',
                            borderColor         : 'rgba(210, 214, 222, 1)',
                            pointRadius         : false,
                            pointColor          : 'rgba(210, 214, 222, 1)',
                            pointStrokeColor    : '#c1c7d1',
                            pointHighlightFill  : '#fff',
                            pointHighlightStroke: 'rgba(220,220,220,1)',
                            data                : [65, 59, 80, 81, 56, 55, 40]
                        },
                    ]
                },
                options: {
                    responsive              : true,
                    maintainAspectRatio     : false,
                    datasetFill             : false
                }
            });
        },
        getStackedBarChart() {
            let ctx = document.getElementById('stackedBarChart').getContext('2d');
            let stackedBarChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels  : ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                    datasets: [
                        {
                            label               : 'Digital Goods',
                            backgroundColor     : 'rgba(60,141,188,0.9)',
                            borderColor         : 'rgba(60,141,188,0.8)',
                            pointRadius          : false,
                            pointColor          : '#3b8bba',
                            pointStrokeColor    : 'rgba(60,141,188,1)',
                            pointHighlightFill  : '#fff',
                            pointHighlightStroke: 'rgba(60,141,188,1)',
                            data                : [28, 48, 40, 19, 86, 27, 90]
                        },
                        {
                            label               : 'Electronics',
                            backgroundColor     : 'rgba(210, 214, 222, 1)',
                            borderColor         : 'rgba(210, 214, 222, 1)',
                            pointRadius         : false,
                            pointColor          : 'rgba(210, 214, 222, 1)',
                            pointStrokeColor    : '#c1c7d1',
                            pointHighlightFill  : '#fff',
                            pointHighlightStroke: 'rgba(220,220,220,1)',
                            data                : [65, 59, 80, 81, 56, 55, 40]
                        },
                    ]
                },
                options: {
                    responsive              : true,
                    maintainAspectRatio     : false,
                    scales: {
                        xAxes: [{
                            stacked: true,
                        }],
                        yAxes: [{
                            stacked: true
                        }]
                    }
                }
            });
        },
        getVisitorsChart() {
            let ctx = document.getElementById('visitors-chart').getContext('2d');
            let visitorsChart = new Chart(ctx, {
                data: {
                    labels  : ['18th', '20th', '22nd', '24th', '26th', '28th', '30th'],
                    datasets: [
                        {
                            type                : 'line',
                            data                : [100, 120, 170, 167, 180, 177, 160],
                            backgroundColor     : 'transparent',
                            borderColor         : '#007bff',
                            pointBorderColor    : '#007bff',
                            pointBackgroundColor: '#007bff',
                            fill                : false
                            // pointHoverBackgroundColor: '#007bff',
                            // pointHoverBorderColor    : '#007bff'
                        },
                        {
                            type                : 'line',
                            data                : [60, 80, 70, 67, 80, 77, 100],
                            backgroundColor     : 'tansparent',
                            borderColor         : '#ced4da',
                            pointBorderColor    : '#ced4da',
                            pointBackgroundColor: '#ced4da',
                            fill                : false
                            // pointHoverBackgroundColor: '#ced4da',
                            // pointHoverBorderColor    : '#ced4da'
                        }
                    ]
                },
                options: {
                    maintainAspectRatio: false,
                    tooltips: {
                        mode: 'index',
                        intersect: true
                    },
                    hover: {
                        mode: 'index',
                        intersect: true
                    },
                    legend: {
                        display: false
                    },
                    scales: {
                        yAxes: [{
                            // display: false,
                            gridLines: {
                                display      : true,
                                lineWidth    : '4px',
                                color        : 'rgba(0, 0, 0, .2)',
                                zeroLineColor: 'transparent'
                            },
                            ticks: {
                                beginAtZero : true,
                                suggestedMax: 200,
                                fontColor: '#495057',
                                fontStyle: 'bold'
                            }
                        }],
                        xAxes: [{
                            display: true,
                            gridLines: {
                                display: false
                            },
                            ticks: {
                                fontColor: '#495057',
                                fontStyle: 'bold'
                            }
                        }]
                    }
                }
            });
        }
    },
    computed: {
        fullscreenLoading() {
            for (const property in this.chartsLoading) {

                if (this.chartsLoading[property] === true) {
                    return true;
                }
            }

            return false;
        }
    },
}
</script>
