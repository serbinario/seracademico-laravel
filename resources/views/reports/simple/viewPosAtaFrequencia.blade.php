<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title></title>
    <style type="text/css" class="init">
        html, body {
            height: 100%;
            font-family: Arial, Helvetica, AppleGothic, sans-serif;
        }

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
        }

        table {
            font-size: 12px;
            font-weight: bold;
            border-collapse: collapse;
        }

        td {
            padding-bottom: 1.0%;
            padding-left: 1.0%;
            padding-top: 0.5%;
        }

        table#tableHeader {
            margin-bottom: 5%;
        }

        table#tableHeader td {
            width: 50%;
        }

        table#tableHeader,table#tableBody {
            width : 100%;
        }

        table#tableBody {
            margin-bottom: 5%;
        }

        .percentFive {
            width: 4%;
        }

        .percentSixty {
            width: 46%;
        }

        .percentThirtyFive {
            width: 50%;
        }

        /****** Estilos footer *******/

        .page-wrap {
            min-height: 100%;
            /* equal to footer height */
            margin-bottom: -142px;
        }
        .page-wrap:after {
            content: "";
            display: block;
        }
        .site-footer, .page-wrap:after {
            height: 142px;
        }

        #footer img {
            padding-top: 90%;
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

        <!-- Lógica do período-->
        <?php
            $numberMonth = date('m');
        ?>

        <div id="body" class="page-wrap">
            <div class="row">
                <div class="col-md-12">

                    <?php
                        $objDate = $dados['filtersBody'][5] ?? "";

                        if(!empty($objDate)) {
                            $objDate = \DateTime::createFromFormat('Y-m-d', $objDate);
                        }
                    ?>

                    <table id="tableHeader" border="1">
                        <tbody>
                        <tr>
                            <td>Unidade de estudos direcionados: Recife</td>
                            <td>{{ $dados['filtersBody'][2] ?? ""  }} - {{($objDate ? $objDate->format('Y') . '.' . ($numberMonth >= 8 ? 2 : 1) :  '')}}</td>
                        </tr>
                        <tr>
                            <td>Disciplina: {{ $dados['filtersBody'][0] ?? ""}}</td>
                            <td>Professor: {{ $dados['filtersBody'][4] ?? ""}}</td>
                        </tr>
                        <tr>
                            <td>Data: {{ !empty($objDate) ? $objDate->format('d/m/Y') : ""}}</td>
                            <td>Período: {{ $request['turno'] }}</td>
                        </tr>
                        </tbody>
                    </table>

                    <h4 style="text-align: center">Ata de Frequência</h4>

                    <table id="tableBody" border="1">
                        <thead>
                        <tr>
                            <th class="percentFive">Nº</th>
                            <th class="percentSixty">Nome</th>
                            <th class="percentThirtyFive">Assinatura</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php $count = 0; ?>
                        @foreach($dados['body'] as $bordy)
                            <tr>
                                <td>{{++$count}}.</td>

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

        <div id="footer" class="site-footer">
            <img src="{{ asset('img/rodape_fasupe.png') }}" alt="Logo Fasupe">
        </div>
    </div>
</body>
</html>