<html>
<head>
    {{--Documento Criado em 21/05/2018 @Gustavo--}}
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title>Contrato Mestrado</title>

    <style type="text/css">
    #body {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 12px;
        padding-top: 150px;
        margin-left: 16%;
    }

      /*  table { page-break-inside:auto; }
        tr    { page-break-inside:avoid; page-break-after:auto }
        thead { display:table-header-group }
        tfoot { display:table-footer-group }*/

        .table {
            display: block;
            margin-top: 5%;
            margin-right: 5%;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px;
            border: 0.5px solid;
            border-collapse: collapse; 
            width: 700px; 
            max-width: 700px;  
        }
        p{
            font-size: 14px;
        }

        .table tr, .table tr td  {
            position: relative;
            border: 0.5px solid;
        }
        .table td {
            height: 65px;
            padding: 0px;

        }
        .title-table{
            position: absolute;
            top:1px;
            left:1px; 
            font-size: 10px;
            font-weight: bold;
        }
        h2{
            font-size:15px;
        }
        h1{
            font-size: 16px; 
            text-align: center;

        }
        hr{
            border-color: black;
            width: 700px;
            border-bottom: 0.5px;
        }
        #endpage{
            margin-top:200px;
            color: grey;
            font-weight: bold;
            text-align: center;
        }
        #background{
            position: absolute;
            z-index: -11;
            width: 900px;
        }
        #background2{
            position: absolute;
            top:1328px;
            z-index: -11;
            width: 900px;
        }
        #background3{
            position: absolute;
            top:2656px;
            z-index: -11;
            width: 900px;
        }
        #background4{
            position: absolute;
            top:3984px;
            z-index: -11;
            width: 900px;
        }
        #header{
            padding-right:30px;

        }
        .page{
            height: 916px;
            width: 100%;
        }
        #page2{
            margin-top: 50px;
        }
        .assinaturas{
            width: 300px;
        </style>
    </head>

    <body> 
        <img  id="background" src="{{ asset('/img/fundo_atenas.jpg') }}">
        <div id="body">
            <div class="page" id="page1">
                <div id="header"> 
                    <h1 style="text-align: center;">
                        CONTRATO DE PRESTAÇÃO DE SERVIÇOS DE ASSESSORIA<br>
                        EDUCACIONAL PARA INTEGRALIZAÇÃO DE CRÉDITOS<br>
                        ACADÊMICOS DE MESTRADO INTERNACIONAL
                    </h1>     
                </div>
                <div class="informacoes_pessoas">
                    <p style="font-size: 15px;"><b><u>CONTRATANTE:</u></b>
                        <p style="font-size: 14px;">Pessoa natural de Direito, residente no Estado Brasileiro, cidadão em pleno gozo de seus direitos
                        Cíveis, abaixo qualificado: </p>
                    </p>
                    <table class="table">
                        <tr>
                            <td colspan="6"><spam class="title-table"> NOME:</spam><br>{{$aluno['pessoa']['nome']}}</td>
                        </tr>
                        <tr>
                            <td colspan="4"><spam class="title-table"> ENDEREÇO:</spam><br>{{ isset($aluno['pessoa']['endereco']) ? $aluno['pessoa']['endereco']['logradouro'] : "" }}</td>
                            <td colspan="2" width="20%"><spam class="title-table"> Nº:</spam><br> {!! isset($aluno['pessoa']['endereco']) ? $aluno['pessoa']['endereco']['numero'] : "" !!}</td>
                        </tr>                   
                        <tr>
                            <td colspan="2"><spam class="title-table"> CIDADE:</spam><br>{{ isset($aluno['pessoa']['endereco']['bairro']['cidade']) ? $aluno['pessoa']['endereco']['bairro']['cidade']['nome'] : "" }}</td>
                            <td colspan="2"><spam class="title-table"> UF:</spam><br>{{ isset($aluno['pessoa']['endereco']['bairro']['cidade']['estado']) ? $aluno['pessoa']['endereco']['bairro']['cidade']['estado']['nome'] : "" }}</td>
                            <td colspan="2"><spam class="title-table"> CEP:</spam><br>{{ isset($aluno['pessoa']['endereco']['cep']) ? $aluno['pessoa']['endereco']['cep'] : "" }}</td>
                        </tr>
                        <tr>
                            <td colspan="1"><spam class="title-table">  Data de Nascimento:</spam><br>{!! isset($aluno['pessoa']['data_nasciemento']) ? $aluno['pessoa']['data_nasciemento'] : "" !!} </td>
                            <td colspan="2"><spam class="title-table"> ID/RG Nº:</spam><br>{{ isset($aluno['pessoa']['identidade']) ? $aluno['pessoa']['identidade'] : "" }}</td>
                            <td colspan="2"><spam class="title-table"> CPF/MF Nº:</spam><br>{{ isset($aluno['pessoa']['cpf']) ? $aluno['pessoa']['cpf'] : "" }} </td>
                            <td colspan="1"><spam class="title-table"> ORGÃO :</spam><br> {{ isset($aluno['pessoa']['orgao_rg']) ? $aluno['pessoa']['orgao_rg'] : "" }}</td>
                        </tr>
                        <tr>
                            <td colspan="1"><spam class="title-table"> ESTADO CIVIL:</spam><br>{{ isset($aluno['pessoa']['estadoCivil']) ? $aluno['pessoa']['estadoCivil']['nome'] : "" }}</td>
                            <td colspan="2"><spam class="title-table"> NACIONALIDADE:</spam><br>{{ isset($aluno['pessoa']['nacionalidade']) ? $aluno['pessoa']['nacionalidade'] : "" }}</td>
                            <td colspan="2"><spam class="title-table"> NATURALIDADE:</spam><br>{{ isset($aluno['pessoa']['naturalidade']) ? $aluno['pessoa']['naturalidade'] : "" }}</td>
                            <td colspan="1"><spam class="title-table"> UF:</spam><br>{!! isset($aluno['pessoa']['endereco']['bairro']['cidade']['estado']) ? $aluno['pessoa']['endereco']['bairro']['cidade']['estado']['prefixo'] : "" !!} </td>
                        </tr>
                        <tr>
                            <td colspan="1"><spam class="title-table"> TEL.COM.:</td>
                                <td colspan="1"><spam class="title-table"> TEL.RES.:</spam><br>{!! isset($aluno['pessoa']['telefone_fixo']) ? $aluno['pessoa']['telefone_fixo'] : "" !!} </td>
                                <td colspan="2"><spam class="title-table"> TEL.CEL.:</spam><br>{!! isset($aluno['pessoa']['celular2']) ? $aluno['pessoa']['celular2'] : "" !!} </td>
                                <td colspan="2"><spam class="title-table"> WHATZAP:</spam><br>{!! isset($aluno['pessoa']['celular']) ? $aluno['pessoa']['celular'] : "" !!}</td>
                            </tr>
                            <tr>
                                <td colspan="3"><spam class="title-table"> PROFISSÃO:</td>
                                    <td colspan="3"><spam class="title-table"> E-MAIL:</spam><br>{!! isset($aluno['pessoa']['email']) ? $aluno['pessoa']['email'] : "" !!} </td>
                                </tr>
                                <tr>
                                    <td colspan="3"><spam class="title-table"> NOME DO PAI:</spam><br>{!! isset($aluno['pessoa']['nome_pai']) ? $aluno['pessoa']['nome_pai'] : "" !!} </td>
                                    <td colspan="3"><spam class="title-table"> NOME DA MÃE:</spam><br>{!! isset($aluno['pessoa']['nome_mae']) ? $aluno['pessoa']['nome_mae'] : "" !!} </td>
                                </tr>
                                <tr>
                                    <td colspan="6"><spam class="title-table"> SERVIÇO:</spam><br> <b>CONTRATO DE PRESTAÇÂO DE SERVIÇOS DE ASSESSORIA EDUCACIONAL PARA INTEGRALIZAÇÃO
                                    DE CRÉDITOS ACADÊMICOS DE MESTRADO INTERNACIONAL.</b></td>
                                </tr>
                            </table>
                        </div>    
                    </div>
                </div>  
                <center>
                    <span id=endpage> <br><br><br><br><br><br><br><br>ATENAS COLLEGE <br><br>

                    WhatsApp (11) 95290-8507 </span>
                </center> 
                <img  id="background2" src="{{ asset('/img/fundo_atenas.jpg') }}">
                <div class="page" id= "page2" style="margin-left: 16%;">

                    <div style="width: 700px;text-align: justify; font-size: 14px;position: relative; top:100px; ">
                        <b><u>CONTRATADA:</u></b><br><br><br>
                        A ATENAS COLLEGE, instituição de direito privado, devidamente registrada no Estado da
                        Delaware, Estados Unidos da América, sob a razão social de ATENAS COLLEGE CORP,
                        mantenedora da ATENAS COLLEGE, devidamente registrada no Estado de Dalaware, sobre
                        número de identificação (ID Number) 37-1838647, neste ato representado pelo seu Diretor
                        Presidente Sr. Marcelo Barbosa Santos, devidamente registrado no Brasil e inscrito no CPF
                        número 669.788.901-20, e no RG nº 1.758.132/DF.<br>
                        Decidem celebrar o presente CONTRATO DE ASSESSORIA para a INTEGRALIZAÇÃO DE
                        CRÉDITOS ACADÊMICOS NA ATENAS COLLEGE. As partes possuidoras de capacidade
                        jurídica resolvem celebrar o presente contrato, com o objetivo de formalizar os serviços
                        educacionais, em observância com a lei nº. 10.406/02, Decreto nº. 5.622/2005 e demais
                        legislações pertinentes em vigor, nos termos adiante firmados, mediante as cláusulas e
                        condições a seguir especificadas:<br>
                        CLÁUSULA PRIMEIRA – DO OBJETO DO CONTRATO<br>
                        O presente instrumento tem por objeto a integralização de créditos de programas de pósgraduação
                        Stricto Sensu outorgado ao CONTRATANTE pela ATENAS COLLEGE, em título
                        de Mestrado, contemplando a assessoria, análise do projeto de pesquisa, grade curricular da
                        IES emitente dos créditos, análise ou desenvolvimento da dissertação, desenvolvimento de
                        pareceres técnicos a adequação necessária à integralização, bem como, o DEFERIMENTO À
                        INTEGRALIZAÇÃO;<br>
                        Parágrafo Primeiro – A CONTRATADA neste ato assessora o CONTRANTE no processo de
                        integralização dos créditos acadêmicos do Programa INTEGRALIZAÇÃO DE CRÉDITOS
                        ACADÊMICOS da ATENAS COLLEGE que o CONTRATANTE adquiriu através de programas
                        realizados em outras IES, conforme documentação enviada.<br>
                        Parágrafo Segundo – O CONTRATANTE declara expressamente estar ciente dos termos da
                        presente contratação, “a qual foi por ele firmada de livre e espontânea vontade. Possui
                        total e completo conhecimento dos procedimentos de nacionalização e reconhecimento
                        de seus títulos emitidos no exterior junto a universidades brasileiras, e reconhece que a
                        CONTRATADA não é responsável por esse serviço, reafirmando sua completa ciência
                        sobre os processos de reconhecimento de títulos, estando sob suas responsabilidades”.<br>
                        CLÁUSULA SEGUNDA – DAS OBRIGAÇÕES<br>
                        Parágrafo Primeiro – O CONTRATADO fica responsável em nomear uma equipe técnica, tão
                        logo assinem este instrumento, a qual fará a interface com a CONTRATANTE, com o objetivo
                        de desenvolver um cronograma de trabalho, o qual possibilite a criação de um fluxo de
                        documentos necessários para o desenvolvimento dos trabalhos que são objetos deste
                        instrumento;<br>
                        Parágrafo Segundo – O cronograma a que se refere o parágrafo primeiro da cláusula segunda
                        deverá ser concluído até 05 dias após a assinatura deste instrumento, devendo em comum
                        acordo entre a CONTRATANTE e o CONTRATADO, ficar estabelecido os responsáveis pelas
                        atividades, documentos necessários, datas a serem cumpridas, entre outros itens necessários
                        para o bom andamento dos trabalhos;<br>
                        Parágrafo Terceiro – O CONTRATADO obriga-se a entregar em no máximo 05 (cinco)
                        dias uteis à CONTRATANTE, parecer técnico referente aos documentos recebidos para
                        integralização do título, solicitando documentos que por ventura estejam faltando, ou
                        insuficientes. <br>
                        Parágrafo Quarto – Os documentos devolvidos pelo CONTRATADO à CONTRATANTE,
                        que não tenham condições de prosseguir para a integralização, não serão objeto de
                        quaisquer custos financeiros para a contratante.
                        Parágrafo Quinto – O CONTRATADO compromete-se a realizar a integralização dos
                        títulos pela ATENAS COLLEGE.<br>
                        Parágrafo Sexto – O CONTRATADO obriga-se a manter o sigilo e confidencialidade
                        sobre todos os documentos que estiverem sob sua responsabilidade, comprometendo-se
                        a não utilizar nenhuma informação ou dados em qualquer que sejam as circunstâncias
                        fora do objeto deste instrumento;<br>
                        Parágrafo Sétimo – O CONTRATADO compromete-se a não utilizar nenhum dado
                        pessoal do CONTRATANTE sem autorização prévia por escrito;<br>
                        Parágrafo Oitavo – O CONTRATADO assume desde já toda a responsabilidade pelo
                        título que não for integralizado por falta de comprovação dos créditos ou falta de produção
                        acadêmica ou até mesmo por não ser aprovado em banca examinadora, ou seja, pela
                        titulação que se comprometer a integralizar e que por qualquer razão não tenha obtido
                        sucesso na integralização, assumindo em especial toda e qualquer ação judicial ou
                        extrajudicial indenizatória que por ventura a CONTRATANTE venha a sofrer em razão do
                        não cumprimento do presente contrato;<br>
                    </div>
                </div>
                <center>
                    <span id=endpage>  <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br>ATENAS COLLEGE <br><br>

                    WhatsApp (11) 95290-8507 </span>
                </center> 

                <img  id="background3" src="{{ asset('/img/fundo_atenas.jpg') }}">
                <div class="page" id= "page3" style="margin-left: 16%;">

                    <div style="width: 700px;text-align: justify; font-size: 14px;position: relative; top:150px; ">
                     CLÁUSULA TERCEIRA – DAS OBRIGAÇÕES DO CONTRATANTE<br>
                     Parágrafo Primeiro – O CONTRATANTE será o único e exclusivo responsável pelo curso
                     estrangeiro no qual foi certificado, responsabilizando-se pelo conteúdo do mesmo.
                     Parágrafo Segundo – Os documentos que o CONTRATANTE deverá entregar ao
                     CONTRATADO para que se cumpra com o objeto deste instrumento são:<br>
                     <ul>
                        <li>
                           Carteira de Identidade ou Identidade Funcional (dentro do prazo de validade);
                       </li>
                       <li>
                           CPF;
                       </li>
                       <li>
                           Certidão de Nascimento ou Casamento;
                       </li>
                       <li>
                           Comprovante de Residência atualizado com no máximo 90 (noventa) dias;
                       </li>
                       <li>
                           Curriculum Vitae;
                       </li>
                       <li>
                           Diploma de Graduação;
                       </li>
                       <li>
                           Histórico Acadêmico ou Documento Equivalente;
                       </li>
                       <li>
                           Certificado de pós-graduação Lato Sensu;
                       </li>
                       <li>
                           Documentação comprobatório de créditos emitidos por IES que deu origem a
                           requisição de Integralização de Créditos (declaração de conclusão do programa de
                           mestrado, ou mesmo declaração de cumprimento de disciplinas, cópia do Diploma de
                           Mestrado e ementário ou histórico do programa de mestrado).
                       </li><br>
                       Parágrafo Terceiro – O CONTRATANTE compromete-se a manter as atividades que
                       constam no objeto deste instrumento, para que o CONTRATADO cumpra com o processo
                       de integralização dos créditos;<br>
                       CLÁUSULA QUARTA – DA FORMA DE PAGAMENTO<br>
                       Parágrafo Primeiro – A CONTRATATANTE pagará ao CONTRATADO o valor de R$
                       Parágrafo Segundo – A CONTRATATANTE, após realizar o pagamento, deverá
                       encaminhar o comprovante digitalizado para o seguinte correio eletrônico:
                       contact@atenascollege.university, juntamente do formulário devidamente preenchido,
                       constante na primeira página deste contrato.<br>
                       CLÁUSULA QUINTA – DA RESCISÃO<br>
                       a. Através do requerimento expresso do CONTRATANTE, assistido ou representado,
                       quando for o caso, do pedido de rescisão contratual, sendo em qualquer caso, condição
                       obrigatória de sua eficácia a comunicação da desistência à ATENAS COLLEGE, e o
                       pagamento dos valores avençados neste instrumento (PAGAMENTO DE MULTA DE 10%
                       DO VALOR TOTAL DO CONTRATO) até da efetiva rescisão;<br>
                       b. Quando por decisão da CONTRATADA houver a rescisão compulsória deste contrato,
                       pela exclusão do CONTRATANTE em decorrência de descumprimento das normas
                       internas, devidamente apresentadas com base no próprio contrato fornecido pela
                       CONTRATADA no ato da assinatura do mesmo;<br>
                       Parágrafo Primeiro – O pedido de rescisão unilateral do Contrato de Prestação de
                       Serviços feito pelo CONTRATANTE deverá ser fundamentado e protocolado na ATENAS
                       COLLEGE, não dispensando o CONTRATANTE da quitação do pagamento referente ao
                       serviço de integralização, assim como outras despesas eventualmente ocasionadas pelo
                       CONTRATANTE, até a data da solicitação da rescisão do contrato.<br>
                       Parágrafo Segundo – O compromisso ora assumido pelo CONTRATANTE com a
                       CONTRATADA é global e abrange a totalidade das obrigações ora pactuadas, e sua falta
                       por impontualidade nos pagamentos não o isentam de responder integralmente por todas
                       as obrigações aqui assumidas, e constituem causa de rescisão unilateral pela
                       CONTRATADA, da presente contratação.<br>
                       Parágrafo Terceiro – Ocorrendo a desistência unilateral do contrato de prestação de
                       serviço, com comunicação escrita 30 dias antes de vencer a parcela seguinte, a
                       CONTRATADA fica autorizada a cobrar 10% (dez por cento) do saldo total do plano
                       financeiro escolhido.<br>
                       Parágrafo Quarto – No caso de rescisão do contrato, o CONTRATANTE, deverá estar
                       em dia com seus pagamentos e comunicar por escrito a CONTRATADA no prazo máximo
                       de 30 dias antes do vencimento da parcela a vencer.<br>
                       Parágrafo Quinto – Na hipótese de mora no pagamento das mensalidades, o
                       CONTRATANTE pagará multa de 2% e juros moratórios de 12% a.a., mais correção
                       monetária pelo INPC, pro-rata dies.<br>
                       Parágrafo Sexto – Caso o pedido de desistência previsto nesta cláusula não seja
                       formalizado, este contrato continuará em vigor e o CONTRATANTE deverá pagar todas
                       as parcelas previstas no ato da assinatura deste instrumento, podendo a CONTRATADA
                       tomar medidas cabíveis de cobrança. Nesta hipótese, além da cláusula penal prevista no
                       item “a”, incidirão sobre o saldo devedor atualizado os encargos do parágrafo anterior.CLÁUSULA SEXTA – SOLICITAÇÕES DE DOCUMENTOS
                       O CONTRATANTE que solicitar certidões ou outros documentos à ATENAS COLLEGE deverá pagar
                       por cada documento solicitado, tomando como base os valores estipulados em tabela elaborada e
                       informada pela CONTRATADA, os quais se destinam a custear as despesas decorrentes da emissão
                       e envio dos mesmos.<br>
                   </ul>
               </div>
           </div>
           <center>
               <span id=endpage>  <br> <br> <br> <br> <br> <br> <br> <br> <br> <br><br> <br> <br> <br> <br> <br> <br>ATENAS COLLEGE <br><br>

               WhatsApp (11) 95290-8507 </span> 
           </center> 
           <img  id="background4" src="{{ asset('/img/fundo_atenas.jpg') }}">
           <div class="page" id= "page4" style="margin-left: 16%;">
            <div style="width: 700px;text-align: justify; font-size: 14px;position: relative; top:150px; ">
               CLÁUSULA SÉTIMA – DA MANUTENÇÃO DO CADASTRO
               Sempre que o CONTRATANTE mudar de endereço deverá comunicar de imediato por escrito a
               CONTRATADA, sob pena de terem-se como válidas e eficazes todas as correspondências enviadas
               pela CONTRATADA para endereço anterior, constante deste contrato, até a conclusão do processo
               de integralização.<br>
               Parágrafo Primeiro – O CONTRATANTE deverá possuir um endereço eletrônico permanente para
               contato com a CONTRATADA. É de total responsabilidade do (a) aluno (a) adquirir e informar um
               endereço eletrônico a CONTRATADA não importando os meios pelos quais irá adquiri-lo e informá-
               lo.<br>
               Parágrafo Segundo – O CONTRATANTE deverá responder a todas as mensagens enviadas em
               seu endereço eletrônico, no prazo máximo de 72 horas.<br>
               CLÁUSULA OITAVA – DOS DOCUMENTOS SOLICITADOS
               O CONTRATANTE deverá apresentar todos os documentos solicitados pela CONTRATADA, dentro
               do prazo estipulado, a fim de ser admitido no processo de Integralização de Créditos em nível de
               Mestrado.<br>
               Parágrafo Único – O CONTRATANTE deverá apresentar os documentos solicitados no checklist da
               CLÁUSULA TERCEIRA deste contrato pela CONTRATADA dentro do prazo de 5 (cinco) dias uteis
               a contar da data de assinatura deste.<br>
               CLÁUSULA NONA – DA INTEGRALIZAÇÃO DE CRÉDITOS ACADÊMICOS
               O CONTRATANTE declara ter ciência de que a assessoria visa auxiliá-lo no processo de
               INTEGRALIZAÇÃO DE CRÉDITOS ACADÊMICOS, o qual compreende:
               a. A Convalidação dos Créditos Acadêmicos pela ATENAS COLLEGE, após avaliação e aprovação
               pela Secretaria Pedagógica.<br>
               b. A entrega de todos os documentos do aluno ao final do Programa de Mestrado, devidamente
               apostilado na Flórida.<br>
               CLÁUSULA DÉCIMA – DA APROVAÇÃO NO PROGRAMA DE MESTRADO
               O CONTRATANTE deve ter ciência que para receber o diploma deverá ter sua dissertação aprovada
               em banca examinadora pela ATENAS COLLEGE, através da avaliação da dissertação de acordo
               com orientação da CONTRATADA.<br>
               Parágrafo Primeiro – O CONTRATANTE deve ter ciência que após concluído o processo de
               INTEGRALIZAÇÃO DE CRÉDITOS ACADÊMICOS, os documentos passarão por legalização junto
               aos órgãos regulamentadores, para somente após o trâmite final receber o Diploma.<br>
               Parágrafo segundo – A CONTRATADA reserva-se ao direito de não finalizar o processo, caso o
               CONTRATANTE desatenda às exigências estabelecidas neste contrato.<br>
               Parágrafo Terceiro – A CONTRATADA compromete-se a encaminhar os documentos
               imediatamente quando os mesmos estiverem disponíveis. <br><br>
               ATENAS COLLEGE<br>
               WhatsApp (11) 95290-8507<br><br>
               CLÁUSULA DÉCIMA PRIMEIRA – DO FORO<br>
               Fica eleito o foro da Cidade de Delaware, Estados Unidos da América, para dirimir todas as
               questões referentes à execução do presente instrumento, após esgotadas todas as instâncias
               administrativas.<br>
               E, por estarem de pleno acordo, os contratantes assinam o presente convênio, em 02 (duas)
               vias de igual teor e forma, na presença das testemunhas abaixo, para todos os seus jurídicos
               e legais efeitos. <br><br>

               <center><pre>Delaware (USA),  {{ strftime('%d de %B de %Y', strtotime('today')) }}</pre></center>
               <center>
                   <b> <br>_____________________________________<br>
                       CONTRATADO<br>
                       Marcelo Barbosa Santos<br>
                       ATENAS COLLEGE<br><br></b>
                   </center>
                   <center>
                    <b>_____________________________________<br>
                        CONTRATANTE<br></b>
                    </center>
                    <div style="float: left;">
                        <b>TESTEMUNHAS:<br><br>
                            _____________________________________<br>
                            Nome:<br>
                            _____________________________________<br>
                        CPF Nº:</b>
                    </div>
                    <div style="float: right;">
                        <br><br>
                        <b>_____________________________________<br>
                            Nome:<br>
                            _____________________________________<br>
                        CPF Nº:</b>
                    </div>

                </div>
            </div>
            <center>
               <span id=endpage>  <br> <br> <br> <br> <br> <br> <br> <br> <br> <br><br> <br> <br> <br> <br> <br> <br>ATENAS COLLEGE <br><br>

               WhatsApp (11) 95290-8507 </span> 
           </center>

       </body>
       </html>