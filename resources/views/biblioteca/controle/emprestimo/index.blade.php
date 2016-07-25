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
                <h4><i class="material-icons">receipt</i> Realizar emprestimo</h4>
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
                                <th>Tombo</th>
                                <th>Situação</th>
                                <th>Emprestimo</th>
                                <th>Acão</th>
                            </tr>
                            </thead>

                            <tfoot>
                            <tr>
                                <th>Acervo - Título</th>
                                <th>Cutter</th>
                                <th>Subtítulo</th>
                                <th>Edição</th>
                                <th>Tombo</th>
                                <th>Situação</th>
                                <th>Emprestimo</th>
                                <th style="width: 5%;">Acão</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                @if(count($emprestimosPendentes) > 0)
                <div class="col-md-6">
                    <div class="table-responsive no-padding">
                        <table id="emprestimos-pendente"  class="display table table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th colspan="2">Empréstimos pendentes</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($emprestimosPendentes as $emprestimo)
                                <tr>
                                    <td>{{$emprestimo->pessoa->nome}}</td>
                                    <td style="width: 10%;"><a href="#" data="{{$emprestimo->pessoa->id}}" id="continuar">Continuar</a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
                {!! Form::open(['route'=>'seracademico.biblioteca.confirmarEmprestimo', 'method' => "POST", 'id' => 'form', 'target' => '__blank' ]) !!}
                    <div class="col-md-12">
                        <div class="form-group col-md-5">
                            {!! Form::select('pessoas_id', (["" => "Selecione uma pessoa"] + $loadFields['pessoa']->toArray()), null, array('class' => 'form-control', 'id' => 'pessoa')) !!}
                        </div>
                        <div class="form-group col-md-2">
                            {!! Form::text('data_devolucao', null , array('class' => 'form-control data', 'placeholder'=> 'Data de entrega', 'id' => 'data', 'readonly' => 'readonly')) !!}
                            <input type="hidden" name="tipo_emprestimo" id="id_emprestimo">
                        </div>
                        <input type="submit" id="conf_emprestimo" class="btn btn-success btn-sm" value="Confirmar emprestimo">
                    </div>
                    <div class="col-md-12">
                        <div class="table-responsive no-padding">
                            <table id="emprestimos"  class="display table table-bordered" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>Acervo - Título</th>
                                    <th>Cutter</th>
                                    <th>Subtítulo</th>
                                    <th>Edição</th>
                                    <th>Tombo</th>
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
@stop

