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
    <style type="text/css" class="init">

        body {
            font-family: arial;
        }
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        table , tr , td {
            font-size: small;
        }
    </style>
    <link href="" rel="stylesheet" media="screen">
</head>

<table style="border: none;" id="topo" class="topo"  width="100%">
    <tr style="border: none">
        <td style="border: none; font-size: medium"><center>
                {{--@if(isset($aluno['img']))
                    <img src="{{asset('/uploads/fotos/'.$aluno['img'])}}" alt="Foto"  height="100" width="150">
                @endif--}}
            </center></td>
        <td style="border: none; font-size: medium">
            <center><h4>ALPHA EDUCAÇÃO E TREINAMENTOS</h4></center>
        </td>
        <td style="border: none; font-size: medium">
            <center><h4>Portaria n° 59 de 19/01/2011 – CNPJ nº 05.783.107/0001-77</h4></center>
        </td>
        <td style="border: none; font-size: medium">
            <center>
                <span>CONTRATO</span>
            </center>
        </td>
    </tr>
</table>
<br />

<p>
    Declaramos, para os devidos fins de direito, que DORIVALDO RAMOS
    BEZERRA JUNIOR, matrícula nº 201611447 está regulamente matriculado (a)
    nesta Instituição de Ensino Superior, FASUP – Faculdade de Saúde de
    Paulista no curso de Pós-graduação “Lato Sensu”, ESPECIALIZAÇÃO EM
    GESTÃO DE PESSOAS/RH, realizado e certificado pela Faculdade FASUP (
    Faculdade de Saúde de Paulista ), de acordo com a portaria de
    credenciamento do MEC de n° 59 de 19/01/2011.
</p>

<p>
    O curso de Pós-Graduação atendeu ao disposto na Resolução CES/CNE-
    MEC Nº 01 de 2007, com carga horária total de 420horas/aula, iniciado no dia
    05 de Março de 2016 com previsão de término no dia 06 de Maio de 2017.
    Aulas aos sábados, das 08:00 às 17:00 horas.
</p>

<p>
    O referido é verdadeiro e dou fé.
</p>
<br />

<center>
    <span>
        <?php
            if(isset($aluno['data_contrato'])) {
                $dataContrato = $aluno['data_contrato'];
            } else {
                $dataContrato = "";
            }
        ?>
        Recife, <?php data($dataContrato->format('d'), $dataContrato->format('m'), $dataContrato->format('Y'), $dataContrato->format('w')); ?>
    </span>
</center>

<p>
    Secretária Acadêmica
</p>

<p>
    Credenciada pelo MEC, Portaria nº 59 de 19/01/2011, publicada no DOU em 20/01/2011.
    Av. Dr. Rodolfo Aureliano, 2182, Vila Torres Galvão – 53430-740 - Paulista-PE.
    81-4101- 1117 - www.fasup.com
</p>

</body>
</html>