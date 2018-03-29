<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title>Ficha de inscrição</title>

    <style type="text/css">
    body {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 12px;
        border: 3px solid;
        margin: 0;
        padding: 0;
    }

    table { page-break-inside:auto; }
    tr    { page-break-inside:avoid; page-break-after:auto }
    thead { display:table-header-group }
    tfoot { display:table-footer-group }

    .table {
        margin-left: 5%;
        margin-top: 5%;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 12px;
        width: 92%;
    }

    .table tr, .table tr td  {
        border: 1px solid;
    }

    .table td {
        padding: 1%;
    }

      /*  #imagem-um {
            width: 90px;
            margin-left: 7%;
        }
        */
       /*  #imagem-dois {
           width: 70px;
           margin-left: 13%;
           } */

    /*    #imagem-tres {
            width: 60px;
            margin-left: 13%;
            }*/

            #imagem-logo {
                width: 50%;
                height: auto; 
                display: block;
                margin-left: auto;
                margin-right: auto;
            }

            #header h1 {
                font-size: 12px;
                text-align: center;
                margin-top: 1%;
                margin-bottom: 5%;
            }

            #cursos {
                margin-top: 5%;
                margin-left: 5%;
            }

            #cursos table {
                font-weight: bold;
                width: 100%;
            }

            #pessoas h2 {
                margin-top: 5%;
                margin-left: 5%;
                margin-bottom: 1%;
                font-size: 12px;
            }

            #footer {
                position: absolute;
                bottom: 0;
                left: 5%;
                right: 5%;
            }
        </style>
    </head>

    <body>

        <div id="header">
            <br>
            <img id="imagem-logo" src="{{ asset('img/contrato-mestrado/image5.jpg') }}" alt="Logo">


            <!-- <img id="imagem-um" src="{{ asset('img/contrato-mestrado/image4.png') }}" alt="Logo"> -->
 <!--  {{-- <img id="imagem-tres" src="{{ asset('img/contrato-mestrado/image2.jpeg') }}" alt="Logo">--}}
  {{--<img id="imagem-dois" src="{{ asset('img/contrato-mestrado/image1.png') }}" alt="Logo">--}}
  <img id="imagem-quatro" src="{{ asset('img/contrato-mestrado/image3.jpeg') }}" alt="Logo"> -->

  <h1>FICHA DE INSCRIÇÃO DOUTORADO</h1>
</div>

<div id="body">
    <div id="cursos">
        <table style="font-size: 12px;">
           <!--  <tr>
               <td>({{ $curso->id == 25 ? 'X' : '  ' }}) MESTRADO EM EDUCAÇÃO</td>
               <td>({{ $curso->id == 28 ? 'X' : '  ' }}) MESTRADO EM PSICOLOGIA</td>
           </tr> -->

           <!-- Cursos citados não se encontram cadastrados na tabela fac_cursos não é possivel ainda fazer a marcação automática -->
           
           <tr><td>(&nbsp;&nbsp;&nbsp;&nbsp;)   DOUTORADO INTERNACIONAL EM SAÚDE PÚBLICA</td></tr>
           <tr><td>(&nbsp;&nbsp;&nbsp;&nbsp;)   DOUTORADO INTERNACIONAL EM  CIÊNCIAS DA EDUCAÇÃO</td> </tr>
           <tr><td>(&nbsp;&nbsp;&nbsp;&nbsp;)   DOUTORADO INTERNACIONAL EM  ADMINISTRAÇÃO DE EMPRESAS</td></tr>
       </table>
   </div>

   <div id="pessoas">
    <h2>Dados Pessoas</h2>

    <table class="table" style="margin-top: 0; margin-bottom: 2%;">
        <tr>
            <td colspan="3">Nome: {{ $aluno['pessoa']['nome'] }}</td>
        </tr>
        <tr>
            <td colspan="3">Formação Acadêmica (Graduação): {{ $aluno['pessoa']['cursoSuperior']['nome'] ?? '' }} </td>
        </tr>
        <tr>
            <td colspan="3">Pós-graduação:</td>
        </tr>
        <tr>
            <td colspan="3">Pai: {{ $aluno['pessoa']['nome_pai'] }}</td>
        </tr>
        <tr>
            <td colspan="3">Mãe: {{ $aluno['pessoa']['nome_mae'] }}</td>
        </tr>

        <?php $sexo = $aluno['pessoa']['sexo']['nome']?>
        <tr>
            <td>Estado Civil: {{ $aluno['pessoa']['estadoCivil']['nome'] ?? '' }}</td>
            <td colspan="2">Sexo: M ( {{ $sexo == 'Masculino' ? 'X' : '' }}) F ({{ $sexo == 'Feminino' ? 'X' : ''  }})</td>
        </tr>

        <tr>
            <td>Data de nascimento: {{ $aluno['pessoa']['data_nasciemento'] }}</td>
            <td colspan="2">Local: {{ $aluno['pessoa']['naturalidade'] }}</td>
        </tr>

        <tr>
            <td style="width: 30%">R.G: {{ $aluno['pessoa']['identidade'] ?? '' }}</td>
            <td style="width: 30%">Órgão emissor: {{ $aluno['pessoa']['orgao_rg'] ?? '' }}</td>
            <td>Data de expedição: {{ $aluno['pessoa']['data_expedicao'] ?? '' }}</td>
        </tr>

        <tr>
            <td>CPF: {{ $aluno['pessoa']['cpf'] ?? '' }}</td>
            <td colspan="2">Reservista: {{ $aluno['pessoa']['reservista'] ?? '' }}</td>
        </tr>

        <tr>
            <td>Titulo de eleitor: {{ $aluno['pessoa']['titulo_eleitoral'] ?? '' }}</td>
            <td>Seção: {{ $aluno['pessoa']['secao'] ?? '' }}</td>
            <td>Zona: {{ $aluno['pessoa']['zona'] ?? '' }}</td>
        </tr>
    </table>
