<div class="row">
	<div class="col-md-12">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#dado" aria-controls="dado" role="tab" data-toggle="tab">Dados Principais</a></li>
                <li role="presentation"><a href="#outros" aria-controls="outros" role="tab" data-toggle="tab">Informação adicional</a></li>
                <li role="presentation"><a href="#aquisicao" aria-controls="aquisicao" role="tab" data-toggle="tab">Aquisição</a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="dado">
                    <br />
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                {!! Form::label('arcevos_id', 'Obra *') !!}
                                {!! Form::select('arcevos_id', $acervo['arcevo'], Session::getOldInput('arcevos_id'), array('class' => 'form-control', "id" => 'obra')) !!}
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                {!! Form::label('ano', 'Ano') !!}
                                {!! Form::text('ano', Session::getOldInput('ano'), array('class' => 'form-control date')) !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                {!! Form::label('editoras_id', 'Editora') !!}
                                {!! Form::select('editoras_id', $loadFields['editora'], Session::getOldInput('editoras_id'), array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                {!! Form::label('isbn', 'ISBN') !!}
                                {!! Form::text('isbn', Session::getOldInput('isbn')  , array('class' => 'form-control')) !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                {!! Form::label('edicao', 'Edição') !!}
                                {!! Form::text('edicao', Session::getOldInput('edicao')  , array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('editor', 'Editor') !!}
                                {!! Form::text('editor', Session::getOldInput('editor')  , array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('local', 'Local') !!}
                                {!! Form::text('local', Session::getOldInput('local')  , array('class' => 'form-control')) !!}
                            </div>
                        </div>

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

                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('codigo_barra', 'Código de barras') !!}
                                {!! Form::text('codigo_barra', Session::getOldInput('codigo_barra')  , array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        @if(!isset($model->id))
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('registros', 'Quantidade de Exemplares (Registros)') !!}
                                    {!! Form::text('registros', Session::getOldInput('registros')  , array('class' => 'form-control')) !!}
                                </div>
                            </div>
                        @endif
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
                    <br />
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
                                {!! Form::text('numero_pag', Session::getOldInput('numero_pag')  , array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('obs_especifica', 'Observação específica') !!}
                                {!! Form::textarea('obs_especifica', Session::getOldInput('obs_especifica')  ,['size' => '50x5'] , array('class' => 'form-control')) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <!-- FIM Aba Outros -->

                <!-- Aba Aquisição -->
                <div role="tabpanel" class="tab-pane" id="aquisicao">
                    <br />
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
                                {!! Form::text('data_aquisicao', Session::getOldInput('data_aquisicao'), array('class' => 'form-control datepicker date')) !!}
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
{{--Buttons Submit e Voltar--}}
<div class="row">
    <div class="col-md-9"></div>
    <div class="col-md-3">
        <div class="btn-group btn-group-justified">
            <div class="btn-group">
                <a href="{{ route('seracademico.biblioteca.indexExemplar') }}" class="btn btn-primary btn-block"><i class="fa fa-long-arrow-left"></i>  Voltar</a></div>
            <div class="btn-group">
                {!! Form::submit('Salvar', array('class' => 'btn btn-primary btn-block')) !!}
            </div>
        </div>
    </div>
    {{--Fim Buttons Submit e Voltar--}}
</div>