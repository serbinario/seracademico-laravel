@extends('menu')

@section('content')
    <div class="ibox float-e-margins">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h4>
                    <i class="material-icons">library_books</i>
                    Cadastrar Agendamento Segunda Chamada
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

            {!! Form::open(['route'=>'seracademico.tecnico.agendamento.store', 'id' => 'formAgendamento', 'method' => "POST" ]) !!}
                    @include('tamplatesForms.tecnico.tamplateFormAgendamentoSegundaChamada')
            {!! Form::close() !!}
        </div>        
    </div>
@stop
