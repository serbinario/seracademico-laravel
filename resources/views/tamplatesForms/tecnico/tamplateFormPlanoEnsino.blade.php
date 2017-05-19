<div class="row">
	<div class="col-md-12">

        <div class="row">
            <div class="col-md-10">
                <div class="form-group">
                    {!! Form::label('nome', 'Nome') !!}
					{!! Form::text('nome', Session::getOldInput('nome')  , array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('vigencia', 'Vigência') !!}
                    {!! Form::text('vigencia', Session::getOldInput('vigencia') , array('class' => 'form-control date datepicker')) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
					{!! Form::label('disciplina_id', 'Disciplina') !!}
					{!! Form::select('disciplina_id', (['' => 'Selecione uma disciplina'] + $loadFields['tecnico\\disciplina']->toArray()), NULL, array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('carga_horaria', 'CH') !!}
					{!! Form::text('carga_horaria', Session::getOldInput('carga_horaria')  , array('class' => 'form-control')) !!}
                </div>
            </div>

            <div class="form-group col-md-1">
                <div class="checkbox checkbox-primary">
                    {!! Form::hidden('ativo', 0) !!}
                    {!! Form::checkbox('ativo', 1, null, array('class' => 'form-control', 'id'=>'ativo')) !!}
                    {!! Form::label('ativo', 'Ativar', false) !!}
                </div>
            </div>
        </div>

        {{--Linha da da Abas--}}
    <div class="row">
        <div class="col-md-12">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#recrusoAudiovisual" aria-controls="dados" data-toggle="tab"><i class="material-icons">playlist_add</i> Recurcos Audiovisuais</a>
                </li>
                <li role="presentation">
                    <a href="#metodologia" aria-controls="contato" role="tab" data-toggle="tab"><i class="material-icons">playlist_add_check</i> Ementa</a>
                </li>
                <li role="presentation">
                    <a href="#avaliacao" aria-controls="ensMedio" role="tab" data-toggle="tab"><i class="material-icons">event_seat</i> Bibliografia Básica</a>
                </li>
                <li role="presentation">
                    <a href="#bibliComplementar" aria-controls="ensMedio" role="tab" data-toggle="tab"><i class="material-icons">event_seat</i> Bibliografia Complementar</a>
                </li>
                <li role="presentation">
                    <a href="#competencia" aria-controls="documentosObrig" role="tab" data-toggle="tab"><i class="material-icons">event</i> Competência</a>
                </li>
                <li role="presentation">
                    <a href="#aulaPratica" aria-controls="documentosObrig" role="tab" data-toggle="tab"><i class="material-icons">account_balance_wallet</i> Aulas Práticas</a>
                </li>
                <li role="presentation">
                    <a href="#objEspecificos" aria-controls="documentosObrig" role="tab" data-toggle="tab"><i class="material-icons">account_balance_wallet</i> Obj. Gerais/Específico</a>
                </li>
                <li role="presentation">
                    <a href="#conteudoProgramatico" aria-controls="documentosObrig" role="tab" data-toggle="tab"><i class="material-icons">account_balance_wallet</i> Conteúdo Programático</a>
                </li>
                <li role="presentation">
                    <a href="#anexos" aria-controls="documentosObrig" role="tab" data-toggle="tab"><i class="material-icons">account_balance_wallet</i> Anexos</a>
                </li>
            </ul>
            <!-- End Nav tabs -->

            <!-- Tab panes -->
            <div class="tab-content">

                {{--Aba Recurso Audivisual--}}
                <div role="tabpanel" class="tab-pane active" id="recrusoAudiovisual">
                    <br/>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                {!! Form::label('recurso_audivisual', 'Recursos Audivisuais') !!}
                                {!! Form::textarea('recurso_audivisual', Session::getOldInput('recurso_audivisual') , array('class' => 'form-control', 'rows'=>'3')) !!}
                            </div>
                        </div>
                    </div>
                </div>
                {{--FIM Aba Recurso Audivisual--}}

                {{--Aba Ementa--}}
                <div role="tabpanel" class="tab-pane" id="metodologia">
                    <br/>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                {!! Form::label('ementa', 'Ementa') !!}
                                {!! Form::textarea('ementa', Session::getOldInput('ementa') , array('class' => 'form-control', 'rows'=>'3')) !!}
                            </div>
                        </div>
                    </div>
                </div>
                {{--Aba Ementa--}}

                {{--Aba Bibliografia Básica--}}
                <div role="tabpanel" class="tab-pane" id="avaliacao">
                    <br/>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                {!! Form::label('bibliografia_basica', 'Bibliografia Básica') !!}
                                {!! Form::textarea('bibliografia_basica', Session::getOldInput('bibliografia_basica') , array('class' => 'form-control', 'rows'=>'3')) !!}
                            </div>
                        </div>
                    </div>
                </div>
                {{--FIM Aba Bibliografia Básica --}}

                {{--Aba Bibliografia Complementar--}}
                <div role="tabpanel" class="tab-pane" id="bibliComplementar">
                    <br/>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                {!! Form::label('bibliografia_complementar', 'Bibliografia Complementar') !!}
                                {!! Form::textarea('bibliografia_complementar', Session::getOldInput('bibliografia_complementar') , array('class' => 'form-control', 'rows'=>'3')) !!}
                            </div>
                        </div>
                    </div>
                </div>
                {{--FIM Aba Bibliografia Complementar --}}

                {{--Aba Competência--}}
                <div role="tabpanel" class="tab-pane" id="competencia">
                    <br/>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                {!! Form::label('competencia', 'Competência') !!}
                                {!! Form::textarea('competencia', Session::getOldInput('competencia') , array('class' => 'form-control', 'rows'=>'3')) !!}
                            </div>
                        </div>
                    </div>
                </div>
                {{--FIM Aba Competência --}}

                {{--Aba Vagas--}}
                <div role="tabpanel" class="tab-pane" id="aulaPratica">
                    <br/>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                {!! Form::label('aula_pratica', 'Aulas Práticas') !!}
                                {!! Form::textarea('aula_pratica', Session::getOldInput('aula_pratica') , array('class' => 'form-control', 'rows'=>'3')) !!}
                            </div>
                        </div>
                    </div>

                </div>
                {{--FIM Aba Financeiro --}}

                {{--Aba objetos especificos--}}
                <div role="tabpanel" class="tab-pane" id="objEspecificos">
                    <br/>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                {!! Form::label('obj_especifico', 'Objetivos Especificos') !!}
                                {!! Form::textarea('obj_especifico', Session::getOldInput('obj_especifico') , array('class' => 'form-control', 'rows'=>'3')) !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                {!! Form::label('obj_gerais', 'Objetivos Gerais') !!}
                                {!! Form::textarea('obj_gerais', Session::getOldInput('obj_gerais') , array('class' => 'form-control', 'rows'=>'3')) !!}
                            </div>
                        </div>
                    </div>

                </div>
                {{--FIM Aba objetos especificos --}}

                {{--Aba Conteudo Programatico--}}
                <div role="tabpanel" class="tab-pane" id="conteudoProgramatico">
                    <br/>

                    <div class="row">
                        <div class="col-md-9">
                            <div class="form-group">
                                {!! Form::label('conteudo_programatico', 'Conteúdo Programatico') !!}
                                {!! Form::text('conteudo_programatico', Session::getOldInput('conteudo_programatico')  , array('class' => 'form-control', 'id'=>'conteudo_programatico')) !!}
                            </div>
                        </div>

                        {{-- Botão --}}
                        <div class="col-md-3">
                            @if(isset($model))
                                <button type="button" class="btn-sm btn-primary" id="btnCreateConteudoEditar">Adicionar Conteúdo</button>
                            @else
                                <button type="button" class="btn-sm btn-primary" id="btnCreateConteudo">Adicionar Conteúdo</button>
                            @endif
                        </div>
                        {{-- Fim Botão --}}

                    </div>

                    {{-- Grid conteudo programatico --}}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive no-padding">
                                <table id="grid-conteudo-programatico" class="display table table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>Conteúdo</th>
                                        <th style="width: 5%;">Ação</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>

                    </br>
                    {{-- Grid conteudo programatico --}}

                </div>
                {{--FIM Aba Conteudo Programatico --}}

                {{-- Aba de anexos--}}
                <div role="tabpanel" class="tab-pane" id="anexos">
                    <div class="row">
                        <div class="col-md-6">
                            <br>
                            <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                <div class="form-control" data-trigger="fileinput">
                                    <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                <span class="fileinput-filename">
                                    @if (isset($model) && $model->path_plano_ensino != null)
                                        {{ $model->path_plano_ensino }}
                                    @endif
                                </span>
                                </div>
                                        <span class="input-group-addon btn btn-default btn-file">
                                            <span class="fileinput-new">Anexo</span><span
                                                    class="fileinput-exists">Anexo</span>
                                            <input type="file" name="path_plano_ensino"></span>
                                <a href="#" class="input-group-addon btn btn-default fileinput-exists"
                                   data-dismiss="fileinput">Remove</a>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Fim aba anexos --}}

            </div>
            <!-- FIM Tab panes -->
        </div>
    </div>
    {{--FIM Linha da da Abas--}}

</div>

{{--Buttons Submit e Voltar--}}
<div class="row">
    <div class="col-md-9"></div>
    <div class="col-md-3">
        <div class="btn-group btn-group-justified">
            <div class="btn-group">
                <a href="{{ route('seracademico.tecnico.planoensino.index') }}" class="btn btn-primary"><i class="fa fa-long-arrow-left"></i>  Voltar</a>
            </div>
            <div class="btn-group">
                {!! Form::submit('Salvar', array('class' => 'btn btn-primary', 'id' => 'submitForm')) !!}
            </div>
        </div>
    </div>
</div>
</div>

@section('javascript')
    <script type="text/javascript" src="{{ asset('/js/posgraduacao/planoEnsino/conteudoProgramatico/grid_conteudo_programatico.js')  }}"></script>
    <script type="text/javascript" src="{{ asset('/js/posgraduacao/planoEnsino/conteudoProgramatico/create_conteudo_programatico.js')  }}"></script>
    <script type="text/javascript" src="{{ asset('/js/posgraduacao/planoEnsino/conteudoProgramatico/edit_conteudo_programatico.js')  }}"></script>

    <script type="text/javascript">
        // Evento para alertar o usuário do plano de ensino ativo.
        $(document).on('click', '#ativo', function () {
            if($(this).is(':checked')) {
                swal("Marcando esse plano como ativo, estará automaticamente desativando o atual ativo.", "Click no botão abaixo!", "warning");
            }
        });

        // Variável que armazenará o objeto datatable
        var tableConteudoProgramatico, idPlanoEnsino;

        // Verificando se é cadastro ou edição
        if(Boolean("{{ !isset($model) }}")) {
            // Carregando a grid create de conteúdo programático
            loadCreateTableConteudoProgramatico();
        } else {
            // Recuperando o id do conteúdo programático
            idPlanoEnsino = Number("{{ isset($model->id) ? $model->id : 0  }}");

            // Carregando a grid edit de conteúdo programático
            loadEditTableConteudoProgramatico(idPlanoEnsino);
        }


        @if(isset($model->path_plano_ensino))
        // Evento para remover o comprovante
       /* $(document).on('click', 'button.fileinput-remove-button', function () {
            // Recuperando o anexo
            var anexo = $(this).parent().find('input[type=file]').attr('id');

            // Requisição ajax
            jQuery.ajax({
                type: 'DELETE',
                data: {'anexo' : anexo},
                url: '{{ route('seracademico.posgraduacao.planoensino.deleteAnexo', ['id' => $model->id ])  }}',
                datatype: 'json'
            }).done(function (json) {
                // Verificando se remoção foi bem sucedida
                if(!json.success) {
                    //swal('Erro ao tentar remover o comprovante, atualize a página e tente novamente', '', 'error');
                }
            });
        });*/
        @endif

    </script>
@endsection