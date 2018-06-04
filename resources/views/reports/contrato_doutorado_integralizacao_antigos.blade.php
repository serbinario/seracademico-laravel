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
        .link{
            color: blue;
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
        .endpage{
            color: grey;
            font-weight: bold;
            text-align: center;
        }
        #endpage1{
            position: absolute;
            top: 1250px;
            left:30%;
            right:30%;
        }
        #endpage2{
            position: absolute;
            top: 2570px;
            left:30%;
            right:30%;
        }
        #endpage3{
            position: absolute;
            top: 3900px;
            left:30%;
            right:30%;
        }
        #endpage4{
            position: absolute;
            top: 5200px;
            left:30%;
            right:30%;
        }
        #endpage5{
            position: absolute;
            top: 6550px;
            left:30%;
            right:30%;
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
        #background5{
            position: absolute;
            top:5312px;
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
        #page5{
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
                            <td colspan="1"><spam class="title-table"> TEL.COM.:</spam></td>
                            <td colspan="1"><spam class="title-table"> TEL.RES.:</spam><br>{!! isset($aluno['pessoa']['telefone_fixo']) ? $aluno['pessoa']['telefone_fixo'] : "" !!} </td>
                            <td colspan="2"><spam class="title-table"> TEL.CEL.:</spam><br>{!! isset($aluno['pessoa']['celular2']) ? $aluno['pessoa']['celular2'] : "" !!} </td>
                            <td colspan="2"><spam class="title-table"> WHATZAP:</spam><br>{!! isset($aluno['pessoa']['celular']) ? $aluno['pessoa']['celular'] : "" !!}</td>
                        </tr>
                        <tr>
                            <td colspan="3"><spam class="title-table"> PROFISSÃO:</spam></td>
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
            <span class="endpage" id=endpage1>ATENAS COLLEGE <br><br>

            WhatsApp (11) 95290-8507 </span>
        </center> 
        <img  id="background2" src="{{ asset('/img/fundo_atenas.jpg') }}">
        <div class="page" id= "page2" style="margin-left: 16%;">

            <div style="width: 700px;text-align: justify; font-size: 14px;position: relative; top:250px; ">
                <b><u>CONTRATADA:</u></b><br><br><br>
                <b>A ATENAS COLLEGE</b>, instituição de direito privado, devidamente registrada no Estado da
                Delaware, Estados Unidos da América, sob a razão social de <b>ATENAS COLLEGE CORP</b>,
                mantenedora da <b>ATENAS COLLEGE</b>, devidamente registrada no Estado de Dalaware, sobre
                número de identificação (ID Number) 37-1838647, neste ato representado pelo seu Diretor
                Presidente Sr. Marcelo Barbosa Santos, devidamente registrado no Brasil e inscrito no CPF
                número 669.788.901-20, e no RG nº 1.758.132/DF.<br><br>

                Decidem celebrar o presente <b>CONTRATO DE ASSESSORIA para a INTEGRALIZAÇÃO DE
                CRÉDITOS ACADÊMICOS NA ATENAS COLLEGE</b>. As partes possuidoras de capacidade
                jurídica resolvem celebrar o presente contrato, com o objetivo de formalizar os serviços
                educacionais, em observância com a lei nº. 10.406/02, Decreto nº. 5.622/2005 e demais
                legislações pertinentes em vigor, nos termos adiante firmados, mediante as cláusulas e
                condições a seguir especificadas:<br><br><br>


                <b>CLÁUSULA PRIMEIRA – DO OBJETO DO CONTRATO</b><br><br>

                O presente instrumento tem por objeto a integralização de créditos de programas de pósgraduação
                Stricto Sensu outorgado ao <b>CONTRATANTE</b> pela <b>ATENAS COLLEGE</b>, em título
                de <b>Mestrado</b>, contemplando a assessoria, análise do projeto de pesquisa, grade curricular da
                IES emitente dos créditos, análise ou desenvolvimento da dissertação, desenvolvimento de
                pareceres técnicos a adequação necessária à integralização, bem como, o <b>DEFERIMENTO À
                INTEGRALIZAÇÃO</b>;<br><br>

                <b>Parágrafo Primeiro</b> – A <b>CONTRATADA</b> neste ato assessora o <b>CONTRANTE</b> no processo de
                integralização dos créditos acadêmicos do Programa <b>INTEGRALIZAÇÃO DE CRÉDITOS
                ACADÊMICOS da ATENAS COLLEGE</b> que o <b>CONTRATANTE</b> adquiriu através de programas
                realizados em outras IES, conforme documentação enviada.<br><br>

                <b>Parágrafo Segundo</b> – O <b>CONTRATANTE</b> declara expressamente estar ciente dos termos da
                presente contratação, “<b>a qual foi por ele firmada de livre e espontânea vontade. Possui
                    total e completo conhecimento dos procedimentos de nacionalização e reconhecimento
                    de seus títulos emitidos no exterior junto a universidades brasileiras, e reconhece que a
                    CONTRATADA não é responsável por esse serviço, reafirmando sua completa ciência
                sobre os processos de reconhecimento de títulos, estando sob suas responsabilidades</b>”.<br><br><br>


                <b>CLÁUSULA SEGUNDA – DAS OBRIGAÇÕES</b><br><br>

                <b>Parágrafo Primeiro</b> – O <b>CONTRATADO</b> fica responsável em nomear uma equipe técnica, tão
                logo assinem este instrumento, a qual fará a interface com a <b>CONTRATANTE</b>, com o objetivo
                de desenvolver um cronograma de trabalho, o qual possibilite a criação de um fluxo de
                documentos necessários para o desenvolvimento dos trabalhos que são objetos deste
                instrumento;<br><br>

                <b>Parágrafo Segundo</b> – O cronograma a que se refere o parágrafo primeiro da cláusula segunda
                deverá ser concluído até 05 dias após a assinatura deste instrumento, devendo em comum
                acordo entre a <b>CONTRATANTE</b> e o <b>CONTRATADO</b>, ficar estabelecido os responsáveis pelas
                atividades, documentos necessários, datas a serem cumpridas, entre outros itens necessários
                para o bom andamento dos trabalhos;<br><br>

                <b>Parágrafo Terceiro</b> – O <b>CONTRATADO</b> obriga-se a entregar em no máximo 05 (cinco)
                dias uteis à <b>CONTRATANTE</b>, parecer técnico referente aos documentos recebidos para
                integralização do título, solicitando documentos que por ventura estejam faltando, ou
                insuficientes. <br><br>

                <b>Parágrafo Quarto</b> – Os documentos devolvidos pelo <b>CONTRATADO</b> à <b>CONTRATANTE</b>,
                que não tenham condições de prosseguir para a integralização, não serão objeto de
                quaisquer custos financeiros para a contratante.<br><br>

                <b>Parágrafo Quinto</b> – O <b>CONTRATADO</b> compromete-se a realizar a integralização dos
                títulos pela <b>ATENAS COLLEGE</b>.<br><br>
            </div>
        </div>
        <center>
            <span class="endpage" id=endpage2>ATENAS COLLEGE <br>
                <u class="link">contac@atenascollege.univesity</u> <br>

            WhatsApp (11) 95290-8507 </span>
        </center> 

        <img  id="background3" src="{{ asset('/img/fundo_atenas.jpg') }}">
        <div class="page" id= "page3" style="margin-left: 16%;">

            <div style="width: 700px;text-align: justify; font-size: 14px;position: relative; top:670px; ">
             <b>Parágrafo Sexto</b> – O <b>CONTRATADO</b> obriga-se a manter o sigilo e confidencialidade
             sobre todos os documentos que estiverem sob sua responsabilidade, comprometendo-se
             a não utilizar nenhuma informação ou dados em qualquer que sejam as circunstâncias
             fora do objeto deste instrumento;<br><br>

             <b>Parágrafo Sétimo</b> – O <b>CONTRATADO</b> compromete-se a não utilizar nenhum dado
             pessoal do <b>CONTRATANTE</b> sem autorização prévia por escrito;<br><br>

             <b>Parágrafo Oitavo</b> – O <b>CONTRATADO</b> assume desde já toda a responsabilidade pelo
             título que não for integralizado por falta de comprovação dos créditos ou falta de produção
             acadêmica ou até mesmo por não ser aprovado em banca examinadora, ou seja, pela
             titulação que se comprometer a integralizar e que por qualquer razão não tenha obtido
             sucesso na integralização, assumindo em especial toda e qualquer ação judicial ou
             extrajudicial indenizatória que por ventura a <b>CONTRATANTE</b> venha a sofrer em razão do
             não cumprimento do presente contrato;<br><br><br>


             <b>CLÁUSULA TERCEIRA – DAS OBRIGAÇÕES DO CONTRATANTE</b><br><br>

             <b>Parágrafo Primeiro</b> – O <b>CONTRATANTE</b> será o único e exclusivo responsável pelo curso
             estrangeiro no qual foi certificado, responsabilizando-se pelo conteúdo do mesmo.
             Parágrafo Segundo – Os documentos que o <b>CONTRATANTE</b> deverá entregar ao
             <b>CONTRATADO</b> para que se cumpra com o objeto deste instrumento são:<br><br>

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
                   <i>Curriculum Vitae</i>;
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
               </li>
           </ul><br><br>

           <b>Parágrafo Terceiro</b> – O <b>CONTRATANTE</b> compromete-se a manter as atividades que
           constam no objeto deste instrumento, para que o <b>CONTRATADO</b> cumpra com o processo
           de integralização dos créditos;<br><br><br>

           <b>CLÁUSULA QUARTA – DA FORMA DE PAGAMENTO</b><br><br>

           <b>Parágrafo Primeiro</b> – A <b>CONTRATATANTE</b> pagará ao <b>CONTRATADO</b> o valor de <b>R$</b><br><br>

           <b>Parágrafo Segundo</b> – A<b> CONTRATATANTE</b>, após realizar o pagamento, deverá
           encaminhar o comprovante digitalizado para o seguinte correio eletrônico:
           contact@atenascollege.university, juntamente do formulário devidamente preenchido,
           constante na primeira página deste contrato.<br><br><br>


           <b>CLÁUSULA QUINTA – DA RESCISÃO</b><br><br>

           a. Através do requerimento expresso do <b>CONTRATANTE</b>, assistido ou representado,
           quando for o caso, do pedido de rescisão contratual, sendo em qualquer caso, condição
           obrigatória de sua eficácia a comunicação da desistência à <b>ATENAS COLLEGE</b>, e o
           pagamento dos valores avençados neste instrumento (<b>PAGAMENTO DE MULTA DE 10%
           DO VALOR TOTAL DO CONTRATO</b>) até da efetiva rescisão;<br>
           b. Quando por decisão da <b>CONTRATADA</b> houver a rescisão compulsória deste contrato,
           pela exclusão do <b>CONTRATANTE</b> em decorrência de descumprimento das normas
           internas, devidamente apresentadas com base no próprio contrato fornecido pela
           <b>CONTRATADA</b> no ato da assinatura do mesmo;<br><br>
       </ul>
   </div>
