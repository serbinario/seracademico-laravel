<div class="row">
    <div class="col-md-12">
        <!-- Busca por cpf, caso exista em pessoa -->
        @if(!isset($aluno))
            <div class="row">
                <div class="col-md-4 form-group">
                    <label for="searchCpf">DIGITE O CPF SE POSSUIR CADASTRO</label>
                    <div class="input-group">
                        <input type="text" id="searchCpf" class="form-control">
                        <span class="input-group-btn">
                             <a id="btnSearchCpf" class="btn-sm btn-primary">Buscar</a>
                        </span>
                    </div>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="form-group col-md-6">
                {!! Form::label('pessoa[nome]', 'Nome * max 60 caracteres (0-9 A-Z .-[ ])') !!}
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

            <div class="form-group col-md-2">
                {!! Form::label('matricula', 'Matrícula ') !!}
                {!! Form::text('matricula', Session::getOldInput('nome') , array('class' => 'form-control', 'readonly' => 'readonly')) !!}
                <input type="hidden" value="" id="idAluno" name="idAluno">
            </div>

            {{--<div class="form-group col-md-4">--}}
                {{--{!! Form::label('situacao_id', 'Situacao') !!}--}}
                {{--{!! Form::select('situacao_id', $loadFields['situacaoaluno'] , Session::getOldInput('situacao_id'), array('class' => 'form-control')) !!}--}}
            {{--</div>--}}

        </div>
        <div class="row">
            <div class="col-md-4">
                <label for="path_image">IMAGEM</label>
                <input name="path_image" id="path_image" type="file">
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
                <a href="#dados" aria-controls="dados" data-toggle="tab">Dados pessoais</a>
            </li>
            <li role="presentation">
                <a href="#contato" aria-controls="contato" role="tab" data-toggle="tab">Informações para contato</a>
            </li>
            <li role="presentation">
                <a href="#ensMedio" aria-controls="ensMedio" role="tab" data-toggle="tab">2º Grau</a>
            </li>
            <li role="presentation">
                <a href="#documentosObrig" aria-controls="documentosObrig" role="tab" data-toggle="tab">Documentos Obrigatórios</a>
            </li>
            <li role="presentation">
                <a href="#admissao" aria-controls="admissao" role="tab" data-toggle="tab">Admissão</a>
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
                                {!! Form::label('pessoa[estado_civis_id]', 'Estado Civil ') !!}
                                {!! Form::select('pessoa[estado_civis_id]', $loadFields['estadocivil'], Session::getOldInput('pessoa[estado_civis_id]'),array('class' => 'form-control')) !!}
                            </div>
                            <div class="form-group col-md-2">
                                {!! Form::label('pessoa[grau_instrucoes_id]', 'Grau de instrução') !!}
                                {!! Form::select('pessoa[grau_instrucoes_id]', $loadFields['grauinstrucao'], Session::getOldInput('pessoa[grau_instrucoes_id]'),array('class' => 'form-control')) !!}
                            </div>
                            <div class="form-group col-md-4">
                                {!! Form::label('pessoa[profissoes_id]', 'Profissão ') !!}
                                {!! Form::select('pessoa[profissoes_id]', array(), Session::getOldInput('pessoa[profissoes_id]'),array('class' => 'form-control')) !!}
                            </div>
                            <div class="form-group col-md-2">
                                {!! Form::label('pessoa[cores_racas_id]', 'Cor/Raça') !!}
                                {!! Form::select('pessoa[cores_racas_id]', $loadFields['corraca'], Session::getOldInput('pessoa[cores_racas_id]'),array('class' => 'form-control')) !!}
                            </div>
                            <div class="form-group col-md-2">
                                {!! Form::label('pessoa[tipos_sanguinios_id]', 'Tipo Sanguíneo') !!}
                                {!! Form::select('pessoa[tipos_sanguinios_id]', $loadFields['tiposanguinio'] , Session::getOldInput('pessoa[tipos_sanguinios_id]'), array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-3">
                                {!! Form::label('pessoa[nacionalidade]', 'Nacionalidade ') !!}
                                {!! Form::text('pessoa[nacionalidade]', Session::getOldInput('pessoa[nacionalidade]'), array('class' => 'form-control')) !!}
                            </div>
                            <div class="form-group col-md-3">
                                {!! Form::label('pessoa[uf_nascimento_id]', 'UF Nascimento') !!}
                                {!! Form::select('pessoa[uf_nascimento_id]', $loadFields['estado'], Session::getOldInput('pessoa[uf_nascimento_id]'),array('class' => 'form-control')) !!}
                            </div>
                            <div class="form-group col-md-3">
                                {!! Form::label('pessoa[naturalidade]', 'Naturalidade ') !!}
                                {!! Form::text('pessoa[naturalidade]', Session::getOldInput('pessoas[naturalidade]'), array('class' => 'form-control')) !!}
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
                                                {!! Form::label('pessoa[nome_pai]', 'Nome Pai max 60 caracteres (0-9 A-Z .-[ ])') !!}
                                                {!! Form::text('pessoa[nome_pai]', Session::getOldInput('pessoa[nome_pai]'), array('class' => 'form-control')) !!}
                                            </div>
                                            <div class="form-group col-md-6">
                                                {!! Form::label('pessoa[nome_mae]', 'Nome Mãe * max 60 caracteres (0-9 A-Z .-[ ])') !!}
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
                                                {!! Form::text('pessoa[uf_exp]', Session::getOldInput('pessoa[uf_exp]'), array('class' => 'form-control')) !!}
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
                                                {!! Form::text('pessoa[zona]', Session::getOldInput('pessoas[zona]'), array('class' => 'form-control')) !!}
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
                            <div class="form-group col-md-10">
                                {!! Form::label('pessoa[endereco][logradouro]', 'Endereço ') !!}
                                {!! Form::text('pessoa[endereco][logradouro]', Session::getOldInput('pessoa[endereco][logradouro]'), array('class' => 'form-control')) !!}
                            </div>
                            <div class="form-group col-md-2">
                                {!! Form::label('pessoa[endereco][numero]', 'Número: max 6') !!}
                                {!! Form::text('pessoa[endereco][numero]', Session::getOldInput('pessoa[endereco][numero]'), array('class' => 'form-control numberFive')) !!}
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
                                {!! Form::label('pessoas[endereco][bairros_id]', 'Bairro ') !!}
                                @if(isset($aluno->pessoa->endereco->bairro->id))
                                    {!! Form::select('pessoa[endereco][bairros_id]', array($aluno->pessoa->endereco->bairro->id => $aluno->pessoa->endereco->bairro->nome), $aluno->pessoa->endereco->bairro->id,array('class' => 'form-control', 'id' => 'bairro')) !!}
                                @else
                                    {!! Form::select('pessoa[endereco][bairros_id]', array(), null,array('class' => 'form-control', 'id' => 'bairro')) !!}
                                @endif
                            </div>
                            <div class="form-group col-md-2">
                                {!! Form::label('pessoa[endereco][complemento]', 'Complemento ') !!}
                                {!! Form::text('pessoa[endereco][complemento]', Session::getOldInput('pessoa[endereco][complemento]'), array('class' => 'form-control')) !!}
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
                                                {!! Form::text('pessoa[email]', Session::getOldInput('pessoas[email]'), array('class' => 'form-control')) !!}
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
                                {{--<div class="panel-heading">--}}
                                    {{--<h4 class="panel-title">--}}
                                        {{--<a data-toggle="collapse" data-parent="#accordion" href="#endprof"> <i--}}
                                                    {{--class="fa fa-plus-circle"></i> Contato profissional</a>--}}
                                    {{--</h4>--}}
                                {{--</div>--}}
                                {{--<div id="endprof" class="panel-collapse collapse">--}}
                                    {{--<div class="panel-body">--}}
                                        {{--<div class="row">--}}
                                            {{--<div class="form-group col-md-12">--}}
                                                {{--{!! Form::label('pessoa[nome_emp]', 'Nome da empresa') !!}--}}
                                                {{--{!! Form::text('pessoa[nome_emp]',Session::getOldInput('pessoa[nome_emp]'), array('class' => 'form-control')) !!}--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                        {{--<div class="row">--}}
                                            {{--<div class="form-group col-md-3">--}}
                                                {{--{!! Form::label('pessoa[uf_pro]', 'UF ') !!}--}}
                                                {{--{!! Form::select('pessoa[uf_pro]', array(), Session::getOldInput('pessoa[uf_pro]'), array('class' => 'form-control', 'id' => 'estadoPro')) !!}--}}
                                            {{--</div>--}}
                                            {{--<div class="form-group col-md-4">--}}
                                                {{--{!! Form::label('pessoa[cidade]', 'Cidade ') !!}--}}
                                                {{--{!! Form::select('pessoa[cidade]', array(), Session::getOldInput('pessoa[cidade]'),array('class' => 'form-control', 'id' => 'cidadePro')) !!}--}}
                                            {{--</div>--}}
                                            {{--<div class="form-group col-md-3">--}}
                                                {{--{!! Form::label('pessoa[bairro]', 'Bairro ') !!}--}}
                                                {{--{!! Form::select('pessoa[bairro]', array(), Session::getOldInput('pessoa[bairro]'),array('class' => 'form-control', 'id' => 'bairroPro')) !!}--}}
                                            {{--</div>--}}
                                            {{--<div class="form-group col-md-2">--}}
                                                {{--{!! Form::label('pessoa[cep_pro]', 'CEP') !!}--}}
                                                {{--{!! Form::text('pessoa[cep_pro]',Session::getOldInput('pessoa[cep_pro]') , array('class' => 'form-control')) !!}--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                        {{--<div class="row">--}}
                                            {{--<div class="form-group col-md-8">--}}
                                                {{--{!! Form::label('pessoa[email_institucional]', 'E-mail institucional') !!}--}}
                                                {{--{!! Form::text('pessoa[email_institucional]',Session::getOldInput('pessoa[email_institucional]') , array('class' => 'form-control')) !!}--}}
                                            {{--</div>--}}
                                            {{--<div class="form-group col-md-2">--}}
                                                {{--{!! Form::label('pessoa[tel_fixo_pro]', 'Telefone Fixo') !!}--}}
                                                {{--{!! Form::text('pessoa[tel_fixo_pro]', Session::getOldInput('pessoa[tel_fixo_pro]') , array('class' => 'form-control phone')) !!}--}}
                                            {{--</div>--}}
                                            {{--<div class="form-group col-md-2">--}}
                                                {{--{!! Form::label('pessoa[cel_pro]', 'Celular') !!}--}}
                                                {{--{!! Form::text('pessoa[cel_pro]',Session::getOldInput('pessoa[cel_pro]') , array('class' => 'form-control phone')) !!}--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
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
                                {!! Form::label('pessoas[ano_conclusao_medio]', 'Ano Conclusão') !!}
                                {!! Form::text('pessoas[ano_conclusao_medio]', Session::getOldInput('pessoas[ano_conclusao_medio]'), array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                {!! Form::label('pessoas[outra_escola]', 'Outra Instituição') !!}
                                {!! Form::text('pessoas[outra_escola]', Session::getOldInput('pessoas[outra_escola]'), array('class' => 'form-control')) !!}
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

                        <!-- Certidão de Nascimento ou Casamento -->
                        <div class="checkbox checkbox-primary">
                            {!! Form::hidden('pessoa[certidao_nasc_cas_doc_obrigatorio]', 0) !!}
                            {!! Form::checkbox('pessoa[certidao_nasc_cas_doc_obrigatorio]', 1, null, array('class' => 'form-control')) !!}
                            {!! Form::label('pessoa[certidao_nasc_cas_doc_obrigatorio]', 'Certidão de nascimento ou casamento ', false) !!}
                        </div>
                        <!-- Fim Certidão de Nascimento ou Casamento -->

                        <!-- Título de Eleitor e último comprovante de votação -->
                        <div class="checkbox checkbox-primary">
                            {!! Form::hidden('pessoa[titulo_eleitor_doc_obrigatorio]', 0) !!}
                            {!! Form::checkbox('pessoa[titulo_eleitor_doc_obrigatorio]', 1, null, array('class' => 'form-control')) !!}
                            {!! Form::label('pessoa[titulo_eleitor_doc_obrigatorio]', 'Título de eleitor e comprovante de votação', false) !!}
                        </div>
                        <!-- Fim Título de Eleitor e último comprovante de votação -->

                        <!-- Histórico Graduação Autenticado -->
                        <div class="checkbox checkbox-primary">
                            {!! Form::hidden('pessoa[histo_gradu_autentic_obrigatorio]', 0) !!}
                            {!! Form::checkbox('pessoa[histo_gradu_autentic_obrigatorio]', 1, null, array('class' => 'form-control')) !!}
                            {!! Form::label('pessoa[histo_gradu_autentic_obrigatorio]', 'Histórico Graduação Autenticado', false) !!}
                        </div>
                        <!-- Fim Histórico Graduação Autenticado -->

                    </div>
                    {{--Fim da Primeria coluna--}}

                    {{--Segunda coluna--}}
                    <div class="col-md-6">

                        <!-- Título de Eleitor e último comprovante de votação -->
                        <div class="checkbox checkbox-primary">
                            {!! Form::hidden('pessoa[reservista_doc_obrigatorio]', 0) !!}
                            {!! Form::checkbox('pessoa[reservista_doc_obrigatorio]', 1, null, array('class' => 'form-control')) !!}
                            {!! Form::label('pessoa[reservista_doc_obrigatorio]', 'Atestado de alaistamento militar ou reservista', false) !!}
                        </div>
                        <!-- Fim Título de Eleitor e último comprovante de votação -->

                        <!-- Título de Eleitor e último comprovante de votação -->
                        <div class="checkbox checkbox-primary">
                            {!! Form::hidden('pessoa[diploma_doc_obrigatorio]', 0) !!}
                            {!! Form::checkbox('pessoa[diploma_doc_obrigatorio]', 1, null, array('class' => 'form-control')) !!}
                            {!! Form::label('pessoa[diploma_doc_obrigatorio]', 'Diploma de graduação (cópia autenticada) ou certidão de conclusão com comprovante de entrada na tramitação do diploma', false) !!}
                        </div>
                        <!-- Fim Título de Eleitor e último comprovante de votação -->


                        <!-- Título de Eleitor e último comprovante de votação -->
                        <div class="checkbox checkbox-primary">
                            {!! Form::hidden('pessoa[fotos_3x4_doc_obrigatorio]', 0) !!}
                            {!! Form::checkbox('pessoa[fotos_3x4_doc_obrigatorio]', 1, null, array('class' => 'form-control')) !!}
                            {!! Form::label('pessoa[fotos_3x4_doc_obrigatorio]', '2 fotos 3x4', false) !!}
                        </div>
                        <!-- Fim Título de Eleitor e último comprovante de votação -->


                        <!-- Título de Eleitor e último comprovante de votação -->
                        <div class="checkbox checkbox-primary">
                            {!! Form::hidden('pessoa[comp_residencia_doc_obrigatorio]', 0) !!}
                            {!! Form::checkbox('pessoa[comp_residencia_doc_obrigatorio]', 1, null, array('class' => 'form-control')) !!}
                            {!! Form::label('pessoa[comp_residencia_doc_obrigatorio]', 'Comprovante de residência ', false) !!}
                        </div>
                        <!-- Fim Título de Eleitor e último comprovante de votação -->

                    </div>
                    {{--Fim da Segunda coluna--}}
                </div>
            </div>
            {{--Aba Documentos Obrigatorios--}}

            {{-- Aba admissão --}}
            <div role="tabpanel" class="tab-pane" id="admissao">
                <br>
                <div class="row">
                    <div class="form-group col-md-6">
                        {!! Form::label('curso_id', 'Curso') !!}
                        @if(isset($aluno->id) && count($aluno->curriculos) > 0)
                            {!! Form::select('curso_id', $loadFields['graduacao\\curso'], [$aluno->curriculos->first()->id => $aluno->curriculos->first()->nome], array('class' => 'form-control', 'disabled' => 'disabled')) !!}
                        @else
                            {!! Form::select('curso_id', $loadFields['graduacao\\curso'], null, array('class' => 'form-control')) !!}
                        @endif
                    </div>

                    <div class="form-group col-md-2">
                        {!! Form::label('turno_id', 'Turno') !!}
                        @if(isset($aluno->id))
                            {!! Form::select('turno_id', $loadFields['turno'], null, array('class' => 'form-control', 'disabled' => 'disabled')) !!}
                        @else
                            {!! Form::select('turno_id', $loadFields['turno'], null, array('class' => 'form-control')) !!}
                        @endif
                    </div>

                    <div class="form-group col-md-4">
                        {!! Form::label('forma_admissao_id', 'Forma de admissão') !!}
                        @if(isset($aluno->id))
                            {!! Form::select('forma_admissao_id', $loadFields['formaadmissao'], null, array('class' => 'form-control', 'disabled' => 'disabled')) !!}
                        @else
                            {!! Form::select('forma_admissao_id', $loadFields['formaadmissao'], null, array('class' => 'form-control')) !!}
                        @endif
                    </div>
                </div>
            </div>
            {{-- Fim aba admissão--}}
        </div>

        {{--Buttons Submit e Voltar--}}
        <div class="row">
            <div class="col-md-9">
                <div class="checkbox checkbox-primary">
                    @if(isset($aluno) && !empty($aluno->matricula))
                        {!! Form::checkbox('gerar_matricula', 1, true, array('class' => 'form-control', 'disabled' => 'disabled')) !!}
                    @else
                        {!! Form::hidden('gerar_matricula', 0) !!}
                        {!! Form::checkbox('gerar_matricula', 1, null, array('class' => 'form-control')) !!}
                    @endif
                    {!! Form::label('gerar_matricula', 'Gerar número de Matrícula', false) !!}
                </div>
            </div>
            <div class="col-md-3">
                <div class="btn-group btn-group-justified">
                    <div class="btn-group">
                        <a href="{{ route('seracademico.graduacao.aluno.index') }}" class="btn btn-primary btn-block pull-right"> <i class="fa fa-long-arrow-left"></i>  Voltar</a>
                    </div>
                    <div class="btn-group">
                        {!! Form::submit('Salvar', array('class' => 'btn btn-primary btn-block pull-right', 'id' => 'submitForm')) !!}
                    </div>
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
                },
                cache: true
            }
        });

//        $('#formAluno').bootstrapValidator({
//            fields: {
//                'pessoa[nome]': {
//                    validators: {
//                        notEmpty: {
//                            message: Lang.get('validation.required', { attribute: 'Nome' })
//                        },
//                        stringLength: {
//                            max: 50,
//                            message: Lang.get('validation.max', { attribute: 'Nome' })
//                        }
//                    }
//                },
//                'pessoa[data_nasciemento]': {
//                    validators: {
//                        notEmpty: {
//                            message: Lang.get('validation.required', { attribute: 'Data Nascimento' })
//                        }
//                    }
//                },
//                'pessoa[cpf]': {
//                    validators: {
//                        notEmpty: {
//                            message: Lang.get('validation.required', { attribute: 'CPF' })
//                        }
//                    }
//                },
//                'pessoa[nome_pai]': {
//                    validators: {
//                        notEmpty: {
//                            message: Lang.get('validation.required', { attribute: 'Nome Pai' })
//                        }
//                    }
//                },
//                'pessoa[nome_mae]': {
//                    validators: {
//                        notEmpty: {
//                            message: Lang.get('validation.required', { attribute: 'Nome Mae' })
//                        }
//                    }
//                },
//                'pessoa[identidade]': {
//                    validators: {
//                        notEmpty: {
//                            message: Lang.get('validation.required', { attribute: 'Identidade' })
//                        }
//                    }
//                }
//            },
//        });

        // Path imagem do aluno
        $("#path_image").fileinput({
            @if(isset($aluno->path_image))
            initialPreviewFileType: 'object',
            initialPreview:[
                '/images/{{$aluno->path_image}}'
            ],
            initialPreviewAsData: true,
            initialPreviewConfig: [{
                url: false,
                width: '100%'
            }],
            @endif
            language: 'pt-BR',
            showUpload: false,
            showCaption: false,
            allowedFileExtensions : ['jpeg', 'gif', 'png'],
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
                type: 'GET',
                url: '{{ route('seracademico.graduacao.aluno.search')  }}',
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
    </script>
@stop
