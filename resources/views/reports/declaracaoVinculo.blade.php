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

<center><h4>ALPHA EDUCAÇÃO E TREINAMENTOS</h4></center>

<center><h4>Portaria n° 59 de 19/01/2011 – CNPJ nº 05.783.107/0001-77</h4></center>

<center>
    <span>DECLARAÇÃO DE VÍNCULO</span>
</center>

<br />

<p style="font-size: 20px">
    Declaramos, para os devidos fins de direito, que {!! isset($aluno['pessoa']) ? $aluno['pessoa']['nome'] : "" !!},
    matrícula nº {!! isset($aluno['matricula']) ? $aluno['matricula'] : "" !!} está regulamente matriculado (a)
    nesta Instituição de Ensino Superior, ALPHA – ALPHA EDUCAÇÃO E TREINAMENTOS no curso de Pós-graduação “Lato Sensu”, ESPECIALIZAÇÃO EM
    {!! isset($curso->nome) ? $curso->nome : "" !!}, realizado e certificado pela Faculdade ALPHA (
    ALPHA EDUCAÇÃO E TREINAMENTOS ), de acordo com a portaria de
    credenciamento do MEC de n° {!! isset($curso->portaria_mec_rec) ? $curso->portaria_mec_rec : "" !!} de
    <?php $data_rec = \DateTime::createFromFormat('Y-m-d', $curso->data_dou_rec);  ?>{{$data_rec->format('d/m/Y')}}.
</p>

<p style="font-size: 20px">
    <?php

    if(isset($turma->aula_inicio) && isset($turma->aula_final)) {
        $aulaIni = \DateTime::createFromFormat('Y-m-d', $turma->aula_inicio);
        $aulaFim = \DateTime::createFromFormat('Y-m-d', $turma->aula_final);
    } else {
        $dataFromat = "";
    }
    ?>
    O curso de Pós-Graduação atendeu ao disposto na Resolução CES/CNE-
    MEC Nº 01 de 2007, com carga horária total de {!! isset($curso->carga_horaria) ? $curso->carga_horaria : "" !!}horas/aula, iniciado no dia
        <?php data($aulaIni->format('d'), $aulaIni->format('m'), $aulaIni->format('Y'), $aulaIni->format('w')); ?> com previsão de término no dia
        <?php data($aulaFim->format('d'), $aulaFim->format('m'), $aulaFim->format('Y'), $aulaFim->format('w')); ?>.
    Aulas aos sábados, das 08:00 às 17:00 horas.
</p>

<p>
    O referido é verdadeiro e dou fé.
</p>
<br />

<center>
    <span>
        Recife, <?php $data = new \DateTime('now'); data($data->format('d'), $data->format('m'), $data->format('Y'), $data->format('w')); ?>
    </span>
</center>

<center>
    <p>
        Secretária Acadêmica
    </p>
</center>

<p>
    Credenciada pelo MEC, Portaria nº 59 de 19/01/2011, publicada no DOU em 20/01/2011.
    Av. Dr. Rodolfo Aureliano, 2182, Vila Torres Galvão – 53430-740 - Paulista-PE.
    81-4101- 1117 - www.fasup.com
</p>

</body>
</html>