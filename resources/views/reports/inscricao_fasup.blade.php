<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title>Ficha de inscrição</title>

    <style type="text/css">
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            margin: 0;
            padding: 0;
            background-image: url("{{ asset('img/background-alpha.png') }}");
            background-repeat: no-repeat;
            background-position: center center;
        }

        table { page-break-inside:auto; }
        tr    { page-break-inside:avoid; page-break-after:auto }
        thead { display:table-header-group }
        tfoot { display:table-footer-group }

        .cabecalho h1 {
            text-align: center;
        }

        .cabecalho h2 {
            text-align: center;
            margin-left: 1%;
            font-size: 12px;
            text-decoration: underline;
            margin-bottom: 10%;
        }

        .table {
            font-size: 11px;
            font-family: Arial, Helvetica, sans-serif;
            width: 100%;
        }

        .table tr {
            width: 100%;
        }

        .table td {
            padding: 1%;
        }

        .column {
            border-bottom: 1px solid;
            width: 86%;
            margin-left: 1%;
            display: inline-block;
        }

    </style>
</head>

<body>

<div class="cabecalho">
    <h1>
        <img width="200" src="{{ asset('img/dd.jpg') }}" alt="FASUP">
    </h1>

    <h2>Ficha matrícula</h2>
</div>

<div class="conteudo">
    <table class="table" style="font-size: 11px;">
        <tr>
            <td colspan="4">
                PÓS-GRADUAÇÃO:<span class="column" style="width: 84%">{{ $curso->nome }}</span>
            </td>
        </tr>

        <tr>
            <td colspan="4" style="text-align: center">
                <b>Informações Pessoais: (Todos os campos são de preenchimento obrigatório)</b>
            </td>
        </tr>

        <tr>
            <td colspan="4">
                Nome Completo:<span class="column" style="width: 87%">{{ $aluno['pessoa']['nome'] }}</span>
            </td>
        </tr>

        <tr>
            <td style="width: 30%">
                Data de Nascimento:<span class="column" style="width: 50%">{{ $aluno['pessoa']['data_nasciemento']  }}</span>
            </td>

            <?php $sexo = $aluno['pessoa']['sexo']['nome']?>
            <td style="width: 30%">
                Sexo: &nbsp;&nbsp; ({{ $sexo == 'Masculino' ? 'X' : ' ' }}) Masculino &nbsp;&nbsp; ({{ $sexo == 'Feminino' ? 'X' : ' ' }}) Feminino
            </td>

            <td colspan="2">
                Naturalidade:<span class="column" style="width: 66%">{{ $aluno['pessoa']['naturalidade'] }}</span>
            </td>
        </tr>
        <tr>
            <?php $estadoCivil = $aluno['pessoa']['estadoCivil']['id'] ?? ''; ?>
            <td colspan="4">
                Estado civil:
                ({{$estadoCivil == 1 ? 'X' : ' '}}) Solteiro
                ({{$estadoCivil == 2 ? 'X' : ' '}}) Casado
                ({{$estadoCivil == 5 ? 'X' : ' '}}) Divorciado
                ({{$estadoCivil == 6 ? 'X' : ' '}}) Viúvo
                ({{$estadoCivil == 3 ? 'X' : ' '}}) Separado
            </td>
        </tr>
        <tr>
            <td colspan="4">Nome do Pai:<span class="column" style="width: 89%">{{ $aluno['pessoa']['nome_pai'] }}</span></td>
        </tr>
        <tr>
            <td colspan="4">Nome da Mãe: <span class="column" style="width: 88%">{{ $aluno['pessoa']['nome_mae'] }}</span></td>
        </tr>
        <tr>
            <td style="width: 40%">
                Identidade: Nº <span class="column" style="width: 70%">{{ $aluno['pessoa']['identidade'] }}</span>
            </td>

            <td style="width: 20%">
                Órgão Emissor:<span class="column" style="width: 48%">{{ $aluno['pessoa']['orgao_rg'] ?? '' }}</span>
            </td>

            <td colspan="2" style="width: 50%">
                Expedição:<span class="column" style="width: 73%">{{ $aluno['pessoa']['data_expedicao'] ?? '' }}</span>
            </td>
        </tr>
        <tr>
            <td>CPF:<span class="column" style="width: 47%">{{ $aluno['pessoa']['cpf'] ?? '' }}</span></td>
        </tr>
        <tr>
            <td colspan="4">
                Título de Eleitor: Nº <span class="column" style="width: 10%">{{ $aluno['pessoa']['titulo_eleitoral'] ?? '' }}</span>
                Zona:<span class="column" style="width: 17%">{{ $aluno['pessoa']['zona'] ?? '' }}</span>
                Seção:<span class="column" style="width: 17%">{{ $aluno['pessoa']['secao'] ?? '' }}</span>
                Expedição:<span class="column" style="width: 17%">{{ $aluno['pessoa']['data_expedicao'] ?? '' }}</span>
            </td>
        </tr>
        <tr>
            <td colspan="4">
                Carteira de Reservista: Nº <span class="column" style="width: 17%">{{ $aluno['pessoa']['resevista'] ?? '' }}</span>
                Data de Expedição: <span class="column" style="width: 17%"></span>
            </td>
        </tr>
        <tr>
            <td colspan="4">
                Endereço: <span class="column" style="width: 80%">{{ $aluno['pessoa']['endereco']['logradouro'] ?? '' }}</span>
                Nº <span class="column" style="width: 8%">{{ $aluno['pessoa']['endereco']['numero'] ?? '' }}</span>
            </td>
        </tr>
        <tr>
            <td>Bairro:<span class="column" style="width: 80%">{{ $aluno['pessoa']['endereco']['bairro']['nome'] ?? '' }}</span></td>
            <td>Cidade:<span class="column" style="width: 80%">{{ $aluno['pessoa']['endereco']['bairro']['cidade']['nome'] ?? '' }}</span></td>
            <td colspan="2">Complemento:<span class="column" style="width: 62%">{{ $aluno['pessoa']['endereco']['complemento'] ?? '' }}</span></td>
        </tr>
        <tr>
            <td style="width: 30%;">Cep:<span class="column" style="width: 50%">{{ $aluno['pessoa']['endereco']['cep'] ?? '' }}</span></td>
            <td style="width: 20%;">UF:<span class="column" style="width: 20%">{{ $aluno['pessoa']['endereco']['bairro']['cidade']['estado']['prefixo'] ?? '' }}</span></td>
        </tr>
        <tr>
            <td>Telefone Residencial:<span class="column" style="width: 55%">{{ $aluno['pessoa']['telefone_fixo'] ?? '' }}</span></td>
            <td>Telefone Celular:<span class="column" style="width: 55%">{{ $aluno['pessoa']['celular'] ?? '' }}</span></td>
        </tr>
        <tr>
            <td>Telefone Comercial:<span class="column" style="width: 55%"></span></td>
        </tr>
        <tr>
            <td colspan="4">E-mail:<span class="column" style="width: 93%">{{ $aluno['pessoa']['email'] ?? '' }}</span></td>
        </tr>
        <tr>
            <td colspan="4">Instituição Anterior: <span class="column" style="width: 85%"> {{ $aluno['pessoa']['instituicaoEscolar']['nome'] ?? ''}}</span></td>
        </tr>
        <tr>
            <td>Origem: Estadual ( )</td>
            <td>Federal ( )</td>
            <td>Particular ( )</td>
        </tr>
        <tr>
            <td colspan="4">Ano de Conclusão:<span class="column" style="width: 85%">{{ $aluno['pessoa']['ano_conclusao_superior'] ?? '' }}</span></td>
        </tr>
        <tr>
            <td colspan="4">Observações<span class="column" style="width: 89%"></span></td>
        </tr>
    </table>

    <div style="margin-left: 1%; margin-top: 3%">
        <p>Assinatura do Aluno _______________________________________________________________________________</p>
        <p>Matrícula de :  _________________  &nbsp; Data: ________/________/_____________</p>
        <p>Matrícula recebida por :_____________________________________  Data: _______/________/______________</p>
    </div>
</div>

<div class="rodape" style="text-align: center; margin-top: 22%;">
    <p style="margin-bottom: 0; text-align: center;">Rua Gervásio Pires, 826 Santo Amaro – Recife – PE</p>
    <p style="margin-bottom: 0; margin-top: 0; text-align: center;">Email: alphaatendimentorecife@gmail.com</p>
    <p style="margin-bottom: 0; margin-top: 0; text-align: center;">facebook.com/faculdadealpha</p>
    <p style="margin-bottom: 0; margin-top: 0; text-align: center;">(81) 3071-7249/9516-2229</p>
</div>

</body>
</html>