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
            background-image: url("{{ asset('img/marca_dagua_modelo.png') }}");
            background-repeat: no-repeat;
            background-position: center center;
        }

        table { page-break-inside:auto; }
        tr    { page-break-inside:avoid; page-break-after:auto }
        thead { display:table-header-group }
        tfoot { display:table-footer-group }

        .cabecalho h1 {
            margin-top: 0;
        }

        .cabecalho h2 {
            text-align: center;
            margin-left: 1%;
            font-size: 15px;
            text-decoration: underline;
        }

        .table {
            margin-left: 5%;
            margin-top: 5%;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            width: 92%;
        }

        .table tr {
            width: 100%;
        }

        .table tr, .table tr td  {
            border: 1px solid;
        }

        .table td {
            padding: 1%;
        }
    </style>
</head>

<body>

<div class="cabecalho">
    <h1>
        <img width="100" src="{{ asset('img/logo_modelo.png') }}" alt="FASUP">
    </h1>

    <h2>FICHA DE MATRÍCULA</h2>
</div>

<div class="conteudo">

    <table class="table" style="font-size: 11px; margin-bottom: 1%;">
        <tr>
            <td colspan="4">
                <b>PÓS-GRADUAÇÃO:</b> &nbsp;&nbsp; {{ $curso->nome }}
            </td>
        </tr>
    </table>

    <table class="table" style="font-size: 11px; margin-top: 1%; margin-bottom: 1%;">
        <tr>
            <td colspan="4">
                <b>Nome Completo:</b>&nbsp;&nbsp;{{ $aluno['pessoa']['nome'] }}
            </td>
        </tr>

        <tr>
            <td style="width: 50%;" colspan="2">
                <b>Data de Nascimento:</b>&nbsp;&nbsp;{{ $aluno['pessoa']['data_nasciemento']  }}
            </td>

            <?php $sexo = $aluno['pessoa']['sexo']['nome']?>
            <td style="width: 50%;" colspan="2">
                <b>Sexo:</b>&nbsp;&nbsp;({{ $sexo == 'Masculino' ? 'X' : ' ' }}) Masculino &nbsp;&nbsp;&nbsp; ({{ $sexo == 'Feminino' ? 'X' : ' ' }}) Feminino
            </td>
        </tr>

        <tr>
            <td colspan="4">
                <b>Naturalidade:</b>&nbsp;&nbsp;{{ $aluno['pessoa']['naturalidade'] }}
            </td>
        </tr>

        <tr>
            <?php $estadoCivil = $aluno['pessoa']['estadoCivil']['id'] ?? ''; ?>
            <td colspan="4">
                <b>Estado civil:</b>&nbsp;&nbsp;
                ({{$estadoCivil == 1 ? 'X' : ' '}}) Solteiro &nbsp;&nbsp;
                ({{$estadoCivil == 2 ? 'X' : ' '}}) Casado &nbsp;&nbsp;&nbsp;&nbsp;
                ({{$estadoCivil == 5 ? 'X' : ' '}}) Divorciado &nbsp;&nbsp;&nbsp;&nbsp;
                ({{$estadoCivil == 6 ? 'X' : ' '}}) Viúvo &nbsp;&nbsp;&nbsp;&nbsp;
                ({{$estadoCivil == 3 ? 'X' : ' '}}) Separado
            </td>
        </tr>
        <tr>
            <td colspan="4"><b>Nome do Pai:</b> &nbsp;&nbsp; {{ $aluno['pessoa']['nome_pai'] }}</td>
        </tr>
        <tr>
            <td colspan="4"><b>Nome da Mãe:</b> &nbsp;&nbsp; {{ $aluno['pessoa']['nome_mae'] }}</td>
        </tr>
        <tr>
            <td style="width: 40%">
                <b>Identidade: Nº</b> &nbsp;&nbsp; {{ $aluno['pessoa']['identidade'] }}
            </td>

            <td style="width: 20%">
                <b>Órgão Emissor:</b> &nbsp;&nbsp; {{ $aluno['pessoa']['orgao_rg'] ?? '' }}
            </td>

            <td colspan="2" style="width: 50%">
                <b>Expedição:</b> &nbsp;&nbsp; {{ $aluno['pessoa']['data_expedicao'] ?? '' }}
            </td>
        </tr>
        <tr>
            <td colspan="4"><b>CPF:</b> &nbsp;&nbsp; {{ $aluno['pessoa']['cpf'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Título de Eleitor: Nº</b> &nbsp;&nbsp; {{ $aluno['pessoa']['titulo_eleitoral'] ?? '' }}</td>
            <td><b>Zona:</b> &nbsp;&nbsp; {{ $aluno['pessoa']['zona'] ?? '' }}</td>
            <td><b>Seção:</b> &nbsp;&nbsp; {{ $aluno['pessoa']['secao'] ?? '' }}</td>
            <td><b>Expedição:</b> &nbsp;&nbsp; {{ $aluno['pessoa']['data_expedicao'] ?? '' }}</td>
        </tr>
        <tr>
            <td colspan="2"><b>Carteira de Reservista Nº :</b> &nbsp;&nbsp; {{ $aluno['pessoa']['resevista'] ?? '' }}</td>
            <td colspan="2"><b>Data de Expedição:</b> &nbsp;&nbsp; </td>
        </tr>
    </table>

    <table class="table" style="margin-top: 1%; margin-bottom: 1%;">
        <tr>
            <td colspan="3">
                <b>Endereço Residencial:</b>  &nbsp;&nbsp; {{ $aluno['pessoa']['endereco']['logradouro'] ?? '' }}
            </td>
            <td>
                <b>Nº</b> &nbsp;&nbsp; {{ $aluno['pessoa']['endereco']['numero'] ?? '' }}
            </td>
        </tr>
        <tr>
            <td style="width: 50%;" colspan="2"><b>Bairro:</b> &nbsp;&nbsp; {{ $aluno['pessoa']['endereco']['bairro']['nome'] ?? '' }}</td>
            <td style="width: 50%;" colspan="2"><b>Cidade:</b> &nbsp;&nbsp; {{ $aluno['pessoa']['endereco']['bairro']['cidade']['nome'] ?? '' }}</td>
        </tr>
        <tr>
            <td colspan="2"><b>Cep:</b> &nbsp;&nbsp;{{ $aluno['pessoa']['endereco']['cep'] ?? '' }}</td>
            <td colspan="2"><b>UF:</b> &nbsp;&nbsp; {{ $aluno['pessoa']['endereco']['bairro']['cidade']['estado']['prefixo'] ?? '' }}</td>
        </tr>
        <tr>
            <td colspan="4"><b>Complemento:</b> &nbsp;&nbsp; {{ $aluno['pessoa']['endereco']['complemento'] ?? '' }}</td>
        </tr>
        <tr>
            <td colspan="2" style="width: 40%"><b>Telefone Residencial:</b> &nbsp;&nbsp; {{ $aluno['pessoa']['telefone_fixo'] ?? '' }}</td>
            <td style="width: 30%"><b>Telefone Celular:</b> &nbsp;&nbsp; {{ $aluno['pessoa']['celular'] ?? '' }}</td>
            <td style="width: 30%"><b>Telefone Comercial:</b> &nbsp;&nbsp; </td>
        </tr>
        <tr>
            <td colspan="4"><b>E-mail (EM LETRA DE FORMA):</b> &nbsp;&nbsp; {{ $aluno['pessoa']['email'] ?? '' }}</td>
        </tr>
        <tr>
            <td colspan="4"><b>Instituição Anterior:</b>  &nbsp;&nbsp; {{ $aluno['pessoa']['instituicaoEscolar']['nome'] ?? ''}}</td>
        </tr>
        <tr>
            <td colspan="3"><b>Origem:</b> &nbsp;&nbsp; Estadual ( ) &nbsp;&nbsp;&nbsp;&nbsp; Federal ( ) &nbsp;&nbsp;&nbsp;&nbsp;  Particular ( ) </td>
            <td><b>Ano de Conclusão:</b> &nbsp;&nbsp; {{ $aluno['pessoa']['ano_conclusao_superior'] ?? '' }}</td>
        </tr>
        <tr>
            <td colspan="4"><b>Portador de necessidades Especiais</b>: &nbsp;&nbsp; Sim ( ) &nbsp;&nbsp;&nbsp;&nbsp; Não ( ) &nbsp;&nbsp;&nbsp;&nbsp; <b>Se sim, qual ?</b></td>
        </tr>
    </table>

    <div style="margin-left: 5%; margin-top: 3%">
        <p>Assinatura do Aluno _______________________________________________________________________________</p>
        <p>Matrícula de :  _________________  &nbsp; Data: ________/________/_____________</p>
        <p>Matrícula recebida por :_____________________________________  Data: _______/________/______________</p>
    </div>
</div>

<div class="rodape" style="text-align: center; margin-top: 5%;">
    <p style="margin: 0;"><b>Faculdade Modelo - FACIMOD.</b></p>
    <p style="margin: 0;">Credenciada pela Portaria Ministerial n° 2.413 de 11/08/2004 (D.O.U. de 12/08/2004).</p>
    <p style="margin: 0;">Mantida pelo  Instituto Modelo de Ensino Superior Ltda.</p>
    <p style="margin: 0;">CNPJ: 05.121.388/0001-00</p>
</div>

</body>
</html>