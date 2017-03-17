<html>
<head>

</head>
<body>
@if($emprestimo)
    <center>RECIBO DE EMPRÉSTIMO</center>
    <hr style="width: 100%">
    <table style="width: 100%">
        <tr>
            <td>Aluno: {{$emprestimo->nome}}</td>
            <td>Identidade: {{$emprestimo->identidade}}</td>
        </tr>
        <tr>
            <td>Telefone: {{$emprestimo->celular}}</td>
        </tr>
        <tr>
            <?php /*$data = new \DateTime($emprestimo->data);  $data2 = new \DateTime($emprestimo->data_devolucao);
            $data3 = new \DateTime($emprestimo->data_devolucao_real);*/?>
            <td>Devolvido em: {{$emprestimo->data_devolucao_real}}</td>
        </tr>
        <tr>
            <td>Multa por atraso: {{$totalMulta}}</td>
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
            <th>Multa</th>
        </tr>
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
                <td>{{$exemplar->valor_multa}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif
</body>
</html>