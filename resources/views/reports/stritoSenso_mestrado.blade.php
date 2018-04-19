<html>
<head>
    {{--Documento personalizado em 04/09/2017 @felipe--}}
    {{--Documento personalizado em 19/04/2018 @Gustavo--}}

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title>Strito Senso - Mestrado</title>
    <style type="text/css">
    body {
        font-family: Arial, Helvetica, AppleGothic, sans-serif;
        font-size: 14px;
    }
    .cabecalho {
        width: 80%;
        margin: 0 auto;
        margin-bottom: 3%;
        font-size: 15px;
    }
    .cabecalho p {
        text-align: center;
        font-weight: bold;
    }
    .conteudo {
        width: 100%;
    }
    .conteudo p {
        text-align: justify;
        word-spacing: 0.1em;
        letter-spacing: normal;
        justify-content: space-between;
    }
    .table {
        border-collapse: collapse;
        width: 100%;
        background-color: #D3D3D3;
    }
    .table td {
        padding: 1%;
        border: 1px solid;
    }
    .rodape hr{
        border-color: black;
        width: 80%;
        margin-left: 20%;
    }
    .rodape h1 {
        text-align: center;
    }
    .titulo_paragrafo {
        font-weight: bold;
        text-decoration: underline;
        margin-left: 2%;
    }
    .paragrafo {
        text-indent: 3em;
    }
    .uppercase {
        text-transform: uppercase;
    }
    .justificado {
        text-align: justify;
    }
    .subparagrafo {
        text-align: justify;
        margin-left: 10%;
        width: 90%;
    }
    .subparagrafo-3-nivel {
        text-align: justify;
        margin-left: 15%;
        width: 85%;
    }
    .tabela-de-descricao tr {
        margin: 0;
    }
    .tabela-de-descricao td,
    .tabela-de-descricao th {
        border: 1px solid black;
    }
    .tabela-de-descricao thead th {
        background-color: #A9A9A9;
        color: white;
        text-align: center;
    }
    table {
        page-break-inside:auto;
    }

    tr    { page-break-inside:avoid; page-break-after:auto }
    thead { display:table-header-group }
    tfoot { display:table-footer-group }
