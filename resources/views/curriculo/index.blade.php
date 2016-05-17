@extends('menu')

@section('css')
    <style type="text/css">
        .select2-close-mask{
            z-index: 2099;
        }

        .select2-dropdown{
            z-index: 3051;
        }

        #disciplina-grid tbody tr{
            font-size: 10px;
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
                <a href="{{ route('seracademico.posgraduacao.curriculo.create')}}" class="btn-sm btn-primary pull-right">Novo Curriculo</a>
            </div>
        </div>

        <div class="ibox-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive no-padding">
                        <table id="curriculo-grid" class="display table table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Código Currículo</th>
                                <th>Descrição</th>
                                <th>Código Curso</th>
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
                                <th>Código Currículo</th>
                                <th>Descrição</th>
                                <th>Código Curso</th>
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
        </div>        
    </div>

    <!-- Modal de cadastro das Disciplinas-->
    <div id="modal-grade-curricular" class="modal fade modal-profile" role="dialog" aria-labelledby="modalProfile" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" type="button" data-dismiss="modal">×</button>
                    <h4 class="modal-title">Adicionar disciplinas ao currículo</h4>
                </div>
                <div class="modal-body" style="alignment-baseline: central">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="input-group">
                                <select  id="select-disciplina" multiple="multiple" class="form-control"></select>
                                <span class="input-group-btn">
                                    <button class="btn btn-sm btn-primary" type="button" id="addDisciplina">Adicionar Disciplinas</button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table id="disciplina-grid" class="display table table-bordered" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th style="width: 5%;">Qtd. Faltas</th>
                                    <th style="width: 10%;">Tipo da disciplina</th>
                                    <th >Acão</th>
                                </tr>
                                </thead>

                                <tfoot>
                                <tr>
                                    <th>Nome</th>
                                    <th style="width: 5%;">Qtd. Faltas</th>
                                    <th style="width: 10%;">Tipo da disciplina</th>
                                    <th style="width: 5%;">Acão</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- FIM Modal de cadastro das Disciplinas-->
@stop

@section('javascript')
    <script type="text/javascript">
        /*Datatable da grid principal*/
        var table = $('#curriculo-grid').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: "{!! route('seracademico.posgraduacao.curriculo.grid') !!}",
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
            idCurriculo = table.row($(this).parent().parent().parent().parent().parent().index()).data().id;

            /*Datatable da grid Modal*/
            table2 = $('#disciplina-grid').DataTable({
                retrieve: true,
                processing: true,
                serverSide: true,
                iDisplayLength: 5,
                bLengthChange: false,
                ajax: "/index.php/seracademico/posgraduacao/curriculo/gridByCurriculo/" + idCurriculo,
                columns: [
                    {data: 'nome', name: 'fac_disciplinas.nome'},
                    {data: 'qtd_falta', name: 'fac_disciplinas.qtd_falta'},
                    {data: 'tipo_disciplina', name: 'fac_tipo_disciplinas.nome'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });

            //Carregando a datatable
            table2.ajax.url("/index.php/seracademico/posgraduacao/curriculo/gridByCurriculo/" + idCurriculo).load();
        });

         //consulta via select2
         $("#select-disciplina").select2({
             placeholder: 'Selecione uma ou mais disciplinas',
             width: 700,
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

            // Verificando se alguma disciplina foi selecionada
            if (!array.length > 0) {
                sweetAlert("Oops...", "Você deve selecionar uma disciplina!", "error");
                return false;
            }

            var arrayId = [];

            for (var i = 0; i < array.length; i++) {
                arrayId[i] = array[i].id
            }

            //Setando o o json para envio
            var dados = {
                'idCurriculo' : idCurriculo,
                'idDisciplinas' : arrayId
            };

            jQuery.ajax({
                type: 'POST',
                url: '{{ route('seracademico.posgraduacao.curriculo.adicionarDisciplinas')  }}',
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
                'idCurriculo' : idCurriculo,
                'idDisciplina' : idDisciplina
            };

            jQuery.ajax({
                type: 'POST',
                url: '{{ route('seracademico.posgraduacao.curriculo.removerDisciplina')  }}',
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
    </script>
@stop