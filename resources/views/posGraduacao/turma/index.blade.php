@extends('menu')

@section("css")
    <link rel="stylesheet" href="{{ asset('/js/posgraduacao/turma/css/modal_calendario.css') }}">

    <style type="text/css">

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
                    <h4><i class="material-icons">turned_in</i> Listar Turmas</h4>
                </div>
                <div class="col-sm-6 col-md-3">
                    <a href="{{ route('seracademico.posgraduacao.turma.create')}}" class="btn-sm btn-primary pull-right">Nova Turma</a>
                </div>
            </div>
        <div class="ibox-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive no-padding">
                        <table id="turma-grid" class="display table table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Cód. Turma</th>
                                <th>Cód. Curso</th>
                                <th>Curso</th>
                                <th>Turno</th>
                                <th>Abertura</th>
                                <th>Fechamento</th>
                                <th>Val. Turma</th>
                                <th style="width: 5%;">Acão</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Cód. Turma</th>
                                <th>Cód. Curso</th>
                                <th>Curso</th>
                                <th>Turno</th>
                                <th>Abertura</th>
                                <th>Fechamento</th>
                                <th>Val. Turma</th>
                                <th >Acão</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('posGraduacao.turma.modal_calendario')
    @include('posGraduacao.turma.modal_novo_calendario')
    @include('posGraduacao.turma.modal_editar_calendario')
    @include('posGraduacao.turma.modal_incluir_disciplinas')
    @include('posGraduacao.turma.modal_notas')
    @include('posGraduacao.turma.modal_frequencias')
@stop

@section('javascript')
    <script type="text/javascript" src="{{ asset('/js/posgraduacao/turma/modal_calendario.js')  }}"></script>
    <script type="text/javascript" src="{{ asset('/js/posgraduacao/turma/modal_novo_calendario.js')  }}"></script>
    <script type="text/javascript" src="{{ asset('/js/posgraduacao/turma/modal_editar_calendario.js')  }}"></script>
    <script type="text/javascript" src="{{ asset('/js/posgraduacao/turma/modal_incluir_disciplinas.js')  }}"></script>
    <script type="text/javascript" src="{{ asset('/js/posgraduacao/turma/modal_notas.js')  }}"></script>
    <script type="text/javascript">
        var table = $('#turma-grid').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,

            ajax: "{!! route('seracademico.posgraduacao.turma.grid') !!}",
            columns: [
                {data: 'codigo_turma', name: 'fac_turmas.codigo'},
                {data: 'codigo', name: 'fac_cursos.codigo'},
                {data: 'nome', name: 'fac_cursos.nome'},
                {data: 'turno', name: 'fac_turnos.nome'},
                {data: 'aula_inicio', name: 'fac_turmas.aula_inicio'},
                {data: 'aula_final', name: 'fac_turmas.aula_final'},
                {data: 'valor_turma', name: 'fac_turmas.valor_turma'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
        //Id da turma corrente
        var idTurma;

        /*Responsável em abrir modal*/
        $(document).on("click", '.modal-calendario', function () {
            // declaração de variáveis locais
            var codigo;

            //Recuperando o id da turma selecionada
            idTurma = table.row($(this).parent().parent().parent().parent().parent().index()).data().id;
            codigo  = table.row($(this).parent().parent().parent().parent().parent().index()).data().codigo_turma;

            // setando a descrição
            $('#caTurma').text(codigo);

            //Executando a grid
            runTableDisciplina(idTurma);

            $("#modal-disciplina-calendario").find('.modal-dialog').css("width", "100%");
            $("#modal-disciplina-calendario").find('.modal-dialog').css("max-height", "100%");
            $("#modal-disciplina-calendario").modal({show: true, keyboard: true});
        });

        /*Responsável em abrir modal*/
        $(document).on("click", '#modal-notas', function () {
            // declaração de variáveis locais
            var codigo;

            //Recuperando o id da turma selecionada
            idTurma = table.row($(this).parent().parent().parent().parent().parent().index()).data().id;
            codigo  = table.row($(this).parent().parent().parent().parent().parent().index()).data().codigo_turma;

            // setando a descrição
            $('#naCodigo').text(codigo);

            //Executando a grid
            runTableNotas(idTurma);
        });

        /*Responsável em abrir modal*/
        $(document).on("click", '#modal-frequencias', function () {
            // declaração de variáveis locais
            var codigo;

            //Recuperando o id da turma selecionada
            idTurma = table.row($(this).parent().parent().parent().parent().parent().index()).data().id;
            codigo  = table.row($(this).parent().parent().parent().parent().parent().index()).data().codigo_turma;

            // setando a descrição
            $('#faCodigo').text(codigo);

            //Executando a grid
            runTableFrequencias(idTurma);
        });
    </script>
@stop