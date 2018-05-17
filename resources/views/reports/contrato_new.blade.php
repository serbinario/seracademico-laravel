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
            font-family: calibri;
            font-size: 14px;
        }
        table{
             
            font-weight: bold;
        }

        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            background: yellow;
        }

        .termos{
            margin-left: 30px;
            text-align: justify;
        }
        .canto {
            position: fixed;
            _position:absolute;
            _margin-right:0;
            right:0;
            z-index:100;
        }
        .yellow{
            background: yellow;
        }

        table { page-break-inside:auto }
        tr    { page-break-inside:avoid; page-break-after:auto }
        thead { display:table-header-group }
        tfoot { display:table-footer-group }
    </style>
    <link href="" rel="stylesheet" media="print">
</head>
<body>

<div class="canto">
    <img style="width: 160px; height: 120px" src="{{asset('/img/dd.jpg')}}">
</div>
<br /><br /><br /><br /><br /><br />
<center><h3>ALPHA SISTEMAS EDUCACIONAL E TREINAMENTOS LTDA - ME</h3></center>

<center>
    <span><u><b>CONTRATO PARTICULAR DE PRESTAÇÃO DE SERVIÇOS EDUCACIONAIS</b></u></span>
</center> <br />

<center><span><u><b>Pós-Graduação “ Lato Sensu ”.</b></u></span></center><br />

<center><span><u><b>Pelo presente instrumento particular de CONTRATO DE PRESTAÇÃO DE SERVIÇOS EDUCACIONAIS</b></u>
         com a <b>ALPHA SISTEMAS EDUCACIONAL E TREINAMENTOS LTDA - ME.</b>. Inscrita no CNPJ de nº 15.708.483/0001-50,
        doravante denominado CONTRATADA, e do outro lado, o abaixo qualificado, doravante denominado de CONTRATANTE,
    </span></center>


<h3><i>01 - Da Identificação do Beneficiário;</i></h3>

<table width="100%" style="background-color: #f1f1f1">
    <tr>
        <td colspan="4">Aluno: {!! isset($aluno['pessoa']) ? $aluno['pessoa']['nome'] : "" !!}</td>
    </tr>
    <tr>
        <td colspan="3">Endereço: {!! isset($aluno['pessoa']['endereco']) ? $aluno['pessoa']['endereco']['logradouro'] : "" !!}</td>
        <td>Número: {!! isset($aluno['pessoa']['endereco']) ? $aluno['pessoa']['endereco']['numero'] : "" !!}</td>
    </tr>
    <tr>
        <td>Apt.: </td>
        <td>Bloco:</td>
        <td colspan="2">Bairro: {!! isset($aluno['pessoa']['endereco']['bairro']) ? $aluno['pessoa']['endereco']['bairro']['nome'] : "" !!} </td>
    </tr>
    <tr>
        <td colspan="2">Cidade: {!! isset($aluno['pessoa']['endereco']['bairro']['cidade']) ? $aluno['pessoa']['endereco']['bairro']['cidade']['nome'] : "" !!} </td>
        <td>UF: {!! isset($aluno['pessoa']['endereco']['bairro']['cidade']['estado']) ? $aluno['pessoa']['endereco']['bairro']['cidade']['estado']['nome'] : "" !!} </td>
        <td>CEP: {!! isset($aluno['pessoa']['endereco']) ? $aluno['pessoa']['endereco']['cep'] : "" !!} </td>
    </tr>
    <tr>
        <td>Tel. Res: {!! isset($aluno['pessoa']['telefone_fixo']) ? $aluno['pessoa']['telefone_fixo'] : "" !!} </td>
        <td colspan="2">Tel.: {!! isset($aluno['pessoa']['celular']) ? $aluno['pessoa']['celular'] : "" !!} </td>
        <td>Tel.: {!! isset($aluno['pessoa']['celular2']) ? $aluno['pessoa']['celular2'] : "" !!} </td>
    </tr>
    <tr>
        <td colspan="4">E-mail: {!! isset($aluno['pessoa']['email']) ? $aluno['pessoa']['email'] : "" !!} </td>
    </tr>
    <tr>
        <td>RG nº: {!! isset($aluno['pessoa']['identidade']) ? $aluno['pessoa']['identidade'] : "" !!} </td>
        <td>Org. Emissor: {!! isset($aluno['pessoa']['orgao_rg']) ? $aluno['pessoa']['orgao_rg'] : "" !!} </td>
        <td>Expedição: {!! isset($aluno['pessoa']['data_expedicao']) ? $aluno['pessoa']['data_expedicao'] : "" !!} </td>
        <td>CPF: {!! isset($aluno['pessoa']['cpf']) ? $aluno['pessoa']['cpf'] : "" !!} </td>
    </tr>
    <tr>
        <td colspan="4">Nome do Pai: {!! isset($aluno['pessoa']['nome_pai']) ? $aluno['pessoa']['nome_pai'] : "" !!} </td>
    </tr>
    <tr>
        <td colspan="4">Nome da Mãe: {!! isset($aluno['pessoa']['nome_mae']) ? $aluno['pessoa']['nome_mae'] : "" !!} </td>
    </tr>
    <tr>
        <td>Estado Civil: {!! isset($aluno['pessoa']['estadoCivil']) ? $aluno['pessoa']['estadoCivil']['nome'] : "" !!} </td>
        <td>Data de Nasc.: {!! isset($aluno['pessoa']['data_nasciemento']) ? $aluno['pessoa']['data_nasciemento'] : "" !!} </td>
        <td>Sexo: {!! isset($aluno['pessoa']['sexo']) ? $aluno['pessoa']['sexo']['nome'] : "" !!} </td>
        <td>Local de Nasc.: {!! isset($aluno['pessoa']['naturalidade']) ? $aluno['pessoa']['naturalidade'] : "" !!} </td>
    </tr>
    <tr>
        <td colspan="3">Área da Pós-Graduação:  </td>
        <td>Ano:  </td>
    </tr>
