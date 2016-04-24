<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    {!! Form::label('nome', 'Nome') !!}
                    {!! Form::text('nome', null, array('class' => 'form-control')) !!}
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('cnpj', 'CNPJ') !!}
                    {!! Form::text('cnpj', null, array('class' => 'form-control cnpj')) !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    {!! Form::label('endereco[logradouro]', 'Endereço ') !!}
                    {!! Form::text('endereco[logradouro]', Session::getOldInput('endereco[logradouro]'), array('class' => 'form-control')) !!}
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('endereco[numero]', 'Número ') !!}
                    {!! Form::text('endereco[numero]', Session::getOldInput('endereco[numero]'), array('class' => 'form-control')) !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('estados_id', 'UF ') !!}
                    {!! Form::select('estados_id', $loadFields['estado'], Session::getOldInput('estados_id'), array('class' => 'form-control', 'id' => 'estado')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('cidade', 'Cidade ') !!}
                    @if(isset($empresa->endereco->bairro->cidade->id))
                        {!! Form::select('cidade', array($empresa->endereco->bairro->cidade->id => $empresa->endereco->bairro->cidade->nome), $empresa->endereco->bairro->cidade->id,array('class' => 'form-control', 'id' => 'cidade')) !!}
                    @else
                        {!! Form::select('cidade', array(), Session::getOldInput('cidade'),array('class' => 'form-control', 'id' => 'cidade')) !!}
                    @endif
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('endereco[bairros_id]', 'Bairro ') !!}
                    @if(isset($empresa->endereco->bairro->id))
                        {!! Form::select('endereco[bairros_id]', array($empresa->endereco->bairro->id => $empresa->endereco->bairro->nome), $empresa->endereco->bairro->id,array('class' => 'form-control', 'id' => 'bairro')) !!}
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

        <div class="row">

            <div class="form-group col-md-2">
                {!! Form::label('inscricao_municipal', 'Ins. Municipal') !!}
                {!! Form::text('inscricao_municipal', null, array('class' => 'form-control')) !!}
            </div>



            <div class="form-group col-md-2">
                {!! Form::label('inscricao_estadual', 'Inscrição Estadual') !!}
                {!! Form::text('inscricao_estadual', null, array('class' => 'form-control')) !!}
            </div>

        </div>


        {{--Buttons Submit e Voltar--}}
        <div class="row">
            <div class="col-md-10"></div>
            <div class="col-md-2">
                {!! Form::submit('Salvar', array('class' => 'btn btn-primary btn-block pull-right')) !!}
            </div>

        </div>
        {{--Fim Buttons Submit e Voltar--}}
    </div>
</div>