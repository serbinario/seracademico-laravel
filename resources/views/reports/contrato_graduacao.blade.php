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

        td {
            font-size: 15px;
        }

        .termos{
         text-align: justify;
            margin-bottom: 20px;
        }

        .centro {
            text-align: center;
        }

        .logoTimbrado {
            position: relative;
            margin-top: -50px;
            margin-left: -15px;
        }

        .tituloTimbrado {
            position: relative;
            margin-top: -175px;
            left: 190px;
            color: #273176;
            font-size: 12px;
            text-align: justify;
        }

        .rodapeTimbrado {
            /*position: absolute;*/
            /*margin-top: 546px;*/
            color: #273176;
            font-size: 12px;
            text-align: center;
        }

        .titulo {
            /*margin-top: 130px;
            margin-bottom: 70px;*/
            text-align: center;
            font-size: 15px;
        }
    </style>
    <link href="" rel="stylesheet" media="print">
</head>
<body>

<div>
    <div class="logoTimbrado">
        <img style="width: 220px; height: auto;" src="{{asset('img/logo_alpha_faculdade-01.png')}}">
    </div>
    <div style="color: #273176; position: absolute; left: 155px; top: 40px; font-size: 12px;">
        20570
    </div>
    <div style="width: 490px; height: 80px;">
        <p class="tituloTimbrado"><br><br>
            Portaria Normativa de Credenciamento da Faculdade ALPHA nº 1.248 de 29 de setembro de 2017,
            Portaria nº 1.062, de 06 de outubro de 2017 sobre autorização dos Cursos: Bacharelado em
            Administração, Licenciatura em Pedagogia, Tecnólogos em Gestão de Recursos Humanos e Análise de
            Desenvolvimento de Sistemas.
        </p>
    </div>
</div>
<div style="margin-top: 55px;">
    <img style="width: 100%; height: auto;" src="{{asset('img/linha_declaracao_declaracao.png')}}">
</div>
<br />
<div class="centro">
    CONTRATO DE PRESTAÇÃO DE SERVIÇOS EDUCACIONAIS COM CLÁUSULA DE INSTITUIÇÃO DE ARBITRAGEM, EM QUE, CASO O CONTRATANTE,
    FACULTATIVAMENTE CONCORDE COM A SUA INSTITUIÇÃO, HAVERÁ DECLARAÇÃO EXPRESSA DE SUA ANUÊNCIA.
</div><br>

Pelo presente Instrumento Particular:<br>

<div class="termos">
    a) De um lado ALPHA SISTEMA EDUCACIONAL E TREINAMENTO LTDA ME, com sede na Rua Gervásio Pires, 286, Santo Amaro,
    Recife - PE - CEP 50.050-415, mantenedora da FACULDADE ALPHA, inscrita no CNPJ/MF sob o nº 15.708.483/0001-50,
    lotada no mesmo endereço, neste ato, representada pela Professora Luciana Teixeira Vitor, doravante denominada CONTRATADA;
</div>

<div class="termos">
    b)	Por outro lado {{$aluno['pessoa']['nome']}}, devidamente qualificado no anverso da última folha deste Contrato,
    doravante denominado CONTRATANTE, o qual teve seu REQUERIMENTO DE ADESÃO AO CONTRATO DE MATRÍCULA devidamente DEFERIDO,
    sendo o mesmo, parte integrante do presente CONTRATO, tem entre si, justa e contratada a PRESTAÇÃO DE SERVIÇOS EDUCACIONAIS,
    regida pelas cláusulas do presente instrumento.
</div>

CONSIDERANDO que:<br>

<div class="termos">
    a)	O CONTRATANTE requereu e teve deferido o pedido de matrícula do Aluno (que é o próprio CONTRATANTE ou RESPONSÁVEL LEGAL),
    necessitando ser regulamentados os termos da prestação dos serviços educacionais ofertados pela CONTRATADA;
</div>

<div class="termos">
    b)	O CONTRATANTE tem o interesse em pactuar com a CONTRATADA a prestação dos serviços objeto deste Contrato, com o que
    concorda a CONTRATADA, desde que observadas as cláusulas adiante estabelecidas.
</div>

<div class="termos">
    Ambas as partes, resolvem, mutuamente, firmar o presente CONTRATO DE PRESTAÇÃO DE SERVIÇOS EDUCACIONAIS, COM CLAUSULA DE
    INSTITUIÇÃO DE ARBITRAGEM, EM QUE, CASO O CONTRATANTE, FACULTATIVAMENTE CONCORDE COM A SUA INSTITUIÇÃO, HAVERÁ DECLARAÇÃO
    EXPRESSA DE SUA ANUÊNCIA, que será regido pela legislação aplicável e pelas cláusulas e condições adiante estabelecidas:
</div>

<div class="termos">
    Cláusula 1º - Legislação - O presente Contrato é celebrado sob a égide dos artigos 1º, inciso IV; 5º, inciso II; 173,
    inciso IV; 206, incisos II e III e 209, todos da Constituição Federal; artigos 205, 389, 476 e 597 do
    Código Civil Brasileiro; da Lei 8.078/90 (CDC), Lei 8.880/94, Lei 9.069/95, Lei 9.307/96, 9.394/96 (LDB) e Lei 9.870/99,
    e demais normas legais, mediante cláusulas e condições a seguir especificadas e cujo cumprimento se obrigam mutuamente.
</div>

<div class="termos">
    Cláusula 2º - Objeto - O objeto deste Contrato é a prestação de serviços educacionais pela
    INSTITUIÇÃO DE ENSINO SUPERIOR - IES - ao CONTRATANTE (na pessoa do Aluno), nos termos estabelecidos neste instrumento,
    no Regimento Interno da CONTRATADA e, ainda, no Manual do Aluno.
</div>

<div class="termos">
    Cláusula 3º - O Regimento Interno e o Manual do Aluno encontram-se disponíveis no site da instituição e na biblioteca,
    e deles o CONTRATANTE declara expressamente ter conhecimento.
</div>

