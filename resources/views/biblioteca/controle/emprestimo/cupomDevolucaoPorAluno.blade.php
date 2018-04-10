<html>
<head>

</head>
<body>
    @if($emprestimo)
    <center>RECIBO DE EMPRÉSTIMO</center>
    <hr style="width: 100%">
    <table style="width: 100%">
        <meta charset="UTF-8">
        <tr>
            <td>Aluno: {{$emprestimo->nome}}</td>
            <td>Identidade: {{$emprestimo->identidade}}</td>
        </tr>
        <tr>
            <td>Telefone: {{$emprestimo->celular}}</td>
        </tr>
        <tr>
            <td>Codigo: {{$emprestimo->codigo}}</td>
        </tr>
        <tr>

            <td>Devolvido em: {{$emprestimo->data_devolucao_real}}</td>
        </tr>
        <tr>
            <?php $multaTotal = 0?>
           @foreach($exemplares as $exemplar)
           <?php if($exemplar->valor_multa != null){
            $multaTotal = $multaTotal + $exemplar->valor_multa;
        } ?>
        @endforeach
        <?php if($multaTotal != 0): ?>
            <td> Multa Total:R$ <?=$multaTotal?>,00</td>   
        <?php endif;?>
    </tr>
    <tr>
        <td>1º Via Biblioteca</td>
        <td><center>__________________________<br />Assinatura</center></td>
    </tr>
</table>
Livros Emprestados: <br /><br />
<table style="width: 100%" border="1">
    <thead>
        <tr>
            <th>Código</th>
            <th>Título</th>
            <th>Cutter</th>
            <th>CDD</th>
            <th>Tombo</th>
            <th>Data</th>
            <th>Data de devolução</th>
            <?php if($multaTotal != 0): ?>
                <th>Multa </th>    
            <?php endif;?>            </tr>
        </thead>
        <tbody>
            @foreach($exemplares as $exemplar)
            <tr>
                <td>{{$exemplar->codigo}}</td>
                <td>{{$exemplar->titulo}}</td>
                <td>{{$exemplar->cutter}}</td>
                <td>{{$exemplar->cdd}}</td>
                <td>{{$exemplar->tombo}}</td>
                <td>{{$exemplar->data}}</td>
                <td>{{$exemplar->data_devolucao}}</td>
                <?php if($exemplar->valor_multa != null): ?>
                    <td>{{$exemplar->valor_multa}}</td>
                <?php endif;?>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</body>
</html>