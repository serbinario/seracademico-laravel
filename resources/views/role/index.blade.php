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
                <h4><i class="material-icons">account_box</i> Lista de Perfís</h4>
            </div>
            <div class="col-sm-6 col-md-3">
                <a href="{{ route('seracademico.role.create')}}" class="btn-sm btn-primary pull-right">Novo Perfil</a>
            </div>
        </div>

        <div class="ibox-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive no-padding">
                        <table id="role-grid" class="display table table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Descrição</th>
                                <th width="5%">Acão</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('javascript')
    <script type="text/javascript">
        var table = $('#role-grid').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{!! route('seracademico.role.grid') !!}",
            columns: [
                {data: 'name', name: 'name'},
                {data: 'description', name: 'description'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    </script>
@stop