<div class="termos">
    Cláusula 4º - DA ADESÃO ON LINE A ESTE CONTRATO VIA INTERNET - As partes contratantes reconhecem a legitimidade e validade
    deste contrato, pela sua adesão via internet. A adesão realizar-se-á do seguinte modo:
</div>

<div class="termos">
    5º - O presente Contrato foi confeccionado obedecendo à legislação em vigor, o Código de Defesa do Consumidor e as
    orientações do Ministério da Educação, e sua eficácia está condicionada ao pagamento da primeira parcela deste Contrato e
    ao adimplemento integral de todos os valores em abertos pactuados entre o CONTRATANTE e a CONTRATADA. A assinatura de novo
    contrato de prestação de serviços educacionais somente se efetivará mediante verificação de pleno cumprimento do presente
    Contrato, e de contratos anteriores entre as partes.
</div>

<div class="termos">
    6º - Declara expressamente o CONTRATANTE ter conhecimento de que o currículo do curso, critérios de avaliação, registros
    de faltas, notas e demais procedimentos operacionais pertinentes ao curso estão disponíveis na Secretaria da CONTRATADA,
    fazendo parte integrante deste Contrato, e que, em virtude de ter lido todas as cláusulas constantes deste Contrato,
    está ciente de todas elas, aceitando-as expressamente.
</div>

<div class="termos">
    7º - Declara o CONTRATANTE, ainda, ter tomado conhecimento prévio sobre os termos deste Contrato, que se encontra
    disponível na biblioteca e na secretaria da Instituição, e ter, por ocasião de sua matrícula, recebido cópia deste contrato.
</div>

<div class="termos">
    8º Ao assinar este instrumento ou aderir ao mesmo através de sua inscrição online, o CONTRATANTE afirma ter ciência do
    inteiro teor do regimento da instituição CONTRATADA, bem como do inteiro teor do Manual Interno Discente e do calendário
    escolar do período letivo, os quais podem ser localizados no seguinte endereço eletrônico: www.alpha.rec.br, obrigando-se
    o Aluno a obedecê-los fielmente.
</div>

<div class="termos">
    9º - Do calendário escolar e da carga horária – É de inteira responsabilidade da CONTRATADA o planejamento e a prestação
    dos serviços educacionais, no que concerne à fixação do calendário escolar, fixação de carga horária, designação dos
    professores, aulas e provas além de outras providências que as atividades docentes exigirem, e que serão realizadas de
    acordo com o exclusivo critério da CONTRATADA.
</div>

<div class="termos">
    10 - A CONTRATADA está expressamente autorizada por força deste Contrato a: I) selecionar e designar locais onde serão
    ministradas as aulas teóricas e práticas, que poderão ser na sede da CONTRATADA, onde ela usualmente realiza suas atividades
    acadêmicas e administrativas, ou em outros locais distintos: II) substituir a qualquer tempo e discricionariamente,
    conforme sua autonomia administrativa, professores e funcionários; III) celebrar convênios com quaisquer outras
    instituições para a realização de aulas teóricas e práticas; IV) alterar a qualquer tempo, o calendário acadêmico;
    V) ministrar aulas em qualquer dia da semana, inclusive aos sábados, ou quaisquer outros dias que se façam necessários
    para atender a exigência do Ministério da Educação para fins de cumprimento do calendário acadêmico; VI) divulgar as
    notas dos discentes (por meio físico ou eletrônico, no PORTAL ACADÊMICO); VII) normatizar regras de funcionamento de
    laboratórios; VIII) realizar quaisquer ações pertinentes ao desenvolvimento do seu objeto social ainda que não previstos
    neste Contrato.
</div>

<div class="termos">
    11 - O CONTRATANTE tem ciência que para a avaliação pedagógica do Aluno, faz-se necessária a realização de avaliações
    (conforme regimento interno da INSTITUIÇÃO). Nos casos em que o aluno não realizar essas avaliações, oferecidas dentro do
    período letivo regular e não apresentar justificativas em tempo hábil, tempo esse, que é definido no Manual Interno do
    Docente e do Discente da CONTRATADA, o mesmo não poderá ofertar reclamações em desfavor dos professores ou da CONTRATADA.
</div>

<div class="termos" style="margin-left: 40px; margin-bottom: 20px;">
    11.1 - Em caso de reprovação por qualquer motivo, o Aluno poderá refazer a disciplina em uma próxima turma da mesma disciplina,
    se possível dentro do mesmo curso, mediante o pagamento do valor descrito no ANEXO II, em regime de dependência, e, ainda,
    com o pagamento da contraprestação prevista no item 37º deste Contrato, fazendo-se necessário requerimento formal na central
    de relacionamento de alunos (“CRA”), cujo deferimento ficará a critério da CONTRATADA, de acordo com a disponibilidade de vaga.
</div>

<div class="termos">
    12 - A CONTRATADA poderá realizar aulas e estágios diurnos nos cursos noturnos de saúde de acordo com a sua disponibilidade,
    planejamento e oferta.
</div>

<div class="termos">
    13 - Todos os cursos poderão ter disciplinas completas ou parciais à distância (EAD – Educação a Distância) com aulas
    presenciais ou semipresenciais, no modelo escolhido pela INSTITUIÇÃO, conforme legislação em vigor e de acordo com o
    planejamento pedagógico/acadêmico da CONTRATADA.
</div>

<div class="termos">
    14 - O CONTRATANTE dos Cursos de Saúde da CONTRATADA, declara neste ato, que tem conhecimento de que poderá estagiar ou
    ter aulas práticas em qualquer Hospital, conveniado ou indicado pela Secretaria Federal, Estadual ou Municipal de Saúde.
</div>

<div class="termos">
    15 - RESCISÃO – A prestação de serviços educacionais objeto deste Contrato, poderá ser rescindida:
    I) em virtude de cancelamento da matrícula, transferência de instituição ou trancamento do curso conforme estipulado
    neste Contrato, no Regimento da CONTRATADA e no Manual Interno do Discente, os quais compõem este instrumento e são do
    conhecimento do CONTRATANTE;
    II) por acordo entre as partes;
    III) por infração disciplinar prevista no Código de Ética, parte integrante e inseparável deste Contrato, que
    justifique, nos termos deste, e da legislação pertinente, seu desligamento do estabelecimento de ensino.
