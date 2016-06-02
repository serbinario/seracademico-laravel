<html>
<head>

</head>
<body>
    @if($result)
        <center>RECIBO DE EMPRÉSTIMO</center>
        <hr style="width: 100%">
        <table style="width: 100%">
            <tr>
                <td>Aluno: {{$result->aluno->nome}}</td>
                <td>Matrícula: {{$result->aluno->matricula}}</td>
            </tr>
            <tr>
                <td>Telefone: {{$result->aluno->celular}}</td>
            </tr>
            <tr>
                <?php $data = new \DateTime($result->data);  $data2 = new \DateTime($result->data_devolucao);?>
                <td>Emprestado em: {{$data->format('d/m/Y')}}</td>
                <td>Devolver em: {{$data2->format('d/m/Y')}}</td>
            </tr>
            <tr>
                <td>Código: {{$result->codigo}}</td>
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
                </tr>
            </thead>
            <tbody>
                @foreach($result->emprestimoExemplar as $exemplar)
                    <tr>
                        <td>{{$exemplar->acervo->titulo}}</td>
                        <td>{{$exemplar->acervo->cutter}}</td>
                        <td>{{$exemplar->acervo->cdd}}</td>
                        <td>{{$exemplar->codigo}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <hr style="width: 100%">

        <table style="width: 100%">
            <tr>
                <td>Aluno: {{$result->aluno->nome}}</td>
                <td>Matrícula: {{$result->aluno->matricula}}</td>
            </tr>
            <tr>
                <td>Telefone: {{$result->aluno->celular}}</td>
            </tr>
            <tr>
                <?php $data = new \DateTime($result->data);  $data2 = new \DateTime($result->data_devolucao);?>
                <td>Emprestado em: {{$data->format('d/m/Y')}}</td>
                <td>Devolver em: {{$data2->format('d/m/Y')}}</td>
            </tr>
            <tr>
                <td>Código: {{$result->codigo}}</td>
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
            </tr>
            </thead>
            <tbody>
            @foreach($result->emprestimoExemplar as $exemplar)
                <tr>
                    <td>{{$exemplar->acervo->titulo}}</td>
                    <td>{{$exemplar->acervo->cutter}}</td>
                    <td>{{$exemplar->acervo->cdd}}</td>
                    <td>{{$exemplar->codigo}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</body>
</html>