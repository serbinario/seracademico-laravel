<html>
<head>
    <meta charset="utf-8">
<style type="text/css">
    .texto {
        font-size: 32px;
    }
    p {
        margin-top: 8px;
    }
    h5 {
        margin-bottom: -8px;
    }
    table, table th, table td {
        border: 1px solid black;
        border-collapse: collapse;
        font-size: 30px;
    }
</style>
</head>
<body>
    @if($result)
    <?php //dd($result);?>
        <h3>RECIBO DE EMPRÉSTIMO</h3>
        <p>----------------------------------------------</p>
        <span class="texto">
            {{ $result->pessoa->nome }}
        </span><br />
        <span class="texto">
            CPF: {{ $result->pessoa->cpf }}
        </span><br />
        <span class="texto">
            Telefone: {{ $result->pessoa->celular }}
        </span><br />
        <?php //if($result->tipo_pessoa != 5):?>
            <!-- <span class="texto">
                Matricula: {{ $result->pessoa->matricula }}
            </span><br /> -->
        <?php //endif;?>
        <span class="texto">
            <?php $data = new \DateTime($result->data);  $data2 = new \DateTime($result->data_devolucao);?>
                Emprestado em: {{ $data->format('d/m/Y') }}<br />
                Devolver em: {{ $data2->format('d/m/Y') }}
        </span><br />
        <p>----------------------------------------------</p>
        <span class="texto">
           ACERVOS EMPRESTADOS:
        </span><br /><br />
        <table style="width: 100%" border="1">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Cutter</th>
                    <th>CDD</th>
                    <th>Tombo</th>
                </tr>
            </thead>
            <tbody>
                @foreach($result->emprestimoExemplar as $exemplar)
                    <tr>
                        <td>{{ $exemplar->acervo->titulo }}</td>
                        <td>{{ $exemplar->acervo->cutter }}</td>
                        <td>{{ $exemplar->acervo->cdd }}</td>
                        <td>{{ $exemplar->codigo }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    <br />
    <span class="texto">
            1º Via Biblioteca<br /><br />
            ____________________________________________<br />Assinatura
    </span>
</body>
</html>