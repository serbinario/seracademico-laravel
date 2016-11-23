<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title></title>
    <link href="{{ asset('/css/bootstrap.min.css')}}" rel="stylesheet">
    <style type="text/css" class="init">
        /****** Estilos Background *******/
        #background {
            width: 100%;
            height: 100%;
            background-image: url("{{ asset('/img/backgroud_fasup.png') }}");
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: top;
            background-size: 800px 1000px;
            opacity: 0.4;
            position: absolute;
        }

        /****** Estilos do header *******/
        #header {
            text-align: center;
        }

        /****** Estilos do body *******/
        #body {
            margin-top: 50px;
            font-size: 12px;
            font-family: Verdana, Arial, Helvetica, AppleGothic, sans-serif;
        }

        table#tableHeader td {
            width: 50%;
        }

        table#tableBody thead th{
            font-weight: normal;
        }

        .percentFive {
            width: 5%;
        }

        .percentFive {
            width: 10%;
        }

        .percentSixty {
            width: 60%;
        }

        .percentThirtyFive {
            width: 35%;
        }

        /****** Estilos footer *******/
        #footer {
            text-align: center;
        }

        #footer img {
            width: 100%;
        }

        /**** Estilos da table em duas páginas *****/
        table { page-break-inside:auto }
        tr    { page-break-inside:avoid; page-break-after:auto }
        thead { display:table-header-group }
        tfoot { display:table-footer-group }
    </style>
    <link href="" rel="stylesheet" media="print">
</head>

<body>
    <!-- Div de backgrund de imagem -->
    <div id="background"></div>

    <!-- Div container-->
    <div id="container">
        <div id="header">
            <img src="{{ asset('img/logo_fasup.png') }}" alt="Logo Fasupe">
        </div>

        <div id="body">
            <div class="row">
                <div class="col-md-12">
                    <table id="tableHeader" class="table table-bordered">
                        <tbody>
                        <tr>
                            <td>Unidade de estudos direcionados: Recife</td>
                            <td>Pós-Graduação em {{ $dados['filtersBody'][2] ?? ""  }} - {{$dados['filtersBody'][1] ?? ""}}</td>
                        </tr>
                        <tr>
                            <td>Disciplina: {{ $dados['filtersBody'][0] ?? ""}}</td>
                            <td>Professor: {{ $dados['filtersBody'][4] ?? ""}}</td>
                        </tr>
                        <tr>
                            <td>Data: {{ date('d/m/Y') }}</td>
                            <td>{{ $dados['filtersBody'][3] ?? ""}}</td>
                        </tr>
                        </tbody>
                    </table>

                    <table id="tableBody" class="table table-bordered">
                        <thead>
                        <tr>
                            <th class="percentFive">Nº</th>
                            <th class="percentTen">Matrícula</th>
                            <th class="percentSixty">Nome</th>
                            <th class="percentTen">Turma</th>
                            <th class="percentThirtyFive">Assinatura</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php $count = 0; ?>
                        @foreach($dados['body'] as $bordy)
                            <tr>
                                <td>{{++$count}}</td>

                                <!-- Percorrendo as colunas que tem reflexo no banco -->
                                @foreach($bordy as $key => $value)
                                    <td>{{ $value }}</td>
                                @endforeach

                                <!-- Percorrendo as colunas que não tem reflexo no banco -->
                                @for($i = 0; $i < (count($dados['headers'])) - count(get_object_vars($dados['body'][0] ?? [])); $i++)
                                    <td></td>
                                @endfor
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div id="footer">
            <img src="{{ asset('img/rodape_fasupe.png') }}" alt="Logo Fasupe">
        </div>
    </div>
</body>
</html>