<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title>Currículo do Curso</title>
    <style type="text/css">
        table tbody th, table tbody td {
            padding: 2px 2px;
            font-size: 10px;
        }
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
                <h1 style="text-align: center;color: #082652; ">Grade Curricular</h1>
                <h3 style="text-align: center;color: #082652; "><b>Curso:</b> {{ $rows[0]->nomeCurso  }} - <b>Currículo:</b> {{ $rows[0]->codigoCurriculo }}</h3>
            </td>
            <td width="15%">
                <img alt="image" width="100%" src="{{ asset('/img/seracad.png')}}"/>
            </td>
        </tr>
    </table>
</div>
<hr>
<div class="row">
    <table id="repor_curriculo" width="100%" border="1" cellspacing="0" style="border: 1px solid lightgray;">
        <thead>
        <tr style="background-color: #2F5286; color: white;">
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
                <td style="text-align: center;">{{ $row->periodo }}</td>
                <td>{{ $row->codigo }}</td>
                <td>{{ $row->nome }}</td>
                <td style="text-align: center;">{{ $row->carga_horaria }}</td>
                <td style="text-align: center;">{{ $row->qtd_credito }}</td>
                <td style="text-align: center;">{{ $row->codPreReq1 }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

</body>
</html>