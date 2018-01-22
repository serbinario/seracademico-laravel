@extends('menu')

@section('css')
    <style type="text/css">
        .select2-close-mask{
            z-index: 2099;
        }

        .select2-dropdown{
            z-index: 3051;
        }

        td.details-control {
            background: url( "{{asset("imagemgrid/icone-produto-plus.png")}} ") no-repeat center center;
            cursor: pointer;
        }
        tr.details td.details-control {
            background: url( "{{asset("imagemgrid/icone-produto-minus.png")}}" ) no-repeat center center;
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
                    <i class="flaticon-exam-1"></i>
                    Listar Chamados
                </h4>
            </div>
            <div class="col-sm-6 col-md-3">
                <a href="{{ route('seracademico.helpdesk.chamados.create')}}"
                   class="btn-sm btn-primary pull-right">Novo Chamado</a>
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
                        <table id="chamado-grid" class="display table table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th style="width: 5%">Detalhe</th>
                                <th style="width: 10%">Data</th>
                                <th style="width: 30%">Título</th>
                                <th style="width: 10%">Situação</th>
                                <th style="width: 10%">Prioridade</th>
                                <th style="width: 5%;">Acão</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('helpdesk.chamados.modal_respostas')
    @include('helpdesk.chamados.modal_create_resposta')
@stop

@section('javascript')
    <script type="text/javascript" src="{{ asset('/js/helpdesk/chamados/modal_respostas.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/helpdesk/chamados/modal_create_resposta.js') }}"></script>
    <script type="text/javascript">
        function format(dados) {
            return '<div class="row">' +
                        '<div class="col-md-12">' +
                            '<p style="font-size: 12px;width: 80%;margin: 2% auto;text-align: justify">'
                                + dados.descricao +
                            '</p>' +
                        '</div>' +
                    '</div>';
        }

        var table = $('#chamado-grid').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('seracademico.helpdesk.chamados.grid') }}",
            columns: [
                {
                    "className":      'details-control',
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": ''
                },
                {data: 'data', name: 'hp_chamados.created_at'},
                {data: 'titulo', name: 'hp_chamados.titulo'},
                {data: 'label_status', name: 'hp_chamados.status'},
                {data: 'label_prioridade', name: 'hp_chamados.prioridade'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

        // array de detalhes da grid
        var detailRows = [];

        // evento para criação dos detalhes da grid
        $('#chamado-grid tbody').on( 'click', 'tr td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = table.row( tr );
            var idx = $.inArray( tr.attr('id'), detailRows );

            if ( row.child.isShown() ) {
                tr.removeClass( 'details' );
                row.child.hide();

                // Remove from the 'open' array
                detailRows.splice( idx, 1 );
            }
            else {
                tr.addClass( 'details' );
                row.child( format( row.data() ) ).show();

                // Add to the 'open' array
                if ( idx === -1 ) {
                    detailRows.push( tr.attr('id') );
                }
            }
        } );

        // On each draw, loop over the `detailRows` array and show any child rows
        table.on( 'draw', function () {
            $.each( detailRows, function ( i, id ) {
                $('#'+id+' td.details-control').trigger( 'click' );
            } );
        } );

    </script>
@stop