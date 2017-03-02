<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title>Declaração de vínculo</title>
    <style type="text/css">
        body {
            background-image: url("{{ asset('img/vinculo-mestrado/image3.png') }}");
            background-repeat: no-repeat;
            background-position: center;
            background-size: 80%;
        }

        .cabecalho h1 {
            text-align: center;
        }

        .cabecalho h2 {
            text-align: center;
        }

        .conteudo {
            margin-top: 15%;
            text-align: justify;
            font-size: 22px;
        }

        .rodape {
            position: absolute;
            bottom: 0;
            font-size: 18px;
        }

        .rodape > p {
            text-align: justify;
            font-style: italic;
        }

        .rodape p + p {
            text-align: center;
            font-style: normal;
        }

        .assinatura {
            margin-top: 10%;
        }
    </style>
</head>

<body>
    <div class="cabecalho">
        <h1>
            <img width="200" src="{{ asset('img/vinculo-mestrado/image1.png') }}" alt="">
        </h1>

        <h2>
          CARTA DE ACEITE
        </h2>
    </div>

    <div class="conteudo">
        <p>
            <b>Estudante:</b> {{$aluno['pessoa']['nome']}}<br>
            <b>CPF</b>  {{$aluno['pessoa']['cpf']}}<br>
            <b>Curso:</b> {{ isset($curso->nome) ? $curso->nome : ""  }}<br>
            <b>Faculdade:</b> Faculdade de Ciências da Educação - FCE<br>
            <b>Seccional:</b> Lusófona<br>
            <b>País:</b> Brasil<br>
        </p>

        <hr>

        <h3><b>Câmara Lusófona de Pós-Graduação</b></h3>

        <p>
            Ao <b>vigésimo terceiro dia do mês de Julho de 2016</b>, sob a <b>Gestão da Câmara Lusófona de Pós-Graduação.</b>
            Representada por sua <b>Faculdade de Ciências da Educação – School of Education</b>, sob a gestão representativa
            da representação legal da <b>Holding Britânica UniGrendal</b>, qualificada no Brasil como <b>Universidade Grendal do
            Brasil</b>, CNPJ 12.147.854/0001-84, reuniram-se em local a coberto os <b>Doutores do Comitê Acadêmico da School
            of Education</b>, a fim de declararem que o aluno(a) citado(a) acima encontra-se devidamente matriculado(a) e
            ativo(a) no curso de Mestrado Internacional em Políticas Públicas com Ênfase em Saúde.
        </p>
    </div>

    <div class="assinatura">
        <p>
            <h1><img width="250" height="250" src="{{ asset('img/vinculo-mestrado/assinatura.png') }}" alt=""></h1>
        </p>
    </div>

    <div class="rodape">
        <p>
            <b>Ps.</b> The above information is a certified copy of data extracted from the official transcript of the named
            individual. This information is confidential and is for verification purposes only.
        </p>

        <p>
            Email: registrar@grendaluniversity.org.uk I www.grendaluniversity.org.uk
        </p>
    </div>
</body>
</html>