@extends('menu')

{{--@section("css")--}}
    {{--<link rel="stylesheet" href="{{ asset('/js/posgraduacao/turma/css/modal_calendario.css') }}">--}}
{{--@stop--}}

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
        <div class="ibox-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive no-padding">
                        <table id="turma-grid" class="display table table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Código</th>
                                <th>Descrição</th>
                                <th>Codigo da turma</th>
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
                                <th>Código</th>
                                <th>Descrição</th>
                                <th>Codigo da turma</th>
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
    {{--@include('turma.modal_editar_calendario')--}}
    {{--@include('turma.modal_incluir_disciplinas')--}}
@stop

@section('javascript')
    <script type="text/javascript" src="{{ asset('/js/graduacao/turma/modal_disciplina.js')  }}"></script>
    <script type="text/javascript" src="{{ asset('/js/graduacao/turma/modal_disciplina_store.js')  }}"></script>
    <script type="text/javascript" src="{{ asset('/js/graduacao/turma/modal_horario.js')  }}"></script>
    {{--<script type="text/javascript" src="{{ asset('/js/posgraduacao/turma/modal_editar_calendario.js')  }}"></script>--}}
    {{--<script type="text/javascript" src="{{ asset('/js/posgraduacao/turma/modal_incluir_disciplinas.js')  }}"></script>--}}
    <script type="text/javascript">
        var table = $('#turma-grid').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,

            ajax: "{!! route('seracademico.graduacao.turma.grid') !!}",
            columns: [
                {data: 'codigo', name: 'fac_cursos.codigo'},
                {data: 'nome', name: 'fac_cursos.nome'},
                {data: 'codigo_turma', name: 'fac_turmas.codigo'},
                {data: 'turno', name: 'fac_turnos.nome'},
                {data: 'aula_inicio', name: 'fac_turmas.aula_inicio'},
                {data: 'aula_final', name: 'fac_turmas.aula_final'},
                {data: 'semestre', name: 'fac_semestres.nome'},
                {data: 'periodo', name: 'fac_turmas.periodo'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
        //Id da turma corrente
        var idTurma;

        /*Responsável em abrir modal*/
        $(document).on("click", '#modal-horario', function () {
            //Recuperando o id da turma selecionada
            idTurma  = table.row($(this).parent().parent().parent().parent().parent().index()).data().id;
            periodo  = table.row($(this).parent().parent().parent().parent().parent().index()).data().periodo;

            //Executando as grids
            runTableDisciplina(idTurma);
            runTableHorario(idTurma);

            $("#modal-disciplina-horario").find('.modal-dialog').css("width", "100%");
            $("#modal-disciplina-horario").find('.modal-dialog').css("max-height", "100%");
            $("#modal-disciplina-horario").modal({show: true, keyboard: true});
        });

    </script>
@stop