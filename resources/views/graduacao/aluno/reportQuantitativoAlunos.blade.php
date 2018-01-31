@extends('menu')

@section('content')
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <div class="col-sm-6 col-md-9">
                <h4>
                    <i class="material-icons">insert_chart</i>
                    Relatório Quantitativo de alunos por vestibular
                </h4>
            </div>
        </div>
        <div class="ibox-content">
            <div class="row">
                <div class="col-md-12">
                    <form class="form-inline" id="reportQtdGerais">
                        <div class="form-group">
                            {!! Form::select('vestibular_id', (['' => 'Selecione um Vestibular'] + $loadFields['graduacao\\vestibular']->toArray()),
                                null, array('class' => 'form-control', 'id' => 'vestibular_id')) !!}
                        </div>

                        <div class="form-group">
                            <button class="btn-sm btn-primary" type="submit">Pesquisar</button>
                        </div>
                    </form>
                </div>
            </div>
            <br><br>
            <div class="row">
                <div class="col-md-2 col-md-offset-10">
                    <strong>Total: </strong> <span id="total">0</span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="flot-chart" style="height: 300px">
                        <div class="flot-chart-content" id="flot-bar-chart"></div>
                    </div>
                </div>

               {{-- <div class="col-md-6">
                    <div class="flot-chart">
                        <div class="flot-chart-content" id="flot-pie-chart"></div>
                    </div>
                </div>--}}
            </div>
        </div>
    </div>
@stop

@section('javascript')
    <script type="text/javascript">
        var previousPoint = null, previousLabel = null;

        $.fn.UseTooltip = function () {
            $(this).bind("plothover", function (event, pos, item) {
                if (item) {
                    if ((previousLabel != item.series.label) || (previousPoint != item.dataIndex)) {
                        previousPoint = item.dataIndex;
                        previousLabel = item.series.label;
                        $("#tooltip").remove();

                        var x = item.datapoint[0];
                        var y = item.datapoint[1];

                        var color = item.series.color;

                        //console.log(item.series.xaxis.ticks[x].label);

                        showTooltip(item.pageX,
                            item.pageY,
                            color,
                            "<strong>" + item.series.label + "</strong><br>" + item.series.xaxis.ticks[x].label + " : <strong>" + y + "</strong>");
                    }
                } else {
                    $("#tooltip").remove();
                    previousPoint = null;
                }
            });
        };

        function showTooltip(x, y, color, contents) {
            $('<div id="tooltip">' + contents + '</div>').css({
                position: 'absolute',
                display: 'none',
                top: y - 40,
                left: x - 120,
                border: '2px solid ' + color,
                padding: '3px',
                'font-size': '9px',
                'border-radius': '5px',
                'background-color': '#fff',
                'font-family': 'Verdana, Arial, Helvetica, Tahoma, sans-serif',
                opacity: 0.9
            }).appendTo("body").fadeIn(200);
        }

        $("#flot-bar-chart").UseTooltip();

        $('#reportQtdGerais').submit(function (event) {
            event.preventDefault();
            var vestibularId = $('#vestibular_id').find('option:selected').val();

            if(!vestibularId) {
                swal('Você deve informar um vestibular', '', 'error');
                return false;
            }

            jQuery.ajax({
                type: 'GET',
                url: '/index.php/seracademico/graduacao/relatorios/getDadosReportQuantitativoAlunos/' + vestibularId,
                datatype: 'json'
            }).done(function (json) {
                if(json.success) {
                    if(json.success) {
                        //var dados = [['Pagos', json.dados.pagos], ['Não Pagos', json.dados.nPagos], ['Totais', json.dados.totais]];
                        //reportPie(json.dados);
                        reportBar(json.dados);
                        $('#total').text(json.dados.total);
                    }
                }
            });
        });


        function reportBar(dados) {
            var data = dados.data;
            var dataset = [{ label: "Quantidade de alunos", data: data, color: "#5482FF" }];
            var ticks = dados.label;

            var p = $.plot("#flot-bar-chart", dataset, {
                colors: ["#1ab394"],
                series: {
                    bars: {
                        show: true,
                        barWidth: 0.5,
                        align: "center",
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
                    axisLabel: "World Cities",
                    axisLabelUseCanvas: true,
                    axisLabelFontSizePixels: 12,
                    axisLabelFontFamily: 'Verdana, Arial',
                    axisLabelPadding: 10,
                    ticks: ticks
                },
                yaxis: {
                    axisLabel: "Quantidade",
                    axisLabelUseCanvas: true,
                    axisLabelFontSizePixels: 12,
                    axisLabelFontFamily: 'Verdana, Arial',
                    axisLabelPadding: 3,
                },
                grid: {
                    hoverable: true,
                    borderWidth: 1,
                    backgroundColor: { colors: ["#ffffff", "#EDF5FF"] }
                },
                legend: {
                    noColumns: 0,
                    labelBoxBorderColor: "#000000",
                    position: "nw"
                }
            });

            $.each(p.getData()[0].data, function(i, el){
                var o = p.pointOffset({x: el[0], y: el[1]});
                $('<div class="data-point-label">' + el[1] + '</div>').css( {
                    position: 'absolute',
                    left: o.left + 3,
                    top: o.top - 20,
                    display: 'none',
                }).appendTo(p.getPlaceholder()).fadeIn('slow');
            });
        }

        /*function labelFormatter(label, series) {
            return "<div style='font-size:8pt; text-align:center; padding:3px; color:" + series.color +";'>"
                + label + "<br/>" + series.data[0][1] + "</div>"
        }

        function reportPie(dados) {
            var data = [{
                label: "Pagos",
                data: dados.pagos,
                color: "#d3d3d3",
            }, {
                label: "Não Pagos",
                data: dados.nPagos,
                color: "#bababa",
            }, {
                label: "Total",
                data: dados.totais,
                color: "#79d2c0",
            }];

            var plotObj = $.plot($("#flot-pie-chart"), data, {
                series: {
                    pie: {
                        show: true,
                        label: {
                            show:true,
                            formatter: labelFormatter
                        }
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
        }*/
    </script>
@stop
