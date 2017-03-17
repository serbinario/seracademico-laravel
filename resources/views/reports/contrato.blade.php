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
            font-size: 15px;
        }

        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
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
<center><h3>ALPHA EDUCAÇÃO E TREINAMENTOS</h3></center>

<center>
    <span><u>CONTRATO PARTICULAR DE PRESTAÇÃO DE SERVIÇOS EDUCACIONAIS</u></span>
</center> <br />

<center><span><u>Pós-Graduação “Lato Sensu”</u></span></center><br />

<center><span><u>Pelo presente instrumento particular de CONTRATO DE PRESTAÇÃO DE SERVIÇOS EDUCACIONAIS</u>
        com a <b><u>ALPHA EDUCAÇÃO E TREINAMENTOS</u></b>. Inscrita no CNPJ de nº 22.945385/0001-00, doravante denominado CONTRATADA,
        e do outro lado, o abaixo qualificado, doravante denominado de CONTRATANTE,
    </span></center>


<h5><i>01 - Da Identificação do Beneficiário;</i></h5>

<table width="100%" style="background-color: #f1f1f1">
    <tr>
        <td colspan="4"><b>Aluno:</b> {!! isset($aluno['pessoa']) ? $aluno['pessoa']['nome'] : "" !!}</td>
    </tr>
    <tr>
        <td colspan="3"><b>Endereço:</b> {!! isset($aluno['pessoa']['endereco']) ? $aluno['pessoa']['endereco']['logradouro'] : "" !!}</td>
        <td><b>Número:</b> {!! isset($aluno['pessoa']['endereco']) ? $aluno['pessoa']['endereco']['numero'] : "" !!}</td>
    </tr>
    <tr>
        <td><b>Apt.:</b> </td>
        <td><b>Bloco:</b></td>
        <td colspan="2"><b>Bairro:</b> {!! isset($aluno['pessoa']['endereco']['bairro']) ? $aluno['pessoa']['endereco']['bairro']['nome'] : "" !!} </td>
    </tr>
    <tr>
        <td colspan="2"><b>Cidade:</b> {!! isset($aluno['pessoa']['endereco']['bairro']['cidade']) ? $aluno['pessoa']['endereco']['bairro']['cidade']['nome'] : "" !!} </td>
        <td><b>UF:</b> {!! isset($aluno['pessoa']['endereco']['bairro']['cidade']['estado']) ? $aluno['pessoa']['endereco']['bairro']['cidade']['estado']['nome'] : "" !!} </td>
        <td><b>CEP:</b> {!! isset($aluno['pessoa']['endereco']) ? $aluno['pessoa']['endereco']['cep'] : "" !!} </td>
    </tr>
    <tr>
        <td><b>Tel. Res:</b> {!! isset($aluno['pessoa']['telefone_fixo']) ? $aluno['pessoa']['telefone_fixo'] : "" !!} </td>
        <td colspan="2"><b>Tel.:</b> {!! isset($aluno['pessoa']['celular']) ? $aluno['pessoa']['celular'] : "" !!} </td>
        <td><b>Tel.:</b> {!! isset($aluno['pessoa']['celular2']) ? $aluno['pessoa']['celular2'] : "" !!} </td>
    </tr>
    <tr>
        <td colspan="4"><b>E-mail:</b> {!! isset($aluno['pessoa']['email']) ? $aluno['pessoa']['email'] : "" !!} </td>
    </tr>
    <tr>
        <td><b>RG nº:</b> {!! isset($aluno['pessoa']['identidade']) ? $aluno['pessoa']['identidade'] : "" !!} </td>
        <td><b>Org. Emissor:</b> {!! isset($aluno['pessoa']['orgao_rg']) ? $aluno['pessoa']['orgao_rg'] : "" !!} </td>
        <td><b>Expedição:</b> {!! isset($aluno['pessoa']['data_expedicao']) ? $aluno['pessoa']['data_expedicao'] : "" !!} </td>
        <td><b>CPF:</b> {!! isset($aluno['pessoa']['cpf']) ? $aluno['pessoa']['cpf'] : "" !!} </td>
    </tr>
    <tr>
        <td colspan="4"><b>Nome do Pai:</b> {!! isset($aluno['pessoa']['nome_pai']) ? $aluno['pessoa']['nome_pai'] : "" !!} </td>
    </tr>
    <tr>
        <td colspan="4"><b>Nome da Mãe:</b> {!! isset($aluno['pessoa']['nome_mae']) ? $aluno['pessoa']['nome_mae'] : "" !!} </td>
    </tr>
    <tr>
        <td><b>Estado Civil:</b> {!! isset($aluno['pessoa']['estadoCivil']) ? $aluno['pessoa']['estadoCivil']['nome'] : "" !!} </td>
        <td><b>Data de Nasc.:</b> {!! isset($aluno['pessoa']['data_nasciemento']) ? $aluno['pessoa']['data_nasciemento'] : "" !!} </td>
        <td><b>Sexo:</b> {!! isset($aluno['pessoa']['sexo']) ? $aluno['pessoa']['sexo']['nome'] : "" !!} </td>
        <td><b>Local de Nasc.:</b> {!! isset($aluno['pessoa']['naturalidade']) ? $aluno['pessoa']['naturalidade'] : "" !!} </td>
    </tr>
    <tr>
        <td colspan="3"><b>Área da Pós-Graduação:</b>  </td>
        <td><b>Ano:</b>  </td>
    </tr>
