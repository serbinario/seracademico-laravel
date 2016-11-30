<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title></title>
    <style type="text/css" class="init">
        div#container {
            text-align: center;
        }

        div#body {
            margin-bottom: 30px;
        }

        div#footer {
            text-align: justify;
            font-size: 12px;;
        }
    </style>
    <link href="" rel="stylesheet" media="screen">
    <link href="{{ asset('/css/bootstrap.min.css')}}" rel="stylesheet">
    <script src="{{ asset('/js/bootstrap.min.js')}}"></script>
</head>
<body>
    <div id="container">
        <div class="row" id="header">
            <div class="col-md-12">
                <h1>Histórico</h1>
            </div>
        </div>

        <!-- Variáveis úteis php -->
        <?php  $mediaGeral = 0.0; $cargaHorariaCumprida = 0.0; ?>

        <div class="row" id="body">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Nº</th>
                                <th>Disciplinas</th>
                                <th>C.H.</th>
                                <th>Nota</th>
                                <th>Freq.</th>
                                <th>Professor</th>
                                <th>Titulação</th>
                            </tr>
                            </thead>

                            <tbody>
                            @for($i = 0;$i < count($dados); $i++)
                                <?php $mediaGeral += $dados[$i]['nota']; $cargaHorariaCumprida += $dados[$i]['carga_horaria']; ?>
                                <tr>
                                    <td>{{ $i +1 }}</td>
                                    <td>{{ $dados[$i]['disciplina'] }}</td>
                                    <td>{{ $dados[$i]['carga_horaria'] }}</td>
                                    <td>{{ $dados[$i]['nota'] }}</td>
                                    <td>{{ $dados[$i]['frequencia'] }}</td>
                                    <td>{{ $dados[$i]['professor'] }}</td>
                                    <td>{{ $dados[$i]['titulacao'] }}</td>
                                </tr>
                            @endfor
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4" style="width: 50%">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <th>Média Geral</th>
                            <th>Carga Horária Cumprida</th>
                            </thead>

                            <tbody>
                            <tr>
                                <td>{{ $mediaGeral }}</td>
                                <td>{{ $cargaHorariaCumprida }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row" id="footer">
                    <div class="col-md-4" style="width: 50%;  float: left;">
                        <p>
                            TEMA DO ARTIGO: <b>ESTUDANTES COM NECESSIDADES ESPECIAIS: INSERIR X INCLUIR</b>
                        </p>

                        <p>
                            NOTA DA MONOGRAFIA: <b>PROFESSOR(A):  José Ramon Gadelha</b>
                        </p>

                        <p>
                            FORMA DE AVALIAÇÃO DO APROVEITAMENTO ADOTADA:
                            <ul>
                                <li>A média final é o resultado da média aritmética das notas obtidas.</li>
                                <li>A nota mínima para aprovação em cada disciplina é 7,0 (sete).</li>
                                <li>A frequência mínima obrigatória é 75%.</li>
                            </ul>
                        </p>
                    </div>

                    <div class="col-md-4" style="border: 1px solid; height: 100px;width: 40%; float: right;">
                        <p>
                            Declaro que o curso cumpriu todas as disposições de resolução Nº 1, de 08/06/2007 –
                            CNE que estabelece normas para o funcionamento de cursos de Pós-Graduação
                            Latu Senso em nível de especialização.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>