<div class="row">
    <div class="col-md-12">
        @if(!isset($aluno))
        <div class="row">
            <div class="col-md-4 form-group">
                <label for="searchCpf">DIGITE O CPF SE POSSUIR CADASTRO</label>
                <input type="text" id="searchCpf" class="form-control">
            </div>

            <div class="col-md-4">
                <a style="margin-top: 6%;" id="btnSearchCpf" class="btn btn-primary">
                    Buscar
                    <span class="glyphicon glyphicon-search"></span>
                </a>
            </div>
        </div>
        @endif
        <div class="row">
            <div class="form-group col-md-7">
                {!! Form::label('pessoa[nome]', 'Nome *') !!}
                {!! Form::text('pessoa[nome]',  Session::getOldInput('pessoa[nome]') , array('class' => 'form-control')) !!}
            </div>
            <div class="form-group col-md-2">
                {!! Form::label('pessoa[data_nasciemento]', 'Nascimento *') !!}
                {!! Form::text('pessoa[data_nasciemento]', null, array('class' => 'form-control datepicker date')) !!}
            </div>
            <div class="form-group col-md-2">
                {!! Form::label('pessoa[sexos_id]', 'Sexo ') !!}
                {!! Form::select('pessoa[sexos_id]', $loadFields['sexo'], Session::getOldInput('pessoa[sexos_id]'), array('class' => 'form-control')) !!}
            </div>
            <div class="form-group col-md-1">
                {!! Form::label('ativar', 'Ativar') !!}
                <div class="checkbox checkbox-primary">
                    {!! Form::hidden('pessoa[ativo]', 0) !!}
                    {!! Form::checkbox('pessoa[ativo]', 1, null, array('class' => 'form-control')) !!}
                    {!! Form::label('pessoa[ativo]', 'Ativar', false) !!}
                </div>
            </div>

        </div>
    </div>
    {{--<div class="col-md-2">--}}
        {{--<div class="fileinput fileinput-new" data-provides="fileinput">--}}
            {{--<div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 135px; height: 115px;">--}}
                {{--@if (isset($aluno) && $aluno->path_image != null)--}}
                    {{--<div id="midias">--}}
                        {{--<img id="logo" src="/images/{{$aluno->path_image}}"  alt="Foto" height="120" width="100"/><br/>--}}
                    {{--</div>--}}
                {{--@endif--}}
            {{--</div>--}}
            {{--<div>--}}
               {{--<span class="btn btn-primary btn-xs btn-block btn-file">--}}
                   {{--<span class="fileinput-new">Selecionar</span>--}}
                   {{--<span class="fileinput-exists">Mudar</span>--}}
                   {{--<input type="file" name="img">--}}
               {{--</span>--}}
                {{--<a href="#" class="btn btn-warning btn-xs fileinput-exists col-md-6" data-dismiss="fileinput">Remover</a>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
</div>
<hr class="hr-line-dashed"/>


<div class="row">
    <div class="col-md-12">

        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active">
                <a href="#dados" aria-controls="dados" data-toggle="tab"><i class="fa fa-male"></i> Dados pessoais</a>
            </li>
            <li role="presentation">
                <a href="#contato" aria-controls="contato" role="tab" data-toggle="tab"><i class="fa fa-globe"></i>Informações para contato</a>
            </li>
            <li role="presentation">
                <a href="#ensMedio" aria-controls="ensMedio" role="tab" data-toggle="tab"><i class="fa fa-file-text"></i> Ensino Médio</a>
            </li>
            {{--<li role="presentation">
                <a href="#documentosObrig" aria-controls="documentosObrig" role="tab" data-toggle="tab"><i class="fa fa-file-text"></i>Documentos Obrigatórios</a>
            </li>--}}
            <li role="presentation">
                <a href="#vestibular" aria-controls="vestibular" role="tab" data-toggle="tab"><i class="fa fa-file-text"></i>Vestibular</a>
            </li>
        </ul>
        <!-- End Nav tabs -->

        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="dados">
                <br/>
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="form-group col-md-2">
                                {!! Form::label('pessoa[estados_civis_id]', 'Estado Civil ') !!}
                                {!! Form::select('pessoa[estados_civis_id]', (['' => 'Selecione uma opção'] + $loadFields['estadocivil']->toArray()), null, array('class' => 'form-control')) !!}
                            </div>
                            {{--<div class="form-group col-md-2">--}}
                                {{--{!! Form::label('grau_instrucoes_id', 'Grau de instrução') !!}--}}
                                {{--{!! Form::select('grau_instrucoes_id', $loadFields['grauinstrucao'], Session::getOldInput('grau_instrucoes_id'),array('class' => 'form-control')) !!}--}}
                            {{--</div>--}}
                            {{--<div class="form-group col-md-4">
                                {!! Form::label('profissoes_id', 'Profissão ') !!}
                                {!! Form::select('profissoes_id', array(), Session::getOldInput('profissoes_id'),array('class' => 'form-control')) !!}
                            </div>--}}
                            <div class="form-group col-md-2">
                                {!! Form::label('pessoa[cores_racas_id]', 'Cor/Raça') !!}
                                {!! Form::select('pessoa[cores_racas_id]', (['' => 'Selecione uma opção'] + $loadFields['corraca']->toArray()), Session::getOldInput('cores_racas_id'),array('class' => 'form-control')) !!}
                            </div>
                            <div class="form-group col-md-2">
                                {!! Form::label('pessoa[tipos_sanguinios_id]', 'Tipo Sanguíneo') !!}
                                {!! Form::select('pessoa[tipos_sanguinios_id]', (['' => 'Selecione uma opção'] + $loadFields['tiposanguinio']->toArray()) , Session::getOldInput('tipos_sanguinios_id'), array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-3">
                                {!! Form::label('pessoa[nacionalidade]', 'Nacionalidade ') !!}
                                {!! Form::text('pessoa[nacionalidade]', Session::getOldInput('pessoa[nacionalidade]'), array('class' => 'form-control')) !!}
                            </div>
                            <div class="form-group col-md-3">
                                {!! Form::label('pessoa[uf_nascimento_id]', 'UF Nascimento') !!}
                                {!! Form::select('pessoa[uf_nascimento_id]', $loadFields['estado'], Session::getOldInput('uf_nascimento_id'),array('class' => 'form-control')) !!}
                            </div>
                            <div class="form-group col-md-3">
                                {!! Form::label('pessoa[naturalidade]', 'Naturalidade ') !!}
                                {!! Form::text('pessoa[naturalidade]', Session::getOldInput('pessoa[naturalidade]'), array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <legend><i class="fa fa-archive"></i> Outros dados</legend>
                        <div class="panel-group" id="accordion">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#filiacao"> <i
                                                    class="fa fa-plus-circle"></i> Filiação</a>
                                    </h4>
                                </div>
                                <div id="filiacao" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                {!! Form::label('pessoa[nome_pai]', 'Nome Pai *') !!}
                                                {!! Form::text('pessoa[nome_pai]', Session::getOldInput('pessoa[nome_pai]'), array('class' => 'form-control')) !!}
                                            </div>
                                            <div class="form-group col-md-6">
                                                {!! Form::label('pessoa[nome_mae]', 'Nome Mãe *') !!}
                                                {!! Form::text('pessoa[nome_mae]',Session::getOldInput('pessoa[nome_mae]'), array('class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"> <i
                                                    class="fa fa-plus-circle"></i> Documentos</a>
                                    </h4>
                                </div>
                                <div id="collapseTwo" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="form-group col-md-3">
                                                {!! Form::label('pessoa[identidade]', 'Identidade *') !!}
                                                {!! Form::text('pessoa[identidade]', Session::getOldInput('pessoa[identidade]'), array('class' => 'form-control')) !!}
                                            </div>
                                            <div class="form-group col-md-3">
                                                {!! Form::label('pessoa[orgao_rg]', 'Orgão RG ') !!}
                                                {!! Form::text('pessoa[orgao_rg]', Session::getOldInput('pessoa[orgao_rg]'), array('class' => 'form-control')) !!}
                                            </div>
                                            <div class="form-group col-md-3">
                                                {!! Form::label('pessoa[uf_exp]', 'UF') !!}
                                                {!! Form::text('pessoa[uf_exp]', null, array('class' => 'form-control')) !!}
                                            </div>
                                            <div class="form-group col-md-3">
                                                {!! Form::label('pessoa[data_expedicao]', 'Data expedição') !!}
                                                {!! Form::text('pessoa[data_expedicao]', null , array('class' => 'form-control datepicker date')) !!}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-3">
                                                {!! Form::label('pessoa[cpf]', 'CPF *') !!}
                                                {!! Form::text('pessoa[cpf]', Session::getOldInput('pessoa[cpf]'), array('class' => 'form-control cpf', 'id' => 'cpfAlunos')) !!}
                                            </div>
                                            <div class="form-group col-md-2">
                                                {!! Form::label('pessoa[titulo_eleitoral]', 'Título Eleitoral') !!}
                                                {!! Form::text('pessoa[titulo_eleitoral]', Session::getOldInput('pessoa[titulo_eleitoral]'), array('class' => 'form-control')) !!}
                                            </div>
                                            <div class="form-group col-md-1">
                                                {!! Form::label('pessoa[zona]', 'Zona') !!}
                                                {!! Form::text('pessoa[zona]', Session::getOldInput('pessoa[zona]'), array('class' => 'form-control')) !!}
                                            </div>
                                            <div class="form-group col-md-1">
                                                {!! Form::label('pessoa[secao]', 'Seção') !!}
                                                {!! Form::text('pessoa[secao]', Session::getOldInput('pessoa[secao]') , array('class' => 'form-control')) !!}
                                            </div>
                                            <div class="form-group col-md-2">
                                                {!! Form::label('pessoa[resevista]', 'Reservista') !!}
                                                {!! Form::text('pessoa[resevista]', Session::getOldInput('pessoa[resevista]'), array('class' => 'form-control')) !!}
                                            </div>
                                            <div class="form-group col-md-3">
                                                {!! Form::label('pessoa[catagoria_resevista]', 'Categoria Reservista') !!}
                                                {!! Form::text('pessoa[catagoria_resevista]', Session::getOldInput('pessoa[catagoria_resevista]'), array('class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#deficiencia"> <i
                                                    class="fa fa-plus-circle"></i> Deficiencia</a>
                                    </h4>
                                </div>
                                <div id="deficiencia" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <div class="row">

                                            <div class="form-group col-md-4">
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
                            <div class="form-group col-md-8">
                                {!! Form::label('pessoa[endereco][logradouro]', 'Endereço ') !!}
                                {!! Form::text('pessoa[endereco][logradouro]', Session::getOldInput('pessoa[endereco][logradouro]'), array('class' => 'form-control')) !!}
                            </div>

                            <div class="form-group col-md-2">
                                {!! Form::label('pessoa[endereco][cep]', 'CEP') !!}
                                {!! Form::text('pessoa[endereco][cep]', Session::getOldInput('pessoa[endereco][cep]'), array('class' => 'form-control')) !!}
                            </div>

                            <div class="form-group col-md-2">
                                {!! Form::label('pessoa[endereco][numero]', 'Número') !!}
                                {!! Form::text('pessoa[endereco][numero]', Session::getOldInput('pessoa[endereco][numero]'), array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-3">
                                {!! Form::label('estado', 'UF ') !!}
                                @if(isset($aluno->pessoa->endereco->bairro->cidade->estado->id))
                                    {!! Form::select('estado', $loadFields['estado'], $aluno->pessoa->endereco->bairro->cidade->estado->id, array('class' => 'form-control', 'id' => 'estado')) !!}
                                @else
                                    {!! Form::select('estado', $loadFields['estado'], Session::getOldInput('estado'), array('class' => 'form-control', 'id' => 'estado')) !!}
                                @endif
                            </div>
                            <div class="form-group col-md-4">
                                {!! Form::label('cidade', 'Cidade ') !!}
                                @if(isset($aluno->pessoa->endereco->bairro->cidade->id))
                                    {!! Form::select('cidade', array($aluno->pessoa->endereco->bairro->cidade->id => $aluno->pessoa->endereco->bairro->cidade->nome), $aluno->pessoa->endereco->bairro->cidade->id,array('class' => 'form-control', 'id' => 'cidade')) !!}
                                @else
                                    {!! Form::select('cidade', array(), Session::getOldInput('cidade'),array('class' => 'form-control', 'id' => 'cidade')) !!}
                                @endif
                            </div>
                            <div class="form-group col-md-3">
                                {!! Form::label('pessoa[endereco][bairros_id]', 'Bairro ') !!}
                                @if(isset($aluno->pessoa->endereco->bairro->id))
                                    {!! Form::select('pessoa[endereco][bairros_id]', array($aluno->pessoa->endereco->bairro->id => $aluno->pessoa->endereco->bairro->nome), $aluno->pessoa->endereco->bairro->id,array('class' => 'form-control', 'id' => 'bairro')) !!}
                                @else
                                    {!! Form::select('pessoa[endereco][bairros_id]', array(), Session::getOldInput('bairro'),array('class' => 'form-control', 'id' => 'bairro')) !!}
                                @endif
                            </div>
                            <div class="form-group col-md-2">
                                {!! Form::label('pessoa[endereco][complemento]', 'Complemento ') !!}
                                {!! Form::text('pessoa[endereco][complemento]', Session::getOldInput('endereco[complemento]'), array('class' => 'form-control')) !!}
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
                                                {!! Form::text('pessoa[email]', Session::getOldInput('pessoa[email]'), array('class' => 'form-control')) !!}
                                            </div>
                                            <div class="form-group col-md-3">
                                                {!! Form::label('pessoa[telefone_fixo]', 'Telefone fixo') !!}
                                                {!! Form::text('pessoa[telefone_fixo]', Session::getOldInput('pessoa[telefone_fixo]') , array('class' => 'form-control phone')) !!}
                                            </div>
                                            <div class="form-group col-md-2">
                                                {!! Form::label('pessoa[celular]', 'Celular') !!}
                                                {!! Form::text('pessoa[celular]', Session::getOldInput('pessoa[celular]'), array('class' => 'form-control phone')) !!}
                                            </div>
                                            <div class="form-group col-md-2">
                                                {!! Form::label('pessoa[celular2]', 'Celular 2') !!}
                                                {!! Form::text('pessoa[celular2]', Session::getOldInput('pessoa[celular2]'), array('class' => 'form-control phone')) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{--<div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#endprof"> <i
                                                    class="fa fa-plus-circle"></i> Contato profissional</a>
                                    </h4>
                                </div>
                                <div id="endprof" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                {!! Form::label('nome_emp', 'Nome da empresa') !!}
                                                {!! Form::text('nome_emp',Session::getOldInput('nome'), array('class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                       --}}{{-- <div class="row">
                                            <div class="form-group col-md-3">
                                                {!! Form::label('uf_pro', 'UF ') !!}
                                                {!! Form::select('uf_pro', array(), Session::getOldInput('nome'), array('class' => 'form-control', 'id' => 'estadoPro')) !!}
                                            </div>
                                            <div class="form-group col-md-4">
                                                {!! Form::label('cidade', 'Cidade ') !!}
                                                {!! Form::select('cidade', array(), Session::getOldInput('nome'),array('class' => 'form-control', 'id' => 'cidadePro')) !!}
                                            </div>
                                            <div class="form-group col-md-3">
                                                {!! Form::label('bairro', 'Bairro ') !!}
                                                {!! Form::select('bairro', array(), Session::getOldInput('nome'),array('class' => 'form-control', 'id' => 'bairroPro')) !!}
                                            </div>
                                            <div class="form-group col-md-2">
                                                {!! Form::label('cep_pro', 'CEP') !!}
                                                {!! Form::text('cep_pro',Session::getOldInput('nome') , array('class' => 'form-control')) !!}
                                            </div>
                                        </div>--}}{{--
                                        <div class="row">
                                            <div class="form-group col-md-8">
                                                {!! Form::label('email_institucional', 'E-mail institucional') !!}
                                                {!! Form::text('email_institucional',Session::getOldInput('nome') , array('class' => 'form-control')) !!}
                                            </div>
                                            <div class="form-group col-md-2">
                                                {!! Form::label('tel_fixo_pro', 'Telefone Fixo') !!}
                                                {!! Form::text('tel_fixo_pro', Session::getOldInput('nome') , array('class' => 'form-control phone')) !!}
                                            </div>
                                            <div class="form-group col-md-2">
                                                {!! Form::label('cel_pro', 'Celular') !!}
                                                {!! Form::text('cel_pro',Session::getOldInput('nome') , array('class' => 'form-control phone')) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="ensMedio">
                <br/>
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            {{--<div class="form-group col-md-5">--}}
                                {{--<label for="fac_cursos_superiores_id">Formação Acadêmica</label>--}}
                                {{--<select id="formacao" name="fac_cursos_superiores_id" class="form-control">--}}
                                    {{--@if(isset($aluno->id) && $aluno->cursoSuperior != null)--}}
                                        {{--<option value="{{ $aluno->cursoSuperior->id  }}" selected="selected">{{ $aluno->cursoSuperior->nome }}</option>--}}
                                    {{--@endif--}}
                                {{--</select>--}}
                            {{--</div>--}}
                            <div class="form-group col-md-10">
                                <label for="instituicao">Instituição</label><br>
                                <select id="instituicao" class="form-control" name="pessoa[instituicao_escolar_id]">
                                    @if(isset($aluno->id) && $aluno->pessoa->instituicaoEscolar != null)
                                        <option value="{{ $aluno->pessoa->instituicaoEscolar->id  }}" selected="selected">{{ $aluno->pessoa->instituicaoEscolar->nome }}</option>
                                    @endif
                                </select>
                            </div>

                            <div class="form-group col-md-2">
                                {!! Form::label('pessoa[ano_conclusao_medio]', 'Ano Conclusão') !!}
                                {!! Form::text('pessoa[ano_conclusao_medio]', Session::getOldInput('pessoa[ano_conclusao_medio]'), array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                {!! Form::label('pessoa[outra_escola]', 'Outra Instituição') !!}
                                {!! Form::text('pessoa[outra_escola]', Session::getOldInput('pessoa[outra_escola]'), array('class' => 'form-control')) !!}
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{--Aba Documentos Obrigatorios--}}{{--
            <div role="tabpanel" class="tab-pane" id="documentosObrig">
                <br/>

                <div class="row">
                    --}}{{--Primeria coluna--}}{{--
                    <div class="col-md-6">

                        <div class="checkbox checkbox-primary">
                            {!! Form::hidden('rg_doc_obrigatorio', 0) !!}
                            {!! Form::checkbox('rg_doc_obrigatorio', 1, null, array('class' => 'form-control')) !!}
                            {!! Form::label('rg_doc_obrigatorio', 'RG', false) !!}
                        </div>

                        <div class="checkbox checkbox-primary">
                            {!! Form::hidden('cpf_doc_obrigatorio', 0) !!}
                            {!! Form::checkbox('cpf_doc_obrigatorio', 1, null, array('class' => 'form-control')) !!}
                            {!! Form::label('cpf_doc_obrigatorio', 'CPF', false) !!}
                        </div>

                        <!-- Certidão de Nascimento ou Casamento -->
                        <div class="checkbox checkbox-primary">
                            {!! Form::hidden('certidao_nasc_cas_doc_obrigatorio', 0) !!}
                            {!! Form::checkbox('certidao_nasc_cas_doc_obrigatorio', 1, null, array('class' => 'form-control')) !!}
                            {!! Form::label('certidao_nasc_cas_doc_obrigatorio', 'Certidão de nascimento ou casamento ', false) !!}
                        </div>
                        <!-- Fim Certidão de Nascimento ou Casamento -->

                        <!-- Título de Eleitor e último comprovante de votação -->
                        <div class="checkbox checkbox-primary">
                            {!! Form::hidden('titulo_eleitor_doc_obrigatorio', 0) !!}
                            {!! Form::checkbox('titulo_eleitor_doc_obrigatorio', 1, null, array('class' => 'form-control')) !!}
                            {!! Form::label('titulo_eleitor_doc_obrigatorio', 'Título de eleitor e comprovante de votação', false) !!}
                        </div>
                        <!-- Fim Título de Eleitor e último comprovante de votação -->

                        <!-- Histórico Graduação Autenticado -->
                        <div class="checkbox checkbox-primary">
                            {!! Form::hidden('histo_gradu_autentic_obrigatorio', 0) !!}
                            {!! Form::checkbox('histo_gradu_autentic_obrigatorio', 1, null, array('class' => 'form-control')) !!}
                            {!! Form::label('histo_gradu_autentic_obrigatorio', 'Histórico Graduação Autenticado', false) !!}
                        </div>
                        <!-- Fim Histórico Graduação Autenticado -->

                    </div>
                    --}}{{--Fim da Primeria coluna--}}{{--

                    --}}{{--Segunda coluna--}}{{--
                    <div class="col-md-6">

                        <!-- Título de Eleitor e último comprovante de votação -->
                        <div class="checkbox checkbox-primary">
                            {!! Form::hidden('reservista_doc_obrigatorio', 0) !!}
                            {!! Form::checkbox('reservista_doc_obrigatorio', 1, null, array('class' => 'form-control')) !!}
                            {!! Form::label('reservista_doc_obrigatorio', 'Atestado de alaistamento militar ou reservista', false) !!}
                        </div>
                        <!-- Fim Título de Eleitor e último comprovante de votação -->

                        <!-- Título de Eleitor e último comprovante de votação -->
                        <div class="checkbox checkbox-primary">
                            {!! Form::hidden('diploma_doc_obrigatorio', 0) !!}
                            {!! Form::checkbox('diploma_doc_obrigatorio', 1, null, array('class' => 'form-control')) !!}
                            {!! Form::label('diploma_doc_obrigatorio', 'Diploma de graduação (cópia autenticada) ou certidão de conclusão com comprovante de entrada na tramitação do diploma', false) !!}
                        </div>
                        <!-- Fim Título de Eleitor e último comprovante de votação -->


                        <!-- Título de Eleitor e último comprovante de votação -->
                        <div class="checkbox checkbox-primary">
                            {!! Form::hidden('fotos_3x4_doc_obrigatorio', 0) !!}
                            {!! Form::checkbox('fotos_3x4_doc_obrigatorio', 1, null, array('class' => 'form-control')) !!}
                            {!! Form::label('fotos_3x4_doc_obrigatorio', '2 fotos 3x4', false) !!}
                        </div>
                        <!-- Fim Título de Eleitor e último comprovante de votação -->


                        <!-- Título de Eleitor e último comprovante de votação -->
                        <div class="checkbox checkbox-primary">
                            {!! Form::hidden('comp_residencia_doc_obrigatorio', 0) !!}
                            {!! Form::checkbox('comp_residencia_doc_obrigatorio', 1, null, array('class' => 'form-control')) !!}
                            {!! Form::label('comp_residencia_doc_obrigatorio', 'Comprovante de residência ', false) !!}
                        </div>
                        <!-- Fim Título de Eleitor e último comprovante de votação -->

                    </div>
                    --}}{{--Fim da Segunda coluna--}}{{--
                </div>
            </div>
            --}}{{--Aba Documentos Obrigatorios--}}

            {{-- Aba vestibular --}}
            <div role="tabpanel" class="tab-pane" id="vestibular">
                <br>

                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="form-group col-md-4">
                                {!! Form::label('vestibular_id', 'Vestibular * ') !!}
                               
                                @if(isset($aluno->vestibular->id))
                                    {!! Form::select('vestibular_id', (['' => 'Selecione um vestibular'] + $loadFields['graduacao\\vestibular']->toArray()), null, array('class' => 'form-control', 'disabled'=>'disabled')) !!}
                                @else
                                    {!! Form::select('vestibular_id', (['' => 'Selecione um vestibular'] + $loadFields['graduacao\\vestibular']->toArray()), null, array('class' => 'form-control')) !!}
                                @endif

                            </div>
                            {{--<div class="form-group col-md-4">--}}
                                {{--{!! Form::label('linguagem_estrangeira_id', 'Linguagem Estrangeira ') !!}--}}
                                {{--{!! Form::select('linguagem_estrangeira_id', $loadFields['linguaextrangeira'], Session::getOldInput('vestibular_id'), array('class' => 'form-control')) !!}--}}
                            {{--</div>--}}
                            <div class="form-group col-md-2">
                                {!! Form::label('inscricao', 'Inscricao * ') !!}
                                @if(isset($aluno->vestibular->codigo))
                                    {!! Form::text('inscricao', $aluno->vestibular->codigo . "" . $aluno->inscricao , array('class' => 'form-control', 'disabled' => 'disabled')) !!}
                                @else
                                    {!! Form::text('inscricao', Session::getOldInput('inscricao'), array('class' => 'form-control', 'disabled' => 'disabled')) !!}
                                @endif

                            </div>
                            <div class="form-group col-md-2">
                                {!! Form::label('pre_matricula', 'Pré-Matrícula ') !!}
                                {!! Form::text('pre_matricula', Session::getOldInput('pre_matricula'), array('class' => 'form-control')) !!}
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <?php $now =  new \DateTime('now'); ?>
                                {!! Form::label('data_insricao_vestibular', 'Data Inscricao * ') !!}
                                {!! Form::text('data_insricao_vestibular', $now->format('d/m/Y'), array('class' => 'form-control', 'readonly' => 'readonly')) !!}
                            </div>
                            <div class="form-group col-md-4">
                                {!! Form::label('sala_vestibular_id', 'Sala ') !!}
                                {!! Form::select('sala_vestibular_id', (['' => 'Selecione uma sala'] + $loadFields['sala']->toArray()), Session::getOldInput('sala_vestibular_id'), array('class' => 'form-control')) !!}
                            </div>
                        </div>

                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#cursos" aria-controls="cursos" data-toggle="tab"><i class="fa fa-male"></i>Opções de Cursos</a>
                            </li>
                            <li role="presentation">
                                <a href="#enem" aria-controls="enem" role="tab" data-toggle="tab"><i class="fa fa-globe"></i>Enem</a>
                            </li>
                            <li role="presentation">
                                <a href="#comprovantes" aria-controls="comprovantes" role="tab" data-toggle="tab"><i class="fa fa-globe"></i>Comprovantes</a>
                            </li>
                            <li role="presentation">
                                <a href="#ficha19" aria-controls="ficha19" role="tab" data-toggle="tab"><i class="fa fa-globe"></i>Ficha 19</a>
                            </li>
                        </ul>
                        <!-- End Nav tabs -->

                        <!-- Conteúdo das abas de vestibular-->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="cursos">
                                <br>
                                <div class="row">
                                    <div class="form-group col-md-8">
                                        {!! Form::label('primeira_opcao_curso_id', '1º Opção * ') !!}
                                        @if(isset($aluno->primeira_opcao_curso_id))
                                            {!! Form::select('primeira_opcao_curso_id', [$aluno->primeiraOpcaoCurso->id => $aluno->primeiraOpcaoCurso->nome ], $aluno->primeira_opcao_curso_id, array('class' => 'form-control', 'id' => 'primeira_opcao_curso_id')) !!}
                                        @else
                                            {!! Form::select('primeira_opcao_curso_id', [], null, array('class' => 'form-control', 'id' => 'primeira_opcao_curso_id')) !!}
                                        @endif
                                    </div>
                                    <div class="form-group col-md-4">
                                        {!! Form::label('primeira_opcao_turno_id', 'Opção Turno *') !!}
                                        @if(isset($aluno->primeira_opcao_turno_id))
                                            {!! Form::select('primeira_opcao_turno_id', [$aluno->primeiraOpcaoTurno->id => $aluno->primeiraOpcaoTurno->nome ], $aluno->primeira_opcao_turno_id, array('class' => 'form-control', 'id' => 'primeira_opcao_turno_id')) !!}
                                        @else
                                            {!! Form::select('primeira_opcao_turno_id', [], null, array('class' => 'form-control', 'id' => 'primeira_opcao_turno_id')) !!}
                                        @endif
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-8">
                                        {!! Form::label('segunda_opcao_curso_id', '2º Opção ') !!}
                                        @if(isset($aluno->segunda_opcao_curso_id))
                                            {!! Form::select('segunda_opcao_curso_id', [$aluno->segundaOpcaoCurso->id => $aluno->segundaOpcaoCurso->nome ], $aluno->segunda_opcao_curso_id, array('class' => 'form-control', 'id' => 'segunda_opcao_curso_id')) !!}
                                        @else
                                            {!! Form::select('segunda_opcao_curso_id', [], null, array('class' => 'form-control', 'id' => 'segunda_opcao_curso_id')) !!}
                                        @endif
                                    </div>
                                    <div class="form-group col-md-4">
                                        {!! Form::label('segunda_opcao_turno_id', 'Opção Turno') !!}
                                        @if(isset($aluno->segunda_opcao_turno_id))
                                            {!! Form::select('segunda_opcao_turno_id', [$aluno->segundaOpcaoTurno->id => $aluno->segundaOpcaoTurno->nome ], $aluno->segunda_opcao_turno_id, array('class' => 'form-control', 'id' => 'segunda_opcao_turno_id')) !!}
                                        @else
                                            {!! Form::select('segunda_opcao_turno_id', [], null, array('class' => 'form-control', 'id' => 'segunda_opcao_turno_id')) !!}
                                        @endif
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-8">
                                        {!! Form::label('terceira_opcao_curso_id', '3º Opção ') !!}
                                        @if(isset($aluno->terceira_opcao_curso_id))
                                            {!! Form::select('terceira_opcao_curso_id', [$aluno->terceiraOpcaoCurso->id => $aluno->terceiraOpcaoCurso->nome ], $aluno->terceira_opcao_curso_id, array('class' => 'form-control', 'id' => 'terceira_opcao_curso_id')) !!}
                                        @else
                                            {!! Form::select('terceira_opcao_curso_id', [], null, array('class' => 'form-control', 'id' => 'terceira_opcao_curso_id')) !!}
                                        @endif
                                    </div>
                                    <div class="form-group col-md-4">
                                        {!! Form::label('terceira_opcao_turno_id', 'Opção Turno') !!}
                                        @if(isset($aluno->terceira_opcao_turno_id))
                                            {!! Form::select('terceira_opcao_turno_id', [$aluno->terceiraOpcaoTurno->id => $aluno->terceiraOpcaoTurno->nome ], $aluno->terceira_opcao_turno_id, array('class' => 'form-control', 'id' => 'terceira_opcao_turno_id')) !!}
                                        @else
                                            {!! Form::select('terceira_opcao_turno_id', [], null, array('class' => 'form-control', 'id' => 'terceira_opcao_turno_id')) !!}
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane" id="enem">
                                <br>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        {!! Form::label('ano_enem', 'Ano ') !!}
                                        {!! Form::text('ano_enem', Session::getOldInput('ano_enem'), array('class' => 'form-control')) !!}
                                    </div>

                                    <div class="form-group col-md-4">
                                        {!! Form::label('inscricao_enem', 'Inscrição ') !!}
                                        {!! Form::text('inscricao_enem', Session::getOldInput('inscricao_enem'), array('class' => 'form-control')) !!}
                                    </div>

                                    <div class="form-group col-md-4">
                                        {!! Form::label('nota_redacao', 'Redação ') !!}
                                        {!! Form::text('nota_redacao', Session::getOldInput('nota_redacao'), array('class' => 'form-control numberFor')) !!}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        {!! Form::label('nota_humanas', 'Ciências Humanas e suas Tecnologias ') !!}
                                        {!! Form::text('nota_humanas', Session::getOldInput('nota_humanas'), array('class' => 'form-control numberFor')) !!}
                                    </div>

                                    <div class="form-group col-md-4">
                                        {!! Form::label('nota_natureza', 'Ciências da Natureza e suas Tecnologias ') !!}
                                        {!! Form::text('nota_natureza', Session::getOldInput('nota_natureza'), array('class' => 'form-control numberFor')) !!}
                                    </div>

                                    <div class="form-group col-md-4">
                                        {!! Form::label('nota_linguagem', 'Linguagens, Códigos e suas Tecnologias ') !!}
                                        {!! Form::text('nota_linguagem', Session::getOldInput('nota_linguagem'), array('class' => 'form-control numberFor')) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        {!! Form::label('nota_matematica', 'Matemática e suas Tecnologias ') !!}
                                        {!! Form::text('nota_matematica', Session::getOldInput('nota_natureza'), array('class' => 'form-control numberFor')) !!}
                                    </div>
                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane" id="comprovantes">
                                <br>
                                <div class="form-group col-md-4">
                                    <label for="path_comprovante_enem">ENEM</label>
                                    <input class="file-preview-other" name="path_comprovante_enem" id="path_comprovante_enem" type="file">



                                    {{--<div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 135px; height: 115px;">
                                            @if (isset($aluno) && $aluno->path_comprovante_enem != null)
                                            <div id="midias">
                                                <img id="img_comprovante_endereco" src="/images/{{$aluno->path_comprovante_endereco}}"  alt="Foto" height="120" width="100"/><br/>
                                            </div>
                                            @endif
                                        </div>
                                        <div>
                                            <span class="btn btn-primary btn-xs btn-block btn-file">
                                            <span class="fileinput-new">Anexo (Enem)</span>
                                            <span class="fileinput-exists">Mudar</span>
                                            <input type="file" name="path_comprovante_enem">
                                            </span>
                                            <a href="#" class="btn btn-warning btn-xs fileinput-exists col-md-6" data-dismiss="fileinput">Remover</a>
                                        </div>
                                    </div>--}}
                                </div>

                                <div class="col-md-4">
                                    <label for="path_comprovante_endereco">ENDEREÇO</label>
                                    <input name="path_comprovante_endereco" id="path_comprovante_endereco" type="file">
                                    {{--<div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 135px; height: 115px;">
                                            @if (isset($aluno) && $aluno->path_comprovante_endereco != null)
                                                <div id="midias">
                                                    <img id="img_comprovante_endereco" src="/images/{{$aluno->path_comprovante_endereco}}"  alt="Foto" height="120" width="100"/><br/>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <span class="btn btn-primary btn-xs btn-block btn-file">
                                            <span class="fileinput-new">Anexo (Endereço)</span>
                                            <span class="fileinput-exists">Mudar</span>
                                            <input type="file" name="path_comprovante_endereco">
                                            </span>
                                            <a href="#" class="btn btn-warning btn-xs fileinput-exists col-md-6" data-dismiss="fileinput">Remover</a>
                                        </div>
                                    </div>--}}
                                </div>

                                <div class="col-md-4">
                                    <label for="path_comprovante_ficha19">FICHA 19</label>
                                    <input name="path_comprovante_ficha19" id="path_comprovante_ficha19" type="file">


                                    {{--<div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 135px; height: 115px;">
                                            @if (isset($aluno) && $aluno->path_comprovante_ficha19 != null)
                                                <div id="midias">
                                                    <img id="img_comprovante_endereco" src="/images/{{$aluno->path_comprovante_ficha19}}"  alt="Foto" height="120" width="100"/><br/>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <span class="btn btn-primary btn-xs btn-block btn-file">
                                            <span class="fileinput-new">Anexo (Ficha 19)</span>
                                            <span class="fileinput-exists">Mudar</span>
                                            <input type="file" name="path_comprovante_ficha19">
                                            </span>
                                            <a href="#" class="btn btn-warning btn-xs fileinput-exists col-md-6" data-dismiss="fileinput">Remover</a>
                                        </div>
                                    </div>
                                </div>--}}
                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane" id="ficha19">
                                <br>
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        {!! Form::label('ficha_nota_portugues', 'Língua Portuguesa') !!}
                                        {!! Form::text('ficha_nota_portugues', Session::getOldInput('ficha_nota_portugues'), array('class' => 'form-control notasComuns')) !!}
                                    </div>

                                    <div class="form-group col-md-4">
                                        {!! Form::label('ficha_nota_matematica', 'Matemática') !!}
                                        {!! Form::text('ficha_nota_matematica', Session::getOldInput('ficha_nota_matematica'), array('class' => 'form-control notasComuns')) !!}
                                    </div>

                                    <div class="form-group col-md-4">
                                        {!! Form::label('ficha_nota_historia', 'História') !!}
                                        {!! Form::text('ficha_nota_historia', Session::getOldInput('ficha_nota_historia'), array('class' => 'form-control notasComuns')) !!}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        {!! Form::label('ficha_nota_geografia', 'Geografia') !!}
                                        {!! Form::text('ficha_nota_geografia', Session::getOldInput('ficha_nota_geografia'), array('class' => 'form-control notasComuns')) !!}
                                    </div>

                                    <div class="form-group col-md-4">
                                        {!! Form::label('ficha_nota_sociologia', 'Sociologia') !!}
                                        {!! Form::text('ficha_nota_sociologia', Session::getOldInput('ficha_nota_sociologia'), array('class' => 'form-control notasComuns')) !!}
                                    </div>

                                    <div class="form-group col-md-4">
                                        {!! Form::label('ficha_nota_filosofia', 'Filosofia') !!}
                                        {!! Form::text('ficha_nota_filosofia', Session::getOldInput('ficha_nota_filosofia'), array('class' => 'form-control notasComuns')) !!}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        {!! Form::label('ficha_nota_biologia', 'Biologia') !!}
                                        {!! Form::text('ficha_nota_biologia', Session::getOldInput('ficha_nota_biologia'), array('class' => 'form-control notasComuns')) !!}
                                    </div>

                                    <div class="form-group col-md-4">
                                        {!! Form::label('ficha_nota_lingua_estrangeira', 'Lígua estrangeira') !!}
                                        {!! Form::text('ficha_nota_lingua_estrangeira', Session::getOldInput('ficha_nota_lingua_estrangeira'), array('class' => 'form-control notasComuns')) !!}
                                    </div>

                                    <div class="form-group col-md-4">
                                        {!! Form::label('ficha_nota_quimica', 'Química') !!}
                                        {!! Form::text('ficha_nota_quimica', Session::getOldInput('ficha_nota_quimica'), array('class' => 'form-control notasComuns')) !!}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        {!! Form::label('ficha_nota_fisica', 'Física') !!}
                                        {!! Form::text('ficha_nota_fisica', Session::getOldInput('ficha_nota_fisica'), array('class' => 'form-control notasComuns')) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Fim da aba vestibular --}}
        </div>
    </div>
    <div class="col-md-10"></div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group col-md-4">
                <div class="checkbox checkbox-primary">
                    @if(isset($aluno) && $aluno->gerar_inscricao == 1)
                        {!! Form::checkbox('gerar_inscricao', 1, null, array('class' => 'form-control', 'disabled' => 'disabled')) !!}
                    @else
                        {!! Form::hidden('gerar_inscricao', 0) !!}
                        {!! Form::checkbox('gerar_inscricao', 1, null, array('class' => 'form-control')) !!}
                    @endif
                    {!! Form::label('gerar_inscricao', 'Gerar número de inscrição', false) !!}
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
                    <a href="{{ route('seracademico.vestibulando.index') }}" class="btn btn-primary btn-block pull-right">Voltar</a>
                </div>
                <div class="btn-group">
                    {!! Form::submit('Salvar', array('class' => 'btn btn-primary btn-block pull-right', 'id' => 'submitForm')) !!}
                </div>
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

        //consulta via select2
        $("#instituicao").select2({
            placeholder: 'Selecione uma instituição',
            minimumInputLength: 3,
            width: 750,
            ajax: {
                type: 'POST',
                url: "{{ route('seracademico.util.select2')  }}",
                dataType: 'json',
                delay: 250,
                crossDomain: true,
                data: function (params) {
                    return {
                        'search':     params.term, // search term
                        'tableName':  'fac_instituicoes',
                        'fieldName':  'nome',
                        'fieldWhere':  'nivel',
                        'valueWhere':  '2',
                        'page':       params.page || 1
                    };
                },
                headers: {
                    'X-CSRF-TOKEN' : '{{  csrf_token() }}'
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
        $("#formacao").select2({
            placeholder: 'Selecione uma formação acadêmica',
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
                        'search':     params.term, // search term
                        'tableName':  'fac_cursos_superiores',
                        'fieldName':  'nome',
                        'page':       params.page || 1
                    };
                },
                headers: {
                    'X-CSRF-TOKEN' : '{{  csrf_token() }}'
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

        // Validações javascript
        $('#formVestibulando').bootstrapValidator({
            fields: {
                'pessoa[nome]': {
                    validators: {
                        notEmpty: {
                            message: Lang.get('validation.required', { attribute: 'Nome' })
                        },
                        stringLength: {
                            max: 50,
                            message: Lang.get('validation.max', { attribute: 'Nome' })
                        }
                    }
                },
                'pessoa[data_nasciemento]': {
                    validators: {
                        notEmpty: {
                            message: Lang.get('validation.required', { attribute: 'Data Nascimento' })
                        }
                    }
                },
                'pessoa[cpf]': {
                    validators: {
                        notEmpty: {
                            message: Lang.get('validation.required', { attribute: 'CPF' })
                        }
                    }
                },
                'pessoa[nome_pai]': {
                    validators: {
                        notEmpty: {
                            message: Lang.get('validation.required', { attribute: 'Nome Pai' })
                        }
                    }
                },
                'pessoa[nome_mae]': {
                    validators: {
                        notEmpty: {
                            message: Lang.get('validation.required', { attribute: 'Nome Mae' })
                        }
                    }
                },
                'pessoa[identidade]': {
                    validators: {
                        notEmpty: {
                            message: Lang.get('validation.required', { attribute: 'Identidade' })
                        }
                    }
                },
                'vestibular_id': {
                    validators: {
                        notEmpty: {
                            message: Lang.get('validation.required', { attribute: 'Vestibular' })
                        }
                    }
                },
                'data_insricao_vestibular': {
                    validators: {
                        notEmpty: {
                            message: Lang.get('validation.required', { attribute: 'Data da inscrição' })
                        }
                    }
                },
                'primeira_opcao_curso_id': {
                    validators: {
                        notEmpty: {
                            message: Lang.get('validation.required', { attribute: 'Primeira opção de curso' })
                        }
                    }
                },
                'primeira_opcao_turno_id': {
                    validators: {
                        notEmpty: {
                            message: Lang.get('validation.required', { attribute: 'Primeira opção de turno' })
                        }
                    }
                }

            },
        });

        // Regra para carregamento dos cursos a partir do vestibular escolhido
        $(document).on('change', '#vestibular_id', function () {
            // Recuperando o id do vestibular selecionado
            var vestibularId = $(this).find("option:selected").val();

            // Verificando o id do vestibular
            if(vestibularId) {
                jQuery.ajax({
                    type: 'POST',
                    url: '{{ route('seracademico.graduacao.curso.getByVestibular')  }}',
                    headers: {
                        'X-CSRF-TOKEN': '{{  csrf_token() }}'
                    },
                    data: {'vestibularId' : vestibularId},
                    datatype: 'json'
                }).done(function (json) {
                    var option = "";

                    option += '<option value="">Selecione um Curso</option>';
                    for (var i = 0; i < json.data.length; i++) {
                        option += '<option value="' + json.data[i]['id'] + '">' + json.data[i]['nome'] + '</option>';
                    }

                    $('#primeira_opcao_curso_id option').remove();
                    $('#primeira_opcao_curso_id').append(option);

                    $('#segunda_opcao_curso_id option').remove();
                    $('#segunda_opcao_curso_id').append(option);

                    $('#terceira_opcao_curso_id option').remove();
                    $('#terceira_opcao_curso_id').append(option);
                });
            }
        });

        // Evento para pesquisar o cpf do digito no search
        $(document).on('click', '#btnSearchCpf', function () {
            // Recuperndo o valor da consulta
            var serachValue = $("#searchCpf").val();

            // Verificando se algum valor foi digitado
            if (!serachValue) {
                swal("Você precisa digitar um cpf", "Click no botão ok para voltar a página", "error");
                return false;
            }

            // Requisição ajax
            jQuery.ajax({
                type: 'POST',
                url: '{{ route('seracademico.vestibulando.search')  }}',
                data: {'cpf': serachValue},
                datatype: 'json'
            }).done(function (json) {
                if (json.success) {
                    $("input:text[name='pessoa[nome]']").val(json.dados[0].nome);
                    $("input:text[name='pessoa[data_nasciemento]']").val(json.dados[0].data_nasciemento);
                    $("select[name='pessoa[sexos_id]'] option[value='" + json.dados[0].sexos_id + "']").attr("selected", "selected");
                    $("select[name='pessoa[estados_civis_id]'] option[value='" + json.dados[0].estados_civis_id + "']").attr("selected", "selected");
                    $("select[name='pessoa[cores_racas_id]'] option[value='" + json.dados[0].cores_racas_id + "']").attr("selected", "selected");
                    $("select[name='pessoa[tipos_sanguinios_id]'] option[value='" + json.dados[0].tipos_sanguinios_id + "']").attr("selected", "selected");
                    $("input:text[name='pessoa[nacionalidade]']").val(json.dados[0].nacionalidade);
                    $("select[name='pessoa[uf_nascimento_id]'] option[value='" + json.dados[0].uf_nascimento_id + "']").attr("selected", "selected");
                    $("input:text[name='pessoa[naturalidade]']").val(json.dados[0].naturalidade);
                    $("input:text[name='pessoa[nome_pai]']").val(json.dados[0].nome_pai);
                    $("input:text[name='pessoa[nome_mae]']").val(json.dados[0].nome_mae);
                    $("input:text[name='pessoa[identidade]']").val(json.dados[0].identidade);
                    $("input:text[name='pessoa[orgao_rg]']").val(json.dados[0].orgao_rg);
                    $("input:text[name='pessoa[data_expedicao]']").val(json.dados[0].data_expedicao);
                    $("input:text[name='pessoa[cpf]']").val(json.dados[0].cpf);
                    $("input:text[name='pessoa[cpf]']").prop('readonly', true);
                    $("input:text[name='pessoa[titulo_eleitoral]']").val(json.dados[0].titulo_eleitoral);
                    $("input:text[name='pessoa[zona]']").val(json.dados[0].zona);
                    $("input:text[name='pessoa[secao]']").val(json.dados[0].secao);
                    $("input:text[name='pessoa[resevista]']").val(json.dados[0].resevista);
                    $("input:text[name='pessoa[catagoria_resevista]']").val(json.dados[0].catagoria_resevista);
                    $("input:checkbox[name='pessoa[deficiencia_fisica]']").attr('checked', json.dados[0].deficiencia_fisica);
                    $("input:checkbox[name='pessoa[deficiencia_auditiva]']").attr('checked', json.dados[0].deficiencia_auditiva);
                    $("input:checkbox[name='pessoa[deficiencia_visual]']").attr('checked', json.dados[0].deficiencia_visual);
                    $("input:checkbox[name='pessoa[deficiencia_outra]']").attr('checked', json.dados[0].deficiencia_outra);
                    $("input:text[name='pessoa[endereco][logradouro]']").val(json.dados[0].endereco.logradouro);
                    $("input:text[name='pessoa[endereco][cep]']").val(json.dados[0].endereco.cep);
                    $("input:text[name='pessoa[endereco][numero]']").val(json.dados[0].endereco.numero);

                    // Validando o estado
                    if (json.dados[0].endereco.bairro) {
                        $("select[name='estado'] option[value='" + json.dados[0].endereco.bairro.cidade.estado.id + "']").attr("selected", "selected");
                        $("select[name='cidade']").append("<option value='" + json.dados[0].endereco.bairro.cidade.id + "'>" + json.dados[0].endereco.bairro.cidade.nome + "</option>");
                        $("select[name='pessoa[endereco][bairros_id]']").append("<option value='" + json.dados[0].endereco.bairro.id + "'>" + json.dados[0].endereco.bairro.nome + "</option>");
                    }

                    $("input:text[name='pessoa[endereco][complemento]']").val(json.dados[0].endereco.complemento);
                    $("input:text[name='pessoa[email]']").val(json.dados[0].email);
                    $("input:text[name='pessoa[telefone_fixo]']").val(json.dados[0].telefone_fixo);
                    $("input:text[name='pessoa[celular]']").val(json.dados[0].celular);
                    $("input:text[name='pessoa[celular2]']").val(json.dados[0].celular2);
                    $("input:text[name='pessoa[ano_conclusao_medio]']").val(json.dados[0].ano_conclusao_medio);
                    $("input:text[name='pessoa[outra_escola]']").val(json.dados[0].outra_escola);

                    // Validando a instituição escolar
                    if (json.dados[0].instituicao_escolar) {
                        $("#instituicao").append($('<option>', {
                            value: json.dados[0].instituicao_escolar.id,
                            text: json.dados[0].instituicao_escolar.nome
                        }));
                        $("#instituicao option[name='" + json.dados[0].instituicao_escolar.id + "']").prop('selected', true);
                        $('#instituicao').trigger('change');
                    }
                } else {
                    swal(json.msg, "Click no botão ok para voltar a página", "error");
                    return false;
                }
            });
        });

        // Evento para selecionar os turnos da primeira opção de curso
        $(document).on('change', '#primeira_opcao_curso_id', function () {
            // Recuperando o id do curso
            var idCurso = $(this).find('option:selected').val();

            // verificando se o curso foi selecionado
            if(idCurso) {
                // recuperando os options
                getTurnosByCurso(idCurso, '#primeira_opcao_turno_id');
            }
        });

        // Evento para selecionar os turnos da segunda opção de curso
        $(document).on('change', '#segunda_opcao_curso_id', function () {
            // Recuperando o id do curso
            var idCurso = $(this).find('option:selected').val();

            // verificando se o curso foi selecionado
            if(idCurso) {
                // recuperando os options
                getTurnosByCurso(idCurso, '#segunda_opcao_turno_id');
            }
        });

        // Evento para selecionar os turnos da segunda opção de curso
        $(document).on('change', '#terceira_opcao_curso_id', function () {
            // Recuperando o id do curso
            var idCurso = $(this).find('option:selected').val();

            // verificando se o curso foi selecionado
            if(idCurso) {
                // Gerando os options
                getTurnosByCurso(idCurso, '#terceira_opcao_turno_id');
            }
        });

        /**
         *
         * @param idCurso
         * @param idHtml
         */
        function getTurnosByCurso (idCurso, idHtml) {
            // Requisição ajax
            jQuery.ajax({
                type: 'POST',
                url: '{{ route('seracademico.graduacao.curso.getTurnosByCurso')  }}',
                headers: {
                    'X-CSRF-TOKEN': '{{  csrf_token() }}'
                },
                data: {'idCurso' : idCurso},
                datatype: 'json'
            }).done(function (json) {
                // Variável que armazenará o html
                var options = '';

                // Criando os options
                options += '<option value="">Selecione um Turno</option>';
                for (var i = 0; i < json.data.length; i++) {
                    options += '<option value="' + json.data[i]['id'] + '">' + json.data[i]['nome'] + '</option>';
                }

                // Gerando o html
                $(idHtml).find('option').remove();
                $(idHtml).append(options);
            });
        }

        $("#path_comprovante_enem").fileinput({
            @if($aluno->path_comprovante_enem)
                initialPreviewFileType: 'object',
                initialPreview:[
                    '/images/{{$aluno->path_comprovante_enem}}'
                ],
                initialPreviewAsData: true,
                initialPreviewConfig: [{
                    caption: 'comprovante-enem.pdf',
                    filetype: 'application/pdf',
                    url: false,
                    width: '100%'
                }],
            @endif

            language: 'pt-BR',
            showUpload: false,
            showCaption: false,
            allowedFileExtensions : ['pdf'],
        });

        $("#path_comprovante_endereco").fileinput({
            @if($aluno->path_comprovante_endereco)
                initialPreviewFileType: 'object',
                initialPreview:[
                    '/images/{{$aluno->path_comprovante_endereco}}'
                ],
                initialPreviewAsData: true,
                initialPreviewConfig: [{
                    caption: 'comprovante-endereco.pdf',
                    filetype: 'application/pdf',
                    url: false,
                    width: '100%'
                }],
            @endif
            language: 'pt-BR',
            showUpload: false,
            showCaption: false,
            allowedFileExtensions : ['pdf'],
        });

        $("#path_comprovante_ficha19").fileinput({
            @if($aluno->path_comprovante_ficha19)
                initialPreviewFileType: 'object',
                initialPreview:[
                    '/images/{{$aluno->path_comprovante_ficha19}}'
                ],
                initialPreviewAsData: true,
                initialPreviewConfig: [{
                    caption: 'comprovante-ficha19.pdf',
                    filetype: 'application/pdf',
                    url: false,
                    width: '100%'
                }],
            @endif
            language: 'pt-BR',
            showUpload: false,
            showCaption: false,
            allowedFileExtensions : ['pdf'],
        });
    </script>

@stop

