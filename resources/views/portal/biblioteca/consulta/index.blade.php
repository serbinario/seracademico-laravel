@extends('portal.menuportal2')

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
                <form action="{{url('seachSimple')}}" class="form-horizontal" method="post">
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

