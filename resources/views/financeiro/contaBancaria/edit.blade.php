@extends('menu')

@section('content')
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h4>
                <i class="fa fa-university"></i>
                Editar Conta Bancária
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

            {!! Form::model($model, ['route'=> ['seracademico.financeiro.contaBancaria.update', $model->id],
                'method' => "POST" ]) !!}
                @include('tamplatesForms.financeiro.tamplateFormContaBancaria')
            {!! Form::close() !!}
        </div>
        
    </div>
@stop