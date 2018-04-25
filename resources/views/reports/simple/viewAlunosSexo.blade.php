<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title></title>
    <link href="" rel="stylesheet" media="screen">
    <style type="text/css">
    table tbody th, table tbody td {
        padding: 2px 2px;
        font-size: 11px;
    }

    table {
        margin: 0 auto;
    }

</style>
</head>

<body>
    <div class="row">
        <table>
            <tr>
                <td><br>
                    <h1 style="text-align: center;color: #082652; ">{{ $dados['reportName'] }}</h1>
                    <h3 style="text-align: center;color: #082652; ">
                        @if(count($dados['filtersHeaders']) === count($dados['filtersBody']))
                        @for ($i = 0; $i < count($dados['filtersHeaders']); $i++)
                        {{ $dados['filtersHeaders'][$i]  }} : {{ $dados['filtersBody'][$i] }} <br>
                        @endfor
                        @endif
                    </h3>
                </td>
                {{--<td width="15%">--}}
                    {{--<img alt="image" width="100%" src="{{ asset('/img/seracad.png')}}"/>--}}
                {{--</td>--}}
            </tr>
        </table>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12">
            <div>
                <table id="report"  width="100%" border="1" cellspacing="0" style="border: 1px solid lightgray;">
                    <thead>
                        <tr>
                            <th>Nº</th>
                            @foreach($dados['headers'] as $value)
                            <th>{{ $value }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <?php $count = 0; ?>
                        @foreach($dados['body'] as $bordy)
                        <tr>
                            <th>{{++$count}}</th>
                            <!-- Percorrendo as colunas que tem reflexo no banco -->
                            @foreach($bordy as $key => $value)
                            <td>{{ $value }}</td>
                            @endforeach

                            <!-- Percorrendo as colunas que não tem reflexo no banco -->
                            @for($i = 0; $i < (count($dados['headers'])) - count(get_object_vars($dados['body'][0] ?? [])); $i++)
                            <td></td>
                            @endfor
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <table border="1" style=" border-collapse: collapse; margin-top: 30px">
                    <tr>
                        <th>Masculino</th>
                        <th>Feminino</th>
                    </tr>
                    <tr>
                        <td><?=$dados[0]->Quantidade?></td>
                        <td><?=$dados[1]->Quantidade?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>
</html>