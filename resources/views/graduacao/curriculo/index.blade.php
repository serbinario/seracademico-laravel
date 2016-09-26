@extends('menu')

@section('css')
    <link rel="stylesheet" href="{{ asset('/js/graduacao/curriculo/css/modal_eletivas.css') }}">
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

        table.dataTable tbody th, table.dataTable tbody td {
            padding: 2px 10px;
        }

        td.details-control {
            background: url('{{asset("imagemgrid/icone-produto-plus.png")}}') no-repeat center center;
            cursor: pointer;
        }

        tr.details td.details-control {
            background: url('{{asset("imagemgrid/icone-produto-minus.png")}}') no-repeat center center;
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
                <a href="{{ route('seracademico.graduacao.curriculo.create')}}" class="btn-sm btn-primary pull-right">Novo Curriculo</a>
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

    <!-- Modais -->
    @include('graduacao.curriculo.modal_adicionar_disciplina')
    @include('graduacao.curriculo.modal_inserir_adicionar_disciplina')
    @include('graduacao.curriculo.modal_editar_adicionar_disciplina')
    @include('graduacao.curriculo.modal_curriculos_eletivas')
    @include('graduacao.curriculo.modal_store_adicionar_eletiva')
@stop

@section('javascript')
    <script type="text/javascript" src="{{ asset('/js/graduacao/curriculo/modal_adicionar_disciplina.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/graduacao/curriculo/modal_inserir_adicionar_disciplina.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/graduacao/curriculo/modal_editar_adicionar_disciplina.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/graduacao/curriculo/modal_curriculos_eletivas.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/graduacao/curriculo/modal_store_adicionar_eletiva.js') }}"></script>
    <script type="text/javascript">
        /*Datatable da grid principal*/
        var table = $('#curriculo-grid').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: "{!! route('seracademico.graduacao.curriculo.grid') !!}",
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

        //Id e nome do Currículo
        var idCurriculo   = 0;
        var nomeCurriculo = 0;

        // Evento para abrir a modal de adicionar disciplinas ao currículo
        $(document).on("click", "#btnGraduacaoAddDisciplinaCurriculo", function () {
            idCurriculo     = table.row($(this).parent().parent().parent().parent().parent().index()).data().id;
            nomeCurriculo   = table.row($(this).parent().parent().parent().parent().parent().index()).data().nome;
            codigoCurriculo = table.row($(this).parent().parent().parent().parent().parent().index()).data().codigo;

            //Chmando a modal de adicionar disciplina
            runTableAdicionarDisciplina(idCurriculo);

            // Setando a descrição do modal
            $('#adNomeCurriculo').text(nomeCurriculo);
            $('#adCodigoCurriculo').text(codigoCurriculo);

            //mostrando a modal
            $("#modal-adicionar-disciplina-curriculo").modal({show:true});
        });

        // Evento para abrir a modal de adicionar disciplinas ao currículo
        $(document).on("click", "#btnGraduacaoEletivaOfCurriculo", function () {
            idCurriculo     = table.row($(this).parent().parent().parent().parent().parent().index()).data().id;
            nomeCurriculo   = table.row($(this).parent().parent().parent().parent().parent().index()).data().nome;
            codigoCurriculo = table.row($(this).parent().parent().parent().parent().parent().index()).data().codigo;

            //Chmando a modal de adicionar disciplina
            runTableDisciplinaEletiva(idCurriculo);

            // Setando a descrição do modal
            $('#ceNomeCurriculo').text(nomeCurriculo);
            $('#ceCodigoCurriculo').text(codigoCurriculo);

            //Ativando o botão de adicionar disciplina
            $("#btnAdicionarOpcaoEletiva").prop("disabled", true);

            //mostrando a modal
            $("#modal-curriculo-eletiva").modal({show:true});
        });
    </script>
@stop