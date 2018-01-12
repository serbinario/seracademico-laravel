<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title>Biblioteca</title>
    <style type="text/css">
        table tbody th, table tbody td {
            padding: 2px 2px;
            font-size: 12px;
        }

        table { page-break-inside:auto }
        tr { page-break-inside:avoid; page-break-after:auto }
        thead { display:table-header-group }
        tfoot { display:table-footer-group }
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
                <h1 style="text-align: center;color: #082652; ">Relação Devolução por data</h1>
                @if($requisicao['data_inicial'] && $requisicao['data_final'])
                    <h4 style="text-align: center;color: #082652; ">Período: {{$requisicao['data_inicial']}} a {{$requisicao['data_final']}}</h4>
                @endif
            </td>
            <td width="15%">
                <img alt="image" width="100%" src="{{ asset('/img/seracad.png')}}"/>
            </td>
        </tr>
    </table>
</div>
<hr>
<div class="row">

        <table id="report_biblioteca" width="100%" border="1" cellspacing="0" style="border: 1px solid lightgray;" >
            <thead>
            <tr style="background-color: #2F5286; color: white;">
                <th>Identidade</th>
                <th>Nome</th>
                <th>Registro</th>
                <th>Título</th>
                <th>Empréstimo</th>
            </tr>
            </thead>
            <tbody>
            @foreach($emprestimos as $emprestimo)
                <tr>
                    <td>{{$emprestimo->identidade}}</td>
                    <td>{{$emprestimo->nome}}</td>
                    <td>{{$emprestimo->registro}}</td>
                    <td>{{$emprestimo->titulo}}</td>
                    <td>{{$emprestimo->data}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

</div>
</body>
</html>