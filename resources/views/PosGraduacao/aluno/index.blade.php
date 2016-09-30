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
                                    <form id="report-form" class="form-inline" role="form">
                                        <div class="form-group">
                                            {!! Form::select('relatorios', ( ['' => 'Selecione um relatório'] + $loadFields['simplereport']->toArray()),
                                             Session::getOldInput('relatorios'), array('class' => 'form-control', 'id' => 'report_id')) !!}
                                        </div>

                                        <div class="form-group">
                                            {!! Form::select('cursos', ( ['' => 'Selecione um curso'] + $loadFields['posgraduacao\\curso']->toArray()),
                                             Session::getOldInput('cursos'), array('class' => 'form-control', 'id' => 'curso_id')) !!}
                                        </div>

                                        <div class="form-group">
                                            {!! Form::select('turmas', ( ['' => 'Selecione uma turma'] + $loadFields['posgraduacao\\turma']->toArray()),
                                             Session::getOldInput('turmas'), array('class' => 'form-control', 'id' => 'turma_id')) !!}
                                        </div>

                                        <div class="form-group">
                                            {!! Form::select('turnos', ( ['' => 'Selecione um turno'] + $loadFields['turno']->toArray()),
                                             Session::getOldInput('turnos'), array('class' => 'form-control', 'id' => 'turno_id')) !!}
                                        </div>

                                        <div class="form-group">
                                            <button class="btn-sm btn-primary" type="submit" id="reportVestibulando">Relatório</button>
                                        </div>
                                    </form>
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
            idAluno = table.row($(this).parent().parent().parent().index()).data().id;

            $("#modal-turma-aluno").modal({show:true});
            loadTableCursoTurma(idAluno);
        });

        $('#report-form').submit(function (event) {
            event.preventDefault();

            // Recuperando o id do relatório selecionado
            var reportId = $('#report_id').val();
            var cursoId  = $('#curso_id').val();
            var turmaId  = $('#turma_id').val();
            var turnoId  = $('#turno_id').val();

            // Validando o relatório escolhido
            if(!reportId) {
                swal('Você deve escolher um relatório', '', 'error');
                return false;
            }

            window.open("/index.php/seracademico/report/"
                    + reportId + "?fac_cursos,id="+cursoId+"&fac_turmas,id="+turmaId+"&fac_turnos,id="+turnoId, '_blank');
        });

    </script>
@stop