</div>

<div class="termos">
    16 - DO CANCELAMENTO DO CURSO – Reserva-se a CONTRATADA ao direito de cancelar o andamento e funcionamento de qualquer
    turma cujo número de alunos matriculados seja inferior a 40 (quarenta), proporcionando ao Aluno, neste caso, o direito
    de ocupar uma vaga em outra turma da mesma natureza, no mesmo ou em outro turno e/ou curso, desde que exista a turma e a vaga.
</div>

<div class="termos">
    17 - VALOR DO SEMESTRE, FORMA DE PAGAMENTO E BÔNUS PARA QUITAÇÃO EM VENCIMENTOS DIVERSOS – O pagamento do valor dos
    serviços educacionais ora contratados, correspondente ao calendário acadêmico de um semestre, compreendendo o valor da
    semestralidade, devendo ser paga a primeira parcela no ato da matrícula e o saldo ser pago de uma única vez ou em
    parcelas mensais e sucessivas, sob 04 (quatro) formas alternativas (nas formas estabelecidas na tabela constante do anexo
    I – parte integrante do presente contrato), em valores diferenciados, conforme a data do seu pagamento.
</div>

<div class="termos">
    18 - Embora assinado o presente Contrato e atendidos os aspectos formais de sua constituição, o início da sua vigência
    fica subordinado à aprovação do aluno no processo seletivo e ao pagamento do valor da matrícula, de modo que, se o aluno
    NÃO vier a ser aprovado no processo seletivo ou o CONTRATANTE NÃO efetue o pagamento da matrícula, a presente avença NÃO
    cria qualquer obrigação para a CONTRATADA, nem gera, sequer, expectativa de direito para o CONTRATANTE, NÃO produzindo pois,
    qualquer efeito, sendo tido como inexistente.
</div>

<div class="termos">
    CONTRATANTE - _______________________  &emsp; CONTRATADA: ______________________
</div>

<div class="termos">
    19 - Acaso o CONTRATANTE formule requerimento de desistência ou de cancelamento da matrícula ANTES DE INICIADAS AS
    AULAS DO CURSO, terá devolvido o montante equivalente a 70% (setenta por cento) do valor da matrícula,
    sendo os 30% (trinta por cento) restantes, utilizados para cobrir despesas com o pagamento da parcela inicial,
    tais como tributos e despesas administrativas, devendo, entretanto, formular requerimento neste sentido, indicando a
    conta em que deve ser creditado tal valor. Se for conta de titularidade diferente, o requerimento indicando a conta
    deverá, obrigatoriamente, estar com firma reconhecida, e serem indicados os dados completos do beneficiário.
</div>

<div class="termos">
    20 - Se o requerimento de desistência for formulado após o início das aulas, o valor da matrícula e primeira parcela
    não serão restituíveis, e será devido, ainda o pagamento de todas as parcelas devidas com vencimento até o mês da data
    do requerimento.
</div>

<div class="termos">
    21 - No caso do ITEM 16 deste contrato, em não havendo formação de turma, se o aluno não optar por outro curso ou turma,
    o valor da matrícula será integralmente devolvido, desde que assim o requeira por escrito.
</div>

<div class="termos">
    22 - A CONTRATADA poderá ceder no todo ou parte o crédito advindo deste Contrato a Instituição ou Agente Financeiro,
    com o que o CONTRATANTE desde já manifesta o seu pleno consentimento.
</div>

<div class="termos">
    23 - O CONTRATANTE – declara que teve conhecimento prévio das condições financeiras deste Contrato, que foi exposto nos
    quadros de aviso da CONTRATADA e na internet, conhecendo e aceitando-as todas de forma livre e espontânea.
</div>

<div class="termos">
    24 - Os serviços ora contratados têm preços diferenciados, conforme a data do seu pagamento, aceitando a CONTRATADA que,
    a cada parcela, por mera liberalidade dela, possa o CONTRATANTE migrar de uma para outra modalidade do pagamento parcelado,
    vigendo, pois, em cada pagamento, o valor da parcela corresponde ao Contrato das diferentes datas de pagamento, conforme
    o item 17º e o Anexo I deste Contrato.
</div>

<div class="termos">
    25 - DO PAGAMENTO DO BOLETO EXCLUSIVAMENTE EM AGÊNCIA BANCÁRIA OFICIAL – O pagamento dos valores constantes da tabela de
    valores das parcelas, Anexo I, parte integrante deste Contrato, somente poderá ser efetuado em AGÊNCIA BANCÁRIA OFICIAL,
    através de boleto bancário emitido para este fim, sendo vedado o pagamento por quaisquer outros meios ou de qualquer outra
    forma, tais como depósito em conta corrente, depósito efetuado pela Internet, depósito efetuado através de
    DOC – transferência eletrônica, efetuada através de caixa automático e similar, sob pena de não ser dada quitação ao
    CONTRATANTE, que será tratado como inadimplente, sendo obrigado, portanto, a pagar novamente, isso à luz do contido no art.308,
    do Código Civil Brasileiro.
</div>

<div class="termos">
    26 - DO NÃO PAGAMENTO EM CORRESPONDENTE BANCÁRIO – As partes acordam que NÃO poderá haver pagamentos das parcelas deste
    Contrato em Correspondentes bancários, tais como: SERVICEPAG, MULT BANK, LEMON BANK, BANCO MATRIZ, bem como em farmácias,
    redes de supermercados e similares; haja vista o grande número de parcelas pagas nesses locais que não são identificados
    pela CONTRATADA, gerando transtornos e constrangimentos para as partes. Fica, ainda, expressamente vedado, o pagamento de
    qualquer das parcelas da semestralidade a prepostos ou funcionários da contratada, ressalvado o disposto no item 22º e 49º.
</div>

