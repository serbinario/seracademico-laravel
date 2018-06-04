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
        padding-top: 45px;
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
            border: 0.5px solid;

        }
        .table td {
            padding: 1px;

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
        #endpage1{
            margin-top:280px; 
            width: 900px;
        }
        #endpage2{
            margin-top:340px; 
            width: 900px;
        }
        #endpage3{
            margin-top:390px; 
            width: 900px;
        }
        #endpage4{
            margin-top:405px; 
            width: 900px;
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
        }
    </style>
</head>

<body> 
    <img  id="background" src="{{ asset('/img/fundo_atenas.jpg') }}">
    <div id="body">
        <div class="page" id="page1">
            <div id="header"> 
                <h1>CONTRATO DE PRESTAÇÃO DE SERVIÇOS EDUCACIONAIS DE MESTRADO</h1>
                <hr>
                <h1>QUADRO DE CONTRATAÇÃO - DADOS DOS CONTRATANTES</h1>     
            </div>
            <div class="informacoes_pessoas">
                <?php $sexo = $aluno['pessoa']['sexo']['nome']?>
                <table class="table">
                    <th colspan="6">CONTRATANTE</th>
                    <tr>
                        <td colspan="6">Nome Completo: {{$aluno['pessoa']['nome']}}</td>
                    </tr>
                    <tr>
                        <td colspan="6">E-mail: {{ isset($aluno['pessoa']['email']) ? $aluno['pessoa']['email'] : "" }}</td>
                    </tr>
                    <tr>
                        <td colspan="3">Estado Civil: {{ isset($aluno['pessoa']['estadoCivil']) ? $aluno['pessoa']['estadoCivil']['nome'] : "" }}</td>
                        <td colspan="3">Nascionalidade: {{ isset($aluno['pessoa']['naturalidade']) ? $aluno['pessoa']['naturalidade'] : "" }}</td>

                    </tr>
                    <tr>
                     <td colspan="3">Sexo:    Masculino ( {{ $sexo == 'Masculino' ? 'X' : ' ' }}  )           Feminino (  {{ $sexo == 'Feminino' ? 'X' : ' '  }}  )</td>
                     <td colspan="3">CPF: {{ isset($aluno['pessoa']['cpf']) ? $aluno['pessoa']['cpf'] : "" }} </td>
                 </tr>
                 <tr>
                    <td colspan="2" width="33%">RGº: {{ isset($aluno['pessoa']['identidade']) ? $aluno['pessoa']['identidade'] : "" }}</td>
                    <td colspan="2"> Orgão Expedidor:{{ isset($aluno['pessoa']['orgao_rg']) ? $aluno['pessoa']['orgao_rg'] : "" }}</td>
                    <td colspan="2" width="33%">Data Expedição: {{ isset($aluno['pessoa']['data_expediao']) ? $aluno['pessoa']['orgao_rg'] : "" }}</td>
                </tr>
                <tr>
                    <td colspan="2">Titulo de Eleitor:</td>
                    <td colspan="2">Zona:</td>
                    <td colspan="2">Sessão:</td>
                </tr>
                <tr>
                    <td colspan="6">Reservista:</td>
                </tr>
                <tr>
                    <td colspan="3" width="50%">Endereço: {{ isset($aluno['pessoa']['endereco']) ? $aluno['pessoa']['endereco']['logradouro'] : "" }}</td>
                    <td colspan="3" width="50%">Bairro: {{ isset($aluno['pessoa']['endereco']['bairro']) ? $aluno['pessoa']['endereco']['bairro']['nome'] : "" }}</td>
                </tr>
                <tr>
                    <td colspan="3">CIDADE: {{ isset($aluno['pessoa']['endereco']['bairro']['cidade']) ? $aluno['pessoa']['endereco']['bairro']['cidade']['nome'] : "" }}</td>
                    <td>UF: {{ isset($aluno['pessoa']['endereco']['bairro']['cidade']['estado']) ? $aluno['pessoa']['endereco']['bairro']['cidade']['estado']['nome'] : "" }}</td>
                    <td>CEP: {{ isset($aluno['pessoa']['endereco']['cep']) ? $aluno['pessoa']['endereco']['cep'] : "" }}</td>
                </tr>
                <tr>
                    <td colspan="3" width="50%">Profissão:</td>
                    <td colspan="3" width="50%">E-mail:</td>
                </tr>
                <tr>
                    <td colspan="3">Telefones: {{ isset($aluno['pessoa']['celular']) ? $aluno['pessoa']['celular'] : "" }}</td>
                    <td colspan="3">{{ isset($aluno['pessoa']['celular2']) ? $aluno['pessoa']['celular2'] : "" }}</td>
                </tr>
                <tr>
                    <td colspan="6">Curso:</td>
                </tr>
                <tr>
                    <td colspan="6"><pre>Duração estimada: {{isset($turma->duracao_meses)? $turma->duracao_meses : ""}} Meses</pre></td>
                </tr>
                <tr>
                    <td colspan="6"><pre>Valor Total do curso: Matrícula R$ {{isset($turma->valor_matricula)? $turma->valor_matricula : ""}} + 30 mensalidades de R$ {{isset($turma->valor_turma) ? $turma->valor_turma : ""}} = R$ {{isset($turma->valor_turma,$turma->valor_matricula,$turma->duracao_meses) ? ($turma->valor_turma*$turma->duracao_meses)+$turma->valor_matricula : ""}}</pre></td>
                </tr>
                <tr>
                    <td colspan="6"><pre>Forma de Pagamento:  (   ) À vista                (   ) Boleto</pre></td>
                </tr>
                <tr>
                    <td colspan="6">Taxa de Defesa da Dissertação, Diplomação e apostilamento do país de origem da Universidade US$ 700,00.</td>
                </tr>
            </table>

            <table class="table">
                <th colspan="4">CONTRATADA</th>
                <tr>
                    <td colspan="4">Nome: Atenas College</td>
                </tr>
                <tr>
                    <td colspan="4">Endereço Completo: 200 Continental Drive, Suite 401, Newark, Delaware, 19713</td>
                </tr>
                <tr>
                    <td colspan="2">Registro Federal: PI 5000094168</td>
                    <td colspan="2">Registro Estadual: EIN 37-1838647</td>
                </tr>
                <tr>
                    <td colspan="4">Home Page: www.atenascollege.university</td>
                </tr>
            </table>


            <center><h1 style="margin-top: 50px;margin-bottom:50px; ">CONDIÇÕES GERAIS DA PRESTAÇÃO DOS SERVIÇOS</h1></center>
            <div style="width: 700px;text-align: justify; font-size: 14px; ">
            1. Definições Conceituais. Este Contrato estabelece as seguintes disposições ou “glossário” dos termos nele adotados:<br>
            a) Contratante: é o subscrevente do contrato. Suportam-no os custos do curso no qual se matricula, custos estes destinados a manter proporcionalmente a administração e a organização da Contratada, a remunerar os professores, bem como para as mobilizações de locais, materiais e equipamentos para as atividades docentes.<br>
            b) Desistência: é a demissão do aluno. Considera-se consumada quando este comunica à Contratada por escrito que deixa injustificadamente de participar das atividades acadêmicas. Acarreta para o desistente os deveres de pagar os montantes das prestações e dos preços vencidos e os deveres de reparar os prejuízos que causar à Contratada ou aos demais alunos da sua turma pela queda da sustentabilidade econômica do Curso.<br>
            c) Turma: é o grupamento formado pelo conjunto dos alunos devidamente matriculados para o Curso e que tem características assemelhadas a um “Condomínio de Compras” dos serviços da Contratada, com responsabilidades mútuas segundo este.<br><br>

            2. O CONTRATANTE e a CONTRATADA resolvem celebrar o presente Contrato de Prestação de Serviços Educacionais (o “CONTRATO”), no qual estão expressas as condições segundo as quais a CONTRATADA ministrará o curso escolhido pelo CONTRATANTE no QUADRO DE CONTRATAÇÃO, mediante o pagamento, pelo ALUNO, dos valores constantes do referido QUADRO.<br><br>

            3. Aplicam-se também ao presente CONTRATO, como parte integrante e indissociável do mesmo, o Regimento Interno da CONTRATADA, documento este que o CONTRATANTE declara ter lido previamente à assinatura deste CONTRATO, obrigando-se, ainda, a cumprir com o quanto ali está disposto. As Partes comprometem-se, ainda, a cumprir com a legislação educacional e a pautar suas ações com base na boa-fé e equilíbrio contratual.
            </div>
        </div>    
    </div>
