@extends('menu')

@section('content')
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <div class="col-sm-6 col-md-9">
                <h4><i class="material-icons">card_travel</i> Relatórios Módulos de Disciplinas por Curso</h4>
            </div>
            <div class="col-sm-6 col-md-3">

            </div>
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

            {!! Form::open(['route'=>'seracademico.tecnico.relatorios.report_modulos_disciplinas',
             'method' => "GET", 'target' => '_blank']) !!}

            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('curso', 'Curso') !!}
                                {!! Form::select('curso', $loadFields['tecnico\curso'], Session::getOldInput('curso'),
                                array('class' => 'form-control')) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div><br />

            {{--Buttons Submit e Voltar--}}
            <div class="row">
                <div class="col-md-2">
                    <div class="btn-group btn-group-justified">
                        <div class="btn-group">
                            {!! Form::submit('Gerar relatório', array('class' => 'btn btn-primary btn-block')) !!}
                        </div>
                    </div>
                </div>
                {{--Fim Buttons Submit e Voltar--}}
            </div>

            {!! Form::close() !!}
        </div>
    </div>
@stop