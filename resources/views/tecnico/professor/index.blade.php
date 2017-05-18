@extends('menu')

@section("css")

    <style type="text/css">
        table.dataTable tbody th, table.dataTable tbody td {
            padding: 2px 10px;
        }
    </style>

@stop

@section('content')

    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <div class="col-sm-6 col-md-9">
                <h4><i class="flaticon-teacher-at-the-blackboard"></i>
                    Listar Professores</h4>
            </div>
            <div class="col-sm-6 col-md-3">
                <a href="{{ route('seracademico.mestrado.professor.create')}}" class="btn-sm btn-primary pull-right">Novo Professor</a>
            </div>
        </div>
        <div class="ibox-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive no-padding">
                        <table id="professor-grid" class="display table table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Nome</th>
                                <th>CPF</th>
                                <th>Acão</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Nome</th>
                                <th>CPF</th>
                                <th style="width: 5%;">Acão</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            {{--Modal--}}
            <div class="row">
                <div class="col-md-6">
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingOne">
                                <h4 class="panel-title">
                                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                        Relatórios Avançados
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            {!! Form::select('relatorios', (['' => 'Selecione um relatório'] + $loadFields['simplereport']->toArray()),
                                             Session::getOldInput('relatorios'), array('class' => 'form-control', 'id' => 'report_id')) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{--Fim Modal--}}
        </div>
    </div>
    @include('reports.simple.modals.modal_report_mestrado_prof_ata_aniversariantes')
@stop

@section('javascript')
    <script type="text/javascript" src="{{ asset('/js/report/simple/modal_report_mestrado_professor_ata_aniversariantes.js')  }}"></script>

    <script type="text/javascript">
        var table = $('#professor-grid').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: "{!! route('seracademico.mestrado.professor.grid') !!}",
            columns: [
                {data: 'nome', name: 'pessoas.nome'},
                {data: 'cpf', name: 'pessoas.cpf'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

        // Geriamento dos relatórios avançadas
        $(document).on('change', '#report_id', function () {
            // Recuperando o id do relatório
            var reportId = $('#report_id').val();

            // Validando o id do relatório
            if(!reportId) {
                return false;
            }

            // Fazendo a requisição ajax
            jQuery.ajax({
                type: 'GET',
                url: '/index.php/seracademico/report/getFunction/' + reportId,
                datatype: 'json'
            }).done(function (retorno) {
                // Verificando o retorno da requisição
                if(retorno.success) {
                    execute(new Function(retorno.dados.function));
                } else {
                    // Retorno tenha dado erro
                    swal(retorno.msg, "Click no botão abaixo!", "error");
                }
            });
        });

        // Função utilizada para executar o callback
        function execute(callback) {
            callback();
        }
    </script>
@stop