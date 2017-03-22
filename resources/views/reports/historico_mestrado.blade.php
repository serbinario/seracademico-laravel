<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title>Histórico - Mestrado</title>
    <style type="text/css">
        body {
            font-family: Arial, Helvetica, AppleGothic, sans-serif;
            font-size: 11px;
            border: 4px solid #0000cc;
            padding: 2%;
        }

        h1 {font-size: 14px;}
        h2 {font-size: 13px;}
        h3 {font-size: 12px;}

        .cabecalho h1 {
            text-align: center;
        }

        .cabecalho .titulo h2,
        .cabecalho .titulo h1,
        .cabecalho .subtitulo h2{
            text-align: center;
        }

        .cabecalho .subtitulo h2 {
            margin-top: 5%;
        }

        .corpo {
            margin-left: auto;
            margin-top: auto;
        }

        .corpo .table_dados_pessoais {
            width: 100%;
        }

        .corpo h3 {
            margin-top: 5%;
            text-align: center;
        }

        .corpo .table_grade_curricular {
            margin-top: 5%;
            margin-right: 5%;
            width: 100%;
        }

        .table_grade_curricular td {
            border: 1px solid;
            padding-bottom: 1%;
        }

        .rodape {
            position: absolute;
            bottom: 0;
        }

        table { page-break-inside:auto }
        tr    { page-break-inside:avoid; page-break-after:auto }
        thead { display:table-header-group }
        tfoot { display:table-footer-group }
    </style>
</head>
<body>

<div class="cabecalho">
    <h1>
        <img width="200" src="{{ asset('img/dd.jpg') }}" alt="FASUP">
    </h1>

    <div class="subtitulo">
        <h2>HISTÓRICO ESCOLAR</h2>
    </div>
</div>

<?php
    $aulaInicial = \DateTime::createFromFormat('Y-m-d', $turma->aula_inicio);
    $aulaFinal   = \DateTime::createFromFormat('Y-m-d', $turma->aula_final);
    $timeInicial = $aulaInicial->getTimestamp();
    $timeFinal   = $aulaFinal->getTimestamp();
?>

<div class="corpo">
    <table class="table_dados_pessoais" style="font-size: 12px">
        <tr>
            <td colspan="2"><b>DADOS PESSOAIS</b></td>
        </tr>
        <tr>
            <td style="width: 60%">Aluno(a): {{ $aluno['pessoa']['nome'] ??  "" }}</td>
            <td style="width: 40%">Matrícula: {{ $aluno['matricula'] ??  ""}}</td>
        </tr>
        <tr>
            <td style="width: 50%">RG: {{ utf8_decode($aluno['pessoa']['identidade'] ??  "")}}</td>
            <td style="width: 50%">CPF: {{ utf8_decode($aluno['pessoa']['cpf'] ??  "")}}</td>
        </tr>
        <tr>
            <td colspan="2"><b>DADOS ACADÊMICOS</b></td>
        </tr>
        <tr>
            <td colspan="2">Curso: {{ isset($curso->nome) ? $curso->nome : ""  }}</td>
        </tr>
        <tr>
            <td colspan="2">
                Período: {{ strftime('%d de %B de %Y', $timeInicial) }} com previsão de término no dia
                {{ strftime('%d de %B de %Y', $timeFinal) }}
            </td>
        </tr>
        <tr>
            <td colspan="2">
                Carga horária total: {{ isset($curso->carga_horaria) ? $curso->carga_horaria : '' }} horas/aula
            </td>
        </tr>
    </table>

    <h3>GRADE CURRICULAR</h3>

    <table class="table_grade_curricular" cellspacing="0" style="font-size: 12px">
        <thead>
        <tr>
            <td style="width: 50%; text-align: center;"><b>Disciplina</b></td>
            <td style="width: 30%; text-align: center;"><b>Carga Horária</b></td>
            <td style="width: 20%; text-align: center;"><b>Nota</b></td>
        </tr>
        </thead>

        <tbody>
        @foreach($notas as $nota)
            <tr>
                <td style="padding-left: 1%;">  {{ $nota['disciplina']['nome'] ?? '' }} </td>
                <td style="text-align: center">
                    {{ $nota['disciplina']['carga_horaria_total'] ?? $nota['disciplina']['carga_horaria'] ?? 0 }}h
                </td>
                <td style="text-align: center"> {{ $nota['nota_final'] ?? 'FALTA' }} </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

</body>
</html>