</table>

<h3><i>02 – Da Prestadora de Serviços:</i></h3>

<p>
    <b><i>ALPHA SISTEMAS EDUCACIONAL E TREINAMENTOS LTDA - ME,</i></b>, Inscrita no CNPJ de nº 15.708.483/0001-50, doravante denominada de CONTRATADA,
    a qual oferece serviços educacionais de (Pós graduação  Lato Sensu)
    a mesma está situada a Rua Gervásio Pires nº826 no Bairro de Santo Amaro na Cidade do Recife no Estado de Pernambuco.
</p>

<h3><i>03 – Da identificação do Curso, Prazo e Duração:</i></h3>
<?php

if(isset($turma->aula_inicio) && isset($turma->aula_final)) {
    $aulaIni = \DateTime::createFromFormat('Y-m-d', $turma->aula_inicio);
    $aulaFim = \DateTime::createFromFormat('Y-m-d', $turma->aula_final);
} else {
    $dataFromat = "";
}
?>
<table style="width: 100%">
    <tr>
        <td><center><b>CURSO Pós-Graduação LATO SENSU em</b></center><br /> {!! isset($curso->nome) ? $curso->nome : "" !!} </td>
        <td><center><b>DURAÇÃO DO CURSO</b></center> <br /> <center>{!! isset($turma->duracao_meses) ? $turma->duracao_meses : "" !!} meses </center> </td>
        <td><center><b>INÍCIO DAS AULAS</b></center> <br /> <?php data($aulaIni->format('d'), $aulaIni->format('m'), $aulaIni->format('Y'), $aulaIni->format('w')); ?> </td>
        <td><center><b>TÉRMINO DAS AULAS</b></center><br /> <?php data($aulaFim->format('d'), $aulaFim->format('m'), $aulaFim->format('Y'), $aulaFim->format('w')); ?> </td>
    </tr>
</table>

<p class="termos">
    <ul> <li><b>O OBJETO</b> – O objeto do presente instrumento é a contratação dos serviços da PRESTADORA DE SERVIÇOS, que se compromete a ministrar aulas dos Cursos de Pós Graduação (lato Sensu), em conformidade com o Curso descrito no quadro <b>03</b>, fornecendo <b>Declaração de Conclusão</b> no final do curso, no prazo máximo de <b>30 dias</b>, ao aluno que obtiver conceito geral mínimo de <b>7 (sete)</b> pontos por módulo, comparecido em pelo menos <b>75% (setenta e cinco por cento)</b> das aulas ministradas, mensalidades em dia, toda documentação entregue, bem como o artigo com o CD. E após 90 dias da entrega da declaração de conclusão será entregue o diploma onde nesta data o aluno deverá assinar o livro ata. Em caso de falta NÃO JUSTIFICADA, o aluno pagará uma taxa de R$ 50,00 (Cinquenta reais) por cada disciplina pendente. Deverá solicitar a secretária acadêmica autorização para cursar tal disciplina. Em caso de falta JUSTIFICADA, o aluno deverá entregar por via requerimento uma cópia do atestado na secretária e pegar autorização para cursar a disciplina em outra turma entregando o mesmo ao professor da disciplina pendente. Para os cursos de Psicopedagogia e Neuropsicopedagogia se faz necessária terapia pessoal, o aluno, antes de cursar a parte clínica deverá constar em sua pasta na secretária acadêmica um parecer do Psicólogo. O Ingresso no Estágio Clínico referente aos cursos de Psicopedagogia e Neuropsicopedagogia só será permitido com todas as disciplinas cursadas.
