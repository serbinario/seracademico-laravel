@extends('portal.menuportal')

@section('css')
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="{{ asset('/biblioteca/css/materialize.css')}}" type="text/css" rel="stylesheet"
          media="screen,projection"/>
    <link href="{{ asset('/biblioteca/css/style.css')}}" type="text/css" rel="stylesheet" media="screen,projection"/>
@endsection

@section('banner')
    <div class="container">
        <h3 class="header white-text" style="margin-top: 5%;">Encontre títulos e autores</h3>
        <p class="white-text">Consulte nosso acervo e obtenha informações sobre milhares livros.</p>
    </div>
    <div class="parallax"><img src="{{ asset('/portal/img/biblioteca31.jpg')}}"></div>
@endsection

@section('container_index')
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
                        <div class="col s5 m2" >
                            <button type="submit" class="waves-effect waves-light btn" style="margin-top: 12px;"><i class="material-icons left">search</i> Buscar</button>
                        </div>
                        <div class="col s5 m2" style="margin-top: 3px;">
                            {{--{!! Form::select('tipo_obra', $loadFields['biblioteca\tipoacervo'], null,array('class' => 'form-control')) !!}--}}
                            <select name="tipo_obra" class="form-control">
                                <option value="1" selected>Livro</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('container')
    <br/>
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
@endsection
