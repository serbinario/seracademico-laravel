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

            <td>Emprestado em: {{ $emprestimo->data }}</td>
            <td>Devolver em: {{ $emprestimo->data_devolucao }}</td>
            <td>Devolvido em: {{ $emprestimo->data_devolucao_real }}</td>
        </tr>
        <tr>
            <td>Código: {{$emprestimo->codigo}}</td>
        </tr>
        <tr>
            <td>Multa por atraso: {{$emprestimo->valor_multa}}</td>
        </tr>
        <tr>
            <td>1º Via Biblioteca</td>
            <td><center>__________________________<br />Assinatura</center></td>
        </tr>
    </table>
    Livros Emprestados:
    <table style="width: 100%" border="1">
        <thead>
        <tr>
            <th>Título</th>
            <th>Cutter</th>
            <th>CDD</th>
            <th>Tombo</th>
            <th>Multa</th>
        </tr>
        </thead>
        <tbody>
        @foreach($exemplares as $exemplar)
            <tr>
                <td>{{$exemplar->titulo}}</td>
                <td>{{$exemplar->cutter}}</td>
                <td>{{$exemplar->cdd}}</td>
                <td>{{$exemplar->tombo}}</td>
                <td>{{$exemplar->valor_multa}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif
</body>
</html>