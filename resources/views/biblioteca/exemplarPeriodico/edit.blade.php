@extends('menu')

@section('content')
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <div class="col-sm-6 col-md-9">
                <h4><i class="material-icons">receipt</i> Editar Exemplar - Revista</h4>
            </div>
            <div class="col-sm-6 col-md-3"></div>
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

            {!! Form::model($model, ['route'=> ['seracademico.biblioteca.updateExemplarP', $model->id], 'id' => 'FormExemplarP', 'method' => "POST", 'enctype' => 'multipart/form-data' ]) !!}
                @include('tamplatesForms.tamplateFormExemplarPeriodico')
            {!! Form::close() !!}
        </div>
    </div>
@stop