<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title>Biblioteca</title>
    <style type="text/css">
        table tbody th, table tbody td {
            padding: 2px 2px;
            font-size: 12px;
        }

        table { page-break-inside:auto }
        tr { page-break-inside:avoid; page-break-after:auto }
        thead { display:table-header-group }
        tfoot { display:table-footer-group }
    </style>
</head>

<body>
<div class="row">
    <table width="100%">
        <tr>
            <td width="20%">
                <img alt="image" width="100%" src="{{ asset('/img/logo-alpha.png')}}"/>
            </td>
            <td width="55%"><br>
                <h1 style="text-align: center;color: #082652; ">Lista de Livros por Curso</h1>
            </td>
            <td width="15%">
                <img alt="image" width="100%" src="{{ asset('/img/seracad.png')}}"/>
            </td>
        </tr>
    </table>
</div>
<hr>
<div class="row">

        <table id="report_biblioteca" width="100%" border="1" cellspacing="0" style="border: 1px solid lightgray;" >
            <thead>
            <tr style="background-color: #2F5286; color: white;">
                    @if(isset($requisicao['titulo_ch'])) <th>Título</th> @endif
                    @if(isset($requisicao['autor_ch'])) <th>Autor(s)</th> @endif
                    @if(isset($requisicao['outro_ch'])) <th>Outros responsáveis</th> @endif
                    @if(isset($requisicao['cdd_ch'])) <th>CDD</th> @endif
                    @if(isset($requisicao['cutter_ch'])) <th>CUTTER</th> @endif
                    @if(isset($requisicao['area_ch'])) <th>Área</th> @endif
                    @if(isset($requisicao['ano_ch'])) <th>Ano</th> @endif
                    @if(isset($requisicao['assunto_ch'])) <th>Assunto</th> @endif
                    <th>Quantidade de exemplares</th>
            </tr>
            </thead>
            <tbody>
            @foreach($cursos as $curso)
                <tr style="padding: 8px; background-color: #bbcde7">
                    <td colspan="9">CURSO - {{$curso->nome}}</td>
                </tr>
                @foreach($curso->livros as $livro)
                    <tr>
                        @if(isset($requisicao['titulo_ch'])) <td>{{$livro->titulo}}</td> @endif
                        @if(isset($requisicao['autor_ch']))
                                <td>
                                    @foreach($livro->autores as $autor)
                                        {{$autor->sobrenome}}, {{$autor->nome}}<br >
                                    @endforeach
                                </td>
                        @endif
                        @if(isset($requisicao['outro_ch']))
                                <td>
                                    @foreach($livro->outros as $outro)
                                        {{$outro->sobrenome}}, {{$outro->nome}}<br >
                                    @endforeach
                                </td>
                        @endif
                        @if(isset($requisicao['cdd_ch'])) <td>{{$livro->cdd}}</td> @endif
                        @if(isset($requisicao['cutter_ch'])) <td>{{$livro->cutter}}</td> @endif
                        @if(isset($requisicao['area_ch'])) <td>{{$livro->area}}</td> @endif
                        @if(isset($requisicao['ano_ch'])) <td>{{$livro->ano}}</td> @endif
                        @if(isset($requisicao['assunto_ch'])) <td>{{$livro->assunto}}</td> @endif
                        <td>{{$livro->qtdExemplares}}</td>
                    </tr>
                @endforeach
            @endforeach
            </tbody>
        </table>

</div>
</body>
</html>