<div class="termos">
    27 - Na hipótese de o CONTRATANTE obter financiamento das parcelas contratadas, seja de qual forma for, como o Programa
    de Financiamento Estudantil do Ministério da Educação - FIES, inclusive mediante concessão de bolsa parcial ou total de
    estudos do Programa Universidade para Todos – PROUNI, ou qualquer outro tipo de bolsas, nas datas de seus respectivos
    vencimentos, até a cessação do gozo do benefício obtido, nos moldes do item 17º deste instrumento contratual.
</div>

<div class="termos">
    28 - Está o CONTRATANTE ciente de que, caso no decorrer do seu curso, perca ele o direito a qualquer benefício de
    Financiamento Estudantil ou de Bolsa de Estudos, por qualquer motivo, estará obrigado a pagar as parcelas relativas à
    prestação de serviços educacionais que não tenham sido alcançadas por financiamento estudantil ou por bolsa de estudos,
    nas respectivas datas de vencimento.
</div>

<div class="termos">
    29 - Especificamente para o caso do FIES, ofertado pelo Fundo Nacional de Desenvolvimento da Educação – FNDE, a legislação
    (Portaria MEC nº 15/2011 e subseqüentes) e os contratos relativos àquele financiamento preveem várias hipóteses que
    “constituem impedimento à manutenção do financiamento”, dentre  elas “a não obtenção de aproveitamento acadêmico em pelo
    menos 75% das disciplinas cursadas pelo estudante no último período letivo financiado pelo FIES”, também conhecida como
    “rendimento insatisfatório”. Nesta hipótese, acaso o CONTRATANTE venha a renovar a matrícula estando ciente de que o Aluno
    não obteve rendimento satisfatório, fica expressamente informado de que terá que arcar, sem uso do financiamento, isto é,
    de forma direta, mensalmente, com as parcelas da semestralidade de seu curso, nos moldes do item 17º.
</div>

<div class="termos">
    30 - Exclusivamente na hipótese do item anterior, uma vez que a renovação de matrícula para os alunos que já sejam beneficiários
    do FIES se dá independentemente do pagamento da primeira parcela da semestralidade (matrícula – que será futuramente
    coberta pelo financiamento estudantil), e, por via de consequência, como a renovação do contrato de prestação de serviços
    educacionais se dá anteriormente à abertura do período de aditamento do FIES, fica expressamente consignado que, encerrado
    o prazo para o aditamento do FIES e esgotadas as possibilidades de renovação excepcional do Financiamento Estudantil junto
    ao Fundo Nacional de Desenvolvimento da Educação – FNDE, inviabilizando, por qualquer motivo, a continuidade do seu
    Financiamento Estudantil, será o CONTRATANTE cobrado de todas as parcelas relativas ao semestre não acobertado pelo
    Financiamento Estudantil, e pelo pagamento delas será responsável inteiramente.
</div>

<div class="termos">
    31 - A falta de fornecimento de boleto ou aviso de cobrança pela CONTRATADA não justifica a ausência de pagamento da
    parcela no seu vencimento, ficando acordado que constitui obrigação do CONTRATANTE diligenciar para coletar e receber o
    boleto para o pagamento nas centrais de informações e centrais de atendimento financeiro da CONTRATADA ou ainda na
    Biblioteca da Instituição, e que este procedimento deve ser realizado pelo CONTRATANTE independentemente de aviso da CONTRATADA.
</div>

<div class="termos">
    32 - O pagamento integral da primeira parcela da semestralidade constitui-se pré-requisito para o ato da assinatura do
    presente Contrato e matrícula, sendo imprescindível o seu pagamento para a celebração e concretização do Contrato. Fica
    certo e ajustado entre as partes que a assinatura do Contrato reserva a vaga do Aluno, não podendo ser disponibilizada
    para outro aluno. A primeira parcela paga somente será devolvida nas hipóteses expressamente previstas neste instrumento,
    e nos percentuais fixados expressamente.
</div>

<div class="termos">
    33 - Os valores pagos a títulos de semestralidade aludidos no item 17º deste contrato referem-se, EXCLUSIVAMENTE, à
    prestação de serviços da Carga Horária constante do Plano de Estudos especificado no Anexo III a este contrato, ordenadas
    por período(Semestre).
</div>

<div class="termos">
    34 - O valor pago por cada disciplina é calculado de acordo com o número de horas aula de cada matéria, considerando a
    estrutura curricular de cada Curso no semestre letivo. Desse modo, o valor por disciplina, será obtido a partir da média
    ponderada no número de disciplinas por período, o número de horas aula de cada disciplina efetivamente cursada e o valor
    da semestralidade que a disciplina esteja inserida. Levar-se-á, ainda, em consideração, o turno do curso que o
    CONTRATANTE (Aluno) esteja matriculado.
</div>

<div class="termos">
    35 - A cobrança das semestralidades será realizada de acordo com o número de disciplinas cursadas pelo Aluno no semestre.
    Assim, caso o aluno curse a totalidade da grade curricular, pagará o valor total da semestralidade e/ou mensalidade.
    O número mínimo e máximo de disciplinas a serem cursadas pelo aluno será regulamentado pelo Regimento Interno.
</div>

<div class="termos">
    36 - Em caso de dispensa de disciplina, por qualquer razão, o Aluno ou o CONTRATANTE pagará a título de mensalidade/semestralidade,
    apenas os valores relativos às disciplinas cursadas naquele semestre, ou seja, o pagamento da semestralidade/mensalidade
    será proporcional ao número de disciplinas cursadas, conforme o item 35º, preservada a primeira parcela que será integral.
</div>

<div class="termos">
    37 - Caso o Aluno complemente a grade com disciplinas de outros períodos, cursando o período que está regularmente inscrito
    e adicionado outras disciplinas que são obrigatórias para a conclusão do Curso, mas que ainda não tenham sido realizadas
    por qualquer motivo, deverá pagar, além do valor da semestralidade/mensalidade do período regulamente inscrito, o valor
    referente a cada disciplina extra cursada, o que será calculado conforme o item 34º.
