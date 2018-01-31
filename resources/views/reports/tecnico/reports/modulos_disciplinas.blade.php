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
                <h1 style="text-align: center;color: #082652; ">Relatório de módulos e disciplinas por curso</h1>
                <h2 style="text-align: center;color: #082652; ">@if(isset($modulos) && count($modulos) > 0) {{$modulos[0]->curso}} @endif</h2>
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
            <tbody>
            @if(isset($modulos) && count($modulos) > 0)
                @foreach($modulos as $modulo)
                    <tr>
                        <td style="background-color: #2F5286;
                            color: white; text-align: center; font-size: 17px" colspan="4">
                            {{$modulo->nome}}
                        </td>
                    </tr>
                    <tr style="text-align: center; font-size: 12px; background-color: grey">
                        <td>Disciplina</td>
                        <td>Carga horária</td>
                        <td>Quantidade de faltas</td>
                        <td>Tipo da disciplina</td>
                    </tr>
                    @foreach($modulo->disciplinas as $disciplina)
                        <tr>
                            <td>{{$disciplina->nome}}</td>
                            <td>{{$disciplina->carga_horaria}}</td>
                            <td>{{$disciplina->qtd_falta}}</td>
                            <td>{{$disciplina->tipo_disciplina}}</td>
                        </tr>
                    @endforeach
                @endforeach
            @endif
            </tbody>
        </table>

</div>
</body>
</html>