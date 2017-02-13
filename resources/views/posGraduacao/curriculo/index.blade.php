@extends('menu')

@section('css')
    <style type="text/css">
        .select2-container {
            width: 100% !important;
            padding: 0;
        }

        .select2-close-mask{
            z-index: 2099;
        }

        .select2-dropdown{
            z-index: 3051;
        }

        #disciplina-grid tbody tr{
            font-size: 10px;
        }

        td.details-control {
            background: url("{{asset("imagemgrid/icone-produto-plus.png")}}") no-repeat center center;
            cursor: pointer;
        }

        tr.details td.details-control {
            background: url("{{asset("imagemgrid/icone-produto-minus.png")}}") no-repeat center center;
        }
        table.dataTable tbody th, table.dataTable tbody td {
            padding: 2px 10px;
        }
    </style>
@stop

@section('content')
    <div class="ibox float-e-margins">

        <div class="ibox-title">
            <div class="col-sm-6 col-md-9">
                <h4><i class="material-icons">library_books</i> Listar Currículos</h4>
            </div>
            <div class="col-sm-6 col-md-3">
                <a href="{{ route('seracademico.posgraduacao.curriculo.create')}}" class="btn-sm btn-primary pull-right">Novo Curriculo</a>
            </div>
        </div>

        <div class="ibox-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive no-padding">
                        <table id="curriculo-grid" class="display table table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Código</th>
                                <th>Currículo</th>
                                <th>Cód. Curso</th>
                                <th>Curso</th>
                                <th>Ano</th>
                                {{--<th>Validade (Início)</th>--}}
                                {{--<th>Validade (Fim)</th>--}}
                                <th>Ativo</th>
                                <th >Acão</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Código</th>
                                <th>Currículo</th>
                                <th>Cód. Curso</th>
                                <th>Curso</th>
                                <th>Ano</th>
                                {{--<th>Validade (Início)</th>--}}
                                {{--<th>Validade (Fim)</th>--}}
                                <th>Ativo</th>
                                <th style="width: 5%;">Acão</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

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
                                            {!! Form::select('relatorios', ( ['' => 'Selecione um relatório'] + $loadFields['simplereport']->toArray()),
                                             Session::getOldInput('relatorios'), array('class' => 'form-control', 'id' => 'report_id')) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
    </div>

    {{--<!-- Modal de cadastro das Disciplinas-->--}}
    {{--<div id="modal-grade-curricular" class="modal fade modal-profile" role="dialog" aria-labelledby="modalProfile" aria-hidden="true">--}}
        {{--<div class="modal-dialog modal-lg">--}}
            {{--<div class="modal-content">--}}
                {{--<div class="modal-header">--}}
                    {{--<button class="close" type="button" data-dismiss="modal">×</button>--}}
                    {{--<h4 class="modal-title">Adicionar disciplinas ao currículo</h4>--}}
                {{--</div>--}}
                {{--<div class="modal-body" style="alignment-baseline: central">--}}
                    {{--<div class="row">--}}
                        {{--<div class="col-md-12">--}}
                            {{--<div class="input-group">--}}
                                {{--<select  id="select-disciplina" multiple="multiple" class="form-control"></select>--}}
                                {{--<span class="input-group-btn">--}}
                                    {{--<button class="btn btn-sm btn-primary" type="button" id="addDisciplina">Adicionar Disciplinas</button>--}}
                                {{--</span>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="row">--}}
                        {{--<div class="col-md-12">--}}
                            {{--<table id="disciplina-grid" class="display table table-bordered" cellspacing="0" width="100%">--}}
                                {{--<thead>--}}
                                {{--<tr>--}}
                                    {{--<th>Nome</th>--}}
                                    {{--<th style="width: 5%;">Qtd. Faltas</th>--}}
                                    {{--<th style="width: 10%;">Tipo da disciplina</th>--}}
                                    {{--<th >Acão</th>--}}
                                {{--</tr>--}}
                                {{--</thead>--}}

                                {{--<tfoot>--}}
                                {{--<tr>--}}
                                    {{--<th>Nome</th>--}}
                                    {{--<th style="width: 5%;">Qtd. Faltas</th>--}}
                                    {{--<th style="width: 10%;">Tipo da disciplina</th>--}}
                                    {{--<th style="width: 5%;">Acão</th>--}}
                                {{--</tr>--}}
                                {{--</tfoot>--}}
                            {{--</table>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
    {{--<!-- FIM Modal de cadastro das Disciplinas-->--}}

    <!-- Modais -->
    @include('posGraduacao.curriculo.modal_adicionar_disciplina')
    @include('posGraduacao.curriculo.modal_inserir_adicionar_disciplina')
    @include('posGraduacao.curriculo.modal_editar_adicionar_disciplina')
    @include('reports.simple.modals.modal_report_pos_curriculo_disciplina')
@stop

@section('javascript')
    <script type="text/javascript" src="{{ asset('/js/report/simple/modal_report_pos_curriculo_disciplina.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/posGraduacao/curriculo/modal_adicionar_disciplina.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/posGraduacao/curriculo/modal_inserir_adicionar_disciplina.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/posGraduacao/curriculo/modal_editar_adicionar_disciplina.js') }}"></script>
    <script type="text/javascript">

        /*Datatable da grid principal*/
        var table = $('#curriculo-grid').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: "{!! route('seracademico.posgraduacao.curriculo.grid') !!}",
            columns: [
                {data: 'codigo', name: 'fac_curriculos.codigo'},
                {data: 'nome', name: 'fac_curriculos.nome'},
                {data: 'codigo_curso', name: 'fac_cursos.codigo'},
                {data: 'curso', name: 'fac_cursos.nome'},
                {data: 'ano', name: 'fac_curriculos.ano'},
                {data: 'ativo', name: 'fac_curriculos.ativo'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

        //Id e nome do Currículo
        var idCurriculo   = 0;
        var nomeCurriculo = "";

        // Evento para abrir a modal de adicionar disciplinas ao currículo
        $(document).on("click", "#btnPosGraduacaoAddDisciplinaCurriculo", function () {
            idCurriculo     = table.row($(this).parent().parent().parent().parent().parent().index()).data().id;
            nomeCurriculo   = table.row($(this).parent().parent().parent().parent().parent().index()).data().nome;
            codigoCurriculo = table.row($(this).parent().parent().parent().parent().parent().index()).data().codigo;

            //Chmando a modal de adicionar disciplina
            runTableAdicionarDisciplina(idCurriculo);

            // Setando a descrição do modal
            $('#adNomeCurriculo').text(nomeCurriculo);
            $('#adCodigoCurriculo').text(codigoCurriculo);

            //mostrando a modal
            $("#modal-adicionar-disciplina-curriculo").modal({show:true});
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