</li></ul>
</p>

<?php

use Seracademico\Uteis\Monetary;

$valorCurso = number_format($turma->valor_turma * ($turma->qtd_parcelas + 1), 2, ',', '.');
$valorCurso2 = number_format($turma->valor_turma * ($turma->qtd_parcelas + 1), 2, '.', '');
$numeroTxt = Monetary::numberToExt($valorCurso2);
$parcelasTxt = Monetary::numberToExt2($turma->qtd_parcelas);
?>

<p class="termos">
    <?php $vencimento = $aluno['data_matricula'] ? \DateTime::createFromFormat('d/m/Y', $aluno['data_matricula']) : null;?>

    1. <b>DO INVESTIMENTO E FORMA DE PAGAMENTO</b>&nbsp;&nbsp;&nbsp; Como contraprestação dos serviços educacionais, acima referidos,
    será cobrado do CONTRATANTE um investimento de R$ <span class="yellow">{{$valorCurso}} ({{$numeroTxt}}),
    dividido em 1+ {{$turma->qtd_parcelas}} ({{$parcelasTxt}}) parcelas iguais mensais de R$ {{$turma->valor_turma}}
    com vencimento todo dia {{ isset($vencimento) ? ((int) $vencimento->format('d')) >=16 ? 30 : 15 : "" }} de cada mês.
    As parcelas podem variar de acordo com cada curso. A matricula só será <b>devolvida</b> caso não forme turma</span>
</p>

<p class="termos">
     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>DOS SERVIÇOS NÃO INCLUSOS NO PREÇO DO INVESTIMENTO</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Não estão incluídos neste Contrato os serviços especiais e as taxas escolares abaixo citados:

<ul>
<li>Declaração de Conclusõ de Curso será cobrado uma taxa de R$ 5,00 (Cinco Reais), </li>
<li>Certidão de Conclusão de Curso (documento provisório), será cobrado uma taxa de R$ 10,00 (dez reais) até o prazo para entrega do original, que são de 90 dias após a entrega do TCC. Caso esse prazo se estenda, a Faculdade Alpha não poderá cobrar pela Certidão.</li>
<li>HISTÓRICO DE NOTAS impresso, terá uma taxa de R$ 15,00 (quinze reais). O mesmo estará disponivel no site <span style="color: blue;"><u>www.alpha.rec.br</u></span> gratuitamente. O login e a senha é o numero de sua matricula que consta na declaração de vínculo.</li>
<li>2ª VIA DE DECLARAÇÃO DE VÍNCULO, terá uma taxa de R$ 15,00 (quinze reais). A primeira via é gratuita, esta será entregue anual.</li>
<li>2ª VIA DE CARNÊ DE MENSALIDADES, terá uma taxa de R$ 10,00 (dez reais)</li>

Qualquer SOLICITAÇÃO terá um prazo de entrega de 7 (sete) dias úteis</ul></p>

<p class="termos">
    2. <b>A CARGA HORÁRIA</b>&nbsp;, sua distribuição mensal, o horário das aulas e o prazo de duração do curso encontram-se especificados no quadro <b>03.</b>
    A data do termino do Curso poderá ser prorrogada por motivos de força maior ou por
    eventuais ocorrências geradas no decorrer do Curso descrito no campo <b>03,</b>
    o qual concorda expressamente o aluno, desde que justificado pela Prestadora de Serviços.
</p>

<p class="termos">
    3. <b>Fica a critério da PRESTADORA DE SERVIÇO </b>&nbsp;&nbsp; a decisão de suspender o Curso a ser iniciado caso não haja o
    preenchimento de <b>70% (sententa por cento)</b> da capacidade de alunos por turma ou remanejar a data de início escolhida pelo aluno (a),
    mediante acordo entre ambas as partes. Caso o aluno não aceite a mudança o mesmo terá direito a devolução do valor da matrícula.