</style>
</head>
<body>

    <div class="cabecalho" style="font-size: 15px;">
        <p>
         CONTRATO DE PRESTAÇÃO DE SERVIÇOS DE ASSESSORIA EDUCACIONAL E MANUTENÇÃO DE CENTRO DE APOIO A ESTUDANTES BRASILEIROS NO EXTERIOR (MODALIDADE ON- LINE)
     </p>
 </div>

 <div class="conteudo">
    <p>
     Pelo presente instrumento particular de <b>CONTRATO DE PRESTAÇÃO DE SERVIÇOS DE ASSESSORIA EDUCACIONAL E MANUTENÇÃO DE CENTRO DE APOIO A ESTUDANTES BRASILEIROS NO EXTERIOR</b>, celebrado pela <b>UNIVERSIDAD INTERAMERICANA</b>, criada pela Lei Nacional Paraguaya n. 4.200, com RUC 80071652-3, representada pelo <b>Dr. HUGO CÉSAR GÓMEZ SOLÍS</b>, paraguaio, portador do RG 625.806, como primeira parte, <b>EMPRESA ALPHA SISTEMA EDUCACIONAL E TREINAMENTOS LTDA-ME</b>, Pessoa Jurídica de Direito Privado, inscrita no CNPJ 15708483/0001-50, como segunda parte, instituições de direito privado, autorizadas à gerencia de Seminários Culturais, Fóruns de Debates, Workshops Educacionais, Seminários de Qualificação de Projetos, Ambientes Virtuais de Ensino Aprendizagem, Mini Cursos Livres e Seminários Culturais, com endereço profissional à Rua Gervásio Pires, 826, Boa Vista, Recife, PE, CEP 50050-070, Brasil, neste ato reconhecidas como <b> Contratadas</b> e pessoa natural de direito, residente no Estado Brasileiro, cidadã em pleno gozo de seus direitos cíveis, abaixo qualificada e reconhecida como <b>Contratante:</b>
 </p>

 <div class="informacoes_pessoas">
    <table class="table" style="font-size: 14px;">
        <tr>
            <td colspan="4">Nome: {{$aluno['pessoa']['nome']}}</td>
        </tr>
        <tr>
            <td colspan="3">Endereço: {{ isset($aluno['pessoa']['endereco']) ? $aluno['pessoa']['endereco']['logradouro'] : "" }}</td>
            <td>Nº {{ isset($aluno['pessoa']['endereco']) ? $aluno['pessoa']['endereco']['numero'] : "" }}</td>
        </tr>
        <tr>
            <td>APT: </td>
            <td>COMP: {{ isset($aluno['pessoa']['endereco']['complemento']) ? $aluno['pessoa']['endereco']['complemento'] : "" }}</td>
            <td colspan="2">BAIRRO: {{ isset($aluno['pessoa']['endereco']['bairro']) ? $aluno['pessoa']['endereco']['bairro']['nome'] : "" }}</td>
        </tr>
        <tr>
            <td colspan="2">CIDADE: {{ isset($aluno['pessoa']['endereco']['bairro']['cidade']) ? $aluno['pessoa']['endereco']['bairro']['cidade']['nome'] : "" }}</td>
            <td>UF: {{ isset($aluno['pessoa']['endereco']['bairro']['cidade']['estado']) ? $aluno['pessoa']['endereco']['bairro']['cidade']['estado']['nome'] : "" }}</td>
            <td>CEP: {{ isset($aluno['pessoa']['endereco']['cep']) ? $aluno['pessoa']['endereco']['cep'] : "" }}</td>
        </tr>
        <tr>
            <td>TEL. RES: {{ isset($aluno['pessoa']['telefone_fixo']) ? $aluno['pessoa']['telefone_fixo'] : "" }}</td>
            <td>TEL. COM: {{ isset($aluno['pessoa']['celular']) ? $aluno['pessoa']['celular'] : "" }}</td>
            <td colspan="2">TEL. CEL: {{ isset($aluno['pessoa']['celular2']) ? $aluno['pessoa']['celular2'] : "" }}</td>
        </tr>
        <tr>
            <td colspan="4">E-mail: {{ isset($aluno['pessoa']['email']) ? $aluno['pessoa']['email'] : "" }}</td>
        </tr>
        <tr>
            <td>RGº: {{ isset($aluno['pessoa']['identidade']) ? $aluno['pessoa']['identidade'] : "" }}</td>
            <td>{{ isset($aluno['pessoa']['orgao_rg']) ? $aluno['pessoa']['orgao_rg'] : "" }}</td>
            <td colspan="2">CPF: {{ isset($aluno['pessoa']['cpf']) ? $aluno['pessoa']['cpf'] : "" }} </td>
        </tr>
        <tr>
            <td colspan="4">Nome do Pai: {{ isset($aluno['pessoa']['nome_pai']) ? $aluno['pessoa']['nome_pai'] : "" }}</td>
        </tr>
        <tr>
            <td colspan="4">Nome da Mãe: {{ isset($aluno['pessoa']['nome_mae']) ? $aluno['pessoa']['nome_mae'] : "" }}</td>
        </tr>
        <tr>
            <td>Estado Civil: {{ isset($aluno['pessoa']['estadoCivil']) ? $aluno['pessoa']['estadoCivil']['nome'] : "" }}</td>
            <td>Data de Nasc: {{ isset($aluno['pessoa']['data_nasciemento']) ? $aluno['pessoa']['data_nasciemento'] : "" }}</td>
            <td>Sexo: {{ isset($aluno['pessoa']['sexo']) ? $aluno['pessoa']['sexo']['nome'] : "" }}</td>
            <td>Local Nasc: {{ isset($aluno['pessoa']['naturalidade']) ? $aluno['pessoa']['naturalidade'] : "" }}</td>
        </tr>
        <tr>
         <td colspan="4">Curso: {{ isset($curso->nome) ? $curso->nome : ""  }}</td>
     </tr>
 </table>
</div>

<p>
    <b>1. Do Objeto Contratual</b>
</p>