</div>  
<center>
    <hr id= "endpage1">
    <b>Página 1 de 4 </b> 
</center> 
<img  id="background2" src="{{ asset('/img/fundo_atenas.jpg') }}">
<div class="page" id= "page2" style="margin-left: 16%;">

    <div style="width: 700px;text-align: justify; font-size: 14px;position: relative; top:55px; ">
4. A formulação e divulgação das diretrizes e orientações técnicas relativas à prestação dos serviços de ensino são de inteira responsabilidade da CONTRATADA, especialmente no que tange à avaliação do rendimento escolar do CONTRATANTE, à fixação de carga horária e grade curricular, à indicação de atividades curriculares, razão pela qual, a CONTRATADA poderá, a qualquer tempo, realizar alterações nas atividades aqui mencionadas, alterações estas que serão previamente informados ao CONTRATANTE pelos canais de comunicação disponíveis para tanto.<br>
5. São obrigações do CONTRATANTE:<br>
a) Pagar a taxa de inscrição e apresentar todos os documentos pessoais para efetivação da matrícula (carteira de identidade, CPF, 2 (duas) fotos 3x4, e diploma certificado pelo MEC do curso de graduação realizado pelo CONTRATANTE), bem como demais documentos que venham a ser solicitados a qualquer tempo pela CONTRATADA. Na hipótese de não apresentação dos documentos solicitados, a CONTRATADA poderá impedir o CONTRATANTE de cursar as matérias em andamento até que seja realizada a regularização de seus documentos pessoais ou não iniciar o processo de certificação do curso do CONTRATANTE. A não entrega de documentos, até o final do curso de mestrado escolhido pelo contratante, converte, automaticamente, a matrícula para curso de aperfeiçoamento e/ou de atualização, ficando a participação do contratante como aluno ouvinte, sem direito a certificação, sendo as notas apenas um índice de qualidade do aproveitamento.<br>
b) Pagar pontualmente as mensalidades devidas à CONTRATADA, no valor e na data de vencimento indicados no QUADRO DE CONTRATAÇÃO deste CONTRATO. O contratante deverá manter sob sua guarda todos os respectivos comprovantes de pagamentos, para apresentá-los sempre e quando for solicitado pela CONTRATADA, até 6 (seis) meses o termo final do prazo estabelecido no item 9 (nove) do presente contrato, a fim de dirimir quaisquer dúvidas. <br>
c) Cursar disciplinas e/ou atividades do curso escolhido no cronograma, de acordo com o projeto pedagógico e matriz curricular estabelecidos, ficando a CONTRATADA desobrigada de reabrir disciplinas e/ou atividades quando o curso não estiver sendo oferecido ou quando a turma não estiver tendo aulas.<br>
d) Atualizar seu endereço, e-mail e telefone junto à secretaria do curso, pois a CONTRATADA não se responsabilizará por extravio de correspondências ou falta de comunicação sobre possíveis alterações no decorrer do curso, nem por boletos que sejam enviados para endereços errados ou insuficientes.<br> 

