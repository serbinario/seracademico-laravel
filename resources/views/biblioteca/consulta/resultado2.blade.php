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
    <li><a href="#!">Autoridades</a></li>
    <li><a href="#!">Minha Seleção</a></li>
    <li class="divider"></li>
    <li><a href="#!">Ajuda</a></li>
</ul>
<nav>
    <div class="container">{{----}}
        <div class="nav-wrapper">
            <a href="#!" class="brand-logo"> <img src="{{ asset('/biblioteca/img/logo_alpha_faculdade-01.png')}}" style="width: 130px;
    margin-top: -20%;"> </a>
            <ul class="right hide-on-med-and-down">
                <!-- Dropdown Trigger -->
                <li><a class="dropdown-button" href="#!" data-activates="dropdown1">Usuário<i
                                class="material-icons right">arrow_drop_down</i></a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="parallax-container">
    <div class="container" style="margin-top: -15px;">
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
                            <div class="input-field col s2">
                                <select name="busca_por" class="form-control">
                                    <option value="1" selected>Todos os campos</option>
                                    <option value="2">Título</option>
                                    <option value="3">Assunto</option>
                                    <option value="4">Autor</option>
                                </select>
                            </div>
                            <div class="input-field col s5">
                                <input id="icon_prefix" type="text" name="busca" class="validate">
                                <label for="icon_prefix">Busque</label>
                            </div>
                            <div class="col s2" >
                                <input type="submit" class="waves-effect waves-light btn" value="Buscar">
                            </div>
                            <div class="col s3" style="margin-top: 3px;">
                                {!! Form::select('tipo_obra', $loadFields['biblioteca\tipoacervo'], null,array('class' => 'form-control')) !!}
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>


<div class="container">
    <!-- Info Resalt-->
    <div class="row">
        <div class="col s12 m12">
            @foreach($resultado->items() as $f)
                <div class="collection">
                    <div class="col s2">
                        <div class="row">
                            <div class="col s12">
                                <div class="book-search">Livro</div>
                            </div>
                            <span class="ed-bdg">@if($f->edicao){{$f->edicao}} .ed @endif</span>

                        </div>
                    </div>
                    <div class="col s5">
                        <div class="row" style="margin-top: 10px;">
                            <div class="col s12">
                                <?php $data =  explode(" ", $f->subtitulo); $subtitulo = "";?>
                                <h5 style="font-size: 1.5rem;"><b>{{ $f->titulo }}</b><br />
                                    @if(count($data) <= 3)
                                        @foreach($data as $d)
                                            {!!   $d  !!}
                                        @endforeach
                                    @else
                                        {{$data[0]}} {{$data[1]}} {{$data[2]}}...
                                    @endif</h5>
                            </div>
                            <div class="col s12">{{$f->sobrenome}}, {{$f->nome}}</div>
                        </div>
                    </div>
                    <div class="col s4">
                        <br />
                        <div class="row">
                            <div class="col s12"><div class="chip">{{$f->assunto}}</div></div>
                        </div>
                        <div class="row">
                            <div class="col s6"><p><b>CDD</b><br/>{{ $f->cdd }}</p></div>
                            <div class="col s6"><p><b>CUTTER</b><br/>{{ $f->cutter }}</p></div>
                        </div>
                    </div>
                    <div class="col s1"><span class="badge mybdg" >@if($f->tipos_acervos_id == '1')
                                Livro
                            @elseif($f->tipos_acervos_id == '2')
                                Revista
                            @endif</span>
                        <a href="{{url("/seracademico/biblioteca/seachDetalhe/exemplar/$f->id")}}" class="btn-floating waves-effect waves-light tooltipped" style="top: 50px;"
                           data-position="bottom" data-delay="40" data-tooltip="Ver detalhes"><i class="material-icons">launch</i></a>
                    </div>
                </div>
            @endforeach
                <div class="row">
                    <div class="col s12 m12 center">
                        {!!  $resultado->render() !!}
                    </div>
                </div>
        </div>
    </div>
</div>


<!-- End Info Resalt-->

</div>
<br><br>
</div>
<footer class="page-footer indigo">
    <div class="footer-copyright">
        <div class="container">
            <p>SerBinário</p>
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
