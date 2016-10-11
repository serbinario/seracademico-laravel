@extends('menu')

@section("css")
    <link rel="stylesheet" href="{{ asset('/js/posgraduacao/turma/css/modal_calendario.css') }}">

    <style type="text/css">
        .select2-close-mask{
            z-index: 2099;
        }

        .select2-dropdown{
            z-index: 3051;
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
                <h4>
                    <i class="fa fa-users"></i>
                    Listar Alunos de Pós-graduação
                </h4>
            </div>
            <div class="col-sm-6 col-md-3">
                <a href="{{ route('seracademico.posgraduacao.aluno.create')}}" class="btn-sm btn-primary pull-right">Novo Aluno</a>
            </div>
        </div>
        <div class="ibox-content">

            @if(Session::has('message'))
                <div class="alert alert-success">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <em> {!! session('message') !!}</em>
                </div>
            @endif

            @if(Session::has('errors'))
                <div class="alert alert-danger">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive no-padding">
                        <table id="aluno-grid" class="display table table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Matrícula</th>
                                <th>Telefones</th>
                                <th>CPF</th>
                                <th>Curso</th>
                                <th>Currículo</th>
                                <th>Situação</th>
                                <th>Acão</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Nome</th>
                                <th>Matrícula</th>
                                <th>Telefones</th>
                                <th>CPF</th>
                                <th>Curso</th>
                                <th>Currículo</th>
                                <th>Situação</th>
                                <th style="width: 5%">Acão</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
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
                                       <div class="form-group col-md-4">
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

    @include('posGraduacao.aluno.turma.modal_aluno_turma')
    @include('posGraduacao.aluno.turma.modal_nova_turma')
    @include('posGraduacao.aluno.turma.modal_create_situacao')
    {{--@include('posGraduacao.aluno.turma.modal_edit_nova_turma')--}}
    @include('reports.simple.modals.modal_report_pos_aluno_geral')
@stop

@section('javascript')
    <script type="text/javascript" src="{{ asset('/js/posgraduacao/aluno/modal_aluno_turma.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/posgraduacao/aluno/modal_nova_turma.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/posgraduacao/aluno/modal_create_situacao.js') }}"></script>
    {{--<script type="text/javascript" src="{{ asset('/js/posgraduacao/aluno/modal_edit_nova_turma.js') }}"></script>--}}
    <script type="text/javascript" src="{{ asset('/js/report/simple/modal_report_pos_aluno_geral.js') }}"></script>
    <script type="text/javascript">
        var table = $('#aluno-grid').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: "{!! route('seracademico.posgraduacao.aluno.grid') !!}",
            columns: [
                {data: 'nome', name: 'pessoas.nome'},
                {data: 'matricula', name: 'pos_alunos.matricula'},
                {data: 'celular', name: 'pessoas.celular'},
                {data: 'cpf', name: 'pessoas.cpf'},
                {data: 'codigoCurso', name: 'fac_cursos.codigo'},
                {data: 'codigoCurriculo', name: 'fac_curriculos.codigo'},
                {data: 'nomeSituacao', name: 'fac_situacao.nome'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

        // Id do aluno corrente
        var idAluno;

        // Evento para abrir o modal de cursos/turmas
        $(document).on("click", "#link_modal_curso_turma", function () {
            // Recuperando o id do aluno selecionado
            idAluno = table.row($(this).parents('tr')).data().id;

            // Recuperando o nome e a matrícula
            var nomeAluno   = table.row($(this).parents('tr')).data().nome;
            var matricula   = table.row($(this).parents('tr')).data().matricula;

            // prenchendo o titulo do nome do aluno
            $('#ctMatricula').text(matricula);
            $('#ctNomeAluno').text(nomeAluno);

            // Executando o modal
            runCursoTurma(idAluno);
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