6. O CONTRATANTE declara-se ciente de que:<br>
a) As parcelas mensais mencionadas no QUADRO DE CONTRATAÇÃO não têm nenhuma vinculação com o número de meses letivos em que perdurará o curso escolhido pelo CONTRATANTE, motivo pela qual o CONTRATANTE reconhece que as parcelas são devidas inclusive nos meses de férias ou recesso.<br>
b) O não comparecimento do CONTRATANTE às salas de aula online ou demais atos acadêmicos ora contratados não o exime ou eximirá do pagamento das parcelas relativas às referidas aulas ou atos acadêmicos realizados sem a sua presença, tendo em vista que o serviço de ensino terá sido efetivamente prestado e colocado à disposição do CONTRATANTE.
c) O CONTRATADO não se responsabilizará pela baixa de pagamentos efetuados por meio de depósitos em sua conta corrente, transferências bancárias ou operações semelhantes, por não serem, essas, as formas previstas neste contrato, para o recebimento das parcelas mensais. Excepcionalmente, na hipótese de ocorrência de tal fato, o CONTRATANTE deverá procurar o departamento financeiro do CONTRATADO, com os devidos comprovantes, para apuração, identificação e regularização do pagamento, sob a pena de não ser reconhecida a quitação da parcela.<br>
d) Não existe possibilidade de trancamento ou suspensão dos serviços educacionais. Caso o CONTRATANTE desista, por qualquer motivo, de continuar frequentando o curso contratado, perderá o direito ao investimento dos pagamentos realizados.<br> 
e) Em caso de atraso de pagamento de uma ou mais parcelas mensais, a CONTRATADA cobrará do CONTRATANTE multa de 2% sobre a parcela devida, juros de mora de 1% ao mês ou fração de mês, e atualização monetária, bem como poderá, independentemente de prévia notificação, adotar todas as providências de cobrança cabíveis (inclusive inscrever o nome do CONTRATANTE em cadastros ou serviços legalmente constituídos e destinados à proteção do crédito e cessar a prestação de serviços educacionais imediatamente), emitir duplicata de serviços, dispensado o aceite, desde já autorizada, pelo valor da(s) parcela(s) vencida(s) e não paga(s), acrescida(s) da multa moratória, dos juros e da correção monetária mencionadas acima, além das custas judiciais e/ou extrajudiciais e dos honorários advocatícios, podendo tais providências serem tomadas isolada, gradativa ou cumulativamente.<br> 
f) O presente CONTRATO vale como título executivo extrajudicial, nos termos do art. 585, II, do CPC, e o CONTRATANTE reconhece e aceita que este CONTRATO é título executivo líquido, certo e exigível. Em caso de cobrança judicial do CONTRATANTE, os honorários advocatícios corresponderão a 20% (vinte por cento) sobre os valores cobrados.
g) O atraso no pagamento de qualquer parcela, por mais de 30 (trinta) dias, torna vencido integralmente o contrato, podendo o contratado, se quiser, rescindi-lo de pleno direito (com fundamento no art. 5º da Lei 9.870, de 23 de novembro de 1999), extingue para o contratante o direito de frequências às aulas, a liberação dos materiais didáticos para download, o trancamento de matrícula, a transferência entre cursos, entre outros. O atraso no pagamento de 3 (três) parcelas consecutivas, ou não, acarretará no vencimento das demais parcelas contratadas.<br>
    </div>
