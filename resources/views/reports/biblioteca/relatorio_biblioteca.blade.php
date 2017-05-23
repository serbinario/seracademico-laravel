<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title>Biblioteca</title>
    <style type="text/css">
        table tbody th, table tbody td {
            padding: 2px 2px;
            font-size: 12px;
        }

        table { page-break-inside:auto }
        tr { page-break-inside:avoid; page-break-after:auto }
        thead { display:table-header-group }
        tfoot { display:table-footer-group }
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
                <h1 style="text-align: center;color: #082652; ">EDITAR BIBLIOTECA - {{$ano}} </h1>
            </td>
            <td width="15%">
                <img alt="image" width="100%" src="{{ asset('/img/seracad.png')}}"/>
            </td>
        </tr>
    </table>
</div>
<hr>
<div class="row">

    <table width="100%" border="1" cellspacing="0" style="border: 1px solid lightgray;">
        <tbody>
            <tr><td style="background-color: #2F5286; color: white;">Silga Biblioteca</td></tr>
            <tr><td>BIBLIOTECA</td></tr>
        </tbody>
    </table><br />

    <table width="100%" border="1" cellspacing="0" style="border: 1px solid lightgray;">
        <tbody>
            <tr><td style="background-color: #2F5286; color: white;">Nome Biblioteca</td></tr>
            <tr><td>BIBLIOTECA ALPHA</td></tr>
        </tbody>
    </table><br />

    <table width="100%" border="1" cellspacing="0" style="border: 1px solid lightgray;">
        <tbody>
            <tr><td style="background-color: #2F5286; color: white;">Tipo de biblioteca</td></tr>
            <tr><td>Biblioteca Central</td></tr>
        </tbody>
    </table><br />

    <table width="100%" border="1" cellspacing="0" style="border: 1px solid lightgray;">
        <tbody>
        <tr><td style="background-color: #2F5286; color: white;">Número de assentos</td></tr>
        <tr><td>0</td></tr>
        </tbody>
    </table><br />

    <table width="100%" border="1" cellspacing="0" style="border: 1px solid lightgray;">
        <tbody>
        <tr><td style="background-color: #2F5286; color: white;">Número de empréstimos domiciliares</td></tr>
        <tr><td>{{$qtdEmprestimos->qtd}}</td></tr>
        </tbody>
    </table><br />

    <table width="100%" border="1" cellspacing="0" style="border: 1px solid lightgray;">
        <tbody>
        <tr><td style="background-color: #2F5286; color: white;">Número de empréstimos entre bibliotecas</td></tr>
        <tr><td>0</td></tr>
        </tbody>
    </table><br />

    <table width="100%" border="1" cellspacing="0" style="border: 1px solid lightgray;">
        <tbody>
        <tr><td style="background-color: #2F5286; color: white;">Realiza comutações bibliográfica?</td></tr>
        <tr><td>Não</td></tr>
        </tbody>
    </table><br />

    <table width="100%" border="1" cellspacing="0" style="border: 1px solid lightgray;">
        <tbody>
        <tr><td style="background-color: #2F5286; color: white;">Usuários treinados em programas de capacitação</td></tr>
        <tr><td></td></tr>
        </tbody>
    </table><br />

    <table width="100%" border="1" cellspacing="0" style="border: 1px solid lightgray;">
        <tbody>
        <tr><td style="background-color: #2F5286; color: white;">Possui rede sem fio?</td></tr>
        <tr><td>Sim</td></tr>
        </tbody>
    </table><br />

    <table width="100%" border="1" cellspacing="0" style="border: 1px solid lightgray;">
        <tbody>
        <tr><td style="background-color: #2F5286; color: white;">Número de Títulos de acervos de periódicos impressos</td></tr>
        <tr><td>{{$qtdLivrosPeriodicos->qtd}}</td></tr>
        </tbody>
    </table><br />

    <table width="100%" border="1" cellspacing="0" style="border: 1px solid lightgray;">
        <tbody>
        <tr><td style="background-color: #2F5286; color: white;">Número de Títulos do acervo de livros impressos</td></tr>
        <tr><td>{{$qtdLivrosNaoPeriodicos->qtd}}</td></tr>
        </tbody>
    </table><br />

    <table width="100%" border="1" cellspacing="0" style="border: 1px solid lightgray;">
        <tbody>
        <tr><td style="background-color: #2F5286; color: white;">Número de Títulos de outros materiais</td></tr>
        <tr><td></td></tr>
        </tbody>
    </table><br />

    <table width="100%" border="1" cellspacing="0" style="border: 1px solid lightgray;">
        <tbody>
        <tr><td style="background-color: #2F5286; color: white;">Oferece condições de acessibilidade</td></tr>
        <tr><td>Sim</td></tr>
        </tbody>
    </table><br />

    <table width="100%" border="1" cellspacing="0" style="border: 1px solid lightgray;">
        <tbody>
        <tr><td style="background-color: #2F5286; color: white;">Possui atendentes treinados na língua brasileira de sinais - Líbras</td></tr>
        <tr><td>Sim</td></tr>
        </tbody>
    </table><br />

    <h4>Acessibilidade Arquitetônica ou Física</h4>

    <table width="100%" border="1" cellspacing="0" style="border: 1px solid lightgray;">
        <tbody>
        <tr>
            <td style="background-color: #2F5286; color: white;">Banheiros adaptados</td>
            <td style="background-color: #2F5286; color: white;">Mobibliário adaptado</td>
        </tr>
        <tr>
            <td>Não</td>
            <td>Não</td>
        </tr>
        <tr>
            <td style="background-color: #2F5286; color: white;">Bebedouros e lavabos adaptados</td>
            <td style="background-color: #2F5286; color: white;">Rampa de acesso com carrimão</td>
        </tr>
        <tr>
            <td>Não</td>
            <td>Não</td>
        </tr>
        <tr>
            <td style="background-color: #2F5286; color: white;">Entrada/Sáida com dimensionamento</td>
            <td style="background-color: #2F5286; color: white;">Sinalização tátil</td>
        </tr>
        <tr>
            <td>Sim</td>
            <td>Não</td>
        </tr>
        <tr>
            <td style="background-color: #2F5286; color: white;">Equipamento eletrônico (elevadores, esteiras rolantes, entre outros)</td>
            <td style="background-color: #2F5286; color: white;">Sinalização visual</td>
        </tr>
        <tr>
            <td>Não</td>
            <td>Sim</td>
        </tr>
        <tr>
            <td style="background-color: #2F5286; color: white;">Espaço para atendimento adaptado</td>
            <td style="background-color: #2F5286; color: white;">Sinalização sonora</td>
        </tr>
        <tr>
            <td>Não</td>
            <td>Não</td>
        </tr>
        <tr>
            <td colspan="2" style="background-color: #2F5286; color: white;">
                Ambientes desobstruídos que facilitam a movimentação de cadeirantes e pessoas com deficiência visual
            </td>
        </tr>
        <tr>
            <td colspan="2">Sim</td>
        </tr>
        </tbody>
    </table><br />

    <h4>Acessibilidade de Conteúdo</h4>

    <table width="100%" border="1" cellspacing="0" style="border: 1px solid lightgray;">
        <tbody>
        <tr>
            <td style="background-color: #2F5286; color: white;">
                Plano de aquisição gradual de acervo bibliográfico dos conteúdos básicos em formato especial
            </td>
        </tr>
        <tr>
            <td>Não</td>
        </tr>
        <tr>
            <td style="background-color: #2F5286; color: white;">
                Possui acervo em formato especial (Brasile/Sonoro)
            </td>
        </tr>
        <tr>
            <td>Não</td>
        </tr>
        <tr>
            <td style="background-color: #2F5286; color: white;">
                Sítios desenvolvidos para que pessoas percebem, compreendam, naveguem e utilizem os serviços oferecidos
            </td>
        </tr>
        <tr>
            <td>Não</td>
        </tr>
        </tbody>
    </table><br />

</div>
</body>
</html>