@extends('menu')

@section('content')
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h4>
                <i class="material-icons">line_weight</i>
                Editar Plano de Ensino
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

            {!! Form::model($model, ['route'=> ['seracademico.graduacao.planoEnsino.update', $model->id], 'method' => "POST", "id" => "formPlanoEnsino", 'enctype' => 'multipart/form-data']) !!}
                @include('tamplatesForms.graduacao.tamplateFormPlanoEnsino')
            {!! Form::close() !!}
        </div>

    </div>
@stop