@section('javascript')
    <script type="text/javascript">
        select2();
        var id_emp1 = "";
        var id_emp2 = "";
        var table = $('#sala-grid').DataTable({
            processing: true,
            serverSide: true,
            iDisplayLength: 5,
            bLengthChange: false,
            ajax: "{!! route('seracademico.biblioteca.gridEmprestimo') !!}",
            columns: [
                {data: 'titulo', name: 'bib_arcevos.titulo'},
                {data: 'cutter', name: 'bib_arcevos.cutter'},
                {data: 'subtitulo', name: 'bib_arcevos.subtitulo'},
                {data: 'edicao', name: 'bib_exemplares.edicao'},
                {data: 'tombo', name: 'bib_exemplares.codigo'},
                {data: 'nome_sit', name: 'bib_emprestimo.nome'},
                {data: 'nome_emp', name: 'bib_emprestimo.nome'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

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
                bootbox.alert("Vocẽ selecionou exemplares tanto de consulta quanto para empréstimo, decida apenas entre um dos dois tipo!");
                return false;
            }

            dadosAjax = {
                'tipo_emprestimo': data['id_emp'],
                'id': data['id'],
                'pessoas_id': $('#pessoa').val(),
                'pessoas_nome': $('select[name=pessoas_id] option:selected').text()
            };

            if (!$('#pessoa').val()) {
                bootbox.alert("Você deve selecionar um aluno!");
                return false;
            } else {

                jQuery.ajax({
                    type: 'POST',
                    url: "{!! route('seracademico.biblioteca.dataDevolucaoEmprestimo') !!}",
                    data: dadosAjax,
                    datatype: 'json'
                }).done(function (retorno) {

                    if(retorno[2] == false) {
                        bootbox.alert(retorno[1]);
                        return false;
                    }

                    $('#emprestimos tbody tr').remove();
                    for(var i = 0; i < retorno[3].length; i++){
                        html += "<tr>";
                        html += "<td>" + retorno[3][i]['acervo']['titulo'] + "</td>";
                        html += "<td>" + retorno[3][i]['acervo']['cutter'] + "</td>";
                        html += "<td>" + retorno[3][i]['acervo']['subtitulo'] + "</td>";
                        html += "<td>" + retorno[3][i]['edicao'] + "</td>";
                        html += "<td>" + retorno[3][i]['codigo'] + "</td>";
                        html += "<td>" +
                                "<button type='button' data='"+retorno[3][i]['pivot']['emprestimo_id']+"' data2='"+retorno[3][i]['pivot']['id']+"' class='btn-floating remove' onclick='RemoveTableRow(this)'  title='Deletar'><i class='fa fa-times'></i></button></li></td>" +
                                "<input type='hidden' name='id_emp' value='"+retorno[3][i]['pivot']['emprestimo_id']+"'>";
                        html += "</tr>";
                    }

                    $('#emprestimos tbody').append(html);
                    $('#data').val(retorno[0]);
                });
            }
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

        $(document).ready(function(){

            $('#continuar').click(function(event){
                event.preventDefault();

                var idPessoa = $('#continuar').attr('data');

                jQuery.ajax({
                    type: 'POST',
                    url: "{!! route('seracademico.biblioteca.findWhereEmprestimo') !!}",
                    datatype: 'json',
                    data: {'id_pessoa' : idPessoa},
                }).done(function (retorno) {

                    var html= "";
                    if(retorno.length > 0 ) {
                        var emprestimos = retorno[0]['emprestimo_exemplar'];
                        var pessoaId = retorno[0]['pessoa']['id'];
                        var pessoaNome = retorno[0]['pessoa']['nome'];

                        $('#emprestimos tbody tr').remove();
                        for (var i = 0; i < emprestimos.length; i++) {
                            html += "<tr>";
                            html += "<td>" + emprestimos[i]['acervo']['titulo'] + "</td>";
                            html += "<td>" + emprestimos[i]['acervo']['cutter'] + "</td>";
                            html += "<td>" + emprestimos[i]['acervo']['subtitulo'] + "</td>";
                            html += "<td>" + emprestimos[i]['edicao'] + "</td>";
                            html += "<td>" + emprestimos[i]['codigo'] + "</td>";
                            html += "<td>" +
                                    "<button type='button' data='"+emprestimos[i]['pivot']['emprestimo_id']+"' data2='"+emprestimos[i]['pivot']['id']+"' class='btn-floating remove' onclick='RemoveTableRow(this)'  title='Deletar'><i class='fa fa-times'></i></button></li></td>" +
                                    "<input type='hidden' name='id_emp' value='"+emprestimos[i]['pivot']['emprestimo_id']+"'>";
                            html += "</tr>";
                        }

                        var option = "<option selected value='"+pessoaId+"'>"+pessoaNome+"</option>";

                        $('#pessoa option').remove();
                        $('#pessoa').append(option);
                        select2();

                        $('#emprestimos tbody').append(html);
                        $('#data').val("");
                    }

                });
            });

        });

        function select2(){
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

        $(document).on('submit', '#form', function (event) {
            $(document).ready(function(){
                if($('#emprestimos tbody tr').length <= 0){
                    bootbox.alert('você deve selecionar pelo menos um exemplar');
                    event.preventDefault();
                } else {
                    setTimeout(explode, 1000);
                }
            });

            function explode(){
                location.reload();
            }
        });

        $(document).on('click', 'button.remove', function (event) {
            event.preventDefault();
            var id = $(this).attr('data');
            var id2 = $(this).attr('data2');
            jQuery.ajax({
                type: 'get',
                url: "deleteEmprestimo/"+id+"/"+id2,
                datatype: 'json'
            }).done(function (retorno) {

            });
        });
    </script>
@stop