</div>

<div id="endereco">
    <table class="table" style="margin-top: 0; margin-bottom: 2%;">
        <tr>
            <td><b>Endereço residencial: {{ $aluno['pessoa']['endereco']['logradouro'] ?? '' }}</b></td>
            <td>Nº {{ $aluno['pessoa']['endereco']['numero'] ?? '' }}</td>
        </tr>

        <tr>
            <td>BAIRRO: {{ $aluno['pessoa']['endereco']['bairro']['nome'] ?? '' }}</td>
            <td>CIDADE: {{ $aluno['pessoa']['endereco']['bairro']['cidade']['nome'] ?? '' }}</td>
        </tr>

        <tr>
            <td>UF: {{ $aluno['pessoa']['endereco']['bairro']['cidade']['estado']['nome'] ?? '' }}</td>
            <td>Cep: {{ $aluno['pessoa']['endereco']['cep'] ?? '' }}</td>
        </tr>

        <tr>
            <td>Telefone fixo: {{ $aluno['pessoa']['telefone_fixo'] ?? '' }}</td>
            <td>Celular: {{ $aluno['pessoa']['celular'] ?? '' }}</td>
        </tr>

        <tr>
            <td colspan="2">Email: {{ $aluno['pessoa']['email'] ?? '' }}</td>
        </tr>
    </table>
</div>

{{--<div id="profissional">--}}
    {{--<table class="table" style="margin-top: 0; margin-bottom: 2%;">--}}
        {{--<tr>--}}
            {{--<td><b>Endereço profissional:</b></td>--}}
            {{--<td>Nº</td>--}}
        {{--</tr>--}}

        {{--<tr>--}}
            {{--<td>BAIRRO:</td>--}}
            {{--<td>CIDADE:</td>--}}
        {{--</tr>--}}

        {{--<tr>--}}
            {{--<td>UF:</td>--}}
            {{--<td>Cep:</td>--}}
        {{--</tr>--}}

        {{--<tr>--}}
            {{--<td>Telefone fixo:</td>--}}
            {{--<td>Celular:</td>--}}
        {{--</tr>--}}

        {{--<tr>--}}
            {{--<td>Cargo que ocupa:</td>--}}
            {{--<td>Setor:</td>--}}
        {{--</tr>--}}

        {{--<tr>--}}
            {{--<td colspan="2">Email institucional:</td>--}}
        {{--</tr>--}}
    {{--</table>--}}
{{--</div>--}}
</div>

<div id="footer">
    <p>
        Matrícula de:______________Data:___/___/_____Recebido por:_______________________Valor: R$___________
    </p>

    <p>
        Assinatura do Aluno : ____________________________________________________________________________
    </p>
</div>

</body>
</html>