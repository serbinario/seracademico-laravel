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

<table style="width: 100%">
    <tr>
        <td colspan="5">
            <sup><b>Sumário</b></sup> <br /> {{$result->acervo->sumario}}
        </td>
    </tr>
    <tr>
        <td colspan="4">
            <sup><b>Autores</b></sup> <br />
            @if(count($result->acervo->primeiraEntrada) > 0)
                @if($result->acervo->etial_autor == '1')
                    @if($result->acervo->primeiraEntrada[0]->responsaveis->tipo_reponsavel_id == '1')
                        {{$result->acervo->primeiraEntrada[0]->responsaveis->sobrenome}},
                        <?php echo ucwords(mb_strtolower($result->acervo->primeiraEntrada[0]->responsaveis->nome)) ?> et al
                    @else
                        <?php echo ucwords(mb_strtoupper($result->acervo->primeiraEntrada[0]->responsaveis->nome)) ?> et al
                    @endif
                @else
                    @foreach($result->acervo->primeiraEntrada as $chave => $autor)
                        @if($autor->responsaveis->tipo_reponsavel_id == '1')
                            {{$autor->responsaveis->sobrenome}},
                            <?php echo ucwords(mb_strtolower($autor->responsaveis->nome)); ?> /
                        @else
                            <?php echo  ucwords(mb_strtoupper($autor->responsaveis->nome) ); ?> /
                        @endif
                    @endforeach
                @endif
            @endif
        </td>
    </tr>
    <tr>
        <td colspan="4">
            <sup><b>Outros responsáveis</b></sup> <br />
            @if(count($result->acervo->segundaEntrada) > 0)
                @if($result->acervo->etial_outros == '1')
                    @if($result->acervo->segundaEntrada[0]->responsaveis->tipo_reponsavel_id == '1')
                        {{$result->acervo->segundaEntrada[0]->responsaveis->sobrenome}},
                        <?php echo ucwords(mb_strtolower($result->acervo->segundaEntrada[0]->responsaveis->nome)) ?> et al
                    @else
                        <?php echo ucwords(mb_strtoupper($result->acervo->segundaEntrada[0]->responsaveis->nome)) ?> et al
                    @endif
                @else
                    @foreach($result->acervo->segundaEntrada as $chave => $autor)
                        @if($autor->responsaveis->tipo_reponsavel_id == '1')
                            {{$autor->responsaveis->sobrenome}},
                            <?php echo ucwords(mb_strtolower($autor->responsaveis->nome)) ?> /
                        @else
                             <?php echo ucwords(mb_strtoupper($autor->responsaveis->nome)) ?> /
                        @endif
                    @endforeach
                @endif
            @endif
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <sup><b>ISBN</b></sup> <br /> {{$result->isbn}}
        </td>
        <td>
            <sup><b>Quant.Exempl</b></sup> <br /> {{$qtdExemplar}}
        </td>
        <td>
            <sup><b>Empréstimo</b></sup> <br /> {{$result->emprestimo->nome}}
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <sup><b>Editora</b></sup> <br /> {{$result->editora->nome}}
        </td>
        <td>
            <sup><b>Local</b></sup> <br /> {{$result->local}}
        </td>
        <td>
            <sup><b>Ilustração</b></sup> <br /> {{$result->ilustracoes->nome}}
        </td>
    </tr>
    <tr>
        <td>
            <sup><b>Idioma</b></sup> <br /> {{$result->idioma->nome}}
        </td>
        <td>
            <sup><b>Nº de pág.</b></sup> <br /> {{count($result->acervo->exemplares)}}
        </td>
        <td>
            <sup><b>Aquisição</b></sup> <br /> {{$result->aquisicao->nome}}
        </td>
        <td>
            <sup><b>Data</b></sup> <br />
            <?php
                $data = \DateTime::createFromFormat('Y-m-d', $result->data_aquisicao);
                echo $data->format('d/m/Y');
            ?>
        </td>
    </tr>
    <tr>
        <td colspan="4">
            <sup><b>Registros/Exemplares</b></sup> <br />
            @foreach($result->acervo->exemplares as $exemplar)
                <?php
                    $codigo = str_pad(substr($exemplar->codigo, 0, -4),4,"0",STR_PAD_LEFT);
                    $ano    = substr($exemplar->codigo, -4);
                    $tombo  = $codigo.'/'.$ano;
                ?>
                {{$tombo}}
                    @if($exemplar->ano || $exemplar->edicao) ({{$exemplar->ano}}/{{$exemplar->edicao}}) @endif /
            @endforeach
        </td>
    </tr>
</table>

</body>
</html>