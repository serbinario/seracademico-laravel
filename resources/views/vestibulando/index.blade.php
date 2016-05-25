@extends('menu')

@section("css")
    <link rel="stylesheet" href="{{ asset('/js/posgraduacao/turma/css/modal_calendario.css') }}">
    <style type="text/css">
        table.dataTable tbody th, table.dataTable tbody td {
            padding: 2px 10px;
        }
        td.details-control {
            background: url({{asset("imagemgrid/icone-produto-plus.png")}}) no-repeat center center;
            cursor: pointer;
        }
        tr.details td.details-control {
            background: url({{asset("imagemgrid/icone-produto-minus.png")}}) no-repeat center center;
        }
    </style>
@stop

@section('content')

    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <div class="col-sm-6 col-md-9">
                <h4>
                    <i class="fa fa-users"></i>
                    Listar Vestibulandos
                </h4>
            </div>
            <div class="col-sm-6 col-md-3">
                <a href="{{ route('seracademico.vestibulando.create')}}" class="btn-sm btn-primary pull-right">Novo Vestibulando</a>
            </div>
        </div>
        <div class="ibox-content">
            <div class="row">
                <div class="col-md-6">
                    <form id="search-form" class="form-inline" role="form" method="GET">
                        <div class="form-group">
                            {!! Form::select('semestreSearch', (['' => 'Todos os semestres'] + $loadFields['graduacao\\semestre']->toArray()), null, array('class' => 'form-control')) !!}
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">Pesquisar</button>
                        </div>
                    </form>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive no-padding">
                        <table id="vestibulando-grid" class="display table table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Detalhe</th>
                                <th>Nome</th>
                                <th>Inscrição</th>
                                <th>Telefones</th>
                                <th>CPF</th>
                                <th>Vestibular</th>
                                <th>Acão</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Detalhe</th>
                                <th>Nome</th>
                                <th>Inscrição</th>
                                <th>Telefones</th>
                                <th>CPF</th>
                                <th>Vestibular</th>
                                <th style="width: 5%">Acão</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('vestibulando.modal_notas')
    @include('vestibulando.modal_notas_update')
    @include('vestibulando.modal_inclusao')
@stop

@section('javascript')
    <script type="text/javascript" src="{{ asset('/js/vestibulando/modal_notas.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/vestibulando/modal_notas_update.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/vestibulando/modal_inclusao.js') }}"></script>
    <script type="text/javascript">
        // função para criação da linha de detalhe
        function format ( d ) {
            return '<table id="vestibulando-grid" class="display table table-bordered" cellspacing="0" width="100%">' +
                        '<thead>' +
                            '<tr>' +
                                '<th style="width: 5%">Opção</th>' +
                                '<th>Curso</th>' +
                                '<th style="width: 20%">Turno</th>' +
                            '</tr>' +
                        '</thead>' +
                        '<tbody>' +
                            '<tr>' +
                                '<td style="width: 5%">1º</td>' +
                                '<td>' + (d.nomeCurso1 ? d.nomeCurso1 : 'Não Selecionado') + '</td>' +
                                '<td style="width: 20%">' + (d.nomeTurno1 ? d.nomeTurno1 : 'Não Selecionado') + '</td>' +
                            '</tr>' +
                            '<tr>' +
                                '<td style="width: 5%">2º</td>' +
                                '<td>' + (d.nomeCurso2 ? d.nomeCurso2 : 'Não Selecionado') + '</td>' +
                                '<td style="width: 20%">' + (d.nomeTurno2 ? d.nomeTurno2 : 'Não Selecionado') + '</td>' +
                            '</tr>' +
                            '<tr>' +
                                '<td style="width: 5%">3º</td>' +
                                '<td>' + (d.nomeCurso3 ? d.nomeCurso3 : 'Não Selecionado') + '</td>' +
                                '<td style="width: 20%">' + (d.nomeTurno3 ? d.nomeTurno3 : 'Não Selecionado') + '</td>' +
                            '</tr>' +
                        '</tbody>' +
                    '</table>';
        }

        var table = $('#vestibulando-grid').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: "{!! route('seracademico.vestibulando.grid') !!}",
                data: function (d) {
                    d.semestre = $('select[name=semestreSearch] option:selected').val();
                }
            },
            columns: [
                {
                    "className":      'details-control',
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": ''
                },
                {data: 'nome', name: 'fac_alunos.nome'},
                {data: 'inscricao', name: 'fac_alunos.inscricao'},
                {data: 'celular', name: 'fac_alunos.celular'},
                {data: 'cpf', name: 'fac_alunos.cpf'},
                {data: 'vestibular', name: 'vestibulares.nome'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

        $('#search-form').on('submit', function(e) {
            table.draw();
            e.preventDefault();
        });

        var detailRows = [];

        $('#vestibulando-grid tbody').on( 'click', 'tr td.details-control', function () {
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

        // Id do vestibulando
        var idVestibulando;

        // Evento para modal de notas
        $(document).on('click', '#notas', function () {
            // Recuperando o id do vestibulando
            idVestibulando = table.row($(this).parent().parent().parent().parent().parent()).data().id;

            // Executando a tabela de notas
            runTableNotas(idVestibulando);
        });

        // Evento para modal de notas
        $(document).on('click', '#inclusao', function () {
            // Recuperando o id do vestibulando
            idVestibulando = table.row($(this).parent().parent().parent().parent().parent()).data().id;

            // Executando a tabela de notas
            runInclusao();
        });
    </script>

    <script id="details-template" type="text/x-handlebars-template">
        <table class="table">
            <tr>
                <td>Full name:</td>
                <td>dsa</td>
            </tr>
            <tr>
                <td>Email:</td>
                <td>dsa</td>
            </tr>
            <tr>
                <td>Extra info:</td>
                <td>And any further details here (images etc)...</td>
            </tr>
        </table>
    </script>
@stop
