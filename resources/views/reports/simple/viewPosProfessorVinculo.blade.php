<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title>Declaração de vínculo</title>
</head>

<body>
    <div class="cabecalho">
        <h1>
            <img width="185" src="{{ asset('img/dd.jpg') }}" alt="" style="position: relative; left: 500px; top: 50px;">
        </h1>
    </div>

    <div class="conteudo">
        <h2 style="text-align: center; margin-top: 30px;">
            DECLARAÇÃO
        </h2>
        <p style="font-size: 18px; text-align: justify; line-height: 50px; text-indent: 30px;">
            Declaramos para fins de comprovação que o(a) Professor(a)
            <strong>{{ $dados['body'][count($dados['body'])-1]->professor }}</strong>, Portadora do CPF:
            <strong>{{ $dados['body'][count($dados['body'])-1]->cpf }}</strong> ministrou em nossa instituição a Disciplina
            <strong>{{ $dados['body'][count($dados['body'])-1]->disciplina }}</strong>, no Curso de Especialização, Pós-Graduação (LATO SENSU) em
            <strong>{{ $dados['body'][count($dados['body'])-1]->curso }}</strong>, com carga horária de
            <strong>{{ $dados['body'][count($dados['body'])-1]->carga_horaria }}</strong> horas, em {{ strftime('%B de %Y', strtotime('today')) }}.
        </p>
        <div style="text-align: center; font-size: 18px; margin-top: 40px;">
            <div>
                O referido é verdadeiro e dou fé.
            </div>
            <p style="margin-top: 20px;">
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

    <div class="rodape" style="text-align: center; font-size: 18px; margin-top: 10px">
        <div>
            ALPHA EDUCAÇÃO E TREINAMENTOS – CNPJ: 22.945.385/0001-00
        </div>
        <div>
            Rua Gervásio Pires, nº 826, Santo Amaro – Recife – PE.
        </div>
        <div>
            Facebook.com/faculdadealpha
        </div>
        <div>
            Fones: (81) 3071-7249 / 99516-2229 / 98446-0808
        </div>
    </div>
</body>
</html>