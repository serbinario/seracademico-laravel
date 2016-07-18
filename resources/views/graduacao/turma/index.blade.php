@extends('menu')

@section("css")
    <link rel="stylesheet" href="{{ asset('/js/graduacao/turma/css/modal_horario.css') }}">
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
                <h4><i class="material-icons">turned_in</i> Listar Turmas</h4>
            </div>
            <div class="col-sm-6 col-md-3">
                <a href="{{ route('seracademico.graduacao.turma.create')}}" class="btn-sm btn-primary pull-right">Nova Turma</a>
            </div>
        </div>

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

        <div class="ibox-content">
            <div class="row">
                <div class="col-md-12">
                    <form id="turma-search-form" class="form-inline" role="form" method="GET">
                        <div class="form-group">
                            {!! Form::select('semestreSearch', (['' => 'Todos os Semestres'] + $loadFields['graduacao\\semestre']->toArray()), count($semestres) == 2 ? $semestres[0]->id : null, array('class' => 'form-control')) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::select('periodoSearch', (['' => 'Todos as Períodos'] + [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10]), null, array('class' => 'form-control')) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::text('globalSearch',  null, array('class' => 'form-control', 'placeholder' => 'Pesquisa...')) !!}
                        </div>

                        <div class="form-group">
                            <button class="btn-sm btn-primary" type="submit">Pesquisar</button>
                        </div>
                    </form>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive no-padding">
                        <table id="turma-grid" class="display table table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Codigo da turma</th>
                                <th>Codigo do Curso</th>
                                <th>Descrição</th>
                                <th>Turno</th>
                                <th>Abertura</th>
                                <th>Fechamento</th>
                                <th>Semestre</th>
                                <th>Período</th>
                                <th style="width: 5%;">Acão</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Codigo da turma</th>
                                <th>Codigo do Curso</th>
                                <th>Descrição</th>
                                <th>Turno</th>
                                <th>Abertura</th>
                                <th>Fechamento</th>
                                <th>Semestre</th>
                                <th>Período</th>
                                <th >Acão</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('graduacao.turma.modal_disciplina')
    @include('graduacao.turma.modal_disciplina_store')
    @include('graduacao.turma.modal_horario_store')
    @include('graduacao.turma.modal_notas')
    @include('graduacao.turma.modal_editar_notas')
    @include('graduacao.turma.modal_frequencias')
    @include('graduacao.turma.modal_editar_frequencias')
    {{--@include('turma.modal_editar_calendario')--}}
    {{--@include('turma.modal_incluir_disciplinas')--}}
@stop

