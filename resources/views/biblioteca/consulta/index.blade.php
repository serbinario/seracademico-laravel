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
        <h3 class="header white-text" style="margin-top: 5%;">Encontre títulos e autores</h3>
        <p class="white-text">Consulte nosso acervo e obtenha informações sobre milhares livros.</p>
    </div>
    <div class="parallax"><img src="{{ asset('/biblioteca/img/biblioteca31.jpg')}}"></div>
</div>

<div class="section no-pad-bot" id="index-banner">
    <div class="container">
        <div class="row">
            <div class="card col s12">
                <div class="card-content">
                    <form action="{{url('seracademico/biblioteca/seachSimple')}}" class="form-horizontal" method="post">
                        <div class="row">
                            <span class="card-title col s12">Busca rápida</span>
                            {{--<div class="input-field col s2">
                                {!! Form::select('tipo_obra', $loadFields['biblioteca\tipoacervo'], null,array('class' => 'form-control')) !!}
                            </div>--}}
                        </div>
                        <hr class="hr-dashline">
                        <div class="row">
                            <div class="input-field col s5 m3">
                                <select name="busca_por" class="form-control">
                                    <option value="1" selected>Todos os campos</option>
                                    <option value="2">Título</option>
                                    <option value="3">Assunto</option>
                                    <option value="4">Autor</option>
                                </select>
                            </div>
                            <div class="input-field col s7 m5">
                                <input id="icon_prefix" type="text" name="busca" class="validate">
                                <label for="icon_prefix">Busque</label>
                            </div>
                            <div class="col s5 m2 >
                                <button type="submit" class="waves-effect waves-light btn" style="margin-top: 12px;"><i class="material-icons left">search</i> Buscar</button>
                            </div>
                            <div class="col s5 m2" style="margin-top: 3px;">
                                {{--{!! Form::select('tipo_obra', $loadFields['biblioteca\tipoacervo'], null,array('class' => 'form-control')) !!}--}}
                                <select name="tipo_obra" class="form-control">
                                    <option value="1" selected>Livro</option>
                                </select>
                            </div>
                        </div>

                        {{--<div class="row">
                            <ul class="collapsible col s12" data-collapsible="accordion">
                                <li>
                                    <div class="collapsible-header">Busca avançada</div>
                                    <div class="collapsible-body">

                                        <div class="col s11">
                                            <br>
                                            <div class="row">
                                                <div class="input-field col s3">
                                                    <select>
                                                        <option value="" disabled selected>Todos os Campos</option>
                                                        <option value="1">Título</option>
                                                        <option value="2">Autor</option>
                                                        <option value="3">Assunto</option>
                                                    </select>
                                                </div>
                                                <div class="input-field col s4">
                                                    <input id="icon_prefix" type="text" class="validate">
                                                    <label for="icon_prefix">Busque</label>
                                                </div>
                                                <div class="input-field col s1">
                                                    <select>
                                                        <option value="" disabled selected>E</option>
                                                        <option value="1">E</option>
                                                        <option value="2">OU</option>
                                                        <option value="3">E NÃO</option>
                                                    </select>
                                                </div>
                                                <div class="input-field col s2">
                                                    <input id="icon_prefix" type="text" class="validate">
                                                    <label for="icon_prefix">Ano Edição (DE)</label>
                                                </div>
                                                <div class="input-field col s2">
                                                    <input id="icon_prefix" type="text" class="validate">
                                                    <label for="icon_prefix">Ano Edição (ATÉ)</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="input-field col s3">
                                                    <select>
                                                        <option value="" disabled selected>Todos os Campos</option>
                                                        <option value="1">Título</option>
                                                        <option value="2">Autor</option>
                                                        <option value="3">Assunto</option>
                                                    </select>
                                                </div>
                                                <div class="input-field col s4">
                                                    <input id="icon_prefix" type="text" class="validate">
                                                    <label for="icon_prefix">Busque</label>
                                                </div>
                                                <div class="input-field col s1">
                                                    <select>
                                                        <option value="" disabled selected>E</option>
                                                        <option value="1">E</option>
                                                        <option value="2">OU</option>
                                                        <option value="3">E NÃO</option>
                                                    </select>
                                                </div>
                                                <div class="input-field col s4">
                                                    <select multiple>
                                                        <option value="" disabled selected>Material</option>
                                                        <option value="1">Cartografia</option>
                                                        <option value="2">Iconografia</option>
                                                        <option value="3">Música</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="input-field col s3">
                                                    <select>
                                                        <option value="" disabled selected>Autor</option>
                                                        <option value="1">Título</option>
                                                        <option value="2">Todos os Campos</option>
                                                        <option value="3">Assunto</option>
                                                    </select>
                                                </div>
                                                <div class="input-field col s4">
                                                    <input id="icon_prefix" type="text" class="validate">
                                                    <label for="icon_prefix">Busque</label>
                                                </div>
                                                <div class="input-field col s1">
                                                    <select>
                                                        <option value="" disabled selected>E</option>
                                                        <option value="1">E</option>
                                                        <option value="2">OU</option>
                                                        <option value="3">E NÃO</option>
                                                    </select>
                                                </div>
                                                <div class="input-field col s4">
                                                    <select multiple>
                                                        <option value="" disabled selected>Idioma</option>
                                                        <option value="1">Ingles</option>
                                                        <option value="2">Frances</option>
                                                        <option value="3">Espanhol</option>
                                                    </select>
                                                </div>

                                                <div class="input-field col s3">
                                                    <select>
                                                        <option value="" disabled selected>Assunto</option>
                                                        <option value="1">Todos os campos</option>
                                                        <option value="2">Autor</option>
                                                        <option value="3">Assunto</option>
                                                    </select>
                                                </div>
                                                <div class="input-field col s4">
                                                    <input id="icon_prefix" type="text" class="validate">
                                                    <label for="icon_prefix">Busque</label>
                                                </div>
                                                <div class="input-field col s4">
                                                    <select multiple>
                                                        <option value="" disabled selected>Ordenação</option>
                                                        <option value="1">Cartografia</option>
                                                        <option value="2">Iconografia</option>
                                                        <option value="3">Música</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col s1">
                                            <div class="row" style="margin-top: 25px;">
                                                <a class="btn-floating waves-effect waves-light"><i class="material-icons">search</i></a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>--}}
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>


