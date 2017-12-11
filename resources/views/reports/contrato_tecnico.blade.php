<html>
<head>
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
        table { page-break-inside:auto }
        tr    { page-break-inside:avoid; page-break-after:auto }
        thead { display:table-header-group }
        tfoot { display:table-footer-group }
    </style>
</head>
<body>

<div class="cabecalho" style="font-size: 15px;">
    <table width="100%">
        <tr>
            <td width="20%">
                <img alt="image" width="100%" src="{{ asset('/img/logo_alpha_tec.jpg')}}"/>
            </td>
            <td width="55%"><br>
                <h3 style="text-align: center; ">CONTRATO DE PRESTAÇÃO DE SERVIÇOS </h3>
            </td>
        </tr>
    </table>
</div>

<div class="conteudo">

    <div class="informacoes_pessoas">
        <table class="table" style="font-size: 14px;">
            <tr>
                <td colspan="4">Nome: {{$aluno['pessoa']['nome']}}</td>
            </tr>
            <tr>
                <td colspan="2">CPF: {{ isset($aluno['pessoa']['cpf']) ? $aluno['pessoa']['cpf'] : "" }} </td>
                <td>RGº: {{ isset($aluno['pessoa']['identidade']) ? $aluno['pessoa']['identidade'] : "" }}</td>
                <td>Data de Nasc: {{ isset($aluno['pessoa']['data_nasciemento']) ? $aluno['pessoa']['data_nasciemento'] : "" }}</td>
            </tr>

            <tr>
                <td colspan="3">Endereço: {{ isset($aluno['pessoa']['endereco']) ? $aluno['pessoa']['endereco']['logradouro'] : "" }}</td>
                <td>Nº {{ isset($aluno['pessoa']['endereco']) ? $aluno['pessoa']['endereco']['numero'] : "" }}</td>
            </tr>
            <tr>
                <td>BAIRRO: {{ isset($aluno['pessoa']['endereco']['bairro']) ? $aluno['pessoa']['endereco']['bairro']['nome'] : "" }}</td>
                <td>CIDADE: {{ isset($aluno['pessoa']['endereco']['bairro']['cidade']) ? $aluno['pessoa']['endereco']['bairro']['cidade']['nome'] : "" }}</td>
                <td>UF: {{ isset($aluno['pessoa']['endereco']['bairro']['cidade']['estado']) ? $aluno['pessoa']['endereco']['bairro']['cidade']['estado']['nome'] : "" }}</td>
                <td>CEP: {{ isset($aluno['pessoa']['endereco']['cep']) ? $aluno['pessoa']['endereco']['cep'] : "" }}</td>
            </tr>
            <tr>
                <td>TEL. RES: {{ isset($aluno['pessoa']['telefone_fixo']) ? $aluno['pessoa']['telefone_fixo'] : "" }}</td>
                <td>TEL. COM: {{ isset($aluno['pessoa']['celular']) ? $aluno['pessoa']['celular'] : "" }}</td>
                <td colspan="2">TEL. CEL: {{ isset($aluno['pessoa']['celular2']) ? $aluno['pessoa']['celular2'] : "" }}</td>
            </tr>
            <tr>
                <td colspan="4">
                    <p style="text-align: justify">
                    Doravante: Denominado CONTRATENTE E, DO OUTRO LADO, ALPHA SERVIÇOS ALPHA SISTEMASEDUCACIONAL E
                    TREINAMENTOS LTDA. ME , inscrita  no CNPJ: 15.708.483/000150, Situado na rua Gervásio Pires 826, bairro Boa vista, Recife-
                    PE, Neste ato, Por seu representante legal, doravante designada CONTRATADA, tendo ainda como responsável financeiro solidário.
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="4">Nome do Pai: {{ isset($aluno['pessoa']['nome_pai']) ? $aluno['pessoa']['nome_pai'] : "" }}</td>
            </tr>
            <tr>
                <td colspan="4">Nome da Mãe: {{ isset($aluno['pessoa']['nome_mae']) ? $aluno['pessoa']['nome_mae'] : "" }}</td>
            </tr>
            <tr>
                <td colspan="2">CPF do responsável: {{ isset($aluno['cpf_responsavel']) ? $aluno['cpf_responsavel'] : "" }} </td>
                <td colspan="2">RGº do responsável: {{ isset($aluno['rg_responsavel']) ? $aluno['rg_responsavel'] : "" }}</td>
            </tr>
            <tr>
                <td colspan="4">
                    <p style="text-align: justify">
                        Estando ciente do projeto pedagógico, plano de curso e do regimento Escolar , firmam o presente CONTRATO DE SERVIÇOS EDUCACIONAIS .
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="2">CURSO: {{ isset($curso->nome) ? $curso->nome : "" }} </td>
                <td colspan="2">TURMA: {{ isset($turma->codigo) ? $turma->codigo : "" }}</td>
            </tr>
            <tr>
                <td colspan="4">INICIO DAS AULAS (PREVISÃO): {{ isset($turma->aula_inicio) ? $turma->aula_inicio : "" }} </td>
            </tr>
            <tr>
                <td colspan="4">
                    <p style="text-align: justify">
                        Ficando estabelecido, como  CONDIÇÃO  DE PAGAMENTO :
                    </p>
                </td>
            </tr>
            <tr>
                <td>MATRICULA: {{ isset($aluno['matricula']) ? $aluno['matricula'] : "" }}</td>
                <td>VALOR DO CURSO: {{ isset($curso->valor) ? $curso->valor : "" }}</td>
                <td>VALOR DAS PARCELAS:
                    @if(isset($curso->valor) && $curso->valor != null)
                        @if($turma->turno_id == '1' || $turma->turno_id == '2')
                            {{ $curso->valor * 14 }}
                        @else
                            {{ $curso->valor * 17 }}
                        @endif
                    @endif
                </td>
                <td>N. PARCELAS: {{ isset($turma->qtd_parcelas) ? $turma->qtd_parcelas : "" }}</td>
            </tr>
            <tr>
                <td colspan="2">DIA DE VENCIMENTO DAS PARCELAS: : {{ isset($turma->vencimento_inicial) ? $turma->vencimento_inicial : "" }} </td>
                <td colspan="2">DESC DE PONTUALIDADE: </td>
            </tr>
        </table>
    </div>

    <p>
        <b>Em observâncias as normas a seguir enunciadas</b>
    </p>

    <p class="paragrafo">
        <b>CLAUSULA PRIMEIRA:</b> O presente contrato tem como objeto a prestação de serviços de capacitação por meio de
        realização de cursos Técnicos profissionalizante, com aula presencial, em conformidade com o previsto em regimento
        interno e o planejamento pedagógico, observando-se ainda a legislação em vigor.
    </p>

    <p class="paragrafo">
        <b>Parágrafo Primeiro:</b> As aulas e demais atividades serão ministradas ordinariamente nas sala de aula,
        e laboratórios localizados no estabelecimento da contratada, sendo admitidas troca de salas, aulas externas e visitações técnicas,
        cujas as despesas inclusive  com o deslocamento, serão de responsabilidade do contratante, caso necessário.
    </p>

    <p class="paragrafo">
        <b>Parágrafo Segundo:</b> As aulas e demais atividades serão ministradas ordinariamente nas sala de aula,
        e laboratórios localizados no estabelecimento da contratada, sendo admitidas troca de salas, aulas externas e visitações técnicas,
        cujas as despesas inclusive  com o deslocamento, serão de responsabilidade do contratante, caso necessário.
    </p>

    <p class="paragrafo">
        <b>Parágrafo Terceiro:</b> Para efeito do presente contrato fica desde logo estipulado que será cobrada uma taxa para a realização de
        cada aula de reposição e uma taxa para cada prova de segunda chamada solicitada pelo contratante, valores especificados na secretaria.
    </p>

    <p class="paragrafo">
        <b>Parágrafo Quarto:</b> O contratante autoriza o uso de sua imagem e som para fins de exibição nos murais da escola e
        meios de comunicação existentes, por tempo indeterminado.
    </p>

    <p class="paragrafo">
        <b>CLAUSULA SEGUNDA:</b> Todo material didático será acessados pelos alunos via on-line gratuitamente.
        Os demais materiais didáticos, tais como artigos, anotações das aulas realizadas pelos docentes (professores),
        textos digitados e materiais de uso pessoal, entre outros, seus respectivos custos são de responsabilidade do contratante.
    </p>

    <p>
        <b>Contrato de prestação de Serviços</b>
    </p>

    <p class="paragrafo">
        <b>Parágrafo Único:</b> O contratante também deverá pagar pelos serviços especiais de : recuperação, reforço,
        segunda chamada, exames especiais ou substitutivos, reciclagem, contratação isolada de disciplina,
        aula de reposição e todo e qualquer outro serviço não discriminado na Clausula Primeira.
    </p>

    <p class="paragrafo">
        <b>CLAUSULA TERCEIRA:</b> O contratante está ciente de que a contratada poderá adiar o inicio do curso por 60 dias( sessenta) da data prevista,
        sem que isto lhe assegure o direito de cancelar este contrato ou lhe
        permita obter o reembolso da quantia paga, mesmo que parcial, ou ainda reparação de qualquer espécie.
    </p>

    <p class="paragrafo">
        <b>Parágrafo Primeiro:</b> O contratante terá o direito de cancelar(rescindir) o contrato, sem quaisquer ônus,
        com a restituição de todos valores pagos, caso as aulas não sejam iniciadas após o período de prorrogação ou se
        for remanejado para outra turma, cujos dias e horários não sejam convenientes.
    </p>

    <p class="paragrafo">
        <b>Parágrafo Segundo:</b> Mediante requerimento escrito e, após o pagamento de encargo correspondente a R$ 30,00(trinta reais),
        o contratante poderá solicitar a transferência de turma, ficando o deferimento de tal pedido condicionada a disponibilidade de vagas.
    </p>

    <p class="paragrafo">
        <b>Parágrafo Terceiro:</b> O estudante que estiver cursando não poderá transferir para uma turma que não tenha iniciado.
    </p>

    <p class="paragrafo">
        <b>Parágrafo Quarto:</b> Havendo necessidade, seja por força maior ou mesmo por situação fortuita,
        a contratada promoverá a substituição de professor, não podendo tal feito ser apontado como motivo para
        cancelamento do contrato, uma vez que não ocorrerá qualquer prejuízo  para o contratante.
    </p>

    <p class="paragrafo">
        <b>CLAUSULA QUARTA:</b> Em caso de reprovação em alguma disciplina em um dos módulos ou em qualquer outra hipótese em que o
        contratante pretenda cursá-la novamente, será admitida a sua contratação isolada, por meio de requerimento expresso e
        pagamento da importância correspondente ao modulo sem desconto.
    </p>

    <p class="paragrafo">
        <b>Parágrafo Único:</b> O CONTRATANTE ESTÁ CIENTE DE QUE OS SERVIÇOS E DEMAIS ATIVIDADES PRESTADAS
        NO TURNO DA NOITE SERÃO MAIS ONEROSOS DO QUE AQUELES REALIZADOS EM PERIODO DIURNO, INCLUINDO MATRICULAS,
        MENSALIDADES E DEMAIS DOCUMENTOS E DECLARAÇÕES SOLICITADO COMO  SEGUNDA VIA.
    </p>

    <p class="paragrafo">
        <b>CLAUSULA QUINTA:</b> O pagamento de totós dos os serviços ora descritos deverá ser realizados, em conformidade com o PROGRAMA DE PAGAMENTO,
        sendo admitidas as seguintes formas de pagamento: a) Cartão de Credito; b) Boleto bancário, cujo pagamento poderá excepcionalmente ser realizado
        no próprio estabelecimento da contratada, em dinheiro, cartão de credito/debito ou em cheque, desde que emitido pelo próprio contratante ou de seu
        representante, ficando sua quitação vinculada a efetiva compensação bancaria.
    </p>

    <p class="paragrafo">
        <b>Parágrafo Primeiro:</b> A contratada poderá conceder descontos nas parcelas , mas tal beneficio apenas será valido para pagamentos
        realizados até a data do seu vencimento, o atraso no pagamento da prestação implicara na perda automática dos descontos, bem como na
        incidência dos encargos previstos na clausula sexta.
    </p>

    <p class="paragrafo">
        <b>Parágrafo Segundo:</b> OS BOLETOS SERÃO ENTREGUES NO ATO DA MATRICULA, CASO O CONTRATANTE TENHA ALGUM TIPO DE PROBLEMA PARA EFETUAR O PAGAMENTO,
        DEVERA REALIZA-LO NA SEDE DO ESTABELECIEMNTO DA CONTRATADA, O MESMO NÃO EXIME O CONTRATANTE DE FAZER O PAGAMENTO.
    </p>

    <p class="paragrafo">
        <b>Parágrafo Terceiro:</b> É obrigatório do contratante apresentar , sempre que solicitado,
        os documentos que comprovem o pagamento das prestações previstas nesse contrato, sob pena de não se dar a respectiva quitação.
    </p>

    <p class="paragrafo">
        <b>CLAUSULA SEXTA:</b> O atraso do pagamento de qualquer parcela dará causa ao pagamento de multa no valor de 2%(dois por cento)
        do valor debito, alem de juros moratórios de 0,034%( trinta e quatro milésimo por cento), correspondente a 1%( um por cento ) ao mês,
        computando desde o dia seguinte ao vencimento da obrigação ate a data do efetivo pagamento.
    </p>

    <p class="paragrafo">
        <b>Parágrafo Primeiro:</b> QUANDO O ATRASO FOR SUPERIOR A 30 (TRINTA) DIAS ANTES DA INCIDENCIA DOS JUROS MORATORIOS E DA MULTA
        A DIVIDA DEVERÁ SER CORRIGIDA PELA VARIAÇÃO DO INDICE DE PREÇOS AO CONSUMIDOR- IPC, ACUMULADO DESDE A DATA DO SEU VENCIMENTO.
    </p>

    <p class="paragrafo">
        <b>Parágrafo Segundo:</b> PODERÁ A CONTRATADA PARA COBRANÇA DO SEU CREDITO, VALER-SE DE FIRMA ESPECIALIZADA,
        OU DE PROFISSIONAIS DE ADVOCACIA, SENDO QUE NESTE CASO, O CONTRATANTE E SEU RESPONSAVEL FINANCEIRO,
        RESPONDERÃO TAMBEM POR HONORARIOS A ESTES DEVIDOS, NO PERCENTUAL CORRESPONDENTE A 20%(VINTE PORCENTO) SOBRE O TOTAL DA DIVIDA.
    </p>

    <p class="paragrafo">
        <b>Parágrafo Terceiro:</b> o inadimplemento de parcelas mensais, da multa, ou outra obrigação contratual de qualquer natureza,
        por prazo superior a 10(dez) dias autoriza a contratada a promover a inscrição do contratante em cadastros de devedores.
    </p>

    <p class="paragrafo">
        <b>Parágrafo Quarto:</b> A tolerância quanto ao descumprimento de qualquer obrigação contratual, não significará renuncia, perdão ou inovação.
    </p>

    <p class="paragrafo">
        <b>Clausula Sétima:</b> Toda e qualquer solicitação – Incluído, mas não se limitando aos casos de rescisão, emissão de certificados,
        cancelamento – Deverá ser feita mediante requerimento por escrito, assinado e datado, a ser preenchido e entregue, mediante protocolo, na secretaria da contratada.
    </p>

    <p class="paragrafo">
        <b>Parágrafo Primeiro:</b> O simples fato de o contratante deixar de comparecer as aulas e demais atividades ministradas não dará causa ao imediato
        cancelamento do contrato, nem tampouco assegurará ao contratante o direito de efetuar o seu pagamento proporcional.
    </p>

    <p class="paragrafo">
        <b>Parágrafo Segundo:</b> Na hipótese de abandono de curso, sem a devida formalização, o contratante ou seu responsável financeiro,
        continuara a responder pelas obrigações financeiras até a data da regularização de seu cancelamento.
    </p>

    <p class="paragrafo">
        <b>Parágrafo Terceiro:</b> No caso de abandono do curso no qual estava matriculado, o contratante terá trinta dias após a solicitação de afastamento,
        para reativar a sua matricula, desde que regularizado o debito, e existam vagas disponíveis.
    </p>

    <p class="paragrafo">
        <b>Parágrafo Quarto:</b> O cancelamento (resolução) do presente contrato ocorrera automaticamente,
        em caso de inadimplemento de qualquer parcela por mais de 60 dias (sessenta), independentemente de solicitação do contratante.
    </p>

    <p class="paragrafo">
        <b>CLAUSULA OITAVA:</b> O CANCELAMENTO (RESOLUÇÃO) DO CONTRADO, AUTOMATICAMENTE OU A REQUERIMENTO DO CONTRATANTE,
        IMPORTARÁ NA INCIDENCIA DE MULTA CORRESPONDENTE A 10%( DEZ POR CENTO) DO VALOR DAS PARCELAS RESTANTES OU O MONTANTE EQUIVALENTE A 1 (UMA) PARCELA,
        O QUE FOR MAIOR, SEM PREJUIZO AS DEMAIS OBRIGAÇÕES JÁ CONSTITUIDAS.
    </p>

    <p class="paragrafo">
        <b>CLAUSULA NONA:</b> QUALQUER  QUE SEJA O FUNDAMENTO PARA A EXTINÇÃO DO CONTRATO ( RESCISÃO OU RESOLUÇÃO) A
        CONTRATANTE NÃO TERÁ DIREITO A RESTITUIÇÃO A RESTITUIÇÃO DOS VALORES PAGOS A TITULO DE MATRICULA, OS QUAIS SÃO DESTINADOS AO PAGAMENTO DE DESPESAS ADMINISTRATIVA.
    </p>

    <p class="paragrafo">
        <b>CLAUSULA DECIMA:</b> <b>O CONTRATANTE</b> tem ciência e concorda expressamente que os livros de consulta ou acervo de reserva não podem ser retirados da Biblioteca,
        e servem, exclusivamente, para consultas no local. Caso o aluno precise retirar um livro, devera assinar os termos de contrato pré existentes na biblioteca,
        Caso o livro já tenha seu exemplar retirado, o mesmo não poderá sair para que o acervo não fique desfalcado.
    </p>

    <p class="paragrafo">
        <b>CLAUSULA DECIMA PRIMEIRA:</b> O Contratante deve ter ciência que a contratada não possui estacionamento e que de sua
        responsabilidade a seguridade do seu transporte. (carro, Moto).
    </p>

    <p class="paragrafo">
        <b>CLAUSULA DECINA SEGUNDA:</b> A contratada não se responsabiliza pela perda, furto, roubo ou danos de quaisquer objetos portados pelo contratante em qualquer das suas pendências físicas.
    </p>

    <p class="paragrafo">
        Por estarem, assim, justos e contratados, ora assinam o presente instrumento em duas vias de igual teor e forma, para que se produzam todos os efeitos legais
    </p>

    <p style="text-align: left; margin-top: 3%;">
        _______de_________________ de ___________.
    </p>

    <div style="margin-left: 0; margin-top: 5%;">
        <h1 style="text-align: left;">
            <table>
                <tr>
                    <td>___________________________________________</td>
                    <td> <span style="margin-left: 30px">___________________________________________</span></td>
                </tr>
                <tr>
                    <td style="font-family: arial; text-align: center"><b>(Assinatura contratante)</b></td>
                    <td style="font-family: arial; text-align: center"><span style="margin-left: 30px"><b>(Assinatura contratado)</b></span></td>
                </tr>
            </table>

            {{--<table style="">
                <tr><td><img src="{{ asset('img/assinatura_luciana_mestrado.png') }}" alt=""></td></tr>
                --}}{{--<tr><td>___________________________________________</td></tr>--}}{{--
                --}}{{--<tr><td style="text-align: center">Alpha Educação e Treinamentos</td></tr>--}}{{--
                --}}{{--<tr><td style="text-align: center">CNPJ: 22.945.385/0001-00</td></tr>--}}{{--
            </table>--}}
        </h1>
    </div>

    <div style="margin-left: 0; margin-top: 5%;">
        <h1 style="text-align: left;">
            <table>
                <tr>
                    <td>___________________________________________</td>
                </tr>
                <tr>
                    <td style="font-family: arial; text-align: center"><b>Responsável Financeiro</b></td>
                </tr>
            </table>

        </h1>
    </div>

    <br />
    <p>
        <b>TESTEMUNHAS</b>
    </p>

    <div style="margin-left: 0; margin-top: 5%;">
        <h1 style="text-align: left;">
            <table>
                <tr>
                    <td>___________________________________________</td>
                    <td> <span style="margin-left: 30px">___________________________________________</span></td>
                </tr>
                <tr>
                    <td style="font-family: arial; text-align: left">
                        <b>NOME:</b> <br />
                        <b>CPF:</b>
                    </td>
                    <td style="font-family: arial; text-align: left">
                        <span style="margin-left: 30px"><b>NOME:</b> <br /></span>
                        <span style="margin-left: 30px"><b>CPF:</b></span>
                    </td>
                </tr>
            </table>


            <br />
            <center>
            <table style="">
                <tr><td><img src="{{ asset('img/assinatura_luciana_mestrado.png') }}" alt=""></td></tr>
            </table>
            </center>
        </h1>
    </div>
</div>

</body>
</html>