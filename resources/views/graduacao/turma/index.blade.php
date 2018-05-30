@extends('menu')

@section("css")
    <link rel="stylesheet" href="{{ asset('/js/graduacao/turma/css/modal_horario.css') }}">
    <style type="text/css">
        .select2-close-mask{
            z-index: 2099;
        }

        .select2-dropdown{
            z-index: 3051;
        }

        table.dataTable tbody th, table.dataTable tbody td {
            padding: 2px 10px;
        }

        td.details-control {
            background: url({{asset("imagemgrid/icone-produto-plus.png")}}) no-repeat center center;
            cursor: pointer;
        }

        tr.details td.details-control {
            background: url({{asset("imagemgrid/icone-produto-minus.png")}}) no-repeat center center;
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
                                <th>Código do Currículo</th>
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
    @include('graduacao.turma.modal_disciplina')
    @include('graduacao.turma.modal_disciplina_store')
    @include('graduacao.turma.modal_horario_store')
    @include('graduacao.turma.modal_horario_update')
    {{--@include('graduacao.turma.modal_notas')--}}
    @include('graduacao.turma.modal_editar_notas')
    @include('graduacao.turma.modal_frequencias')
    @include('graduacao.turma.modal_editar_frequencias')
    @include('graduacao.turma.modal_notas_new')
    @include('graduacao.turma.diarioAula.modal_diario_aula')
    @include('graduacao.turma.diarioAula.modal_create_diario_aula')
    @include('graduacao.turma.diarioAula.modal_edit_diario_aula')
    @include('graduacao.turma.planoEnsino.modal_plano_ensino')
    @include('reports.simple.modals.modal_report_gra_turma_ata_assinatura')
    @include('reports.simple.modals.modal_report_gra_turma_ata_assinatura_aluno')
    @include('reports.simple.modals.modal_report_gra_turma_ata_assinatura_turno')
    @include('reports.simple.modals.modal_report_graduacao_aluno_ata_aniversariantes')
    @include('reports.simple.modals.modal_report_gra_aluno_caderneta')
    {{--@include('turma.modal_editar_calendario')--}}
    {{--@include('turma.modal_incluir_disciplinas')--}}
@stop

@section('javascript')
    <script type="text/javascript" src="{{ asset('/js/graduacao/turma/modal_disciplina.js')  }}"></script>
    <script type="text/javascript" src="{{ asset('/js/graduacao/turma/modal_disciplina_store.js')  }}"></script>
    <script type="text/javascript" src="{{ asset('/js/graduacao/turma/modal_horario.js')  }}"></script>
    <script type="text/javascript" src="{{ asset('/js/graduacao/turma/modal_horario_delete.js')  }}"></script>
    <script type="text/javascript" src="{{ asset('/js/graduacao/turma/modal_horario_store.js')  }}"></script>
    <script type="text/javascript" src="{{ asset('/js/graduacao/turma/modal_horario_update.js')  }}"></script>
    <script type="text/javascript" src="{{ asset('/js/graduacao/turma/modal_notas.js')  }}"></script>
    <script type="text/javascript" src="{{ asset('/js/graduacao/turma/modal_editar_notas.js')  }}"></script>
    <script type="text/javascript" src="{{ asset('/js/graduacao/turma/modal_frequencias.js')  }}"></script>
    <script type="text/javascript" src="{{ asset('/js/graduacao/turma/modal_editar_frequencias.js')  }}"></script>
    <script type="text/javascript" src="{{ asset('/js/graduacao/turma/diarioAula/modal_diario_aula.js')  }}"></script>
    <script type="text/javascript" src="{{ asset('/js/graduacao/turma/diarioAula/modal_create_diario_aula.js')  }}"></script>
    <script type="text/javascript" src="{{ asset('/js/graduacao/turma/diarioAula/modal_edit_diario_aula.js')  }}"></script>
    <script type="text/javascript" src="{{ asset('/js/graduacao/turma/diarioAula/conteudo_programatico_create.js')  }}"></script>
    <script type="text/javascript" src="{{ asset('/js/graduacao/turma/diarioAula/conteudo_programatico_edit.js')  }}"></script>
    <script type="text/javascript" src="{{ asset('/js/graduacao/turma/diarioAula/diario_aula_select2.js')  }}"></script>
    <script type="text/javascript" src="{{ asset('/js/graduacao/turma/planoEnsino/modal_plano_ensino.js')  }}"></script>
    <script type="text/javascript" src="{{ asset('/js/report/simple/modal_report_gra_turma_ata_assinatura.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/report/simple/modal_report_gra_turma_ata_assinatura_aluno.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/report/simple/modal_report_gra_turma_ata_assinatura_turno.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/report/simple/modal_report_gra_turma_ata_aniversariantes.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/report/simple/modal_report_gra_aluno_caderneta.js') }}"></script>
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
                {data: 'codigoCurriculo', name: 'fac_curriculos.codigo'},
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
            var nomeCurso, codCurriculo, semestre;

            //Recuperando o id da turma selecionada
            idTurma      = table.row($(this).parent().parent().parent().parent().parent().index()).data().id;
            codigo       = table.row($(this).parent().parent().parent().parent().parent().index()).data().codigo;
            periodo      = table.row($(this).parent().parent().parent().parent().parent().index()).data().periodo;
            nomeCurso    = table.row($(this).parent().parent().parent().parent().parent().index()).data().nome;
            codCurriculo = table.row($(this).parent().parent().parent().parent().parent().index()).data().codigoCurriculo;
            semestre     = table.row($(this).parent().parent().parent().parent().parent().index()).data().semestre;

            // setando a descrição
            $('#thTurma').text(codigo);
            $('#thPeriodo').text(periodo);
            $('#thCurriculo').text(codCurriculo);
            $('#thCurso').text(nomeCurso);
            $('#thSemestre').text(semestre);

            //Executando as grids
            runTableDisciplina(idTurma);
            runTableHorario(idTurma);

            $("#modal-disciplina-horario").find('.modal-dialog').css("width", "97%");
            $("#modal-disciplina-horario").find('.modal-dialog').css("max-height", "97%");
            $("#modal-disciplina-horario").modal({show: true, keyboard: true});
        });

        /*Responsável em abrir modal de notas*/
        /*$(document).on("click", '#modal-notas', function () {
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
            $('#tnTurma').text(codigo);
            $('#tnPeriodo').text(periodo);
            $('#tnCurriculo').text(codCurriculo);
            $('#tnCurso').text(nomeCurso);
            $('#tnSemestre').text(semestre);

            //Executando as grids
            runTableNotas(idTurma);
        });*/
         $(document).on("click", '#btnNotasNew', function () {
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
            $('#tnTurma').text(codigo);
            $('#tnPeriodo').text(periodo);
            $('#tnCurriculo').text(codCurriculo);
            $('#tnCurso').text(nomeCurso);
            $('#tnSemestre').text(semestre);

             // Remove toda a tbody
             $("#notas-grid tbody").remove();

            //Executando as grids
            runTableNotas(idTurma);
        });

        /*Responsável em abrir modal de frequencias*/
        $(document).on("click", '#modal-frequencias', function () {
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
            $('#tfTurma').text(codigo);
            $('#tfPeriodo').text(periodo);
            $('#tfCurriculo').text(codCurriculo);
            $('#tfCurso').text(nomeCurso);
            $('#tfSemestre').text(semestre);

            //Executando as grids
            runTableFrequencias(idTurma);
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
    </script>
@stop