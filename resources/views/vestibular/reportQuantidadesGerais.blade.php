@extends('menu')

@section('content')
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <div class="col-sm-6 col-md-9">
                <h4>
                    <i class="flaticon-employment-test"></i>
                    Relatório Geral Quantitativo
                </h4>
            </div>
        </div>
        <div class="ibox-content">
            <div class="row">
                <div class="col-md-12">
                    {!! Form::open(['route'=>'seracademico.graduacao.curriculo.reportById', 'method' => "POST", 'id' => 'reportQtdGerais', 'class' => 'form-inline']) !!}
                        <div class="form-group">
                            {!! Form::select('vestibular_id', (['' => 'Selecione um Vestibular'] + $loadFields['graduacao\\vestibular']->toArray()), null, array('class' => 'form-control', 'id' => 'vestibular_id')) !!}
                        </div>

                        <div class="form-group">
                            <button class="btn-sm btn-primary" type="submit">Pesquisar</button>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
            <br><br>
            <div class="row">
                <div class="col-md-6">
                    <div class="flot-chart">
                        <div class="flot-chart-content" id="flot-bar-chart"></div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="flot-chart">
                        <div class="flot-chart-content" id="flot-pie-chart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('javascript')
    <script type="text/javascript">
             // Evento para carregar o relatório
        $('#reportQtdGerais').submit(function (event) {
            // Cancelando a propagação do método
            event.preventDefault();

            // Recuperando o id do currículo
            var vestibularId = $('#vestibular_id').find('option:selected').val();

            // Verificando se o currículo foi passado
            if(!vestibularId) {
                swal('Você deve informar um vestibular', '', 'error');
                return false;
            }

            // Redirecionando
           // window.open('/index.php/seracademico/graduacao/curriculo/reportById/' + curriculoId,'_blank');

            // Requisição ajax
            jQuery.ajax({
                type: 'GET',
                url: '/index.php/seracademico/vestibular/relatorios/getReportQuantidadesGerais/' + vestibularId,
                datatype: 'json'
            }).done(function (json) {
                if(json.success) {
                    if(json.success) {
                        //var dados = [['Pagos', json.dados.pagos], ['Não Pagos', json.dados.nPagos], ['Totais', json.dados.totais]];
                        reportPie(json.dados);
                        reportBar(json.dados);
                    }
                }
            });
        });

        // Função para formatar a label
        function labelFormatter(label, series) {
            return "<div style='font-size:8pt; text-align:center; padding:3px; color:" + series.color +";'>" + label + "<br/>" + series.data[0][1] + "</div>"
        }

        // Função para carregar o gráfico de barras
        function reportBar(dados) {
            var data = [ ["Pgos", dados.pagos], ["Não Pagos", dados.nPagos], ["Totais", dados.totais] ];

            $.plot("#flot-bar-chart", [ data ], {
                colors: ["#1ab394"],
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
                    mode: "categories",
                    tickLength: 0
                },
                grid: {
                    color: "#999999",
                    hoverable: true,
                    clickable: true,
                    tickColor: "#D4D4D4",
                    borderWidth:0
                },
                legend: {
                    show: false
                },
            });
        };

        // função para carregar o gráfico de pizza
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
        }
    </script>
@stop
