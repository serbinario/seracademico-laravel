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

    <body>

        <center><h4>ALPHA BIBLIOTECA / PLANILHA PARA AUTOMAÇÃO DE BIBLIOTECA</h4></center>

        <table style="width: 100%">
            <tr>
                <td colspan="4">
                    <sup><b>Título</b></sup> <br /> {{$result->acervo->titulo}}
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <sup><b>Subtítulo</b></sup> <br /> {{$result->acervo->subtitulo}}
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <sup><b>Assunto</b></sup> <br /> {{$result->acervo->assunto}}
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <sup><b>Cursos</b></sup> <br />           
                    <?php 
                    $flag  = 0;
                    foreach($result->acervo->cursos as $curso){
                        if($flag == 0){
                            echo $curso['nome'];
                            $flag ++;

                        }else{
                            echo ", ".$curso['nome'];
                        }
                        

                    }
                    echo '.';
                    ?>
                </td>
            </tr>
            <tr>
                <td>
                    <sup><b>Volume</b></sup> <br /> {{$result->acervo->volume}}
                </td>
                <td>
                    <sup><b>Cutter</b></sup> <br /> {{$result->acervo->cutter}}
                </td>
                <td>
                    <sup><b>CDD</b></sup> <br /> {{$result->acervo->cdd}}
                </td>
                <td>
                    <sup><b>Tipo de acervo</b></sup> <br /> {{$result->acervo->tipoAcervo->nome}}
                </td>
            </tr>
            <tr>
                <td>
                    <sup><b>Coleção/Série</b></sup> <br /> @if($result->acervo->colecao) {{$result->acervo->colecao->nome}} @endif
                </td>
                <td colspan="3">
                    <sup><b>Situação</b></sup> <br /> {{$result->acervo->situacao->nome}}
                </td>
            </tr>
            <tr>
                <td>
                    <sup><b>Estante/Corredor</b></sup> <br />
                    @if($result->acervo->estante) {{$result->acervo->estante->nome}} / @endif
                    @if($result->acervo->corredor) {{$result->acervo->corredor->nome}} @endif
                </td>
                <td colspan="2">
                    <sup><b>Este livro serve para todos os cursos</b></sup> <br /> @if($result->acervo->uso_global == true) Sim @else Não @endif
                </td>
                <td>
                    <sup><b>Exemplar de referência (Apenas consulta)</b></sup> <br /> @if($result->acervo->exemplar_ref == true) Sim @else Não @endif
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <sup><b>Palavras-chave</b></sup> <br />  {{$result->acervo->palavras_chaves}}
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <sup><b>Notas</b></sup> <br />  {{$result->acervo->resumo}}
                </td>
            </tr>
        </table>

    </body>
    </html>