<p class="paragrafo">
    O objeto do presente <b>CONTRATO DE PRESTAÇÃO DE SERVIÇOS DE ASSESSORIA EDUCACIONAL E MANUTENÇÃO DE CENTRO
    DE APOIO A ESTUDANTES BRASILEIROS NO EXTERIOR</b>, é a prestação de serviços das <b>Contratadas</b> a <b>Contratante</b>,
    visando a administração de centros de apoio à pesquisadores admitidos na <b>UNIVERSIDAD INTERAMERICANA</b>, ofertando a estes recurso e gerência a execução de <b>Seminários Culturais, Fóruns de Debates,
    Workshops Educacionais, Seminários de Qualificação de Projetos, Ambientes Virtuais de Ensino Aprendizagem, Mini Cursos Livres e Seminários</b>, tomando como base o modelo internacional sul-americano de integralização de créditos, fortemente amparado por organismos internacionais, bem como assessorá-la a nacionalizar os documentos estrangeiros no Estado Brasileiro sob segunda contratação entre Contratadas e Contratante.
</p>

<div style="margin-top: 65px;">
    <p class="titulo_paragrafo">
        Cláusula Primeira:
    </p>
</div>

<p class="paragrafo">
    Como contraprestação aos serviços de <b>ASSESSORIA EDUCACIONAL E MANUTENÇÃO DE CENTRO DE APOIO A ESTUDANTES BRASILEIROS</b>, prestados e/ou a serem prestados, conforme prevê a Cláusula Segunda, a Contratante confessa dívida e se obriga a pagar as Contratadas, o número e valor de parcelas descritas abaixo, conforme o curso e área da pós-graduação escolhida na qualificação acima:
</p>

<p><b>1. MESTRADOS</b></p>

<p>
    a. CIÊNCIAS DA EDUCAÇÃO, SAÚDE PÚBLICA, CIÊNCIA AMBIENTAIS:
</p>


<table class="tabela-de-descricao" style="font-size: 12px;" cellspacing="0" width="45%">
    <thead>
        <tr>
            <th style="width: 80%">Descrição</th>
            <th>Valor</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Matrícula</td>
            <td>R$ 600,00</td>
        </tr>
        <tr>
            <td>Nº de Mensalidades:30(trinta)</td>
            <td>R$ 750,00</td>
        </tr>
    </tbody>
</table>

<table class="tabela-de-descricao" style="font-size: 12px;" cellspacing="0" style="margin-top: 3%" width="45%">
    <thead>
        <tr>
            <th>Diplomação</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>U$ 2000,00</td>
        </tr>
    </tbody>
    <tbody>
       <tr>
        <td>OBS: Pagamento das mensalidades até o vencimento terá R$ 50,00
        de desconto</td>
    </tr>
</tbody>
</table>
<p>
    b. ADMINISTRAÇÃO DE EMPRESA, ADMINISTRAÇÃO EM GESTÃO HOSPITALAR e DIREITO INTERNACIONAL PÚBLICO:
</p>


<table class="tabela-de-descricao" style="font-size: 12px;" cellspacing="0" width="45%">
    <thead>
        <tr>
            <th style="width: 80%">Descrição</th>
            <th>Valor</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Matrícula</td>
            <td>R$ 600,00</td>
        </tr>
        <tr>
            <td>Nº de Mensalidades:30(trinta)</td>
            <td>R$ 750,00</td>
        </tr>
    </tbody>
</table>

<table class="tabela-de-descricao" style="font-size: 12px;" cellspacing="0" style="margin-top: 3%" width="45%">
    <thead>
        <tr>
            <th>Diplomação</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>U$ 2500,00</td>
        </tr>
    </tbody>
    <tbody>
       <tr>
        <td>OBS: Pagamento das mensalidades até o vencimento terá R$ 50,00
        de desconto</td>
    </tr>
</tbody>
</table>
<p><b>2. DOUTORADOS</b></p>

<p>
    a. INTERNACIONAL EM SAÚDE PÚBLICA, CIÊNCIAS AMBIENTAIS
</p>


<table class="tabela-de-descricao" style="font-size: 12px;" cellspacing="0" width="45%">
    <thead>
        <tr>
            <th style="width: 80%">Descrição</th>
            <th>Valor</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Matrícula</td>
            <td>R$ 600,00</td>
        </tr>
        <tr>
            <td>Nº de Mensalidades:30(trinta)</td>
            <td>R$ 850,00</td>
        </tr>
    </tbody>
