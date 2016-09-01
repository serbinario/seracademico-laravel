@extends('menu')

@section("css")
    <link rel="stylesheet" href="{{ asset('/js/graduacao/aluno/css/modal_historico.css') }}">

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
                            <a id="pesquisar" class="btn-sm btn-primary" type="submit">Pesquisar</a>
                            <button id="reportAluno" class="btn-sm btn-primary">Relatório</button>
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
                                <th>Semestre Atual</th>
                                <th>Período</th>
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
        </div>
    </div>

    @include('graduacao.aluno.modal_historico')
    @include('graduacao.aluno.modal_create_historico')
    @include('graduacao.aluno.modal_create_situacao')
    @include('graduacao.aluno.modal_curriculo')
    @include('graduacao.aluno.modal_inserir_dispensar_disciplina')
    @include('graduacao.aluno.modal_editar_dispensar_disciplina')
    @include('graduacao.aluno.modal_semestre')
    @include('graduacao.aluno.financeiro.modal_debitos')
    @include('graduacao.aluno.financeiro.modal_create_debito_aberto')
    @include('graduacao.aluno.financeiro.modal_create_fechamento')
    @include('graduacao.aluno.beneficio.modal_beneficios')
    @include('graduacao.aluno.beneficio.modal_create_beneficio')
    @include('graduacao.aluno.beneficio.modal_edit_beneficio')
@stop

