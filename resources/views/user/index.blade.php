@extends('menu')

@section("css")

    <style type="text/css">
        td.details-control {
            background: url({{asset("imagemgrid/icone-produto-plus.png")}}) no-repeat center center;
            cursor: pointer;
        }

        tr.details td.details-control {
            background: url({{asset("imagemgrid/icone-produto-minus.png")}}) no-repeat center center;
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
                <h4><i class="material-icons">account_circle</i> Listar Usuários</h4>
            </div>
            <div class="col-sm-6 col-md-3">
                <a href="{{ route('seracademico.user.create')}}" class="btn-sm btn-primary pull-right">Novo Usuário</a>
            </div>
        </div>
        <div class="ibox-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive no-padding">
                        <table id="user-grid" class="display table table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Polo</th>
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
        var table = $('#user-grid').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{!! route('seracademico.user.grid') !!}",
            columns: [
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'sede', name: 'sede'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    </script>
@stop