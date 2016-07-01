@extends('menu')

@section("css")
    <link rel="stylesheet" href="{{ asset('/js/graduacao/aluno/css/modal_historico.css') }}">

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
                <h4>
                    <i class="fa fa-users"></i>
                    Listar Alunos
                </h4>
            </div>
            <div class="col-sm-6 col-md-3">
                <a href="{{ route('seracademico.graduacao.aluno.create')}}" class="btn-sm btn-primary pull-right">Novo Aluno</a>
            </div>
        </div>
        <div class="ibox-content">
            <div class="row">
                <div class="col-md-12">
                    <form id="search-form" class="form-inline" role="form" method="GET">
                        <div class="form-group">
                            {!! Form::select('semestreSearch', (['' => 'Todos os Semestres'] + $loadFields['graduacao\\semestre']->toArray()), count($semestres) == 2 ? $semestres[0]->id : null, array('class' => 'form-control')) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::select('situacaoSearch', (['' => 'Todos as Situações'] + $loadFields['situacaoaluno']->toArray()), null, array('class' => 'form-control')) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::text('globalSearch',  null, array('class' => 'form-control', 'placeholder' => 'Pesquisa...')) !!}
                        </div>

                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">Pesquisar</button>
                        </div>
                    </form>
                </div>
            </div>
            <br>
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
                                <th>Semestre Atual</th>
                                <th>Período</th>
                                <th>Curso</th>
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
                                <th>Semestre Atual</th>
                                <th>Período</th>
                                <th>Curso</th>
                                <th>Situação</th>
                                <th style="width: 5%">Acão</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('graduacao.aluno.modal_historico')
    @include('graduacao.aluno.modal_create_historico')
    @include('graduacao.aluno.modal_create_situacao')
    @include('graduacao.aluno.modal_curriculo')
@stop

@section('javascript')
    <script type="text/javascript" src="{{ asset('/js/graduacao/aluno/modal_historico.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/graduacao/aluno/modal_create_historico.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/graduacao/aluno/modal_create_situacao.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/graduacao/aluno/modal_curriculo.js') }}"></script>
    <script type="text/javascript">
        var table = $('#aluno-grid').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            bFilter: false,
            ajax: {
                url: "{!! route('seracademico.graduacao.aluno.grid') !!}",
                data: function (d) {
                    d.semestre = $('select[name=semestreSearch] option:selected').val();
                    d.situacao = $('select[name=situacaoSearch] option:selected').val();
                    d.globalSearch = $('input[name=globalSearch]').val();
                }
            },
            columns: [
                {data: 'nome', name: 'pessoas.nome'},
                {data: 'matricula', name: 'fac_alunos.matricula'},
                {data: 'celular', name: 'pessoas.celular'},
                {data: 'cpf', name: 'pessoas.cpf'},
                {data: 'semestre', name: 'fac_semestres.nome'},
                {data: 'periodo', name: 'fac_alunos_semestres.periodo'},
                {data: 'codigoCurriculo', name: 'fac_curriculos.codigo'},
                {data: 'nomeSituacao', name: 'fac_situacao.nome'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

        // Função do submit do search da grid principal
        $('#search-form').on('submit', function(e) {
            table.draw();
            e.preventDefault();
        });

        // Id do aluno corrente
        var idAluno;

        // Evento para abrir o modal de histórico
        $(document).on("click", "#modalHistorico", function () {
            // recuperando o id do aluno
            idAluno   = table.row($(this).parent().parent().parent().parent().parent().index()).data().id;

            // Recuperando o nome e a matrícula
            nomeAluno = table.row($(this).parent().parent().parent().parent().parent().index()).data().nome;
            matricula = table.row($(this).parent().parent().parent().parent().parent().index()).data().matricula;

            // prenchendo o titulo do nome do aluno
            $('#nomeDoAluno').text('Nome: ' + nomeAluno);

            // Executando o script de histórico
            runHistorico(idAluno);
        });

        // Evento para abrir o modal de histórico
        $(document).on("click", "#modalCurriculo", function () {
            // recuperando o id do aluno
            idAluno   = table.row($(this).parent().parent().parent().parent().parent().index()).data().id;

            // Recuperando o nome e a matrícula
            nomeAluno = table.row($(this).parent().parent().parent().parent().parent().index()).data().nome;
            matricula = table.row($(this).parent().parent().parent().parent().parent().index()).data().matricula;

            // prenchendo o titulo do nome do aluno
            $('#tlMatricula').text('Matrícula: ' + matricula);
            $('#tlNomeAluno').text('Nome: ' + nomeAluno);

            // Executando o script de curriculo
            runCurriculo(idAluno);
        });
    </script>
@stop
