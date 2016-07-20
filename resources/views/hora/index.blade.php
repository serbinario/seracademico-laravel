@extends('menu')

@section("css")
    <style type="text/css">
        table.dataTable tbody th, table.dataTable tbody td {
            padding: 2px 10px;
        }
    </style>
@stop


@section('content')

    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <div class="col-sm-6 col-md-9">
                <h4>
                    <i class="flaticon-passed-exam"></i>
                    Listar Horas
                </h4>
            </div>
            <div class="col-sm-6 col-md-3">
                <a href="{{ route('seracademico.hora.create')}}" class="btn-sm btn-primary pull-right">Nova Hora</a>
            </div>
        </div>
        <div class="ibox-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive no-padding">
                        <table id="hora-grid" class="display table table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Hora Inicial</th>
                                <th>Hora Final</th>
                                <th>Turno</th>
                                <th style="width: 5%;">Acão</th>
                            </tr>
                            </thead>

                            <tfoot>
                            <tr>
                                <th>Nome</th>
                                <th>Hora Inicial</th>
                                <th>Hora Final</th>
                                <th>Turno</th>
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
        var table = $('#hora-grid').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{!! route('seracademico.hora.grid') !!}",
            columns: [
                {data: 'nome', name: 'fac_horas.nome'},
                {data: 'hora_inicial', name: 'fac_horas.hora_inicial'},
                {data: 'hora_final', name: 'fac_horas.hora_final'},
                {data: 'turno', name: 'fac_turnos.nome'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    </script>
@stop