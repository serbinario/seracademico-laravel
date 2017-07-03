<div class="row">
    <div class="col-md-10">
        <div class="row">
            <div class="form-group col-md-6">
                {!! Form::label('pessoa[nome]', 'Nome') !!}
                {!! Form::text('pessoa[nome]', Session::getOldInput('pessoa[nome]')  , array('class' => 'form-control')) !!}
            </div>
            {{--<div class="form-group col-md-2">--}}
            {{--{!! Form::label('tratamento', 'Tratamento') !!}--}}
            {{--{!! Form::text('tratamento', Session::getOldInput('tratamento')  , array('class' => 'form-control')) !!}--}}
            {{--</div>--}}
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
            {{--<div class="form-group col-md-6">--}}
            {{--{!! Form::label('pessoa[nome_social]', 'Nome Social') !!}--}}
            {{--{!! Form::text('pessoa[nome_social]', Session::getOldInput('pessoa[nome_social]')  , array('class' => 'form-control')) !!}--}}
            {{--</div>--}}
            {{--<div class="form-group col-md-3">--}}
            {{--{!! Form::label('turno_id', 'Turno') !!}--}}
            {{--{!! Form::select('turno_id', $loadFields['turno'], null, array('class' => 'form-control')) !!}--}}
            {{--</div>--}}
            <div class="checkbox checkbox-primary checkbox-inline" style="margin-top: 27px">
                {!! Form::hidden('pos_e_graduacao', 0) !!}
                {!! Form::checkbox('pos_e_graduacao', 1, null, array('class' => 'form-control')) !!}
                {!! Form::label('pos_e_graduacao', 'Professor de graduação', false) !!}
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="fileinput fileinput-new" data-provides="fileinput">
            <div class="fileinput-preview thumbnail" data-trigger="fileinput" id="captura"
                 style="width: 135px; height: 115px;">
                @if (isset($model) && $model->path_image != null)
                    <div id="midias">
                        <img id="logo"
                             src="{{route('seracademico.posgraduacao.professorpos.getImg', ['id' => $model->id])}}"
                             alt="Foto" height="120" width="100"/><br/>
                        {{--<img id="logo" src="{{asset("/images/$aluno->path_image")}}"  alt="Foto" height="120" width="100"/><br/>--}}
                    </div>
                @endif
            </div>
            <div>
               <span class="btn btn-primary btn-xs btn-block btn-file">

                   <span class="fileinput-new">Selecionar</span>
                   <input type="file" id="img" name="img">
                   <input type="hidden" id="cod_img" name="cod_img">
               </span>
                <input type=button id="foto" value="Webcam" class="btn btn-primary btn-sm btn-block" data-toggle="modal"
                       data-target="#myModal">
                {{--<a href="#" class="btn btn-warning btn-xs fileinput-exists col-md-6" data-dismiss="fileinput">Remover</a>--}}
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
            <li role="presentation">
                <a href="#documentosObrig" aria-controls="documentosObrig" role="tab" data-toggle="tab">Documentos
                    Obrigatórios</a>
            </li>
            <li role="presentation">
                <a href="#anexoDoc" aria-controls="anexoDoc" role="tab" data-toggle="tab">Anexo</a>
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
                                {!! Form::label('pessoa[grau_instrucoes_id]', 'Titulação') !!}
                                {!! Form::select('pessoa[grau_instrucoes_id]', $loadFields['grauinstrucao'], null, array('class' => 'form-control')) !!}
                            </div>
                            {{--<div class="form-group col-md-4">--}}
                            {{--{!! Form::label('pessoa[profissoes_id]', 'Profissão') !!}--}}
                            {{--{!! Form::select('pessoa[profissoes_id]', $loadFields['profissao'], null, array('class' => 'form-control')) !!}--}}
                            {{--</div>--}}
                            {{--<div class="form-group col-md-2">--}}
                            {{--{!! Form::label('pessoa[cores_racas_id]', 'Cor/Raça') !!}--}}
                            {{--{!! Form::select('pessoa[cores_racas_id]', $loadFields['corraca'], null, array('class' => 'form-control')) !!}--}}
                            {{--</div>--}}
                            {{--<div class="form-group col-md-2">--}}
                            {{--{!! Form::label('pessoa[tipos_sanguinios_id]', 'Tipo Sanguíneo') !!}--}}
                            {{--{!! Form::select('pessoa[tipos_sanguinios_id]', $loadFields['tiposanguinio'], null, array('class' => 'form-control')) !!}--}}
                            {{--</div>--}}
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
                                                {!! Form::text('pessoa[cpf]', Session::getOldInput('pessoa[cpf]')  , array('id' => 'cpf', 'class' => 'form-control')) !!}
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
                                {{--Portal do aluno--}}
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#portaAluno"> <i
                                                    class="material-icons">arrow_drop_down_circle</i>Portal do Aluno</a>
                                    </h4>
                                </div>
                                <div id="portaAluno" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="form-group col-md-4">
                                                <h5>Senha de acesso ao portal</h5>
                                                <div class="form-group col-md-6">
                                                    {!! Form::label('login', 'Login') !!}
                                                    {!! Form::text('login', Session::getOldInput('login'), array('id' => 'login', 'class' => 'form-control', 'readonly' => 'true')) !!}
                                                </div>
                                                <div class="form-group col-md-5">
                                                    {!! Form::label('password', 'Senha') !!}
                                                    {!! Form::password('password', Session::getOldInput('password'), array('class' => 'form-control')) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{--Portal do aluno--}}
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
                <br>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-create-instituicao">Nova Instituição</button>
                <br><br>
                <div class="row">
                    <div class="col-md-12">
                        {{--<div class="row">--}}
                        {{--<div class="form-group col-md-3">--}}
                        {{--{!! Form::label('titulacao_id', 'Titulação') !!}--}}
                        {{--{!! Form::select('titulacao_id', $loadFields['titulacao'], null, array('class' => 'form-control')) !!}--}}
                        {{--</div>--}}
                        {{--</div>--}}

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

            {{--Aba Documentos Obrigatorios--}}
            <div role="tabpanel" class="tab-pane" id="documentosObrig">
                <br/>

                <div class="row">
                    {{--Primeria coluna--}}
                    <div class="col-md-6">

                        <div class="checkbox checkbox-primary">
                            {!! Form::hidden('pessoa[rg_doc_obrigatorio]', 0) !!}
                            {!! Form::checkbox('pessoa[rg_doc_obrigatorio]', 1, null, array('class' => 'form-control')) !!}
                            {!! Form::label('pessoa[rg_doc_obrigatorio]', 'RG', false) !!}
                        </div>

                        <div class="checkbox checkbox-primary">
                            {!! Form::hidden('pessoa[cpf_doc_obrigatorio]', 0) !!}
                            {!! Form::checkbox('pessoa[cpf_doc_obrigatorio]', 1, null, array('class' => 'form-control')) !!}
                            {!! Form::label('pessoa[cpf_doc_obrigatorio]', 'CPF', false) !!}
                        </div>

                        <!-- Comprovante de residência -->
                        <div class="checkbox checkbox-primary">
                            {!! Form::hidden('pessoa[comp_residencia_doc_obrigatorio]', 0) !!}
                            {!! Form::checkbox('pessoa[comp_residencia_doc_obrigatorio]', 1, null, array('class' => 'form-control')) !!}
                            {!! Form::label('pessoa[comp_residencia_doc_obrigatorio]', 'Comprovante de residência ', false) !!}
                        </div>
                        <!-- Fim Comprovante de residência -->

                        <!-- Currículo Lattes -->
                        <div class="checkbox checkbox-primary">
                            {!! Form::hidden('curriculo_lattes_doc_obrigatorio', 0) !!}
                            {!! Form::checkbox('curriculo_lattes_doc_obrigatorio', 1, null, array('class' => 'form-control')) !!}
                            {!! Form::label('curriculo_lattes_doc_obrigatorio', 'Currículo Lattes', false) !!}
                        </div>
                        <!-- Fim Currículo Lattes -->

                        <!-- Certificado Graduação -->
                        <div class="checkbox checkbox-primary">
                            {!! Form::hidden('diploma_graduacao_obrigatorio]', 0) !!}
                            {!! Form::checkbox('diploma_graduacao_obrigatorio', 1, null, array('class' => 'form-control')) !!}
                            {!! Form::label('diploma_graduacao_obrigatorio', 'Diploma de Graduação', false) !!}
                        </div>
                        <!-- Fim Certificado Graduação -->

                    </div>
                    {{--Fim da Primeria coluna--}}

                    {{--Segunda coluna--}}
                    <div class="col-md-6">

                        <!-- Certificado Pós graduação -->
                        <div class="checkbox checkbox-primary">
                            {!! Form::hidden('diploma_pos_obrigatorio', 0) !!}
                            {!! Form::checkbox('diploma_pos_obrigatorio', 1, null, array('class' => 'form-control')) !!}
                            {!! Form::label('diploma_pos_obrigatorio', 'Certificado de Pós Graduação', false) !!}
                        </div>
                        <!-- Fim Certificado Pós graduação -->

                        <!-- Certificado Mestrado  -->
                        <div class="checkbox checkbox-primary">
                            {!! Form::hidden('diploma_mestrado_obrigatorio', 0) !!}
                            {!! Form::checkbox('diploma_mestrado_obrigatorio', 1, null, array('class' => 'form-control')) !!}
                            {!! Form::label('diploma_mestrado_obrigatorio', 'Certificado Mestrado', false) !!}
                        </div>
                        <!-- Fim Certificado Mestrado -->


                        <!-- Certificado Doutorado -->
                        <div class="checkbox checkbox-primary">
                            {!! Form::hidden('diploma_doutorado_obrigatorio', 0) !!}
                            {!! Form::checkbox('diploma_doutorado_obrigatorio', 1, null, array('class' => 'form-control')) !!}
                            {!! Form::label('diploma_doutorado_obrigatorio', 'Certificado Doutorado', false) !!}
                        </div>
                        <!-- Fim Certificado Doutorado  -->

                    </div>
                    {{--Fim da Segunda coluna--}}
                </div>
            </div>
            {{--Aba Documentos Obrigatorios--}}

            {{-- Aba anexos --}}
            <div role="tabpanel" class="tab-pane" id="anexoDoc">
                <div class="row" style="margin-top: 3%;">
                    <div class="col-md-12">
                        <div class="row" style="margin-bottom: 3%;">
                            <div class="col-md-4">
                                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                    <div class="form-control" data-trigger="fileinput">
                                        <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                        <span class="fileinput-filename"></span>
                                    </div>
                                        <span class="input-group-addon btn btn-default btn-file">
                                            <span class="fileinput-new">Anexo (CPF)</span><span
                                                    class="fileinput-exists">Anexo (CPF)</span>
                                            <input type="file" name="path_cpf"></span>
                                    <a href="#" class="input-group-addon btn btn-default fileinput-exists"
                                       data-dismiss="fileinput">Remove</a>
                                </div>
                            </div>

                            <div class="col-md-1">
                                @if(isset($model) && $model->path_cpf)
                                    <a target="_blank"
                                       href="{{ route('seracademico.posgraduacao.professorpos.visualizarAnexo', ['id' => $model->id, 'tipo' => 'cpf']) }}">Visualizar</a>
                                @endif
                            </div>

                            <div class="col-md-4">
                                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                    <div class="form-control" data-trigger="fileinput">
                                        <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                        <span class="fileinput-filename"></span>
                                    </div>
                                        <span class="input-group-addon btn btn-default btn-file">
                                            <span class="fileinput-new">Anexo (RG)</span><span
                                                    class="fileinput-exists">Anexo (RG)</span>
                                            <input type="file" name="path_rg"></span>
                                    <a href="#" class="input-group-addon btn btn-default fileinput-exists"
                                       data-dismiss="fileinput">Remove</a>
                                </div>
                            </div>

                            <div class="col-md-1">
                                @if(isset($model) && $model->path_rg)
                                    <a target="_blank"
                                       href="{{ route('seracademico.posgraduacao.professorpos.visualizarAnexo', ['id' => $model->id, 'tipo' => 'rg']) }}">Visualizar</a>
                                @endif
                            </div>
                        </div>

                        <div class="row" style="margin-bottom: 3%;">
                            <div class="col-md-4">
                                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                    <div class="form-control" data-trigger="fileinput">
                                        <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                        <span class="fileinput-filename"></span>
                                    </div>
                                        <span class="input-group-addon btn btn-default btn-file">
                                            <span class="fileinput-new">Anexo (C. de Residência)</span><span
                                                    class="fileinput-exists">Anexo (C. de Residência)</span>
                                            <input type="file" name="path_comprovante_residencia"></span>
                                    <a href="#" class="input-group-addon btn btn-default fileinput-exists"
                                       data-dismiss="fileinput">Remove</a>
                                </div>
                            </div>

                            <div class="col-md-1">
                                @if(isset($model) && $model->path_comprovante_residencia)
                                    <a target="_blank" href="{{ route('seracademico.posgraduacao.professorpos.visualizarAnexo',
                                     ['id' => $model->id, 'tipo' => 'comprovante_residencia']) }}">Visualizar</a>
                                @endif
                            </div>

                            <div class="col-md-4">
                                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                    <div class="form-control" data-trigger="fileinput">
                                        <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                        <span class="fileinput-filename"></span>
                                    </div>
                                        <span class="input-group-addon btn btn-default btn-file">
                                            <span class="fileinput-new">Anexo (C. Lattes)</span><span
                                                    class="fileinput-exists">Anexo (C. Lattes)</span>
                                            <input type="file" name="path_curriculo_lattes"></span>
                                    <a href="#" class="input-group-addon btn btn-default fileinput-exists"
                                       data-dismiss="fileinput">Remove</a>
                                </div>
                            </div>

                            <div class="col-md-1">
                                @if(isset($model) && $model->path_curriculo_lattes)
                                    <a target="_blank" href="{{ route('seracademico.posgraduacao.professorpos.visualizarAnexo', ['id' => $model->id,
                                     'tipo' => 'curriculo_lattes']) }}">Visualizar</a>
                                @endif
                            </div>
                        </div>

                        <div class="row" style="margin-bottom: 3%;">
                            <div class="col-md-4">
                                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                    <div class="form-control" data-trigger="fileinput">
                                        <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                        <span class="fileinput-filename"></span>
                                    </div>
                                        <span class="input-group-addon btn btn-default btn-file">
                                            <span class="fileinput-new">Anexo (D. Graduação)</span><span
                                                    class="fileinput-exists">Anexo (D. Graduação)</span>
                                            <input type="file" name="path_diploma_graduacao"></span>
                                    <a href="#" class="input-group-addon btn btn-default fileinput-exists"
                                       data-dismiss="fileinput">Remove</a>
                                </div>
                            </div>

                            <div class="col-md-1">
                                @if(isset($model) && $model->path_diploma_graduacao)
                                    <a target="_blank" href="{{ route('seracademico.posgraduacao.professorpos.visualizarAnexo', ['id' => $model->id,
                                     'tipo' => 'diploma_graduacao']) }}">Visualizar</a>
                                @endif
                            </div>

                            <div class="col-md-4">
                                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                    <div class="form-control" data-trigger="fileinput">
                                        <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                        <span class="fileinput-filename"></span>
                                    </div>
                                        <span class="input-group-addon btn btn-default btn-file">
                                            <span class="fileinput-new">Anexo (C. Pós)</span><span
                                                    class="fileinput-exists">Anexo (C. Pós)</span>
                                            <input type="file" name="path_certificado_pos"></span>
                                    <a href="#" class="input-group-addon btn btn-default fileinput-exists"
                                       data-dismiss="fileinput">Remove</a>
                                </div>
                            </div>

                            <div class="col-md-1">
                                @if(isset($model) && $model->path_certificado_pos)
                                    <a target="_blank" href="{{ route('seracademico.posgraduacao.professorpos.visualizarAnexo', ['id' => $model->id,
                                     'tipo' => 'certificado_pos']) }}">Visualizar</a>
                                @endif
                            </div>
                        </div>

                        <div class="row" style="margin-bottom: 3%;">
                            <div class="col-md-4">
                                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                    <div class="form-control" data-trigger="fileinput">
                                        <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                        <span class="fileinput-filename"></span>
                                    </div>
                                        <span class="input-group-addon btn btn-default btn-file">
                                            <span class="fileinput-new">Anexo (C. Mestrado)</span><span
                                                    class="fileinput-exists">Anexo (C. Mestrado)</span>
                                            <input type="file" name="path_certificado_mestrado"></span>
                                    <a href="#" class="input-group-addon btn btn-default fileinput-exists"
                                       data-dismiss="fileinput">Remove</a>
                                </div>
                            </div>

                            <div class="col-md-1">
                                @if(isset($model) && $model->path_certificado_pos)
                                    <a target="_blank" href="{{ route('seracademico.posgraduacao.professorpos.visualizarAnexo', ['id' => $model->id,
                                     'tipo' => 'certificado_pos']) }}">Visualizar</a>
                                @endif
                            </div>

                            <div class="col-md-4">
                                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                    <div class="form-control" data-trigger="fileinput">
                                        <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                        <span class="fileinput-filename"></span>
                                    </div>
                                        <span class="input-group-addon btn btn-default btn-file">
                                            <span class="fileinput-new">Anexo (C. Doutorado)</span><span
                                                    class="fileinput-exists">Anexo (C. Doutorado)</span>
                                            <input type="file" name="path_certificado_doutorado"></span>
                                    <a href="#" class="input-group-addon btn btn-default fileinput-exists"
                                       data-dismiss="fileinput">Remove</a>
                                </div>
                            </div>

                            <div class="col-md-1">
                                @if(isset($model) && $model->path_certificado_doutorado)
                                    <a target="_blank" href="{{ route('seracademico.posgraduacao.professorpos.visualizarAnexo', ['id' => $model->id,
                                     'tipo' => 'path_certificado_doutorado']) }}">Visualizar</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- FIM Aba anexos --}}
        </div>
    </div>
