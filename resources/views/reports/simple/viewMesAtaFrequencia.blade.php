<html>
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title></title>
    <style type="text/css">
        html, body {
            height: 100%;
            height:auto !important;
            font-family: Arial, Helvetica, AppleGothic, sans-serif;
        }

        #header {
            text-align: center;
            margin-bottom: 0;
        }

        #header img {
            margin-right: 8%;
        }

        #body {
            margin-bottom: 5px;
        }

        .percentFive {
            width: 4%;
        }

        .percentTen {
            width: 10%;
        }

        .percentSixty {
            width: 46%;
        }

        .percentThirtyFive {
            width: 50%;
        }

        table {
            font-size: 12px;
            font-weight: bold;
            border-collapse: collapse;
        }

        table#tableHeader {
            margin-bottom: 5%;
        }

        table#tableHeader td {
            width: 50%;
        }

        table#tableHeader, table#tableBody {
            width: 100%;
        }

        td {
            padding-bottom: 1.0%;
            padding-left: 1.0%;
            padding-top: 0.5%;
        }

        /**** Estilos da table em duas páginas *****/
        table#tableBody { page-break-inside:auto }
        tr    { page-break-inside:avoid; page-break-after:auto }
        thead { display:table-header-group }
        tfoot { display:table-footer-group }
    </style>
</head>

<body>
<div id="header">
    {{--<img style="margin-left: 5%" width="100" src="{{ asset('img/contrato-mestrado/image4.png') }}" alt="Logo">--}}
    {{--<img width="100" src="{{ asset('img/contrato-mestrado/image1.png') }}" alt="Logo">
    <img style="margin-top: 1.3%" width="90" height="90" src="{{ asset('img/contrato-mestrado/image2.jpeg') }}" alt="Logo">--}}
    {{--<img style="margin-top: 2%" width="150" src="{{ asset('img/contrato-mestrado/image3.jpeg') }}" alt="Logo">--}}
</div>

<div id="body">
    <?php
        $objDate = $dados['filtersBody'][5] ?? "";
        $dataFinal = $dados['filtersBody'][7] ?? "";
        $numberMonth = '';

        if (!empty($objDate)) {
            $objDate = \DateTime::createFromFormat('Y-m-d', $objDate);
            $numberMonth = $objDate->format('m');
        }

        if (!empty($dataFinal)) {
            $dataFinal = \DateTime::createFromFormat('Y-m-d', $dataFinal);
        }
    ?>
    <br>

    <h4 style="text-align: center; margin-top: 0; margin-bottom: 0;">Ata de Frequência</h4>

    <table style="width: 90%; margin-left: auto; margin-right: auto;" id="tableHeader" border="1">
        <tbody>
        <tr>
            <td>CAMPUS: {{ $dados['filtersBody'][6] ?? ""}}</td>
            <td>Data: {{ !empty($dataFinal) ? $dataFinal->format('d/m/Y') : ""}}</td>

        </tr>
        <tr>
            <td>Disciplina: {{ $dados['filtersBody'][0] ?? ""}}</td>
            <td>{{ $dados['filtersBody'][2] ?? ""  }}
                - {{($objDate ? $objDate->format('Y') . '.' . ($numberMonth >= 8 ? 2 : 1) :  '')}}</td>
        </tr>
        <tr>
            <td>Professor: {{ $dados['filtersBody'][4] ?? ""}}</td>
            <td>{{ $request['turno'] }}</td>
        </tr>
        </tbody>
    </table>

    <table id="tableBody" border="1">
        <thead>
        <tr>
            <th class="percentFive">Nº</th>
            <th class="percentSixty">Nome</th>
            <th class="percentThirtyFive">Assinatura</th>
            <th class="percentTen">Nota</th>
        </tr>
        </thead>

        <tbody>
        <?php $count = 0; ?>
        @foreach($dados['body'] as $bordy)
            <tr>
                <td>{{++$count}}.</td>

                <!-- Percorrendo as colunas que tem reflexo no banco sfdsfsdfs-->
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
</body>
</html>