</table>
<table class="tabela-de-descricao" style="font-size: 12px;" cellspacing="0" style="margin-top: 3%" width="45%">
    <thead>
        <tr>
            <th>Diplomação</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>U$ 3000,00</td>
        </tr>
    </tbody>
    <tbody>
       <tr>
        <td>OBS: Pagamento das mensalidades até o vencimento terá R$ 50,00
        de desconto</td>
    </tr>
</tbody>
</table>
<p>
    b. DOUTORADO EM CIÊNCIAS DA EDUCAÇÃO:
</p>


<table class="tabela-de-descricao" style="font-size: 12px;" cellspacing="0" width="45%">
    <thead>
        <tr>
            <th style="width: 80%">Descrição</th>
            <th>Valor</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Matrícula</td>
            <td>R$ 600,00</td>
        </tr>
        <tr>
            <td>Nº de Mensalidades:30(trinta)</td>
            <td>R$ 850,00</td>
        </tr>
    </tbody>
</table>
<table class="tabela-de-descricao" style="font-size: 12px;" cellspacing="0" style="margin-top: 3%" width="45%">
    <thead>
        <tr>
            <th>Diplomação</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>U$ 3000,00</td>
        </tr>
    </tbody>
    <tbody>
       <tr>
        <td>OBS: Pagamento das mensalidades até o vencimento terá R$ 50,00
        de desconto</td>
    </tr>
</tbody>
</table>
<p>
    c. DOUTORADO EM ADMINISTRAÇÃO DE EMPRESAS
</p>


<table class="tabela-de-descricao" style="font-size: 12px;" cellspacing="0" width="45%">
    <thead>
        <tr>
            <th style="width: 80%">Descrição</th>
            <th>Valor</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Matrícula</td>
            <td>R$ 600,00</td>
        </tr>
        <tr>
            <td>Nº de Mensalidades:30(trinta)</td>
            <td>R$ 850,00</td>
        </tr>
    </tbody>
</table>
<table class="tabela-de-descricao" style="font-size: 12px;" cellspacing="0" style="margin-top: 3%" width="45%">
    <thead>
        <tr>
            <th>Diplomação</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>U$ 3000,00</td>
        </tr>
    </tbody>
    <tbody>
       <tr>
        <td>OBS: Pagamento das mensalidades até o vencimento terá R$ 50,00
        de desconto</td>
    </tr>
</tbody>
</table>


<p class="titulo_paragrafo">
    Cláusula Segunda
</p>

<p class="paragrafo">
    <span>As</span> <b>Contratadas</b> comprometem-se a prestar serviços de <b>ASSESSORIA EDUCACIONAL E MANUTENÇÃO DE CENTRO DE
    APOIO A ESTUDANTES BRASILEIROS</b> a <b>Contratante</b>, a autorizando a acessar o <b>CENTRO DE APOIO A ESTUDANTES
    BRASILEIROS</b> de sua zona.
</p>

<p class="titulo_paragrafo">
    Cláusula Terceira:
</p>

<p class="paragrafo">
 A <b>Contratante</b> declara expressamente estar ciente dos termos da presente contratação, <b> a qual foi por ela firmada de livre e espontânea vontade</b>, sendo <b>sua  a  opção  pelo  ensino semipresencial ou blend learning</b>. Que também toma ciência da possibilidade da necessidade de serem realizadas viagens ao exterior para fins de submeter-se aos trâmites burocráticos de imigração, estudos e a apresentação de sua tese no Paraguay. De toda forma, <b>possui total e completa ciência dos procedimentos de nacionalização e convalidação de seus títulos emitidos  no exterior</b>, por intermédio de diplomação junto a programas baseados em experiências acadêmicas, bem como tem ciência, que sua participação no <b>CENTRO DE APOIO A ESTUDANTES BRASILEIROS</b> não configura aulas e/ou qualquer atividade regulamentada no Brasil, mas sim oferta de subsídios à educação realizada a distância, ou presencialmente no Paraguay.
</p>

<p class="paragrafo">
    <span><b>Parágrafo Primeiro:</b></span> Reafirma sua completa ciência sobre os processos de convalidação de títulos,mediante pagamento da taxa cobrada em dólar,
    caso o contratante não efetue o pagamento da referida taxa, não terá seu título convalidado.
