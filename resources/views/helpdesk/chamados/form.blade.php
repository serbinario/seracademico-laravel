<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    {!! Form::label('titulo', 'Título *') !!}
                    {!! Form::text('titulo', Session::getOldInput('titulo')  , array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('prioridade', 'Prioridade *') !!}
                    {!! Form::select('prioridade', ['N' => 'Normal', 'M' => 'Moderada', 'U' => 'Urgente'],
                        Session::getOldInput('prioridade'), array('class' => 'form-control')) !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::label('descricao', 'Descrição *') !!}
                    {!! Form::textarea('descricao', Session::getOldInput('descricao'), array('class' => 'form-control', 'rows' => '5')) !!}
                </div>
            </div>
        </div>
    </div>
</div>
{{--Buttons Submit e Voltar--}}
<div class="row">
    <div class="col-md-9"></div>
    <div class="col-md-3">
        <div class="btn-group btn-group-justified">
            <div class="btn-group">
                <a href="{{  route('seracademico.helpdesk.chamados.index') }}" class="btn btn-primary btn-block"><i class="fa fa-long-arrow-left"></i>  Voltar</a></div>
            <div class="btn-group">
                {!! Form::submit('Salvar', array('class' => 'btn btn-primary btn-block')) !!}
            </div>
        </div>
    </div>
    {{--Fim Buttons Submit e Voltar--}}
</div>
