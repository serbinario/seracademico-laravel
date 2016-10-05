<div class="row">
    <div class="col-md-10">
        <div class="row">
            <div class="form-group col-md-6">
                {!! Form::label('pessoa[nome]', 'Nome') !!}
                {!! Form::text('pessoa[nome]', Session::getOldInput('pessoa[nome]')  , array('class' => 'form-control')) !!}
            </div>
            <div class="form-group col-md-2">
                {!! Form::label('tratamento', 'Tratamento') !!}
                {!! Form::text('tratamento', Session::getOldInput('tratamento')  , array('class' => 'form-control')) !!}
            </div>
            <div class="form-group col-md-2">
                {!! Form::label('pessoa[data_nasciemento]', 'Nascimento') !!}
                {!! Form::text('pessoa[data_nasciemento]', Session::getOldInput('pessoa[data_nasciemento]'), array('class' => 'form-control datepicker')) !!}
            </div>
            <div class="form-group col-md-2">
                {!! Form::label('pessoa[sexos_id]', 'Sexo') !!}
                {!! Form::select('pessoa[sexos_id]',$loadFields['sexo'], Session::getOldInput('pessoa[sexos_id]'),  array('class' => 'form-control')) !!}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                {!! Form::label('pessoa[nome_social]', 'Nome Social') !!}
                {!! Form::text('pessoa[nome_social]', Session::getOldInput('pessoa[nome_social]')  , array('class' => 'form-control')) !!}
            </div>
            <div class="form-group col-md-3">
                {!! Form::label('turno_id', 'Turno') !!}
                {!! Form::select('turno_id', $loadFields['turno'], null, array('class' => 'form-control')) !!}
            </div>
            <div class="checkbox checkbox-primary checkbox-inline" style="margin-top: 27px">
                {!! Form::hidden('pos_e_graduacao', 0) !!}
                {!! Form::checkbox('pos_e_graduacao', 1, null, array('class' => 'form-control')) !!}
                {!! Form::label('pos_e_graduacao', 'Professor de graduação', false) !!}
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="fileinput fileinput-new" data-provides="fileinput">
            <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 135px; height: 115px;">
                @if (isset($model) && $model->path_image != null)
                    <div id="midias">
                        <img id="logo" src="/seracademico-laravel/public/images/{{$model->path_image}}" alt="Foto"
                             height="120" width="100"/><br/>
                    </div>
                @endif
            </div>
            <div>
               <span class="btn btn-primary btn-xs btn-block btn-file">
                   <span class="fileinput-new">Selecionar</span>
                   <input type="file" name="img">
               </span>
                {{--<a href="#" class="btn btn-warning btn-xs fileinput-exists col-md-6"--}}
                   {{--data-dismiss="fileinput">Remover</a>--}}
            </div>
        </div>
    </div>