</p>
<p class="termos">
    4. <b>VALOR E PAGAMENTO </b>&nbsp; – O Preço dos Serviços ora contratados, bem como o número de mensalidades e data do vencimento ficará especificado na data da Matrícula, ficando ao aluno, o pagamento através das condições escolhidas no ato da assinatura do presente contrato. Caso seja escolhida a modalidade do pagamento parcelado, será confeccionado carnê de pagamento com a quantidade de mensalidades a serem pagas, o carnê será entregue ao aluno no seu 1º dia de aula, as mensalidades deverão ser pagas no setor financeiro da prestadora de serviços. O desconto que for concedido ao aluno será respeitado desde que, a data do vencimento seja obedecida.<br> <br> 

&nbsp;&nbsp;&nbsp;&nbsp;O Pagamento com desconto só será feito até o vencimento. Reforçamos a informação que o desconto é dado até o vencimento e esta informação consta no corpo do boleto, redobrem a atenção no ato do pagamento, avisando ao operador do caixa o seu desconto, para que não seja cobrado o valor integral do curso. A Instituição não se responsabilizará pelo ressarcimento de boletos pagos erroneamente. Após a data de vencimento será cobrado o valor do curso sem desconto, mais 0,33% de juros diários e 2% de multa.
</p>

<p class="termos">
    5. <b>ATRASO(S) DA(S) MENSALIDADE(S) </b>&nbsp;&nbsp;&nbsp; – O atraso ou não pagamento das mensalidades, resultarão em perda do desconto promocional, mais multa de 2% (dois por cento) sobre a importância devida acrescida de 1% (um por cento) ao mês mais correção com base no IGPM (FGV) sendo que o recebimento da determinada parcela não significará quitação das anteriores. Em caso de mudança na politica financeira nacional convenciona as partes que a presente cláusula será revista e fixado um novo parâmetro para o cálculo da atualização monetária.
</p>

<p class="termos">
    6. <b>PERCA DO CARNÊ </b>&nbsp; – O aluno que perde o carnê deverá solicitar segunda via através de requerimento à prestadora de serviço, mediante pagamento de uma taxa no valor de R$ 15,00.

         <pre>        - Pagamento realizado através de recibo, será acrescido uma taxa de (R$ 5,00) sobre o valor da mensalidade
        - Pagamento através de cartão de crédito ou débito o aluno perde o desconto, assim o valor será cheio sem desconto promocional (Desconto promocional apenas para mensalidades pagas em dinheiro na data do vencimento no setor financeiro da prestadora de serviços). 
        - A data de vencimento não poderá ser alterada uma vez que a data e automática do sistema. 
        - Após a matricula realizada, o carnê ficará disponivel para ser retirado no setor financeiro.
        - Em caso de 2º lote de carnê, o mesmo será retirado no setor financiero.
        - Boleto em atraso, o aluno poderá pagar no banco de oriegem ou na Instituição.
        - Boleto a vencer, o aluno deverá pagar no banco ou lotérica direto no caixa.
        - Pagamentos online, o aluno precisa digitar o valor com descontor (descrito no corpo do     boleto).
        - Pagamento efetuado erroneamente é de inteira responsabilidade do aluno
        - As datas de vencimento são corridas, ou seja, independente do aluno vir à aula ou não. O setor financeiro NÃO envia boleto por e-mail.</pre>
</p>

<p class="termos">
    7. <b>TRANCAMENTO </b>&nbsp; – Caso precise, o aluno poderá solicitar através de requerimento o trancamento do seu curso,
    o mesmo deverá está com as mensalidades em dia e pagar uma taxa no valor de R$ 30,00,
    o trancamento terá a duração de um ano a contar da data da assinatura do requerimento,
    após este prazo o aluno deverá comparecer a prestadora de serviços para formalizar a sua situação,
    no caso de não comparecimento o aluno autoriza a prestadora a encaminhar o débito ao Cartório de Protesto,
    bem como proceder ao registro do débito junto ao serviço de Proteção ao Crédito – SPC e Serasa, ficando a
    critério da PRESTADORA DE SERVIÇOS, rescindir o presente contrato
</p>
<p class="termos">
    8. <b>CANCELAMENTO</b> – Caso precise, deverá estar com as mensalidades em dia, não precisará pagar taxa, porem perderá todas as disciplinas cursadas.
</p>
<p class="termos">
    9. <b>ABANDONO</b> – Em casos de abandono de curso, será cancelado o curso a partir da quarta mensalidade em aberto. Caso queira retornar ao curso, o aluno solicitará na secretária da Pós-Graduação uma reintegração ao curso e pagará nova matricula para ter vínculo novamente com a IES.
</p>

