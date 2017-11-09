<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('nome', 'Nome: ') !!}
                    {!! Form::text('nome', null, array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('estado', 'Estado: ') !!}
                    @if(isset($model->endereco->bairro->cidade->estado->id))
                        {!! Form::select('estado', $loadFields['estado'], $model->cidade->estado->id, array('class' => 'form-control', 'id' => 'estado')) !!}
                    @else
                        {!! Form::select('estado', $loadFields['estado'], Session::getOldInput('estado'), array('class' => 'form-control', 'id' => 'estado')) !!}
                    @endif
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('cidades_id', 'Cidade: ') !!}
                    @if(isset($model->cidade->id))
                        {!! Form::select('cidades_id', array($model->cidade->id => $model->cidade->nome), $model->cidade->id,array('class' => 'form-control', 'id' => 'cidade')) !!}
                    @else
                        {!! Form::select('cidades_id', array(), Session::getOldInput('cidades_id'), array('class' => 'form-control', 'id' => 'cidade')) !!}
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9"></div>
            <div class="col-md-3">
                <div class="btn-group btn-group-justified">
                    <div class="btn-group">
                        <a href="{{ route('seracademico.bairro.index') }}" class="btn btn-primary btn-block"><i class="fa fa-long-arrow-left"></i>  Voltar</a></div>
                    <div class="btn-group">
                        {!! Form::submit('Salvar', array('class' => 'btn btn-primary btn-block')) !!}
                    </div>
                </div>
            </div>
            {{--Fim Buttons Submit e Voltar--}}

        </div>
    </div>

    @section('javascript')
        <script type="text/javascript" >

            //Carregando as cidades
            $(document).on('change', "#estado", function () {
                //Removendo as cidades
                $('#cidade option').remove();

                //Removendo as Bairros
                $('#bairro option').remove();

                //Recuperando o estado
                var estado = $(this).val();

                if (estado !== "") {
                    var dados = {
                        'table': 'cidades',
                        'field_search': 'estados_id',
                        'value_search': estado
                    };

                    jQuery.ajax({
                        type: 'POST',
                        url: "/index.php/seracademico/util/search",
                        data: dados,
                        datatype: 'json'
                    }).done(function (json) {
                        var option = "";

                        option += '<option value="">Selecione uma cidade</option>';
                        for (var i = 0; i < json.length; i++) {
                            option += '<option value="' + json[i]['id'] + '">' + json[i]['nome'] + '</option>';
                        }

                        $('#cidade option').remove();
                        $('#cidade').append(option);
                    });
                }
            });
        </script>
@stop
{{--Buttons Submit e Voltar--}}
