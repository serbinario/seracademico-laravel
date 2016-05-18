<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
    <title>Biblioteca Faculdade</title>

    <!-- CSS  -->
    @section('css')
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="{{ asset('/portal/css/materialize.css')}}" type="text/css" rel="stylesheet"
          media="screen,projection"/>
    <!-- <link rel="stylesheet" type="text/css" href="css/bootstrap.css"> -->
    <link href="{{ asset('/portal/css/style.css')}}" type="text/css" rel="stylesheet" media="screen,projection"/>
    @show
</head>
<body>
<!-- Dropdown Structure -->
<ul id="dropdown1" class="dropdown-content">
    <li><a href="#!">Ajuda</a></li>
    <li><a href="#!">Perfil</a></li>
    <li class="divider"></li>
    <li><a href="#!">Sair</a></li>
</ul>
<nav>
    <div class="container">{{----}}
        <div class="nav-wrapper">
            <a href="#!" class="brand-logo">
                <img src="{{ asset('/portal/img/logo_alpha_faculdade-01.png')}}" style="width: 130px;margin-top: -20%;"> </a>
            <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons" style="color: #283277;">menu</i></a>
        </div>
    </div>
</nav>
<div class="parallax-container">
    @yield('banner')
</div>

<div class="section no-pad-bot" id="index-banner">
    <div class="container">
        @yield('container_index')
    </div>
</div>
<div class="container">
    <!-- Info Resalt-->
    <br/>
    <div class="row">
        @yield('container')
    </div>
</div>


<!-- End Info Resalt-->

<br><br>
<footer class="page-footer">
    <div class="container">
        <div class="row">
            <div class="col l6 s12">
                <a href="">
                    <img src="{{ asset('/portal/img/logo-alpha-b.png')}}"
                         style="width: 180px;position: relative;float: left;">
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
            <a class="grey-text text-lighten-4 right" href="#!"> <img src="{{ asset('/portal/img/s1-b.png')}}"
                                                                      style="width: 130px;position: relative;
    float: right;margin-top: 12px;"></a>
        </div>
    </div>
</footer>


<!--  Scripts-->
<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script src="{{ asset('/portal/js/materialize.js')}}"></script>
<script src="{{ asset('/portal/js/init.js')}}"></script>

<script>
    $(document).ready(function () {
        $('.parallax').parallax();
    });
    $(document).ready(function () {
        $('select').material_select();
    });
</script>
@yield('js')
</body>
</html>
