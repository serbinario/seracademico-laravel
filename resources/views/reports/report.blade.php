<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title></title>
    <link href="" rel="stylesheet" media="screen">
    <style type="text/css">
        table tbody th, table tbody td {
            padding: 2px 2px;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="row">
        <div class="col-md-12">
            <h3>{{ $dados['reportName'] }}</h3>
            <div>
                <table id="report" border="1" cellspacing="0" width="100%">
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
                {{ dd()  }}
            </div>
        </div>
    </div>
</body>
</html>