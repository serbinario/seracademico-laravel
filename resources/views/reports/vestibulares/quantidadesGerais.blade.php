<html>
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title></title>
    <link href="" rel="stylesheet" media="screen">
    <link href="{{ asset('/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('/css/animate.css')}}" rel="stylesheet">
    <link href="{{ asset('/css/style.css')}}" rel="stylesheet">

    <style type="text/css">
        body {
            background-color: white;
        }
        table tbody th, table tbody td {
            padding: 2px 2px;
            font-size: 12px;
        }
    </style>
</head>

<body>
<div class="row">
    <div class="col-md-12">
        <h3>Relatório Geral Quantitativo</h3>
        <h2>Vestibular : </h2>

        <!-- Linha dos Gráficos -->
        <div class="row">
            <!-- Gráfico Barra -->
            <div class="col-md-6">
                <div class="flot-chart">
                    <div class="flot-chart-content" id="flot-bar-chart"></div>
                </div>
            </div>

            <!-- Gráfico Pizza -->
            <div class="col-md-6">
                <div class="flot-chart">
                    <div class="flot-chart-content" id="flot-pie-chart"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Mainly scripts -->
<script src="{{ asset('/js/jquery-2.1.1.js')}}"></script>

<script src="{{ asset('/js/bootstrap.min.js')}}"></script>
<script src="{{ asset('/js/plugins/metisMenu/jquery.metisMenu.js')}}"></script>
<script src="{{ asset('/js/plugins/toastr.min.js')}}"></script>
<script src="{{ asset('/js/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>

<!-- Flot -->
<script src="{{ asset('js/plugins/flot/jquery.flot.js') }}"></script>
{{--<script src="{{ asset('js/plugins/flot/jquery.flot.tooltip.min.js') }}"></script>--}}
<script src="{{ asset('js/plugins/flot/jquery.flot.resize.js') }}"></script>
<script src="{{ asset('js/plugins/flot/jquery.flot.pie.js') }} "></script>
<script src="{{ asset('js/plugins/flot/jquery.flot.time.js') }}"></script>

<!-- Custom and plugin javascript -->
<script src="{{ asset('/js/inspinia.js')}}"></script>
<script src="{{ asset('/js/plugins/pace/pace.min.js')}}"></script>

<script type="text/javascript">
    //Flot Bar Chart
    $(function () {
        var barOptions = {
            series: {
                bars: {
                    show: true,
                    barWidth: 0.6,
                    fill: true,
                    fillColor: {
                        colors: [{
                            opacity: 0.8
                        }, {
                            opacity: 0.8
                        }]
                    }
                }
            },
            xaxis: {
                tickDecimals: 0
            },
            colors: ["#1ab394"],
            grid: {
                color: "#999999",
                hoverable: true,
                clickable: true,
                tickColor: "#D4D4D4",
                borderWidth: 0
            },
            legend: {
                show: false
            },
            tooltip: true,
            tooltipOpts: {
                content: "x: %x, y: %y"
            }
        };

        var barData = {
            label: "bar",
            data: [
                [1, 34],
                [2, 25],
                [3, 19],
                [4, 34],
                [5, 32],
                [6, 44]
            ]
        };

        $.plot($("#flot-bar-chart"), [barData], barOptions);
    });


    //Flot Pie Chart
    $(function() {

        var data = [{
            label: "Sales 1",
            data: 21,
            color: "#d3d3d3",
        }, {
            label: "Sales 2",
            data: 3,
            color: "#bababa",
        }, {
            label: "Sales 3",
            data: 15,
            color: "#79d2c0",
        }, {
            label: "Sales 4",
            data: 52,
            color: "#1ab394",
        }];

        var plotObj = $.plot($("#flot-pie-chart"), data, {
            series: {
                pie: {
                    show: true
                }
            },
            grid: {
                hoverable: true
            },
            tooltip: true,
            tooltipOpts: {
                content: "%p.0%, %s", // show percentages, rounding to 2 decimal places
                shifts: {
                    x: 20,
                    y: 0
                },
                defaultTheme: false
            }
        });

    });
</script>
</body>
</html>