</p>

<p class="paragrafo">
    <span><b>Parágrafo Segundo:</b></span> A <b>Contratante</b> se compromete a elaborar e publicar 01 (hum) artigo por ano acadêmico em periódico acadêmico indexado no QUALIS/CAPES.
    <br><b>a.</b> A referida indexação da revista pode ser consultada através da Plataforma SUCUPIRA, no endereço eletrônico:  <p style='color: blue;text-decoration: underline;'>https://sucupira.capes.gov.br/sucupira/public/consultas/coleta/veiculoPublicacaoQualis/listaConsultaGeralPeriodicos.jsf</p>
</p>

<p class="paragrafo">
   <span><b>Parágrafo Terceiro:</b></span>A <b>Contratante</b> se compromete a pagar o preço ajustado pela prestação dos serviços ora contratados, no valor e na
   forma prevista no presente contrato, estando ciente que em caso de inadimplência <b>terá seus dados incluídos nos
   serviços de proteção ao crédito</b> no <b>Estado Brasileiro</b>, bem como em caso de desacordo e/ou dissonância comercial,
   administrativa e/ou acadêmica, fica eleito o foro de sua comarca de origem.
</p>
<p class="paragrafo">
   <span><b>Parágrafo Quarto:</b></span>
   Pagamentos em atraso após dois dias úteis serão corrigidos monetariamente pelo IGPM/FGV, acrescido de multa de 2% (dois por cento), além de juros moratórios de 1% (um por cento) ao mês, e pro rata / dia na fração do mês, podendo a cobrança passar a ser feita, neste caso, por advogado ou por empresa especializada em cobrança, quando então, tais valores serão também acrescidos de honorários advocatícios de 10% (dez por cento) em caso de acerto amigável ou 20% (vinte por cento) se for judicial, além das demais despesas decorrentes da exigibilidade dos valores inadimplidos, seja administrativa ou judicialmente.
</p>

<p class="paragrafo">
    <span><b>Parágrafo Quinto:</b></span> O aluno é expressamente alertado da necessidade de viagem ao exterior e que os custos de suas viagens serão pagos às suas expensas. Contudo, caso o aluno pague suas mensalidades em dia, a Alpha se responsabiliza integralmente pelas passagens aéreas ao exterior.
</p>
<p class="paragrafo">
    <span><b>Parágrafo Sexto:</b></span> Quanto à viagem ao exterior:
    <br><b>a.</b> Quanto ao pagamento do procedimento de imigração e documentações acadêmicas, o aluno tem ciência que pagará uma taxa administrativa ao despachante no Paraguai, para tanto, o aluno será informado acerca do valor a ser pago ao referido despachante em momento anterior à sua viagem, prazo jamais menor que 30 (trinta) dias, e num valor nunca excedente a um salário mínimo e meio. 
    <br><b>b</b>. Quanto à estada no País estrangeiro, esta ocorrerá às expensas do próprio aluno, assim como quaisquer valores referentes à sua viagem, desde que não preencha o predisposto no parágrafo quinto, deste caput. 
    <br> <b>c</b>. A viagem que trata esta cláusula não excederá ao valor total de 02(duas) ao longo de todo o curso.
</p>
<p class="paragrafo">
    <span><b>Parágrafo Sétimo:</b></span> Havendo a necessidade de refazer algum dos seminários, o aluno pagará 50% (cinquenta por
    cento) da mensalidade referente ao(s) módulo(s) devidamente requeridos por meio de protocolo acadêmico. 
</p>

<div style='margin-top: 40px;'>
    <p class="titulo_paragrafo">
        Cláusula Quarta:
    </p>
</div>

<p class="paragrafo">
    O valor dos serviços educacionais contratados neste instrumento decorreu do equiparamento feito entre a realidade
    econômica e financeira vigente na data da assinatura deste instrumento, os custos gerais das <b>Contratadas</b>, incluindo
    custos operacionais, fatos estes que são conhecidos e aceitos pela <b>Contratante</b>.
</p>

<p class="titulo_paragrafo">
    Cláusula Quinta:
</p>

