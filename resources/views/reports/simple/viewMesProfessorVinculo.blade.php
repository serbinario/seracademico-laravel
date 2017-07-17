<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title>Declaração de vínculo</title>
</head>

<body>
    <div class="cabecalho">
        <h1>
            <img width="150" src="{{ asset('img/vinculo-mestrado/image1.png') }}" alt="" style="margin-left: 50px;">
        </h1>
        <h1>
            <img width="150" src="{{ asset('img/dd.jpg') }}" alt="" style="position: absolute; left: 500px; top: 50px;">
        </h1>
    </div>

    <div class="conteudo">
        <h2 style="text-align: center; margin-top: 70px;">
            DECLARAÇÃO
        </h2>
        <hr style="margin-bottom: 25px; margin-top: 25px;">
        <p style="font-size: 18px">
            Declaramos para fins de comprovação que o(a) Professor(a) <strong>{{ $dados['body'][count($dados['body'])-1]->professor }}</strong>,
            <strong>{{ $dados['body'][count($dados['body'])-1]->cpf }}</strong> ministrou em nossa instituição
            Disciplina <strong>{{ $dados['body'][count($dados['body'])-1]->disciplina }}</strong>, como Professor(ar) Convidado(a), no
            <strong>{{ $dados['body'][count($dados['body'])-1]->curso }}</strong>, com carga horária de
            <strong>{{ $dados['body'][count($dados['body'])-1]->carga_horaria }}</strong> horas, em {{ strftime('%B de %Y', strtotime('today')) }}.
        </p>
    </div>

    <div class="assinatura" style="margin-left: 5%;">
        <p>
            <h1><img  src="{{ asset('img/vinculo-mestrado/assinatura.png') }}" alt=""></h1>
        </p>
    </div>

    <div class="rodape" style="margin-left: 6%;">
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