<p class="termos">
    10. <b>DESISTÊNCIA  </b>&nbsp; O aluno poderá desistir do presente contrato no prazo de 7 (sete) dias a contar de sua assinatura e os valores
    eventualmente pagos serão devolvidos. A desistência após este prazo deverá ser solicitada por escrito,
    com 30 (trinta) dias de antecedência, condicionada ao pagamento da multa rescisória equivalente ao valor de 1 (uma)
    mensalidade vincenda sem o <b>DESCONTO PROMOCIONAL</b> , sendo assim, valor da <b>MENSALIDADE CHEIA</b>, e deverá estar em dia com os pagamentos contratados.
</p>

<p>
    <b>Parágrafo Único:</b>&nbsp; Caso o pedido de desistência previsto nesta cláusula não seja formalizado,
    o contrato continuará em vigor e a Contratante deverá pagar todas as parcelas previstas no ato da inscrição,
    podendo a primeira parte Contratada tomar medidas cabíveis de cobrança.
</p>

<p class="termos">
    11. <b>INADIMPLÊNCIA  </b>&nbsp; – O aluno desde já, autoriza a PRESTADORA DE SERVIÇOS em caso de Inadimplência,
    a emitir a Duplicata de Prestação de Serviços com o vencimento a vista e enviar ao Cartório de Protesto,
    bem como proceder ao registro do débito junto ao serviço de Proteção ao Crédito – SPC e Serasa,
    ficando a critério da PRESTADORA DE SERVIÇOS, rescindir o presente contrato nos casos de Inadimplência superior a 60 (sessenta) dias
</p>

<p class="termos">
    12. Sempre que a <b>Contratante</b>&nbsp; mudar de endereço deverá comunicar de imediato por escrito as <b>Contratadas</b>,
    sob pena de terem-se como válidas e eficazes todas as correspondências enviadas pelas <b>Contratadas</b> para endereço anterior,
    constante deste contrato.
</p>

<p>
    <b>Parágrafo Primeiro:</b>&nbsp; A <b>Contratante</b> deverá possuir um endereço eletrônico permanente para contato com as <b>Contratadas</b> e
    com o (s) professor (s). É de total responsabilidade da <b>Contratante</b> adquirir e informar um endereço eletrônico as <b>Contratadas</b>,
    não importando os meios pelos quais irá adquiri-lo.
</p>

<p>
    <b>Parágrafo Segundo:</b>&nbsp; A <b>Contratante</b> autoriza a divulgação de sua imagem nas propagandas da instituição.
</p>

<p class="termos">
    13. <b>DANOS </b>&nbsp; – O aluno que danificar bens móveis, equipamentos ou mesmo o prédio  da PRESTADORA DE SERVIÇO,&nbsp;&nbsp;
    deverá ressarcir em dinheiro o dano ou repor os bens danificados por outros equivalentes ou de mesma qualidade
    e uma vez apurado por ele causado e não havendo ressarcimento ou reposição do bem danificado, fica autorizado a
    PRESTADORA DE SERVIÇOS, a qualquer tempo, a propositura das ações cabíveis para a satisfação de seu prejuízo e a rescisão contratual.
</p>

<p class="termos">
    14. <b>RESCISÃO CONTRATUAL </b>&nbsp; – Constitui em causa para a rescisão contratual, além do constante na cláusula <b>9</b>,
    o descumprimento de qualquer cláusula contratual, sendo ainda rescindido o contrato uma vez provado por declarações de terceiros,
    atos de indisciplina do aluno.
</p>

<p class="termos">
    15. <b>TOLERÂNCIA </b>&nbsp; – A tolerância da PRESTADORA DE SERVIÇOS ou do aluno não significará renúncia, perdão, renovação ou alteração do que foi contratado.
</p>

<p class="termos">
    16. <b>FORO </b>&nbsp; – As partes elegem o foro desta comarca como o único competente para dirimir qualquer questão oriunda do presente contrato,
    em detrimento de qualquer outro, por mais privilegiado que possa ser.<br />
    E por estarem justas e contratadas, as partes firmam o presente contrato em 02 (duas) vias de igual teor,
    subscritos pelas testemunhas abaixo nomeadas, declarando ainda o aluno/responsável legal haver lido e
    entendido todas as cláusulas do presente contrato, estabelecendo as partes, ao presente contrato, pela eficácia e
    força executiva e força executiva extrajudicial.
</p> <br /><br />

<center>
    <span class="yellow" style="display: inline-block; width: 100%;text-align: center;">
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
<br /><br />

<div>
    <div style="text-align: center;"> <!-- position: absolute; margin-top: -85px; margin-left: 30%; -->
        <img style="width: 35%;" src="{{ asset('img/assinatura_luciana_edit.png')  }}" alt="">
    </div>
</div>
</body>
</html>