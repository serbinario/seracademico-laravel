@extends('menu')

@section('content')

    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <div class="col-sm-6 col-md-9">
                <h4><i class="material-icons">find_in_page</i> Listar Acervos</h4>
            </div>
            <div class="col-sm-6 col-md-3">
                <a href="{{ route('seracademico.biblioteca.createAcervo')}}" class="btn-sm btn-primary pull-right">Novo Acervo</a>
            </div>
        </div>
        <div class="ibox-content">

            <div class="row">
                <div class="col-md-12">
                    <form action="{{url('seracademico/biblioteca/seachSimple')}}" class="form-horizontal" method="post">
                        <div class="form-group col-md-2">
                            {!! Form::label('matricula', 'Buscar por ') !!}
                            <select name="busca_por" class="form-control">
                                <option value="1" selected>Todas</option>
                                <option value="2">Título</option>
                                <option value="3">Assunto</option>
                                <option value="4">Autor</option>
                            </select>
                        </div>
                        <div class="form-group col-md-7">
                            {!! Form::label('busca', 'Busca ') !!}
                            {!! Form::text('busca', null , array('class' => 'form-control')) !!}
                        </div>
                        <div class="form-group col-md-2">
                            {!! Form::label('tipo_obra', 'Tipo da obra') !!}
                            {!! Form::select('tipo_obra', $loadFields['biblioteca\tipoacervo'], null,array('class' => 'form-control')) !!}
                        </div>
                        <div class="form-group col-md-4">
                            <input type="submit" class="btn btn-primary" value="Pesquisar">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('javascript')
@stop