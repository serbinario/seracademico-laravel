<html>
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title></title>
    <style type="text/css">
        body {
            font-family: Arial, Helvetica, AppleGothic, sans-serif;
        }

        #logoTopo {
            margin-bottom: 20px;
        }

        #tituloDocumento {
            background-color: #DCDCDC;
            font-family: Arial;
            font-size: 16px;
            text-align: center;
            margin-bottom: 0;
        }

        table {
            font-size: 12px;
            margin-top: 0;
        }

        #subTitulo {
            background-color: #DCDCDC;
            font-family: Arial;
            font-size: 15px;
            margin-bottom: 20px;
        }

        td, th {
            border: 1px solid;
            margin: 0;
        }

        td {
            padding: 0.8%;
        }
a
        thead th {
            background-color: #DCDCDC;
            text-align: center;
        }

        tr {
            border: none;
            margin: 0;
            padding: 0;
        }

        .textLeft {
            text-align: left;
        }

        .textCenter {
            width: 4%;
            text-align: center;

        }
    </style>
</head>

<body>
<div id="header">
    {{--Dados da turma--}}
    <h1>
        <img id="logoTopo" src="{{ asset('img/logo_modelo.png') }}" alt="Logo faculdade modelo">
    </h1>

    <h1 id="tituloDocumento">
        DIÁRIO DE CLASSE
    </h1>

    <table id="tabelaSupeior" style="margin-bottom: 2%" width="544" cellspacing="0">
        <tbody>
        <tr>
            <td><b>Curso:</b> {{ $dados["cursoTurmaDisciplinaProfessor"][0]->nomeCurso ?? "" }}</td>
            <td><b>Turma:</b> {{ $dados["cursoTurmaDisciplinaProfessor"][0]->codigoTurma ?? "" }}</td>
        </tr>
        <tr>
            <td colspan="2"><b>Disciplina:</b> {{ $dados["cursoTurmaDisciplinaProfessor"][0]->nomeDisciplina ?? "" }}</td>
        </tr>
        <tr>
            <td colspan="2"><b>Carga Horária:</b> {{ $dados["cursoTurmaDisciplinaProfessor"][0]->cargaHoraria ?? "" }}</td>
        </tr>
        <tr>
            <td><b>Professor Responsável:</b> {{ $dados["cursoTurmaDisciplinaProfessor"][0]->nomeProfessor ?? "" }}</td>
            <td><b>Titulação:</b> {{ $dados["cursoTurmaDisciplinaProfessor"][0]->nomeTitulacao ?? "" }}</td>
        </tr>
        </tbody>
    </table>

    <h1 id="subTitulo" style="text-align: center;">
        ALUNOS EFETIVOS
    </h1>

    {{--Dados da turma--}}
</div>
<div id="body">
    {{--Dados dos alunos--}}
    <table width="544" id="tabelaInferior" border="1" cellspacing="0">
        <thead>
        <tr>
            <th rowspan="3">N°</th>
            <th rowspan="3">Nome do(a) Aluno(a)</th>
            <th colspan="11">Dias Letivos</th>
            <th rowspan="3">Percentual de Frequência (%)</th>
            <th colspan="3">Notas</th>
        </tr>
        <tr>
            <th class="textCenter">Mês</th>
            {{--colunas verticais abaixo de dias letivos--}}
            <td class="textCenter"></td>
            <td class="textCenter"></td>
            <td class="textCenter"></td>
            <td class="textCenter"></td>
            <td class="textCenter"></td>
            <td class="textCenter"></td>
            <td class="textCenter"></td>
            <td class="textCenter"></td>
            <td class="textCenter"></td>
            <td class="textCenter"></td>

            {{--colunas abaixo da coluna notas--}}
            <th rowspan="2">Prova</th>
            <th rowspan="2">Trab.</th>
            <th rowspan="2">Média</th>
        </tr>
        <tr>
            <th class="textCenter">Dias</th>
            <td class="textCenter"></td>
            <td class="textCenter"></td>
            <td class="textCenter"></td>
            <td class="textCenter"></td>
            <td class="textCenter"></td>
            <td class="textCenter"></td>
            <td class="textCenter"></td>
            <td class="textCenter"></td>
            <td class="textCenter"></td>
            <td class="textCenter"></td>
        </tr>
        </thead>
        <tbody>

        <?php $cout = 0; ?>

        @foreach($dados["alunos"] as $aluno)
            <tr>
                <td class="textCenter">{{ ++$cout }}</td>
                <td style="font-size: 10px; padding-top: 0;">{{ $aluno->nome }}</td>
                <td></td>
                <td class="textCenter"></td>
                <td class="textCenter"></td>
                <td class="textCenter"></td>
                <td class="textCenter"></td>
                <td class="textCenter"></td>
                <td class="textCenter"></td>
                <td class="textCenter"></td>
                <td class="textCenter"></td>
                <td class="textCenter"></td>
                <td class="textCenter"></td>
                <td class="textCenter"></td>
                <td class="textCenter"></td>
                <td class="textCenter"></td>
                <td class="textCenter"></td>
            </tr>
        @endforeach

        </tbody>
    </table>
    {{--Dados dos alunos--}}
    {{--Diario de aula--}}
    <h1 id="tituloDocumento" style="margin-bottom: 3%; page-break-before: always;">
        RESUMO DO CONTEÚDO MINISTRADO
    </h1>

    <table class="tabelaDiario" style="width: 100%;" cellspacing="0">
        <thead>
            <tr>
                <th rowspan="11">1ª Aula</th>
                <th style="text-align: left">Data: ...... / ...... /........</th>
                <th style="text-align: left" >Horas: </th>
            </tr>
        </thead>
        <tbody>
        <tr>
            <td colspan="2" style="height: 2%"></td>
        </tr>
        <tr>
            <td colspan="2" style="height: 2%"></td>
        </tr>
        <tr>
            <td colspan="2" style="height: 2%"></td>
        </tr>
        <tr>
            <td colspan="2" style="height: 2%"></td>
        </tr>
        <tr>
            <td colspan="2" style="height: 2%"></td>
        </tr>
        <tr>
            <td colspan="2" style="height: 2%"></td>
        </tr>
        <tr>
            <td colspan="2" style="height: 2%"></td>
        </tr>
        <tr>
            <td colspan="2" style="height: 2%"></td>
        </tr>
        <tr>
            <td colspan="2" style="height: 2%"></td>
        </tr>
        <tr>
            <td colspan="2" style="height: 2%"></td>
        </tr>
        </tbody>
    </table>
    {{--Diario de aula--}}
</div>
</body>
</html>