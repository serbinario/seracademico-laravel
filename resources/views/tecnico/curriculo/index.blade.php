@extends('menu')

@section('css')
    <style type="text/css">
        .select2-container {
            width: 100% !important;
            padding: 0;
        }

        .select2-close-mask{
            z-index: 2099;
        }

        .select2-dropdown{
            z-index: 3051;
        }

        /*#disciplina-grid tbody tr{*/
            /*font-size: 10px;*/
        /*}*/

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
                <h4><i class="material-icons">library_books</i> Listar Currículos</h4>
            </div>
            <div class="col-sm-6 col-md-3">
                <a href="{{ route('seracademico.tecnico.curriculo.create')}}" class="btn-sm btn-primary pull-right">Novo Curriculo</a>
            </div>
        </div>

        <div class="ibox-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive no-padding">
                        <table id="curriculo-grid" class="display table table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Código</th>
                                <th>Currículo</th>
                                <th>Cód. Curso</th>
                                <th>Curso</th>
                                <th>Ano</th>
                                {{--<th>Validade (Início)</th>--}}
                                {{--<th>Validade (Fim)</th>--}}
                                <th>Ativo</th>
                                <th >Acão</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Código</th>
                                <th>Currículo</th>
                                <th>Cód. Curso</th>
                                <th>Curso</th>
                                <th>Ano</th>
                                {{--<th>Validade (Início)</th>--}}
                                {{--<th>Validade (Fim)</th>--}}
                                <th>Ativo</th>
                                <th style="width: 5%;">Acão</th>
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

    @include('reports.simple.modals.modal_report_tecnico_curriculo_disciplina')
    @include('tecnico.curriculo.modal_adicionar_disciplina')
    {{--@include('tecnico.curriculo.modal_inserir_adicionar_disciplina')
    @include('tecnico.curriculo.modal_editar_adicionar_disciplina')--}}
@stop

@section('javascript')
    <script type="text/javascript" src="{{ asset('/js/report/simple/modal_report_tecnico_curriculo_disciplina.js') }}"></script>
    <script type="text/javascript">
        /*Datatable da grid principal*/
        var table = $('#curriculo-grid').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: "{!! route('seracademico.tecnico.curriculo.grid') !!}",
            columns: [
                {data: 'codigo', name: 'fac_curriculos.codigo'},
                {data: 'nome', name: 'fac_curriculos.nome'},
                {data: 'codigo_curso', name: 'fac_cursos.codigo'},
                {data: 'curso', name: 'fac_cursos.nome'},
                {data: 'ano', name: 'fac_curriculos.ano'},
//                {data: 'valido_inicio', name: 'fac_curriculos.valido_inicio'},
//                {data: 'valido_fim', name: 'fac_curriculos.valido_fim'},
                {data: 'ativo', name: 'fac_curriculos.ativo'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

        //Variável que armazenará o id do currículo
        var idCurriculo = 0;
        var table2;

        /*Responsável em abrir modal*/
        $(document).on("click", '.grid-curricular', function () {
            $("#modal-grade-curricular").modal({show: true, keyboard: true});
            idCurriculo = table.row($(this).parents('tr').index()).data().id;

            /*Datatable da grid Modal*/
            table2 = $('#disciplina-grid').DataTable({
                retrieve: true,
                processing: true,
                serverSide: true,
                iDisplayLength: 5,
                bLengthChange: false,
                ajax: "/index.php/seracademico/tecnico/curriculo/gridByCurriculo/" + idCurriculo,
                columns: [
                    {data: 'nome', name: 'fac_disciplinas.nome'},
                    {data: 'carga_horaria', name: 'fac_disciplinas.carga_horaria'},
                    {data: 'qtd_falta', name: 'fac_disciplinas.qtd_falta'},
                    {data: 'tipo_disciplina', name: 'fac_tipo_disciplinas.nome'},
                    {data: 'modulo', name: 'tec_modulos.nome'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });

            //Carregando a datatable
            table2.ajax.url("/index.php/seracademico/tecnico/curriculo/gridByCurriculo/" + idCurriculo).load();
        });

        //consulta via select2
        $("#select-disciplina").select2({
            placeholder: 'Selecione uma ou mais disciplinas',
            width: 600,
            ajax: {
                type: 'POST',
                url: "{{ route('seracademico.util.select2')  }}",
                dataType: 'json',
                delay: 250,
                crossDomain: true,
                data: function (params) {
                    return {
                        'search':         params.term, // search term
                        'tableName':      'fac_disciplinas',
                        'fieldName':      'nome',
                        'page':           params.page || 1,
                        'tableNotIn':     'fac_curriculo_disciplina',
                        'columnWhere' :   'curriculo_id',
                        'columnNotWhere': 'id',
                        'culmnNotGet':    'disciplina_id',
                        'valueWhere':     4,
                        'fieldWhere':     'tipo_nivel_sistema_id',
                        'valueNotWhere':    idCurriculo
                    };
                },
                headers: {
                    'X-CSRF-TOKEN' : '{{  csrf_token() }}'
                },
                processResults: function (data, params) {

                    // parse the results into the format expected by Select2
                    // since we are using custom formatting functions we do not need to
                    // alter the remote JSON data, except to indicate that infinite
                    // scrolling can be used
                    params.page = params.page || 1;

                    return {
                        results: data.data,
                        pagination: {
                            more: data.more
                        }
                    };
                }
            }
        });

        //Evento do click no botão adicionar disciplina
        $(document).on('click', '#addDisciplina', function (event) {
            var array   = $('#select-disciplina').select2('data');
            var modulo  = $('#modulo_id').val();

            // Verificando preenchimento dos campos disciplina e modulo
            if (!array.length > 0 || modulo == 0) {
                sweetAlert("Oops...", "Por favor, selecione a disciplina e um modulo", "error");
                return false;
            }

            var arrayId = [];

            for (var i = 0; i < array.length; i++) {
                arrayId[i] = array[i].id
            }

            //Setando o o json para envio
            var dados = {
                'idCurriculo' : idCurriculo,
                'idDisciplinas' : arrayId,
                'modulo_id' : modulo
            };

            jQuery.ajax({
                type: 'POST',
                url: '{{ route('seracademico.tecnico.curriculo.adicionarDisciplinas')  }}',
                headers: {
                    'X-CSRF-TOKEN': '{{  csrf_token() }}'
                },
                data: dados,
                datatype: 'json'
            }).done(function (json) {
                $('#select-disciplina').select2("val", "");
                swal("Disciplina(s) adicionada(s) com sucesso!", "Click no botão abaixo!", "success");
                table2.ajax.reload();
            });
        });

        //Evento de remover a disciplina
        $(document).on('click', '.removerDisciplina', function () {
            idCurriculo  = table2.row($(this).parent().parent().parent().parent().parent().index()).data().idCurriculo;
            idDisciplina = table2.row($(this).parent().parent().parent().parent().parent().index()).data().id;

            //Setando o o json para envio
            var dados = {
                'idCurriculo'  : idCurriculo,
                'idDisciplina' : idDisciplina,
            };

            jQuery.ajax({
                type: 'POST',
                url: '{{ route('seracademico.tecnico.curriculo.removerDisciplina')  }}',
                headers: {
                    'X-CSRF-TOKEN': '{{  csrf_token() }}'
                },
                data: dados,
                datatype: 'json'
            }).done(function (retorno) {
                $('#select-disciplina').select2("val", "");
                swal("Disciplina removida com sucesso!", "Click no botão abaixo!", "success");
                table2.ajax.reload();
            });
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