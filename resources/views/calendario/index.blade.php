@extends('menu')

@section('css')
    <style type="text/css">

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
                <h4>
                    <i class="material-icons">collections_bookmark</i>
                    Listar Calendários
                </h4>
            </div>
            <div class="col-sm-6 col-md-3">
                <a href="{{ route('seracademico.calendarioAnual.create')}}" class="btn-sm btn-primary pull-right">Novo Calendário</a>
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
                        <table id="calendario-grid" class="display table table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Nome</th>
                                <th style="width: 2%;">Ano</th>
                                <th style="width: 2%;">Acão</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Nome</th>
                                <th style="width: 2%;">Ano</th>
                                <th style="width: 2%;">Acão</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>        
    </div>
    @include('calendario.modal_adicionar_periodos_avaliacao')
    @include('calendario.modal_adicionar_eventos')
@stop

@section('javascript')
    <script type="text/javascript" src="{{ asset('/js/calendario/selectModalAddEvento.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/calendario/modal_controller_calendario.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/calendario/modal_adicionar_periodos.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/calendario/modal_adicionar_eventos.js') }}"></script>
    <script type="text/javascript">
        var table = $('#calendario-grid').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: "{!! route('seracademico.calendarioAnual.grid') !!}",
            columns: [
                {data: 'nome', name: 'fac_calendarios_escolares.nome'},
                {data: 'ano', name: 'fac_calendarios_escolares.ano'},
                /*{data: 'data_inicial', name: 'fac_calendarios_escolares.data_inicial'},
                {data: 'data_final', name: 'fac_calendarios_escolares.data_final'},
                {data: 'dias_letivos', name: 'fac_calendarios_escolares.dias_letivos'},
                {data: 'semanas_letivas', name: 'fac_calendarios_escolares.semanas_letivas'},
                {data: 'status_id', name: 'fac_calendarios_escolares.status_id'},
                {data: 'data_resultado_final', name: 'fac_calendarios_escolares.data_resultado_final'},
                {data: 'duracao', name: 'fac_calendarios_duracao.nome'},*/
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    </script>
@stop