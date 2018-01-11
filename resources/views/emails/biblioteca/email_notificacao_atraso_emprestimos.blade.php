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
            <h4 style="text-align: center">BIBLIOTECA SUELANDRE GONSALVES LIMA</h4>
            <p style="text-align: justify;">
                Prezado(a) {{ $emprestimo->nome }}, até a presente data constatamos que o {{ $exemplares[0]->tipo_acervo }}(s)
            </p>
            <hr>
            <p style="text-align: justify;">
                não foi devolvido ao acervo da Biblioteca e encontra-se em atraso. Pedimos que o mais breve possível
                compareça ao setor para devolução do supracitado(s) título(s).
            </p>
            <br />
            <table style="width: 100%; border-collapse: collapse;" cellspacing="0" cellpadding="0" border="1">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Subtítulo</th>
                        <th>Número de chamada</th>
                        <th>Tombo</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($exemplares as $exemplar)
                        <tr style="text-align: center">
                            <td >{{ $exemplar->titulo }}</td>
                            <td>{{ $exemplar->subtitulo }}</td>
                            <td>{{ $exemplar->numero_chamada }}</td>
                            <td>{{ $exemplar->tombo }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <br /><br />
            <p style="text-align: justify;">
                Desde já agradecemos a sua compreensão e colaboração.
            </p>
            <br /><br />
            <p style="text-align: justify;">
                <i>À Biblioteca</i>
            </p>
        </section>
    </div>
</body>
</html>