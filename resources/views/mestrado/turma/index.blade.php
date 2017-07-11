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
                <h4><i class="material-icons">turned_in</i> Listar Turmas</h4>
            </div>
            <div class="col-sm-6 col-md-3">
                <a href="{{ route('seracademico.mestrado.turma.create')}}" class="btn-sm btn-primary pull-right">Nova Turma</a>
            </div>
        </div>

        <div class="ibox-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive no-padding">
                        <table id="turma-grid" class="display table table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Código Turma</th>
                                <th>Cód. Curso</th>
                                <th>Curso</th>
                                <th>Sede</th>
                                <th>Turno</th>
                                <th>Abertura</th>
                                <th>Fechamento</th>
                                <th>Val. Turma</th>
                                <th style="width: 5%;">Acão</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Código Turma</th>
                                <th>Cód. Curso</th>
                                <th>Curso</th>
                                <th>Sede</th>
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

    @include('mestrado.turma.modal_calendario')
    @include('mestrado.turma.modal_novo_calendario')
    @include('mestrado.turma.modal_editar_calendario')
    @include('mestrado.turma.modal_incluir_disciplinas')
    @include('mestrado.turma.modal_notas')
    @include('mestrado.turma.modal_editar_notas')
    @include('mestrado.turma.modal_frequencias')
    @include('mestrado.turma.alunos.modal_turmas_alunos')
    @include('mestrado.turma.alunos.modal_add_aluno')
    @include('mestrado.turma.diarioAula.modal_diario_aula')
    @include('mestrado.turma.diarioAula.modal_create_diario_aula')
    @include('mestrado.turma.diarioAula.modal_edit_diario_aula')
    @include('mestrado.turma.planoEnsino.modal_plano_ensino')
    @include('reports.simple.modals.modal_report_mestrado_turma_ata_assinatura')
    @include('reports.simple.modals.modal_report_mestrado_turma_ata_aniversariantes')
    @include('reports.simple.modals.modal_report_mes_aluno_turma')
@stop

