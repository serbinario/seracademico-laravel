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
                    <i class="flaticon-employment-test"></i>
                    Listar Vestibulandos
                </h4>
            </div>
            <div class="col-sm-6 col-md-3">
                <a href="{{ route('seracademico.vestibulando.create')}}" id="btnAddVestibulando" class="btn-sm btn-primary pull-right">Novo Vestibulando</a>
            </div>
        </div>
        <div class="ibox-content">
            <div class="row">
                <div class="col-md-12">
                    <form id="search-form" class="form-inline" role="form" method="GET">
                        <div class="form-group">
                            {!! Form::select('vestibularSearch', (['' => 'Todos os vestibulares'] + $loadFields['graduacao\\vestibular']->toArray()), null, array('class' => 'form-control')) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::select('pagoSearch', (['' => 'Todos os Vestibulandos', 0 => 'Não Págos', 1 => 'Págos'] ), null, array('class' => 'form-control')) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::select('formaAvaliacaoSearch', (['' => 'Todas as Formas', 0 => 'FICHA 19', 1 => 'ENEM'] ), null, array('class' => 'form-control')) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::text('globalSearch',  null, array('class' => 'form-control', 'placeholder' => 'Pesquisa...')) !!}
                        </div>

                        <div class="form-group">
                            <button class="btn-sm btn-primary" type="submit">Pesquisar</button>
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
                                <th>Situação</th>
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
                                <th>Situação</th>
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
    @include('vestibulando.modal_debitos')
    @include('vestibulando.modal_debitos_abertos_store')
    @include('vestibulando.modal_debitos_abertos_update')
@stop

@section('javascript')
    <script type="text/javascript" src="{{ asset('/js/vestibulando/modal_notas.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/vestibulando/modal_notas_update.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/vestibulando/modal_inclusao.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/vestibulando/modal_debitos.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/vestibulando/modal_debitos_abertos_store.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/vestibulando/modal_debitos_abertos_update.js') }}"></script>
    <script type="text/javascript">
        // função para criação da linha de detalhe
        function format ( d ) {
            return  '<div class="row">' +
                        '<div class="col-md-4">' +
                            '<h3>Forma de avaliação : ' + d.formaAvaliacao + '</h3>' +
                        '</div>' +
                    '</div>' +
                    '<div class="row">' +
                        '<div class="col-md-12">' +
                            '<table id="vestibulando-grid" class="display table table-bordered" cellspacing="0" width="100%">' +
                                '<thead>' +
                                    '<tr>' +
                                        '<th>Média Enem</th>' +
                                        '<th>Média Ficha 19</th>' +
                                    '</tr>' +
                                '</thead>' +
                                '<tbody>' +
                                    '<tr>' +
                                        '<td>' + d.media_enem+ '</td>' +
                                        '<td>' + d.media_ficha+ '</td>' +
                                    '</tr>' +
                                '</tbody>' +
                            '</table>' +
                        '</div>' +
                    '</div>'+
                    '<div class="row">' +
                        '<div class="col-md-12">' +
                            '<table id="vestibulando-grid" class="display table table-bordered" cellspacing="0" width="100%">' +
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
                            '</table>' +
                        '</div>' +
                    '</div>';
        }

        // criação da grid principal
        var table = $('#vestibulando-grid').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            bFilter: false,
            ajax: {
                url: "{!! route('seracademico.vestibulando.grid') !!}",
                data: function (d) {
                    d.vestibular = $('select[name=vestibularSearch] option:selected').val();
                    d.pago = $('select[name=pagoSearch] option:selected').val();
                    d.formaAvaliacao = $('select[name=formaAvaliacaoSearch] option:selected').val();
                    d.globalSearch = $('input[name=globalSearch]').val();
                }
            },
            columns: [
                {
                    "className":      'details-control',
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": ''
                },
                {data: 'nome', name: 'pessoas.nome'},
                {data: 'inscricao', name: 'fac_vestibulandos.inscricao'},
                {data: 'celular', name: 'pessoas.celular'},
                {data: 'cpf', name: 'pessoas.cpf'},
                {data: 'vestibular', name: 'fac_vestibulares.nome'},
                {data: 'transferencia', name: 'fac_alunos.id'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

        // Função do submit do search da grid principal
        $('#search-form').on('submit', function(e) {
            table.draw();
            e.preventDefault();
        });

        // array de detalhes da grid
        var detailRows = [];

        // evento para criação dos detalhes da grid
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

        // Evento para modal de transfência de vestibulando
        $(document).on('click', '#inclusao', function () {
            // Recuperando o id do vestibulando
            idVestibulando = table.row($(this).parent().parent().parent().parent().parent()).data().id;

            // Executando a tabela de notas
            runInclusao();
        });

        // Evento para modal de financeiro
        $(document).on('click', '#financeiro', function () {
            // Recuperando o id do vestibulando
            idVestibulando = table.row($(this).parent().parent().parent().parent().parent()).data().id;

            // Executando a tabela de notas
            runFinanceiro(idVestibulando);
        });

        /**
         * [RFV003-RN002] - Documento de Requisitos
         *
         * Evento disparado quando houver o click no botão de novo vestibulando
         * feito para validar se o período de inscriçõe do vestibular está válido
         * caso não esteja e o usuário seja um administrador ele ainda poderá prosseguir
         * com a requisição, caso contrário permanecerá na página.
         */
        $(document).on('click', '#btnAddVestibulando', function (event) {
            // parando a execução
            event.preventDefault();

            // Fazendo a requisição ajax
            jQuery.ajax({
                type: 'GET',
                url: '/index.php/seracademico/vestibular/getByValidDate',
                datatype: 'json'
            }).done(function (retorno) {
                // Verificando o retorno da requisição
                if(retorno.success) {
                    if(retorno.dados.length == 0) {
                        @if((Auth::check() && Auth::user()->is('admin')))
                            swal({
                                title: "Período de inscrições encerrado, deseja continuar ?",
                                text: "Não existe nenhum vestibular disponível!",
                                type: "warning",
                                showCancelButton: true,
                                confirmButtonColor: "#DD6B55",
                                confirmButtonText: "Sim, desejo continuar!",
                                closeOnConfirm: false
                            }, function() {
                                // redirecionamento
                                location.href = $("#btnAddVestibulando").prop('href');
                            });
                        @else
                            // usuário comum
                            swal("Período de inscrições encerrado!");
                        @endif
                    } else {
                        // redirecionamento
                        location.href = $("#btnAddVestibulando").prop('href');
                    }
                } else {
                    // Retorno caso não tenha currículo em uma turma ou algum erro
                    swal(retorno.msg, "Click no botão abaixo!", "error");
                    $('#modal-create-historico').modal('toggle');
                }
            });
        });
    </script>
@stop
