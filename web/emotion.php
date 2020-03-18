<?php
$page_title = 'Emotion';
include 'header.php';

?>

    <div class="container-fluid">
        <div class="row">
            <main role="main" class="col-md-12 ml-sm-auto col-lg-12 px-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Emotion Graphs</h1>
                </div>


            </main>
        </div>
        <div class="row col-md-12">
            <div class="col-md-4">
                <p class="text-center">Disgust</p>
                <canvas id="disgustChart" width="400" height="400"></canvas>
            </div>

            <div class="col-md-4">
                <p class="text-center">Fear</p>
                <canvas id="fearChart" width="400" height="400"></canvas>
            </div>

            <div class="col-md-4">
                <p class="text-center">Anger</p>
                <canvas id="angerChart" width="400" height="400"></canvas>
            </div>
        </div>

        <div class="row col-md-12" style="margin-top:30px">
            <div class="col-md-4">
                <p class="text-center">Sadness</p>
                <canvas id="sadnessChart" width="400" height="400"></canvas>
            </div>
            <div class="col-md-4">
                <p class="text-center">Joy</p>
                <canvas id="joyChart" width="400" height="400"></canvas>
            </div>

            <div class="col-md-4">
                <p class="text-center">Trust</p>
                <canvas id="trustChart" width="400" height="400"></canvas>
            </div>
        </div>

        <div class="row col-md-12" style="margin-top:30px">
            <div class="col-md-4">
                <p class="text-center">Surprise</p>
                <canvas id="surpriseChart" width="400" height="400"></canvas>
            </div>
            <div class="col-md-4">
                <p class="text-center">Anticipation</p>
                <canvas id="anticipationChart" width="400" height="400"></canvas>
            </div>
        </div>
    </div>


    <script>
        Chart.plugins.unregister(ChartDataLabels);

        var disgustChart = null;
        var fearChart = null;
        var angerChart = null;
        $( document ).ready(function() {
            $.ajax({
                url: "/api.php",
                type: "POST",
                dataType: "json",
                data: {action: 'getemotion'},
                success: function (data) {
                    loadChartOverall(data);
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError);
                }
            });

            function loadChartOverall(data) {
                var dataDisgust = [];
                var dataFear = [];
                var dataAnger = [];
                var dataSadness = [];
                var dataJoy = [];
                var dataTrust = [];
                var dataSurprise = [];
                var dataAnticipation = [];

                for (var key in data) {
                    dataDisgust.push(data[key]['disgust'] * 100 / data[key]['total']);
                    dataFear.push(data[key]['fear'] * 100 / data[key]['total']);
                    dataAnger.push(data[key]['anger'] * 100 / data[key]['total']);
                    dataSadness.push(data[key]['sadness'] * 100 / data[key]['total']);
                    dataJoy.push(data[key]['joy'] * 100 / data[key]['total']);
                    dataTrust.push(data[key]['trust'] * 100 / data[key]['total']);
                    dataSurprise.push(data[key]['surprise'] * 100 / data[key]['total']);
                    dataAnticipation.push(data[key]['anticipation'] * 100 / data[key]['total']);
                }

                console.log(dataFear);

                disgustChart = new Chart($('#disgustChart'), {
                    type: 'bar',
                    data: {
                        labels: ["Overall", "Hong Kong", "Singapore","Netherlands", "USA"],
                        datasets: [{
                            label: 'Disgust',
                            data: dataDisgust,
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255,99,132,1)',
                            borderWidth: 2
                        },
                        ]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                stacked: true,
                                ticks: {
                                    beginAtZero: true,
                                    min: 0,
                                    max: 80,
                                    callback: function (value) {
                                        return value + "%"
                                    }
                                }
                            }],
                            xAxes: [{
                                stacked: true,
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });

                fearChart = new Chart($('#fearChart'), {
                    type: 'bar',
                    data: {
                        labels: ["Overall", "Hong Kong", "Singapore","Netherlands", "USA"],
                        datasets: [{
                            label: 'Fear',
                            data: dataFear,
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 2
                        },
                        ]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                stacked: true,
                                ticks: {
                                    beginAtZero: true,
                                    min: 0,
                                    max: 80,
                                    callback: function (value) {
                                        return value + "%"
                                    }
                                }
                            }],
                            xAxes: [{
                                stacked: true,
                                ticks: {
                                    beginAtZero: true
                                }
                            }]

                        }
                    }
                });
                angerChart = new Chart($('#angerChart'), {
                    type: 'bar',
                    data: {
                        labels: ["Overall", "Hong Kong", "Singapore","Netherlands", "USA"],
                        datasets: [{
                            label: 'Anger',
                            data: dataAnger,
                            backgroundColor: 'rgba(255, 159, 64, 0.2)',
                            borderColor: 'rgba(255, 159, 64, 1)',
                            borderWidth: 2
                        },
                        ]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                stacked: true,
                                ticks: {
                                    beginAtZero: true,
                                    min: 0,
                                    max: 80,
                                    callback: function (value) {
                                        return value + "%"
                                    }
                                }
                            }],
                            xAxes: [{
                                stacked: true,
                                ticks: {
                                    beginAtZero: true
                                }
                            }]

                        }
                    }
                });
                sadnessChart = new Chart($('#sadnessChart'), {
                    type: 'bar',
                    data: {
                        labels: ["Overall", "Hong Kong", "Singapore","Netherlands", "USA"],
                        datasets: [{
                            label: 'Sadness',
                            data: dataSadness,
                            backgroundColor: 'rgba(153, 102, 255, 0.2)',
                            borderColor: 'rgba(153, 102, 255, 1)',
                            borderWidth: 2
                        },
                        ]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                stacked: true,
                                ticks: {
                                    beginAtZero: true,
                                    min: 0,
                                    max: 80,
                                    callback: function (value) {
                                        return value + "%"
                                    }
                                }
                            }],
                            xAxes: [{
                                stacked: true,
                                ticks: {
                                    beginAtZero: true
                                }
                            }]

                        }
                    }
                });
                joyChart = new Chart($('#joyChart'), {
                    type: 'bar',
                    data: {
                        labels: ["Overall", "Hong Kong", "Singapore","Netherlands", "USA"],
                        datasets: [{
                            label: 'Joy',
                            data: dataJoy,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 2
                        },
                        ]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                stacked: true,
                                ticks: {
                                    beginAtZero: true,
                                    min: 0,
                                    max: 80,
                                    callback: function (value) {
                                        return value + "%"
                                    }
                                }
                            }],
                            xAxes: [{
                                stacked: true,
                                ticks: {
                                    beginAtZero: true
                                }
                            }]

                        }
                    }
                });
                trustChart = new Chart($('#trustChart'), {
                    type: 'bar',
                    data: {
                        labels: ["Overall", "Hong Kong", "Singapore","Netherlands", "USA"],
                        datasets: [{
                            label: 'Trust',
                            data: dataTrust,
                            backgroundColor: 'rgba(255, 206, 86, 0.2)',
                            borderColor: 'rgba(255, 206, 86, 1)',
                            borderWidth: 2
                        },
                        ]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                stacked: true,
                                ticks: {
                                    beginAtZero: true,
                                    min: 0,
                                    max: 80,
                                    callback: function (value) {
                                        return value + "%"
                                    }
                                }
                            }],
                            xAxes: [{
                                stacked: true,
                                ticks: {
                                    beginAtZero: true
                                }
                            }]

                        }
                    }
                });

                surpriseChart = new Chart($('#surpriseChart'), {
                    type: 'bar',
                    data: {
                        labels: ["Overall", "Hong Kong", "Singapore","Netherlands", "USA"],
                        datasets: [{
                            label: 'Surprise',
                            data: dataSurprise,
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255,99,132,1)',
                            borderWidth: 2
                        },
                        ]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                stacked: true,
                                ticks: {
                                    beginAtZero: true,
                                    min: 0,
                                    max: 80,
                                    callback: function (value) {
                                        return value + "%"
                                    }
                                }
                            }],
                            xAxes: [{
                                stacked: true,
                                ticks: {
                                    beginAtZero: true
                                }
                            }]

                        }
                    }
                });

                anticipationChart = new Chart($('#anticipationChart'), {
                    type: 'bar',
                    data: {
                        labels: ["Overall", "Hong Kong", "Singapore","Netherlands", "USA"],
                        datasets: [{
                            label: 'Anticipation',
                            data: dataAnticipation,
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 2
                        },
                        ]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                stacked: true,
                                ticks: {
                                    beginAtZero: true,
                                    min: 0,
                                    max: 80,
                                    callback: function (value) {
                                        return value + "%"
                                    }
                                }
                            }],
                            xAxes: [{
                                stacked: true,
                                ticks: {
                                    beginAtZero: true
                                }
                            }]

                        }
                    }
                });
            }
        });
    </script>

<?php include 'footer.php';?>