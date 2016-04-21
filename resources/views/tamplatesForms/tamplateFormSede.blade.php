<div class="row">
    <div class="col-md-12">
        <div class="row">

            <div class="col-md-5">
                <div class="form-group">
                    {!! Form::label('nome', 'Nome') !!}
                    {!! Form::text('nome', null, array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    {!! Form::label('representante', 'Representante') !!}
                    {!! Form::text('representante', Session::getOldInput('representante')  , array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('telefone', 'Telefone') !!}
                    {!! Form::text('telefone', Session::getOldInput('representante')  , array('class' => 'form-control phone')) !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-10">
                <div class="form-group">
                    {!! Form::label('endereco[logradouro]', 'Endereço ') !!}
                    {!! Form::text('endereco[logradouro]', Session::getOldInput('endereco[logradouro]'), array('class' => 'form-control')) !!}
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('endereco[numero]', 'Número') !!}
                    {!! Form::text('endereco[numero]', Session::getOldInput('endereco[numero]'), array('class' => 'form-control')) !!}
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('estado', 'UF ') !!}
                    @if(isset($model->endereco->bairro->cidade->estado->id))
                        {!! Form::select('estado', $loadFields['estado'], $model->endereco->bairro->cidade->estado->id, array('class' => 'form-control', 'id' => 'estado')) !!}
                    @else
                        {!! Form::select('estado', $loadFields['estado'], Session::getOldInput('estado'), array('class' => 'form-control', 'id' => 'estado')) !!}
                    @endif
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('cidade', 'Cidade ') !!}
                    @if(isset($model->endereco->bairro->cidade->id))
                        {!! Form::select('cidade', array($model->endereco->bairro->cidade->id => $model->endereco->bairro->cidade->nome), $model->endereco->bairro->cidade->id,array('class' => 'form-control', 'id' => 'cidade')) !!}
                    @else
                        {!! Form::select('cidade', array(), Session::getOldInput('cidade'),array('class' => 'form-control', 'id' => 'cidade')) !!}
                    @endif
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('endereco[bairros_id]', 'Bairro ') !!}
                    @if(isset($model->endereco->bairro->id))
                        {!! Form::select('endereco[bairros_id]', array($model->endereco->bairro->id => $model->endereco->bairro->nome), $model->endereco->bairro->id,array('class' => 'form-control', 'id' => 'bairro')) !!}
                    @else
                        {!! Form::select('endereco[bairros_id]', array(), Session::getOldInput('bairro'),array('class' => 'form-control', 'id' => 'bairro')) !!}
                    @endif
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('endereco[cep]', 'CEP ') !!}
                    {!! Form::text('endereco[cep]', Session::getOldInput('endereco[cep]'), array('class' => 'form-control cep')) !!}
                </div>
            </div>
        </div>

        {{--Buttons Submit e Voltar--}}
        <div class="row">
            <div class="col-md-9"></div>
            <div class="col-md-3">
                <div class="btn-group btn-group-justified">
                    <div class="btn-group">
                        <a href="{{ route('seracademico.sede.index') }}" class="btn btn-primary btn-block"><i class="fa fa-long-arrow-left"></i>  Voltar</a>
                    </div>
                    <div class="btn-group">
                        {!! Form::submit('Salvar', array('class' => 'btn btn-primary btn-block')) !!}
                    </div>
                </div>
                <div class="col-md-2">
                </div>
            </div>
            {{--Fim Buttons Submit e Voltar--}}

        </div>
    </div>