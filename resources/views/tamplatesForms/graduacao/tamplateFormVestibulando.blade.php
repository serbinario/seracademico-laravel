<div class="row">
    <div class="col-md-12">
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
                            <div class="form-group col-md-4">
                                {!! Form::label('linguagem_estrangeira_id', 'Linguagem Estrangeira ') !!}
                                {!! Form::select('linguagem_estrangeira_id', $loadFields['linguaextrangeira'], Session::getOldInput('vestibular_id'), array('class' => 'form-control')) !!}
                            </div>
                            <div class="form-group col-md-2">
                                {!! Form::label('inscricao', 'Inscricao * ') !!}
                                {!! Form::text('inscricao', Session::getOldInput('inscricao'), array('class' => 'form-control', 'readonly' => 'readonly')) !!}
                            </div>
                            <div class="form-group col-md-2">
                                {!! Form::label('pre_matricula', 'Pré-Matrícula ') !!}
                                {!! Form::text('pre_matricula', Session::getOldInput('pre_matricula'), array('class' => 'form-control')) !!}
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                {!! Form::label('data_insricao_vestibular', 'Data Inscricao * ') !!}
                                {!! Form::text('data_insricao_vestibular', Session::getOldInput('data_insricao_vestibular'), array('class' => 'form-control datepicker')) !!}
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
                        </ul>
                        <!-- End Nav tabs -->

                        <!-- Conteúdo das abas de vestibular-->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="cursos">
                                <br>
                                <div class="row">
                                    <div class="form-group col-md-8">
                                        {!! Form::label('primeira_opcao_curso_id', '1º Opção * ') !!}
                                        {!! Form::select('primeira_opcao_curso_id', (['' => 'Selecione uma opção'] + $loadFields['graduacao\\curso']->toArray()), Session::getOldInput('primeira_opcao_curso_id'), array('class' => 'form-control')) !!}
                                    </div>
                                    <div class="form-group col-md-4">
                                        {!! Form::label('primeira_opcao_turno_id', 'Opção Turno *') !!}
                                        {!! Form::select('primeira_opcao_turno_id', (['' => 'Selecione uma opção'] + $loadFields['turno']->toArray()), Session::getOldInput('primeira_opcao_turno_id'), array('class' => 'form-control')) !!}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-8">
                                        {!! Form::label('segunda_opcao_curso_id', '2º Opção ') !!}
                                        {!! Form::select('segunda_opcao_curso_id', (['' => 'Selecione uma opção'] + $loadFields['graduacao\\curso']->toArray()), Session::getOldInput('segunda_opcao_curso_id'), array('class' => 'form-control')) !!}
                                    </div>
                                    <div class="form-group col-md-4">
                                        {!! Form::label('segunda_opcao_turno_id', 'Opção Turno') !!}
                                        {!! Form::select('segunda_opcao_turno_id', (['' => 'Selecione uma opção'] + $loadFields['turno']->toArray()), Session::getOldInput('segunda_opcao_turno_id'), array('class' => 'form-control')) !!}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-8">
                                        {!! Form::label('terceira_opcao_curso_id', '3º Opção ') !!}
                                        {!! Form::select('terceira_opcao_curso_id', (['' => 'Selecione uma opção'] + $loadFields['graduacao\\curso']->toArray()), Session::getOldInput('terceira_opcao_curso_id'), array('class' => 'form-control')) !!}
                                    </div>
                                    <div class="form-group col-md-4">
                                        {!! Form::label('terceira_opcao_turno_id', 'Opção Turno') !!}
                                        {!! Form::select('terceira_opcao_turno_id', (['' => 'Selecione uma opção'] + $loadFields['turno']->toArray()), Session::getOldInput('terceira_opcao_turno_id'), array('class' => 'form-control')) !!}
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
                                        {!! Form::text('nota_redacao', Session::getOldInput('inscricao_enem'), array('class' => 'form-control')) !!}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        {!! Form::label('nota_humanas', 'Ciências Humanas e suas Tecnologias ') !!}
                                        {!! Form::text('nota_humanas', Session::getOldInput('nota_humanas'), array('class' => 'form-control')) !!}
                                    </div>

                                    <div class="form-group col-md-4">
                                        {!! Form::label('nota_natureza', 'Ciências da Natureza e suas Tecnologias ') !!}
                                        {!! Form::text('nota_natureza', Session::getOldInput('nota_natureza'), array('class' => 'form-control')) !!}
                                    </div>

                                    <div class="form-group col-md-4">
                                        {!! Form::label('nota_linguagem', 'Linguagens, Códigos e suas Tecnologias ') !!}
                                        {!! Form::text('nota_linguagem', Session::getOldInput('nota_linguagem'), array('class' => 'form-control')) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        {!! Form::label('nota_matematica', 'Matemática e suas Tecnologias ') !!}
                                        {!! Form::text('nota_matematica', Session::getOldInput('nota_natureza'), array('class' => 'form-control')) !!}
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

</div>
