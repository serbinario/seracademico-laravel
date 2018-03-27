<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title>DECLARAÇÃO DE AVALIAÇÃO</title>
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
            margin-top: 130px;
            margin-bottom: 70px;
            text-align: center;
            font-size: 15px;
        }
        .corpo {
            font-size: 14px;
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
<div class="titulo">
    <h4>D E C L A R A Ç Ã O &nbsp; D E &nbsp; S E M A N A &nbsp; D E &nbsp; A V A L I A Ç Ã O</h4>
</div>
<div class="corpo">
    <p style="text-indent:80px; line-height: 50px; text-align: justify;">
        Declaramos para os devidos fins que o aluno <b>{{ isset($aluno['pessoa']) ? $aluno['pessoa']['nome'] : "" }}</b>,
        matrícula <b>{{$aluno['matricula']}}</b>, <b>CPF {{ isset($aluno['pessoa']['cpf']) ? $aluno['pessoa']['cpf'] : "" }}</b>,
        terá nos dias {{ $inicio }} até {{ $fim }} , 1ª avaliação de unidade, no Turno da {{ $turno->nome }} do <b>CURSO DE {{ isset($curso->nome) ? $curso->nome : "" }}</b>
        desta Faculdade.
    </p>

    <div style="text-align: center; margin-top: 50px;">
        Recife, {{ strftime('%d de %B de %Y', strtotime((new \DateTime("now"))->format("Y-m-d"))) }}
    </div>

    <div style="font-size: 11px; text-align: center; margin-top: 50px;">
        _______________________________<br>
        Dorivaldo Ramos Bezerra Junior<br>
        Secretário Geral da Faculdade e<br>
        Depositário do Acervo Acadêmico
    </div>
</div>
<div style="margin-top: 200px;">
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