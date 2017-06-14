<?php

use Seracademico\Uteis\NumberText;

$qtdLivrosTxt = NumberText::numberToExt($qtdLivros->qtd);
$qtdTotalLivrosTxt = NumberText::numberToExt($qtdTotalLivros->qtd);

function data($dia, $mes, $ano, $semana) {

    /*$dia = date('d');
    $mes = date('m');
    $ano = date('Y');
    $semana = date('w');*/
//$cidade = "Digite aqui sua cidade";

// configuração mes

    switch ($mes){

        case 1: $mes = "Janeiro"; break;
        case 2: $mes = "Fevereiro"; break;
        case 3: $mes = "Março"; break;
        case 4: $mes = "Abril"; break;
        case 5: $mes = "Maio"; break;
        case 6: $mes = "Junho"; break;
        case 7: $mes = "Julho"; break;
        case 8: $mes = "Agosto"; break;
        case 9: $mes = "Setembro"; break;
        case 10: $mes = "Outubro"; break;
        case 11: $mes = "Novembro"; break;
        case 12: $mes = "Dezembro"; break;

    }


// configuração semana

    switch ($semana) {

        case 0: $semana = "Domingo"; break;
        case 1: $semana = "Segunda Feira"; break;
        case 2: $semana = "Terça Feira"; break;
        case 3: $semana = "Quarta Feira"; break;
        case 4: $semana = "Quinta Feira"; break;
        case 5: $semana = "Sexta Feira"; break;
        case 6: $semana = "Sábado"; break;

    }

    echo ("$dia de $mes de $ano");
}

?>
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

        li {
            margin-top: 18px;
        }

        td {
            text-align: center;
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
                <h1 style="text-align: center;color: #082652; ">FACULDADE ALPHA BIBLIOTECA</h1>
            </td>
            <td width="15%">
                <img alt="image" width="100%" src="{{ asset('/img/seracad.png')}}"/>
            </td>
        </tr>
    </table>
</div>
<hr>
<div class="row">

    <h3 style="text-align: center"><u>RELATÓRIO DE ATIVIDADES REALIZADAS NA BIBLIOTECA EM {{$ano}}</u></h3>
    <br />
    <ul>
        <li style="margin-top: 0px;">Triagem do material bibliográfico adquirido através de doação;</li>
        <li>Seleção e aquisição da bibligrafia solicitada pelos professores;</li>
        <li>Aquisição de aproximadamente <b>{{$qtdLivros->qtd}} ({{$qtdLivrosTxt}} - exemplares de livros) compras de
                {{$qtdLivrosComprados->qtd}} livros e {{$qtdLivrosDoados->qtd}} doações registradas.</b>
            Total geral de acervo de aproximadamente <b>{{$qtdTotalLivros->qtd}} ({{$qtdTotalLivrosTxt}} exemplares);</b></li>
        <li>Relatórios das aquisições supracitadas;</li>
        <li>Classificação, Catalogação e Registro das Aquisições realizadas;</li>
        <li>Preparação manual das novas aquisições: - Processo técnico e físico de todos os documentos que foram doados e comprados;</li>
        <li>Planilhamento de livros, periódicos, referências, folhetos, monografias, teses, dissestações, material multimídia;</li>
        <li>Revisão das planilhas supracitadas (Bibliotecária);</li>
        <li>Reuniões com funcionários, estagiários e menores aprendizes e coordenação dos mesmos;</li>
        <li>Revisão do manual de procedimentos da biblioteca;</li>
        <li>Organização das planilhas para atualização do banco de dados;</li>
        <li>Informação sobre a renovação de assinaturas das revistas, controle de
            datas e novas aquisições Cotações e compras de livros com autorização prévia da Direção;</li>
        <li>Manutenção e revisão periódica do acervo; Expasão das estantes dos livros e periódicos;</li>
        <li>Preparação de fichas catalográficas para conclusão das monograficas dos cursos e graduação e especialização;</li>
        <li>Revisão e atualização da bibliografia dos cursos, com correção de
            toda referência bibliográfica substituição de livros, cotação, conferência e aquisição dos mesmos;</li>
        <li>Recebimento da visita do MEC para avaliação dos Curso de Contábeis de toda a bibliografia do acervo da biblioteca (com nota 4);</li>
        <li>Relatório das atividades do Coral;</li>
        <li>Atendimento ao aluno do PRONATEC;</li>
        <li>Inventátio do acervo semestral;</li>
    </ul>

    <br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
    <h3 style="text-align: center"><u>QUADRO ESTATÍSTICO ANUAL DA BIBLIOTECA EM {{$ano}}</u></h3>
    <br />

    <table width="100%" border="1" cellspacing="0" style="border: 1px solid lightgray;">
        <tr>
            <td>AQUISIÇÃO DE LIVROS (compras + doações registradas)</td>
            <td>{{$qtdLivros->qtd}}</td>
        </tr>
        <tr>
            <td>COMPRAS DE LIVROS</td>
            <td>{{$qtdLivrosComprados->qtd}}</td>
        </tr>
        <tr>
            <td>DOAÇÕES LIVROS REGISTRADOS</td>
            <td>{{$qtdLivrosDoados->qtd}}</td>
        </tr>
        <tr>
            <td>ATENDIMENTO POR EMPRÉSTIMOS</td>
            <td>{{$qtdEmprestimos->qtd}}</td>
        </tr>
        <tr>
            <td>ATENDIMENTO POR CONSULTA*</td>
            <td>Não oferecido pelo programa</td>
        </tr>
        <tr>
            <td>INSCRIÇÃO DE ALUNOS (Graduação e Pós)</td>
            <td></td>
        </tr>
        <tr>
            <td>CONSULTAS NA INTERNET (contagem manual)</td>
            <td></td>
        </tr>
        <tr>
            <td>ESTUDO EM GRUPO (contagem manual)</td>
            <td></td>
        </tr>
        <tr>
            <td>ATENDIMENTO AO USUÁRIO EXTERNO*</td>
            <td>Não oferecido pelo programa</td>
        </tr>
        <tr>
            <td>TOTAL DE AQUISIÇÕES DE LIVROS NO GERAL</td>
            <td>{{$qtdTotalLivros->qtd}}</td>
        </tr>
    </table>
    <br />

    <h3 style="text-align: center">SERVIÇOS OFERECIDOS</h3>
    <br />

    <ul>
        <li>Empréstimos, consulta de livros, periódicos, monografias, teses e folhetos;</li>
        <li>Divulgação de novas aquisições;</li>
        <li>Levantamento bibliográfico, Ficha catalográfica;</li>
        <li>Orientação sobre normalização técnica (ABNT);</li>
        <li>Plataforma móvel para idosos, gestantes, deficientes e acidentados;</li>
        <li>Biblioteca Virtual Pearson (COMUT e outras bases de dados online);</li>
        <li>Consulta a internet / Digitação de trabalhos;</li>
        <li>Três salas de estudo em grupo (mínimo de três pessoas);</li>
        <li>Marketing da biblioteca (através de folders, avisos e informativos);</li>
        <li>Orientação a auxílio a pesquisa dos documentos disponíveis no acervo.</li>
    </ul>

    <br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
    <p style="text-align: center">Recife, <?php $data = new \DateTime('now'); data($data->format('d'), $data->format('m'), $data->format('Y'), $data->format('w')); ?></p>
    <br /><br />

    <p style="text-align: center">
        Miriam P. W. de Medeiros<br />
        Biblioteca CRM-4/1183
    </p>
</div>
</body>
</html>