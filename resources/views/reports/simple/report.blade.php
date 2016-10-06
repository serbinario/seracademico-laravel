<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title></title>
    <link href="" rel="stylesheet" media="screen">
    <style type="text/css">
        table tbody th, table tbody td {
            padding: 2px 2px;
            font-size: 15px;
        }
    </style>
</head>

<body>
    <div class="row">
        <table width="100%">
            <tr>
                <td width="20%">
                    <img alt="image" width="100%" src="{{ asset('/img/logo-alpha.png')}}"/>
                </td>
                <td width="55%"><br>
                    <h1 style="text-align: center;color: #082652; ">{{ $dados['reportName'] }}</h1>
                    <h3 style="text-align: center;color: #082652; ">
                        @if(count($dados['filtersHeaders']) === count($dados['filtersBody']))
                            @for ($i = 0; $i < count($dados['filtersHeaders']); $i++)
                                {{ $dados['filtersHeaders'][$i]  }} : {{ $dados['filtersBody'][$i] }} <br>
                            @endfor
                        @endif
                    </h3>
                </td>
                <td width="15%">
                    <img alt="image" width="100%" src="{{ asset('/img/seracad.png')}}"/>
                </td>
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
                        @foreach($dados['headers'] as $value)
                            <th>{{ $value }}</th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    
                        @foreach($dados['body'] as $bordy)
                            <tr>
                                @foreach($bordy as $key => $value)
                                    <td>{{ $value }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>