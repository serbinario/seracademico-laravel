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
                                <th>Detalhe</th>
                                <th>Código</th>
                                <th>Data</th>
                                <th>Data de devolução</th>
                                <th>Data real de devolução</th>
                                <th>Aluno</th>
                                <th >Acão</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Detalhe</th>
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
    </div>
@stop

@section('javascript')
    <script src="{{ asset('/js/handlebars-v4.0.5.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function () {

            function format(d) {

                var exemplar = d['emprestimo_exemplar'];

                var html = "<table class='table table-bordered'>";
                html += "<thead>" +
                        "<tr><td>Título</td><td>Subtitulo</td><td>Número de chamada</td><td>Tombo</td></tr>" +
                        "</thead>";
                for (var i = 0; i < exemplar.length; i++) {
                    html += "<tr>"
                    html += "<td>" + exemplar[i]['acervo']['titulo'] + "</td>"
                    html += "<td>" + exemplar[i]['acervo']['subtitulo'] + "</td>"
                    html += "<td>" + exemplar[i]['acervo']['numero_chamada'] + "</td>"
                    var codFull    = "" + exemplar[i]['codigo'];
                    var pad = "00000000"
                    codFull = pad.substring(0, pad.length - codFull.length) + codFull
                    var cod = codFull.toString().substring(0,4);
                    var ano    = exemplar[i]['codigo'];
                    ano = codFull.toString().substring(4, 8);
                    var tombo  = cod.concat("/"+ano);
                    html += "<td>" + tombo + "</td>"
                    html += "</tr>"
                 }
                html += "</table>"

                return  html;
            }

            var table = $('#sala-grid').DataTable({
                processing: true,
                serverSide: true,
                order: [[ 1, "asc" ]],
                ajax: "{!! route('seracademico.biblioteca.devolucaoEmprestimo') !!}",
                columns: [
                    {
                        "className":      'details-control',
                        "orderable":      false,
                        "data":           'fac_alunos.nome',
                        "defaultContent": ''
                    },
                    {data: 'codigo', name: 'bib_emprestimos.codigo'},
                    {data: 'data', name: 'bib_emprestimos.data'},
                    {data: 'data_devolucao', name: 'bib_emprestimos.data_devolucao'},
                    {data: 'data_devolucao_real', name: 'bib_emprestimos.data_devolucao_real'},
                    {data: 'nome', name: 'fac_alunos.nome'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });

            // Add event listener for opening and closing details
            $('#sala-grid tbody').on('click', 'td.details-control', function () {
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
                    location.href = url
                } else {
                    false;
                }
            });
        });
    </script>
@stop