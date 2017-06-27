<?php

// leitura das datas automaticamente

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

    echo ("$semana, $dia de $mes de $ano");
}
//Agora basta imprimir na tela...
//echo ("$cidade, $semana, $dia de $mes de $ano");
?>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title></title>
    <style type="text/css">
        /*#container {*/
            /*border-style: double;*/
            /*border-color: #000080;*/
            /*border-width: thick;*/
        /*}*/

        /*#background {
            width: 100%;
            height: 100%;
            background-image: url("{{ asset('/img/marca_dagua_modelo.png') }}");
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
            background-size: 500px 700px;
            position: absolute;
        }*/
        @media print
        {
            body {font-family:georgia, times, serif;}
        }
        #main {
            margin: 20px;
            font-weight: 500;
            font-family: Arial, Helvetica, sans-serif;
            text-align: justify;
            line-height: 1.4;
        }

        div#rodape {
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        table , tr , td {
            font-size: small;
        }

        #logo{
            width: 70px;
            height: auto;
            margin-left: 293px;
        }
    </style>
</head>

<body>
<div id="background">
</div>

<div id="container">
    <div id="main">
        <div style="margin-right: 500px;">
            <img src="{{ asset('img/logo_modelo.png')  }}" alt="" id="logo">
        </div>
        <br/>
        <center><div style="font-size: 11px; margin-top:10px; margin-bottom: 5px;">
                Credenciada pela Portaria Ministerial n° 2.413 de 11/08/2004 (D.O.U. de 12/08/2004)</br>
                Mantida pelo Instituto Modelo de Ensino Superior Ltda.</br>
                CNPJ: 05.121.388/0001-00</br>
                Centro de Estudos Avançados de Extensão e Pós Graduação – CEA</div></center>
        <br/>
        <center>
            <span><b>DECLARAÇÃO DE VÍNCULO</b></span>
        </center>
        <br/>
        <div style="font-size: 15px;text-indent: 2em; margin-top: 10px;">
            O Centro de Estudos Avançados de Extensão e Pós Graduação da Faculdade Modelo – CEA/PE por competência delegada e amparado:
        </div>
        <div style="font-size: 15px;text-indent: 2em; margin-top: 10px;">
            a) Nota Técnica n° 388/2013 – CGLNRS/DPR/SERES/MEC, de 21 de junho de 2013.
        </div>
        <div style="font-size: 15px;text-indent: 2em; margin-top: 10px;">
            b) Resolução CNE/CES n° 01/2007, n° 04/2011 e n° 07/2011, por dispositivo da Portaria Normativa MEC n° 40/2007, republicada em 29/12/2010.
        </div>
        <div style="font-size: 15px;text-indent: 2em; margin-top: 10px;">
            c) Parecer CNE/CES n° 263/2006.
        </div>

        <p style="font-size: 15px;text-indent: 2em; margin-top: 10px;">
            Declara para os devidos fins que <b>{!! isset($aluno['pessoa']) ? $aluno['pessoa']['nome'] : "" !!}</b>,
            matricula de Nº <b>{!! isset($aluno['matricula']) ? $aluno['matricula'] : "" !!}</b>,
            portadora do CPF: <b>{!! isset($aluno->pessoa['cpf']) ? $aluno->pessoa['cpf'] : "" !!}</b> e
            RG: <b>{!! isset($aluno->pessoa['identidade']) ? $aluno->pessoa['identidade'] : "" !!}</b>
            <b>{!! isset($aluno->pessoa['orgao_rg']) ? $aluno->pessoa['orgao_rg'] : "" !!}</b>,
            está matriculada (o) no Curso de Especialização de
            Pós Graduação LATO SENSU em Educação Inclusiva e Coordenação Pedagógica, ministrado por esta
            Instituição o qual está devidamente registrado no Sistema e-MEC.
            Com carga horária total de 420 horas/aulas, iniciado em 04 de março de 2017 com previsão de término no
            dia, 05 de Maio de 2018. Aulas aos sábados, das 08h às 17h.
        </p>

        <p style="font-size: 15px;text-indent: 2em; margin-top: 10px;">
            O Referido é verdadeiro e dou fé.
        </p>

        <center><p style="font-size: 15px;text-indent: 2em; margin-top: 150px;">
                Luciana Teixeira Vitor<br>
                Gestora do Centro de Estudos Avançados<br>
                De Extensão Pós Graduação<br>
                CEA/PE
            </p></center>

        <div id="rodape" style="position: absolute; bottom: 0; margin-left: auto; margin-right: auto; left: 0; right: 0;">
            <div style="text-align: center; font-size: 11px;">
                <p style="margin: 0;">Rua Engenheiro Benedito Mario da Silva nº 95, Bairro Cajuru</p>
                <p style="margin: 0;">Curitiba – Paraná Te 041 32 26 454 5 – http://www.facimod.com.br/</p>
                <p style="margin: 0;">CEA/PE: Rua Gervásio Pires, 826 – Santo Amaro – Recife/PE</p>
            </div>
        </div>
    </div>
</body>
</html>