<div class="container">
    <!-- Info Resalt-->
    {{--<h5>Últimos livros adicionados</h5>
    <hr>
   <div class="row">
        <div class="col s12 m3">
            <div class="card">
                <div class="card-image waves-effect waves-block waves-light">
                    <img class="activator" src="{{ asset('/biblioteca/img/capa_livro3.jpg')}}">
                </div>
                <div class="card-content">
                    <span class="card-title activator grey-text text-darken-4"><p style="font-size: 12px;"><b>SOCIOLOGIA GERAL: ANTROPOLOGIA</b></p></span>
                </div>
                <div class="card-reveal">
                    <span class="card-title grey-text text-darken-4">Detalhes<i
                                class="material-icons right">close</i></span>
                    <p>Here is some more information about this product that is only revealed once clicked on.</p>
                </div>
            </div>
        </div>
        <div class="col s12 m3">
            <div class="card">
                <div class="card-image waves-effect waves-block waves-light">
                    <img class="activator" src="img/2204_Biblioteca_.jpg">
                </div>
                <div class="card-content">
                    <span class="card-title activator grey-text text-darken-4">Livro 2<i class="material-icons right">more_vert</i></span>
                    <p><a href="#">This is a link</a></p>
                </div>
                <div class="card-reveal">
                    <span class="card-title grey-text text-darken-4">Detalhes<i
                                class="material-icons right">close</i></span>
                    <p>Here is some more information about this product that is only revealed once clicked on.</p>
                </div>
            </div>
        </div>
        <div class="col s12 m3">
            <div class="card">
                <div class="card-image waves-effect waves-block waves-light">
                    <img class="activator" src="img/2204_Biblioteca_.jpg">
                </div>
                <div class="card-content">
                    <span class="card-title activator grey-text text-darken-4">Livro 3<i class="material-icons right">more_vert</i></span>
                    <p><a href="#">This is a link</a></p>
                </div>
                <div class="card-reveal">
                    <span class="card-title grey-text text-darken-4">Detalhes<i
                                class="material-icons right">close</i></span>
                    <p>Here is some more information about this product that is only revealed once clicked on.</p>
                </div>
            </div>
        </div>
        <div class="col s12 m3">
            <div class="card">
                <div class="card-image waves-effect waves-block waves-light">
                    <img class="activator" src="img/2204_Biblioteca_.jpg">
                </div>
                <div class="card-content">
                    <span class="card-title activator grey-text text-darken-4">Livro 4<i class="material-icons right">more_vert</i></span>
                    <p><a href="#">This is a link</a></p>
                </div>
                <div class="card-reveal">
                    <span class="card-title grey-text text-darken-4">Detalhes<i
                                class="material-icons right">close</i></span>
                    <p>Here is some more information about this product that is only revealed once clicked on.</p>
                </div>
            </div>
        </div>
    </div>
<br />
    <br />--}}
    <!-- End Info Resalt-->

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
