<html>
<header>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</header>
<body style="background: #e0e0e0; font-family: verdana">
    <div style="width: 70%; margin: 0 auto; max-width: 1280px;">
        <section style="background: white; border-radius: 10px; padding: 25px; margin-top: 10%;">
            <img src="http://alpha.rec.br/wp-content/uploads/2017/03/logoalphacs.png" alt="" style="width: 25%; margin-left: 35%;">
            <hr>
            <h4>Olá, {{ $vestibulando->nome }}</h4>
            <article style="text-align: justify;">
            	<img src="http://alpha.rec.br/wp-content/uploads/2017/11/ok-1976099_640.png" alt="" style="width: 25%; margin-left: 35%;"><br>
				O pagamento da sua inscrição do vestibular <b>{{ $vestibular }}</b>, foi confirmado!
            </article>          
        </section>
    </div>
</body>
</html>