@section('javascript')
    <script type="text/javascript" src="{{ asset('/js/mestrado/turma/modal_calendario.js')  }}"></script>
    <script type="text/javascript" src="{{ asset('/js/mestrado/turma/modal_novo_calendario.js')  }}"></script>
    <script type="text/javascript" src="{{ asset('/js/mestrado/turma/modal_editar_calendario.js')  }}"></script>
    <script type="text/javascript" src="{{ asset('/js/mestrado/turma/modal_incluir_disciplinas.js')  }}"></script>
    <script type="text/javascript" src="{{ asset('/js/mestrado/turma/modal_notas.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/mestrado/turma/modal_editar_notas.js')  }}"></script>
    <script type="text/javascript" src="{{ asset('/js/mestrado/turma/modal_frequencias.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/mestrado/turma/alunos/modal_turmas_alunos.js')  }}"></script>
    <script type="text/javascript" src="{{ asset('/js/mestrado/turma/alunos/modal_add_aluno.js')  }}"></script>
    <script type="text/javascript" src="{{ asset('/js/mestrado/turma/diarioAula/modal_diario_aula.js')  }}"></script>
    <script type="text/javascript" src="{{ asset('/js/mestrado/turma/diarioAula/modal_create_diario_aula.js')  }}"></script>
    <script type="text/javascript" src="{{ asset('/js/mestrado/turma/diarioAula/modal_edit_diario_aula.js')  }}"></script>
    <script type="text/javascript" src="{{ asset('/js/mestrado/turma/diarioAula/conteudo_programatico_create.js')  }}"></script>
    <script type="text/javascript" src="{{ asset('/js/mestrado/turma/diarioAula/conteudo_programatico_edit.js')  }}"></script>
    <script type="text/javascript" src="{{ asset('/js/mestrado/turma/diarioAula/diario_aula_select2.js')  }}"></script>
    <script type="text/javascript" src="{{ asset('/js/mestrado/turma/planoEnsino/modal_plano_ensino.js')  }}"></script>
    <script type="text/javascript" src="{{ asset('/js/report/simple/modal_report_mestrado_turma_ata_assinatura.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/report/simple/modal_report_mestrado_turma_ata_aniversariantes.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/report/simple/modal_report_mestrado_aluno_turma.js') }}"></script>
    <script type="text/javascript">
        var table = $('#turma-grid').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,

            ajax: "{!! route('seracademico.mestrado.turma.grid') !!}",
            columns: [
                {data: 'codigo_turma', name: 'fac_turmas.codigo'},
                {data: 'codigo', name: 'fac_cursos.codigo'},
                {data: 'nome', name: 'fac_cursos.nome'},
                {data: 'sede', name: 'sedes.nome'},
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

        /*Responsável em abrir modal*/
        $(document).on("click", '#modal-alunos', function () {
            // declaração de variáveis locais
            var codigo;

            //Recuperando o id da turma selecionada
            idTurma = table.row($(this).parent().parent().parent().parent().parent().index()).data().id;
            codigo  = table.row($(this).parent().parent().parent().parent().parent().index()).data().codigo_turma;

            // setando a descrição
            $('#gaTurma').text(codigo);

            //Executando a grid
            runTableAlunos(idTurma);

            // Abrindo o modal
            $("#modal-turmas-alunos").modal('show');
        });

        /*Responsável em abrir modal de frequencias*/
        $(document).on("click", '#btnModalDiarioAula', function () {
            // declaração de variáveis locais
            var nomeCurso, codCurriculo, semestre;

            //Recuperando o id da turma selecionada
            idTurma      = table.row($(this).parent().parent().parent().parent().parent().index()).data().id;
            periodo      = table.row($(this).parent().parent().parent().parent().parent().index()).data().periodo;
            codigo       = table.row($(this).parent().parent().parent().parent().parent().index()).data().codigo;
            nomeCurso    = table.row($(this).parent().parent().parent().parent().parent().index()).data().nome;
            codCurriculo = table.row($(this).parent().parent().parent().parent().parent().index()).data().codigoCurriculo;
            semestre     = table.row($(this).parent().parent().parent().parent().parent().index()).data().semestre;

            // setando a descrição
            $('#daTurma').text(codigo);
            $('#daPeriodo').text(periodo);
            $('#daCurriculo').text(codCurriculo);
            $('#daCurso').text(nomeCurso);
            $('#daSemestre').text(semestre);

            //Executando as grids
            runTableDiariosAulas(idTurma);
        });

        /*Responsável em abrir modal de frequencias*/
        $(document).on("click", '#btnModalPlanoEnsino', function () {
            // declaração de variáveis locais
            var nomeCurso, codCurriculo, semestre;

            //Recuperando o id da turma selecionada
            idTurma      = table.row($(this).parent().parent().parent().parent().parent().index()).data().id;
            periodo      = table.row($(this).parent().parent().parent().parent().parent().index()).data().periodo;
            codigo       = table.row($(this).parent().parent().parent().parent().parent().index()).data().codigo;
            nomeCurso    = table.row($(this).parent().parent().parent().parent().parent().index()).data().nome;
            codCurriculo = table.row($(this).parent().parent().parent().parent().parent().index()).data().codigoCurriculo;
            semestre     = table.row($(this).parent().parent().parent().parent().parent().index()).data().semestre;

            // setando a descrição
            $('#peTurma').text(codigo);
            $('#pePeriodo').text(periodo);
            $('#peCurriculo').text(codCurriculo);
            $('#peCurso').text(nomeCurso);
            $('#peSemestre').text(semestre);

            //Executando as grids
            runTablePlanoEnsino(idTurma);
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

        //modal calendario > modal adicionar calendario > select professor
        $('#professor_id').select2({ width: 142 });
        $('#professor_id_editar').select2({ width: 142 });
        //modal calendario > modal adicionar disciplina > select disciplina
        $('#incluir-disciplinas').select2({ width: 250 });
        //modal gerencimaneto alunos
        $('#disciplinaTurmaALunoSearch').select2({ width: 360 });
        //modal gerencimaneto alunos > adicionar aluno (reposição)
        $('#calendarioTurmaALunoSearch').select2({ width: 190 });
        //modal gerencimaneto alunos > adicionar aluno (reposição)
        $('#turma_disciplina_id').select2({ width: 250 });
        $('#add_aluno_curso').select2({ width: 250 });
        $('#turma_aluno_id').select2({ width: 250 });
        //modal add frequencia
        $('#disciplinaFrequenciasSearch').select2({ width: 360 });
        //modal add notas
        $('#disciplinaSearch').select2({ width: 360 });
    </script>
@stop