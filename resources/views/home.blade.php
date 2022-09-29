@extends('layouts.master')

@section('style')
    <style>
        #maps {
            height: 300px;
            min-width: 200px;
            max-width: 600px;
            margin: 0 auto;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            {{-- <h1 class="h3 mb-0 text-gray-800">Dashboard</h1> --}}
            {{-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> --}}
        </div>

        <!-- Content Row -->
        {{-- <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Earnings (Monthly)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">$40,000</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Earnings (Annual)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">$215,000</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tasks
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">50%</div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-info" role="progressbar"
                                            style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Pending Requests</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

        <!-- Content Row -->

        <div class="row">

            <!-- Comparison Chart -->
            <div class="col-xl-6 col-lg-6">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Komparasi Tokoh</h6>
                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                aria-labelledby="dropdownMenuLink">
                                <div class="dropdown-header">Dropdown Header:</div>
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </div>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="card-body bg-primary" style="color: white">
                                    Prabowo Subianto
                                </div>
                                <center>vs</center>
                                <div class="card-body bg-danger" style="color: white">
                                    Puan Maharani
                                </div>
                            </div>
                            <div class="col-6">
                                <div id="chart-comparison"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pie Chart -->
            <div class="col-xl-6 col-lg-6">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Top Isu Tokoh Di Provinsi Jawa Timur</h6>
                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                aria-labelledby="dropdownMenuLink">
                                <div class="dropdown-header">Dropdown Header:</div>
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </div>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="chart-pie pt-4 pb-2">
                            {{-- <canvas id="myPieChart"></canvas> --}}
                            <div id="maps"></div>
                        </div>
                        <div style="padding-bottom: 5.5rem">
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Content Row -->
        <div class="row">

            <!-- Content Column -->
            <div class="col-lg-12 mb-4">

                <!-- Illustrations -->
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="border-right">
                                    <h5 class="font-weight-bold"><i class="fas fa-circle fa-xs" style="color:#3eb369"></i>
                                        Sentimen Positif Tertinggi
                                    </h5>
                                    <h3 class="my-3">DKI Jakarta</h3>
                                    <p><small>19 Agustus 2022</small></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border-right">
                                    <h5 class="font-weight-bold"><i class="fas fa-circle fa-xs" style="color: #d1cbcc"></i>
                                        Sentimen Netral Tertinggi
                                    </h5>
                                    <h3 class="my-3">Jawa Barat</h3>
                                    <p><small>19 Agustus 2022</small></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div>
                                    <h5 class="font-weight-bold"><i class="fas fa-circle fa-xs" style="color: #ff1c42"></i>
                                        Sentimen Negatif Tertinggi
                                    </h5>
                                    <h3 class="my-3">Nusa Tenggara Barat</h3>
                                    <p><small>19 Agustus 2022</small></p>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="text-center">
                            <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;"
                                src="img/undraw_posting_photo.svg" alt="...">
                        </div>
                        <p>Add some quality, svg illustrations to your project courtesy of <a target="_blank" rel="nofollow"
                                href="https://undraw.co/">unDraw</a>, a
                            constantly updated collection of beautiful svg images that you can use
                            completely free and without attribution!</p>
                        <a target="_blank" rel="nofollow" href="https://undraw.co/">Browse Illustrations on
                            unDraw &rarr;</a> --}}
                    </div>
                </div>

                <!-- Approach -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <h5>Analisis Spasial Tokoh</h5>
                                <div class="row">
                                    <div class="col-6">
                                        <div id="chart-person-spatial"></div>
                                    </div>
                                    <div class="col-2">
                                        <i class="far fa-smile fa-2x mx-2 my-2" style="color: #3eb369"></i>
                                        <p class="font-weight-bold">Positif</p>
                                        <p>30,00%</p>
                                        <p>44</p>
                                    </div>
                                    <div class="col-2">
                                        <i class="far fa-meh fa-2x mx-2 my-2" style="color: #d1cbcc"></i>
                                        <p class="font-weight-bold">Netral</p>
                                        <p>38,00%</p>
                                        <p>55</p>
                                    </div>
                                    <div class="col-2">
                                        <i class="far fa-frown fa-2x mx-2 my-2" style="color: #ff1c42"></i>
                                        <p class="font-weight-bold">Negatif</p>
                                        <p>32,00%</p>
                                        <p>41</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <h5>Analisis Spasial Partai Politik</h5>
                                <div class="row">
                                    <div class="col-6">
                                        <div id="chart-party-spatial"></div>
                                    </div>
                                    <div class="col-2">
                                        <i class="far fa-smile fa-2x mx-2 my-2" style="color: #3eb369"></i>
                                        <p class="font-weight-bold">Positif</p>
                                        <p>30,00%</p>
                                        <p>44</p>
                                    </div>
                                    <div class="col-2">
                                        <i class="far fa-meh fa-2x mx-2 my-2" style="color: #d1cbcc"></i>
                                        <p class="font-weight-bold">Netral</p>
                                        <p>38,00%</p>
                                        <p>55</p>
                                    </div>
                                    <div class="col-2">
                                        <i class="far fa-frown fa-2x mx-2 my-2" style="color: #ff1c42"></i>
                                        <p class="font-weight-bold">Negatif</p>
                                        <p>32,00%</p>
                                        <p>41</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <span>Elektabilitas Tokoh Berdasarkan Lembaga Survei</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection

