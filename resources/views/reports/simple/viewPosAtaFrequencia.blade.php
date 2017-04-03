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

        body {
            background-image: url("{{ asset('img/background-alpha.png') }}");
            background-position: center center;
        }

        #header {
            text-align: center;
        }

        #body {
            margin-bottom: 10px;
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

        #footer {
            position: absolute;
            bottom: 0;
        }

        #footer img {
            width: 100%;
        }

        table {
            font-size: 12px;
            font-weight: bold;
            border-collapse: collapse;
            page-break-inside: auto
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

        table#tableBody {
            margin-bottom: 5%;
        }

        tr {
            page-break-inside: avoid;
            page-break-after: auto
        }

        td {
            padding-bottom: 1.0%;
            padding-left: 1.0%;
            padding-top: 0.5%;
        }

        thead {
            display: table-header-group
        }

        tfoot {
            display: table-footer-group
        }
    </style>
</head>

<body>
<!-- Div de backgrund de imagem -->
<div id="background"></div>

<div id="header">
    <<h1>
        <img width="200" src="{{ asset('img/dd.jpg') }}" alt="FASUP">
    </h1>
</div>

<!-- Lógica do período-->
<?php
    $numberMonth = date('m');
?>

<div id="body">
    <?php
        $objDate = $dados['filtersBody'][5] ?? "";

        if (!empty($objDate)) {
            $objDate = \DateTime::createFromFormat('Y-m-d', $objDate);
        }
    ?>
    <br>

    <table id="tableHeader" border="1">
        <tbody>
        <tr>
            <td>Unidade de estudos direcionados: {{ $dados['filtersBody'][6] ?? ""}}</td>
            <td>{{ $dados['filtersBody'][2] ?? ""  }}
                - {{($objDate ? $objDate->format('Y') . '.' . ($numberMonth >= 8 ? 2 : 1) :  '')}}</td>
        </tr>
        <tr>
            <td>Disciplina: {{ $dados['filtersBody'][0] ?? ""}}</td>
            <td>Professor: {{ $dados['filtersBody'][4] ?? ""}}</td>
        </tr>
        <tr>
            <td>Data: {{ !empty($objDate) ? $objDate->format('d/m/Y') : ""}}</td>
            <td>Período: {{ $request['turno'] }}</td>
        </tr>
        {{--{{dd($dados)}}--}}
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