</table>

<h5><i>02 – Da Prestadora de Serviços:</i></h5>

<p>
    <b><i>ALPHA EDUCAÇÃO E TREINAMENTOS</i></b>, Inscrita no CNPJ de nº 22.945/0001-00, doravante denominada de CONTRATADA,
    a qual oferece serviços educacionais de (Pós graduação  Lato Sensu)
    a mesma está situada a Rua Gervásio Pires nº826 no Bairro de Santo Amaro na Cidade do Recife no Estado de Pernambuco.
</p>

<h5><i>03 – Da identificação do Curso, Prazo e Duração:</i></h5>
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
    1. <b>O OBJETO</b> – O objeto do presente instrumento é a contratação dos serviços da PRESTADORA DE SERVIÇOS,&nbsp;&nbsp;&nbsp;
    que se compromete a ministrar aulas dos Cursos de Pós Graduação (lato Sensu), em conformidade com o Curso descrito no quadro 03,
    fornecendo Declaração de Conclusão no final do curso, no prazo máximo de 30 dias,
    ao aluno que obtiver conceito geral mínimo de 7 (sete) pontos por módulo, comparecido em pelo
    menos 75% (setenta e cinco por cento) das aulas ministradas, mensalidades em dia,
    toda documentação entregue, bem como o artigo com o CD.
    E após 90 dias da entrega da declaração de conclusão será entregue o diploma onde nesta data o aluno deverá assinar o livro ata.
</p>

<?php

use Seracademico\Uteis\Monetary;

$valorCurso = number_format($turma->valor_turma * ($turma->qtd_parcelas + 1), 2, ',', '.');
$valorCurso2 = number_format($turma->valor_turma * ($turma->qtd_parcelas + 1), 2, '.', '');
$numeroTxt = Monetary::numberToExt($valorCurso2);
$parcelasTxt = Monetary::numberToExt2($turma->qtd_parcelas);
?>

<p class="termos">
    <?php $vencimento = $turma->vencimento_inicial ? \DateTime::createFromFormat('Y-m-d', $turma->vencimento_inicial) : null; ?>

    2. <b>DO INVESTIMENTO E FORMA DE PAGAMENTO</b>&nbsp;&nbsp;&nbsp; Como contraprestação dos serviços educacionais, acima referidos,
    será cobrado do CONTRATANTE um investimento de R$ {{$valorCurso}} ({{$numeroTxt}}),
    dividido em 1+ {{$turma->qtd_parcelas}} ({{$parcelasTxt}}) parcelas iguais mensais de R$ {{$turma->valor_turma}} com vencimento todo dia {{ isset($vencimento) ? $vencimento->format('d') : 30 }} de cada mês.
    As parcelas podem variar de acordo com cada curso. A matricula só será <b>devolvida</b> caso não forme turma
</p>

<p class="termos">
    3. <b>DOS SERVIÇOS NÃO INCLUSOS NO PREÇO DO INVESTIMENTO</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Não estão incluídos neste Contrato os serviços especiais e as taxas escolares,
    assim como: 2º chamada de provas, requerimentos, declarações, certificado e outros serviços.