</div>


<div class="row">
    <div class="modal fade my-profile" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Foto</h4>
                </div>
                <div class="modal-body">
                    <div style="margin-left: -11px;" id="my_camera"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Sair</button>
                    <button type="button" onClick="take_snapshot()" class="btn btn-primary">Tirar foto</button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-9"></div>
    <div class="col-md-3">
        <div class="btn-group btn-group-justified">
            <div class="btn-group">
                <a href="{{ route('seracademico.mestrado.professor.index') }}" class="btn btn-primary"><i
                            class="fa fa-long-arrow-left"></i> Voltar</a>
            </div>
            <div class="btn-group">
                {!! Form::submit('Salvar', array('class' => 'btn btn-primary', 'id' => 'submitForm')) !!}
            </div>
        </div>
    </div>
</div>

@include('posGraduacao.professor.modal_create_instituicao')

@section('javascript')
    <script type="text/javascript">
        //Setando cpf como login para uso no portal
        $(document).on('focusout', '#cpf', function () {
            var cpf = $('#cpf').val();
            $('#login').val(cpf);
        });

        Webcam.set({
            width: 260,
            height: 240,
            image_format: 'jpeg',
            jpeg_quality: 90
        });

        $(document).on('click', '#foto', function () {
            Webcam.attach('#my_camera');
        });

        function take_snapshot() {

            // take snapshot and get image data
            Webcam.snap(function (data_uri) {

                // display results in page
                document.getElementById('captura').innerHTML = '<img src="' + data_uri + '"/>';
                var raw_image_data = data_uri.replace(/^data\:image\/\w+\;base64\,/, '');
                document.getElementById('cod_img').value = raw_image_data;

                $(".my-profile").modal('hide');
                Webcam.reset();
                // $(".modal-dialog").modal('toggle');

            });
        }

        //Validações javascript
        /*$('#formProfessor').bootstrapValidator({
            fields: {
                'img': {
                    validators: {
                        file: {
                            maxSize: 819200,   // 2048 * 1024
                            message: "Tamanho de imagem permitido é de até 800kb"
                        }
                    }
                },
            },
        });*/

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
                    'value_search': estado,
                };

                jQuery.ajax({
                    type: 'POST',
                    url: '{{ route('seracademico.util.search')  }}',
                    data: dados,
                    datatype: 'json',
                    headers: {
                        'X-CSRF-TOKEN': '{{  csrf_token() }}'
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
                    'table': 'bairros',
                    'field_search': 'cidades_id',
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

        //consulta via select2
        $("#instituicao-graduacao").select2({
            placeholder: 'Selecione uma instituição',
            minimumInputLength: 3,
            width: 400,
            ajax: {
                type: 'POST',
                url: "{{ route('seracademico.util.select2')  }}",
                dataType: 'json',
                delay: 250,
                crossDomain: true,
                data: function (params) {
                    return {
                        'search': params.term, // search term
                        'tableName': 'fac_instituicoes',
                        'fieldName': 'nome',
                        'fieldWhere': 'nivel',
                        'valueWhere': '3',
                        'page': params.page || 1
                    };
                },
                headers: {
                    'X-CSRF-TOKEN': '{{  csrf_token() }}'
                },
                processResults: function (data, params) {

                    // parse the results into the format expected by Select2
                    // since we are using custom formatting functions we do not need to
                    // alter the remote JSON data, except to indicate that infinite
                    // scrolling can be used
                    params.page = params.page || 1;

                    return {
                        results: data.data,
                        pagination: {
                            more: data.more
                        }
                    };
                }
            }
        });

        //consulta via select2
        $("#instituicao-pos").select2({
            placeholder: 'Selecione uma instituição',
            minimumInputLength: 3,
            width: 400,
            ajax: {
                type: 'POST',
                url: "{{ route('seracademico.util.select2')  }}",
                dataType: 'json',
                delay: 250,
                crossDomain: true,
                data: function (params) {
                    return {
                        'search': params.term, // search term
                        'tableName': 'fac_instituicoes',
                        'fieldName': 'nome',
                        'fieldWhere': 'nivel',
                        'valueWhere': '3',
                        'page': params.page || 1
                    };
                },
                headers: {
                    'X-CSRF-TOKEN': '{{  csrf_token() }}'
                },
                processResults: function (data, params) {

                    // parse the results into the format expected by Select2
                    // since we are using custom formatting functions we do not need to
                    // alter the remote JSON data, except to indicate that infinite
                    // scrolling can be used
                    params.page = params.page || 1;

                    return {
                        results: data.data,
                        pagination: {
                            more: data.more
                        }
                    };
                }
            }
        });

        //consulta via select2
        $("#instituicao-mestrado").select2({
            placeholder: 'Selecione uma instituição',
            minimumInputLength: 3,
            width: 400,
            ajax: {
                type: 'POST',
                url: "{{ route('seracademico.util.select2')  }}",
                dataType: 'json',
                delay: 250,
                crossDomain: true,
                data: function (params) {
                    return {
                        'search': params.term, // search term
                        'tableName': 'fac_instituicoes',
                        'fieldName': 'nome',
                        'fieldWhere': 'nivel',
                        'valueWhere': '3',
                        'page': params.page || 1
                    };
                },
                headers: {
                    'X-CSRF-TOKEN': '{{  csrf_token() }}'
                },
                processResults: function (data, params) {

                    // parse the results into the format expected by Select2
                    // since we are using custom formatting functions we do not need to
                    // alter the remote JSON data, except to indicate that infinite
                    // scrolling can be used
                    params.page = params.page || 1;

                    return {
                        results: data.data,
                        pagination: {
                            more: data.more
                        }
                    };
                }
            }
        });

        //consulta via select2
        $("#instituicao-doutorado").select2({
            placeholder: 'Selecione uma instituição',
            minimumInputLength: 3,
            width: 400,
            ajax: {
                type: 'POST',
                url: "{{ route('seracademico.util.select2')  }}",
                dataType: 'json',
                delay: 250,
                crossDomain: true,
                data: function (params) {
                    return {
                        'search': params.term, // search term
                        'tableName': 'fac_instituicoes',
                        'fieldName': 'nome',
                        'fieldWhere': 'nivel',
                        'valueWhere': '3',
                        'page': params.page || 1
                    };
                },
                headers: {
                    'X-CSRF-TOKEN': '{{  csrf_token() }}'
                },
                processResults: function (data, params) {

                    // parse the results into the format expected by Select2
                    // since we are using custom formatting functions we do not need to
                    // alter the remote JSON data, except to indicate that infinite
                    // scrolling can be used
                    params.page = params.page || 1;

                    return {
                        results: data.data,
                        pagination: {
                            more: data.more
                        }
                    };
                }
            }
        });

        $(document).on('click', '#btnSaveInstituicao', function () {
            var nome  = $('#nome_instituicao').val();
            var nivel = 3;

            if(!nome) {
                swal('Você deve informar uma instituição', '', 'error');
                return false;
            }

            jQuery.ajax({
                type: 'POST',
                url: '{{ route('seracademico.posgraduacao.professorpos.instituicao')  }}',
                headers: {
                    'X-CSRF-TOKEN': '{{  csrf_token() }}'
                },
                data: {'nome' :  nome, 'nivel' : nivel},
                datatype: 'json'
            }).done(function (json) {
                if(json.success) {
                    swal('Instituição adicionada com sucesso', '', 'success');
                    $('#modal-create-instituicao').modal('toggle');
                }
            });
        });
    </script>
@stop