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
        <br>
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
                                <button type="submit" class="waves-effect waves-light btn" style="margin-top: 12px;"><i class="material-icons left">search</i> Buscar</button>
                            </div>
                            <div class="col s3" style="margin-top: 3px;">
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
    <div class="row">
        <div class="col s12 m12">
            <div class="row section">
                <div class="col s12 m9">
                    <section class="">
                        <div class="row">
                            <div class="col s12">
                                <ul class="tabs">
                                    <li class="tab col s3"><a class="active" href="#test1">Detalhes</a></li>
                                    <li class="tab col s3"><a href="#test2">Exemplares</a></li>
                                    <li class="tab col s3"><a href="#test4">Referência</a></li>
                                </ul>
                            </div>
                            <div id="test1" class="col s12">
                                <br>
                                <div class="collection">
                                    <a class="collection-item">
                                        <div class="row">
                                            <div class="col s4"><b>Inf. publicação</b></div>
                                            <div class="col s8">{{$exemplar['acervo']['tipoAcervo']['nome']}} - {{$exemplar['idioma']['nome']}}</div>
                                        </div>
                                    </a>
                                    <a class="collection-item">
                                        <div class="row">
                                            <div class="col s4"><b>ISBN</b></div>
                                            <div class="col s8">{{$exemplar['isbn']}}</div>
                                        </div>
                                    </a>
                                    <a class="collection-item">
                                        <div class="row">
                                            <div class="col s4"><b>Classificação Dewey</b></div>
                                            <div class="col s8">{{$exemplar['acervo']['cdd']}}</div>
                                        </div>
                                    </a>
                                    <a class="collection-item">
                                        <div class="row">
                                            <div class="col s4"><b>Cutter</b></div>
                                            <div class="col s8">{{$exemplar['acervo']['cutter']}}</div>
                                        </div>
                                    </a>
                                    <a class="collection-item">
                                        <div class="row">
                                            <div class="col s4"><b>Número de chamada</b></div>
                                            <div class="col s8">{{$exemplar['acervo']['numero_chamada']}}</div>
                                        </div>
                                    </a>
                                    <a class="collection-item">
                                        <div class="row">
                                            <div class="col s4"><b>Edição</b></div>
                                            <div class="col s8">@if($exemplar['edicao']){{$exemplar['edicao']}}. ed. @endif</div>
                                        </div>
                                    </a>
                                    <a class="collection-item active">
                                        <div class="row">
                                            <div class="col s4"><b>Título</b></div>
                                            <div class="col s8"><b>{{$exemplar['acervo']['titulo']}}: {{$exemplar['acervo']['subtitulo']}}</b></div>
                                        </div>
                                    </a>
                                    <a class="collection-item">
                                        <div class="row">
                                            <div class="col s4"><b>Ent. princ.</b></div>
                                            <div class="col s8">@if(count($exemplar['acervo']['primeiraEntrada']) > 0)
                                                    @if($exemplar['acervo']['etial_autor'] == '1')
                                                        {{$exemplar['acervo']['primeiraEntrada'][0]['responsaveis']['sobrenome']}},
                                                        <?php echo ucfirst(mb_strtolower($exemplar['acervo']['primeiraEntrada'][0]['responsaveis']['nome'])) ?> et al
                                                    @else
                                                        @foreach($exemplar['acervo']['primeiraEntrada'] as $chave => $autor)
                                                            <b>{{$chave + 1}}</b>. {{$autor['responsaveis']['sobrenome']}}, <?php echo ucfirst(mb_strtolower($autor['responsaveis']['nome'])) ?><br />
                                                        @endforeach
                                                    @endif
                                                @endif</div>
                                        </div>
                                    </a>
                                    <a class="collection-item">
                                        <div class="row">
                                            <div class="col s4"><b>Imprenta</b></div>
                                            <div class="col s8"><?php echo ucwords(mb_strtolower($exemplar['local'])) ?> @if($exemplar['ano']), {{$exemplar['ano']}}.@endif</div>
                                        </div>
                                    </a>
                                    <a class="collection-item">
                                        <div class="row">
                                            <div class="col s4"><b>Desc. física</b></div>
                                            <div class="col s8">{{$exemplar['numero_pag']}}p. @if($exemplar['ilustracoes_id'] == '1') : il.@endif</div>
                                        </div>
                                    </a>
                                    <a class="collection-item">
                                        <div class="row">
                                            <div class="col s4"><b>Notas</b></div>
                                            <div class="col s8">{{$exemplar['acervo']['resumo']}}</div>
                                        </div>
                                    </a>
                                    <a class="collection-item">
                                        <div class="row">
                                            <div class="col s4"><b>Assunto</b></div>
                                            <div class="col s8">{{$exemplar['acervo']['assunto']}}</div>
                                        </div>
                                    </a>
                                    <a class="collection-item">
                                        <div class="row">
                                            <div class="col s4"><b>Ent. sec.</b></div>
                                            <div class="col s8">@if(count($exemplar['acervo']['segundaEntrada']) > 0)
                                                    @if($exemplar['acervo']['etial_outros'] == '1')
                                                        <b>1</b>. {{$exemplar['acervo']['segundaEntrada'][0]['responsaveis']['sobrenome']}}, <?php echo ucfirst(mb_strtolower($exemplar['acervo']['segundaEntrada'][0]['responsaveis']['nome'])) ?> et al
                                                    @else
                                                        @foreach($exemplar['acervo']['segundaEntrada'] as $chave => $autor)
                                                            <b>{{$chave + 1}}</b>. {{$autor['responsaveis']['sobrenome']}}, <?php echo ucfirst(mb_strtolower($autor['responsaveis']['nome'])) ?><br />
                                                        @endforeach
                                                    @endif
                                                @endif</div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div id="test2" class="col s12">
                                <br>
                                @if(count($exemplares) > 0)
                                    <table class="table striped responsive-table">
                                        <thead>
                                        <tr>
                                            <th>Tombo</th>
                                            <th>Edição</th>
                                            <th>Ano</th>
                                            <th>Volume</th>
                                            <th>CDD</th>
                                            <th>Cutter</th>
                                            <th>Nº de chamada</th>
                                            <th>Situação</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($exemplares as $e)
                                            <tr>
                                                <td>
                                                    <?php
                                                    $codigo = str_pad(substr($e->codigo, 0, -4),4,"0",STR_PAD_LEFT);
                                                    $ano    = substr($e->codigo, -4);
                                                    $tombo  = $codigo.'/'.$ano;
                                                    ?>
                                                    {{$tombo}}
                                                </td>
                                                <td>@if($e->edicao){{$e->edicao}}. ed. @endif</td>
                                                <td>@if($e->ano){{$e->ano}} @endif</td>
                                                <td>{{$e->volume}}</td>
                                                <td>{{$e->cdd}}</td>
                                                <td>{{$e->cutter}}</td>
                                                <td>{{$e->numero_chamada}}</td>
                                                <td>{{$e->nome}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                            <div id="test4" class="col s12" style="font-size: 15px;">
                                <br>
                                <?php $count = 0; ?>
                                @if(count($exemplar['acervo']['primeiraEntrada']) > 0)
                                    @if($exemplar['acervo']['etial_autor'] == '1')
                                        <span style="text-transform: uppercase">{{$exemplar['acervo']['primeiraEntrada'][0]['responsaveis']['sobrenome']}}</span>,
                                        <?php echo ucwords(mb_strtolower($exemplar['acervo']['primeiraEntrada'][0]['responsaveis']['nome'])) ?> et al.
                                    @else
                                        @foreach($exemplar['acervo']['primeiraEntrada'] as $chave => $autor)
                                            <?php $count++ ?>
                                            <span style="text-transform: uppercase">{{$autor['responsaveis']['sobrenome']}}</span>, <?php echo ucwords(mb_strtolower($autor['responsaveis']['nome'])); ?>@if(count($exemplar['acervo']['primeiraEntrada']) == $count ). @else;@endif
                                        @endforeach
                                    @endif
                                @endif
                                <b><?php echo ucfirst(mb_strtolower($exemplar['acervo']['titulo'])) ?></b>@if($exemplar['acervo']['subtitulo'])<?php echo ': '. mb_strtolower($exemplar['acervo']['subtitulo']) ?>.@else.@endif
                                @if($exemplar['edicao']){{$exemplar['edicao']}}. ed. @endif @if($exemplar['local'])<?php echo ucwords(mb_strtolower($exemplar['local'])) ?>: @endif @if($exemplar['editora']['nome'])<?php echo ucfirst(mb_strtolower($exemplar['editora']['nome'])) ?>, @endif @if($exemplar['ano']){{$exemplar['ano']}}. @endif @if($exemplar['numero_pag']){{$exemplar['numero_pag']}}p., @endif @if($exemplar['ilustracoes_id'] && $exemplar['ilustracoes_id'] == '1')il., @endif @if($exemplar['isbn'])ISBN {{$exemplar['isbn']}}. @endif
                            </div>
                        </div>
                    </section>
                </div>
                <div class="col s12 m3">
                    <section class="arg-list">
                        <div class="col s12">
                            <div class="card" style="margin-top: 0px;">
                                <div class="card-image waves-effect waves-block waves-light" >
                                    <div class="book-search">
                                        <img src="{{ asset('/biblioteca/img/capa_livro3.jpg')}}" style="min-height: 0;width: 130px;max-width: 130px;max-height: 165px;">
                                    </div>
                                    {{-- <img class="activator" src="{{ asset('/biblioteca/img/Capa-Livro-Propague-2.jpg')}}">--}}
                                </div>
                            </div>
                            <br/>
                            <button class="btn waves-effect waves-light"><i class="material-icons left">arrow_back</i>Voltar</button>
                    </section>
                </div>
            </div>
        </div>
    </div>
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
