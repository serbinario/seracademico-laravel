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
            Declaramos para fins de comprovação que o(a) Professor(a)
            <strong>{{ $dados['body'][count($dados['body'])-1]->professor }}</strong>, CPF:
            <strong>{{ $dados['body'][count($dados['body'])-1]->cpf }}</strong> ministrou em nossa instituição a Disciplina
            <strong>{{ $dados['body'][count($dados['body'])-1]->disciplina }}</strong>, como Professor(ar) Convidado(a), no
            <strong>{{ $dados['body'][count($dados['body'])-1]->curso }}</strong>, com carga horária de
            <strong>{{ $dados['body'][count($dados['body'])-1]->carga_horaria }}</strong> horas, em {{ strftime('%B de %Y', strtotime('today')) }}.
        </p>
        <div style="text-align: center; font-size: 18px; margin-top: 55px;">
            <p>
                O referido é verdadeiro e dou fé.
            </p>
            <p style="margin-top: 75px;">
                <strong>Recife, {{ strftime('%d de %B de %Y', strtotime('today')) }}</strong>
            </p>
        </div>
    </div>

    <div class="assinatura" style="font-size: 18px">
        <p>
            <h1><img  src="{{ asset('img/assinatura_luciana.png') }}" alt="" style="margin-left: 20%; width: 330px; height: auto;"></h1>
        </p>
        <p style="position: absolute; top: 80px; margin-left: 27%;">
            ___________________________________
        </p>
        <p style="position: absolute; top: 80px; margin-left: 45%;">
            Direção
        </p>
    </div>

    <div class="rodape" style="text-align: center; font-size: 18px">
        <p>
            Email: registrar@grendaluniversity.org.uk | www.grendaluniversity.org.uk
        </p>
    </div>
</body>
</html>