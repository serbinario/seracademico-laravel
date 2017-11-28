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
                <h4><i class="material-icons">library_books</i> Listar Agendamentos Segunda Chamada</h4>
            </div>
            <div class="col-sm-6 col-md-3">
                <a href="{{ route('seracademico.tecnico.agendamento.create')}}" class="btn-sm btn-primary pull-right">Novo Agendamento</a>
            </div>
        </div>

        <div class="ibox-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive no-padding">
                        <table id="agendamento-grid" class="display table table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Data</th>
                                <th>Hora inicial</th>
                                <th>Hora final</th>
                                <th>Hora de entrada</th>
                                <th>Tipo de prova</th>
                                <th>Acão</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Data</th>
                                <th>Hora inicial</th>
                                <th>Hora final</th>
                                <th>Hora de entrada</th>
                                <th>Tipo de prova</th>
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
        /* Datatable da grid principal */
        var table = $('#agendamento-grid').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: "{!! route('seracademico.tecnico.agendamento.grid') !!}",
            columns: [
                {data: 'data', name: 'pos_agendamentos_segunda_chamada.data'},
                {data: 'hora_inicio', name: 'pos_agendamentos_segunda_chamada.hora_inicio'},
                {data: 'hora_final', name: 'pos_agendamentos_segunda_chamada.hora_final'},
                {data: 'hora_entrada', name: 'pos_agendamentos_segunda_chamada.hora_entrada'},
                {data: 'tipo', name: 'pos_agendamentos_tipos_provas.nome'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    </script>
@stop