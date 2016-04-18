<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="form-group col-md-4">
                {!! Form::label('nome', 'Nome') !!}
                {!! Form::text('nome', null, array('class' => 'form-control')) !!}
            </div>
        </div>

        {{--Buttons Submit e Voltar--}}
        <div class="row">
            <div class="col-md-2">
                {!! Form::submit('Salvar', array('class' => 'btn btn-primary btn-block')) !!}
            </div>
            <div class="col-md-2">
                <a href="{{ route('seracademico.tipoCurso.index') }}" class="btn btn-primary btn-block">Voltar</a>
            </div>
        </div>
        {{--Fim Buttons Submit e Voltar--}}

    </div>
</div>