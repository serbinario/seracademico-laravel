<div class="row">
    <div class="col-md-12">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#dados" aria-controls="dados" role="tab" data-toggle="tab">Principais
                    dados</a></li>
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

                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('subtitulo', 'Subtítulo') !!}
                            {!! Form::text('subtitulo', Session::getOldInput('subtitulo') , array('class' => 'form-control')) !!}
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
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('volume', 'Volume') !!}
                            {!! Form::text('volume', Session::getOldInput('volume') , array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('cutter', 'Cutter') !!}
                            {!! Form::text('cutter', Session::getOldInput('cutter') , array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('cdd', 'CDD') !!}
                            {!! Form::text('cdd', Session::getOldInput('cdd')  , array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('tipos_acervos_id', 'Tipo do acervo') !!}
                            {!! Form::select('tipos_acervos_id', (["" => "Selecione o tipo"] + $loadFields['tipoacervo']->toArray()), Session::getOldInput('tipos_acervos_id'), array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('colecao_id', 'Coleção') !!}
                            {!! Form::select('colecao_id', (["" => "Selecione a coleção"] + $loadFields['colecao']->toArray()), Session::getOldInput('colecao_id'), array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('genero_id', 'Genero') !!}
                            {!! Form::select('genero_id', (["" => "Selecione o genero"] + $loadFields['genero']->toArray()), Session::getOldInput('genero_id'), array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('situacao_id', 'Situação') !!}
                            {!! Form::select('situacao_id', $loadFields['situacao'], Session::getOldInput('situacao_id'), array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('estante_id', 'Estante') !!}
                            {!! Form::select('estante_id', (["" => "Selecione a estante"] + $loadFields['estante']->toArray()), Session::getOldInput('estante_id'), array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('corredor_id', 'Corredor') !!}
                            {!! Form::select('corredor_id', (["" => "Selecione o corredor"] + $loadFields['corredor']->toArray()), Session::getOldInput('corredor_id'), array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('cursos', 'Cursos') !!}
                            {{--{{dd($model->cursos->lists('id')->all())}}--}}
                            @if(isset($model->id))
                                <select class="form-control" multiple="multiple" name="cursos[]" id="cursos">
                                    @foreach($loadFields['curso'] as $key => $value)
                                        <option value="{{$key}}"
                                                @foreach($model->cursos->lists('id') as $c) @if($key == $c)selected="selected"@endif @endforeach>{{$value}}</option>
                                    @endforeach
                                </select>
                            @else
                                {!! Form::select('cursos[]', $loadFields['curso'], null, ['id' => 'cursos', 'multiple' => 'multiple', 'class' => 'form-control']) !!}
                            @endif
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
                            {!! Form::hidden('tipo_periodico', 1) !!}
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
            <div role="tabpanel" class="tab-pane" id="infoAdd">
                <br/>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('obs_geral', 'Observação Geral') !!}
                            {!! Form::textarea('obs_geral', Session::getOldInput('obs_geral')  ,['size' => '55x5'] , array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('palavras_chaves', 'Palavras chave') !!}
                            {!! Form::textarea('palavras_chaves', Session::getOldInput('palavras_chaves')  ,['size' => '55x5'] , array('class' => 'form-control')) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10">
                        <div class="form-group">
                            {!! Form::label('resumo', 'Notas') !!}
                            {!! Form::textarea('resumo', Session::getOldInput('resumo')  ,['size' => '117x6'] , array('class' => 'form-control')) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10">
                        <div class="form-group">
                            {!! Form::label('sumario', 'Sumário') !!}
                            {!! Form::textarea('sumario', Session::getOldInput('sumario')  ,['size' => '117x6'] , array('class' => 'form-control')) !!}
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
                                {!! Form::select('primeira[responsaveis_id][]', (["" => "Selecione o responsável"] + $loadFields['responsavel']->toArray()), $primeiraEntrada[0]->responsaveis_id, array('class' => 'form-control', "id" => 'autor-1')) !!}
                                <input type="hidden" name="primeira[id][]" value="{{$primeiraEntrada[0]->id}}">
                            @else
                                {!! Form::select('primeira[responsaveis_id][]', (["" => "Selecione o responsável"] + $loadFields['responsavel']->toArray()), array(" " => 'teste'), array('class' => 'form-control', "id" => 'autor-1')) !!}
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            {!! Form::label('primeira[responsaveis_id]', 'Autor 2') !!}
                            @if(isset($primeiraEntrada[1]))
                                {!! Form::select('primeira[responsaveis_id][]', (["" => "Selecione o responsável"] + $loadFields['responsavel']->toArray()), $primeiraEntrada[1]->responsaveis_id, array('class' => 'form-control', "id" => 'autor-2')) !!}
                                <input type="hidden" name="primeira[id][]" value="{{$primeiraEntrada[1]->id}}">
                            @else
                                {!! Form::select('primeira[responsaveis_id][]', (["" => "Selecione o responsável"] + $loadFields['responsavel']->toArray()), NULL, array('class' => 'form-control', "id" => 'autor-2')) !!}
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            {!! Form::label('primeira[responsaveis_id]', 'Autor 3') !!}
                            @if(isset($primeiraEntrada[2]))
                                {!! Form::select('primeira[responsaveis_id][]', (["" => "Selecione o responsável"] + $loadFields['responsavel']->toArray()), $primeiraEntrada[2]->responsaveis_id, array('class' => 'form-control', "id" => 'autor-3')) !!}
                                <input type="hidden" name="primeira[id][]" value="{{$primeiraEntrada[2]->id}}">
                            @else
                                {!! Form::select('primeira[responsaveis_id][]', (["" => "Selecione o responsável"] + $loadFields['responsavel']->toArray()), NULL, array('class' => 'form-control', "id" => 'autor-3')) !!}
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-1">
                        <div class="checkbox checkbox-primary">
                            {!! Form::hidden('etial_autor', 0) !!}
                            {!! Form::checkbox('etial_autor', 1, null, array('class' => 'form-control')) !!}
                            {!! Form::label('etial_autor', 'Etal', false) !!}
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
                                {!! Form::select('segunda[responsaveis_id][]', (["" => "Selecione o responsável"] + $loadFields['responsavel']->toArray()), $segundaEntrada[0]->responsaveis_id, array('class' => 'form-control', "id" => 'responsavel-1')) !!}
                                <input type="hidden" name="segunda[id][]" value="{{$segundaEntrada[0]->id}}">
                            @else
                                {!! Form::select('segunda[responsaveis_id][]', (["" => "Selecione o responsável"] + $loadFields['responsavel']->toArray()), NULL, array('class' => 'form-control', "id" => 'responsavel-1')) !!}
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('segunda[tipo_autor_id]', 'Tipo reponsável') !!}
                            @if(isset($segundaEntrada[0]))
                                {!! Form::select('segunda[tipo_autor_id][]', (["" => "Selecione o tipo"] + $loadFields['tipoautor']->toArray()), $segundaEntrada[0]->tipo_autor_id, array('class' => 'form-control')) !!}
                            @else
                                {!! Form::select('segunda[tipo_autor_id][]', (["" => "Selecione o tipo"] + $loadFields['tipoautor']->toArray()), NULL, array('class' => 'form-control')) !!}
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            {!! Form::label('segunda[responsaveis_id]', 'Responsável 2') !!}
                            @if(isset($segundaEntrada[1]))
                                {!! Form::select('segunda[responsaveis_id][]', (["" => "Selecione o responsável"] + $loadFields['responsavel']->toArray()), $segundaEntrada[1]->responsaveis_id, array('class' => 'form-control', "id" => 'responsavel-2')) !!}
                                <input type="hidden" name="segunda[id][]" value="{{$segundaEntrada[1]->id}}">
                            @else
                                {!! Form::select('segunda[responsaveis_id][]', (["" => "Selecione o responsável"] + $loadFields['responsavel']->toArray()), NULL, array('class' => 'form-control', "id" => 'responsavel-2')) !!}
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('segunda[tipo_autor_id]', 'Tipo reponsável') !!}
                            @if(isset($segundaEntrada[1]))
                                {!! Form::select('segunda[tipo_autor_id][]', (["" => "Selecione o tipo"] + $loadFields['tipoautor']->toArray()), $segundaEntrada[1]->tipo_autor_id, array('class' => 'form-control')) !!}
                            @else
                                {!! Form::select('segunda[tipo_autor_id][]', (["" => "Selecione o tipo"] + $loadFields['tipoautor']->toArray()), NULL, array('class' => 'form-control')) !!}
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            {!! Form::label('segunda[responsaveis_id]', 'Responsável 3') !!}
                            @if(isset($segundaEntrada[2]))
                                {!! Form::select('segunda[responsaveis_id][]', (["" => "Selecione o responsável"] + $loadFields['responsavel']->toArray()), $segundaEntrada[2]->responsaveis_id, array('class' => 'form-control', "id" => 'responsavel-3')) !!}
                                <input type="hidden" name="segunda[id][]" value="{{$segundaEntrada[2]->id}}">
                            @else
                                {!! Form::select('segunda[responsaveis_id][]', (["" => "Selecione o responsável"] + $loadFields['responsavel']->toArray()), NULL, array('class' => 'form-control', "id" => 'responsavel-3')) !!}
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('segunda[tipo_autor_id]', 'Tipo reponsável') !!}
                            @if(isset($segundaEntrada[2]))
                                {!! Form::select('segunda[tipo_autor_id][]', (["" => "Selecione o tipo"] + $loadFields['tipoautor']->toArray()), $segundaEntrada[2]->tipo_autor_id, array('class' => 'form-control')) !!}
                            @else
                                {!! Form::select('segunda[tipo_autor_id][]', (["" => "Selecione o tipo"] + $loadFields['tipoautor']->toArray()), NULL, array('class' => 'form-control')) !!}
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-1">
                        <div class="checkbox checkbox-primary">
                            {!! Form::hidden('etial_outros', 0) !!}
                            {!! Form::checkbox('etial_outros', 1, null, array('class' => 'form-control')) !!}
                            {!! Form::label('etial_outros', 'Etal', false) !!}
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
                    <a href="{{ route('seracademico.biblioteca.indexAcervo') }}" class="btn btn-primary btn-block"><i
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
                                {!! Form::text('nome', Session::getOldInput('nome')  , array('class' => 'form-control', 'onkeyup' => 'maiuscula("nome")', 'id' => 'nome')) !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('sobrenome', 'Último Sobrenome') !!}
                                {!! Form::text('sobrenome', Session::getOldInput('sobrenome')  , array('class' => 'form-control', 'id' => 'sobrenome')) !!}
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