</div>
<center>
   <span class="endpage" id=endpage3>ATENAS COLLEGE <br><br>

   WhatsApp (11) 95290-8507 </span> 
</center> 
<img  id="background4" src="{{ asset('/img/fundo_atenas.jpg') }}">
<div class="page" id= "page4" style="margin-left: 16%;">
    <div style="width: 700px;text-align: justify; font-size: 14px;position: relative; top:1083px; ">
       <b>Parágrafo Primeiro</b> – O pedido de rescisão unilateral do <b>Contrato de Prestação de
       Serviços</b> feito pelo <b>CONTRATANTE</b> deverá ser fundamentado e protocolado na <b>ATENAS
       COLLEGE</b>, não dispensando o <b>CONTRATANTE</b>, da quitação do pagamento referente ao
       serviço de integralização, assim como outras despesas eventualmente ocasionadas pelo
       <b>CONTRATANTE</b>, até a data da solicitação da rescisão do contrato.<br><br>

       <b>Parágrafo Segundo</b> – O compromisso ora assumido pelo <b>CONTRATANTE</b> com a
       <b>CONTRATADA</b> é global e abrange a totalidade das obrigações ora pactuadas, e sua falta
       por impontualidade nos pagamentos não o isentam de responder integralmente por todas
       as obrigações aqui assumidas, e constituem causa de rescisão unilateral pela
       <b>CONTRATADA</b>, da presente contratação.<br><br>

       <b>Parágrafo Terceiro</b> – Ocorrendo a desistência unilateral do contrato de prestação de
       serviço, com comunicação escrita <b>30 dias</b> antes de vencer a parcela seguinte, a
       <b>CONTRATADA</b> fica autorizada a cobrar 10% (dez por cento) do saldo total do plano
       financeiro escolhido.<br><br>

       <b>Parágrafo Quarto</b> – No caso de rescisão do contrato, o <b>CONTRATANTE</b>, deverá estar
       em dia com seus pagamentos e comunicar por escrito a <b>CONTRATADA</b> no prazo máximo
       de 30 dias antes do vencimento da parcela a vencer.<br><br>

       <b>Parágrafo Quinto</b> – Na hipótese de mora no pagamento das mensalidades, o
       <b>CONTRATANTE</b> pagará multa de 2% e juros moratórios de 12% a.a., mais correção
       monetária pelo INPC, pro-rata dies.<br><br>

       <b>Parágrafo Sexto</b> – Caso o pedido de desistência previsto nesta cláusula não seja
       formalizado, este contrato continuará em vigor e o <b>CONTRATANTE</b> deverá pagar todas
       as parcelas previstas no ato da assinatura deste instrumento, podendo a <b>CONTRATADA</b>
       tomar medidas cabíveis de cobrança. Nesta hipótese, além da cláusula penal prevista no
       item “a”, incidirão sobre o saldo devedor atualizado os encargos do parágrafo anterior.<br><br><br>


       <b>CLÁUSULA SEXTA – SOLICITAÇÕES DE DOCUMENTOS</b><br><br>

       O <b>CONTRATANTE</b> que solicitar certidões ou outros documentos à <b>ATENAS COLLEGE</b> deverá pagar
       por cada documento solicitado, tomando como base os valores estipulados em tabela elaborada e
       informada pela <b>CONTRATADA</b>, os quais se destinam a custear as despesas decorrentes da emissão
       e envio dos mesmos.<br><br><br>

       <b>CLÁUSULA SÉTIMA – DA MANUTENÇÃO DO CADASTRO</b><br><br>

       Sempre que o <b>CONTRATANTE</b> mudar de endereço deverá comunicar de imediato por escrito a
       <b>CONTRATADA</b>, sob pena de terem-se como válidas e eficazes todas as correspondências enviadas
       pela <b>CONTRATADA</b> para endereço anterior, constante deste contrato, até a conclusão do processo
       de integralização.<br><br>

       <b>Parágrafo Primeiro</b> – O <b>CONTRATANTE</b> deverá possuir um endereço eletrônico permanente para
       contato com a <b>CONTRATADA</b>. É de total responsabilidade do (a) aluno (a) adquirir e informar um
       endereço eletrônico a <b>CONTRATADA</b> não importando os meios pelos quais irá adquiri-lo e informá-
       lo.<br><br>

       <b>Parágrafo Segundo</b> – O <b>CONTRATANTE</b> deverá responder a todas as mensagens enviadas em
       seu endereço eletrônico, no prazo máximo de 72 horas.<br><br><br>


       <b>CLÁUSULA OITAVA – DOS DOCUMENTOS SOLICITADOS</b><br><br>

       O <b>CONTRATANTE</b> deverá apresentar todos os documentos solicitados pela <b>CONTRATADA</b>, dentro
       do prazo estipulado, a fim de ser admitido no processo de Integralização de Créditos em nível de
       Mestrado.<br><br>

       <b>Parágrafo Único</b> – O <b>CONTRATANTE</b> deverá apresentar os documentos solicitados no checklist da
       <b>CLÁUSULA TERCEIRA</b> deste contrato pela <b>CONTRATADA</b> dentro do prazo de <b>5 (cinco)</b> dias uteis
       a contar da data de assinatura deste.<br><br><br>
   </div>
