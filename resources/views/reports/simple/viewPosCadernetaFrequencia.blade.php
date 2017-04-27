<html>
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title>Caderneta de Frequência</title>
    <style type="text/css">
        #logoTopo {
            margin-bottom: 10px;
            width: 80px;
            height: auto;
        }

        #tituloSituacaoAlunos {
            background-color: #c8c8c8;
            font-family: Arial;
            font-size: 16px;
            text-align: center;
            margin-bottom: 0;
        }

        #tituloDiarioAula {
            background-color: #c8c8c8;
            font-family: Arial;
            font-size: 16px;
            text-align: center;
            margin-bottom: 10px;
        }

        #tabelaSuperior {
            margin-bottom: 15px;
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

        .textCenter {
            text-align: center;
        }

        .textRight {
            text-align: right;
        }

        .textLeft {
            text-align: left;
        }

        #detalhePlanoAulaHora {
            margin-top: 15px;
            margin-bottom: 40px;
        }

        #linhAssinaturaProf {
            position: relative;
            top: 25px;
            left: 50px;
        }

        #linhAssinaturaCoor {
            position: relative;
            top: -10px;
            left: 400px;
        }

        #assinaturaProf {
            position: relative;
            top: -25px;
            left: 58px;
        }

        #assinaturaCoor {
            position: relative;
            top: -60px;
            left: 435px;
        }
    </style>
</head>

<body>
<div id="header">
    {{--Dados da turma--}}
    <h1>
        <img id="logoTopo" src="{{ asset('img/logo_modelo.png') }}" alt="Logo faculdade modelo">
    </h1>
    <h2 id="tituloSituacaoAlunos">
        DIÁRIO DE CLASSE
    </h2>
    <table id="tabelaSuperior" width="544" cellspacing="0">
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
        <tr>
            <td style="background-color: #c8c8c8; font-weight: bold;" colspan="2" class="textCenter">ALUNOS EFETIVOS</td>
        </tr>
        </tbody>
    </table>
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
            {{--mês--}}
            <td class="textCenter">8</td>
            <td class="textCenter">9</td>
            <td class="textCenter">10</td>
            {{--colunas abaixo da coluna notas--}}
            <th rowspan="2">Prova</th>
            <th rowspan="2">Trab.</th>
            <th rowspan="2">Média</th>
        </tr>
        <tr>
            <th class="textCenter">Dias</th>
            {{--dia--}}
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
    <h2 id="tituloDiarioAula">
        RESUMO DO CONTEÚDO MINISTRADO
    </h2>
    <table style="width: 100%">
        <thead>
            <tr>
                <th width="160px" rowspan="6" height="120px">1ª Aula</th>
                <td>Data: ...... / ...... /........</td>
                <td>Horas</td>
            </tr>
        </thead>
        <tbody>
        <tr>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td colspan="2"></td>
        </tr>
        </tbody>
    </table>
    <p id="detalhePlanoAulaHora" class="textLeft">Total de horas ministradas:___________________</p>
    <p class="textRight">_______________, _____ de __________________ de ________.</p>
    <p id="linhAssinaturaProf">_______________________________</p>
    <p id="linhAssinaturaCoor">_______________________________</p>
    <p id="assinaturaProf">Assinatura do Professor Ministrante</p>
    <p id="assinaturaCoor">Assinatura da Coordenação</p>

</div>
</body>
</html>