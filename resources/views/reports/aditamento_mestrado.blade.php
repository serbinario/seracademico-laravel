<html>
<head>
    {{--Documento personalizado em 04/09/2017 @felipe--}}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title>Contrato - Mestrado</title>
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
            margin-top: 20px;
            text-indent: 3em;
        }
        .uppercase {
            text-transform: uppercase;
        }
        .justificado {
            text-align: justify;
        }
        .subparagrafo {
            margin-top: 20px;
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
        ADITAMENTO AO CONTRATO DE PRESTAÇÃO DE SERVIÇOS DE ASSESSORIA EDUCACIONAL E
        MANUTENÇÃO DE CENTRO DE APOIO A ESTUDANTES BRASILEIROS NO EXTERIOR (MODALIDADE ON- LINE)
    </p>
</div>

<div class="conteudo">
    <p>
        O presente ADITAMENTO refere-se ao contrato já firmado entre as partes abaixo qualificadas, denominado de
        <b>CONTRATO DE PRESTAÇÃO DE SERVIÇOS DE ASSESSORIA EDUCACIONAL E MANUTENÇÃO
            DE CENTRO DE APOIO A ESTUDANTES AOS BRASILEIROS NO EXTERIOR</b>, celebrado pela <b>Universidade Grendal do Brasil – Unigrendal
            (CNPJ 12.147.854/0001-84)</b>, como primeira parte, <b>ALPHA EDUCAÇÃO E TREINAMENTOS Ltda – Me (22.945.385/0001-00)</b>
        como segunda parte, instituições de direito privado, autorizadas à gerencia de Seminários Culturais, Fóruns de Debates, Workshops
        Educacionais, Seminários de Qualiﬁcação de Projetos, Ambientes Virtuais de Ensino Aprendizagem, Mini Cursos Livres e
        Seminários Culturais, com endereço proﬁssional à Rua Gervásio Pires, 826, Boa Vista, Recife, PE, CEP 50050-070,
        Brasil, neste ato reconhecidas como Contratadas e pessoa natural de direito, residente no Estado Brasileiro,
        cidadã em pleno gozo de seus direitos cíveis, abaixo qualiﬁcada e reconhecida como <b>Contratante</b>:
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
        <b>CLÁUSULA PRIMEIRA - DO OBJETO DO PRESENTE ADITAMENTO</b>
    </p>

    <p class="paragrafo">
        Este aditamento refere-se à alteração da CONTRATANTE, denominada de PRIMEIRA PARTE, no referido contrato acima,
        sucedendo-se em sua totalidade, assumindo todas os deveres e responsabilidades antes constituídas à <b>Universidade
        Grendal do Brasil – UNIGRENDAL (CNPJ 12.147.854/0001-84)</b>, à <b>UNIVERSIDAD INTERAMERICANA</b>, criada pela Lei
        Nacional Paraguaya n. 4.200, com RUC 80071652-3, representada pelo Dr. <b>HUGO CÉSAR GÓMEZ SOLÍS</b>, paraguaio,
        portador do RG 625.806, com sede na Rua Victor Haedo, esquina com  Rua Hernandaria, Centro, cidade de
        Assunção, Paraguai.
    </p>

    <p>
        <b>CLÁUSULA SEGUNDA – DAS RESPONSABILIDADES DAS PARTES</b>
    </p>


    <p class="paragrafo">
        As responsabilidades assumidas pela anterior PRIMEIRA PARTE (UNIGRENDAL), como contraprestação aos serviços de
        <b>ASSESSORIA EDUCACIONAL E MANUTENÇÃO DE CENTRO DE APOIO A ESTUDANTES BRASILEIROS</b>, prestados e/ou a serem prestados,
        conforme prevê a Cláusula Segunda do contrato aditado, a Contratante confessa dívida e se obriga a pagar as
        Contratadas, o número e valor de parcelas descritas, conforme o curso e área da pós graduação escolhida na
        qualificação acima.
    </p>

    <p class="paragrafo">
        Alteram-se os demais termos pactuados, a seguir descritos:
    <p>

    <p class="titulo_paragrafo">
        Cláusula Terceira:
    </p>

    <p class="paragrafo">
        A <b>Contratante</b> declara expressamente estar ciente dos termos da presente contratação, <b>a qual foi por ela ﬁrmada de livre e
        espontânea vontade</b>,  sendo <b>sua  a  opção  pelo  ensino semipresencial ou blend learning</b>.
        Que também toma ciência da possibilidade da necessidade de serem realizadas viagens ao exterior para fins de submeter-se aos
        trâmites burocráticos de imigração, estudos e a apresentação de sua tese no Paraguay. De toda forma, <b>possui total e completa
        ciência dos procedimentos de nacionalização e convalidação de seus títulos emitidos  no exterior</b>, por intermédio de
        diplomação junto a programas baseados em experiências acadêmicas, bem como tem ciência, que sua participação no
        <b>CENTRO DE APOIO A ESTUDANTES BRASILEIROS</b> não conﬁgura aulas e/ou qualquer atividade regulamentada no Brasil,
        mas sim oferta de subsídios à educação realizada a distância, ou presencialmente no Paraguay.
    <p>

    <p class="subparagrafo">
        <b>Parágrafo Primeiro:</b> [Sem alteraçoes]
    </p>

    <p class="subparagrafo">
        <b>Parágrafo Segundo:</b> A <b>Contratante</b> se compromete a elaborar e publicar 01 (hum) artigo por ano acadêmico em
        períodico acadêmico indexado no QUALIS/CAPES.
        A referida indexação da revista pode ser consultada através da Plataforma SUCUPIRA, no endereço eletrônico:
        https://sucupira.capes.gov.br/sucupira/public/consultas/coleta/veiculoPublicacaoQualis/listaConsultaGeralPeriodicos.jsf
    </p>

    <p class="subparagrafo">
        <b>Parágrafo Terceiro:</b> [Sem alteraçoes]
    </p>
    <p class="subparagrafo">
        <b>Parágrafo Quarto:</b> [Sem alteraçoes]
    </p>
    <p class="subparagrafo">
        <b>Parágrafo Quinto:</b> [Sem alteraçoes]
    </p>

    <p class="subparagrafo">
        <b>Parágrafo Sexto:</b> Quanto à viagem ao exterior:<br>
        <b>a.</b> Quanto ao pagamento do procedimento de imigração e documentações acadêmicas, o aluno tem ciência
        que pagará uma taxa administrativa ao despachante no Paraguai, para tanto, o aluno será informado
        acerca do valor a ser pago ao referido despachante em momento anterior à sua viagem, prazo jamais menor
        que 30 (trinta) dias, e num valor nunca excedente a um salário mínimo e meio.<br>
        <b>b.</b> Quanto à estada no País estrangeiro, esta ocorrerá às expensas do próprio aluno,
        assim como quaisquer valores referentes à sua viagem.
    </p>

    <p class="subparagrafo">
        <b>Parágrafo Setimo:</b> Quando o CONTRATANTE se ausentar/faltar às aulas poderá repô-las, desde que pague o valor de uma
    aula, a depender do módulo e da disciplina que deixou se assistir aula, condicionando-se a reposição, todavia à
    existência de novo módulo com aula idêntica àquela que obteve falta.
    </p>

    <p class="titulo_paragrafo">
        Cláusula Quarta: [sem alterações].
    </p>


    <p class="titulo_paragrafo">
        Cláusula Quinta:
    </p>


    <p class="titulo_paragrafo">
        Cláusula Terceira:
    </p>
    <p class="paragrafo">
        O presente instrumento poderá ser rescindido nas seguintes hipóteses:
    <p>

    <p class="subparagrafo">
        a. [sem alterações].<br>
        b. Através do requerimento expresso da Contratante, assistido ou representado, quando for o caso de trancamento de matrícula,
        sendo em qualquer caso, condição obrigatória de sua eﬁcácia a comunicação da desistência da primeira parte Contratada, e o
        pagamento de multa no valor de R$50,00 referente a taxa de trancamento, quando o CONTRATANTE poderá retornar ao curso em
        até 24 (vinte e quatro) meses, fazendo o pagamento da rematrícula.<br>
        c. Observado pela coordenação, bem como orientador, o plágio no trabalho de tese ou dissertação, ou que seja investigado ou
        denunciado ao teor do art 184, do Código Penal Brasileiro;<br>
        d. [sem alterações].<br>
        e. [sem alterações].
    </p>


    <p class="subparagrafo">
        <b>Parágrafo Primeiro:</b> [Sem alteraçoes]
    </p>

    <p class="subparagrafo">
        <b>Parágrafo Segundo:</b> [Sem alteraçoes]
    </p>

    <p class="subparagrafo">
        <b>Parágrafo Terceiro:</b>Ocorrendo a desistência unilateral do contrato, com comunicação escrita de 30 (trinta) dias
        antes de vencer a parcela seguinte, o Contratado ﬁca autorizado a cobrar ou reter 10% (dez por cento) do saldo
        total do plano ﬁnanceiro escolhido.
        <br>a. Se, suspendendo-se o contrato pelo prazo de 24(vinte e quatro) meses, o aluno não regressar ao
        curso, dará causa à desistência unilateral, podendo ser cobrado do valor referido no parágrafo terceiro.

    </p>
    <p class="subparagrafo">
        <b>Parágrafo Quarto:</b> [Sem alteraçoes]
    </p>

    <p class="subparagrafo">
        <b>Parágrafo Quinto:</b> [Sem alteraçoes]
    </p>

    <p class="subparagrafo">
        <b>Parágrafo Sexto:</b> [Sem alteraçoes]
    </p>

    <p class="subparagrafo">
        <b>Parágrafo Sétimo:</b> [Sem alteraçoes]
    </p>

    <p class="titulo_paragrafo">
        Cláusula Sexta: [sem alterações].
    </p>

    <p class="titulo_paragrafo">
        Cláusula Sétima: [sem alterações].
    </p>

    <p class="subparagrafo">
        <b>Parágrafo Primeiro:</b> [Sem alteraçoes]
    </p>

    <p class="subparagrafo">
        <b>Parágrafo Segundo:</b> [Sem alteraçoes]
    </p>

    <p class="subparagrafo">
        <b>Parágrafo Terceio:</b> [Sem alteraçoes]
    </p>

    <p class="titulo_paragrafo">
        Cláusula Sétima: [sem alterações].
    </p>
    <p class="paragrafo">
    A emissão dos diplomas internacionais ocorrerá em até 150 (cento e cinquenta) dias úteis e o prazo para entrega do
    diploma convalidado nacionalmente é de até 300 (trezentos) dias úteis a contar da data da entrega da dissertação deﬁnitiva.
    </p>

    <p class="titulo_paragrafo">
        Cláusula Nona: [sem alterações].
    </p>

    <p class="titulo_paragrafo">
        Cláusula Décima: [sem alterações].
    </p>
    <p class="paragrafo">
        As partes escolhem como domicílio forense a cidade do Recife, para dirimir quaisquer conflitos extrajudiciais ou judiciais.

    </p>



    <div style="margin-top: 0px;">

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