</div>
<hr class="hr-line-dashed"/>
<div class="row">
    <div class="col-md-12">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active">
                <a href="#dados" aria-controls="dados" data-toggle="tab">Dados
                    pessoais</a>
            </li>
            <li role="presentation">
                <a href="#contato" aria-controls="contato" role="tab" data-toggle="tab">Informações
                    para contato</a>
            </li>
            <li role="presentation">
                <a href="#academico" aria-controls="academico" role="tab" data-toggle="tab">
                    Dados Acadêmicos</a>
            </li>
        </ul>
        <!-- End Nav tabs -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="dados">
                <br/>
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="form-group col-md-2">
                                {!! Form::label('pessoa[estado_civis_id]', 'Estado Civil') !!}
                                {!! Form::select('pessoa[estado_civis_id]', $loadFields['estadocivil'], null, array('class' => 'form-control')) !!}
                            </div>
                            <div class="form-group col-md-2">
                                {!! Form::label('pessoa[grau_instrucoes_id]', 'Grau de Instrução') !!}
                                {!! Form::select('pessoa[grau_instrucoes_id]', $loadFields['grauinstrucao'], null, array('class' => 'form-control')) !!}
                            </div>
                            <div class="form-group col-md-4">
                                {!! Form::label('pessoa[profissoes_id]', 'Profissão') !!}
                                {!! Form::select('pessoa[profissoes_id]', $loadFields['profissao'], null, array('class' => 'form-control')) !!}
                            </div>
                            <div class="form-group col-md-2">
                                {!! Form::label('pessoa[cores_racas_id]', 'Cor/Raça') !!}
                                {!! Form::select('pessoa[cores_racas_id]', $loadFields['corraca'], null, array('class' => 'form-control')) !!}
                            </div>
                            <div class="form-group col-md-2">
                                {!! Form::label('pessoa[tipos_sanguinios_id]', 'Tipo Sanguíneo') !!}
                                {!! Form::select('pessoa[tipos_sanguinios_id]', $loadFields['tiposanguinio'], null, array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-3">
                                {!! Form::label('pessoa[nacionalidade]', 'Nascionalidade') !!}
                                {!! Form::text('pessoa[nacionalidade]', Session::getOldInput('nacionalidade')  , array('class' => 'form-control')) !!}
                            </div>
                            <div class="form-group col-md-3">
                                {!! Form::label('pessoa[uf_nascimento_id]', 'UF Nascimento') !!}
                                {!! Form::select('pessoa[uf_nascimento_id]', $loadFields['estado'], null, array('class' => 'form-control')) !!}
                            </div>
                            <div class="form-group col-md-3">
                                {!! Form::label('pessoa[naturalidade]', 'Naturalidade') !!}
                                {!! Form::text('pessoa[naturalidade]', Session::getOldInput('naturalidade')  , array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <legend>Outros dados</legend>
                        <div class="panel-group" id="accordion">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#filiacao"> <i
                                                    class="material-icons">arrow_drop_down_circle</i> Filiação</a>
                                    </h4>
                                </div>
                                <div id="filiacao" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                {!! Form::label('pessoa[nome_pai]', 'Nome do Pai') !!}
                                                {!! Form::text('pessoa[nome_pai]', Session::getOldInput('pessoa[nome_pai]')  , array('class' => 'form-control')) !!}
                                            </div>
                                            <div class="form-group col-md-6">
                                                {!! Form::label('pessoa[nome_mae]', 'Nome da Mãe') !!}
                                                {!! Form::text('pessoa[nome_mae]', Session::getOldInput('pessoa[nome_mae]')  , array('class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"> <i
                                                    class="material-icons">arrow_drop_down_circle</i> Documentos</a>
                                    </h4>
                                </div>
                                <div id="collapseTwo" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="form-group col-md-3">
                                                {!! Form::label('pessoa[identidade]', 'Identidade') !!}
                                                {!! Form::text('pessoa[identidade]', Session::getOldInput('pessoa[identidade]')  , array('class' => 'form-control')) !!}
                                            </div>
                                            <div class="form-group col-md-3">
                                                {!! Form::label('pessoa[orgao_rg]', 'Orgão RG') !!}
                                                {!! Form::text('pessoa[orgao_rg]', Session::getOldInput('pessoa[orgao_rg]')  , array('class' => 'form-control')) !!}
                                            </div>
                                            <div class="form-group col-md-3">
                                                {!! Form::label('pessoa[uf_exp]', 'UF') !!}
                                                {!! Form::text('pessoa[uf_exp]', Session::getOldInput('pessoa[uf_exp]'), array('class' => 'form-control')) !!}
                                            </div>
                                            <div class="form-group col-md-3">
                                                {!! Form::label('pessoa[data_expedicao]', 'Data de expedição') !!}
                                                {!! Form::text('pessoa[data_expedicao]', Session::getOldInput('pessoa[data_expedicao]'), array('class' => 'form-control datepicker')) !!}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-3">
                                                {!! Form::label('pessoa[cpf]', 'CPF') !!}
                                                {!! Form::text('pessoa[cpf]', Session::getOldInput('pessoa[cpf]')  , array('class' => 'form-control')) !!}
                                            </div>
                                            <div class="form-group col-md-2">
                                                {!! Form::label('pessoa[titulo_eleitoral]', 'Titulo Eleitoral') !!}
                                                {!! Form::text('pessoa[titulo_eleitoral]', Session::getOldInput('pessoa[titulo_eleitoral]')  , array('class' => 'form-control')) !!}
                                            </div>
                                            <div class="form-group col-md-1">
                                                {!! Form::label('pessoa[zona]', 'Zona') !!}
                                                {!! Form::text('pessoa[zona]', Session::getOldInput('pessoa[zona]')  , array('class' => 'form-control')) !!}
                                            </div>
                                            <div class="form-group col-md-1">
                                                {!! Form::label('pessoa[secao]', 'Seção') !!}
                                                {!! Form::text('pessoa[secao]', Session::getOldInput('pessoa[secao]')  , array('class' => 'form-control')) !!}
                                            </div>
                                            <div class="form-group col-md-2">
                                                {!! Form::label('pessoa[resevista]', 'Reservista') !!}
                                                {!! Form::text('pessoa[resevista]', Session::getOldInput('pessoa[resevista]')  , array('class' => 'form-control')) !!}
                                            </div>
                                            <div class="form-group col-md-3">
                                                {!! Form::label('pessoa[catagoria_resevista]', 'Categoria Reservista') !!}
                                                {!! Form::text('pessoa[catagoria_resevista]', Session::getOldInput('pessoa[catagoria_resevista]')  , array('class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-4">
                                                {!! Form::label('ctps_numero', 'CTPS-Número') !!}
                                                {!! Form::text('ctps_numero', Session::getOldInput('ctps_numero')  , array('class' => 'form-control')) !!}
                                            </div>
                                            <div class="form-group col-md-4">
                                                {!! Form::label('ctps_serie', 'CTPS-Série') !!}
                                                {!! Form::text('ctps_serie', Session::getOldInput('ctps_serie')  , array('class' => 'form-control')) !!}
                                            </div>
                                            <div class="form-group col-md-4">
                                                {!! Form::label('data_admissao', 'Data Admissão') !!}
                                                {!! Form::text('data_admissao', Session::getOldInput('data_admissao'), array('class' => 'form-control datepicker')) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#deficiencia"> <i
                                                    class="material-icons">arrow_drop_down_circle</i> Deficiencia</a>
                                    </h4>
                                </div>
                                <div id="deficiencia" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                {!! Form::label('tipoDef', 'Deficiências') !!}
                                                <div class="checkbox checkbox-primary">
                                                    {!! Form::hidden('pessoa[deficiencia_fisica]', 0) !!}
                                                    {!! Form::checkbox('pessoa[deficiencia_fisica]', 1, null, array('class' => 'form-control')) !!}
                                                    {!! Form::label('pessoa[deficiencia_fisica]', 'Física') !!}
                                                    <div class="checkbox checkbox-primary checkbox-inline">
                                                        {!! Form::hidden('pessoa[deficiencia_auditiva]', 0) !!}
                                                        {!! Form::checkbox('pessoa[deficiencia_auditiva]', 1, null, array('class' => 'form-control')) !!}
                                                        {!! Form::label('pessoa[deficiencia_auditiva]', 'Auditivas', false) !!}
                                                    </div>
                                                    <div class="checkbox checkbox-primary checkbox-inline">
                                                        {!! Form::hidden('pessoa[deficiencia_visual]', 0) !!}
                                                        {!! Form::checkbox('pessoa[deficiencia_visual]', 1, null, array('class' => 'form-control')) !!}
                                                        {!! Form::label('pessoa[deficiencia_visual]', 'Visuais', false) !!}
                                                    </div>
                                                    <div class="checkbox checkbox-primary checkbox-inline">
                                                        {!! Form::hidden('pessoa[deficiencia_outra]', 0) !!}
                                                        {!! Form::checkbox('pessoa[deficiencia_outra]', 1, null,array('class' => 'form-control')) !!}
                                                        {!! Form::label('pessoa[deficiencia_outra]', 'Outras') !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="contato">
                <br/>
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="form-group col-md-10">
                                {!! Form::label('pessoa[endereco][logradouro]', 'Endereço ') !!}
                                {!! Form::text('pessoa[endereco][logradouro]', Session::getOldInput('pessoa[endereco][logradouro]'), array('class' => 'form-control')) !!}
                            </div>
                            <div class="form-group col-md-2">
                                {!! Form::label('pessoa[endereco][numero]', 'Número') !!}
                                {!! Form::text('pessoa[endereco][numero]', Session::getOldInput('pessoa[endereco][numero]'), array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-3">
                                {!! Form::label('estado', 'UF ') !!}
                                @if(isset($model->endereco->bairro->cidade->estado->id))
                                    {!! Form::select('estado', $loadFields['estado'], $model->endereco->bairro->cidade->estado->id, array('class' => 'form-control', 'id' => 'estado')) !!}
                                @else
                                    {!! Form::select('estado', $loadFields['estado'], Session::getOldInput('estado'), array('class' => 'form-control', 'id' => 'estado')) !!}
                                @endif
                            </div>
                            <div class="form-group col-md-4">
                                {!! Form::label('cidade', 'Cidade ') !!}
                                @if(isset($model->endereco->bairro->cidade->id))
                                    {!! Form::select('cidade', array($model->endereco->bairro->cidade->id => $model->endereco->bairro->cidade->nome), $model->endereco->bairro->cidade->id,array('class' => 'form-control', 'id' => 'cidade')) !!}
                                @else
                                    {!! Form::select('cidade', array(), Session::getOldInput('cidade'),array('class' => 'form-control', 'id' => 'cidade')) !!}
                                @endif
                            </div>
                            <div class="form-group col-md-3">
                                {!! Form::label('pessoa[endereco][bairros_id]', 'Bairro ') !!}
                                @if(isset($model->endereco->bairro->id))
                                    {!! Form::select('pessoa[endereco][bairros_id]', array($model->endereco->bairro->id => $model->endereco->bairro->nome), $model->endereco->bairro->id,array('class' => 'form-control', 'id' => 'bairro')) !!}
                                @else
                                    {!! Form::select('pessoa[endereco][bairros_id]', array(), Session::getOldInput('bairro'),array('class' => 'form-control', 'id' => 'bairro')) !!}
                                @endif
                            </div>
                            <div class="form-group col-md-2">
                                {!! Form::label('pessoa[endereco][cep]', 'CEP ') !!}
                                {!! Form::text('pessoa[endereco][cep]', Session::getOldInput('pessoa[endereco][cep]'), array('class' => 'form-control cep')) !!}
                            </div>
                        </div>
                        <legend><i class="fa fa-phone"></i> Contato</legend>
                        <div class="panel-group" id="accordion">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#contato1"> <i
                                                    class="fa fa-plus-circle"></i> Contato pessoal</a>
                                    </h4>
                                </div>
                                <div id="contato1" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="form-group col-md-5">
                                                {!! Form::label('pessoa[email]', 'E-mail') !!}
                                                {!! Form::text('pessoa[email]', Session::getOldInput('pessoa[email]')  , array('class' => 'form-control')) !!}
                                            </div>
                                            <div class="form-group col-md-3">
                                                {!! Form::label('pessoa[telefone_fixo]', 'Telefone Fixo') !!}
                                                {!! Form::text('pessoa[telefone_fixo]', Session::getOldInput('pessoa[telefone_fixo]')  , array('class' => 'form-control')) !!}
                                            </div>
                                            <div class="form-group col-md-2">
                                                {!! Form::label('pessoa[celular]', 'Celular') !!}
                                                {!! Form::text('pessoa[celular]', Session::getOldInput('pessoa[celular]')  , array('class' => 'form-control')) !!}
                                            </div>
                                            <div class="form-group col-md-2">
                                                {!! Form::label('pessoa[celular2]', 'Celular 2') !!}
                                                {!! Form::text('pessoa[celular2]', Session::getOldInput('pessoa[celular2]')  , array('class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="academico">
                <br/>
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="form-group col-md-3">
                                {!! Form::label('titulacao_id', 'Titulação') !!}
                                {!! Form::select('titulacao_id', $loadFields['titulacao'], null, array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="instituicao-graduacao" class="control-label">Graduação</label>
                                <select id="instituicao-graduacao" class="form-control" name="instituicao_graduacao_id">
                                    @if(isset($model->id) && $model->instituicaoGraduacao != null)
                                        <option value="{{ $model->instituicaoGraduacao->id  }}"
                                                selected="selected">{{ $model->instituicaoGraduacao->nome }}</option>
                                    @endif
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="instituicao-pos">Pós Graduação</label>
                                <select id="instituicao-pos" class="form-control" name="instituicao_pos_id">
                                    @if(isset($model->id) && $model->instituicaoPos != null)
                                        <option value="{{ $model->instituicaoPos->id  }}"
                                                selected="selected">{{ $model->instituicaoPos->nome }}</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                {!! Form::label('especificacao_graduacao', 'Especificação Graduação') !!}
                                {!! Form::text('especificacao_graduacao', Session::getOldInput('especificacao_graduacao')  , array('class' => 'form-control')) !!}
                            </div>
                            <div class="form-group col-md-6">
                                {!! Form::label('especificacao_pos', 'Especificação Pós') !!}
                                {!! Form::text('especificacao_pos', Session::getOldInput('especificacao_pos')  , array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="instituicao-mestrado">Mestrado</label>
                                <select id="instituicao-mestrado" class="form-control" name="instituicao_mestrado_id">
                                    @if(isset($model->id) && $model->instituicaoMestrado != null)
                                        <option value="{{ $model->instituicaoMestrado->id  }}"
                                                selected="selected">{{ $model->instituicaoMestrado->nome }}</option>
                                    @endif
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="instituicao-doutorado">Doutorado</label>
                                <select id="instituicao-doutorado" class="form-control" name="instituicao_doutorado_id">
                                    @if(isset($model->id) && $model->instituicaoDoutorado != null)
                                        <option value="{{ $model->instituicaoDoutorado->id  }}"
                                                selected="selected">{{ $model->instituicaoDoutorado->nome }}</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                {!! Form::label('especificacao_mestrado', 'Especificação Mestrado') !!}
                                {!! Form::text('especificacao_mestrado', Session::getOldInput('especificacao_mestrado')  , array('class' => 'form-control')) !!}
                            </div>
                            <div class="form-group col-md-6">
                                {!! Form::label('especificacao_doutorado', 'Especificação Doutorado') !!}
                                {!! Form::text('especificacao_doutorado', Session::getOldInput('especificacao_doutorado')  , array('class' => 'form-control')) !!}
                            </div>
                        </div>

                    </div>
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
                <a href="{{ route('seracademico.posgraduacao.professorpos.index') }}" class="btn btn-primary"><i class="fa fa-long-arrow-left"></i>  Voltar</a>
            </div>
            <div class="btn-group">
                {!! Form::submit('Salvar', array('class' => 'btn btn-primary', 'id' => 'submitForm')) !!}
            </div>
        </div>
    </div>
</div>
{{--Fim Buttons Submit e Voltar--}}
</div>

</div>
</div>
</div>