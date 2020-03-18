<?php
$page_title = 'Sentiment';
include 'header.php';

?>

    <div class="container-fluid">
        <div class="row">
            <main role="main" class="col-md-12 ml-sm-auto col-lg-12 px-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Sentiment Graphs</h1>
                </div>
            </main>
        </div>
        <div class="row col-md-12">


            <div class="col-md-4">
                <h5 class="h5 text-center">Overall Sentiment Pie</h5>
                <canvas id="overallPie" width="400" height="400"></canvas>
            </div>
            <div class="col-md-4">
                <h5 class="h5 text-center">Sentiment (Number of Tweets)</h5>
                <canvas id="numChart" width="400" height="400"></canvas>
            </div>

            <div class="col-md-4">
                <h5 class="h5 text-center">Sentiment OverTime (Number of Tweets)</h5>
                <div class="form-group row">
                    <label for="locationSelect2" class="col-sm-4 col-form-label text-right">Location</label>
                    <select class="custom-select mr-sm-2 col-sm-4" id="locationSelect2">
                        <option>Overall</option>
                        <option>Hong Kong</option>
                        <option>Singapore</option>
                        <option>Netherlands</option>
                        <option>USA</option>
                    </select>

                </div>
                <canvas id="overtimeNumChart" width="400" height="400"></canvas>
            </div>



        </div>
        <div class="row col-md-12" style="margin-top:30px">
            <div class="col-md-4">
                <h5 class="h5 text-center">Filter: Date</h5>
                <div class="form-group row">
                    <label for="date1" class="col-sm-2 col-form-label text-right">From </label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="date1" placeholder="1000" value="2020/02/23">
                    </div>
                    <label for="date2" class="col-sm-1 col-form-label text-right">To </label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="date2" placeholder="1000" value="2020/02/28">
                    </div>
                    <div class="col-sm-3">
                        <button type="submit" class="btn btn-primary text-left" id="redate">Generate</button>
                    </div>
                </div>
                <canvas id="dateChart" width="400" height="400"></canvas>
            </div>
            <div class="col-md-4">
                <h5 class="h5 text-center">Filter: User Followers Count</h5>
                <div class="form-group row">
                    <label for="followerCount" class="col-sm-4 col-form-label text-right">Followers >= </label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="followerCount" placeholder="1000" value="1000">
                    </div>
                    <div class="col-sm-4">
                        <button type="submit" class="btn btn-primary text-left" id="refollower">Generate</button>
                    </div>
                </div>
                <canvas id="followerChart" width="400" height="400"></canvas>
            </div>
            <div class="col-md-4">
                <h5 class="h5 text-center">Filter: Keyword</h5>
                <div class="form-group row">
                    <label for="keyword" class="col-sm-4 col-form-label text-right">Keyword </label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="keyword" placeholder="government" value="government">
                    </div>
                    <div class="col-sm-4">
                        <button type="submit" class="btn btn-primary text-left" id="rekeyword">Generate</button>
                    </div>
                </div>
                <canvas id="keywordChart" width="400" height="400"></canvas>
            </div>

        </div>
        <div class="row col-md-12" style="margin-top:30px">
            <div class="col-md-4">
                <h5 class="h5 text-center">Sentiment OverTime (Percentage)</h5>
                <div class="form-group row">
                    <label for="locationSelect" class="col-sm-4 col-form-label text-right">Location</label>
                    <select class="custom-select mr-sm-2 col-sm-4" id="locationSelect">
                        <option>Overall</option>
                        <option>Hong Kong</option>
                        <option>Singapore</option>
                        <option>Netherlands</option>
                        <option>USA</option>
                    </select>

                </div>
                <canvas id="overtimeChart" width="400" height="400"></canvas>
            </div>
            <div class="col-md-4">
                <h5 class="h5 text-center">Filter: Favourites Count</h5>
                <div class="form-group row">
                    <label for="favoriteCount" class="col-sm-4 col-form-label text-right">Favourites >= </label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="favoriteCount" placeholder="100" value="100">
                    </div>
                    <div class="col-sm-4">
                        <button type="submit" class="btn btn-primary text-left" id="relike">Generate</button>
                    </div>
                </div>
                <canvas id="likeChart" width="400" height="400"></canvas>
            </div>
            <div class="col-md-4">
                <h5 class="h5 text-center">Filter: Retweets Count</h5>
                <div class="form-group row">
                    <label for="rtCount" class="col-sm-4 col-form-label text-right">Retweets >= </label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="rtCount" placeholder="100" value="100">
                    </div>
                    <div class="col-sm-4">
                        <button type="submit" class="btn btn-primary text-left" id="rert">Generate</button>
                    </div>
                </div>
                <canvas id="rtChart" width="400" height="400"></canvas>
            </div>


        </div>

        <div class="row col-md-12" style="margin-top:30px">
            <div class="col-md-4">
                <h5 class="h5 text-center">Overall Sentiment</h5>
                <p class="text-center">Overall Sentiment</p>
                <canvas id="overallChart" width="400" height="400"></canvas>
            </div>
        </div>
        </div>


    <script>
        Chart.plugins.unregister(ChartDataLabels);

        var overallChart = null;
        var overallNumChart = null;
        var likeChart = null;
        var rtChart = null;
        var followerChart = null;
        var dateChart = null;
        var keywordChart = null;
        var overtimeChart = null;
        var overtimeNumChart = null;
        var overtimeData = null;

        $( document ).ready(function() {
            $.ajax({
                url: "/api.php",
                type: "POST",
                dataType: "json",
                data: {action: 'getsentiment'},
                success: function (data) {
                    overallChart = loadChartOverall($('#overallChart'),data, overallChart);
                    overallNumChart = loadChartNum($('#numChart'),data,overallNumChart);

                    // load Pie Chart
                    var dataPositive = [];
                    var dataNegative = [];
                    var dataNeutral = [];
                    var dataOverall = [];

                    var locationLabel = ['USA', 'Netherlands', 'Hong Kong', 'Singapore']
                    // console.log(data['USA']['positive'])

                    locationLabel.forEach (function(key){
                        dataPositive.push(data[key]['positive']);
                        dataNegative.push(data[key]['negative']);
                        dataNeutral.push(data[key]['neutral']);
                    });

                    new Chart($('#overallPie'), {
                        type: 'pie',
                        data: {
                            labels: ['Positive','Negative','Neutral'],
                            datasets: [{
                                data: [
                                    data['overall']['positive'],
                                    data['overall']['negative'],
                                    data['overall']['neutral'],
                                ],
                                backgroundColor: [
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(255,99,132,1)',
                                    'rgba(255, 159, 64, 1)',
                                ],
                            },
                            ]
                        },
                        plugins: [ChartDataLabels],
                        options: {
                            responsive: true,
                            plugins: {
                                datalabels: {
                                    formatter: (value, ctx) => {
                                        let sum = 0;
                                        let dataArr = ctx.chart.data.datasets[0].data;
                                        dataArr.map(data => {
                                            sum += data;
                                        });
                                        let percentage = (value*100 / sum).toFixed(2)+"%";
                                        return percentage;
                                    },
                                    color: '#fff',
                                }
                            }
                        },

                    });

                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError);
                }
            });

            $.ajax({
                url: "/api.php",
                type: "POST",
                dataType: "json",
                data: {action: 'getsentimentovertime'},
                success: function (data) {
                    // overtimeChart = loadChartOverall($('#overtimeChart'),data, overtimeChart);
                    // console.log(data);
                    overtimeData = data;
                    loadChartOverTime('overall');
                    loadChartOverTimeNum('overall');
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError);
                }
            });

            $('#locationSelect').change(function (e) {
                var location = $('#locationSelect').val();
                if (location === 'Overall')
                    location = 'overall';
                loadChartOverTime(location);
            });

            $('#locationSelect2').change(function (e) {
                var location = $('#locationSelect2').val();
                if (location === 'Overall')
                    location = 'overall';
                loadChartOverTimeNum(location);
            });

            var myChart = null;

            getLike();
            getRT();
            getFollower();
            getDate();
            getKeyword();

            function loadChartOverTimeNum (location) {
                if (overtimeNumChart !== null)
                    overtimeNumChart.destroy();

                var data = overtimeData;
                var dataPositive = [];
                var dataNegative = [];
                var dataNeutral = [];
                var dataKey = [];
                for (var key in data) {
                    dataPositive.push(data[key][location]['positive']);
                    dataNegative.push(data[key][location]['negative']);
                    dataNeutral.push(data[key][location]['neutral']);
                    dataKey.push(key);
                }

                // console.log(dataPositive);
                overtimeNumChart = new Chart($('#overtimeNumChart'), {
                    type: 'line',
                    data: {
                        labels: dataKey,
                        datasets: [{
                            label: 'Positive',
                            fill: false,
                            data: dataPositive,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 2
                        },
                            {
                                label: 'Neutral',
                                fill: false,
                                data: dataNeutral,
                                backgroundColor: 'rgba(255, 159, 64, 0.2)',
                                borderColor: 'rgba(255, 159, 64, 1)',
                                borderWidth: 2
                            },
                            {
                                label: 'Negative',
                                fill: false,
                                data: dataNegative,
                                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                borderColor: 'rgba(255,99,132,1)',
                                borderWidth: 2
                            }
                        ]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                stacked: false,
                                ticks: {
                                    beginAtZero: false,
                                }
                            }],
                            xAxes: [{
                                stacked: false,
                                ticks: {
                                    beginAtZero: false
                                }
                            }]

                        }
                    }
                });
            }

            function loadChartOverTime (location) {
                if (overtimeChart !== null)
                    overtimeChart.destroy();

                var data = overtimeData;
                var dataPositive = [];
                var dataNegative = [];
                var dataNeutral = [];
                var dataKey = [];
                for (var key in data) {
                    dataPositive.push(data[key][location]['positive'] * 100 / data[key][location]['total']);
                    dataNegative.push(data[key][location]['negative'] * 100 / data[key][location]['total']);
                    dataNeutral.push(data[key][location]['neutral'] * 100 / data[key][location]['total']);
                    dataKey.push(key);
                }

                // console.log(dataPositive);
                overtimeChart = new Chart($('#overtimeChart'), {
                    type: 'line',
                    data: {
                        labels: dataKey,
                        datasets: [{
                            label: 'Positive',
                            fill: false,
                            data: dataPositive,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 2
                        },
                            {
                                label: 'Neutral',
                                fill: false,
                                data: dataNeutral,
                                backgroundColor: 'rgba(255, 159, 64, 0.2)',
                                borderColor: 'rgba(255, 159, 64, 1)',
                                borderWidth: 2
                            },
                            {
                                label: 'Negative',
                                fill: false,
                                data: dataNegative,
                                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                borderColor: 'rgba(255,99,132,1)',
                                borderWidth: 2
                            }
                        ]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                stacked: false,
                                ticks: {
                                    beginAtZero: false,
                                    // min: 10,
                                    // max: 50,
                                    callback: function (value) {
                                        return value + "%"
                                    }
                                }
                            }],
                            xAxes: [{
                                stacked: false,
                                ticks: {
                                    beginAtZero: false
                                }
                            }]

                        }
                    }
                });
            }

            function getKeyword() {
                $.ajax({
                    url: "/api.php",
                    type: "POST",
                    dataType: "json",
                    data: {action: 'getsentiment', keyword: $('#keyword').val()},
                    success: function (data) {
                        keywordChart = loadChartOverall($('#keywordChart'), data, keywordChart);
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        alert('Error Filter');
                    }
                });
            }

            function getDate() {
                $.ajax({
                    url: "/api.php",
                    type: "POST",
                    dataType: "json",
                    data: {action: 'getsentiment', date1: $('#date1').val(), date2: $('#date2').val()},
                    success: function (data) {
                        dateChart = loadChartOverall($('#dateChart'), data, dateChart);
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        alert('Error Filter');
                    }
                });
            }

            function getFollower() {
                $.ajax({
                    url: "/api.php",
                    type: "POST",
                    dataType: "json",
                    data: {action: 'getsentiment', follower: $('#followerCount').val()},
                    success: function (data) {
                        followerChart = loadChartOverall($('#followerChart'), data, followerChart);
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        alert('Error Filter');
                    }
                });
            }

            function getLike() {
                $.ajax({
                    url: "/api.php",
                    type: "POST",
                    dataType: "json",
                    data: {action: 'getsentiment', favorite: $('#favoriteCount').val()},
                    success: function (data) {
                        likeChart = loadChartOverall($('#likeChart'), data, likeChart);
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        alert('Error Filter');
                    }
                });
            }

            function getRT() {
                $.ajax({
                    url: "/api.php",
                    type: "POST",
                    dataType: "json",
                    data: {action: 'getsentiment', rt: $('#rtCount').val()},
                    success: function (data) {
                        rtChart = loadChartOverall($('#rtChart'), data, rtChart);
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        alert('Error Filter');
                    }
                });
            }


            $('#relike').click(function(e) {
                getLike();
            });

            $('#rert').click(function (e) {
                getRT();
            });

            $('#refollower').click(function (e) {
                getFollower();
            });

            $('#redate').click(function(e){
                getDate();
            });

            $('#rekeyword').click(function(e) {
               getKeyword();
            });

            // Load Chart by Number
            function loadChartNum(ctx, data, currentChart) {
                if (currentChart !== null)
                    currentChart.destroy();

                var dataPositive = [];
                var dataNegative = [];
                var dataNeutral = [];
                var dataOverall = [];

                var locationLabel = ['USA', 'Netherlands', 'Hong Kong', 'Singapore']
                // console.log(data['USA']['positive'])

                locationLabel.forEach (function(key){
                    dataPositive.push(data[key]['positive']);
                    dataNegative.push(data[key]['negative']);
                    dataNeutral.push(data[key]['neutral']);
                });

                currentChart = new Chart(ctx, {
                    type: 'horizontalBar',
                    data: {
                        labels: locationLabel,
                        datasets: [{
                            label: 'Positive',
                            data: dataPositive,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 2
                        },
                            {
                                label: 'Negative',
                                data: dataNegative,
                                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                borderColor: 'rgba(255,99,132,1)',
                                borderWidth: 2
                            },
                            {
                                label: 'Neutral',
                                data: dataNeutral,
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
                                }
                            }],
                            xAxes: [{
                                stacked: true,
                                ticks: {
                                    beginAtZero: true,
                                    stepSize: 2000,
                                }
                            }]

                        }
                    }
                });
                return currentChart;
            }

            // Load Chart by Percentage
            function loadChartOverall(ctx,data, currentChart) {
                if (currentChart !== null)
                    currentChart.destroy();
                var dataPositive = [];
                var dataNegative = [];
                var dataNeutral = [];
                for (var key in data) {
                    dataPositive.push(data[key]['positive'] * 100 / data[key]['total']);
                    dataNegative.push(data[key]['negative'] * 100 / data[key]['total']);
                    dataNeutral.push(data[key]['neutral'] * 100 / data[key]['total']);

                }
                myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ["Overall", "Hong Kong", "Singapore","Netherlands", "USA"],
                        datasets: [{
                            label: 'Positive',
                            data: dataPositive,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 2
                        },
                            {
                                label: 'Neutral',
                                data: dataNeutral,
                                backgroundColor: 'rgba(255, 159, 64, 0.2)',
                                borderColor: 'rgba(255, 159, 64, 1)',
                                borderWidth: 2
                            },
                            {
                                label: 'Negative',
                                data: dataNegative,
                                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                borderColor: 'rgba(255,99,132,1)',
                                borderWidth: 2
                            }
                        ]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                stacked: true,
                                ticks: {
                                    beginAtZero: true,
                                    min: 0,
                                    max: 100,
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
                return myChart;
            }
        });
    </script>

<?php include 'footer.php';?>