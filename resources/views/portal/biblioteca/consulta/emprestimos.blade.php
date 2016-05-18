<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
    <title>Biblioteca Faculdade</title>

    <!-- CSS  -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="{{ asset('/biblioteca/css/materialize.css')}}" type="text/css" rel="stylesheet"
          media="screen,projection"/>
    <!-- <link rel="stylesheet" type="text/css" href="css/bootstrap.css"> -->
    <link href="{{ asset('/biblioteca/css/style.css')}}" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>
<body>
<!-- Dropdown Structure -->
<ul id="dropdown1" class="dropdown-content">
    <li><a href="#!">Ajuda</a></li>
    <li><a href="#!">Sobre</a></li>
    <li class="divider"></li>
    <li><a href="#!">Sair</a></li>
</ul>
<nav>
    <div class="container">{{----}}
        <div class="nav-wrapper">
            <a href="#!" class="brand-logo"> <img src="{{ asset('/biblioteca/img/logo_alpha_faculdade-01.png')}}" style="width: 130px;
    margin-top: -20%;"> </a>
            <ul class="right hide-on-med-and-down">
                <!-- Dropdown Trigger -->
                <li><a class="dropdown-button" href="#!" data-activates="dropdown1"><i class="material-icons left">account_circle</i>Usuário<i
                                class="material-icons right">arrow_drop_down</i></a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="parallax-container">
    <div class="container">
        <h3 class="header white-text" style="margin-top: 5%;">Meus Emprestimos</h3>
        <p class="white-text">Consulte nosso acervo e obtenha informações sobre milhares livros.</p>
    </div>
    <div class="parallax"><img src="{{ asset('/biblioteca/img/biblioteca31.jpg')}}"></div>
</div>

<div class="section no-pad-bot" id="index-banner">
    <div class="container">
        <div class="row">
            <div class="card col s12">
                <div class="card-content">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Título do livro</th>
                                <th>Data de saída</th>
                                <th>Data de devolução</th>
                                <th>Status</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="container">
    <!-- Info Resalt-->

</div>
<br><br>
</div>
<footer class="page-footer">
    <div class="container">
        <div class="row">
            <div class="col l6 s12">
                <a href="">
                    <img src="{{ asset('/biblioteca/img/logo-alpha-b.png')}}" style="width: 180px;position: relative;float: left;">
                </a>

            </div>
            <div class="col l4 offset-l2 s12">
                <h5 class="white-text"><b>Alpha Faculdade</b></h5>
                <p class="grey-text text-lighten-4">Biblioteca Institucional</p>
                <ul>
                    <li><a class="grey-text text-lighten-3" href="#!">Sobre</a></li>
                    <li><a class="grey-text text-lighten-3" href="#!">Ajuda</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="footer-copyright">
        <div class="container">
            © 2016 Desenvolvimento por: SerBinário
            <a class="grey-text text-lighten-4 right" href="#!"> <img src="{{ asset('/biblioteca/img/s1-b.png')}}" style="width: 130px;position: relative;
    float: right;margin-top: 12px;"></a>
        </div>
    </div>
</footer>


<!--  Scripts-->
<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script src="{{ asset('/biblioteca/js/materialize.js')}}"></script>
<script src="{{ asset('/biblioteca/js/init.js')}}"></script>

<script>
    $(document).ready(function () {
        $('.parallax').parallax();
    });
    $(document).ready(function () {
        $('select').material_select();
    });
</script>


</body>
</html>
