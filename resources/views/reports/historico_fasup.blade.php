<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title>Histórico - Fasup</title>
    <style type="text/css">
        body {
            font-family: Arial, Helvetica, AppleGothic, sans-serif;
            font-size: 11px;
            border: 4px solid #0000cc;
            padding: 1%;
            background-image: url("{{ asset('img/marca_dagua_fasup_600.png')  }}");
            background-position: center;
            background-repeat: no-repeat;
        }

        h1 {font-size: 14px;}
        h2 {font-size: 13px;}
        h3 {font-size: 12px;}

        .cabecalho h1 img {
            margin-left: 5%;
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
            margin-left: 3%;
            margin-top: 5%;
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
        <img src="{{ asset('img/fasup.png') }}" alt="FASUP">
    </h1>

    <div class="titulo">
        <h1>FACULDADE DE SAÚDE DE PAULISTA</h1>
        <h2>Portaria n° 59 de 19/01/2011 – CNPJ nº 05.783.107/0001-77</h2>
    </div>

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
    <table class="table_dados_pessoais">
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

    <table class="table_grade_curricular" cellspacing="0">
        <thead>
            <tr>
                <td style="width: 50%; text-align: center;"><b>Disciplina</b></td>
                <td style="width: 30%; text-align: center;"><b>Carga Horária</b></td>
                <td style="width: 20%; text-align: center;"><b>Notas</b></td>
            </tr>
        </thead>

        <tbody>
            @foreach($notas as $nota)
                <tr>
                    <td style="padding-left: 1%;">  {{ $nota['disciplina']['nome'] ?? '' }} </td>
                    <td style="text-align: center">
                        {{ $nota['disciplina']['carga_horaria_total'] ?? $nota['disciplina']['carga_horaria'] ?? 0 }}h
                    </td>
                    <td style="text-align: center"> {{ $nota['disciplina']['nota'] ?? 'NÃO INFORMADO' }} </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="rodape">
    <h1 style="text-align: center">
        <img src="{{ asset('img/fasup.png') }}" alt="FASUP">
    </h1>

    <div style="font-size: 9px; text-align: center; color: #808080;">
        <p style="margin:0;">Credenciada pelo MEC, Portaria nº 59 de 19/01/2011, publicada no DOU em 20/01/2011.</p>
        <p style="margin:0;">Av. Dr. Rodolfo Aureliano, 2182, Vila Torres Galvão – 53430-740 - Paulista-PE.</p>
        <p style="margin-top:0; margin-bottom: 5%;">81-4101-1117 - www.fasup.com</p>
    </div>
</div>

</body>
</html>