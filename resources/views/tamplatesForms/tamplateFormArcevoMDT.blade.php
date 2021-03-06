<div class="row">
    <div class="col-md-12">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#dados" aria-controls="dados" role="tab" data-toggle="tab">Principais
                    dados</a></li>
            <li role="presentation"><a href="#curso" aria-controls="curso" role="tab" data-toggle="tab">Cursos</a></li>
            <li role="presentation"><a href="#infoAdd" aria-controls="infoAdd" role="tab" data-toggle="tab">Informações
                    adicionais</a></li>
            <li role="presentation"><a href="#autores" aria-controls="autores" role="tab" data-toggle="tab">Autores</a>
            </li>
            <li role="presentation"><a href="#outros" aria-controls="outros" role="tab" data-toggle="tab">Outros
                    reponsáveis</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="dados">
                <br/>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('titulo', 'Título') !!}
                            {!! Form::text('titulo', Session::getOldInput('titulo') , array('class' => 'form-control')) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('subtitulo', 'Subtítulo') !!}
                            {!! Form::textarea('subtitulo', Session::getOldInput('subtitulo') , ['size' => '120x5'], array('class' => 'form-control')) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('assunto', 'Assunto') !!}
                            {!! Form::text('assunto', Session::getOldInput('assunto') , array('class' => 'form-control')) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::label('cutter', 'Cutter') !!}
                            {!! Form::text('cutter', Session::getOldInput('cutter') , array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <button class="btn-sm btn-primary" id="auto-cutter" style="margin-top: 23px; margin-left: -31px;" type="button">Gerar Cutter
                            </button>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            {!! Form::label('cdd', 'CDD') !!}
                            {!! Form::text('cdd', Session::getOldInput('cdd')  , array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            {!! Form::label('outro_cdd', 'Outra opção de CDD') !!}
                            {!! Form::text('outro_cdd', Session::getOldInput('outro_cdd')  , array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            {!! Form::label('tipos_acervos_id', 'Tipo do acervo') !!}
                            {!! Form::select('tipos_acervos_id', (["" => "Selecione o tipo"] + $loadFields['biblioteca\tipoacervo']->toArray()), Session::getOldInput('tipos_acervos_id'), array('class' => 'form-control')) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('situacao_id', 'Situação') !!}
                            {!! Form::select('situacao_id', $loadFields['biblioteca\situacao'], Session::getOldInput('situacao_id'), array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('estante_id', 'Estante') !!}
                            {!! Form::select('estante_id', (["" => "Selecione a estante"] + $loadFields['biblioteca\estante']->toArray()), Session::getOldInput('estante_id'), array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('corredor_id', 'Corredor') !!}
                            {!! Form::select('corredor_id', (["" => "Selecione o corredor"] + $loadFields['biblioteca\corredor']->toArray()), Session::getOldInput('corredor_id'), array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="checkbox checkbox-primary">
                            {!! Form::hidden('uso_global', 0) !!}
                            {!! Form::checkbox('uso_global', 1, null, array('class' => 'form-control')) !!}
                            {!! Form::label('uso_global', 'Este livro serve para todos os cursos?', false) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="checkbox checkbox-primary">
                            {!! Form::hidden('exemplar_ref', 0) !!}
                            {!! Form::hidden('tipo_periodico', 3) !!}
                            {!! Form::checkbox('exemplar_ref', 1, null, array('class' => 'form-control')) !!}
                            {!! Form::label('exemplar_ref', 'Exemplar de referẽncia (Apenas consulta)', false) !!}
                        </div>
                    </div>
                    @if(isset($model->id))
                        <div class="col-md-5">
                            <div class="form-group">
                                {!! Form::label('cdd', 'Número de chamada') !!}
                                {!! Form::text('', $model->numero_chamada  , array('class' => 'form-control', 'readonly' => 'readonly')) !!}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="curso">
                <br />
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('curso-graduacao', 'Graduação/Tecnólogo') !!}
                            @if(isset($model->id))
                                <select class="form-control cursos" multiple="multiple" name="cursos[]" id="curso-graduacao">
                                    @foreach($cursos['graduacao'] as $value)
                                        <option value="{{ $value->id }}"
                                                @foreach($model->cursos->lists('id') as $c) @if($value->id == $c) selected="selected" @endif @endforeach>{{$value->nome}}</option>
                                    @endforeach
                                </select>
                            @else
                                <select class="form-control cursos" name="cursos[]" multiple id="curso-graduacao">
                                    @foreach($cursos['graduacao'] as $value)
                                        <option value="{{ $value->id }}">{{ $value->nome }}</option>
                                    @endforeach
                                </select>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('curso-posgraduacao', 'Pós-Graduação/Curso Extensão') !!}
                            @if(isset($model->id))
                                <select class="form-control cursos" multiple="multiple" name="cursos[]" id="curso-posgraduacao">
                                    @foreach($cursos['pos'] as $value)
                                        <option value="{{ $value->id }}"
                                                @foreach($model->cursos->lists('id') as $c) @if($value->id == $c) selected="selected" @endif @endforeach>{{$value->nome}}</option>
                                    @endforeach
                                </select>
                            @else
                                <select class="form-control cursos" name="cursos[]" multiple id="curso-posgraduacao">
                                    @foreach($cursos['pos'] as $value)
                                        <option value="{{ $value->id }}">{{ $value->nome }}</option>
                                    @endforeach
                                </select>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('curso-mestrado', 'Mestrado') !!}
                            @if(isset($model->id))
                                <select class="form-control cursos" multiple="multiple" name="cursos[]" id="curso-mestrado">
                                    @foreach($cursos['mestrado'] as $value)
                                        <option value="{{ $value->id }}"
                                                @foreach($model->cursos->lists('id') as $c) @if($value->id == $c) selected="selected" @endif @endforeach>{{$value->nome}}</option>
                                    @endforeach
                                </select>
                            @else
                                <select class="form-control cursos" name="cursos[]" multiple id="curso-mestrado">
                                    @foreach($cursos['mestrado'] as $value)
                                        <option value="{{ $value->id }}">{{ $value->nome }}</option>
                                    @endforeach
                                </select>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="infoAdd">
                <br/>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('obs_geral', 'Observação Geral') !!}
                            {!! Form::textarea('obs_geral', Session::getOldInput('obs_geral')  , array('class' => 'form-control', 'rows' => '5')) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('palavras_chaves', 'Palavras chave') !!}
                            {!! Form::textarea('palavras_chaves', Session::getOldInput('palavras_chaves') , array('class' => 'form-control', 'rows' => '5')) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('resumo', 'Notas') !!}
                            {!! Form::textarea('resumo', Session::getOldInput('resumo') , array('class' => 'form-control', 'rows' => '5')) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('sumario', 'Sumário') !!}
                            {!! Form::textarea('sumario', Session::getOldInput('sumario'), array('class' => 'form-control', 'rows' => '5')) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="autores">
                <br/>

                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            {!! Form::label('primeira[responsaveis_id]', 'Autor 1') !!}
                            @if(isset($primeiraEntrada[0]))
                                {!! Form::select('primeira[responsaveis_id][]', (["" => "Selecione o responsável"] + $loadFields['biblioteca\responsavel']->toArray()), $primeiraEntrada[0]->responsaveis_id, array('class' => 'form-control', "id" => 'autor-1')) !!}
                                <input type="hidden" name="primeira[id][]" value="{{$primeiraEntrada[0]->id}}">
                            @else
                                {!! Form::select('primeira[responsaveis_id][]', (["" => "Selecione o responsável"] + $loadFields['biblioteca\responsavel']->toArray()), null, array('class' => 'form-control', "id" => 'autor-1')) !!}
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            {!! Form::label('primeira[responsaveis_id]', 'Autor 2') !!}
                            @if(isset($primeiraEntrada[1]))
                                {!! Form::select('primeira[responsaveis_id][]', (["" => "Selecione o responsável"] + $loadFields['biblioteca\responsavel']->toArray()), $primeiraEntrada[1]->responsaveis_id, array('class' => 'form-control', "id" => 'autor-2')) !!}
                                <input type="hidden" name="primeira[id][]" value="{{$primeiraEntrada[1]->id}}">
                            @else
                                {!! Form::select('primeira[responsaveis_id][]', (["" => "Selecione o responsável"] + $loadFields['biblioteca\responsavel']->toArray()), NULL, array('class' => 'form-control', "id" => 'autor-2')) !!}
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            {!! Form::label('primeira[responsaveis_id]', 'Autor 3') !!}
                            @if(isset($primeiraEntrada[2]))
                                {!! Form::select('primeira[responsaveis_id][]', (["" => "Selecione o responsável"] + $loadFields['biblioteca\responsavel']->toArray()), $primeiraEntrada[2]->responsaveis_id, array('class' => 'form-control', "id" => 'autor-3')) !!}
                                <input type="hidden" name="primeira[id][]" value="{{$primeiraEntrada[2]->id}}">
                            @else
                                {!! Form::select('primeira[responsaveis_id][]', (["" => "Selecione o responsável"] + $loadFields['biblioteca\responsavel']->toArray()), NULL, array('class' => 'form-control', "id" => 'autor-3')) !!}
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-1">
                        <div class="checkbox checkbox-primary">
                            {!! Form::hidden('etial_autor', 0) !!}
                            {!! Form::checkbox('etial_autor', 1, null, array('class' => 'form-control')) !!}
                            {!! Form::label('etial_autor', 'et al', false) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-1">
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">
                            Novo Responsável
                        </button>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="outros">
                <br/>

                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            {!! Form::label('segunda[responsaveis_id]', 'Responsável 1') !!}
                            @if(isset($segundaEntrada[0]))
                                {!! Form::select('segunda[responsaveis_id][]', (["" => "Selecione o responsável"] + $loadFields['biblioteca\responsavel']->toArray()), $segundaEntrada[0]->responsaveis_id, array('class' => 'form-control', "id" => 'responsavel-1')) !!}
                                <input type="hidden" name="segunda[id][]" value="{{$segundaEntrada[0]->id}}">
                            @else
                                {!! Form::select('segunda[responsaveis_id][]', (["" => "Selecione o responsável"] + $loadFields['biblioteca\responsavel']->toArray()), NULL, array('class' => 'form-control', "id" => 'responsavel-1')) !!}
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::label('segunda[tipo_autor_id]', 'Tipo reponsável') !!}
                            @if(isset($segundaEntrada[0]))
                                {!! Form::select('segunda[tipo_autor_id][]', (["" => "Selecione o tipo"] + $loadFields['biblioteca\tipoautor']->toArray()), $segundaEntrada[0]->tipo_autor_id, array('class' => 'form-control')) !!}
                            @else
                                {!! Form::select('segunda[tipo_autor_id][]', (["" => "Selecione o tipo"] + $loadFields['biblioteca\tipoautor']->toArray()), NULL, array('class' => 'form-control')) !!}
                            @endif
                        </div>
                    </div>
                    <div class="col-md-2" style="margin-top: 15px">
                        <div class="checkbox checkbox-primary">
                            {!! Form::hidden('segunda[para_referencia1]', 0) !!}
                            @if(isset($segundaEntrada[0]) && $segundaEntrada[0]->para_referencia1 == '1')
                                {!! Form::checkbox('segunda[para_referencia1]', 1, null, array('class' => 'form-control', 'checked' => 'checked')) !!}
                            @else
                                {!! Form::checkbox('segunda[para_referencia1]', 1, null, array('class' => 'form-control')) !!}
                            @endif
                            {!! Form::label('para_referencia1', 'Para referência?', false) !!}
                        </div>
                    </div>
                    <div class="col-md-2" style="margin-top: 15px">
                        <div class="checkbox checkbox-primary">
                            {!! Form::hidden('segunda[exibir_tipo1]', 0) !!}
                            @if(isset($segundaEntrada[0]) && $segundaEntrada[0]->exibir_tipo1 == '1')
                                {!! Form::checkbox('segunda[exibir_tipo1]', 1, null, array('class' => 'form-control', 'checked' => 'checked')) !!}
                            @else
                                {!! Form::checkbox('segunda[exibir_tipo1]', 1, null, array('class' => 'form-control')) !!}
                            @endif
                            {!! Form::label('exibir_tipo1', 'Exibir Tipo?', false) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            {!! Form::label('segunda[responsaveis_id]', 'Responsável 2') !!}
                            @if(isset($segundaEntrada[1]))
                                {!! Form::select('segunda[responsaveis_id][]', (["" => "Selecione o responsável"] + $loadFields['biblioteca\responsavel']->toArray()), $segundaEntrada[1]->responsaveis_id, array('class' => 'form-control', "id" => 'responsavel-2')) !!}
                                <input type="hidden" name="segunda[id][]" value="{{$segundaEntrada[1]->id}}">
                            @else
                                {!! Form::select('segunda[responsaveis_id][]', (["" => "Selecione o responsável"] + $loadFields['biblioteca\responsavel']->toArray()), NULL, array('class' => 'form-control', "id" => 'responsavel-2')) !!}
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::label('segunda[tipo_autor_id]', 'Tipo reponsável') !!}
                            @if(isset($segundaEntrada[1]))
                                {!! Form::select('segunda[tipo_autor_id][]', (["" => "Selecione o tipo"] + $loadFields['biblioteca\tipoautor']->toArray()), $segundaEntrada[1]->tipo_autor_id, array('class' => 'form-control')) !!}
                            @else
                                {!! Form::select('segunda[tipo_autor_id][]', (["" => "Selecione o tipo"] + $loadFields['biblioteca\tipoautor']->toArray()), NULL, array('class' => 'form-control')) !!}
                            @endif
                        </div>
                    </div>
                    <div class="col-md-2" style="margin-top: 15px">
                        <div class="checkbox checkbox-primary">
                            {!! Form::hidden('segunda[para_referencia2]', 0) !!}
                            @if(isset($segundaEntrada[1]) && $segundaEntrada[1]->para_referencia2 == '1')
                                {!! Form::checkbox('segunda[para_referencia2]', 1, null, array('class' => 'form-control', 'checked' => 'checked')) !!}
                            @else
                                {!! Form::checkbox('segunda[para_referencia2]', 1, null, array('class' => 'form-control')) !!}
                            @endif
                            {!! Form::label('para_referencia2', 'Para referência?', false) !!}
                        </div>
                    </div>
                    <div class="col-md-2" style="margin-top: 15px">
                        <div class="checkbox checkbox-primary">
                            {!! Form::hidden('segunda[exibir_tipo2]', 0) !!}
                            @if(isset($segundaEntrada[1]) && $segundaEntrada[1]->exibir_tipo2 == '1')
                                {!! Form::checkbox('segunda[exibir_tipo2]', 1, null, array('class' => 'form-control', 'checked' => 'checked')) !!}
                            @else
                                {!! Form::checkbox('segunda[exibir_tipo2]', 1, null, array('class' => 'form-control')) !!}
                            @endif
                            {!! Form::label('exibir_tipo2', 'Exibir Tipo?', false) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            {!! Form::label('segunda[responsaveis_id]', 'Responsável 3') !!}
                            @if(isset($segundaEntrada[2]))
                                {!! Form::select('segunda[responsaveis_id][]', (["" => "Selecione o responsável"] + $loadFields['biblioteca\responsavel']->toArray()), $segundaEntrada[2]->responsaveis_id, array('class' => 'form-control', "id" => 'responsavel-3')) !!}
                                <input type="hidden" name="segunda[id][]" value="{{$segundaEntrada[2]->id}}">
                            @else
                                {!! Form::select('segunda[responsaveis_id][]', (["" => "Selecione o responsável"] + $loadFields['biblioteca\responsavel']->toArray()), NULL, array('class' => 'form-control', "id" => 'responsavel-3')) !!}
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::label('segunda[tipo_autor_id]', 'Tipo reponsável') !!}
                            @if(isset($segundaEntrada[2]))
                                {!! Form::select('segunda[tipo_autor_id][]', (["" => "Selecione o tipo"] + $loadFields['biblioteca\tipoautor']->toArray()), $segundaEntrada[2]->tipo_autor_id, array('class' => 'form-control')) !!}
                            @else
                                {!! Form::select('segunda[tipo_autor_id][]', (["" => "Selecione o tipo"] + $loadFields['biblioteca\tipoautor']->toArray()), NULL, array('class' => 'form-control')) !!}
                            @endif
                        </div>
                    </div>
                    <div class="col-md-2" style="margin-top: 15px">
                        <div class="checkbox checkbox-primary">
                            {!! Form::hidden('segunda[para_referencia3]', 0) !!}
                            @if(isset($segundaEntrada[2]) && $segundaEntrada[2]->para_referencia3 == '1')
                                {!! Form::checkbox('segunda[para_referencia3]', 1, null, array('class' => 'form-control', 'checked' => 'checked')) !!}
                            @else
                                {!! Form::checkbox('segunda[para_referencia3]', 1, null, array('class' => 'form-control')) !!}
                            @endif
                            {!! Form::label('para_referencia3', 'Para referência?', false) !!}
                        </div>
                    </div>
                    <div class="col-md-2" style="margin-top: 15px">
                        <div class="checkbox checkbox-primary">
                            {!! Form::hidden('segunda[exibir_tipo3]', 0) !!}
                            @if(isset($segundaEntrada[2]) && $segundaEntrada[2]->exibir_tipo3 == '1')
                                {!! Form::checkbox('segunda[exibir_tipo3]', 1, null, array('class' => 'form-control', 'checked' => 'checked')) !!}
                            @else
                                {!! Form::checkbox('segunda[exibir_tipo3]', 1, null, array('class' => 'form-control')) !!}
                            @endif
                            {!! Form::label('exibir_tipo3', 'Exibir Tipo?', false) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-1">
                        <div class="checkbox checkbox-primary">
                            {!! Form::hidden('etial_outros', 0) !!}
                            {!! Form::checkbox('etial_outros', 1, null, array('class' => 'form-control')) !!}
                            {!! Form::label('etial_outros', 'et al', false) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-1">
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">
                            Novo Responsável
                        </button>
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
                    <a href="{{ route('seracademico.biblioteca.indexAcervoMonoDiTe') }}" class="btn btn-primary btn-block"><i
                                class="fa fa-long-arrow-left"></i> Voltar</a></div>
                <div class="btn-group">
                    {!! Form::submit('Salvar', array('class' => 'btn btn-primary btn-block')) !!}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Cadastrar Responsável</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                {!! Form::label('nome', 'Nome') !!}
                                {!! Form::text('nome', Session::getOldInput('nome')  , array('class' => 'form-control', 'id' => 'nome')) !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('sobrenome', 'Último Sobrenome') !!}
                                {!! Form::text('sobrenome', Session::getOldInput('sobrenome')  , array('class' => 'form-control', 'id' => 'sobrenome')) !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('tipo_reponsavel_id', 'Tipo do responsável') !!}
                                {!! Form::select('tipo_reponsavel_id', (["" => "Selecione o tipo"] + $loadFields['biblioteca\tiporesponsavel']->toArray()), Session::getOldInput('corredor_id'), array('class' => 'form-control', 'id' => 'tipo_reponsavel_id')) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="save" class="btn btn-primary">Salvar</button>
                </div>
            </div>
        </div>
    </div>
</div>

@section('javascript')
    <script type="text/javascript" src="{{asset('/js/validacoes/biblioteca/validation_form_acervo.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/biblioteca/acervoNPeriodico/script_crud.js')}}"></script>
@stop