</p>

<p class="termos">
    4. <b>A CARGA HORÁRIA</b>&nbsp;, sua distribuição mensal, o horário das aulas e o prazo de duração do curso encontram-se especificados no quadro 03.
    A data do termino do Curso poderá ser prorrogada por motivos de força maior ou por
    eventuais ocorrências geradas no decorrer do Curso descrito no campo 03,
    o qual concorda expressamente o aluno, desde que justificado pela Prestadora de Serviços.
</p>

<p class="termos">
    5. <b>Fica a critério da PRESTADORA DE SERVIÇO </b>&nbsp;&nbsp; a decisão de suspender o Curso a ser iniciado caso não haja o
    preenchimento de 70% (sententa por cento) da capacidade de alunos por turma ou remanejar a data de início escolhida pelo aluno (a),
    mediante acordo entre ambas as partes. Caso o aluno não aceite a mudança o mesmo terá direito a devolução do valor da matrícula.
</p>

<p class="termos">
    6. <b>ATRASO(S) DA(S) MENSALIDADE(S) </b>&nbsp;&nbsp;&nbsp; – O Preço dos Serviços ora contratados, bem como o número de mensalidades e data do vencimento
    ficará especificado na data da Matrícula, ficando ao aluno, o pagamento através das condições escolhidas no ato da
    assinatura do presente contrato. Caso seja escolhida a modalidade do pagamento parcelado, será confeccionado carnê de
    pagamento com a quantidade de mensalidades a serem pagas, o carnê será entregue ao aluno no seu 1º dia de aula,
    as mensalidades deverão ser pagas no setor financeiro da prestadora de serviços. O desconto que for concedido ao
    aluno será respeitado desde que, a data do vencimento seja obedecida.
</p>

<p class="termos">
    7. <b>VALOR E PAGAMENTO </b>&nbsp; – O atraso ou não pagamento das mensalidades, resultarão em perda do desconto promocional,
    mais multa de 2% (dois por cento) sobre a importância devida acrescida de 1% (um por cento)
    ao mês mais correção com base no IGPM (FGV) sendo que o recebimento da determinada parcela não significará
    quitação das anteriores. Em caso de mudança na politica financeira nacional convenciona as partes que a
    presente cláusula será revista e fixado um novo parâmetro para o cálculo da atualização monetária.
</p>

<p class="termos">
    8. <b>PERCA DO CARNÊ </b>&nbsp; – O aluno que perde o carnê deverá solicitar segunda via através de requerimento à prestadora de serviço,
    mediante pagamento de uma taxa no valor de R$ 15,00.<br />
    - Pagamento realizado através de recibo, será acrescida uma taxa de (R$ 5,00) sobre o valor da mensalidade.<br />
    - Pagamento através de cartão de crédito ou débito o aluno perde o desconto, assim o valor será cheio sem desconto promocional
    (Desconto promocional apenas para mensalidades pagas em dinheiro na data do vencimento no setor financeiro da prestadora de serviços).
</p>

<p class="termos">
    9. <b>TRANCAMENTO </b>&nbsp; – Caso precise, o aluno poderá solicitar através de requerimento o trancamento do seu curso,
    o mesmo deverá está com as mensalidades em dia e pagar uma taxa no valor de R$ 30,00,
    o trancamento terá a duração de um ano a contar da data da assinatura do requerimento,
    após este prazo o aluno deverá comparecer a prestadora de serviços para formalizar a sua situação,
    no caso de não comparecimento o aluno autoriza a prestadora a encaminhar o débito ao Cartório de Protesto,
    bem como proceder ao registro do débito junto ao serviço de Proteção ao Crédito – SPC e Serasa, ficando a
    critério da PRESTADORA DE SERVIÇOS, rescindir o presente contrato
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
    14. <b>RESCISÃO CONTRATUAL </b>&nbsp; – Constitui em causa para a rescisão contratual, além do constante na cláusula 9,
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
<br /><br />

<div>
    <div style="text-align: center;"> <!-- position: absolute; margin-top: -85px; margin-left: 30%; -->
        <img width="1000px" height="202px" src="{{ asset('img/assinatura_full.png')  }}" alt="">
    </div>
</div>
</body>
</html>