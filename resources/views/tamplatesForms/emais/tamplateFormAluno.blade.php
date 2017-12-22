<div class="row">
	<div class="col-md-12">

        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#dados" aria-controls="dados" role="tab" data-toggle="tab">Dados Pessoais</a></li>
            <li role="presentation"><a href="#endereco" aria-controls="endereco" role="tab" data-toggle="tab">Endereço</a></li>
        </ul>


        <div class="tab-content">
            <!-- Tab Pricipais dados -->
            <div role="tabpanel" class="tab-pane active" id="dados">
                <br />
                <div class="row">

                    <div class="form-group col-md-6">
                        <div class="fg-line">
                            {!! Form::label('pessoa[nome]', 'Nome * max 60 caracteres (0-9 A-Z .-[ ])') !!}
                            {!! Form::text('pessoa[nome]',  Session::getOldInput('pessoa[nome]') , array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="form-group col-md-2">
                        <div class="fg-line">
                            {!! Form::label('pessoa[data_nasciemento]', 'Nascimento *') !!}
                            {!! Form::text('pessoa[data_nasciemento]', null, array('class' => 'form-control datepicker date')) !!}
                        </div>
                    </div>
                    <div class="form-group col-md-2">
                        <div class="fg-line">
                            {!! Form::label('pessoa[sexos_id]', 'Sexo ') !!}
                            {!! Form::select('pessoa[sexos_id]', $loadFields['sexo'], Session::getOldInput('pessoa[sexos_id]'), array('class' => 'form-control')) !!}
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="form-group col-md-3">
                        <div class="fg-line">
                            {!! Form::label('pessoa[cpf]', 'CPF *') !!}
                            {!! Form::text('pessoa[cpf]', Session::getOldInput('pessoa[cpf]'), array('class' => 'form-control cpf', 'id' => 'cpfAlunos')) !!}
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                        <div class="fg-line">
                            {!! Form::label('pessoa[identidade]', 'Identidade *') !!}
                            {!! Form::text('pessoa[identidade]', Session::getOldInput('pessoa[identidade]'), array('class' => 'form-control')) !!}
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="form-group col-md-3">
                        <div class="fg-line">
                            {!! Form::label('tel_res', 'Telefone residencial') !!}
                            {!! Form::text('tel_res', Session::getOldInput('tel_res'), array('class' => 'form-control phone')) !!}
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                        <div class="fg-line">
                            {!! Form::label('tel_celular', 'Telefone celular') !!}
                            {!! Form::text('tel_celular', Session::getOldInput('tel_celular'), array('class' => 'form-control celPhone')) !!}
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                        <div class="fg-line">
                            {!! Form::label('tel_outro', 'Outro telefone') !!}
                            {!! Form::text('tel_outro', Session::getOldInput('tel_outro'), array('class' => 'form-control phone')) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-8">
                        <div class="fg-line">
                            {!! Form::label('pessoa[email]', 'E-mail') !!}
                            {!! Form::text('pessoa[email]', Session::getOldInput('pessoa[email]'), array('class' => 'form-control')) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <span>Selecione modalidade de interesse</span>
                    </div>
                    <div class="form-group col-md-4">
                        @foreach($modalidades as $modalidade)
                            <div class="checkbox checkbox-primary checkbox-inline">
                                <input type="checkbox"
                                       @if(isset($model))
                                            @foreach($model['modalidades'] as $mod)
                                                @if($mod['id'] == $modalidade->id) checked="checked" @endif
                                            @endforeach
                                       @endif
                                       name="pre_modalidade_id[]" value="{{ $modalidade->id }}" class="form-control">
                                {!! Form::label('pre_modalidade_id[]', $modalidade->nome, false) !!}
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <span>Selecione materias de interesse</span>
                    </div>
                    <div class="form-group col-md-12">
                        @foreach($materias as $materia)
                            <div class="checkbox checkbox-primary checkbox-inline">
                                <input type="checkbox"
                                       @if(isset($model))
                                            @foreach($model['materias'] as $mat)
                                                @if($mat['id'] == $materia->id) checked="checked" @endif
                                            @endforeach
                                       @endif
                                       name="pre_materia_id[]" value="{{ $materia->id }}" class="form-control">
                                {!! Form::label('pre_materia_id[]', $materia->nome, false) !!}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- FIM aba Pricipais dados -->

            <!-- Tab Endereço -->
            <div role="tabpanel" class="tab-pane" id="endereco">
                <br />
                <div class="row">
                    <div class="col-md-8">
                        <div class="fg-line">
                            {!! Form::label('pessoa[endereco][logradouro]', 'Endereço ') !!}
                            {!! Form::text('pessoa[endereco][logradouro]', Session::getOldInput('pessoa[endereco][logradouro]'), array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="fg-line">
                            {!! Form::label('pessoa[endereco][numero]', 'Número: max 6') !!}
                            {!! Form::text('pessoa[endereco][numero]', Session::getOldInput('pessoa[endereco][numero]'), array('class' => 'form-control numberFive')) !!}
                        </div>
                    </div>
                    <div class="form-group col-md-2">
                        <div class="fg-line">
                            {!! Form::label('pessoa[endereco][complemento]', 'Complemento ') !!}
                            {!! Form::text('pessoa[endereco][complemento]', Session::getOldInput('pessoa[endereco][complemento]'), array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="fg-line">
                            {!! Form::label('pessoa[endereco][cep]', 'CEP ') !!}
                            {!! Form::text('pessoa[endereco][cep]', Session::getOldInput('pessoa[endereco][cep]'), array('class' => 'form-control cep')) !!}
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                        {!! Form::label('estado', 'UF ') !!}
                        @if(isset($model->pessoa->endereco->bairro->cidade->estado->id))
                            {!! Form::select('estado', $loadFields['estado'], $model->pessoa->endereco->bairro->cidade->estado->id, array('class' => 'form-control', 'id' => 'estado')) !!}
                        @else
                            {!! Form::select('estado', $loadFields['estado'], Session::getOldInput('estado'), array('class' => 'form-control', 'id' => 'estado')) !!}
                        @endif
                    </div>
                    <div class="form-group col-md-3">
                        {!! Form::label('cidade', 'Cidade ') !!}
                        @if(isset($model->pessoa->endereco->bairro->cidade->id))
                            {!! Form::select('cidade', array($model->pessoa->endereco->bairro->cidade->id => $model->pessoa->endereco->bairro->cidade->nome), $model->pessoa->endereco->bairro->cidade->id,array('class' => 'form-control', 'id' => 'cidade')) !!}
                        @else
                            {!! Form::select('cidade', array(), Session::getOldInput('cidade'),array('class' => 'form-control', 'id' => 'cidade')) !!}
                        @endif
                    </div>
                    <div class="form-group col-md-4">
                        {!! Form::label('pessoas[endereco][bairros_id]', 'Bairro ') !!}
                        @if(isset($model->pessoa->endereco->bairro->id))
                            {!! Form::select('pessoa[endereco][bairros_id]', array($model->pessoa->endereco->bairro->id => $model->pessoa->endereco->bairro->nome), $model->pessoa->endereco->bairro->id,array('class' => 'form-control', 'id' => 'bairro')) !!}
                        @else
                            {!! Form::select('pessoa[endereco][bairros_id]', array(), null,array('class' => 'form-control', 'id' => 'bairro')) !!}
                        @endif
                    </div>

                </div>
            </div>
            <!-- aba Endereço -->

        </div>
	</div>
</div>
{{--Buttons Submit e Voltar--}}
<div class="row">
    <div class="col-md-9"></div>
    <div class="col-md-3">
        <div class="btn-group btn-group-justified">
            <div class="btn-group">
                <a href="{{ route('seracademico.emais.aluno.index') }}" class="btn btn-primary btn-block"><i class="fa fa-long-arrow-left"></i>  Voltar</a></div>
            <div class="btn-group">
                {!! Form::submit('Salvar', array('class' => 'btn btn-primary btn-block save')) !!}
            </div>
        </div>
    </div>
    {{--Fim Buttons Submit e Voltar--}}
</div>

@section('javascript')
    <script type="text/javascript">

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
                    'table' : 'cidades',
                    'field_search' : 'estados_id',
                    'value_search': estado,
                };

                jQuery.ajax({
                    type: 'POST',
                    url: '{{ route('seracademico.util.search')  }}',
                    data: dados,
                    datatype: 'json',
                    headers: {
                        'X-CSRF-TOKEN' : '{{  csrf_token() }}'
                    },
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

        //Carregando os bairros
        $(document).on('change', "#cidade", function () {
            //Removendo as Bairros
            $('#bairro option').remove();

            //Recuperando a cidade
            var cidade = $(this).val();

            if (cidade !== "") {
                var dados = {
                    'table' : 'bairros',
                    'field_search' : 'cidades_id',
                    'value_search': cidade,
                };

                jQuery.ajax({
                    type: 'POST',
                    url: '{{ route('seracademico.util.search')  }}',
                    headers: {
                        'X-CSRF-TOKEN': '{{  csrf_token() }}'
                    },
                    data: dados,
                    datatype: 'json'
                }).done(function (json) {
                    var option = "";

                    option += '<option value="">Selecione um bairro</option>';
                    for (var i = 0; i < json.length; i++) {
                        option += '<option value="' + json[i]['id'] + '">' + json[i]['nome'] + '</option>';
                    }

                    $('#bairro option').remove();
                    $('#bairro').append(option);
                });
            }
        });

    </script>
@stop