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
            <h3>Grade Curricular</h3>
            <h2>Curso : {{ $rows[0]->nomeCurso  }} Currículo: {{ $rows[0]->codigoCurriculo }}</h2>
            <div>
                <table id="repor_curriculo" border="1" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Período</th>
                        <th>Código</th>
                        <th>Disciplina</th>
                        <th>C.H.</th>
                        <th>Crédito</th>
                        <th>Pré-requisito</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($rows as $row)
                            <tr>
                                <td>{{ $row->periodo }}</td>
                                <td>{{ $row->codigo }}</td>
                                <td>{{ $row->nome }}</td>
                                <td>{{ $row->carga_horaria }}</td>
                                <td>{{ $row->qtd_credito }}</td>
                                <td>{{ $row->codPreReq1 }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>