</div>
<center>
   <span class="endpage" id=endpage4>ATENAS COLLEGE <br><br>

   WhatsApp (11) 95290-8507 </span> 
</center>
<img  id="background5" src="{{ asset('/img/fundo_atenas.jpg') }}">
<div class="page" id= "page5" style="margin-left: 16%;">
    <div style="width: 700px;text-align: justify; font-size: 14px;position: relative; top:1450px; ">

       <b>CLÁUSULA NONA – DA INTEGRALIZAÇÃO DE CRÉDITOS ACADÊMICOS</b><br><br>

       O <b>CONTRATANTE</b> declara ter ciência de que a assessoria visa auxiliá-lo no processo de
       <b>INTEGRALIZAÇÃO DE CRÉDITOS ACADÊMICOS, o qual compreende</b>:<br>

       a. A Convalidação dos Créditos Acadêmicos pela <b>ATENAS COLLEGE</b>, após avaliação e aprovação
       pela Secretaria Pedagógica.<br>
       b. A entrega de todos os documentos do aluno ao final do Programa de Mestrado, devidamente
       apostilado na Flórida.<br><br><br>

       <b>CLÁUSULA DÉCIMA – DA APROVAÇÃO NO PROGRAMA DE MESTRADO</b><br><br>

       O <b>CONTRATANTE</b> deve ter ciência que para receber o diploma deverá ter sua dissertação aprovada
       em banca examinadora pela ATENAS COLLEGE, através da avaliação da dissertação de acordo
       com orientação da <b>CONTRATADA</b>.<br><br>

       <b>Parágrafo Primeiro</b> – O <b>CONTRATANTE</b> deve ter ciência que após concluído o processo de
       INTEGRALIZAÇÃO DE CRÉDITOS ACADÊMICOS, os documentos passarão por legalização junto
       aos órgãos regulamentadores, para somente após o trâmite final receber o Diploma.<br><br>

       <b>Parágrafo segundo</b> – A <b>CONTRATADA</b> reserva-se ao direito de não finalizar o processo, caso o
       <b>CONTRATANTE</b> desatenda às exigências estabelecidas neste contrato.<br><br>

       <b>Parágrafo Terceiro</b> – A <b>CONTRATADA</b> compromete-se a encaminhar os documentos
       imediatamente quando os mesmos estiverem disponíveis.<br><br><br>


       <b>CLÁUSULA DÉCIMA PRIMEIRA – DO FORO</b><br><br>

       Fica eleito o foro da Cidade de Delaware, Estados Unidos da América, para dirimir todas as
       questões referentes à execução do presente instrumento, após esgotadas todas as instâncias
       administrativas.<br><br>

       E, por estarem de pleno acordo, os contratantes assinam o presente convênio, em 02 (duas)
       vias de igual teor e forma, na presença das testemunhas abaixo, para todos os seus jurídicos
       e legais efeitos. <br><br>

       <center><pre>DELAWARE (USA),  {{ strftime('%d de %B de %Y', strtotime('today')) }}</pre></center>
       <center>
           <b> <br><br><br>_____________________________________<br>
               CONTRATADO<br>
               Marcelo Barbosa Santos<br>
               ATENAS COLLEGE<br><br><br></b>
           </center>
           <center>
            <b>_____________________________________<br>
                CONTRATANTE<br><br></b>
            </center>
            <div style="float: left;">
                <b>TESTEMUNHAS:<br><br>
                    1._____________________________________<br>
                    Nome:<br>
                    _____________________________________<br>
                CPF Nº:</b>
            </div>
            <div style="float: right;">
                <br><br>
                <b>2._____________________________________<br>
                    Nome:<br>
                    _____________________________________<br>
                CPF Nº:</b>
            </div>

        </div>
    </div>
    <center>
       <span class="endpage" id=endpage5>ATENAS COLLEGE <br><br>

       WhatsApp (11) 95290-8507 </span>
   </center>

</body>
</html>