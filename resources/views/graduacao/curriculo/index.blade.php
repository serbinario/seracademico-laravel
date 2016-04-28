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


    </script>
@stop