@section('javascript')
    <script type="text/javascript" src="{{ asset('/js/graduacao/turma/modal_disciplina.js')  }}"></script>
    <script type="text/javascript" src="{{ asset('/js/graduacao/turma/modal_disciplina_store.js')  }}"></script>
    <script type="text/javascript" src="{{ asset('/js/graduacao/turma/modal_horario.js')  }}"></script>
    <script type="text/javascript" src="{{ asset('/js/graduacao/turma/modal_horario_delete.js')  }}"></script>
    <script type="text/javascript" src="{{ asset('/js/graduacao/turma/modal_horario_store.js')  }}"></script>
    <script type="text/javascript" src="{{ asset('/js/graduacao/turma/modal_notas.js')  }}"></script>
    <script type="text/javascript" src="{{ asset('/js/graduacao/turma/modal_editar_notas.js')  }}"></script>
    <script type="text/javascript" src="{{ asset('/js/graduacao/turma/modal_frequencias.js')  }}"></script>
    <script type="text/javascript" src="{{ asset('/js/graduacao/turma/modal_editar_frequencias.js')  }}"></script>
    {{--<script type="text/javascript" src="{{ asset('/js/posgraduacao/turma/modal_incluir_disciplinas.js')  }}"></script>--}}
    <script type="text/javascript">
        var table = $('#turma-grid').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: "{!! route('seracademico.graduacao.turma.grid') !!}",
                data: function (d) {
                    d.semestre = $('select[name=semestreSearch] option:selected').val();
                    d.periodo = $('select[name=periodoSearch] option:selected').val();
                    d.globalSearch = $('input[name=globalSearch]').val();
                }
            },
            columns: [
                {data: 'codigo_turma', name: 'fac_turmas.codigo'},
                {data: 'codigo', name: 'fac_cursos.codigo'},
                {data: 'nome', name: 'fac_cursos.nome'},
                {data: 'turno', name: 'fac_turnos.nome'},
                {data: 'aula_inicio', name: 'fac_turmas.aula_inicio'},
                {data: 'aula_final', name: 'fac_turmas.aula_final'},
                {data: 'semestre', name: 'fac_semestres.nome'},
                {data: 'periodo', name: 'fac_turmas.periodo'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

        // Função do submit do search da grid principal
        $('#turma-search-form').on('submit', function(e) {
            table.draw();
            e.preventDefault();
        });

        //Id da turma corrente
        var idTurma;

        /*Responsável em abrir modal de horários*/
        $(document).on("click", '#modal-horario', function () {
            // declaração de variáveis locais
            var nomeCurso, codCurriculo, anoCurriculo;

            //Recuperando o id da turma selecionada
            idTurma      = table.row($(this).parent().parent().parent().parent().parent().index()).data().id;
            periodo      = table.row($(this).parent().parent().parent().parent().parent().index()).data().periodo;
            nomeCurso    = table.row($(this).parent().parent().parent().parent().parent().index()).data().nome;
            codCurriculo = table.row($(this).parent().parent().parent().parent().parent().index()).data().codigoCurriculo;
            anoCurriculo = table.row($(this).parent().parent().parent().parent().parent().index()).data().ano;

            // setando a descrição
            $('#thCurriculo').text(codCurriculo);
            $('#thCurso').text(nomeCurso);
            $('#thAno').text(anoCurriculo);

            //Executando as grids
            runTableDisciplina(idTurma);
            runTableHorario(idTurma);

            $("#modal-disciplina-horario").find('.modal-dialog').css("width", "97%");
            $("#modal-disciplina-horario").find('.modal-dialog').css("max-height", "97%");
            $("#modal-disciplina-horario").modal({show: true, keyboard: true});
        });

        /*Responsável em abrir modal de notas*/
        $(document).on("click", '#modal-notas', function () {
            // declaração de variáveis locais
            var nomeCurso, codCurriculo, anoCurriculo;

            //Recuperando o id da turma selecionada
            idTurma      = table.row($(this).parent().parent().parent().parent().parent().index()).data().id;
            periodo      = table.row($(this).parent().parent().parent().parent().parent().index()).data().periodo;
            nomeCurso    = table.row($(this).parent().parent().parent().parent().parent().index()).data().nome;
            codCurriculo = table.row($(this).parent().parent().parent().parent().parent().index()).data().codigoCurriculo;
            anoCurriculo = table.row($(this).parent().parent().parent().parent().parent().index()).data().ano;

            // setando a descrição
            $('#tnCurriculo').text(codCurriculo);
            $('#tnCurso').text(nomeCurso);
            $('#tnAno').text(anoCurriculo);

            //Executando as grids
            runTableNotas(idTurma);
        });

        /*Responsável em abrir modal de frequencias*/
        $(document).on("click", '#modal-frequencias', function () {
            // declaração de variáveis locais
            var nomeCurso, codCurriculo, anoCurriculo;

            //Recuperando o id da turma selecionada
            idTurma      = table.row($(this).parent().parent().parent().parent().parent().index()).data().id;
            periodo      = table.row($(this).parent().parent().parent().parent().parent().index()).data().periodo;
            nomeCurso    = table.row($(this).parent().parent().parent().parent().parent().index()).data().nome;
            codCurriculo = table.row($(this).parent().parent().parent().parent().parent().index()).data().codigoCurriculo;
            anoCurriculo = table.row($(this).parent().parent().parent().parent().parent().index()).data().ano;

            // setando a descrição
            $('#tfCurriculo').text(codCurriculo);
            $('#tfCurso').text(nomeCurso);
            $('#tfAno').text(anoCurriculo);

            //Executando as grids
            runTableFrequencias(idTurma);
        });
    </script>
@stop