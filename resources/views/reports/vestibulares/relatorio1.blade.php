<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title></title>
    <link href="" rel="stylesheet" media="screen">
    <style type="text/css">
        table tbody th, table tbody td {
            padding: 2px 2px;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="row">
        <div class="col-md-12">
            <h3>Relatório de todos os Vestibulandos</h3>
            <div>
                <table id="report_vestibulando" border="1" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Inscrição</th>
                        <th>Telefones</th>
                        <th>CPF</th>
                        <th>Vestibular</th>
                        <th>Financeiro</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($rows as $row)
                            <tr>
                                <td>{{ $row->nome }}</td>
                                <td>{{ $row->inscricao }}</td>
                                <td>{{ $row->celular  }}</td>
                                <td>{{ $row->cpf }}</td>
                                <td>{{ $row->vestibular }}</td>
                                <td>{{ $row->financeiro }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>