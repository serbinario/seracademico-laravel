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
            <h3>Comprovante de Inscrição</h3>
            <div class="row">
                <div class="col-md-4">
                    <span>Nome: {{ $vestibulando->pessoa->nome  }}</span>
                </div>

                <div class="col-md-4">
                    <span>Número Inscrição: {{ $vestibulando->inscricao  }}</span>
                </div>
            </div>
        </div>
    </div>
</body>
</html>