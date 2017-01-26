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
                <h4><i class="material-icons">find_in_page</i> Reservas dos livros</h4>
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
                    <div class="alert alert-warning">
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

            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive no-padding">
                        <table id="sala-grid" class="display table table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Detalhe</th>
                                <th>Código</th>
                                <th>Data</th>
                                <th>Data de vencimento</th>
                                <th>Aluno</th>
                                <th >Acão</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Detalhe</th>
                                <th>Código</th>
                                <th>Data</th>
                                <th>Data de vencimento</th>
                                <th>Aluno</th>
                                <th >Acão</th>
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
    console.log(d['acervo']);
                var acervo = d['reserva_exemplar'];
                var tipoEmprestimo = d['tipo_emprestimo'];
                var pessoaId = d['pessoas_id'];
                var reservaId = d['id'];
                var qtdExemplar = 0;
                var qtdExemplarAll = d['acervo'];
                var qtdExempEmprestado = 0;
                var url = "{!! route('seracademico.biblioteca.saveEmprestimo') !!}";

                var html = "<form action='"+url+"' method='post'>";
                html += "<table class='table table-bordered'>";
                html += "<thead>" +
                        "<tr><td>Título</td><td>Subtitulo</td><td>Número de chamada</td><td>Exemplares disponíveis</td>" +
                        "<td>Selecionar</td></tr>" +
                        "</thead>";

                for (var i = 0; i < acervo.length; i++) {

                    //vericando quantidade exemplares por acervo
                    /*for(var j = 0; j < acervo[i]['exemplares'].length; j++){
                        if((acervo[i]['exemplares'][j]['edicao'] == acervo[i]['pivot']['edicao'] || acervo[i]['exemplares'][j]['edicao'] == "") && acervo[i]['exemplares'][j]['situacao_id'] == '1' ||
                                (acervo[i]['exemplares'][j]['situacao_id'] == '3' && acervo[i]['exemplares'][j]['exemp_principal'] == '0')){
                            qtdExemplar++;
                            qtdExemplarAll = qtdExemplarAll + qtdExemplar;
                        }
                    }*/

                    //verificando a quantidade de exemplares já emprestados
                    if(acervo[i]['pivot']['status'] == '1') {
                        qtdExempEmprestado++;
                    }

                    html += "<tr>";
                    html += "<td>" + acervo[i]['titulo'] + "</td>";
                    html += "<td>" + acervo[i]['subtitulo'] + "</td>";
                    html += "<td>" + acervo[i]['numero_chamada'] + "</td>";
                    html += "<td>" + qtdExemplarAll + "</td>";
                    if(qtdExemplarAll == 0 || acervo[i]['pivot']['status'] == '1'){
                        html += "<td></td>";
                    } else {
                        html += "<td><input type='checkbox' name='id[]' value='"+acervo[i]['id']+"'></td>";
                        html += "<input type='hidden' name='edicao[]' value='"+acervo[i]['pivot']['edicao']+"'>";
                    }
                    html += "</tr>";
                    //if(acervo[i]['pivot']['edicao'] == "" && (qtdExemplar == 0 || acervo[i]['pivot']['status'] == '1')){
                    //    html += "<input type='hidden' name='edicao[]' value='null'>";
                   // } else {
                  //      html += "<input type='hidden' name='edicao[]' value='"+acervo[i]['pivot']['edicao']+"'>";
                  //  }
                    //qtdExemplar = 0;
                 }

                html += "</table>";
                html += "<input type='hidden' name='tipo_emprestimo' value='"+tipoEmprestimo+"'>";
                html += "<input type='hidden' name='id_pessoa' value='"+pessoaId+"'>";
                html += "<input type='hidden' name='id_reserva' value='"+reservaId+"'>";
                if(qtdExemplarAll > 0 || qtdExempEmprestado < acervo.length) {
                    html += "<input type='submit' class='btn btn-primary' value='Confirmar'>";
                }
                html += "</form>";

                return  html;
            }

            var table = $('#sala-grid').DataTable({
                processing: true,
                serverSide: true,
                order: [[ 1, "asc" ]],
                ajax: "{!! route('seracademico.biblioteca.gridReservados') !!}",
                columns: [
                    {
                        "className":      'details-control',
                        "orderable":      false,
                        "data":           'pessoas.nome',
                        "defaultContent": ''
                    },
                    {data: 'codigo', name: 'bib_reservas.codigo'},
                    {data: 'data', name: 'bib_reservas.data'},
                    {data: 'data_vencimento', name: 'bib_reservas.data_vencimento'},
                    {data: 'nome', name: 'pessoas.nome'},
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
    </script>
@stop