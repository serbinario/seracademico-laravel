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
                <h4><i class="material-icons">library_books</i> Listar Modulos</h4>
            </div>
            <div class="col-sm-6 col-md-3">
                <a href="{{ route('seracademico.tecnico.modulo.create')}}" class="btn-sm btn-primary pull-right">Novo Modulo</a>
            </div>
        </div>

        <div class="ibox-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive no-padding">
                        <table id="modulo-grid" class="display table table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Código</th>
                                <th>Nome</th>
                                <th>Acão</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Código</th>
                                <th>Nome</th>
                                <th style="width: 5%;">Acão</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>        
    </div>
@stop

@section('javascript')
    <script type="text/javascript">
        /*Datatable da grid principal*/
        var table = $('#modulo-grid').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: "{!! route('seracademico.tecnico.modulo.grid') !!}",
            columns: [
                {data: 'codigo', name: 'tec_modulos.codigo'},
                {data: 'nome', name: 'tec_modulos.nome'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    </script>
@stop