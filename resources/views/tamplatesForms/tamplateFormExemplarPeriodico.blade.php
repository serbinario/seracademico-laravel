<div class="row">
    <div class="col-md-12">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#dado" aria-controls="dado" role="tab" data-toggle="tab">Dados Principais</a></li>
            <li role="presentation"><a href="#publicacao" aria-controls="outros" role="tab" data-toggle="tab">Publicação</a></li>
            <li role="presentation"><a href="#outros" aria-controls="outros" role="tab" data-toggle="tab">Informação adicional</a></li>
            <li role="presentation"><a href="#aquisicao" aria-controls="aquisicao" role="tab" data-toggle="tab">Aquisição</a>
            </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="dado">
                <br/>

                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            {!! Form::label('arcevos_id', 'Obra *') !!}
                            {!! Form::select('arcevos_id',(["" => "Selecione uma obra"] + $acervo['arcevo']->toArray()), Session::getOldInput('arcevos_id'), array('class' => 'form-control', "id" => 'obra')) !!}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            {!! Form::label('issn', 'ISSN') !!}
                            {!! Form::text('issn', Session::getOldInput('issn')  , array('class' => 'form-control')) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('assunto_p', 'Assunto') !!}
                            {!! Form::text('assunto_p', Session::getOldInput('assunto_p')  , array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('link', 'Link de acesso') !!}
                            {!! Form::text('link', Session::getOldInput('link'), array('class' => 'form-control')) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::label('codigo_barra', 'Código de barras') !!}
                            {!! Form::text('codigo_barra', Session::getOldInput('codigo_barra')  , array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    @if(!isset($model->id))
                        <div class="col-md-3">
                            <div class="form-group">
                                {!! Form::label('registros', 'Quantidade de Exemplares (Registros)') !!}
                                {!! Form::text('registros', Session::getOldInput('registros')  , array('class' => 'form-control numberFor')) !!}
                            </div>
                        </div>
                    @endif
                    @if(isset($model->id))
                        <?php
                            $codigo = substr($model->codigo, 0, -4);
                            $ano    = substr($model->codigo, -4);
                        ?>
                        <div class="col-md-3">
                            <div class="form-group">
                                {!! Form::label('codigo', 'Tombo') !!}
                                {!! Form::text('codigo', $codigo  , array('class' => 'form-control')) !!}
                                <input type="hidden" name="ano_tombo" value="{{$ano}}">
                            </div>
                        </div>
                    @endif

                    <div class="col-md-2">
                        <div class="form-group">
                            {!! Form::label('emprestimo_id', 'Emprestimo') !!}
                            {!! Form::select('emprestimo_id', $loadFields['emprestimo'], Session::getOldInput('emprestimo_id'), array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            {!! Form::label('situacao_id', 'Situação') !!}
                            {!! Form::select('situacao_id', $loadFields['situacao'], Session::getOldInput('situacao_id'), array('class' => 'form-control')) !!}
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="btn-group">
                            <div class="btn-group">
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">
                                    Nova Editora
                                </button>
                            </div>
                        </div>
                    </div>
                    {{--<div class="col-md-2">
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 135px; height: 115px;">
                                @if (isset($model) && $model->path_image != null)
                                    <div id="midias">
                                        <img id="logo" src="/images/{{$model->path_image}}"  alt="Foto" height="120" width="100"/><br/>
                                    </div>
                                @endif
                            </div>
                            <div>
                                 <span class="btn btn-primary btn-xs btn-block btn-file">
                                     <span class="fileinput-new">Selecionar</span>
                                     <span class="fileinput-exists">Mudar</span>
                                     <input type="file" name="img">
                                 </span>
                                <a href="#" class="btn btn-warning btn-xs fileinput-exists col-md-6" data-dismiss="fileinput">Remover</a>
                            </div>
                        </div>
                    </div>--}}
                </div>
            </div>

            <!-- Aba Outros -->
            <div role="tabpanel" class="tab-pane" id="outros">
                <br/>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('ilustracoes_id', 'Ilustração') !!}
                            {!! Form::select('ilustracoes_id', $loadFields['ilustracao'], Session::getOldInput('ilustracoes_id'), array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('idiomas_id', 'Idioma') !!}
                            {!! Form::select('idiomas_id', $loadFields['idioma'], Session::getOldInput('idiomas_id'), array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('numero_pag', 'Número de páginas') !!}
                            {!! Form::text('numero_pag', Session::getOldInput('numero_pag')  , array('class' => 'form-control numberFor')) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('artigos', 'Artigos') !!}
                            {!! Form::textarea('artigos', Session::getOldInput('artigos')  ,['size' => '90x5'] , array('class' => 'form-control')) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('palavras_chaves', 'Palavras chaves') !!}
                            {!! Form::textarea('palavras_chaves', Session::getOldInput('palavras_chaves')  ,['size' => '90x5'] , array('class' => 'form-control')) !!}
                        </div>
                    </div>
                </div>
            </div>
            <!-- FIM Aba Outros -->

            <!-- Aba Publicacao -->
            <div role="tabpanel" class="tab-pane" id="publicacao">
                <br/>

                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            {!! Form::label('ano', 'Ano') !!}
                            {!! Form::text('ano', Session::getOldInput('ano'), array('class' => 'form-control numberFor')) !!}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            {!! Form::label('vol_periodico', 'Volume') !!}
                            {!! Form::text('vol_periodico', Session::getOldInput('vol_periodico')  , array('class' => 'form-control numberFive')) !!}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            {!! Form::label('edicao', 'Número do Periódico') !!}
                            {!! Form::text('edicao', Session::getOldInput('edicao')  , array('class' => 'form-control numberFive')) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('editoras_id', 'Editora') !!}
                            {!! Form::select('editoras_id',(["" => "Selecione uma editora"] + $loadFields['editora']->toArray()), Session::getOldInput('editoras_id'), array('class' => 'form-control', "id" => 'editora')) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('local', 'Local') !!}
                            {!! Form::text('local', Session::getOldInput('local')  , array('class' => 'form-control')) !!}
                        </div>
                    </div>
                </div>
            </div>
            <!-- FIM Aba Publicacao -->

            <!-- Aba Aquisição -->
            <div role="tabpanel" class="tab-pane" id="aquisicao">
                <br/>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            {!! Form::label('aquisicao_id', 'Aquisição') !!}
                            {!! Form::select('aquisicao_id', $loadFields['aquisicao'], Session::getOldInput('aquisicao_id'), array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            {!! Form::label('data_aquisicao', 'Data Aquisição') !!}
                            {!! Form::text('data_aquisicao', Session::getOldInput('data_aquisicao'), array('class' => 'form-control datepicker date data2')) !!}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            {!! Form::label('valor', 'Valor') !!}
                            {!! Form::text('valor', Session::getOldInput('valor')  , array('class' => 'form-control')) !!}
                        </div>
                    </div>
                </div>
            </div>
            <!-- FIM Aba Aquisição -->
        </div>
    </div>
</div>
<div class="row">
    <!-- Modal editora -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Cadastrar Editora</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                {!! Form::label('nome', 'Nome') !!}
                                {!! Form::text('nome', Session::getOldInput('nome')  , array('class' => 'form-control' , 'id' => 'nome')) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="save" class="btn btn-primary save">Salvar</button>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- Buttons Submit e Voltar --}}
<div class="row">
    <div class="col-md-9"></div>
    <div class="col-md-3">
        <div class="btn-group btn-group-justified">
            <div class="btn-group">
                <a href="{{ route('seracademico.biblioteca.indexExemplarP') }}" class="btn btn-primary btn-block"><i
                            class="fa fa-long-arrow-left"></i> Voltar</a>
            </div>
            <div class="btn-group">
                {!! Form::submit('Salvar', array('class' => 'btn btn-primary btn-block')) !!}
            </div>
        </div>
    </div>
    {{--Fim Buttons Submit e Voltar--}}
</div>
