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
                {!! Form::open(['route'=>'seracademico.biblioteca.storeEmprestimo', 'method' => "POST", 'id' => 'form', 'target' => '__blank' ]) !!}
                    <div class="col-md-12">
                        <div class="form-group col-md-5">
                            {!! Form::select('pessoas_id', (["" => "Selecione uma pessoa"] + $loadFields['pessoa']->toArray()), null, array('class' => 'form-control', 'id' => 'pessoa')) !!}
                        </div>
                        <div class="form-group col-md-2">
                            {!! Form::text('data_devolucao', null , array('class' => 'form-control data', 'placeholder'=> 'Data de entrega', 'id' => 'data', 'readonly' => 'readonly')) !!}
                            <input type="hidden" name="tipo_emprestimo" id="id_emprestimo">
                        </div>
                        <input type="submit" class="btn btn-success btn-sm" value="Confirmar emprestimo">
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
                                    <th>Tombo</th>
                                    <th>Situação</th>
                                    <th>Emprestimo</th>
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
            }
            else {
                table.$('tr.selected').removeClass('selected');
                $(this).parent().parent().addClass('selected');
            }

            var data = table.rows('.selected').data()[0];
            var html = "";

            dadosAjax = {
                'id_emp': data['id_emp']
            };

            jQuery.ajax({
                type: 'POST',
                url: "{!! route('seracademico.biblioteca.dataDevolucaoEmprestimo') !!}",
                data: dadosAjax,
                datatype: 'json'
            }).done(function (retorno) {
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
                } else {
                    //console.log(data);
                    html += "<tr>";
                    html += "<td>" + data['titulo'] + "</td>";
                    html += "<td>" + data['cutter'] + "</td>";
                    html += "<td>" + data['subtitulo'] + "</td>";
                    html += "<td>" + data['edicao'] + "</td>";
                    html += "<td>" + data['tombo'] + "</td>";
                    html += "<td>" + data['nome_sit'] + "</td>";
                    html += "<td>" + data['nome_emp'] + "</td>";
                    html += "<td>" +
                            "<button type='button' class='btn-floating remove' onclick='RemoveTableRow(this)'  title='Deletar'><i class='fa fa-times'></i></button></li></td>" +
                            "<input type='hidden' name='id[]' value='" + data['id'] + "'>";
                    html += "</tr>";

                    $('#emprestimos tbody').append(html);
                    $('#data').val(retorno['data']);
                }

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

        $(document).ready(function(){
            //consulta via select2 responsável
            $("#pessoa").select2({
                placeholder: 'Selecione uma pessoa',
                minimumInputLength: 1,
                width: 400,
                ajax: {
                    type: 'POST',
                    url: "{{ route('seracademico.util.select2')  }}",
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
        });

        $(document).on('submit', '#form', function (event) {
            location.reload();
        });
    </script>
@stop