</div>

<div class="termos">
    38 - Em nenhuma hipótese será admitido que o Aluno deixe de cursar alguma das disciplinas previstas para a grade curricular
    do primeiro semestre, de qualquer dos cursos, salvo na hipótese em que este tenha cursado, anteriormente, a referida disciplina,
    e venha a ser dispensado da mesma, por aproveitamento da disciplina, a exclusivo critério da CONTRATADA.
</div>

<div class="termos">
    39 - Serviços Complementares – Fica certo e ajustado que não estão incluídos nos valores da semestralidade tratados no
    item 17º do presente Contrato, os valores dos serviços prestados pela CONTRATADA, diferentes da prestação de serviços da
    carga horária constante do Plano de Estudos especificado no Anexo III a este contrato, serviços esses considerados como
    atividades extracurriculares e complementares, que serão fixados e cobrados pela CONTRATADA, de acordo com a Resolução
    número 153 de 07/11/05 do Conselho Superior da CONTRATADA.
</div>

<div class="termos">
    40 -  Da exclusão dos valores contratuais – Ficam, desta forma, expressamente excluídos do valor ora contratado, aqueles
    valores referentes a serviços realizados pela CONTRATADA e usufruído pelo discente, tais como: segunda chamada; reabertura
    de matrícula; isenção de disciplina; reingresso; revisão de prova; renovação de bolsa de estudo ou financiamento estudantil;
    segunda via de outros serviços relativos ao fornecimento de documentos escolares tais como; guia de transferências;
    confecção de diploma ou certificado; históricos escolares; declaração de escolaridade; cópias de documentos escolares;
    segunda via de boleto bancário; atestado de frequência; declaração de conclusão de curso ou de disciplina;
    segunda via de carteira do aluno; atestados; cartões de identificação e acesso dos discentes aos recintos da CONTRATADA,
    dentre outros, os quais serão fixados para todo o prazo de vigência do Contrato sendo divulgados neste ato para o CONTRATANTE,
    que fica ciente de seus valores, conforme disposto no Anexo II ao presente Contrato.
</div>

<div class="termos">
    41 O CONTRATANTE está ciente e concorda expressamente que todos os materiais indicados e solicitados pelos docentes para
    estudos curriculares, tais como livros, cópias de textos (ressalvados os que fazem parte do acervo da biblioteca da CONTRATADA),
    batas para uso em laboratórios, etc., são de inteira responsabilidade do CONTRATANTE, e por ele devem ser adquiridos<adquiridos></adquiridos>.
</div>

{{--<div class="termos">
    42 Não estão incluídos neste Contrato os materias para aulas práticas dos alunos dos cursos de saúde a exemplo dos
    Cursos de Odontologia e Medicina, que deverão ser adquiridos e trazidos pelo Aluno, a exemplo de luvas, seringas, kit´s
    de odontologia, alicates, materiais cirúrgicos, moldes, resinas, etc.
</div>--}}

<div class="termos">
    42 Taxas Internas – Reserva-se a CONTRATADA o direito de cobrar pelo fornecimento de quaisquer serviços e ou documentos,
    de acordo com a tabela constante do Anexo II deste Contrato, e em caso de omissão na presente tabela, de acordo com as
    tabelas afixadas nos quadros de avisos da CONTRATADA, distribuídos nos corredores da FACULDADE.
</div>

<div class="termos">
    43 Serão isentos de pagamento de valores os processos de análise administrativa e as apresentações de Aproveitamento de
    Disciplinas, quando os programas das disciplinas forem entregues na Secretaria, no ato do ingresso do Aluno na IES.
    Os programas que forem entregues após a matrícula do aluno, estão sujeitos a todo o processo administrativo de análise
    por parte do corpo docente da IES, o que acarretará a cobrança por tais serviços prestados, conforme a tabela descrita
    como Anexo II deste Contrato. Ou seja, será cobrado por pacote de disciplinas entregues.
</div>

<div class="termos">
    44 TRANSFERÊNCIAS – Para transferência do Aluno de outra IES são necessários:
    a) guia em papel timbrado, devidamente identificado, informando a transferência do vínculo existente com a IES;
    b) histórico escolar contendo todas as disciplinas cursadas, aprovadas ou não e as que faltam cursar;
    c) cópia de autorização do curso, expedida pelo Ministério da Educação;
    d) cópia da situação do aluno, no cadastro do Censo Superior ou um documento, expedido pela IES, explicando a sua inexistência;
    e) conteúdo programático de todas as disciplinas cursadas pelo Aluno, nas quais o mesmo obteve aprovação.
</div>

<div class="termos">
    45 - Da devolução de valores e das informações necessárias – Concorda e aceita o CONTRATANTE que em caso de requerimento
    solicitando devolução de valores de qualquer natureza, feitos em requerimentos próprios perante a CONTRATADA
    desde que, aprovado expressamente pela CONTRATADA, o CONTRATANTE deve informar no próprio requerimento, número de conta
    bancária para recebimento dos valores deferidos, o que se fará no prazo máximo de 15 dias úteis do deferimento.
</div>

<div class="termos">
    46 - Variações do valor contratual – Os valores dos serviços educacionais fixados neste Contrato poderão ser objeto de
    reajuste pela aplicação do IGP-M ou por qualquer outro índice oficial a ser escolhido pela CONTRATADA, e ao seu critério,
    quando houver alteração nas políticas econômicas e/ou salarial, acordo, convenção ou dissídio coletivo ou Lei referente a
    salários do pessoal docente e auxiliar, bem como pela incidência de tributos e/ou contribuição previdenciária advindos de
    normas legais.
</div>

<div class="termos">
    47 - Inadimplemento – Em caso de falta de pagamento na data do vencimento, o valor da parcela será acrescido de multa
    de 2% (dois por cento), cláusula penal moratória, além de juros de 1% (um por cento) ao mês, atualização monetária, com
    a aplicação da variação do IGP-M ou, na sua ausência, índice similar e legalmente previsto, desde a data do vencimento
    até sua liquidação, bem como honorários advocatícios correspondentes a 20% (vinte por cento) sobre o valor da dívida,
    nos termos do novo Código Civil, do Código de Defesa do Consumidor, do Código de Processo Civil, da Lei 8.906/94 e demais
    normas legais em vigor.