</div>
<center>
    <hr id= "endpage2">
    <b>Página 2 de 4 </b> 
</center> 

<img  id="background3" src="{{ asset('/img/fundo_atenas.jpg') }}">
<div class="page" id= "page3" style="margin-left: 16%;">

    <div style="width: 700px;text-align: justify; font-size: 14px;position: relative; top:100px; ">
h) Não estão incluídos no valor deste CONTRATO: o fornecimento de materiais acadêmicos indicados e/ou solicitados pelos docentes para estudos curriculares; material didático, apostilas, cópias reprográficas e demais materiais utilizados em clínicas, laboratórios ou aulas práticas; serviços especiais de reforço de matérias, seminários, monografias; taxas e emolumentos; transporte escolar bem como fornecimento de material pessoal e didático de uso individual do CONTRATANTE.<br> 
i) Que no caso de perda ou o não recebimento do carnê ou dos boletos bancários em tempo hábil, o CONTRATANTE deverá solicitar ao setor financeiro do CONTRATADO e não poderá alegar o não recebimento dos boletos como escusa para o não pagamento pontual, uma vez que a data mensal de vencimento das parcelas é de conhecimento do próprio CONTRATANTE.<br> 
j) Caso o contratante tenha optado por pagamento por meio de cheques, no caso de não entrega de todos os cheques por ocasião da matrícula, a não entrega dos cheques relativos às parcelas restantes do contrato, no momento da parcela devida sem cheques correspondentes entregues, modifica o modo de pagamento do contrato, automaticamente, para boletos bancários, que poderão ser enviados ao contratante via e-mail, alterando concomitantemente o bônus ou os descontos, caso haja.<br> Embora o contratado seja responsável pela guarda dos cheques, o contratante concorda em apresentar imediata contraordem ao pagamento dos cheques, no caso de extravio, furto ou roubo, junto aos respectivos bancos ou instituições financeiras que lhes sejam equiparadas, desde que devidamente comunicado em tempo hábil. Neste caso, será de total responsabilidade do contratado todas as despesas bancárias e outras decorrentes que se fizerem necessárias ao cumprimento da contraordem, desde que devidamente comprovadas pelo contratante. Caso não tenha havido o desconto dos cheques extraviados, furtados ou roubados, até o ato da respectiva contraordem, o contratante se obriga a substituí-los, imediatamente, por outros de idênticos valores e vencimentos.<br>
k) No caso de devolução de cheque da parcela mensal, independentemente do motivo, poderá o contratado atualizar os valores devidos, inclusive da diferença da perda de descontos especiais, se for o caso e, cobrá-los do contratante, por meio de duplicatas, via cobrança bancária, com protesto previsto e com dispensa de aceite, corrigidos da forma estabelecida no caput da cláusula décima primeira do presente contrato.
l) O contratante contemplado com financiamento ou bolsa de estudo parcial, concedidas por entidades públicas, privadas ou por terceiros, responde pelo total dos valores contratados, caso ocorra inadimplência das entidades concedentes ou dos terceiros.<br>
m) Nos termos da legislação vigente, a CONTRATADA não permitirá a rematrícula, nas disciplinas do curso, do CONTRATANTE que (i) estiver inadimplente em relação ao pagamento de qualquer uma das parcelas previstas no QUADRO DE CONTRATAÇÃO, especialmente a inexistência de débito referente às mensalidades dos períodos anteriores; (ii) não tiver enviado todos os documentos pessoais que lhe tenham sido requeridos pela CONTRATADA, a exemplo dos comprobatórios da sua graduação e colação de grau em instituição de ensino superior reconhecida pelo Ministério da Educação; (iii) não tiver desempenho acadêmico compatível com a continuidade do curso; (iv) não cumprir com o Regimento Interno da CONTRATADA.<br> 
n) Em caso de desistência por parte do CONTRATANTE, o mesmo terá o prazo improrrogável de até 5 (cinco) dias corridos, após a efetivação da matrícula, para requerer o cancelamento da mesma com direito à restituição de 50% (cinquenta por cento) do valor pago, ficando 50% (cinquenta por cento) do valor para cobrir custo operacional da instituição.<br> 
o) Depois de decorrido o prazo constante no item acima, para a desistência contratual, o CONTRATANTE deverá pagar os valores vencidos e não quitados, além do valor correspondente a 30% (trinta por cento) sobre o saldo remanescente dos valores dos créditos acadêmicos e/ou das horas–aulas a cursar (valores vincendos), devidamente corrigidos, da forma estabelecida no presente contrato, a título de cláusula penal (art. 408 até art. 416 do Código Civil). A CONTRATADA não receberá o pedido de rescisão/cancelamento de matrícula de CONTRATANTE inadimplente até que seja realizado o acerto da referida pendência financeira.<br>   
p) A emissão do Diploma do curso somente ocorrerá mediante solicitação efetuada pelo próprio responsável através de requerimento, com o prazo máximo de até 120 (cento e vinte) dias úteis, tendo o CONTRATANTE que estar adimplente com todas as parcelas vencidas até a data de solicitação.<br>
q) O contratante declara-se ciente que pode optar pela defesa de dissertação ser realizada no país de origem da instituição, desde que o mesmo se responsabilize por todas as despesas de viagem.<br><br>


