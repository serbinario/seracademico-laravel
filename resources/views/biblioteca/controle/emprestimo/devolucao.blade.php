@extends('menu')

@section('css')
    <style type="text/css" class="init">
        td.details-control {
            background: url({{asset("/imagemgrid/icone-produto-plus.png")}}) no-repeat center center;
            cursor: pointer;
        }
        tr.shown td.details-control {
            background: url({{asset("/imagemgrid/icone-produto-minus.png")}}) no-repeat center center;
        }


        a.visualizar {
            background: url({{asset("/imagemgrid/impressao.png")}}) no-repeat 0 0;
            width: 23px;
        }

        td.bt {
            padding: 10px 0;
            width: 126px;
        }

        td.bt a {
            float: left;
            height: 22px;
            margin: 0 10px;
        }
        .highlight {
            background-color: #FE8E8E;
        }
    </style>
@endsection

@section('content')

    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <div class="col-sm-6 col-md-9">
                <h4><i class="material-icons">find_in_page</i> Devolução de livros</h4>
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

            @if(Session::has('error'))
                <div class="alert alert-danger">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <em> {!! session('error') !!}</em>
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

            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#individual" aria-controls="individual" role="tab" data-toggle="tab">Devolução individual</a></li>
                <li role="presentation"><a href="#aluno" aria-controls="aluno" role="tab" data-toggle="tab">Devolução por aluno</a></li>
            </ul>

            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="individual">
                    <br />
                    <div class="row">
                        <div class="col-md-12">
                            <form id="search-form" class="form-inline" role="form" method="GET">
                                <div class="form-group">
                                    {!! Form::text('globalSearch',  null, array('class' => 'form-control', 'placeholder' => 'Pesquisa...')) !!}
                                </div>
                                <div class="form-group">
                                    <button class="btn-sm btn-primary" type="submit">Pesquisar</button>
                                </div>
                            </form>
                        </div><br /><br /><br /><br />
                        <div class="col-md-12">
                            <div class="table-responsive no-padding">
                                <table id="individual-grid" class="display table table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>Detalhe</th>
                                        <th>Código</th>
                                        <th>Data</th>
                                        <th>Data de devolução</th>
                                        <th>Data real de devolução</th>
                                        <th>Aluno</th>
                                        <th>Acão</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th style="width: 5%;">Detalhe</th>
                                        <th>Código</th>
                                        <th>Data</th>
                                        <th>Data de devolução</th>
                                        <th>Data real de devolução</th>
                                        <th>Aluno</th>
                                        <th style="width: 5%;">Acão</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="aluno">
                    <br />
                    <div class="row">
                        <div class="col-md-12">
                            <form id="search-form-aluno" class="form-inline" role="form" method="GET">
                                <div class="form-group">
                                    {!! Form::text('globalSearchAluno',  null, array('class' => 'form-control', 'placeholder' => 'Pesquisa...')) !!}
                                </div>
                                <div class="form-group">
                                    <button class="btn-sm btn-primary" type="submit">Pesquisar</button>
                                </div>
                            </form>
                        </div><br /><br /><br /><br />
                        <div class="col-md-12">
                            <div class="table-responsive no-padding">
                                <table id="aluno-grid" class="display table table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>Detalhe</th>
                                        <th>Nome</th>
                                        <th>RG</th>
                                        <th>CPF</th>
                                        <th >Acão</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th style="width: 5%;">Detalhe</th>
                                        <th>Nome</th>
                                        <th>RG</th>
                                        <th>CPF</th>
                                        <th style="width: 5%;">Acão</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('javascript')
    <script src="{{ asset('/js/handlebars-v4.0.5.js')}}"></script>

    {{--Devolução individual--}}
    <script type="text/javascript">
        $(document).ready(function () {

            function format(d) {

                var exemplar = d['exemplares'];

                var html = "<table class='table table-bordered'>";
                html += "<thead>" +
                        "<tr><td>Título</td><td>Subtitulo</td><td>Número de chamada</td><td>Tombo</td></tr>" +
                        "</thead>";
                for (var i = 0; i < exemplar.length; i++) {
                    html += "<tr>";
                    html += "<td>" + exemplar[i]['titulo'] + "</td>";
                    html += "<td>" + exemplar[i]['subtitulo'] + "</td>";
                    html += "<td>" + exemplar[i]['numero_chamada'] + "</td>";
                    html += "<td>" + exemplar[i]['tombo'] + "</td>";
                    html += "</tr>"
                 }
                html += "</table>";

                return  html;
            }

            var table = $('#individual-grid').DataTable({
                processing: true,
                serverSide: true,
                bFilter: false,
                order: [[ 1, "asc" ]],
                ajax: {
                    url: "{!! route('seracademico.biblioteca.devolucaoEmprestimo') !!}",
                    data: function (d) {
                        d.globalSearch = $('input[name=globalSearch]').val();
                    }
                },
                columns: [
                    {
                        "className":      'details-control',
                        "orderable":      false,
                        "data":           'pessoas.nome',
                        "defaultContent": ''
                    },
                    {data: 'codigo', name: 'bib_emprestimos.codigo'},
                    {data: 'data', name: 'bib_emprestimos.data'},
                    {data: 'data_devolucao', name: 'bib_emprestimos.data_devolucao'},
                    {data: 'data_devolucao_real', name: 'bib_emprestimos.data_devolucao_real'},
                    {data: 'nome', name: 'pessoas.nome'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });

            // Função do submit do search da grid principal
            $('#search-form').on('submit', function(e) {
                table.draw();
                e.preventDefault();
            });

            // Add event listener for opening and closing details
            $('#individual-grid tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = table.row( tr );

                if ( row.child.isShown() ) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                }
                else {
                    // Open this row
                    row.child( format(row.data()) ).show();
                    tr.addClass('shown');
                }
            });
        });

        $(document).on('click', 'a.excluir', function (event) {
            event.preventDefault();
            var url = $(this).attr('href');
            bootbox.confirm("Tem certeza que deseja devolver esse emprestimo?", function (result) {
                if (result) {
                    window.open(url, '_blank');
                    location.reload();
                    //location.href = url
                } else {
                    false;
                }
            });
        });

        $(document).on('click', 'a.renovar', function (event) {
            event.preventDefault();
            var url = $(this).attr('href');
            bootbox.confirm("Tem certeza que deseja renovar esse emprestimo?", function (result) {
                if (result) {
                    window.open(url, '_blank');
                    location.reload();
                    //location.href = url
                } else {
                    false;
                }
            });
        });

        $(document).on('click', 'a.baixa-pagamento', function (event) {
            event.preventDefault();
            var url = $(this).attr('href');
            bootbox.confirm("Tem certeza que deseja dar baixa no pagamento desse empréstimo?", function (result) {
                if (result) {
                    //window.open(url, '_blank');
                    //location.reload();
                    location.href = url
                } else {
                    false;
                }
            });
        });
    </script>


    {{--Devolução por aluno--}}
    <script type="text/javascript">
        $(document).ready(function () {

            function formatAluno(d) {

                var exemplar = d['exemplares'];

                var html = "<table class='table table-bordered'>";
                html += "<thead>" +
                        "<tr><td>Código do empréstimo</td><td>Título</td><td>Subtitulo</td><td>Número de chamada</td><td>Tombo</td><td>Data</td><td>Data devolução</td></tr>" +
                        "</thead>";
                for (var i = 0; i < exemplar.length; i++) {
                    html += "<tr>";
                    html += "<td>" + exemplar[i]['codigo'] + "</td>";
                    html += "<td>" + exemplar[i]['titulo'] + "</td>";
                    html += "<td>" + exemplar[i]['subtitulo'] + "</td>";
                    html += "<td>" + exemplar[i]['numero_chamada'] + "</td>";
                    html += "<td>" + exemplar[i]['tombo'] + "</td>";
                    html += "<td>" + exemplar[i]['data'] + "</td>";
                    html += "<td>" + exemplar[i]['data_devolucao'] + "</td>";
                    html += "</tr>"
                }
                html += "</table>";

                return  html;
            }

            var table_aluno = $('#aluno-grid').DataTable({
                processing: true,
                serverSide: true,
                bFilter: false,
                order: [[ 1, "asc" ]],
                ajax: {
                    url: "{!! route('seracademico.biblioteca.devolucaoEmprestimoPorAluno') !!}",
                    data: function (d) {
                        d.globalSearchAluno = $('input[name=globalSearchAluno]').val();
                    }
                },
                columns: [
                    {
                        "className":      'details-control',
                        "orderable":      false,
                        "data":           'pessoas.nome',
                        "defaultContent": ''
                    },
                    {data: 'nome', name: 'pessoas.nome'},
                    {data: 'identidade', name: 'pessoas.identidade'},
                    {data: 'cpf', name: 'pessoas.cpf'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });

            // Função do submit do search da grid principal
            $('#search-form-aluno').on('submit', function(e) {
                table_aluno.draw();
                e.preventDefault();
            });

            // Add event listener for opening and closing details
            $('#aluno-grid tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = table_aluno.row( tr );

                if ( row.child.isShown() ) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                }
                else {
                    // Open this row
                    row.child( formatAluno(row.data()) ).show();
                    tr.addClass('shown');
                }
            });
        });

        $(document).on('click', 'a.devolver-aluno', function (event) {
            event.preventDefault();
            var url = $(this).attr('href');
            bootbox.confirm("Tem certeza que deseja devolver esse emprestimo?", function (result) {
                if (result) {
                    window.open(url, '_blank');
                    location.reload();
                    //location.href = url
                } else {
                    false;
                }
            });
        });

        $(document).on('click', 'a.baixa-pagamento-aluno', function (event) {
            event.preventDefault();
            var url = $(this).attr('href');
            bootbox.confirm("Tem certeza que deseja dar baixa no pagamento desse empréstimo?", function (result) {
                if (result) {
                    //window.open(url, '_blank');
                    //location.reload();
                    location.href = url
                } else {
                    false;
                }
            });
        });
    </script>
@stop