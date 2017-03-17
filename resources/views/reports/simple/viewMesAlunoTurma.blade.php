<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title></title>
    <style type="text/css" class="init">
        body {
            font-family: Arial, Helvetica, AppleGothic, sans-serif;
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
            width: 10%;
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
    <!-- Div container-->
    <div id="container">
        <div id="header">
            <img src="{{ asset('img/logo-alpha-b.png') }}" width="200" height="200" alt="Logo Alpha">
        </div>


        <div id="body">
            <div class="row">
                <div class="col-md-12">
                    <table id="tableHeader" border="1">
                        <tbody>
                        <tr>
                            <td>Turma:</td>
                            <td>{{ $dados['filtersBody'][0] ?? ""  }}</td>
                        </tr>
                        </tbody>
                    </table>

                    <h4 style="text-align: center">Alunos por turma</h4>

                    <table id="tableBody" border="1">
                        <thead>
                        <tr>
                            <th class="percentFive">Nº</th>
                            <th>Nome</th>
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
    </div>
</body>
</html>