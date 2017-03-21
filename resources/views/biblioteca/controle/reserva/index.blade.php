@extends('menu')

@section('css')
    <style>
        table.dataTable tbody th, table.dataTable tbody td {
            padding: 2px 10px;
        }
    </style>
@endsection
@section('content')

    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <div class="col-sm-6 col-md-9">
                <h4><i class="material-icons">receipt</i> Realizar reserva</h4>
            </div>
            <div class="col-sm-6 col-md-3">
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
                                <th>Acervo - Título</th>
                                <th>Cutter</th>
                                <th>Subtítulo</th>
                                <th>Edição</th>
                                <th>Data de previsão</th>
                                <th>Quantidade de reservas</th>
                                <th>Acão</th>
                            </tr>
                            </thead>

                            <tfoot>
                            <tr>
                                <th>Acervo - Título</th>
                                <th>Cutter</th>
                                <th>Subtítulo</th>
                                <th>Edição</th>
                                <th>Data de previsão</th>
                                <th>Quantidade de reservas</th>
                                <th style="width: 10%;">Acão</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                @if(count($reservasPendentes) > 0)
                    <div class="col-md-6">
                        <div class="table-responsive no-padding">
                            <table id="emprestimos-pendente"  class="display table table-bordered" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th colspan="2">Reservas pendentes</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($reservasPendentes as $reserva)
                                    <tr>
                                        <td>{{$reserva->pessoa->nome}}</td>
                                        <td style="width: 10%;"><a href="#" data="{{$reserva->pessoa->id}}" class="continuar">Continuar</a></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
                {!! Form::open(['route'=>'seracademico.biblioteca.confirmarReserva', 'method' => "POST", 'id' => 'form' ]) !!}
                    <div class="col-md-12">
                        <div class="form-group col-md-2">
                            <select class="form-control" id="tipo_pessoa">
                                <option value="">Tipo pessoa</option>
                                <option value="1">Graduação</option>
                                <option value="2">Pós-graduação</option>
                                <option value="3">Mestrado</option>
                                <option value="4">Professor</option>
                            </select>
                        </div>
                        <div class="form-group col-md-5">
                            {!! Form::select('pessoas_id', array(), null, array('class' => 'form-control', 'id' => 'pessoa')) !!}
                            <input type="hidden" name="edicao" id="edicao">
                            <input type="hidden" name="tipo_emprestimo" id="id_emprestimo">
                        </div>
                        <div class="form-group col-md-3" style="margin-top: -8px">
                            <div class="checkbox checkbox-primary">
                                <input type="checkbox" class="form-control" id="emprestimoEspecial">
                                {!! Form::label('emprestimoEspecial', 'Para empréstimo especial?', false) !!}
                            </div>
                        </div>
                        <input type="submit" style="margin-left: -50px" id="conf_reserva" class="btn btn-success btn-sm" value="Confirmar reserva">
                    </div>
                    <div class="col-md-12">
                        <div class="table-responsive no-padding">
                            <table id="emprestimos" class="display table table-bordered" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>Acervo - Título</th>
                                    <th>Cutter</th>
                                    <th>Subtítulo</th>
                                    <th>Edição</th>
                                    <th>Ação</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    @include('biblioteca.controle.reserva.modal_fila_de_reserva')
@stop

