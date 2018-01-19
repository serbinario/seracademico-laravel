
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title>VESTIBULANDOS POR FORMA DE ADMISSÃO - GRADUAÇÃO</title>
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
            <th>Vestibulando</th>
            <th>Curso</th>
            <th>Turno</th>
        </tr>
        </thead>
        <tbody>
        @foreach($dados['body'] as $vestibulando)
            <tr>
                <td><b>{{$vestibulando->nome}}</b></td>
                <td style="text-align: center;">{{$vestibulando->curso}}</td>
                @if($vestibulando->turno == 1)
                        <td style="text-align: center;">Manhã</td>
                    @elseif($vestibulando->turno == 2)
                        <td style="text-align: center;">Tarde</td>
                    @elseif($vestibulando->turno == 3)
                        <td style="text-align: center;">Noite</td>
                    @else
                        <td style="text-align: center;">Integral</td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
    <br>
    <table width="100%" border="1" cellspacing="0" style="border: 1px solid lightgray;">
        <thead>
        <tr style="background-color: #2F5286; color: white;">
            <th colspan="2">Totais</th>
        </tr>
        <tr>
            <th>Vestibulandos</th>
            <td>{{count($dados['body'])}}</td>
        </tr>
        {{--<tr>
            @foreach($dados['body'] as $value)
                <th>{{$value->turno}}</th>
                <td>gfd</td>
            @endforeach
        </tr>--}}
        </thead>
        <tbody>
        {{----}}
        </tbody>
    </table>
</div>
</body>
</html>