7. O presente CONTRATO tem início na data da sua assinatura, subsistindo até o término do curso escolhido pelo CONTRATANTE no QUADRO DE CONTRATAÇÃO.<br>
8. Fica reservado à CONTRATADA o direito de não oferecer o curso escolhido pelo CONTRATANTE no QUADRO DE CONTRATAÇÃO caso não se atinja um número mínimo de alunos efetivamente matriculados acadêmica e financeiramente. Nesta hipótese, o CONTRATANTE deverá optar por aguardar o início de uma nova turma ou resilir o CONTRATO, hipótese em que deverá apresentar formalmente o pedido de devolução da taxa de inscrição já paga, devolução esta que se efetivará no prazo de até 30 dias úteis após a data da apresentação do pedido de devolução à CONTRATADA.<br><br>

9. Será facultado à CONTRATADA rescindir o presente CONTRATO pela prática comprovada de atos de indisciplina por parte do CONTRATANTE, ou de atos previstos do Regimento Interno da CONTRATADA, sendo devidas as mensalidades até a data da efetiva expulsão do CONTRATANTE.
    </div>
</div>
<center>
    <hr id= "endpage3">
    <b>Página 3 de 4 </b> 
</center> 
<img  id="background4" src="{{ asset('/img/fundo_atenas.jpg') }}">
<div class="page" id= "page4" style="margin-left: 16%;">
    <div style="width: 700px;text-align: justify; font-size: 14px;position: relative; top:100px; ">