<p class="justificado">
    O presente instrumento poderá ser rescindido nas seguintes hipóteses:
</p>

<p class="subparagrafo">
    a. Ocorrendo a extinção da primeira parte <b>Contratada</b>;
</p>

<p class="subparagrafo">
    b. Através do requerimento expresso da <b>Contratante</b>, assistido ou representado, quando for o caso de cancelamento
    de inscrição, sendo em qualquer caso, condição obrigatória de sua eficácia a comunicação da desistência da
    primeira parte <b>Contratada</b>, e o pagamento de multa no valor de 02 (duas) mensalidades, referente a taxa de trancamento, quando o CONTRATANTE poderá retornar ao curso em até 24 (vinte e quatro) meses, fazendo o pagamento da rematrícula.
</p>

<p class="subparagrafo">
    c. Quando por decisão da primeira parte <b>Contratada</b>, houver o cancelamento compulsório da inscrição, pela exclusão
    da Contratante em decorrência de descumprimento das normas internas da primeira parte <b>Contratada</b>;
</p>

<p class="subparagrafo-3-nivel">
    <b>Parágrafo Primeiro:</b> Os pedidos de desistência unilaterais do contrato, feitos pela <b>Contratante</b> deverão ser
    fundamentados e protocolados sob gerência da primeira parte <b>Contratada</b>, tendo prazo máximo de 30 (trinta)
    dias antes do vencimento da parcela a vencer. <b>Após este prazo, entende-se que o contrato é perfeito e não
    passível de rescisão, podendo ser exigido  o pagamento de todas as parcelas</b>, não dispensando a <b>Contratante</b> da
    quitação do pagamento referente ao nível de acesso escolhido, bem como também as outras despesas eventualmente
    ocasionadas pela <b>Contratante</b>.
</p>

<p class="subparagrafo-3-nivel">
    <b>Parágrafo Segundo:</b> O compromisso ora assumido pela <b>Contratante</b> com primeira parte <b>Contratada</b> é global e
    abrange a totalidade das obrigações ora pactuadas, e sua falta de freqüência ou impontualidade nos  pagamentos
    não o isentam de responder integralmente por todas as obrigações aqui assumidas, e constituem causa de rescisão
    unilateral pelas <b>Contratadas</b> da presente contratação.
</p>

<p class="subparagrafo-3-nivel">
    <b>Parágrafo Terceiro:</b> Ocorrendo a desistência unilateral do contrato, com comunicação escrita de 30 dias antes de
    vencer a parcela seguinte, o <b>Contratado</b> fica autorizado a cobrar ou reter 10% (dez por cento) do saldo total do
    plano financeiro escolhido.<br> <b>a</b>. Se, suspendendo-se o contrato pelo prazo de 24(vinte e quarto) meses, o aluno não regressar ao curso, dará causa à desistência unilateral, podendo ser cobrado do valor referido no parágrafo terceiro.  
</p>

<p class="subparagrafo-3-nivel">
    <b>Parágrafo Quarto:</b> No caso de desistência, a <b>Contratante</b>, deverá estar em dia com seus pagamentos e comunicar por
    escrito a primeira parte <b>Contratada</b> no prazo máximo de 30 dias antes do vencimento da parcela a vencer.
</p>

<p class="subparagrafo-3-nivel">
    <b>Parágrafo Quinto:</b> Caso o pedido de desistência previsto nesta cláusula não seja formalizado, o contrato
    continuará em vigor e a <b>Contratante</b> deverá pagar todas as parcelas previstas no ato da inscrição, podendo
    a primeira parte <b>Contratada</b> tomar medidas cabíveis de cobrança.
</p>

<p class="subparagrafo-3-nivel">
    <b>Parágrafo Sexto:</b> A devolução da matrícula só ocorrerá em caso de não fechamento de turma ou de
    desistência no prazo de até 7 dias após a formalização da matrícula.
</p>
<p class="subparagrafo-3-nivel">
    <b>Parágrafo Sétimo:</b> A inadimplência contratual por um período superior a 60 (sessenta dias). 
</p>

<div style='margin-top: 30px;'>
    <p class="titulo_paragrafo">
        Cláusula Sexta:
    </p>
</div>

