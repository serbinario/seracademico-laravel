@extends('portal.menuportal2')

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
                <form action="{{url('seachSimple')}}" class="form-horizontal" method="get">
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
                                <option value="5">Palavra chave</option>
                                <option value="6">Sumário</option>
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
                                <option value="1">Livro</option>
                                <option value="2">Revista</option>
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
                    <section>
                        <div class="row">
                            <div class="col s12">
                                <ul class="tabs">
                                    <li class="tab col s3"><a class="active" href="#test1">Detalhes</a></li>
                                    <li class="tab col s3"><a href="#test2">Exemplares</a></li>
                                    <li class="tab col s3"><a href="#test4">Referência</a></li>
                                    @if($exemplar['acervo']['tipo_periodico'] == '1')
                                        <li class="tab col s3"><a href="#test5">Sumário/Palavras chaves</a></li>
                                    @endif
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
                                    @if($exemplar['acervo']['tipo_periodico'] == '1')
                                        <a class="collection-item">
                                            <div class="row">
                                                <div class="col s4"><b>ISBN</b></div>
                                                <div class="col s8">{{$exemplar['isbn']}}</div>
                                            </div>
                                        </a>
                                    @else
                                        <a class="collection-item">
                                            <div class="row">
                                                <div class="col s4"><b>ISSN</b></div>
                                                <div class="col s8">{{$exemplar['issn']}}</div>
                                            </div>
                                        </a>
                                    @endif
                                    <a class="collection-item">
                                        <div class="row">
                                            <div class="col s4"><b>Classificação Dewey</b></div>
                                            <div class="col s8">{{$exemplar['acervo']['cdd']}}</div>
                                        </div>
                                    </a>
                                    @if($exemplar['acervo']['tipo_periodico'] == '1')
                                        <a class="collection-item">
                                            <div class="row">
                                                <div class="col s4"><b>Cutter</b></div>
                                                <div class="col s8">{{$exemplar['acervo']['cutter']}}</div>
                                            </div>
                                        </a>
                                    @endif
                                    {{--<a class="collection-item">
                                        <div class="row">
                                            <div class="col s4"><b>Número de chamada</b></div>
                                            <div class="col s8">{{$exemplar['acervo']['numero_chamada']}}</div>
                                        </div>
                                    </a>--}}
                                    @if($exemplar['acervo']['tipo_periodico'] == '1')
                                        <a class="collection-item">
                                            <div class="row">
                                                <div class="col s4"><b>Edição</b></div>
                                                <div class="col s8">{{$exemplar['acervo']['numero_chamada']}} / @if($exemplar['edicao']){{$exemplar['edicao']}}. ed. @endif</div>
                                            </div>
                                        </a>
                                        <a class="collection-item">
                                            <div class="row">
                                                <div class="col s4"><b>Coleção/Série</b></div>
                                                <div class="col s8">
                                                    @if($exemplar['acervo']['colecao_id'] && !$exemplar['acervo']['serie_id'])
                                                        ({{ $exemplar['acervo']['colecao']['nome'] }})
                                                    @elseif($exemplar['acervo']['serie_id'] && !$exemplar['acervo']['colecao_id'])
                                                        ({{ $exemplar['acervo']['serie']['nome'] }})
                                                    @elseif($exemplar['acervo']['serie_id'] && $exemplar['acervo']['colecao_id'])
                                                        ({{ $exemplar['acervo']['serie']['nome'] }}) ({{ $exemplar['acervo']['colecao']['nome'] }}) @endif
                                                </div>
                                            </div>
                                        </a>
                                    @else
                                        <a class="collection-item">
                                            <div class="row">
                                                <div class="col s4"><b>Edição</b></div>
                                                <div class="col s8">
                                                    {{$exemplar['acervo']['numero_chamada']}} /
                                                    @if($exemplar['vol_periodico'])v. {{$exemplar['vol_periodico']}}. @endif
                                                    @if($exemplar['num_periodico'])n. {{$exemplar['num_periodico']}}. @endif
                                                    @if($exemplar['ano']){{$exemplar['ano']}}. @endif
                                                </div>
                                            </div>
                                        </a>
                                    @endif
                                    @if($exemplar['acervo']['tipo_periodico'] == '2')
                                        <?php
                                        $data = \DateTime::createFromFormat('Y-m-d', $exemplar['acervo']['data_vencimento']);
                                        $dataFromat = $data->format('d/m/Y');
                                        ?>
                                        <a class="collection-item">
                                            <div class="row">
                                                <div class="col s4"><b>Periodicidade</b></div>
                                                <div class="col s8">{{$exemplar['acervo']['periodicidade']}} - Vencimento ({{$dataFromat}})</div>
                                            </div>
                                        </a>
                                    @endif
                                    <a class="collection-item active">
                                        <div class="row">
                                            <div class="col s4"><b>Título</b></div>
                                            @if($exemplar['acervo']['tipo_periodico'] == '1')
                                                <div class="col s8"><b>{{$exemplar['acervo']['titulo']}}: {{$exemplar['acervo']['subtitulo']}} </b></div>
                                            @elseif($exemplar['acervo']['tipo_periodico'] == '2')
                                                <div class="col s8"><b>{{$exemplar['acervo']['titulo']}}@if($exemplar['acervo']['subtitulo']): {{$exemplar['acervo']['subtitulo']}} @endif</b></div>
                                            @endif
                                        </div>
                                    </a>
                                    @if($exemplar['acervo']['tipo_periodico'] == '1')
                                        <a class="collection-item">
                                            <div class="row">
                                                <div class="col s4"><b>Ent. princ.</b></div>
                                                <div class="col s8">
                                                    @if(count($exemplar['acervo']['primeiraEntrada']) > 0)
                                                        @if($exemplar['acervo']['etial_autor'] == '1')
                                                            @if($exemplar['acervo']['primeiraEntrada'][0]['responsaveis']['tipo_reponsavel_id'] == '1' || $exemplar['acervo']['primeiraEntrada'][0]['responsaveis']['tipo_reponsavel_id'] == "")
                                                                <b>1</b>. {{$exemplar['acervo']['primeiraEntrada'][0]['responsaveis']['sobrenome']}},
                                                                <?php echo ucwords(mb_strtolower($exemplar['acervo']['primeiraEntrada'][0]['responsaveis']['nome'])) ?> et al
                                                            @else
                                                                <?php echo $exemplar['acervo']['primeiraEntrada'][0]['responsaveis']['nome'] ?> et al
                                                            @endif
                                                        @else
                                                            @foreach($exemplar['acervo']['primeiraEntrada'] as $chave => $autor)
                                                                @if($autor['responsaveis']['tipo_reponsavel_id'] == '1' || $autor['responsaveis']['tipo_reponsavel_id'] == "")
                                                                    <b>{{$chave + 1}}</b>. {{$autor['responsaveis']['sobrenome']}},
                                                                    <?php echo ucwords(mb_strtolower($autor['responsaveis']['nome'])) ?><br />
                                                                @else
                                                                    <b>{{$chave + 1}}</b>.
                                                                    <?php echo  $autor['responsaveis']['nome'] ?><br />
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </a>
                                    @else
                                        <a class="collection-item">
                                            <div class="row">
                                                <div class="col s4"><b>Artigos</b></div>
                                                <div class="col s8">
                                                    <?php
                                                        $array = explode(';', $exemplar['artigos']);
                                                        $count = 0;
                                                    ?>
                                                    @foreach($array as $artigo)
                                                            <?php $count++ ?>
                                                        {{$artigo}} @if($count >= count($array)) @else <br /> @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </a>
                                    @endif
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
                                    @if($exemplar['acervo']['tipo_periodico'] == '1')
                                        <a class="collection-item">
                                            <div class="row">
                                                <div class="col s4"><b>Notas</b></div>
                                                <div class="col s8">{{$exemplar['acervo']['resumo']}}</div>
                                            </div>
                                        </a>
                                    @else
                                        <a class="collection-item">
                                            <div class="row">
                                                <div class="col s4"><b>Link</b></div>
                                                <div class="col s8">{{$exemplar['link']}}</div>
                                            </div>
                                        </a>
                                    @endif
                                    @if($exemplar['acervo']['tipo_periodico'] == '1')
                                        <a class="collection-item">
                                            <div class="row">
                                                <div class="col s4"><b>Assunto</b></div>
                                                <div class="col s8">{{$exemplar['acervo']['assunto']}}</div>
                                            </div>
                                        </a>
                                    @else
                                        <a class="collection-item">
                                            <div class="row">
                                                <div class="col s4"><b>Assunto</b></div>
                                                <div class="col s8">{{$exemplar['assunto_p']}}</div>
                                            </div>
                                        </a>
                                    @endif
                                    @if($exemplar['acervo']['tipo_periodico'] == '1')
                                        <a class="collection-item">
                                            <div class="row">
                                                <div class="col s4"><b>Ent. sec.</b></div>
                                                <div class="col s8">@if(count($exemplar['acervo']['segundaEntrada']) > 0)
                                                        @if($exemplar['acervo']['etial_outros'] == '1')
                                                            @if($exemplar['acervo']['segundaEntrada'][0]['responsaveis']['tipo_reponsavel_id'] == '1' || $exemplar['acervo']['segundaEntrada'][0]['responsaveis']['tipo_reponsavel_id'] == "")
                                                                <b>1</b>. {{$exemplar['acervo']['segundaEntrada'][0]['responsaveis']['sobrenome']}},
                                                                <?php /*echo ucwords(mb_strtolower($exemplar['acervo']['segundaEntrada'][0]['responsaveis']['nome'])) */?>
                                                                <?php echo $exemplar['acervo']['segundaEntrada'][0]['responsaveis']['nome'] ?>
                                                                <?php if($exemplar['acervo']['segundaEntrada'][0]['tipo_autor_id'] == 1) {echo ' (Org.) ';} ?>
                                                                <?php if($exemplar['acervo']['segundaEntrada'][0]['tipo_autor_id'] == 2) {echo ' (Coord.) ';} ?>
                                                                <?php if($exemplar['acervo']['segundaEntrada'][0]['tipo_autor_id'] == 3) {echo ' (Trad.) ';} ?>
                                                                <?php if($exemplar['acervo']['segundaEntrada'][0]['tipo_autor_id'] == 4) {echo ' (Edit.) ';} ?>
                                                                <?php if($exemplar['acervo']['segundaEntrada'][0]['tipo_autor_id'] == 5) {echo ' (Colab.) ';} ?>et al
                                                            @else
                                                                <?php echo $exemplar['acervo']['segundaEntrada'][0]['responsaveis']['nome'] ?>
                                                                <?php if($exemplar['acervo']['segundaEntrada'][0]['tipo_autor_id'] == 1) {echo ' (Org.) ';} ?>
                                                                <?php if($exemplar['acervo']['segundaEntrada'][0]['tipo_autor_id'] == 2) {echo ' (Coord.) ';} ?>
                                                                <?php if($exemplar['acervo']['segundaEntrada'][0]['tipo_autor_id'] == 3) {echo ' (Trad.) ';} ?>
                                                                <?php if($exemplar['acervo']['segundaEntrada'][0]['tipo_autor_id'] == 4) {echo ' (Edit.) ';} ?>
                                                                <?php if($exemplar['acervo']['segundaEntrada'][0]['tipo_autor_id'] == 5) {echo ' (Colab.) ';} ?>et al
                                                            @endif
                                                        @else
                                                            @foreach($exemplar['acervo']['segundaEntrada'] as $chave => $autor)
                                                                @if($autor['responsaveis']['tipo_reponsavel_id'] == '1' || $autor['responsaveis']['tipo_reponsavel_id'] == "")
                                                                    <b>{{$chave + 1}}</b>. {{$autor['responsaveis']['sobrenome']}},
                                                                    <?php /*echo ucwords(mb_strtolower($autor['responsaveis']['nome'])) */?>
                                                                    <?php echo $autor['responsaveis']['nome'] ?>
                                                                    <?php if($autor['tipo_autor_id'] == 1) {echo ' (Org.)';} ?>
                                                                    <?php if($autor['tipo_autor_id'] == 2) {echo ' (Coord.)';} ?>
                                                                    <?php if($autor['tipo_autor_id'] == 3) {echo ' (Trad.)';} ?>
                                                                    <?php if($autor['tipo_autor_id'] == 4) {echo ' (Edit.)';} ?>
                                                                    <?php if($autor['tipo_autor_id'] == 5) {echo ' (Colab.)';} ?>
                                                                    <br />
                                                                @else
                                                                    <b>{{$chave + 1}}</b>.
                                                                    <?php echo $autor['responsaveis']['nome'] ?>
                                                                    <?php if($autor['tipo_autor_id'] == 1) {echo ' (Org.)';} ?>
                                                                    <?php if($autor['tipo_autor_id'] == 2) {echo ' (Coord.)';} ?>
                                                                    <?php if($autor['tipo_autor_id'] == 3) {echo ' (Trad.)';} ?>
                                                                    <?php if($autor['tipo_autor_id'] == 4) {echo ' (Edit.)';} ?>
                                                                    <?php if($autor['tipo_autor_id'] == 5) {echo ' (Colab.)';} ?>
                                                                    <br />
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    @endif</div>
                                            </div>
                                        </a>
                                    @endif
                                    <a class="collection-item">
                                        <div class="row">
                                            <div class="col s4"><b>Observação Geral</b></div>
                                            <div class="col s8">{{$exemplar['acervo']['obs_geral']}}</div>
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
                                            @if($exemplar['acervo']['tipo_periodico'] == '1')
                                                <th>Edição</th>
                                            @else
                                                <th>Volume</th>
                                                <th>Número</th>
                                            @endif
                                            <th>Ano</th>
                                            @if($exemplar['acervo']['tipo_periodico'] == '1')
                                                <th>Volume</th>
                                            @endif
                                            <th>CDD</th>
                                            @if($exemplar['acervo']['tipo_periodico'] == '1')
                                                <th>Cutter</th>
                                            @endif
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
                                                @if($e->tipo_periodico == '1' && $e->edicao)
                                                    <td>{{$e->edicao}}. ed.</td>
                                                @elseif($e->tipo_periodico == '2' && $e->edicao)
                                                    <td>n. {{$e->edicao}}</td>
                                                @endif
                                                @if($exemplar['acervo']['tipo_periodico'] == '1')
                                                    <td>{{$e->volume}}</td>
                                                @endif
                                                @if($exemplar['acervo']['tipo_periodico'] == '2')
                                                    <td>{{ $e->vol_periodico }}</td>
                                                    <td>{{ $e->num_periodico }}</td>
                                                @endif
                                                <td>@if($e->ano){{$e->ano}} @endif</td>
                                                <td>{{$e->cdd}}</td>
                                                @if($exemplar['acervo']['tipo_periodico'] == '1')
                                                    <td>{{$e->cutter}}</td>
                                                @endif
                                                <td>{{$e->numero_chamada}}</td>
                                                <td>{{$e->nome}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>

                            {{--Começa referência--}}

                            <div id="test4" class="col s12" style="font-size: 15px;">
                                <br>
                                <?php $count = 0; ?>
                                @if(count($exemplar['acervo']['primeiraEntrada']) > 0)
                                    @if($exemplar['acervo']['etial_autor'] == '1')
                                        @if($exemplar['acervo']['primeiraEntrada'][0]['responsaveis']['tipo_reponsavel_id'] == '1' || $exemplar['acervo']['primeiraEntrada'][0]['responsaveis']['tipo_reponsavel_id'] == "")
                                            <span style="text-transform: uppercase">{{$exemplar['acervo']['primeiraEntrada'][0]['responsaveis']['sobrenome']}}</span>,
                                            <?php echo $exemplar['acervo']['primeiraEntrada'][0]['responsaveis']['nome'] ?> et al.
                                        @else
                                            <span style="text-transform: uppercase"><?php echo ucwords(mb_strtolower($exemplar['acervo']['primeiraEntrada'][0]['responsaveis']['nome'])) ?></span><?php if (strrchr($exemplar['acervo']['primeiraEntrada'][0]['responsaveis']['nome'], ".") == ".") { echo "";} else {echo ".";} ?>
                                        @endif
                                    @else
                                        @foreach($exemplar['acervo']['primeiraEntrada'] as $chave => $autor)
                                            <?php $count++ ?>
                                                @if($autor['responsaveis']['tipo_reponsavel_id'] == '1' || $autor['responsaveis']['tipo_reponsavel_id'] == "")
                                                    <span style="text-transform: uppercase">{{$autor['responsaveis']['sobrenome']}}</span>,
                                                    <?php echo $autor['responsaveis']['nome']; ?>@if(count($exemplar['acervo']['primeiraEntrada']) == $count )<?php if (strrchr($autor['responsaveis']['nome'], ".") == ".") { echo "";} else {echo ".";} ?> @else;@endif
                                                @else
                                                    <?php echo $autor['responsaveis']['nome']; ?>@if(count($exemplar['acervo']['primeiraEntrada']) == $count )<?php if (strrchr($autor['responsaveis']['nome'], ".") == ".") { echo "";} else {echo ".";} ?> @else;@endif
                                                @endif
                                        @endforeach
                                    @endif
                                @elseif(count($exemplar['acervo']['segundaEntrada']) > 0)
                                    @if($exemplar['acervo']['etial_outros'] == '1')
                                        @if($exemplar['acervo']['segundaEntrada'][0]['responsaveis']['tipo_reponsavel_id'] == '1' || $exemplar['acervo']['segundaEntrada'][0]['responsaveis']['tipo_reponsavel_id'] == "")
                                            <span style="text-transform: uppercase">{{$exemplar['acervo']['primeiraEntrada'][0]['responsaveis']['sobrenome']}}</span>,
                                            <?php echo $exemplar['acervo']['segundaEntrada'][0]['responsaveis']['nome'] ?>
                                            <?php if($exemplar['acervo']['segundaEntrada'][0]['tipo_autor_id'] == 1) {echo ' (Org.) ';} ?>
                                            <?php if($exemplar['acervo']['segundaEntrada'][0]['tipo_autor_id'] == 2) {echo ' (Coord.) ';} ?>
                                            <?php if($exemplar['acervo']['segundaEntrada'][0]['tipo_autor_id'] == 3) {echo ' (Trad.) ';} ?>
                                            <?php if($exemplar['acervo']['segundaEntrada'][0]['tipo_autor_id'] == 4) {echo ' (Edit.) ';} ?>
                                            <?php if($exemplar['acervo']['segundaEntrada'][0]['tipo_autor_id'] == 5) {echo ' (Colab.) ';} ?>et al.
                                        @else
                                            <span style="text-transform: uppercase"><?php echo ucwords(mb_strtolower($exemplar['acervo']['segundaEntrada'][0]['responsaveis']['nome'])) ?></span><?php if (strrchr($exemplar['acervo']['segundaEntrada'][0]['responsaveis']['nome'], ".") == ".") { echo "";} else {echo ".";} ?>
                                        @endif
                                    @else
                                        @foreach($exemplar['acervo']['segundaEntrada'] as $chave => $autor)
                                            <?php $count++; ?>
                                                @if($autor['responsaveis']['tipo_reponsavel_id'] == '1' || $autor['responsaveis']['tipo_reponsavel_id'] == "")
                                                    @if($chave == 0 && $autor['para_referencia1'] == '1')
                                                        @if($autor['exibir_tipo1'] == '1')
                                                            <span style="text-transform: uppercase">{{$autor['responsaveis']['sobrenome']}}</span>,
                                                            <?php echo $autor['responsaveis']['nome']; ?>
                                                            <?php if($autor['tipo_autor_id'] == 1) {echo ' (Org.)';} ?>
                                                            <?php if($autor['tipo_autor_id'] == 2) {echo ' (Coord.)';} ?>
                                                            <?php if($autor['tipo_autor_id'] == 3) {echo ' (Trad.)';} ?>
                                                            <?php if($autor['tipo_autor_id'] == 4) {echo ' (Edit.)';} ?>
                                                            <?php if($autor['tipo_autor_id'] == 5) {echo ' (Colab.)';} ?>@if(count($exemplar['acervo']['segundaEntrada']) == $count ).@else;@endif
                                                        @else
                                                            <span style="text-transform: uppercase">{{$autor['responsaveis']['sobrenome']}}</span>,
                                                            <?php echo $autor['responsaveis']['nome']; ?>@if(count($exemplar['acervo']['segundaEntrada']) == $count ).@else;@endif
                                                        @endif
                                                    @elseif ($chave == 1 && $autor['para_referencia2'] == '1')
                                                        @if($autor['exibir_tipo2'] == '1')
                                                            <span style="text-transform: uppercase">{{$autor['responsaveis']['sobrenome']}}</span>,
                                                            <?php echo $autor['responsaveis']['nome']; ?>
                                                            <?php if($autor['tipo_autor_id'] == 1) {echo ' (Org.)';} ?>
                                                            <?php if($autor['tipo_autor_id'] == 2) {echo ' (Coord.)';} ?>
                                                            <?php if($autor['tipo_autor_id'] == 3) {echo ' (Trad.)';} ?>
                                                            <?php if($autor['tipo_autor_id'] == 4) {echo ' (Edit.)';} ?>
                                                            <?php if($autor['tipo_autor_id'] == 5) {echo ' (Colab.)';} ?>@if(count($exemplar['acervo']['segundaEntrada']) == $count ).@else;@endif
                                                        @else
                                                            <span style="text-transform: uppercase">{{$autor['responsaveis']['sobrenome']}}</span>,
                                                            <?php echo $autor['responsaveis']['nome']; ?>@if(count($exemplar['acervo']['segundaEntrada']) == $count ).@else;@endif
                                                        @endif
                                                    @elseif ($chave == 2 && $autor['para_referencia3'] == '1')
                                                        @if($autor['exibir_tipo3'] == '1')
                                                            <span style="text-transform: uppercase">{{$autor['responsaveis']['sobrenome']}}</span>,
                                                            <?php echo $autor['responsaveis']['nome']; ?>
                                                            <?php if($autor['tipo_autor_id'] == 1) {echo ' (Org.)';} ?>
                                                            <?php if($autor['tipo_autor_id'] == 2) {echo ' (Coord.)';} ?>
                                                            <?php if($autor['tipo_autor_id'] == 3) {echo ' (Trad.)';} ?>
                                                            <?php if($autor['tipo_autor_id'] == 4) {echo ' (Edit.)';} ?>
                                                            <?php if($autor['tipo_autor_id'] == 5) {echo ' (Colab.)';} ?>@if(count($exemplar['acervo']['segundaEntrada']) == $count ).@else;@endif
                                                        @else
                                                            <span style="text-transform: uppercase">{{$autor['responsaveis']['sobrenome']}}</span>,
                                                            <?php echo $autor['responsaveis']['nome']; ?>@if(count($exemplar['acervo']['segundaEntrada']) == $count ).@else;@endif
                                                        @endif
                                                    @endif
                                                @else
                                                    @if($chave == 0 && $autor['para_referencia1'] == '1')
                                                            @if($autor['exibir_tipo1'] == '1')
                                                                <?php echo $autor['responsaveis']['nome']; ?>
                                                                <?php if($autor['tipo_autor_id'] == 1) {echo ' (Org.)';} ?>
                                                                <?php if($autor['tipo_autor_id'] == 2) {echo ' (Coord.)';} ?>
                                                                <?php if($autor['tipo_autor_id'] == 3) {echo ' (Trad.)';} ?>
                                                                <?php if($autor['tipo_autor_id'] == 4) {echo ' (Edit.)';} ?>
                                                                <?php if($autor['tipo_autor_id'] == 5) {echo ' (Colab.)';} ?>@if(count($exemplar['acervo']['segundaEntrada']) == $count ).@else;@endif
                                                            @else
                                                                <span style="text-transform: uppercase">{{$autor['responsaveis']['sobrenome']}}</span>,
                                                                <?php echo $autor['responsaveis']['nome']; ?>@if(count($exemplar['acervo']['segundaEntrada']) == $count ).@else;@endif
                                                            @endif
                                                    @elseif ($chave == 1 && $autor['para_referencia2'] == '1')
                                                        @if($autor['exibir_tipo2'] == '1')
                                                            <?php echo $autor['responsaveis']['nome']; ?>
                                                            <?php if($autor['tipo_autor_id'] == 1) {echo ' (Org.)';} ?>
                                                            <?php if($autor['tipo_autor_id'] == 2) {echo ' (Coord.)';} ?>
                                                            <?php if($autor['tipo_autor_id'] == 3) {echo ' (Trad.)';} ?>
                                                            <?php if($autor['tipo_autor_id'] == 4) {echo ' (Edit.)';} ?>
                                                            <?php if($autor['tipo_autor_id'] == 5) {echo ' (Colab.)';} ?>@if(count($exemplar['acervo']['segundaEntrada']) == $count ).@else;@endif
                                                        @else
                                                            <span style="text-transform: uppercase">{{$autor['responsaveis']['sobrenome']}}</span>,
                                                            <?php echo $autor['responsaveis']['nome']; ?>@if(count($exemplar['acervo']['segundaEntrada']) == $count ).@else;@endif
                                                        @endif
                                                    @elseif ($chave == 2 && $autor['para_referencia3'] == '1')
                                                        @if($autor['exibir_tipo3'] == '1')
                                                            <?php echo $autor['responsaveis']['nome']; ?>
                                                            <?php if($autor['tipo_autor_id'] == 1) {echo ' (Org.)';} ?>
                                                            <?php if($autor['tipo_autor_id'] == 2) {echo ' (Coord.)';} ?>
                                                            <?php if($autor['tipo_autor_id'] == 3) {echo ' (Trad.)';} ?>
                                                            <?php if($autor['tipo_autor_id'] == 4) {echo ' (Edit.)';} ?>
                                                            <?php if($autor['tipo_autor_id'] == 5) {echo ' (Colab.)';} ?>@if(count($exemplar['acervo']['segundaEntrada']) == $count ).@else;@endif
                                                        @else
                                                            <span style="text-transform: uppercase">{{$autor['responsaveis']['sobrenome']}}</span>,
                                                            <?php echo $autor['responsaveis']['nome']; ?>@if(count($exemplar['acervo']['segundaEntrada']) == $count ).@else;@endif
                                                        @endif
                                                    @endif
                                                @endif
                                        @endforeach
                                    @endif
                                @endif
                                @if(count($exemplar['acervo']['primeiraEntrada']) <= 0 && count($exemplar['acervo']['segundaEntrada']) <= 0)

                                        <?php
                                        $array = explode(' ', $exemplar['acervo']['titulo']);
                                        $paravra = "";

                                        if (strlen($array[0]) <= 1) {
                                            $paravra .= ucwords(mb_strtoupper($array[0] . " " . $array[1])) . " ";
                                            for ($i = 2; $i < count($array); $i++) {
                                                $paravra .= mb_strtolower($array[$i]);
                                                if ($i >= count($array)) {
                                                    $paravra .= "";
                                                } else {
                                                    $paravra .= " ";
                                                }
                                            };
                                        } else {
                                            $paravra .= ucwords(mb_strtoupper($array[0])) . " ";
                                            for ($i = 1; $i < count($array); $i++) {
                                                $paravra .= mb_strtolower($array[$i]);
                                                if ($i >= count($array)) {
                                                    $paravra .= "";
                                                } else {
                                                    $paravra .= " ";
                                                }
                                            };
                                        }
                                        ?>
                                    @if($exemplar['acervo']['tipo_periodico'] == '1')
                                          <b> {{$paravra}}@if($exemplar['acervo']['subtitulo'])<?php echo ': '. mb_strtolower($exemplar['acervo']['subtitulo']) ?>.@else.@endif  </b>
                                    @elseif($exemplar['acervo']['tipo_periodico'] == '2')
                                          {{mb_strtoupper($paravra)}} @if($exemplar['acervo']['subtitulo'])<?php echo ': '. $exemplar['acervo']['subtitulo'] ?>.@else.@endif
                                    @endif

                                @else
                                    <b><?php echo $exemplar['acervo']['titulo'] ?></b>@if($exemplar['acervo']['subtitulo'])<?php echo ': '. mb_strtolower($exemplar['acervo']['subtitulo']) ?>.@else.@endif
                                @endif
                                @if($exemplar['edicao'] && $exemplar['acervo']['tipo_periodico'] == '1')
                                    {{$exemplar['edicao']}}. ed.
                                    @if($exemplar['ampliada'] && !$exemplar['revisada'] && !$exemplar['atualizada'] && !$exemplar['revista']) ampl.
                                    @elseif($exemplar['revisada'] && !$exemplar['ampliada'] && !$exemplar['atualizada'] && !$exemplar['revista'] ) rev.
                                    @elseif($exemplar['atualizada'] && !$exemplar['ampliada'] && !$exemplar['revisada'] && !$exemplar['revista']) atual.
                                    @elseif($exemplar['revista'] && !$exemplar['ampliada'] && !$exemplar['revisada'] && !$exemplar['atualizada']) revis.
                                    @elseif($exemplar['ampliada'] && $exemplar['revisada']) ampl. e rev.
                                    @elseif($exemplar['ampliada'] && $exemplar['atualizada']) ampl. e atual.
                                    @elseif($exemplar['revisada'] && $exemplar['atualizada']) rev. e atual.
                                    @elseif($exemplar['revista'] && $exemplar['atualizada']) revis. e atual.
                                    @elseif($exemplar['revista'] && $exemplar['revisada']) revis. e rev.
                                    @elseif($exemplar['revista'] && $exemplar['ampliada']) revis. e ampl.
                                    @elseif($exemplar['revisada'] && $exemplar['atualizada'] && $exemplar['ampliada'] && $exemplar['revista']) ampl. e rev. e atual. e revis.
                                    @endif
                                @endif
                                @if($exemplar['acervo']['tipo_periodico'] == '2')
                                    v. {{$exemplar['vol_periodico']}}, n. {{$exemplar['num_periodico']}},
                                @endif
                                @if($exemplar['local'])<?php echo ucwords(mb_strtolower($exemplar['local'])) ?>: @endif
                                @if($exemplar['editora']['nome'])<?php echo $exemplar['editora']['nome'] ?>, @endif
                                @if($exemplar['ano']){{$exemplar['ano']}}. @endif @if($exemplar['numero_pag']){{$exemplar['numero_pag']}}p.@endif
                                @if($exemplar['acervo']['tipo_periodico'] == '1')
                                    @if($exemplar['ilustracoes_id'] == '1'), il.@endif
                                @endif
                                @if($exemplar['acervo']['colecao_id'] && !$exemplar['acervo']['serie_id'])
                                    ({{ $exemplar['acervo']['colecao']['nome'] }}).
                                @elseif($exemplar['acervo']['serie_id'] && !$exemplar['acervo']['colecao_id'])
                                    ({{ $exemplar['acervo']['serie']['nome'] }}).
                                @elseif($exemplar['acervo']['serie_id'] && $exemplar['acervo']['colecao_id'])
                                    ({{ $exemplar['acervo']['serie']['nome'] }}) ({{ $exemplar['acervo']['colecao']['nome'] }}).@else, @endif
                                @if($exemplar['acervo']['tipo_periodico'] == '1')
                                    @if($exemplar['isbn'])ISBN {{$exemplar['isbn']}}. @endif
                                @else
                                    @if($exemplar['issn'])ISSN {{$exemplar['issn']}}. @endif
                                @endif
                            </div>

                            {{--Termina referência--}}

                            @if($exemplar['acervo']['tipo_periodico'] == '1')

                                <div id="test5" class="col s12">
                                <div class="collection">
                                    <a class="collection-item">
                                        <div class="row">
                                            <div class="col s4"><b>Sumário</b></div>
                                            <div class="col s8">
                                                <?php
                                                $array = explode(';', $exemplar['acervo']['sumario']);
                                                $count = 0;
                                                ?>
                                                @foreach($array as $sumario)
                                                    <?php $count++ ?>
                                                     {{$sumario}} @if($count >= count($array)) @else <br /> @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </a>
                                    <a class="collection-item">
                                        <div class="row">
                                            <div class="col s4"><b>Palavras chave</b></div>
                                            <div class="col s8">
                                                <?php
                                                $array = explode(';', $exemplar['acervo']['palavras_chaves']);
                                                $count = 0;
                                                ?>
                                                @foreach($array as $palavra)
                                                    <?php $count++ ?>
                                                    {{$palavra}} @if($count >= count($array)) @else <br /> @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            @endif

                        </div>
                    </section>
                </div>
                <div class="col s12 m3">
                    <section class="arg-list">
                        <div class="col s12">
                            <div class="card" style="margin-top: 0px;">
                                <div class="card-image waves-effect waves-block waves-light">
                                    <div class="book-search">
                                        @if($exemplar['path_image'] != null)
                                            <img src="{{route('seracademico.biblioteca.getImg', ['id' => $exemplar['id']])}}"
                                                 style="min-height: 0;width: 130px;max-width: 130px;max-height: 165px;">
                                        @else
                                            <img src="{{ asset('/biblioteca/img/capa_livro3.jpg')}}"
                                                 style="min-height: 0;width: 130px;max-width: 130px;max-height: 165px;">
                                        @endif
                                    </div>
                                    {{-- <img class="activator" src="{{ asset('/biblioteca/img/Capa-Livro-Propague-2.jpg')}}">--}}
                                </div>
                            </div>
                            <br/>
                            <a href="javascript:window.history.go(-1)" class="btn waves-effect waves-light"><i
                                        class="material-icons left">arrow_back</i>Voltar</a>
                        </div>
                    </section>
            </div>
        </div>
    </div>
</div>
@endsection