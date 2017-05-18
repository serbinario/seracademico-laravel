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
    <div class="parallax"><img src="{{ asset('/biblioteca/img/biblioteca31.jpg')}}"></div>
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
                                <option value="1" selected >Todos os campos</option>
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
        @foreach($resultado->items() as $f)
            <div class="col s12 m4 l3">
                <div class="box-book">
                    <div class="col s12">
                        <div class="row">
                            <div class="col s12">
                                <div class="book-search">
                                    <a href="{{url("seachDetalhe/exemplar/$f->id")}}">
                                        @if($f->path_image != null)
                                            <img src="{{route('seracademico.biblioteca.getImg', ['id' => $f->id])}}" style="min-height: 0;width: 130px;max-width: 130px;max-height: 165px;">
                                        @else
                                            <img src="{{ asset('/biblioteca/img/capa_livro3.jpg')}}" style="min-height: 0;width: 130px;max-width: 130px;max-height: 165px;">
                                        @endif
                                    </a>
                                </div>
                            </div>
                            <span class="ed-bdg">@if($f->edicao){{$f->edicao}}. ed. @endif</span>
                            <span class="badge mybdg" >@if($f->tipos_acervos_id == '1')
                                    Livro
                                @elseif($f->tipos_acervos_id == '2')
                                    Revista
                                @endif
                            </span>
                        </div>
                    </div>

                    <div class="row center">
                        <div class="col s12">
                            <a href="{{url("seachDetalhe/exemplar/$f->id")}}">
                                <?php $data = explode(" ", $f->subtitulo); $subtitulo = "";?>
                                <p style="font-size: 13px;color: #182d52;"><b>{{ $f->titulo }}</b><br/>
                                    @if(count($data) <= 3)
                                        @foreach($data as $d)
                                            {!!   $d  !!}
                                        @endforeach
                                    @else
                                        {{$data[0]}} {{$data[1]}} {{$data[2]}}...
                                    @endif
                                </p></a>
                            <p style="font-size: 11px;color: #0c0c0c;">{{$f->sobrenome}}, {{$f->nome}}</p>
                            <div class="col s6"><p class="labels-cc"><b>CDD</b><br/>{{ $f->cdd }}</p></div>
                            <div class="col s6"><p class="labels-cc"><b>CUTTER</b><br/>{{ $f->cutter }}</p></div>
                            <div class="col s12"><div class="chip tooltipped" data-position="bottom" data-delay="30" data-tooltip="{{$f->assunto}}" style="font-size: 10px;">{{$f->assunto}}</div></div>

                        </div>
                    </div>

                    <div class="row">
                        <a href="{{url("seachDetalhe/exemplar/$f->id")}}" class="btn waves-effect waves-light btn-box"><i class="material-icons left">launch</i>Detalhes</a>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="row">
            <div class="col s12 m12 center">
                {!!  $resultado->appends(Input::except('page'))->render() !!}
            </div>
        </div>
    </div>
@endsection
