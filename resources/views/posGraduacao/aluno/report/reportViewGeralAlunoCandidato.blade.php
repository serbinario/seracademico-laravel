@extends('menu')

@section('content')

    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <div class="col-sm-6 col-md-9">
                <h4>
                    <i class="fa fa-users"></i>
                    Relatório Geral de Alunos e Pretendentes
                </h4>
            </div>

        </div>
        <div class="ibox-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive no-padding">
                        <table id="report-grid" class="display table table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Cpf</th>
                                <th>Endereço</th>
                                <th>Telefone</th>
                                <th>Email</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="flot-chart">
                        <div class="flot-chart-content" id="flot-bar-chart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('javascript')

    <script type="text/javascript">
        console.log("{!! route('seracademico.posgraduacao.aluno.gridReportGeralAlunoCandidato', ['tipo' => 2]) !!}");
        var tableReport = $('#report-grid').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            retrieve: true,
            iDisplayLength: 10,
            bLengthChange: false,
            autoWidth: false,
            ajax: "{!! route('seracademico.posgraduacao.aluno.gridReportGeralAlunoCandidato', ['tipo' => 2]) !!}",
            columns: [
                {data: 'nome', name: 'pessoas.nome'},
                {data: 'cpf', name: 'pessoas.cpf'},
                {data: 'endereco', name: 'endereco', orderable: false, searchable: false},
                {data: 'celular', name: 'pessoas.celular'},
                {data: 'email', name: 'pessoas.email'}
            ]
        });

        // Requisição ajax
        jQuery.ajax({
            type: 'GET',
            url: '/index.php/seracademico/posgraduacao/aluno/graphicBuilderGeral',
            datatype: 'json'
        }).done(function (json) {
            reportBar(json);
        });

        // Função para carregar o gráfico de barras
        function reportBar(dados) {
            var data = [ ["Alunos", dados.alunos], ["Pretendentes", dados.pretendentes], ["Total", dados.total] ];

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
//            window.open("/index.php/seracademico/report/"
//                    + reportId + "?fac_cursos,id="+cursoId+"&fac_turmas,id="+turmaId+"&fac_turnos,id="+turnoId, '_blank');
        $("#flot-bar-chart").bind("plotclick", function (event, pos, item) {
            tableReport.ajax.url("/index.php/seracademico/posgraduacao/aluno/gridReportGeralAlunoCandidatorid/" + item.dataIndex).load();
        });

    </script>
@stop
