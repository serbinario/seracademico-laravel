<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title>Relatório de notas</title>
    <style type="text/css">
        body {
            font-family: Arial, Helvetica, AppleGothic, sans-serif;
        }
        @page {
            border: 1px solid;
        }
        .cabecalho {
            width: 70%;
            margin: 0 auto;
            margin-bottom: 3%;
        }
        .cabecalho p {
            text-align: center;
            font-weight: bold;
        }
        .conteudo {
            width: 100%;
        }
        .conteudo p {
            font-size: 15px;
            text-align: justify;
            word-spacing: 0.1em;
        }
        .table {
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
        .rodape {
            page-break-after: always;
        }
        .rodape h1 {
            text-align: center;
        }
        /*.rodape div {
            margin-left: 60%;
        }
        .rodape p {
            text-align: center;
            font-weight: bold;
        }*/
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
    </style>
</head>
<body>

<div class="cabecalho">
    <p>
        CONTRATO DE PRESTAÇÃO DE SERVIÇOS DE ASSESSORIA EDUCACIONAL E MANUTENÇÃO DE CENTRO DE APOIO A ESTUDANTES
        BRASILEIROS NO EXTERIOR (MODALIDADE ON-LINE)
    </p>
</div>

<div class="conteudo">
    <p>
        Pelo presente instrumento particular de <b>CONTRATO DE PRESTAÇÃO DE SERVIÇOS DE ASSESSORIA EDUCACIONAL E MANUTENÇÃO
        DE CENTRO DE APOIO A ESTUDANTES  BRASILEIROS NO EXTERIOR</b>, celebrado pela <b>Universidade Grendal do Brasil – Unigrendal
        (CNPJ 12.147.854/0001-84)</b>, como primeira parte, <b>ALPHA EDUCAÇÃO E TREINAMENTOS Ltda – Me (22.945.385/0001-00)</b> como
        segunda parte, instituições de direito privado, autorizadas à gerencia de Seminários Culturais, Fóruns de Debates,
        Workshops Educacionais, Seminários de Qualificação de Projetos, Ambientes Virtuais de Ensino Aprendizagem,
        Mini Cursos Livres e Seminários Culturais, com endereço profissional à Rua Gervásio Pires, 826, Boa Vista, Recife,
        PE,  CEP 50050-070, Brasil, neste ato reconhecidas como <b>Contratadas</b> e pessoa natural de direito, residente no
        Estado Brasileiro, cidadã em pleno gozo de seus direitos cíveis, abaixo qualificada e reconhecida como <b>Contratante</b>:
    </p>

    <div class="informacoes_pessoas">
        <table class="table">
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
                <td>CEP: </td>
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
                <td>SDS: {{ isset($aluno['pessoa']['uf_exp']) ? $aluno['pessoa']['uf_exp'] : "" }}</td>
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
                <td colspan="3">Área da Pós-Graduação: </td>
                <td>Ano: </td>
            </tr>
        </table>
    </div>

    <div class="rodape" style="margin-top: 65%">
        <h1><img src="{{ asset('/img/rodape_contrato_mestrado.png') }}" alt=""></h1>
    </div>

    <div style="text-align: center">
        <h1>
            <img src="{{ asset('/img/cabecalho_contrato_mestrado.png') }}" alt="">
        </h1>
    </div>

    <p>
        <b>1. Do Objeto Contratual</b>
    </p>

    <p class="paragrafo">
        O objeto do presente <b>CONTRATO DE PRESTAÇÃO DE SERVIÇOS DE ASSESSORIA EDUCACIONAL E MANUTENÇÃO DE CENTRO
        DE APOIO A ESTUDANTES BRASILEIROS NO EXTERIOR</b>, é a prestação de serviços das <b>Contratadas</b> a <b>Contratante</b>,
        visando a administração de centros de apoio à pesquisadores admitidos na <b>Grendal College and University
        dos USA</b>, ofertando a estes recurso e gerência a execução de <b>Seminários Culturais, Fóruns de Debates,
        Workshops Educacionais, Seminários de Qualificação de Projetos, Ambientes Virtuais de Ensino Aprendizagem,
        Mini Cursos Livres e Seminários</b>, tomando como base o modelo internacional de integralização de créditos
        <b>Profile Evaluation System - CPAAS</b>, fortemente amparado  por organismos internacionais como UNESCO/CEPES
        (International Policy Seminar Co-organised by IIEP/UNESCO and KRIVET), International Accreditation
        Organization – (IAO/USA), United States Distance Learning Association (USDLA), National Academic Higher
        Education e pelo Council for Adult and Experiential Learning (CAEL), bem como assessorá-la a nacionalizar
        os documentos  estrangeiros no Estado Brasileiro sob segunda contratação entre Contratadas e Contratante.
    </p>

    <p class="titulo_paragrafo">
        Cláusula Primeira:
    </p>

    <p class="paragrafo">
        Como contraprestação aos serviços de <b>ASSESSORIA EDUCACIONAL E MANUTENÇÃO DE CENTRO DE APOIO A ESTUDANTES
        BRASILEIROS</b>, prestados e/ou a serem prestados, conforme prevê a Cláusula Segunda, a Contratante confessa
        dívida e se obriga a pagar as Contratadas, o número e valor de parcelas descritas abaixo:
    </p>

    <p class="uppercase">
        MESTRADO INTERNACIONAL EM {{ isset($curso->nome) ? $curso->nome : ""  }}
    </p>


    <table class="tabela-de-descricao" cellspacing="0" width="45%">
        <thead>
        <tr>
            <th style="width: 80%">Inscrição</th>
            <th>Valor</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>Matrícula</td>
            <td>R$ 400,00</td>
        </tr>
        <tr>
            <td>Nº de Mensalidades:30</td>
            <td>R$ 500,00</td>
        </tr>
        </tbody>
    </table>

    <table class="tabela-de-descricao" cellspacing="0" style="margin-top: 3%" width="45%">
        <thead>
        <tr>
            <th>Diplomação</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>R$ 1000,00</td>
        </tr>
        </tbody>
    </table>

    <p class="titulo_paragrafo">
        Clausula Segunda
    </p>

    <p class="paragrafo">
        As <b>Contratadas</b> comprometem-se a prestar serviços de <b>ASSESSORIA EDUCACIONAL E MANUTENÇÃO DE CENTRO DE
            APOIO A ESTUDANTES BRASILEIROS</b> a <b>Contratante</b>, a autorizando a acessar o <b>CENTRO DE APOIO A ESTUDANTES BRASILEIROS</b> de sua zona.
    </p>

    <p class="titulo_paragrafo">
        Cláusula Terceira:
    </p>

    <p class="paragrafo">
        A <b>Contratante</b> declara expressamente estar ciente dos termos da presente contratação, <b>a qual foi por
            ela firmada de livre e espontânea vontade</b>, sendo <b>sua a opção pelo ensino à distância euro-estadunidense</b>.
        <b>Possui total e completa ciência dos procedimentos de nacionalização e convalidação de seus títulos
            emitidos no exterior</b>, por intermédio de diplomação junto a programas baseados em experiência de vida
        <b>“Prior Learning Assessment Programs”</b>, bem como tem ciência, que sua participação no <b>CENTRO DE APOIO A ESTUDANTES BRASILEIROS</b>
        não configura aulas e/ou qualquer atividade regulamentada no Brasil, mas sim oferta de subsídios à educação realizada online nos USA.
    </p>

    <p class="paragrafo">
        Reafirma sua completa ciência sobre os processos de convalidação de títulos,mediante pagamento da taxa cobrada em dólar,
        caso o contratante não efetue o pagamento da referida taxa, não terá seu título convalidado.
    </p>

    <p class="paragrafo">
        A <b>Contratante</b> se compromete a pagar o preço ajustado pela prestação dos serviços ora contratados, no valor e na
        forma prevista no presente contrato, estando ciente que em caso de inadimplência <b>terá seus dados incluídos nos
        serviços de proteção ao crédito</b> no <b>Estado Brasileiro</b>, bem como em caso de desacordo e/ou dissonância comercial,
        administrativa e/ou acadêmica, fica eleito o foro de sua comarca de origem.
    </p>

    <p class="subparagrafo">
        <b>Parágrafo Primeiro:</b> Pagamentos em atraso após dois dias úteis serão corrigidos monetariamente pelo IGPM/FGV,
        acrescido de multa de 2% (dois por cento), além de juros moratórios de 1% (um por cento) ao mês, e pro rata
        / dia na fração do  mês, podendo a cobrança passar a ser feita, neste caso, por advogado ou por empresa especializada
        em cobrança, quando então, tais valores serão também acrescidos de honorários advocatícios de 10% (dez por cento)
        em caso de acerto amigável ou 20% (vinte por cento) se for judicial, além das demais despesas decorrentes da
        exigibilidade dos valores inadimplidos, seja administrativa ou judicialmente.
    </p>

    <p class="titulo_paragrafo">
        Cláusula Quarta:
    </p>

    <p class="paragrafo">
        O valor dos serviços educacionais contratados neste instrumento decorreu do equiparamento feito entre a realidade
        econômica e financeira vigente na data da assinatura deste instrumento, os custos gerais das <b>Contratadas</b>, incluindo
        custos operacionais, fatos estes que são conhecidos e aceitos pela <b>Contratante</b>.
    </p>

    <div class="rodape" style="margin-top: 10%;">
        <h1>
            <img src="{{ asset('/img/rodape_contrato_mestrado.png') }}" alt="">
        </h1>
    </div>

    <div style="text-align: center">
        <h1>
            <img src="{{ asset('/img/cabecalho_contrato_mestrado.png') }}" alt="">
        </h1>
    </div>

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
        primeira parte <b>Contratada</b>, e o pagamento de multa no valor de 10% do contrato;
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
        plano financeiro escolhido.
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

    <p class="titulo_paragrafo">
        Cláusula Sexta:
    </p>

    <p class="paragrafo">
        A <b>Contratante</b> que solicitar certidões ou outros documentos as <b>Contratadas</b> deverá pagar  por cada documento solicitado,
        tomando como base os valores estipulados em tabela elaborada e informada a <b>Contratante</b>, os quais se destinam a
        custear as despesas decorrentes da emissão e envio dos mesmos.
    </p>

    <table class="tabela-de-descricao" cellspacing="0" width="45%">
        <thead>
        <tr>
            <th style="width: 80%">Documento</th>
            <th>Valor</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>2º Via de declaração de vínculo</td>
            <td>R$ 15,00</td>
        </tr>
        <tr>
            <td>Declaração de afastamento</td>
            <td>R$ 15,00</td>
        </tr>
        <tr>
            <td>2º Via de boleto</td>
            <td>R$ 15,00</td>
        </tr>
        <tr>
            <td>Solicitação de disciplina como curso de extensão</td>
            <td>R$ 30,00</td>
        </tr>
        <tr>
            <td>Trancamento do curso</td>
            <td>R$ 50,00</td>
        </tr>
        </tbody>
    </table>

    <p class="titulo_paragrafo">
        Cláusula Sétima:
    </p>

    <p class="paragrafo">
        Sempre que a <b>Contratante</b> mudar de endereço deverá comunicar de imediato por escrito as <b>Contratadas</b>, sob pena de
        terem-se como válidas e eficazes todas as correspondências enviadas pelas <b>Contratadas</b> para endereço anterior, constante deste contrato.
    </p>

    <p class="subparagrafo">
        <b>Parágrafo Primeiro:</b> A <b>Contratante</b> deverá possuir um endereço eletrônico permanente para contato com as <b>Contratadas</b>
        e com o (s) professor (s). É de total responsabilidade da <b>Contratante</b> adquirir e informar um endereço eletrônico
        as <b>Contratadas</b>, não importando os meios pelos quais irá adquiri-lo.
    </p>

    <p class="subparagrafo">
        <b>Parágrafo Segundo:</b> A <b>Contratante</b> deverá responder a todas as mensagens enviadas em seu endereço eletrônico, no prazo máximo de 72 horas.
    </p>

    <p class="subparagrafo">
        <b>Parágrafo Terceiro:</b> A <b>Contratante</b> autoriza a divulgação de sua imagem nas propagandas da instituição.
    </p>

    <div class="rodape" style="margin-top: 8%;">
        <h1>
            <img src="{{ asset('/img/rodape_contrato_mestrado.png') }}" alt="">
        </h1>
    </div>

    <div style="text-align: center">
        <h1>
            <img src="{{ asset('/img/cabecalho_contrato_mestrado.png') }}" alt="">
        </h1>
    </div>

    <p class="titulo_paragrafo">
        Cláusula Oitava:
    </p>

    <p class="paragrafo">
        As <b>Contratadas</b> prestarão assessoramento à legalização externa mediante pagamento de emolumentos (honorários)
        pela <b>Contratante</b>.
    </p>

    <p class="paragrafo">
        E assim por estarem juntos, firmes e contratados, firmam os signatários, o presente instrumento, em duas vias de
        igual teor e forma, para que produza seus jurídicos e legais efeitos.
    </p>

   <p style="text-align: center; margin-top: 15%; margin-bottom: 10%;">
       ______________/_______,_______de______________________________de_____________________.
   </p>

    <div style="margin-left: 0;">
        <h1 style="text-align: left;">
            <img src="{{ asset('/img/assinatura_contrato_mestrado.png') }}" alt="">
        </h1>
    </div>

    <div style="margin-top: 45%;">
        <h1 style="text-align: center">
            <img src="{{ asset('/img/rodape_contrato_mestrado.png') }}" alt="">
        </h1>
    </div>
</div>

</body>
</html>