</div>

<div class="termos">
    48 - Não procedendo o CONTRATANTE a quitação de seus serviços educacionais nos respectivos vencimentos, fica a CONTRATADA
    autorizada a emitir duplicatas de prestação de serviços, de acordo com os valores devidos, no valor total das parcelas
    em atraso, com os acréscimos legais e ora pactuados, valendo a assinatura do presente Contrato como concordância com
    aquelas, e para todos os efeitos legais, encaminhando após 30 (trinta dias) do vencimento do Departamento jurídico para
    efetivação da cobrança.
</div>

<div class="termos">
    49 - O CONTRATANTE, neste ato, fica ciente e concorda EXPRESSAMENTE, que em caso de inadimplência, perderá todo e
    qualquer desconto de que seja eventualmente beneficiário.
</div>

<div class="termos">
    50 - Da negativação em SPC e/ou SERASA e das cobranças – Em caso de inadimplemento, a CONTRATADA poderá ainda:
    A) NEGATIVAR o devedor em cadastro ou serviços legalmente constituídos e destinados à proteção de tal cobrança;
    B) Promover a cobrança através de advogados ou de empresas especializadas, sendo o CONTRATANTE responsável pelo
    pagamento de todas as despesas decorrentes de tal cobrança extrajudicial, inclusive honorários advocatícios
    extrajudiciais na base de 10% (dez por cento) sobre o valor da dívida;
    C) Promover a cobrança judicial, arcando o CONTRATANTE com honorários advocatícios correspondentes a
    20% (vinte por cento) sobre o valor da dívida, valendo o presente Contrato como título executivo extrajudicial, nos
    termos do art. 784, III, do CPC (Lei nº 13.105/2015), reconhecendo, as partes, desde já, este título, como líquido,
    certo e exigível, ou, ainda, qualquer tipo de cobrança previsto na legislação brasileira, independentemente de prévia
    notificação, podendo tais providências serem tomadas isolada, gradativa ou cumulativamente.
</div>

<div class="termos">
    51 - A CONTRATADA terá direito a recursar a rematrícula, ou a matrícula em qualquer outro curso por ela mantida, ou a
    inscrição em atividade desenvolvida pela IES, mantida pela ALPHA EDUCAÇÃO e TREINAMENTO, quando o CONTRATANTE:
    1. Estiver inadimplente, inclusive em relação à vinculação anterior, independentemente da origem e da espécie do débito
    e da manutenção do direito de cobrança das dívidas contraídas;
    2. Não cumprir as determinações contidas no calendário acadêmico e no Regimento Geral da IES;
    3. Estiver em débito para com obrigações junto ao Sistema de Bibliotecas da IES.
</div>

<div class="termos">
    52 - Direito ao uso da imagem – O CONTRATANTE, neste ato, autoriza expressamente a CONTRATADA, a título gratuito, o
    direito de uso de sua imagem, ou sendo o caso do beneficiário (ALUNO) do qual é responsável legal, para figurar,
    individualmente ou coletivamente, em campanhas institucionais ou publicitárias da CONTRATADA, para todos os efeitos
    legais, em qualquer caso observada a moral e os bons costumes.
</div>

<div class="termos">
    53 - Do trancamento, desistência e Cancelamento do Curso – Para o cancelamento de matrícula, desistência e trancamento
    do Curso, o CONTRATANTE, deverá estar quite com todas as parcelas vencidas do presente Contrato, além de ter o dever de
    pagar o valor da parcela do mês do requerimento, bem como pagar outros débitos eventualmente existentes para com a CONTRATADA.
</div>

<div class="termos">
    54 - Por se tratar de ato solene, a exemplo da matrícula do Aluno, o requerimento de trancamento, desistência e
    cancelamento do curso apenas poderá ser feito de forma presencial, na sede da CONTRATADA, junto ao atendimento pessoal,
    no prazo do calendário acadêmico, caso em que o CONTRATANTE (aluno ou responsável financeiro), preencherá requerimento
    padrão, com assinatura cuja autenticidade deverá ser atestada no ato, ou deverá estar com assinatura com firma reconhecida
    por autenticidade. Isto é, não é admitido e nem será conhecido qualquer requerimento feito de forma eletrônica, através do
    Portal do Aluno.
</div>

<div class="termos">
    55 À exceção do requerimento de que trata a cláusula anterior, que obrigatoriamente deverá ser feito de forma presencial,
    todos os demais requerimentos do CONTRATANTE deverão ser formalizados por meio de formulários próprios disponíveis na
    secretaria da FACULDADE ou on-line, no Portal do Aluno. Não serão aceitas de forma alguma solicitações tácitas, verbais
    ou por formulários distintos daqueles exigidos formalmente pela contratada.
</div>

{{--<div class="termos">
    57 Do uso obrigatório de equipamento de proteção – Os alunos dos cursos dos núcleos de Saúde e de Gastronomia da
    CONTRATADA, ou cursos que dependem do uso de laboratórios, não poderão ter acesso aos laboratórios sem os equipamentos
    adequados de proteção, tais como: roupas adequadas, bata, luvas, equipamentos de proteção individual, sapatos fechados
    e outros que sejam necessários.
</div>

<div class="termos">
    58 Da aquisição de equipamento de proteção – Os equipamentos de proteção individual e assemelhados, quando necessários
    às atividades acadêmicas, devidamente recomendados pelos professores responsáveis, deverão ser adquiridos pelo CONTRATANTE,
    sem nenhum ônus para a CONTRATADA.
</div>--}}

