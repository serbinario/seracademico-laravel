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

$dataEmissao = new \DateTime('now');
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

        #background {
            width: 100%;
            height: 100%;
            background-image: url("{{ asset('/img/marca_dagua_logo-alpha-b.png') }}");
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
            background-size: 700px 400px;
            position: absolute;
        }
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
        <div>
            <img style="margin-right: 330px; height: 100px; width: auto;" src="{{ asset('img/logo-alpha.png')  }}" alt="" id="logo">
        </div>
        <br/>
        <center><div style="font-size: 22px; margin-top:10px; margin-bottom: 5px;">
                Faculdade Alpha</br>
                Credenciada pela Portaria Ministerial n° 1.248</div></center>
        <br/>

        <center style="margin-top: 8%;">
            <span><b>DECLARAÇÃO DE VÍNCULO</b></span>
        </center>
        <br/>
        <div style="font-size: 20px;text-indent: 2em; margin-top: 10px;">
            <div>
                Declaramos, para os devidos fins de direito, que <b>{!! isset($aluno['pessoa']) ? $aluno['pessoa']['nome'] : "" !!}</b>,
                matricula de Nº <b>{!! isset($aluno['matricula']) ? $aluno['matricula'] : "" !!}</b>, está regulamente
                matriculado (a) nesta Instituição de Ensino Superior, no curso de Pós-Graduação “Lato Sensu”, em
                <b>{{ $curso->nome }}</b>, realizado e certificado pela Faculdade Alpha de acordo com a portaria de
                credenciamento do MEC de n° 1.248 de 29/09/2017.
            </div>
            <div>
                O curso de Pós-Graduação atendeu ao disposto na Resolução CES/CNE-MEC Nº 01 de 2007, com carga horária total
                de {!! isset($curso->carga_horaria) ? $curso->carga_horaria : "" !!} horas/aula, iniciado no dia
                {{ strftime('%d de %B de %Y', strtotime($turma->aula_inicio)) }}
                com previsão de término no dia {{ strftime('%d de %B de %Y', strtotime($turma->aula_final)) }}.
                Aulas aos sábados, das 08:00 às 17:00 horas.
            </div>
            <div>
                O referido é verdadeiro e dou fé.
            </div>
            <div style="margin-top: 70px; margin-left: 450px;">
                Data Emissão: {{ $dataEmissao->format('d/m/Y') }}
            </div>
        </div>

        <center>
            <div style="margin-top: 130px;">
                <h1 style="position: absolute; left: 0; right: 0; top: 740px;"><img width="320px;" src="{{ asset('img/assinatura_luciana.png') }}" alt=""></h1>
                <p style="font-size: 17px;">
                    Diretora Geral
                </p>
            </div>
        </center>

        <div id="rodape" style="position: absolute; bottom: 0; margin-left: auto; margin-right: auto; left: 0; right: 0;">
            <div style="text-align: center; font-size: 11px;">
                <p style="margin: 0;">FACULDADE ALPHA</p>
                <p style="margin: 0;">Credenciada pela Portaria Ministerial n° 1.248 de 29/09/2017</p>
                <p style="margin: 0;">Mantida pela Alpha Sistemas Educacionais e Treinamentos - EIRELI.</p>
                <p style="margin: 0;">CNPJ: 15.708.483/0001-50</p>
            </div>
        </div>
    </div>
</div>
</body>
</html>