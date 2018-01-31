<html>
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title>Ata de Assinatura - GRADUAÇÃO</title>
    <style type="text/css">
        html, body {
            height: 100%;
            height:auto !important;
            font-family: Arial, Helvetica, AppleGothic, sans-serif;
        }

        body {
            background-image: url("{{ asset('img/marca_dagua_logo-alpha-b.png') }}");
            background-position: center center;
            background-repeat: no-repeat;
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
    <h1>
        <img width="200" src="{{ asset('img/logo-alpha-b.png') }}" alt="alpha">
    </h1>
</div>

<!-- Lógica do período-->
<?php
    $numberMonth = date('m');
?>

<div id="body">
    <?php
        $objDate = new \DateTime("now");
    ?>
    <br>

    <table id="tableHeader" border="1">
        <tbody>
        <tr>
            {{--<td>Unidade de estudos direcionados: {{ $dados['filtersBody'][6] ?? ""}}</td>--}}
            <td colspan="2">Disciplina: {{ $dados['filtersBody'][0] ?? ""}}</td>
        </tr>
        <tr>
            <td>Turma: {{ $dados['filtersBody'][2] ?? ""  }} - {{ $dados['filtersBody'][1] ?? ""  }}</td>
            <td>Professor: {{ $dados['body'][0]->professor ?? ""}}</td>
        </tr>
        <tr>
            <td>Data: {{ !empty($objDate) ? $objDate->format('d/m/Y') : ""}}</td>
            <td></td>
            {{--<td>Período: {{ $request['turno'] }}</td>--}}
        </tr>
        </tbody>
    </table>

    <h4 style="text-align: center">Ata de Assinatura</h4>

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
        @foreach($dados['body'] as $body)
            <tr>
                <td>{{++$count}}.</td>
                <td>{{ $body->matricula . ' - ' . $body->nome }}</td>
                <td></td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

</body>
</html>
