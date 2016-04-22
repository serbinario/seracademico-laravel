<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="form-group col-md-4">
                {!! Form::label('nome', 'Nome:') !!}
                {!! Form::text('nome', null, array('class' => 'form-control')) !!}
            </div>
            <div class="form-group col-md-1">
                {!! Form::label('bloco', 'Bloco: ') !!}
                {!! Form::text('bloco', null, array('class' => 'form-control')) !!}
            </div>

            <div class="form-group col-md-1">
                {!! Form::label('andar', 'Andar: ') !!}
                {!! Form::text('andar', null, array('class' => 'form-control')) !!}
            </div>
            <div class="form-group col-md-2">
                {!! Form::label('numero', 'Número: ') !!}
                {!! Form::text('numero', null, array('class' => 'form-control')) !!}
            </div>

            <div class="form-group col-md-2">
                {!! Form::label('capacidade', 'Capacidade:') !!}
                {!! Form::text('capacidade', null, array('class' => 'form-control')) !!}
            </div>
            <div class="form-group col-md-2">
                {!! Form::label('situacao', 'Ativo') !!}
                <div class="checkbox checkbox-primary">
                    {!! Form::hidden('situacao', 0) !!}
                    {!! Form::checkbox('situacao', 1, null, array('class' => 'form-control')) !!}
                    {!! Form::label('ativo', 'Ativar', false) !!}
                </div>
            </div>
        </div>

        {{--Buttons Submit e Voltar--}}
        <div class="row">
            <div class="col-md-9"></div>
            <div class="col-md-3">
                <div class="btn-group btn-group-justified">
                    <div class="btn-group">
                        <a href="{{ route('seracademico.sala.index') }}" class="btn btn-primary btn-block"><i class="fa fa-long-arrow-left"></i>  Voltar</a></div>
                    <div class="btn-group">
                        {!! Form::submit('Salvar', array('class' => 'btn btn-primary btn-block')) !!}
                    </div>
                </div>
            </div>
            {{--Fim Buttons Submit e Voltar--}}

        </div>
    </div>