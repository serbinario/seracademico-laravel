@extends('menu')

@section('content')
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h4>
                <i class="flaticon-currency-rates"></i>
                Editar Par�metro
            </h4>
        </div>

        <div class="ibox-content">

            @if(Session::has('message'))
                <div class="alert alert-success">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <em> {!! session('message') !!}</em>
                </div>
            @endif

            @if(Session::has('errors'))
                <div class="alert alert-danger">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            {!! Form::model($model, ['route'=> ['seracademico.financeiro.parametro.update', $model->id], 'method' => "POST", 'id' => 'formParametro' ]) !!}
                @include('tamplatesForms.financeiro.tamplateFormParametro')
            {!! Form::close() !!}
        </div>
        
    </div>
@stop