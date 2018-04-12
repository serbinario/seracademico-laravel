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
    @if(isset($emprestimo))
    <h3>RECIBO DE DEVOLUÇÃO</h3>
    <p>---------------------------------------------------------------------------------------------------------------------------------------------</p>
    <span class="texto">
        {{ $emprestimo->nome }}
    </span><br />
    <span class="texto">
        CPF: {{ $emprestimo->cpf }}
    </span><br />
    <span class="texto">
        Telefone: {{ $emprestimo->celular }}
    </span><br />
    <span class="texto">
        Emprestado em: {{ $emprestimo->data }}<br />
        Devolver em: {{ $emprestimo->data_devolucao }} <br />
        Devolvido em: {{ $emprestimo->data_devolucao_real }}
    </span><br />
    <p class="texto">Código: {{ $emprestimo->codigo }}</p>
</span><br />
<?php if($emprestimo->valor_multa > 0): ?>
    <span class="texto">
        Multa por atraso: {{ $emprestimo->valor_multa }}
    </span>
<?php endif; ?> 
<p>---------------------------------------------------------------------------------------------------------------------------------------------</p>

<br />

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
            <?php if($emprestimo->valor_multa > 0): ?>
                <th>Multa</th>
            <?php endif; ?>

     </tr>
 </thead>
 <tbody>
    @foreach($exemplares as $exemplar)
    <tr>
        <td>{{ $exemplar->titulo }}</td>
        <td>{{ $exemplar->cutter }}</td>
        <td>{{ $exemplar->cdd }}</td>
        <td>{{ $exemplar->tombo }}</td>
        <?php if($emprestimo->valor_multa > 0): ?>
            <td>{{ $exemplar->valor_multa }}</td>
        <?php endif; ?>
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