@section('javascript')
    <script type="text/javascript" src="{{ asset('/js/graduacao/aluno/modal_historico.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/graduacao/aluno/modal_create_historico.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/graduacao/aluno/modal_create_situacao.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/graduacao/aluno/modal_curriculo.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/graduacao/aluno/modal_inserir_dispensar_disciplina.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/graduacao/aluno/modal_editar_dispensar_disciplina.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/graduacao/aluno/modal_semestre.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/graduacao/aluno/gerenciar-disciplinas/funcoes.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/graduacao/aluno/gerenciar-disciplinas/disciplina.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/graduacao/aluno/gerenciar-disciplinas/horario.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/graduacao/aluno/financeiro/modal_debitos.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/graduacao/aluno/financeiro/modal_create_debito_aberto.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/graduacao/aluno/financeiro/modal_create_fechamento.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/graduacao/aluno/beneficio/modal_beneficios.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/graduacao/aluno/beneficio/beneficios_select2.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/graduacao/aluno/beneficio/modal_create_beneficio.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/graduacao/aluno/beneficio/modal_edit_beneficio.js') }}"></script>
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
                {data: 'codigoCurso', name: 'fac_cursos.codigo'},
                {data: 'codigoCurriculo', name: 'fac_curriculos.codigo'},
                {data: 'nomeSituacao', name: 'fac_situacao.nome'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

        // Função do submit do search da grid principal
        $('#pesquisar').click(function(e) {
            table.draw();
            e.preventDefault();
        });

        // Id do aluno corrente e o semestre
        var idAluno, idSemestre;

        // Evento para abrir o modal de histórico
        $(document).on("click", "#modalHistorico", function () {
            // recuperando o id do aluno
            idAluno   = table.row($(this).parent().parent().parent().parent().parent().index()).data().id;

            // Recuperando o nome e a matrícula
            nomeAluno   = table.row($(this).parent().parent().parent().parent().parent().index()).data().nome;
            matricula   = table.row($(this).parent().parent().parent().parent().parent().index()).data().matricula;
            codigoCurso = table.row($(this).parent().parent().parent().parent().parent().index()).data().codigoCurso;
            periodo     = table.row($(this).parent().parent().parent().parent().parent().index()).data().periodo;

            // prenchendo o titulo do nome do aluno
            $('#tlHMatricula').text(matricula);
            $('#tlHNomeAluno').text(nomeAluno);
            $('#tlHCurso').text(codigoCurso);
            $('#tlHPeriodo').text(periodo);

            // Executando o script de histórico
            runHistorico(idAluno);
        });

        // Evento para abrir o modal de histórico
        $(document).on("click", "#modalCurriculo", function () {
            // recuperando o id do aluno e do semestre
            idAluno    = table.row($(this).parent().parent().parent().parent().parent().index()).data().id;
            idSemestre = table.row($(this).parent().parent().parent().parent().parent().index()).data().idSemestre;

            // Recuperando o nome e a matrícula
            nomeAluno   = table.row($(this).parent().parent().parent().parent().parent().index()).data().nome;
            matricula   = table.row($(this).parent().parent().parent().parent().parent().index()).data().matricula;
            codigoCurso = table.row($(this).parent().parent().parent().parent().parent().index()).data().codigoCurso;
            periodo     = table.row($(this).parent().parent().parent().parent().parent().index()).data().periodo;

            // prenchendo o titulo do nome do aluno
            $('#tlMatricula').text( matricula);
            $('#tlNomeAluno').text(nomeAluno);
            $('#tlCurso').text(codigoCurso);
            $('#tlPeriodo').text(periodo);

            // Executando o script de curriculo
            runCurriculo(idAluno);
        });

        // Evento para abrir o modal de semestre
        $(document).on("click", "#modalSemestre", function () {
            // recuperando o id do aluno e o semestre
            idAluno    = table.row($(this).parent().parent().parent().parent().parent().index()).data().id;
            idSemestre = table.row($(this).parent().parent().parent().parent().parent().index()).data().idSemestre;

            // Recuperando o nome e a matrícula
            nomeAluno   = table.row($(this).parent().parent().parent().parent().parent().index()).data().nome;
            matricula   = table.row($(this).parent().parent().parent().parent().parent().index()).data().matricula;
            codigoCurso = table.row($(this).parent().parent().parent().parent().parent().index()).data().codigoCurso;
            periodo     = table.row($(this).parent().parent().parent().parent().parent().index()).data().periodo;

            // prenchendo o titulo do nome do aluno
            $('#tlSMatricula').text(matricula);
            $('#tlSNomeAluno').text(nomeAluno);
            $('#tlSCurso').text(codigoCurso);
            $('#tlSPeriodo').text(periodo);

            // Executando o script de curriculo
            runSemestre(idAluno, idSemestre);
        });

        // Evento para abrir o modal de financeiro
        $(document).on("click", "#modalFinanceiro", function () {
            // recuperando o id do aluno e o semestre
            idAluno    = table.row($(this).parent().parent().parent().parent().parent().index()).data().id;
            idSemestre = table.row($(this).parent().parent().parent().parent().parent().index()).data().idSemestre;

            // Recuperando o nome e a matrícula
            nomeAluno   = table.row($(this).parent().parent().parent().parent().parent().index()).data().nome;
            matricula   = table.row($(this).parent().parent().parent().parent().parent().index()).data().matricula;
            codigoCurso = table.row($(this).parent().parent().parent().parent().parent().index()).data().codigoCurso;
            periodo     = table.row($(this).parent().parent().parent().parent().parent().index()).data().periodo;

            // prenchendo o titulo do nome do aluno
            $('#finMatricula').text(matricula);
            $('#finNomeAluno').text(nomeAluno);
            $('#finCurso').text(codigoCurso);
            $('#finPeriodo').text(periodo);

            // Carregando o modal
            runFinanceiro(idAluno);
        });


        // Evento para abrir o modal de financeiro
        $(document).on("click", "#modalBeneficio", function () {
            // recuperando o id do aluno e o semestre
            idAluno    = table.row($(this).parent().parent().parent().parent().parent().index()).data().id;
            idSemestre = table.row($(this).parent().parent().parent().parent().parent().index()).data().idSemestre;

            // Recuperando o nome e a matrícula
            nomeAluno   = table.row($(this).parent().parent().parent().parent().parent().index()).data().nome;
            matricula   = table.row($(this).parent().parent().parent().parent().parent().index()).data().matricula;
            codigoCurso = table.row($(this).parent().parent().parent().parent().parent().index()).data().codigoCurso;
            periodo     = table.row($(this).parent().parent().parent().parent().parent().index()).data().periodo;

            // prenchendo o titulo do nome do aluno
            $('#benMatricula').text(matricula);
            $('#benNomeAluno').text(nomeAluno);
            $('#benCurso').text(codigoCurso);
            $('#benPeriodo').text(periodo);

            // Carregando o modal
            runBeneficio(idAluno);
        });

        /**
         * Evento responsável por gerar um gráfico a partir
         * do filtro escolhido na busca.
         */
        $(document).on('click', '#reportAluno', function () {
            // Reuperando os valores do filtro
            var semestre = $('select[name=semestreSearch] option:selected').val();
            var situacao = $('select[name=situacaoSearch] option:selected').val();
            var globalSearch = $('input[name=globalSearch]').val();

            // Dados para requisição
            var dados =  'semestre=' + semestre + '&situacao=' + situacao + '&globalSearch=' + globalSearch;

            // Redirecionando para a página de relatório
            window.open('/index.php/seracademico/graduacao/aluno/reportFilter?' + dados ,'_blank');
        });
    </script>
@stop
