<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title>Declaração de afastamento</title>
    <style type="text/css">
        body {
            font-size: 12px;
        }

        .cabecalho p {
            margin-top: 0;
        }

        #conteudo_cabecalho p {
            margin-top: 0;
            margin-bottom: 2%;
        }

        .conteudo h2 {
            font-size: 15px;
        }

        .conteudo > #conteudo_1 {
            margin-left: 10%;
        }

        .rodape {
            text-align: center;
        }

        .rodape hr {
            border-top: solid;
        }
    </style>

    <?php
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');
    ?>
</head>

<body>
    <div class="cabecalho">
        <table style="font-size: 15px;">
            <tr>
                <td>
                    <h1>
                        <img width="200" src="{{ asset('img/logo_alpha_tec.jpg') }}" alt="">
                    </h1>
                </td>

                <td>
                    <div id="conteudo_cabecalho">
                        <p style="margin-bottom: 0;">
                            ALPHA SISTEMAS EDUCACIONAL E TREINAMENTO LTDA. Portaria normativa de credenciamento SEE n. 10177
                            de 17 de novembro de 2017. Portaria de autorização dos cursos em: Técnico de Segurança do Trabalho,
                            Técnico em Administração e Técnico em Informática.
                        </p>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <h2 style="text-align: center">FORMULÁRIO DE PRÉ – MATRÍCULA</h2>

    <div class="conteudo">
        <div id="conteudo_1" style="margin-top: 80px">

            <p style="text-align: justify">
                NOME: _______________________________________________________________________________________________________________
            </p>

            <br />

            <p style="text-align: justify">
                ENDEREÇO: ___________________________________________________________________________________________________________
            </p>

            <br />

            <p style="text-align: justify">
                CURSO: ______________________________________________________ TURNO: ________________________________________________
            </p>

            <br />

            <p style="text-align: justify">
                FONE: (___) ______________________ E-MAIL: _____________________________________________________________________________
            </p>

            <br /> <br /> <br /> <br />

            <p style="text-align: justify">
                <b>Documentação exigida</b>
            </p>
            <p style="text-align: justify">
                Cópia da carteira de Identidade e CPF
            </p>
            <p style="text-align: justify">
                Comprovante de residência em nome do aluno ou responsável Identificado.
            </p>
            <p style="text-align: justify">
                Cópia Histórica Escolar e Certificado de Conclusão do Ensino Médio (Autenticadas).
            </p>
            <p style="text-align: justify">
                1 fotografia 3x4 com nome no verso.
            </p>

        </div>

    </div>

    <div class="rodape" style="margin-top: 52%;">
        <hr style="color: #bfbfbf">
        <hr>
        <p style="text-align: center">
            <span style="margin-bottom: 0;">Rua Gervásio Pires, 286, Santo Amaro, Recife –PE-CEP 50050-415</span><br>
            <span style="margin-top: 0;">CNPJ: 15708483/0001-50</span><br>
            <span>Fone: 81 – 3071-7249</span><br>
            <span> 	(81) 995162229</span>
        </p>
    </div>
</body>
</html>