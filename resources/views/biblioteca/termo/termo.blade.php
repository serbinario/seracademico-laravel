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
            font-size: 11px;
        }

        .termos {
            font-size: 11px;
        }

        .table, .table th, .table td {
            border: 1px solid black;
            border-collapse: collapse;
            font-size: 11px;
        }

        .termos{
            margin-left: 30px;
            text-align: justify;
        }
        .canto {
            position: fixed;
            _position:absolute;
            _margin-left:0;
            left:0;
            z-index:100;
        }

        .table { page-break-inside:auto }
        .table tr    { page-break-inside:avoid; page-break-after:auto }
        .table thead { display:table-header-group }
        .table tfoot { display:table-footer-group }
    </style>
    <link href="" rel="stylesheet" media="print">
</head>
<body>

<div class="canto">
    <img style="width: 145px; height: 120px" src="{{asset('/img/logo_biblioteca_alpha.png')}}">
</div>
<br /><br /><br /><br /><br /><br />
<center><h3>BIBLIOTECA SUELANDRE GONSALVES LIMA<br />
        TERMO DE COMPROMISSO<br />
        USUÁRIO DA BIBLIOTECA </h3>
</center>

<table class="table" width="100%" style="background-color: #f1f1f1">
    <tr>
        <td><b>Nome:</b> {{$dados->nome}}</td>
        <td><b>Telefone:</b> {{$dados->celular}}</td>
    </tr>
    <tr>
        <td colspan="2"><b>Endereço:</b> {{$dados->logradouro}}</td>
    </tr>
    <tr>
        <td><b>Código da matrícula:</b>  @if(isset($dados->matricula)) {{$dados->matricula}} @endif</td>
        <td><b>E-mail:</b>  {{$dados->email}}</td>
    </tr>
</table>

<h5><b>NORMAS</b></h5>

<p class="termos">
    O Usuário ao se cadastrar, terá que cumprir as seguintes normas: 1)
    Assumir inteira responsabilidade de quaisquer materiais que façam parte do acervo da biblioteca, sejam estes livros,
    revistas, monografias, teses, referências ( livro de consulta ), CDs, DVDs, outros, quando de posse destes; 2 )
    Se danificar ou extraviar qualquer material do acervo da biblioteca,
    <b>o usuário terá que repor o referido item, entregando o material novo e com nota fiscal. Quando a obra possuir
        qualificação e quantidade específica, tornando-se infugível, o usuário deverá devolver a obra de igual qualidade
        e quantidade, estas que assumam a identidade e as características do material extraviado.
        3) O aluno tem o compromisso de informar, caso mude de endereço, telefone ou e-mail e atualizar seus dados o mais breve possível</b>
</p>

<h5><b>EMPRÉSTIMO</b></h5>

<p class="termos">
    1)	Apenas os livros sairão para empréstimo (até que esteja inserido no programa e até a presente data);<br />
    2)	O usuário que não for aluno da ALPHA, não poderá pegar livros para empréstimo e nem consulta;<br />
    3)	Aluno da graduação poderá pegar até 02 (dois) livros, durante 08 (oito) dias;<br />
    4)	Professor poderá pegar até 03 (três) livros, durante 12 (doze) dias;<br />
    5)	Aluno de pós-graduação poderá pegar 03 (três) livros e a consulta será apenas do livro na biblioteca;<br />
    6)	Funcionário poderá pegar até 03 (três) livros, durante 12 (doze) dias;<br />
    7)	O aluno que desistir ou trancar o curso, não poderá pegar livros para empréstimo (terá que devolver caso tenha algum emprestado);<br />
    8)	O empréstimo não poderá ser realizado por terceiros;
</p>

<h5><b>RENOVAÇÃO</b></h5>

<p class="termos">
    1)	O usuário poderá renovar o livro quantas vezes quiser, desde que o livro não esteja na reserva.
    A renovação só será feita na biblioteca e também não poderá ser realizada por terceiros.
</p>

<h5><b>DEVOLUÇÃO</b></h5>

<p class="termos">
    1)	A devolução poderá ser feita por terceiros.
</p>

<h5><b>CONSULTA</b></h5>

<p class="termos">
    1)	Revista, jornais, CDs, DVDs, livros de referência (dicionários, enciclopédias) e livros <b>com tarja vermelha,
    são para consulta exclusiva na biblioteca (consulta especial);</b><br />
    2)	A consulta especial é aquela da qual o usuário só poderá consultar o livro na Biblioteca ou áreas da Faculdade,
    tendo o compromisso de devolver o livro antes que encerre o expediente,
    ou então terá que pagar uma multa de <b>R$ 10,00 (vinte reais) p/ dia e p/ livro.</b>
</p>

<h5><b>MULTA</b></h5>

<p class="termos">
    O usuário: aluno de graduação, aluno de pós-graduação, professor e funcionário que não devolver ou renovar o livro na data prevista,
    pagará multa <b> de R$ 2,50 (cinco reais )</b> por livro/dia de atraso, incluindo sábados, domingos e feriados, reajustada anualmente,
    a partir de 2018. <b>Só serão abonadas as multas em caso de doença mediante apresentação de atestado médico;</b><br />
    1)	O usuário que estiver em débito e/ou pendência com a biblioteca, ou qualquer outro setor acadêmico,
    não poderá fazer empréstimo de livros, matrícula, trancamento, licença, outros Os que abandonarem o curso e não
    devolverem o livro será cobrado em protesto.
</p >

<h5><b>RESERVA</b></h5>

<p class="termos">
    O usuário só poderá fazer reserva, quando todos os exemplares dos livros desejados estiverem fora da biblioteca.
    Se o usuário estiver com o livro emprestado, não poderá fazer reserva deste; A quantidade dos livros para reserva,
    será a mesma do empréstimo e suas categorias correlatas (aluno de graduação, pós-graduação, professor e funcionário).
</p>


{{--<p>
    <b>Parágrafo Único:</b>&nbsp; Caso o pedido de desistência previsto nesta cláusula não seja formalizado,
    o contrato continuará em vigor e a Contratante deverá pagar todas as parcelas previstas no ato da inscrição,
    podendo a primeira parte Contratada tomar medidas cabíveis de cobrança.
</p>--}}
<br /><br />

<center>
    <table border="0" style="border: none; width: 100%">
        <tr>
            <td style="width: 90%; font-size: 11px;">
                Como usuário, estou ciente, concordo e firmo o meu compromisso com a biblioteca.
            </td>
            <td style="font-size: 11px;">
                Data:___/___/_____
            </td>
        </tr>
    </table>
</center><br /><br />

<center>
    <table border="0" style="border: none; width: 100%">
        <tr>
            <td style="width: 50%; font-size: 11px;">
                <center> ___________________________________________________<br>
                Documento do usuário</center>
            </td>
            <td style="width: 50%; font-size: 11px;">
                <center>
                    <br />___________________________________________________<br>

                    Miriam P. W. de Medeiros<br />
                    Bibliotecária CRB-4/1183
                </center>
            </td>
        </tr>
    </table>
</center>
<br /><br />

<center>
    <span>
        _________________________________________________<br />
        Luciana Vítor – Diretora da Alpha Faculdade
    </span>
</center>


</body>
</html>