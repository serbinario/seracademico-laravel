@extends('menu')

@section("css")
    <link rel="stylesheet" href="{{ asset('/js/posgraduacao/turma/css/modal_calendario.css') }}">
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
                <a href="{{ route('seracademico.posgraduacao.aluno.create')}}" class="btn-sm btn-primary pull-right">Novo Aluno</a>
            </div>
        </div>
        <div class="ibox-content">
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
                                <th>Acão</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Nome</th>
                                <th>Matrícula</th>
                                <th>Telefones</th>
                                <th>CPF</th>
                                <th style="width: 5%">Acão</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('aluno.turma.modal_aluno_turma')
    @include('aluno.turma.modal_nova_turma')
@stop

@section('javascript')
    <script type="text/javascript" src="{{ asset('/js/posgraduacao/aluno/modal_aluno_turma.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/posgraduacao/aluno/modal_nova_turma.js') }}"></script>
    <script type="text/javascript">
        var table = $('#aluno-grid').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: "{!! route('seracademico.posgraduacao.aluno.grid') !!}",
            columns: [
                {data: 'nome', name: 'nome'},
                {data: 'matricula', name: 'matricula'},
                {data: 'celular', name: 'celular'},
                {data: 'cpf', name: 'cpf'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

        // Id do aluno corrente
        var idAluno;

        // Evento para abrir o modal de cursos/turmas
        $(document).on("click", "#link_modal_curso_turma", function () {
            idAluno = table.row($(this).parent().parent().parent().index()).data().id;

            $("#modal-turma-aluno").modal({show:true});
            loadTableCursoTurma(idAluno);
        });
    </script>
@stop
