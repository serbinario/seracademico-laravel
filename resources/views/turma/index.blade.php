@extends('menu')

@section("css")
    <link rel="stylesheet" href="{{ asset('/js/posgraduacao/turma/css/modal_calendario.css') }}">
@stop

@section('content')
    <div class="ibox float-e-margins">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <div class="col-md-10">
                    <h4>
                        <i class="fa fa-users"></i>
                        Listar Turmas
                    </h4>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('seracademico.posgraduacao.turma.create')}}" class="btn-sm btn-primary">Nova Turma</a>
                </div>
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
                                <th>Valor Integral</th>
                                <th>Valor Isolado</th>
                                <th >Acão</th>
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
                                <th>Valor Integral</th>
                                <th>Valor Isolado</th>
                                <th style="...">Acão</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="ibox-footer">
            <span class="pull-right">
                The righ side of the footer
            </span>
            This is simple footer example
        </div>
    </div>
    @include('turma.modal_calendario')
    @include('turma.modal_novo_calendario')
    @include('turma.modal_editar_calendario')
@stop

@section('javascript')
    <script type="text/javascript" src="{{ asset('/js/posgraduacao/turma/modal_calendario.js')  }}"></script>
    <script type="text/javascript" src="{{ asset('/js/posgraduacao/turma/modal_novo_calendario.js')  }}"></script>
    <script type="text/javascript" src="{{ asset('/js/posgraduacao/turma/modal_editar_calendario.js')  }}"></script>
    <script type="text/javascript">
        var table = $('#turma-grid').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{!! route('seracademico.posgraduacao.turma.grid') !!}",
            columns: [
                {data: 'codigo', name: 'fac_cursos.codigo'},
                {data: 'nome', name: 'fac_cursos.nome'},
                {data: 'codigo_turma', name: 'fac_turmas.codigo'},
                {data: 'turno', name: 'fac_turnos.nome'},
                {data: 'aula_inicio', name: 'fac_turmas.aula_inicio'},
                {data: 'aula_final', name: 'fac_turmas.aula_final'},
                {data: 'valor_turma', name: 'fac_turmas.valor_turma'},
                {data: 'valor_disciplina', name: 'fac_turmas.valor_disciplina'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

        var idTurma;
        /*Responsável em abrir modal*/
        $(document).on("click", '.modal-calendario', function () {
            //Recuperando o id da turma selecionada
            idTurma = table.row($(this).parent().parent().index()).data().id;

            //Executando a grid
            runTableDisciplina(idTurma);

            $("#modal-disciplina-calendario").find('.modal-dialog').css("width", "100%");
            $("#modal-disciplina-calendario").find('.modal-dialog').css("max-height", "100%");
            $("#modal-disciplina-calendario").modal({show: true});
        });

    </script>
@stop