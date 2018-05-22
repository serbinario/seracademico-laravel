<html>
<head>
    {{--Documento personalizado em 03/04/2018 @Gustavo--}}
    {{--Documento personalizado em 25/04/2018 @Gustavo--}}
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title>Declaração de vínculo</title>
    <style>

    .borda{
       height: 916px;
       border: 5px solid black;
       padding: 10px 50px;
       margin: 0;  
   }
    .background{
      width: 70%;
      z-index: -10; 
      opacity: 0.3;
      position: absolute;
      top: 350px;
      left: 150px;
    } 
    </style>
</head>

<body>
    <div class="borda">
        <img class="background" src="{{ asset('img/logo-alpha.png') }}" alt="">
      <div class="cabecalho">
       
        <h1>
            <img width="130" src="{{ asset('img/logo-alpha_640x344.png') }}" alt="" style="position: relative; left: 500px;">
        </h1>

    </div>

    <div class="conteudo">
        <h2 style="text-align: center; margin-top: 100px;">
            <b>DECLARAÇÃO</b>
        </h2>
        <p style="font-size: 15px; text-align: justify;">
            Declaramos para fins de comprovação que o (a) Professor (a)
            Convidado (a)
            <strong>{{ $dados['body'][count($dados['body'])-1]->professor }}</strong>, CPF:
            <strong>{{ $dados['body'][count($dados['body'])-1]->cpf }}</strong> ministrou em nossa instituição a Disciplina
            <strong>{{ $dados['body'][count($dados['body'])-1]->disciplina }}</strong>, no Curso de Pós-Graduação (LATO SENSU) em
            <strong>{{ $dados['body'][count($dados['body'])-1]->curso }}</strong>, com carga horária de
            <strong>{{ $dados['body'][count($dados['body'])-1]->carga_horaria }}</strong> horas, em {{ strftime('%B de %Y', strtotime('today')) }}.
        </p>
        <div style="text-align: center; font-size: 18px; margin-top: 40px;">
            <div>
                O referido é verdadeiro e dou fé.
            </div>
            <p style="position: relative; left: 200px; top:50px">
                <strong>Recife, {{ strftime('%d de %B de %Y', strtotime('today')) }}.</strong>
            </p>
            <div class="assinatura" style="font-size: 18px; position: relative; top:100px; right:80px;">
    <p>
        <h1><img  src="{{ asset('img/assinatura_luciana.png') }}" alt="" style="margin-right: 10%; width: 330px; height: auto;"></h1>
    </p>
    <p style="position: absolute; top: 100px; margin-left: 27%;padding-left: 80px;">
        Luciana Teixeira Vitor
    </p>
    <p style="position: absolute; top: 120px; margin-left: 45%;">
        Direção Geral
    </p>
</div>
            <p style=" position:relative; left:150px; top:100px; display:block;width: 300px;font-size: 14px;color: #13205D" ><b>&nbsp;&nbsp;&nbsp; Faculdade Alpha</b> – CNPJ: 15.708.483/0001-50
                Rua Gervásio Pires, nº 826, Santo Amaro – Recife – PE.
            Fones: (81) 3071-7249 / 99516-2229/ 98446-0808</p>
        </div>
    </div>
</div>
</html>