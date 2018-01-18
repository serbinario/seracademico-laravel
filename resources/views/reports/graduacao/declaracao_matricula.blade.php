{{dd($curso)}}
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title>DECLARAÇÃO DE MATRÍCULA</title>
    <style type="text/css" class="init">
        body {
            font-family: arial;
        }

        .logoTimbrado {
            position: relative;
            margin-top: -70px;
            margin-left: -29px;
        }

        .tituloTimbrado {
            position: relative;
            margin-top: -193px;
            left: 215px;
            color: #273176;
            font-size: 20px;
        }

        .rodapeTimbrado {
            /*position: absolute;*/
            margin-top: 546px;
            color: #273176;
            font-size: 20px;
            text-align: center;
        }

        .titulo {
            margin-top: 100px;
            margin-bottom: 100px;
            text-align: center;
            font-size: 20px;
        }
        .corpo {
            font-size: 20px;
        }

    </style>
    <link href="" rel="stylesheet" media="print">
</head>
<body>
<div class="logoTimbrado">
    <img style="width: 250px; height: auto" src="{{asset('img/logo_alpha_faculdade-01.png')}}">
</div>
<div class="tituloTimbrado">
    Portaria Normativa de Credenciamento da Faculdade ALPHA nº 1.248 <br>
    de 29 de setembro de 2017, Portaria nº 1.062, de 06 de outubro de 2017 <br>
    sobre autorização dos Cursos: Bacharelado em Administração,<br>
    Licenciatura em Pedagogia, Tecnólogos em Gestão de Recursos Humanos <br>
    e Análise de Desenvolvimento de Sistemas.
</div>

<div class="titulo">
    <h3>D E C L A R A Ç Ã O &nbsp; D E &nbsp; M A T R Í C U L A</h3>
</div>

<div class="corpo">
    <p style="text-indent:80px;">
        Declaramos para os devidos fins que o aluno {{ isset($aluno['pessoa']) ? $aluno['pessoa']['nome'] : "" }},
        matrícula {{$aluno['matricula']}}, CPF {{ isset($aluno['pessoa']['cpf']) ? $aluno['pessoa']['cpf'] : "" }},
        encontra-se regularmente matriculado no Campus Recife, no Turno da {{ $turno->nome }}, com carga horária
        equivalente ao {{ $semestre['periodo'] }}º Período do CURSO DE {{ isset($curso->nome) ? $curso->nome : "" }}
        desta Faculdade.
    </p>

    <div style="text-align: center; margin-top: 50px;">
        Recife, {{ strftime('%d de %B de %Y', strtotime((new \DateTime("now"))->format("Y-m-d"))) }}
    </div>

    <div style="text-align: center; margin-top: 50px;">
        _______________________________<br>
        Dorivaldo Ramos Bezerra Junior<br>
        Secretário Geral da Faculdade e Depositário do Acervo Acadêmico
    </div>
</div>

<div class="rodapeTimbrado">
    Rua Gervásio Pires, 286, Santo Amaro, Recife – PE – CEP: 50.050-415<br>
    CNPJ: 15.708.483/0001-50<br>
    Fones: (81) 3071.7249 / 3039.0362 / 9.9516.2229 / 9.8446.0808<br>
    contato@alpha.rec.br  www.alpha.rec.br
</div>
</body>
</html>