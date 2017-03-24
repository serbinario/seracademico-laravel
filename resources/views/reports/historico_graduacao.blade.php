<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title>Histórico - PÓS</title>
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

<div class="corpo">
    <table class="table_dados_pessoais" style="font-size: 12px">
        <tr>
            <td colspan="2"><b>DADOS PESSOAIS</b></td>
        </tr>
        <tr>
            <td style="width: 60%">Aluno(a): {{ $dadosDoAluno->nome }}</td>
            <td style="width: 40%">Matrícula: {{ $dadosDoAluno->matricula }}</td>
        </tr>
        <tr>
            <td style="width: 50%">RG: {{ $dadosDoAluno->identidade }}</td>
            <td style="width: 50%">CPF: {{ $dadosDoAluno->cpf }}</td>
        </tr>
        <tr>
            <td colspan="2"><b>DADOS ACADÊMICOS</b></td>
        </tr>
        <tr>
            <td colspan="2">Curso: {{ $dadosDoAluno->codigoCurso }} -  {{ $dadosDoAluno->nomeDoCurso  }}</td>
        </tr>
        <tr>
            <td colspan="2">
                Currículo: {{ $dadosDoAluno->codigoCurriculo }} - {{ $dadosDoAluno->nomeDoCurriculo }}
            </td>
        </tr>
        <tr>
            <td colspan="2">
                Semestre: {{ $dadosDoAluno->semestre }}
            </td>
        </tr>
        <tr>
            <td colspan="2">
                Período: {{ $dadosDoAluno->periodo }}
            </td>
        </tr>

    </table>

    <h3>GRADE CURRICULAR</h3>

    <table class="table_grade_curricular" cellspacing="0" style="font-size: 12px">
        <thead>
        <tr>
            <td style="width: 50%; text-align: center;"><b>Disciplina</b></td>
            <td style="width: 6%; text-align: center;"><b>1º Unidade</b></td>
            <td style="width: 6%; text-align: center"><b>2º Unidade</b></td>
            <td style="width: 6%; text-align: center;"><b>2º Chamada</b></td>
            <td style="width: 6%; text-align: center;"><b>Nota Final</b></td>
            <td style="width: 6%; text-align: center;"><b>Média</b></td>
            <td style="width: 20%; text-align: center;"><b>Situação</b></td>
        </tr>
        </thead>

        <tbody>
        @foreach($dadosDasNotas as $nota)
            <tr>
                <td style="padding-left: 1%;">  {{ $nota->nome }} </td>
                <td style="padding-left: 1%;">  {{ $nota->nota_unidade_1 ? number_format((float) $nota->nota_unidade_1, 2, '.' , '') : '' }} </td>
                <td style="padding-left: 1%;">  {{ $nota->nota_unidade_2 ? number_format((float) $nota->nota_unidade_2 , 2, '.', '') : '' }} </td>
                <td style="padding-left: 1%;">  {{ $nota->nota_2_chamada ? number_format((float) $nota->nota_2_chamada, 2, '.', '') : '' }} </td>
                <td style="padding-left: 1%;">  {{ $nota->nota_final ? number_format((float) $nota->nota_final, 2, '.', '') : '' }} </td>
                <td style="padding-left: 1%;">  {{ $nota->nota_media ? number_format((float) $nota->nota_media, 2, '.', '') : '' }} </td>
                <td style="padding-left: 1%;">  {{ $nota->nomeSituacao }} </td>
            </tr>
        @endforeach


        </tbody>
    </table>
</div>

</body>
</html>