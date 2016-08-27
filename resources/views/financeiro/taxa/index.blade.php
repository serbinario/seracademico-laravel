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
                    <i class="flaticon-currency-rates"></i>
                    Listar Taxas
                </h4>
            </div>
            <div class="col-sm-6 col-md-3">
                <a href="{{ route('seracademico.financeiro.taxa.create')}}" class="btn-sm btn-primary pull-right">Nova Taxa</a>
            </div>
        </div>

        <div class="ibox-content">

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

            <div class="row">
                <div class="col-md-12">

                    <div class="table-responsive no-padding">
                        <table id="sala-grid" class="display table table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th style="width: 5%;">Código</th>
                                <th>Nome</th>
                                <th>Valor</th>
                                <th>Dia Vencimento</th>
                                <th >Acão</th>
                            </tr>
                            </thead>

                            <tfoot>
                            <tr>
                                <th style="width: 5%;">Código</th>
                                <th>Nome</th>
                                <th style="width: 5%;">Valor</th>
                                <th style="width: 5%;">Dia Vencimento</th>
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
        var table = $('#sala-grid').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: "{!! route('seracademico.financeiro.taxa.grid') !!}",
            columns: [
                {data: 'codigo', name: 'codigo'},
                {data: 'nome', name: 'nome'},
                {data: 'valor', name: 'valor'},
                {data: 'dia_vencimento', name: 'dia_vencimento'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    </script>
@stop