@section('script')
    <script>
        $(function() {
            // Komparasi Tokoh Chart
            const comparisonOptions = {
                series: [{
                    name: 'Series 1',
                    data: [80, 50, 30, 40, 100, 20],
                }, {
                    name: 'Series 2',
                    data: [20, 30, 40, 80, 20, 80],
                }],
                chart: {
                    height: 350,
                    type: 'radar',
                    dropShadow: {
                        enabled: true,
                        blur: 1,
                        left: 1,
                        top: 1
                    }
                },
                title: {
                    text: ''
                },
                stroke: {
                    width: 2
                },
                fill: {
                    opacity: 0.1
                },
                markers: {
                    size: 0
                },
                xaxis: {
                    categories: [
                        'Popularitas', 'Sentimen Positif', 'Sentimen Negatif', 'Elektabilitas',
                        'Pengalaman Politik', 'Kekuatan Partai'
                    ]
                }
            };

            const comparisonChart = new ApexCharts(document.querySelector("#chart-comparison"), comparisonOptions);
            comparisonChart.render();

            // Analisis Spatial Tokoh
            const personSpatialOptions = {
                series: [44, 55, 41],
                labels: ['Positif', 'Netral', 'Negatif'],
                colors: ['#3eb369', '#d1cbcc', '#ff1c42'],
                chart: {
                    type: 'donut',
                },
                dataLabels: {
                    enabled: false,
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            };

            const personSpatialChart = new ApexCharts(document.querySelector("#chart-person-spatial"),
                personSpatialOptions);
            personSpatialChart.render();

            // Analisis Spatial Partai Politik
            const partySpatialOptions = {
                series: [44, 55, 41],
                labels: ['Positif', 'Netral', 'Negatif'],
                colors: ['#3eb369', '#d1cbcc', '#ff1c42'],
                chart: {
                    type: 'donut',
                },
                dataLabels: {
                    enabled: false,
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            };

            const partySpatialChart = new ApexCharts(document.querySelector("#chart-party-spatial"),
                partySpatialOptions);
            partySpatialChart.render();

            // Maps

            (async () => {

                const topology = await fetch(
                    'https://code.highcharts.com/mapdata/countries/id/id-all.topo.json'
                ).then(response => response.json());

                // Prepare demo data. The data is joined to map using value of 'hc-key'
                // property by default. See API docs for 'joinBy' for more info on linking
                // data and map.
                const data = [
                    ['id-3700', 10],
                    ['id-ac', 11],
                    ['id-jt', 12],
                    ['id-be', 13],
                    ['id-bt', 14],
                    ['id-kb', 15],
                    ['id-bb', 16],
                    ['id-ba', 17],
                    ['id-ji', 18],
                    ['id-ks', 19],
                    ['id-nt', 20],
                    ['id-se', 21],
                    ['id-kr', 22],
                    ['id-ib', 23],
                    ['id-su', 24],
                    ['id-ri', 25],
                    ['id-sw', 26],
                    ['id-ku', 27],
                    ['id-la', 28],
                    ['id-sb', 29],
                    ['id-ma', 30],
                    ['id-nb', 31],
                    ['id-sg', 32],
                    ['id-st', 33],
                    ['id-pa', 34],
                    ['id-jr', 35],
                    ['id-ki', 36],
                    ['id-1024', 37],
                    ['id-jk', 38],
                    ['id-go', 39],
                    ['id-yo', 40],
                    ['id-sl', 41],
                    ['id-sr', 42],
                    ['id-ja', 43],
                    ['id-kt', 44]
                ];

                // Create the chart
                Highcharts.mapChart('maps', {
                    chart: {
                        map: topology
                    },

                    title: {
                        text: ''
                    },

                    subtitle: {
                        text: ''
                    },

                    mapNavigation: {
                        enabled: true,
                        buttonOptions: {
                            verticalAlign: 'bottom'
                        }
                    },

                    colorAxis: {
                        min: 0
                    },

                    series: [{
                        data: data,
                        name: 'Random data',
                        showInLegend: false,
                        states: {
                            hover: {
                                color: '#BADA55'
                            }
                        },
                        dataLabels: {
                            enabled: false,
                            format: '{point.name}'
                        }
                    }]
                });

            })();

        })
    </script>
@endsection