<div class="termos">
    56 Da responsabilidade Objetiva do CONTRATANTE (e do aluno) quanto ao uso dos equipamentos de proteção – O CONTRATANTE
    (e o Aluno) assume(m) inteira responsabilidade por danos que venha(m) a sofrer ou causar fora ou dentro do estabelecimento
    da CONTRATADA, em razão das seguintes situações: a) Inobservância de normas de segurança, das recomendações, instruções
    e alertas de professores, instrutores e funcionários técnicos administrativos, ou pela não utilização e/ou utilização
    inadequada de equipamentos de proteção individual ou assemelhados, quando no exercício de atividades acadêmicas que
    demandarem tal tipo de providência; b) Quando da utilização de equipamentos e instalações da CONTRATADA, ainda que esta
    tenha liberado os equipamentos e instalações.
</div>

<div class="termos">
    57 Obtenção de insumos e materiais para práticas acadêmicas – O CONTRATANTE tem ciência e concorda expressamente que
    todos os insumos e materiais de uso pessoal do Aluno, a exemplo de alimentos para o curso de gastronomia, e luvas para
    o curso de saúde, ENTRE OUTROS, serão adquiridos diretamente pelo Aluno (CONTRATANTE) ou por meio de uma taxa, paga à
    INSTITUIÇÃO DE ENSINO SUPERIOR (IES).
</div>

<div class="termos">
    58 Declarações e Informações do Contratante – Responsabiliza-se o CONTRATANTE pelas informações pessoais fornecidas à
    CONTRATADA, bem como se compromete a atualizá-las em caso de alteração.
</div>

<div class="termos">
    59 O CONTRATANTE assume total responsabilidade quanto às declarações prestadas neste Contrato e no ato de matrícula,
    relativas à aptidão legal do Aluno para a frequência na série e graus indicados, quando for o caso, concordando, desde
    já, que a não entrega dos documentos legais comprobatórios das declarações prestadas, até 30 (trinta) dias corridos,
    contados do início das aulas, acarretará o automático cancelamento da matrícula na vaga aberta ao aluno, rescindindo-se
    o presente Contrato, encerrando-se a prestação de serviços e isentando a CONTRATADA de qualquer responsabilidade decorrente
    da inadimplência do Aluno, não cabendo ao CONTRATANTE (e ao Aluno) qualquer reembolso ou indenização.
</div>

<div class="termos">
    60 Sanções Disciplinares - A CONTRATADA poderá aplicar procedimentos disciplinares ao Aluno, nos termos do seu Regimento,
    do Código de Ética, bem como na legislação pertinente à espécie.
</div>

<div class="termos">
    61 - Responsabilidade Civil – Em caso de dano material ao patrimônio da CONTRATADA, o CONTRATANTE, além da sanção
    disciplinar aplicável, está obrigado ao ressarcimento dos danos causados. O CONTRATANTE é responsável pela integridade
    física (conservação) de todos os livros recebidos a título de mútuo na biblioteca da CONTRATADA; está ciente que arcará
    com a reposição dos mesmos em caso de extravio ou através de indenização por danos materiais, mau uso e deformações
    (riscos, folhas arrancadas e outros); está ciente ainda que deverá pagar as respectivas multas, conforme Anexos I e II,
    quando da falta de devolução dos livros nos prazos estabelecidos, o que poderá inclusive impedir a sua rematrícula.
    Igual responsabilidade existe com relação a quaisquer outros materiais e/ou equipamentos da CONTRATADA utilizados pelo
    CONTRATANTE ou a ele emprestados.
</div>

<div class="termos">
    62 O CONTRATANTE tem ciência e concorda expressamente que os livros de consulta ou acervo de reserva não podem ser
    retirados da Biblioteca, e servem, exclusivamente, para consultas no local. Em caso de descumprimento do presente,
    fica o CONTRATANTE obrigado ao pagamento de uma multa diária na forma do Anexo II deste instrumento.
</div>

<div class="termos">
    63 Da exclusão de responsabilidade – O CONTRATANTE (Aluno) tem ciência e concorda expressamente que a CONTRATADA não
    tem nenhum tipo de responsabilidade por objetos de uso pessoal, a exemplo de celulares, jóias, relógios, câmeras fotográficas,
    laptops, notebooks, ipods e outros adornos e ou acessórios pertencentes ao CONTRATANTE e que seu uso dentro ou fora das
    instalações da CONTRATADA, é de sua inteira e total responsabilidade.
</div>

<div class="termos">
    64 Para acesso às instalações da CONTRATADA, o Aluno deverá comprovar a sua condição. Para tanto, deverá apresentar
    comprovante de vínculo com a IES e ou outro meio de identificação definido pela CONTRATADA.
</div>

<div class="termos">
    65 O não comparecimento do Aluno aos atos escolares ora contratados ou à apresentação de documentos não o exime do
    pagamento das parcelas, tendo em vista a oferta do serviço colocado à sua disposição pela CONTRATADA.
</div>

{{--<div class="termos">
    69 Do prazo de arquivamento das provas/trabalho – As atas de assinatura de prova/trabalho e de recebimento destas,
    serão arquivadas até 30 (trinta) dias do fechamento formal do semestre letivo em que foram confeccionadas.
    Findo este prazo, as provas/trabalhos serão inutilizadas e/ou doados a instituição que os possa aproveitar em beneficio
    de grupos necessitados.
</div>--}}

<div class="termos">
    66 Das necessidades especiais – Na hipótese do Aluno ser portador de necessidades especiais, nos termos dos artigos
    58 e 59 da lei 9.394/96, obriga-se o CONTRATANTE a informar expressamente e por escrito essa condição específica à
    CONTRATADA no ato da assinatura do presente Contrato.
</div>

<div class="termos">
    67 A prestação dos serviços adicionais à pessoa portadora de necessidades especiais e/ou deficiente, será prestada de
    acordo com os seus interesses e efetiva verificação da necessidade. Caso o CONTRATANTE (Aluno), venha a se tornar portador
    de necessidades especiais, no decorrer do semestre letivo, obriga-se ainda o CONTRATANTE não se responsabilizar pelo
    insuficiente desempenho do Aluno em razão da omissão do CONTRATANTE, a quem caberá toda a responsabilidade pela conduta
    omissa.
</div>

