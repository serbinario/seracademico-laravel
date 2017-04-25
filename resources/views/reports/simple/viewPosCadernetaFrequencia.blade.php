<html>
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title></title>
    <style type="text/css">
        #logoTopo {
            margin-bottom: 20px;
        }

        #tituloDocumento {
            background-color: #c8c8c8;
            font-family: Arial;
            font-size: 16px;
            text-align: center;
            margin-bottom: 0;
        }

        table {
            margin-top: 0;
        }

        #subTitulo {
            background-color: #c8c8c8;
            font-family: Arial;
            font-size: 15px;
            margin-bottom: 20px;
        }

        td, th {
            border: 1px solid;
            margin: 0;
        }

        thead th {
            background-color: #c8c8c8;
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
    <table id="tabelaSupeior" width="544" cellspacing="0">
        <tbody>
        <tr>
            <td>Curso: </td>
            <td>Turma: </td>
        </tr>
        <tr>
            <td colspan="2">Disciplina: </td>
        </tr>
        <tr>
            <td colspan="2">Carga Horária: </td>
        </tr>
        <tr>
            <td>Professor Responsável: </td>
            <td>Titulação: </td>
        </tr>
        </tbody>
    </table>
    <h1 id="subTitulo" class="textCenter">
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
            <th colspan="4">Dias Letivos</th>
            <th rowspan="3">Percentual de Frequência (%)</th>
            <th colspan="3">Notas</th>
        </tr>
        <tr>
            <th class="textCenter">Mês</th>
            {{--colunas verticais abaixo de dias letivos--}}
            <td class="textCenter">1</td>
            <td class="textCenter">2</td>
            <td class="textCenter">3</td>
            {{--colunas abaixo da coluna notas--}}
            <th rowspan="2">Prova</th>
            <th rowspan="2">Trab.</th>
            <th rowspan="2">Média</th>
        </tr>
        <tr>
            <th class="textCenter">Dias</th>
            <td class="textCenter">7</td>
            <td class="textCenter">8</td>
            <td class="textCenter">9</td>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="textCenter">1</td>
            <td>Francisco</td>
            <td></td>
            <td class="textCenter">F</td>
            <td class="textCenter">P</td>
            <td class="textCenter">F</td>
            <td class="textCenter">50%</td>
            <td class="textCenter">7,0</td>
            <td class="textCenter">7,0</td>
            <td class="textCenter">7,0</td>
        </tr>
        </tbody>
    </table>
    {{--Dados dos alunos--}}
    {{--Diario de aula--}}
    <h1 id="tituloDocumento">
        RESUMO DO CONTEÚDO MINISTRADO
    </h1>
    <table>
        <thead>
            <tr>
                <th rowspan="6">1ª Aula</th>
                <th>Data: ...... / ...... /........</th>
                <th>Horas</th>
            </tr>
        </thead>
        <tbody>
        <tr>
            <td>1</td>
            <td>2</td>
        </tr>
        <tr>
            <td>3</td>
            <td>4</td>
        </tr>
        <tr>
            <td>5</td>
            <td>6</td>
        </tr>
        <tr>
            <td>7</td>
            <td>8</td>
        </tr>
        <tr>
            <td>9</td>
            <td>10</td>
        </tr>
        </tbody>
    </table>
    {{--Diario de aula--}}
</div>
</body>
</html>