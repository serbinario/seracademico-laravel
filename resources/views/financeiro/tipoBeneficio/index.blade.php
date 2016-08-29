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
                    <i class="material-icons">account_balance_wallet</i>
                    Listar Tipos de Beneficios
                </h4>
            </div>
            <div class="col-sm-6 col-md-3">
                <a href="{{ route('seracademico.financeiro.tipoBeneficio.create')}}" class="btn-sm btn-primary pull-right">Novo Tipo de Beneficio</a>
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
                        <table id="tipos-beneficios-grid" class="display table table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>

                                <th style="width: 10%;">Código</th>
                                <th style="width: 50%;">Descrição</th>
                                <th>Valor</th>
                                <th>Válido</th>
                                <th>Até</th>
                                <th>Inicio</th>
                                <th>Final</th>
                                <th style="width: 5%;">Acao</th>

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
        var table = $('#tipos-beneficios-grid').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{!! route('seracademico.financeiro.tipoBeneficio.grid') !!}",
            columns: [
                {data: 'codigo',        name: 'fin_tipos_beneficios.codigo'},        //codigo
                {data: 'nome',          name: 'fin_tipos_beneficios.nome'},          //nome
                {data: 'valor',         name: 'fin_tipos_beneficios.valor'},         //endereco
                {data: 'validoInicio',  name: 'fin_tipos_beneficios.valido_inicio'}, //rg
                {data: 'validoFim',     name: 'fin_tipos_beneficios.valido_fim'},    //data nasc
                {data: 'dataInicio',    name: 'fin_tipos_beneficios.data_inicio'},   //cpf
                {data: 'dataFim',       name: 'fin_tipos_beneficios.data_fim'},      //endereco

                {data: 'action',        name: 'action', orderable: false, searchable: false}
            ]
        });
    </script>
@stop