@section('javascript')
    <script type="text/javascript">
        $("#pessoa").select2();
        var id_emp1 = "";
        var id_emp2 = "";
        var table = $('#sala-grid').DataTable({
            processing: true,
            serverSide: true,
            iDisplayLength: 5,
            bLengthChange: false,
            ajax: "{!! route('seracademico.biblioteca.gridReserva') !!}",
            columns: [
                {data: 'titulo', name: 'bib_arcevos.titulo'},
                {data: 'cutter', name: 'bib_arcevos.cutter'},
                {data: 'subtitulo', name: 'bib_arcevos.subtitulo'},
                {data: 'edicao', name: 'bib_exemplares.edicao'},
                {data: 'previsao', name: 'previsao', orderable: false, searchable: false},
                {data: 'qtdReservas', name: 'qtdReservas', orderable: false, searchable: false},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

        // Adicionar um acervos para reserva
        $('#sala-grid tbody').on('click', '.add', function (event) {
            event.preventDefault();
            if ($(this).parent().parent().hasClass('selected')) {
                $(this).parent().parent().removeClass('selected');
                return false;
            }
            else {
                table.$('tr.selected').removeClass('selected');
                $(this).parent().parent().addClass('selected');
            }

            var data = table.rows('.selected').data()[0];
            var html = "";
            var edicao = "";

            if(data['edicao'] == "") {
                edicao = ""
            } else {
                edicao = data['edicao'];
            }

            if($('#emprestimos tbody tr').length <= 0) {
                id_emp1 = "";
                id_emp2 = "";
                $('#id_emprestimo').val("");
            }

            if(data['id_emp'] == '1'){ id_emp1 = data['id_emp']; $('#id_emprestimo').val(id_emp1);}
            if(data['id_emp'] == '2'){ id_emp2 = data['id_emp']; $('#id_emprestimo').val(id_emp2);}

            if(id_emp1 && id_emp2) {
                if(data['id_emp'] == '1'){ id_emp1 = ""; $('#id_emprestimo').val(id_emp2)}
                if(data['id_emp'] == '2'){ id_emp2 = ""; $('#id_emprestimo').val(id_emp1)}
                bootbox.alert("Vocẽ selecionou acervos tanto de consulta quanto para empréstimo, decida apenas entre um dos dois tipo!");
                return false;
            }

            dadosAjax = {
                'tipo_emprestimo': data['id_emp'],
                'pessoas_id': $('#pessoa').val(),
                'id_acervo': data['id_acervo'],
                'edicao': edicao,
                'tipo_pessoa': $('#tipo_pessoa').val(),
                'emprestimo_especial': $('#emprestimoEspecial').is(":checked") ? '1' : '0'
            };

            if (!$('#pessoa').val()) {
                bootbox.alert("Você deve selecionar um aluno!");
                return false;
            } else {

                jQuery.ajax({
                    type: 'POST',
                    url: "{!! route('seracademico.biblioteca.storeReserva') !!}",
                    data: dadosAjax,
                    datatype: 'json'
                }).done(function (retorno) {

                    if(retorno[2] == false) {
                        bootbox.alert(retorno[1]);
                        return false;
                    }

                    $('#emprestimos tbody tr').remove();
                    for(var i = 0; i < retorno[2].length; i++){

                        html += "<tr>";
                        html += "<td>" + retorno[2][i]['titulo'] + "</td>";
                        html += "<td>" + retorno[2][i]['cutter'] + "</td>";
                        html += "<td>" + retorno[2][i]['subtitulo'] + "</td>";
                        html += "<td>" + retorno[2][i]['pivot']['edicao'] + "</td>";
                        html += "<td>" +
                                "<button type='button' data='"+retorno[2][i]['pivot']['reserva_id']+"' data2='"+retorno[2][i]['pivot']['id']+"' class='btn-floating remove' onclick='RemoveTableRow(this)'  title='Deletar'><i class='fa fa-times'></i></button></li></td>" +
                                "<input type='hidden' name='id_emp' value='"+retorno[2][i]['pivot']['reserva_id']+"'>" +
                                "<input type='hidden' name='edicao' value='" + retorno[2][i]['titulo'] + "'>";
                        html += "</tr>";
                    }

                    $('#emprestimos tbody').append(html);

                });
            }

        });

        // Exibir pessoas na fila de reservas
        $('#sala-grid tbody').on('click', '.fila-reserva', function (event) {
            event.preventDefault();
            if ($(this).parent().parent().hasClass('selected')) {
                $(this).parent().parent().removeClass('selected');
                return false;
            }
            else {
                table.$('tr.selected').removeClass('selected');
                $(this).parent().parent().addClass('selected');
            }

            var data = table.rows('.selected').data()[0];
            var acervo = data['id_acervo'];

            jQuery.ajax({
                type: 'POST',
                url: "{!! route('seracademico.biblioteca.listaPessoasReservas') !!}",
                data: {'acervo' : acervo},
                datatype: 'json'
            }).done(function (retorno) {

                var html = "";

                for (var i = 0; i < retorno.length; i++) {
                    html += "<tr>";
                    html += "<td>"+retorno[i]['nome']+"</td>";
                    html += "</tr>";
                }

                $('#table-fila tbody tr').remove();
                $('#table-fila tbody').append(html);
                $("#modal-fila-reserva").modal({show:true});

            });
        });


        //Excluir tr da tabela
        (function ($) {
            RemoveTableRow = function (handler) {
                var tr = $(handler).closest('tr');

                tr.fadeOut(400, function () {
                    tr.remove();
                });
                return false;
            };
        })(jQuery);

        // Carregar as reservas pendentes
        $(document).ready(function () {

            $('.continuar').click(function (event) {
                event.preventDefault();

                var idPessoa = $(this).attr('data');

                jQuery.ajax({
                    type: 'POST',
                    url: "{!! route('seracademico.biblioteca.findWhereReserva') !!}",
                    datatype: 'json',
                    data: {'id_pessoa': idPessoa}
                }).done(function (retorno) {

                    var html = "";
                    if (retorno.length > 0) {
                        var reservas = retorno[0]['reserva_exemplar'];
                        var pessoaId = retorno[0]['pessoa']['id'];
                        var pessoaNome = retorno[0]['pessoa']['nome'];

                        $('#emprestimos tbody tr').remove();
                        for (var i = 0; i < reservas.length; i++) {

                            html += "<tr>";
                            html += "<td>" + reservas[i]['titulo'] + "</td>";
                            html += "<td>" + reservas[i]['cutter'] + "</td>";
                            html += "<td>" + reservas[i]['subtitulo'] + "</td>";
                            html += "<td>" + reservas[i]['pivot']['edicao'] + "</td>";
                            html += "<td>" +
                                    "<button type='button' data='" + reservas[i]['pivot']['reserva_id'] + "' data2='" + reservas[i]['pivot']['id'] + "' class='btn-floating remove' onclick='RemoveTableRow(this)'  title='Deletar'><i class='fa fa-times'></i></button></li></td>" +
                                    "<input type='hidden' name='id_emp' value='" + reservas[i]['pivot']['reserva_id'] + "'>" +
                                    "<input type='hidden' name='edicao' value='" + reservas[i]['titulo'] + "'>";
                            html += "</tr>";
                        }

                        var option = "<option selected value='" + pessoaId + "'>" + pessoaNome + "</option>";

                        $('#pessoa option').remove();
                        $('#pessoa').append(option);
                        select2(retorno[0]['tipo_pessoa']);

                        $('#emprestimos tbody').append(html);

                        if(retorno[0]['emprestimo_especial'] == '1') {
                            $('#emprestimoEspecial').prop('checked', true);
                        } else {
                            $('#emprestimoEspecial').prop('checked', false);
                        }

                        $( "#tipo_pessoa option" ).each(function() {
                            if($(this).val() == retorno[0]['tipo_pessoa']) {
                                $(this).prop('selected', true);
                            }
                        });
                    }

                });
            });
        });


        // Função para chamar o select dois
        function select2(tipo){
            //consulta via select2 responsável
            $("#pessoa").select2({
                placeholder: 'Selecione uma pessoa',
                minimumInputLength: 1,
                width: 400,
                ajax: {
                    type: 'POST',
                    url: "{{ route('seracademico.util.queryByselect2Pessoa')  }}",
                    dataType: 'json',
                    delay: 250,
                    crossDomain: true,
                    data: function (params) {
                        return {
                            'search':     params.term, // search term
                            'tableName':  'pessoas',
                            'fieldName':  'nome',
                            'parametro':  tipo,
                            'page':       params.page
                        };
                    },
                    headers: {
                        'X-CSRF-TOKEN' : '{{  csrf_token() }}'
                    },
                    processResults: function (data, params) {

                        // parse the results into the format expected by Select2
                        // since we are using custom formatting functions we do not need to
                        // alter the remote JSON data, except to indicate that infinite
                        // scrolling can be used
                        params.page = params.page || 1;

                        return {
                            results: data.data,
                            pagination: {
                                more: (params.page * 30) < data.total_count
                            }
                        };
                    }
                }
            });
        }

        // Tratar os tipos de aluoos a seren selecionaods
        $(document).on('change', '#tipo_pessoa', function (event) {

            var tipo = $(this).val();

            if(tipo) {

                if(tipo == 2 || tipo == 3) {
                    $('#emprestimoEspecial').prop('checked', true);
                } else {
                    $('#emprestimoEspecial').prop('checked', false);
                }
                select2(tipo);
            }

        });

        // Confirmação do empréstimo
        $(document).on('submit', '#form', function (event) {
            $(document).ready(function(){

                if(($("#tipo_pessoa").val() == '2' || $("#tipo_pessoa").val() == '3') && !$("#emprestimoEspecial").prop( "checked")) {
                    bootbox.alert('Esse empréstimos deve ser do tipo especial');
                    event.preventDefault();
                } else if($('#emprestimos tbody tr').length <= 0){
                    bootbox.alert('você deve selecionar pelo menos um livro');
                    event.preventDefault();
                } else {
                    setTimeout(explode, 1000);
                    $( "#tipo_pessoa option" ).each(function() {
                        $(this).prop('selected', false);
                    });
                }

            });

            function explode(){
                location.reload();
            }

        });

        // Remover um acervo da reserva
        $(document).on('click', 'button.remove', function (event) {
            event.preventDefault();
            var id = $(this).attr('data');
            var id2 = $(this).attr('data2');
            jQuery.ajax({
                type: 'get',
                url: "deleteReserva/"+id+"/"+id2,
                datatype: 'json'
            }).done(function (retorno) {

            });
        });


    </script>
@stop