<div class="termos">
    68 A CONTRATADA não se responsabilizará pelo insuficiente desempenho do Aluno em razão de omissão do CONTRATANTE em
    informar que o Aluno é portador de necessidades especiais, pois nesse caso, não haverá a prestação de serviço de
    atendimento individual e/ou especializado ao Aluno.
</div>

<div class="termos">
    69 Obriga-se também o CONTRATANTE a informar, no ato da assinatura do presente Contrato, que o Aluno é portador de
    doença e/ou deficiência que o impeça de praticar esportes ou atividades recreativas, ou, ainda, portador de alergias ou
    doenças que o impeçam de manipular certos materiais, principalmente nos cursos de saúde. Caso o CONTRATANTE não informe
    da doença e ou deficiência que impeça o Aluno de praticar esportes ou atividades recreativas, e/ou das alergias ou doenças
    que impeçam o Aluno de manipular certos materiais, não se responsabilizará a CONTRATADA por qualquer evento ocorrido em
    relação ao Aluno, caso em que caberá toda a responsabilidade, pela conduta omissiva, ao CONTRATANTE.
</div>

<div class="termos">
    70 – Dos Cursos Sequenciais – O Contratante, tem ciência que os cursos sequenciais ofertados pela IES, são de complementação
    de estudos com destinação coletiva, sendo regulamentados pelo Ministério da Educação, de acordo com o Art. 44 da LDB:
    sendo que conforme regulamentação específica, não serão emitidos diplomas e sim certificados de conclusão.
</div>

<div class="termos">
    71 – Dos espaços para estacionamento – Tem ciência o CONTRATANTE que a CONTRATADA não disponibiliza espaços gratuitos
    para estacionamento. É cientificado, ainda, ao CONTRATANTE, que todos os espaços para estacionamentos são administrados
    por empresas terceirizadas, e que, para essas empresas garantirem a integridade física dos veículos são obrigados a
    contratar mão de obra especializada e empresas de seguros, e para tanto as mesmas cobram pelo serviço prestado, ficando
    a livre critério do CONTRATANTE aderir ou não ao serviço, e utilizar ou não, tais áreas.
</div>

<div class="termos">
    72 – O  CONTRATANTE fica desde já cientificado que não faz parte deste contrato o estacionamento eventualmente localizado
    no mesmo prédio da IES. Este serviço é oferecido e dirigido por empresa terceirizada, motivo pelo qual todo e qualquer
    assunto ou contrato relativo ao estacionamento deve ser tratado direta e necessariamente com a empresa terceirizada, da
    mesma forma que a IES não é responsável e não assumirá qualquer responsabilidade decorrente de eventuais danos, furtos,
    roubos ocasionados aos veículos, a objetos deixados em seu interior ou aos seus condutores.
</div>

<div class="termos">
    73 – O CONTRATANTE fica ciente, e aceita neste ato expressamente, que na hipótese de inclusão de disciplina, de qualquer
    natureza, além das previstas na grade curricular para o respectivo semestre letivo do curso ou no caso de inclusão, que
    resulte no aumento de disciplina em relação ao semestre anterior, caso o MEC (Ministério da Educação/Fundo Nacional de
    Desenvolvimento da Educação – FNDE), não aceite o acréscimo do valor dessa inclusão no financiamento (FIES), os encargos
    financeiros relativos à diferença do valor não acatado serão de responsabilidade do CONTRATANTE. Caso o CONTRATANTE seja
    pagante, bolsista ou beneficiário de qualquer programa de Financiamento Estudantil, será responsável financeiramente por
    essa inclusão de disciplinas.
</div>

<div class="termos">
    74 – O CONTRATANTE fica ciente, e aceita neste ato expressamente, que nos casos de ingresso do CONTRATANTE, na IES
    CONTRATADA, por meio de transferência de outra IES, na hipótese de o – Ministério da Educação / Fundo Nacional de
    Desenvolvimento da Educação – FNDE – não autorizar o valor do aditamento de transferência do Financiamento Estudantil em
    sua integridade, a diferença dos encargos financeiros será de inteira responsabilidade do CONTRATANTE.
</div>

<div class="termos">
    75 – Pactuação Facultativa de Compromisso Arbitral nos Termos da Lei 9.307/96, subscrita por iniciativa do contratante:
    fica de logo estabelecido, em caráter definitivo, que qualquer litígio originário ou relacionado com o presente contrato,
    e com as renovações semestrais da prestação de serviços educacionais, será definitivamente resolvido por arbitragem,
    de acordo com o regulamento de arbitragem de qualquer tribunal arbitral com sede no mesmo município onde seja realizada
    a prestação de serviços contratada, ou, ainda, na capital do respectivo Estado onde sejam prestados esses serviços,
    através de um ou mais árbitros nomeados e a sentença por eles(s) prolatada poderá ser executada em qualquer juízo que
    sobre ela tenha jurisdição.
</div>

<div class="termos">
    CONTRATANTE	CONTRATADA
</div>

76 – QUALIFICAÇÃO CONTRATANTE E ALUNO<br>

<div class="termos">
    Declaração do CONTRATANTE, em observância ao disposto no Art. 46, da Lei 8.078/90, declara expressamente o CONTRATANTE
    que, em virtude de ter lido todas as cláusulas constantes deste contrato, está ciente de todas elas, aceitando-as
    expressamente e de ter recebido cópia deste contrato devidamente assinado pelas partes e pelas testemunhas.<br> <br>
    Recife, <?php $data = new DateTime('now'); data($data->format('d'), $data->format('m'), $data->format('Y'), $data->format('w')); ?>
</div><br>

<div class="termos">
    <table style="width: 100%;">
        <tr>
            <td>CONTRATANTE</td>
            <td>CONTRATADA</td>
        </tr>
    </table>
</div>

{{--<div>CONTRATANTE</div>

<div style="position: relative; top:-37px; left: 300px; margin-top: 20px;">CONTRATADA</div>--}}
<br /><br /><br />
<div class="termos">
    TESTEMUNHAS
</div>
</body>
</html>
