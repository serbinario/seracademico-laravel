@extends('menu')


@section('content')

    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h4>
                <i class="flaticon-employment-test"></i>
                Editar Vestibulando
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

            {!! Form::model($aluno, ['route'=> ['seracademico.vestibulando.update', $aluno->id], 'id' => 'formVestibulando', 'enctype' => 'multipart/form-data']) !!}
                @include('tamplatesForms.graduacao.tamplateFormVestibulando')
                {{--<a href="{{ route('seracademico.report.contratoAluno', ['id' => $aluno->id]) }}" target="_blank" class="btn btn-info">Contrato</a>--}}
            {!! Form::close() !!}
        </div>
    </div>
@stop
