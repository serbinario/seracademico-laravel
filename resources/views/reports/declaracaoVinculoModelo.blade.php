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
        #container {
            border-style: double;
            border-color: #000080;
            border-width: thick;
        }

        #background {
            width: 100%;
            height: 100%;
            background-image: url("{{ asset('/img/marca_dagua_modelo.png') }}");
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
            background-size: 500px 700px;
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
    </style>
</head>

<body>
    <div id="background">
    </div>

    <div id="container">
        <div id="main">
            <div style="margin-right: 500px;">
                <img src="{{ asset('img/logo_modelo.png')  }}" alt="">
            </div>
            <center><h4 style="margin-top:10px; margin-bottom: 5px;">FACULDADE MODELO - FACIMOD</h4></center>

            <center><h4 style="margin-top: 5px; margin-bottom: 20px;">Credenciada pela Portaria Ministerial nº 2.413</h4></center>

            <center>
                <span><b>DECLARAÇÃO DE VÍNCULO</b></span>
            </center>

            <br />

            <p style="font-size: 20px;text-indent: 2em; margin-top: 10px;">
                Declaramos, para os devidos fins de direito, que <b>{!! isset($aluno['pessoa']) ? $aluno['pessoa']['nome'] : "" !!}</b>,
                matrícula nº <b>{!! isset($aluno['matricula']) ? $aluno['matricula'] : "" !!}</b> está regulamente matriculado (a)
                nesta Instituição de Ensino Superior, no curso de Pós-graduação “Lato Sensu”, em ESPECIALIZAÇÃO EM
                <b>{!! isset($curso->nome) ? $curso->nome : "" !!}</b>, realizado e certificado pela Faculdade Modelo - FACIMOD
                de acordo com a portaria de credenciamento do MEC de n° 2.413 de 11/08/2004.
            </p>

            <p style="font-size: 20px;text-indent: 2em;">
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

            <div id="rodape">
                <p style="text-indent: 2em;">
                    O referido é verdadeiro e dou fé.
                </p>
                <br />

                <div style="position: absolute; margin-top: -20px; margin-left: 30%;">
                    <img width="200px" height="200px" src="{{ asset('img/assinatura_luciana.png')  }}" alt="">
                </div>

                <center>
                    <span>
                        Recife, <?php $data = new \DateTime('now'); data($data->format('d'), $data->format('m'), $data->format('Y'), $data->format('w')); ?>
                    </span>
                </center>

                <center>
                    <p style="margin-top: 60px;">
                        Secretária Acadêmica
                    </p>
                </center>

                <div id="rodape" style="margin-top: 50px;">
                    <div style="text-align: center; font-size: 11px;">
                        <p style="margin: 0;"><b>Faculdade Modelo - FACIMOD.</b></p>
                        <p style="margin: 0;">Credenciada pela Portaria Ministerial n° 2.413 de 11/08/2004 (D.O.U. de 12/08/2004).</p>
                        <p style="margin: 0;">Mantida pelo  Instituto Modelo de Ensino Superior Ltda.</p>
                        <p style="margin: 0;">CNPJ: 05.121.388/0001-00</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>