<p class="paragrafo">
    A <b>Contratante</b> que solicitar certidões ou outros documentos as <b>Contratadas</b> deverá pagar  por cada documento solicitado,
    tomando como base os valores estipulados em tabela elaborada e informada a <b>Contratante</b>, os quais se destinam a
    custear as despesas decorrentes da emissão e envio dos mesmos.
</p>

<table class="tabela-de-descricao" style="font-size: 12px;" cellspacing="0" width="45%">
    <thead>
        <tr>
            <th style="width: 75%">Documento</th>
            <th>Valor</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>2º Via de declaração de vínculo</td>
            <td>R$ 30,00</td>
        </tr>
        <tr>
            <td>Declaração de afastamento</td>
            <td>R$ 30,00</td>
        </tr>
        <tr>
            <td>2º Via de boleto</td>
            <td>R$ 20,00</td>
        </tr>
    </tbody>
</table>

<p class="titulo_paragrafo" style="margin-top: 25px;">
    Cláusula Sétima:
</p>

<p class="paragrafo">
    Sempre que a <b>Contratante</b> mudar de endereço deverá comunicar de imediato por escrito <span>as</span>
    <b>Contratadas</b>, sob pena de terem-se como válidas e eficazes todas as correspondências enviadas pelas
    <b>Contratadas</b> para endereço anterior, constante deste contrato.
</p>

<p class="subparagrafo">
    <b>Parágrafo Primeiro:</b> A <b>Contratante</b> deverá possuir um endereço eletrônico permanente para contato com
    as <b>Contratadas</b> e com o (s) professor (s). É de total responsabilidade da <b>Contratante</b>
    adquirir e informar um endereço eletrônico as <b>Contratadas</b>, não importando os meios pelos quais irá adquiri-lo.
</p>

<p class="subparagrafo">
    <b>Parágrafo Segundo:</b> A <b>Contratante</b> deverá responder a todas as mensagens enviadas em seu endereço
    eletrônico, no prazo máximo de 72 horas.
</p>

<p class="subparagrafo">
    <b>Parágrafo Terceiro:</b> A <b>Contratante</b> autoriza a divulgação de sua imagem nas propagandas da instituição.
</p>

<p class="titulo_paragrafo">
    Cláusula Oitava:
</p>

<p class="paragrafo">
    A emissão dos diplomas internacionais ocorrerá em até 150 dias úteis e o prazo para entrega do diploma
    convalidado nacionalmente é de até 300 dias úteis a contar da data da entrega da dissertação definitiva.
</p>

<p class="titulo_paragrafo">
    Cláusula Nona:
</p>

<p class="paragrafo">
    As <b>Contratadas</b> prestarão assessoramento à legalização externa mediante pagamento de emolumentos (honorários)
    pela <b>Contratante</b>.
</p>

<div style="margin-top: 0px;">
    <p class="paragrafo">
        E assim por estarem juntos, firmes e contratados, firmam os signatários, o presente instrumento, em duas vias de
        igual teor e forma, para que produza seus jurídicos e legais efeitos.
    </p>

    <p style="text-align: center; margin-top: 8%;">
        _______de_________________ de ___________.
    </p>

    <div style="margin-left: 0; margin-top: 5%;">
        <h1 style="text-align: left;">
            <table>
                <tr><td>___________________________________________</td></tr>
                <tr><td style="font-family: arial; text-align: center"><b>(Assinatura contratante)</b></td></tr>
            </table>

            <table style="">
                <tr><td><img src="{{ asset('img/assinatura_luciana_mestrado_novo_cnpj.png') }}" alt=""></td></tr>
            </table>
        </h1>
    </div>

    <div style="margin-left: 0;">
        <h3 style="text-align: left;">Testemunhas</h3>

        <table style="margin-bottom: 1%; font-size: 12px; float:left;">
            <tr style="margin-bottom: 1%"><td>1)</td></tr>
            <tr><td>RG nº</td></tr>
            <tr><td>CPF nº</td></tr>
        </table>

        <table style="margin-left: 300px; font-size: 12px; float:left;">
            <tr style="margin-bottom: 1%;"><td>2)</td></tr>
            <tr><td>RG nº</td></tr>
            <tr><td>CPF nº</td></tr>
        </table>
    </div>
</div>
</div>
</body>
</html>