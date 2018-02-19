<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title>ATA DE FREQUÊNCIA</title>
    <style type="text/css" class="init">
        body {
            font-family: arial;
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
        .corpo {
            font-size: 14px;
        }

        .percentFive {
            width: 10%;
        }

        .percentSixty {
            width: 40%;
        }

        .percentThirtyFive {
            width: 50%;
        }

        table {
            font-size: 12px;
            font-weight: bold;
            border-collapse: collapse;
        }

        table#tableHeader {
            margin-bottom: 5%;
        }

        table#tableHeader td {
            width: 50%;
        }

        table#tableHeader, table#tableBody {
            width: 100%;
        }

        td {
            padding-bottom: 1.0%;
            padding-left: 1.0%;
            padding-top: 0.5%;
        }

        /**** Estilos da table em duas páginas *****/
        table#tableBody { page-break-inside:auto }
        tr    { page-break-inside:avoid; page-break-after:auto }
        thead { display:table-header-group }
        tfoot { display:table-footer-group }

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
    <div style="width: 490px;"}>
        <p class="tituloTimbrado"><br><br>
            Portaria Normativa de Credenciamento da Faculdade ALPHA nº 1.248 de 29 de setembro de 2017,
            Portaria nº 1.062, de 06 de outubro de 2017 sobre autorização dos Cursos: Bacharelado em
            Administração, Licenciatura em Pedagogia, Tecnólogos em Gestão de Recursos Humanos e Análise de
            Desenvolvimento de Sistemas.
        </p>
    </div>
</div>
<div style="margin-top: -55px;">
    <img style="width: 100%;" src="{{asset('img/linha_declaracao_declaracao.png')}}">
</div>
<div class="titulo">
    <h4>ATA DE FREQUÊNCIA</h4>
</div>
<div class="titulo" style="margin-top: -50px">
    <p>{{ $dados['filtersBody'][2] ?? ""  }} - {{$dados['filtersBody'][0] ?? ""  }} - {{$dados['filtersBody'][1] ?? ""  }}  - {{ $dados['filtersBody'][3] ?? ""  }}</p>
</div>
<div class="corpo">

    <div style="text-align: left; margin-top: 15px;">
        Recife, {{ strftime('%d de %B de %Y', strtotime((new \DateTime("now"))->format("Y-m-d"))) }}
    </div>

    <br /><br/>

    <table id="tableBody" border="1">
        <thead>
        <tr>
            <th class="percentFive">Matrícula</th>
            <th class="percentSixty">Nome</th>
            <th class="percentThirtyFive">Assinatura</th>
        </tr>
        </thead>

        <tbody>
        <?php $count = 0; ?>
        @foreach($dados['body'] as $body)
            <tr>
                <td>{{ $body->matricula }}.</td>
                <td>{{ $body->nome }}</td>
                <td></td>
            </tr>
        @endforeach
        </tbody>
    </table>

</div>
<div style="margin-top: 150px;">
    <img style="width: 100%; height: auto;" src="{{asset('img/linha_declaracao_declaracao.png')}}">
</div>
<div class="rodapeTimbrado">
    Rua Gervásio Pires, 286, Santo Amaro, Recife – PE – CEP: 50.050-415<br>
    CNPJ: 15.708.483/0001-50<br>
    Fones: (81) 3071.7249 / 3039.0362 / 9.9516.2229 / 9.8446.0808<br>
    contato@alpha.rec.br  www.alpha.rec.br
</div>
</body>
</html>