10. O CONTRATANTE que for comprovadamente dispensado pela CONTRATADA de cursar determinadas disciplinas que compõe o curso por ele escolhido no QUADRO DE CONTRATAÇÃO não será dispensado de pagar pelas referidas disciplinas, descabendo-lhe o direito de pleitear da CONTRATADA qualquer reembolso, desconto ou indenização em decorrência de tal fato.<br><br>    

11. O Curso foi concebido segundo os estudos de mercado e as experiências da Contratada. Para a sua manutenção depende das suas expectativas de sustentação do rateio dos seus custos e das naturais e previsíveis remunerações da Contratada. A perda de rendas poderá determinar a falta de condições para a sua manutenção. Por tais razões, fica o Contratante ciente de que iniciado o curso, caso no seu decorrer não haja número de alunos para assegurar a sua continuidade, será facultado ao Contratante, à sua livre escolha:<br>
a) Com as adequadas compensações econômicas dos respectivos custos, transferir-se para outro curso presentemente mantido em iguais condições pela Contratada;<br>
b) Com as necessárias adaptações aos custos então vigentes, ter sua vaga assegurada em outro curso idêntico a ser mantido pela Contratada;<br>
c) Aproveitar os seus créditos curriculares em quaisquer outros cursos mantidos pela Contratada, respeitadas as similitudes e equivalências de matérias;<br>
d) Ocorrendo a hipótese da letra c) acima, só lhe serão cobrados os valores correspondentes às contraprestações às quais se obrigou pelos serviços até então prestados, seguindo-se sempre os critérios das proporcionalidades quando da interrupção do fornecimento serviços.<br><br>

12. Fica eleito o foro da comarca de Brasília, Distrito Federal, para dirimir qualquer ação fundada no presente Contrato, renunciando as partes qualquer outro foro, por mais privilegiado que venha a ser.<br> 

13. O presente CONTRATO é firmado em duas vias, de igual teor e forma, assinado, neste ato, pelo CONTRATANTE e/ou RESPONSÁVEL FINANCEIRO e pela CONTRATADA.8. Fica reservado à CONTRATADA o direito de não oferecer o curso escolhido pelo CONTRATANTE no QUADRO DE CONTRATAÇÃO caso não se atinja um número mínimo de alunos efetivamente matriculados acadêmica e financeiramente. Nesta hipótese, o CONTRATANTE deverá optar por aguardar o início de uma nova turma ou resilir o CONTRATO, hipótese em que deverá apresentar formalmente o pedido de devolução da taxa de inscrição já paga, devolução esta que se efetivará no prazo de até 30 dias úteis após a data da apresentação do pedido de devolução à CONTRATADA.<br><br> 

        <center><pre>Delaware,  {{ strftime('%d de %B de %Y', strtotime('today')) }}</pre></center>
        <center>
         <br> _____________________________________<br>
         ASSINATURA DO CONTRATANTE<br><br>
     </center>
     <center>
        _____________________________________<br>
        ASSINATURA DA CONTRATADA<br>
    </center>
    <div style="float: left;">
        TESTEMUNHAS:<br><br>
        _____________________________________<br>
        Nome:
    </div>
    <div style="float: right;">
        <br><br>
        _____________________________________<br>
        Nome:
    </div>

</div>
</div>
<center>
    <hr id= "endpage4">
    <b>Página 4 de 4 </b> 
</center> 

</body>
</html>