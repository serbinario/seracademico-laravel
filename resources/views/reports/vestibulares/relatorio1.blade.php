<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title>Vestibulandos</title>
    <style type="text/css">
        table tbody th, table tbody td {
            padding: 2px 2px;
            font-size: 12px;
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
                <h1 style="text-align: center;color: #082652; ">Lista de Vestibulandos</h1>
            </td>
            <td width="15%">
                <img alt="image" width="100%" src="{{ asset('/img/seracad.png')}}"/>
            </td>
        </tr>
    </table>
</div>
<hr>
<div class="row">

        <table id="report_vestibulando" width="100%" border="1" cellspacing="0" style="border: 1px solid lightgray;" >
            <thead>
            <tr style="background-color: #2F5286; color: white;">
                <th>Nome</th>
                <th>Inscrição</th>
                {{--<th>Telefones</th>--}}
                <th>CPF</th>
                <th>Vestibular</th>
                <th>Financeiro</th>
            </tr>
            </thead>
            <tbody>
            @foreach($rows as $row)
                <tr >
                    <td><b>{{ $row->nome }}</b></td>
                    <td style="text-align: center;">{{ $row->inscricao }}</td>
                    {{--<td>{{ $row->celular  }}</td>--}}
                    <td style="text-align: center;">{{ $row->cpf }}</td>
                    <td style="text-align: center;">{{ $row->vestibular }}</td>
                    <td style="text-align: center;">{{ $row->financeiro }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

</div>
</body>
</html>