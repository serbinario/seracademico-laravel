<div class="row">
    <div class="col-md-10">
        <!-- Busca por cpf, caso exista em pessoa -->
        @if(!isset($aluno))
            <div class="row">
                <div class="col-md-4 form-group">
                    <label for="searchCpf">DIGITE O CPF SE POSSUIR CADASTRO</label>
                    <div class="input-group">
                        <input type="text" id="searchCpf" class="form-control twelveNumbers">
                        <span class="input-group-btn">
                             <a id="btnSearchCpf" class="btn-sm btn-primary">Buscar</a>
                        </span>
                    </div>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="form-group col-md-6">
                <div class="fg-line">
                    {!! Form::label('pessoa[nome]', 'Nome * max 60 caracteres (0-9 A-Z .-[ ])') !!}
                    {!! Form::text('pessoa[nome]',  Session::getOldInput('pessoa[nome]') , array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="form-group col-md-2">
                <div class="fg-line">
                    {!! Form::label('pessoa[data_nasciemento]', 'Nascimento *') !!}
                    {!! Form::text('pessoa[data_nasciemento]', null, array('class' => 'form-control datepicker date')) !!}
                </div>
            </div>
            <div class="form-group col-md-2">
                <div class="fg-line">
                    {!! Form::label('pessoa[sexos_id]', 'Sexo ') !!}
                    {!! Form::select('pessoa[sexos_id]', $loadFields['sexo'], Session::getOldInput('pessoa[sexos_id]'), array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="form-group col-md-2">
                <div class="fg-line">
                    {!! Form::label('matricula', 'Matrícula ') !!}
                    {!! Form::text('matricula', Session::getOldInput('nome') , array('class' => 'form-control', 'disabled' => true)) !!}
                    <input type="hidden" value="" id="idAluno" name="idAluno">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-2">
                <div class="fg-line">
                    {!! Form::label('data_matricula', 'Data de Matrícula') !!}
                    {!! Form::text('data_matricula',  Session::getOldInput('data_matricula') , array('class' => 'form-control datepicker date')) !!}
                </div>
            </div>
        </div>

    </div>
    <div class="col-md-2">
        <div class="fileinput fileinput-new" data-provides="fileinput">
            <div class="fileinput-preview thumbnail" data-trigger="fileinput" id="captura" style="width: 135px; height: 115px;">
                @if (isset($aluno) && $aluno->path_image != null)
                    <div id="midias">
                        <img id="logo" src="{{route('seracademico.mestrado.aluno.getImgAluno', ['id' => $aluno->id])}}"  alt="Foto" height="120" width="100"/><br/>
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
                <input type=button id="foto" value="Webcam" class="btn btn-primary btn-sm btn-block" data-toggle="modal" data-target="#myModal">
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
                <a href="#dados" aria-controls="dados" data-toggle="tab">Dados pessoais</a>
            </li>
            <li role="presentation">
                <a href="#contato" aria-controls="contato" role="tab" data-toggle="tab">Informações para contato</a>
            </li>
            <li role="presentation">
                <a href="#graduacao" aria-controls="graduacao" role="tab" data-toggle="tab">Graduação</a>
            </li>
            <li role="presentation">
                <a href="#documentosObrig" aria-controls="documentosObrig" role="tab" data-toggle="tab">Documentos Obrigatórios</a>
            </li>
            <li role="presentation">
                <a href="#abaMatricula" aria-controls="abaMatricula" role="tab" data-toggle="tab">Matrícula</a>
            </li>
            <li role="presentation">
                <a href="#monografia" aria-controls="monografia" role="tab" data-toggle="tab">Monografia</a>
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
                                <div class="fg-line">
                                    {!! Form::label('pessoa[estados_civis_id]', 'Estado Civil ') !!}
                                    {!! Form::select('pessoa[estados_civis_id]', $loadFields['estadocivil'], Session::getOldInput('pessoa[estados_civis_id]'),array('class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <div class="fg-line">
                                    {!! Form::label('pessoa[grau_instrucoes_id]', 'Grau de instrução') !!}
                                    {!! Form::select('pessoa[grau_instrucoes_id]', $loadFields['grauinstrucao'], Session::getOldInput('pessoa[grau_instrucoes_id]'),array('class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="form-group col-md-2 col-sm-2">
                                <div class="fg-line">
                                    {!! Form::label('pessoa[profissoes_id]', 'Profissão ') !!}
                                    {!! Form::select('pessoa[profissoes_id]', (['' => 'Selecione uma Profissão'] + $loadFields['profissao']->toArray()), Session::getOldInput('pessoa[profissoes_id]'),array('class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <div class="fg-line">
                                    {!! Form::label('pessoa[cores_racas_id]', 'Cor/Raça') !!}
                                    {!! Form::select('pessoa[cores_racas_id]', $loadFields['corraca'], Session::getOldInput('pessoa[cores_racas_id]'),array('class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <div class="fg-line">
                                    {!! Form::label('pessoa[tipos_sanguinios_id]', 'Tipo Sanguíneo') !!}
                                    {!! Form::select('pessoa[tipos_sanguinios_id]', $loadFields['tiposanguinio'] , Session::getOldInput('pessoa[tipos_sanguinios_id]'), array('class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-3">
                                <div class="fg-line">
                                    {!! Form::label('pessoa[nacionalidade]', 'Nacionalidade ') !!}
                                    {!! Form::text('pessoa[nacionalidade]', Session::getOldInput('pessoa[nacionalidade]'), array('class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <div class="fg-line">
                                    {!! Form::label('pessoa[uf_nascimento_id]', 'UF Nascimento') !!}
                                    {!! Form::select('pessoa[uf_nascimento_id]', $loadFields['estado'], Session::getOldInput('pessoa[uf_nascimento_id]'),array('class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <div class="fg-line">
                                    {!! Form::label('pessoa[naturalidade]', 'Naturalidade ') !!}
                                    {!! Form::text('pessoa[naturalidade]', Session::getOldInput('pessoas[naturalidade]'), array('class' => 'form-control')) !!}
                                </div>
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
                                                <div class="fg-line">
                                                    {!! Form::label('pessoa[nome_pai]', 'Nome Pai max 60 caracteres (0-9 A-Z .-[ ])') !!}
                                                    {!! Form::text('pessoa[nome_pai]', Session::getOldInput('pessoa[nome_pai]'), array('class' => 'form-control')) !!}
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <div class="fg-line">
                                                    {!! Form::label('pessoa[nome_mae]', 'Nome Mãe * max 60 caracteres (0-9 A-Z .-[ ])') !!}
                                                    {!! Form::text('pessoa[nome_mae]',Session::getOldInput('pessoa[nome_mae]'), array('class' => 'form-control')) !!}
                                                </div>
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
                                                <div class="fg-line">
                                                    {!! Form::label('pessoa[identidade]', 'Identidade *') !!}
                                                    {!! Form::text('pessoa[identidade]', Session::getOldInput('pessoa[identidade]'), array('class' => 'form-control')) !!}
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <div class="fg-line">
                                                    {!! Form::label('pessoa[orgao_rg]', 'Orgão RG ') !!}
                                                    {!! Form::text('pessoa[orgao_rg]', Session::getOldInput('pessoa[orgao_rg]'), array('class' => 'form-control')) !!}
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <div class="fg-line">
                                                    {!! Form::label('pessoa[uf_exp]', 'UF') !!}
                                                    {!! Form::text('pessoa[uf_exp]', Session::getOldInput('pessoa[uf_exp]'), array('class' => 'form-control')) !!}
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <div class="fg-line">
                                                    {!! Form::label('pessoa[data_expedicao]', 'Data expedição') !!}
                                                    {!! Form::text('pessoa[data_expedicao]', null , array('class' => 'form-control date')) !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-3">
                                                <div class="fg-line">
                                                    {!! Form::label('pessoa[cpf]', 'CPF *') !!}
                                                    {!! Form::text('pessoa[cpf]', Session::getOldInput('pessoa[cpf]'), array('class' => 'form-control cpf', 'id' => 'cpfAlunos')) !!}
                                                </div>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <div class="fg-line">
                                                    {!! Form::label('pessoa[titulo_eleitoral]', 'Título Eleitoral') !!}
                                                    {!! Form::text('pessoa[titulo_eleitoral]', Session::getOldInput('pessoa[titulo_eleitoral]'), array('class' => 'form-control')) !!}
                                                </div>
                                            </div>
                                            <div class="form-group col-md-1">
                                                <div class="fg-line">
                                                    {!! Form::label('pessoa[zona]', 'Zona') !!}
                                                    {!! Form::text('pessoa[zona]', Session::getOldInput('pessoas[zona]'), array('class' => 'form-control')) !!}
                                                </div>
                                            </div>
                                            <div class="form-group col-md-1">
                                                <div class="fg-line">
                                                    {!! Form::label('pessoa[secao]', 'Seção') !!}
                                                    {!! Form::text('pessoa[secao]', Session::getOldInput('pessoa[secao]') , array('class' => 'form-control')) !!}
                                                </div>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <div class="fg-line">
                                                    {!! Form::label('pessoa[resevista]', 'Reservista') !!}
                                                    {!! Form::text('pessoa[resevista]', Session::getOldInput('pessoa[resevista]'), array('class' => 'form-control')) !!}
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <div class="fg-line">
                                                    {!! Form::label('pessoa[catagoria_resevista]', 'Categoria Reservista') !!}
                                                    {!! Form::text('pessoa[catagoria_resevista]', Session::getOldInput('pessoa[catagoria_resevista]'), array('class' => 'form-control')) !!}
                                                </div>
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
                                {{--Portal do aluno--}}
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#portaAluno"> <i
                                                    class="fa fa-plus-circle"></i>Portal do Aluno</a>
                                    </h4>
                                </div>
                                <div id="portaAluno" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="form-group col-md-4">
                                                <h5>Senha de acesso ao portal</h5>
                                                <div class="form-group col-md-7">
                                                    <div class="fg-line">
                                                        {!! Form::label('password', 'Senha') !!}
                                                        {!! Form::password('password', Session::getOldInput('password'), array('class' => 'form-control')) !!}
                                                    </div>
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
                            <div class="form-group col-md-8">
                                <div class="fg-line">
                                    {!! Form::label('pessoa[endereco][logradouro]', 'Endereço ') !!}
                                    {!! Form::text('pessoa[endereco][logradouro]', Session::getOldInput('pessoa[endereco][logradouro]'), array('class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <div class="fg-line">
                                    {!! Form::label('pessoa[endereco][cep]', 'CEP ') !!}
                                    {!! Form::text('pessoa[endereco][cep]', Session::getOldInput('pessoa[endereco][cep]'), array('class' => 'form-control cep')) !!}
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <div class="fg-line">
                                    {!! Form::label('pessoa[endereco][numero]', 'Número: max 6') !!}
                                    {!! Form::text('pessoa[endereco][numero]', Session::getOldInput('pessoa[endereco][numero]'), array('class' => 'form-control numberFive')) !!}
                                </div>
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
                                <div class="fg-line">
                                    {!! Form::label('pessoa[endereco][complemento]', 'Complemento ') !!}
                                    {!! Form::text('pessoa[endereco][complemento]', Session::getOldInput('pessoa[endereco][complemento]'), array('class' => 'form-control')) !!}
                                </div>
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
                                                <div class="fg-line">
                                                    {!! Form::label('pessoa[email]', 'E-mail') !!}
                                                    {!! Form::text('pessoa[email]', Session::getOldInput('pessoas[email]'), array('class' => 'form-control')) !!}
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <div class="fg-line">
                                                    {!! Form::label('pessoa[telefone_fixo]', 'Telefone') !!}
                                                    {!! Form::text('pessoa[telefone_fixo]', Session::getOldInput('pessoa[telefone_fixo]') , array('class' => 'form-control phone')) !!}
                                                </div>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <div class="fg-line">
                                                    {!! Form::label('pessoa[celular]', 'Celular') !!}
                                                    {!! Form::text('pessoa[celular]', Session::getOldInput('pessoa[celular]'), array('class' => 'form-control celPhone')) !!}
                                                </div>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <div class="fg-line">
                                                    {!! Form::label('pessoa[celular2]', 'Celular 2') !!}
                                                    {!! Form::text('pessoa[celular2]', Session::getOldInput('pessoa[celular2]'), array('class' => 'form-control celPhone')) !!}
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

            <div role="tabpanel" class="tab-pane" id="graduacao">
                <br/>
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="form-group col-md-5">
                                <label for="fac_cursos_superiores_id">Formação Acadêmica</label>
                                <select id="cursoSuperior" name="curso_superior_id" class="form-control">
                                    @if(isset($aluno->id) && $aluno->cursoSuperior != null)
                                        <option value="{{ $aluno->cursoSuperior->id  }}" selected="selected">{{ $aluno->cursoSuperior->nome }}</option>
                                    @endif
                                </select>
                                <span style="margin-left:auto;">
                                    <div class="input-group">
                                        <input type="text" id="novaFormacao" class="form-control">
                                        <span class="input-group-btn">
                                            <a id="btnNovaFormacao" class="btn-sm btn-primary">Adicionar</a>
                                        </span>
                                    </div>
                                </span>
                                <span style="margin-left:auto;">
                                    <a id="linkNovaFormacao">Adicionar nova formação</a>
                                </span>
                            </div>
                            <div class="form-group col-md-5">
                                <label for="instituicao">Instituição</label><br>
                                <select id="instituicao" class="form-control" name="pessoa[instituicao_escolar_id]">
                                    @if(isset($aluno->id) && $aluno->pessoa->instituicaoEscolar != null)
                                        <option value="{{ $aluno->pessoa->instituicaoEscolar->id  }}" selected="selected">{{ $aluno->pessoa->instituicaoEscolar->nome }}</option>
                                    @endif
                                </select>
                                <span style="margin-left:auto;">
                                    <div class="input-group">
                                        <input type="text" id="novaInstituicao" class="form-control">
                                    <span class="input-group-btn">
                                        <a id="btnNovaInstituicao" class="btn-sm btn-primary">Adicionar</a>
                                    </span>
                                    </div>
                                </span>
                                <span style="margin-left:auto;">
                                    <a id="linkNovaInstituicao">Adicionar nova instituição</a>
                                </span>
                            </div>
                            <div class="form-group col-md-2">
                                <div class="fg-line">
                                    {!! Form::label('pessoas[ano_conclusao_medio]', 'Ano Conclusão') !!}
                                    {!! Form::text('pessoas[ano_conclusao_medio]', Session::getOldInput('pessoas[ano_conclusao_medio]'), array('class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-5">
                                <label for="fac_cursos_superiores_id">Pós-graduação</label>
                                <select id="cursoPosGraduacao" name="curso_pos_graduacao_id" class="form-control">
                                    @if(isset($aluno->id) && $aluno->curso_pos_graduacao_id != null)
                                        <option value="{{ $aluno->cursoPosGraduacao->id  }}" selected="selected">{{ $aluno->cursoPosGraduacao->nome }}</option>
                                    @endif
                                </select>
                                <span style="margin-left:auto;">
                                    <div class="input-group">
                                        <input type="text" id="novaPosGraduacao" class="form-control">
                                    <span class="input-group-btn">
                                        <a id="btnNovaPosGraduacao" class="btn-sm btn-primary">Adicionar</a>
                                    </span>
                                    </div>
                                </span>
                                <span style="margin-left:auto;">
                                    <a id="linkNovaPosGraduacao">Adicionar pós-graduação</a>
                                </span>
                            </div>
                            <div class="form-group col-md-5">
                                <label for="instituicao">Instituição</label><br>
                                <select id="instituicaoDePos" class="form-control" name="fac_instituicao_id">
                                    @if(isset($aluno->id) && $aluno->pessoa->instituicaoEscolar != null)
                                        <option value="{{ $aluno->pessoa->instituicaoEscolar->id  }}" selected="selected">{{ $aluno->pessoa->instituicaoEscolar->nome }}</option>
                                    @endif
                                </select>
                                <span style="margin-left:auto;">
                                    <div class="input-group">
                                        <input type="text" id="novaInstituicaoDePos" class="form-control">
                                    <span class="input-group-btn">
                                        <a id="btnNovaInstituicaoDePos" class="btn-sm btn-primary">Adicionar</a>
                                    </span>
                                    </div>
                                </span>
                                <span style="margin-left:auto;">
                                    <a id="linkNovaInstituicaoDePos">Adicionar nova instituição</a>
                                </span>
                            </div>
                        </div>
                        {{--<div class="row">
                            <div class="form-group col-md-12">
                                {!! Form::label('pessoas[outra_escola]', 'Outra Instituição') !!}
                                {!! Form::text('pessoas[outra_escola]', Session::getOldInput('pessoas[outra_escola]'), array('class' => 'form-control')) !!}
                            </div>
                        </div>--}}
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
                            {!! Form::label('pessoa[titulo_eleitor_doc_obrigatorio]', 'Título de eleitor', false) !!}
                        </div>
                        <!-- Fim Título de Eleitor e último comprovante de votação -->

                        <!-- Histórico Graduação Autenticado -->
                        <div class="checkbox checkbox-primary">
                            {!! Form::hidden('pessoa[histo_gradu_autentic_obrigatorio]', 0) !!}
                            {!! Form::checkbox('pessoa[histo_gradu_autentic_obrigatorio]', 1, null, array('class' => 'form-control')) !!}
                            {!! Form::label('pessoa[histo_gradu_autentic_obrigatorio]', 'Histórico Graduação Autenticado', false) !!}
                        </div>
                        <!-- Fim Histórico Graduação Autenticado -->

                        <!-- Título de Eleitor e último comprovante de votação -->
                        <div class="checkbox checkbox-primary">
                            {!! Form::hidden('pessoa[reservista_doc_obrigatorio]', 0) !!}
                            {!! Form::checkbox('pessoa[reservista_doc_obrigatorio]', 1, null, array('class' => 'form-control')) !!}
                            {!! Form::label('pessoa[reservista_doc_obrigatorio]', 'Atestado de alistamento militar ou reservista', false) !!}
                        </div>
                        <!-- Fim Título de Eleitor e último comprovante de votação -->

                    </div>
                    {{--Fim da Primeria coluna--}}

                    {{--Segunda coluna--}}
                    <div class="col-md-6">

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
                            {!! Form::label('pessoa[fotos_3x4_doc_obrigatorio]', 'Uma foto 3x4', false) !!}
                        </div>
                        <!-- Fim Título de Eleitor e último comprovante de votação -->


                        <!-- Título de Eleitor e último comprovante de votação -->
                        <div class="checkbox checkbox-primary">
                            {!! Form::hidden('pessoa[comp_residencia_doc_obrigatorio]', 0) !!}
                            {!! Form::checkbox('pessoa[comp_residencia_doc_obrigatorio]', 1, null, array('class' => 'form-control')) !!}
                            {!! Form::label('pessoa[comp_residencia_doc_obrigatorio]', 'Comprovante de residência ', false) !!}
                        </div>
                        <!-- Fim Título de Eleitor e último comprovante de votação -->

                        <!-- Título de Eleitor e último comprovante de votação -->
                        <div class="checkbox checkbox-primary">
                            {!! Form::hidden('curriculo_doc_obrigatorio', 0) !!}
                            {!! Form::checkbox('curriculo_doc_obrigatorio', 1, null, array('class' => 'form-control')) !!}
                            {!! Form::label('curriculo_doc_obrigatorio', 'Currículo com comprovação ', false) !!}
                        </div>
                        <!-- Fim Título de Eleitor e último comprovante de votação -->

                        <!-- Título de Eleitor e último comprovante de votação -->
                        <div class="checkbox checkbox-primary">
                            {!! Form::hidden('carta_intencao_doc_obrigatorio', 0) !!}
                            {!! Form::checkbox('carta_intencao_doc_obrigatorio', 1, null, array('class' => 'form-control')) !!}
                            {!! Form::label('carta_intencao_doc_obrigatorio', 'Carta de intenção ', false) !!}
                        </div>
                        <!-- Fim Título de Eleitor e último comprovante de votação -->

                    </div>
                    {{--Fim da Segunda coluna--}}
                </div>
            </div>
            {{--Aba Documentos Obrigatorios--}}

            {{-- Aba admissão --}}
            <div role="tabpanel" class="tab-pane" id="abaMatricula">
                <br>
                <div class="row">
                    <div class="form-group col-md-4">
                        <div class="fg-line">
                            {!! Form::label('curso_id', 'Curso') !!}
                            @if(isset($aluno->id) && count($aluno->curriculos) > 0)
                                {!! Form::select('curso_id', [$aluno->curriculos->last()->curso->id => $aluno->curriculos->last()->nome], null, array('class' => 'form-control', 'id' => 'curso_id')) !!}
                            @else
                                {!! Form::select('curso_id', (['' => 'Selecione um Curso'] + $loadFields['tecnico\\curso']->toArray()), null, array('class' => 'form-control', 'id' => 'curso_id')) !!}
                            @endif
                        </div>
                    </div>

                    <div class="form-group col-md-2">
                        <div class="fg-line">
                            {!! Form::label('sede_id', 'Sede') !!}
                            {!! Form::select('sede_id', (['' => 'Selecione uma sede'] + $loadFields['sede']->toArray()), null, array('class' => 'form-control', 'id' => 'sede_id')) !!}
                        </div>
                    </div>

                    <div class="form-group col-md-4">
                        <div class="fg-line">
                            {!! Form::label('turma_id', 'Turma') !!}
                            {!! Form::select('turma_id', ['' => 'Selecione uma turma'], null, array('class' => 'form-control', 'id' => 'turma_id')) !!}
                        </div>
                    </div>

                    <div class="form-group col-md-2">
                        <div class="fg-line">
                            {!! Form::label('turno_id', 'Turno') !!}
                            @if(isset($aluno->id))
                                {!! Form::select('turno_id', $loadFields['turno'], null, array('class' => 'form-control')) !!}
                            @else
                                {!! Form::select('turno_id', $loadFields['turno'], null, array('class' => 'form-control')) !!}
                            @endif
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <div class="fg-line">
                            {!! Form::label('forma_admissao_id', 'Forma de admissão') !!}
                            @if(isset($aluno->id))
                                {!! Form::select('forma_admissao_id', $loadFields['formaadmissao'], null, array('class' => 'form-control', 'disabled' => 'disabled')) !!}
                            @else
                                {!! Form::select('forma_admissao_id', $loadFields['formaadmissao'], null, array('class' => 'form-control')) !!}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            {{-- Fim aba Mtrícula--}}

            {{-- Aba Monografia --}}
            <div role="tabpanel" class="tab-pane" id="monografia">
                </br>
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#monografiaGerais" aria-controls="monografiaGerais" role="tab" data-toggle="tab">Monografia / Gerais</a>
                    </li>
                    <li role="presentation">
                        <a href="#monografiaBanca" aria-controls="monografiaBanca" role="tab" data-toggle="tab">Monografia Banca Examinadora</a>
                    </li>
                    <li role="presentation">
                        <a href="#formatura" aria-controls="formatura" role="tab" data-toggle="tab">Formatura</a>
                    </li>
                </ul>

                {{-- Inicio Monografia/gerais --}}
                </br>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="monografiaGerais">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <div class="fg-line">
                                    {!! Form::label('titulo', 'Título') !!}
                                    {!! Form::text('titulo', Session::getOldInput('titulo'), array('class' => 'form-control', 'placeholder' => 'Informe um título')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <div class="fg-line">
                                    {!! Form::label('nota_final', 'Nota Final') !!}
                                    {!! Form::text('nota_final', Session::getOldInput('nota_final'), array('class' => 'form-control')) !!}
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <div class="fg-line">
                                    {!! Form::label('media', 'Média') !!}
                                    {!! Form::text('media', Session::getOldInput('media'), array('class' => 'form-control')) !!}
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <div class="fg-line">
                                    {!! Form::label('media_conceito', 'Média Conceito') !!}
                                    {!! Form::select('media_conceito', ['' => 'Selecione', '1' => 'CUMPRIO', '2' => 'NÃO CUMPRIO'], null, array('class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <div class="fg-line">
                                    {!! Form::label('defendeu', 'Defendeu') !!}
                                    {!! Form::select('defendeu', ['' => 'Selecione', '1' => 'Sim', '2' => 'Não'], null, array('class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <div class="fg-line">
                                    {!! Form::label('professor_orientador_id', 'Professor Orientador') !!}
                                    {!! Form::select('professor_orientador_id', array(), null, array('class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class="fg-line">
                                    {!! Form::label('defesa', 'Defesa') !!}
                                    {!! Form::text('defesa', Session::getOldInput(''), array('class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Fim Monografia/gerais --}}

                    {{-- Inicio Monografia/gerais --}}
                    </br>
                    <div role="tabpanel" class="tab-pane" id="monografiaBanca">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <div class="fg-line">
                                    {!! Form::label('professor_banca_1_id', 'Professor 01') !!}
                                    {!! Form::select('professor_banca_1_id', array(), null, array('class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class="fg-line">
                                    {!! Form::label('inst_ensino_banca_1_id', 'Instituição 01') !!}
                                    {!! Form::select('inst_ensino_banca_1_id', array(), null, array('class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <div class="fg-line">
                                    {!! Form::label('professor_banca_2_id', 'Professor 02') !!}
                                    {!! Form::select('professor_banca_2_id', array(), null, array('class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class="fg-line">
                                    {!! Form::label('inst_ensino_banca_2_id', 'Instituição 02') !!}
                                    {!! Form::select('inst_ensino_banca_2_id', array(), null, array('class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <div class="fg-line">
                                    {!! Form::label('professor_banca_3_id', 'Professor 03') !!}
                                    {!! Form::select('professor_banca_3_id', array(), null, array('class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class="fg-line">
                                    {!! Form::label('inst_ensino_banca_3_id', 'Instituição 02') !!}
                                    {!! Form::select('inst_ensino_banca_3_id', array(), null, array('class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <div class="fg-line">
                                    {!! Form::label('professor_banca_4_id', 'Professor 04') !!}
                                    {!! Form::select('professor_banca_4_id', array(), null, array('class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class="fg-line">
                                    {!! Form::label('inst_ensino_banca_4_id', 'Instituição 02') !!}
                                    {!! Form::select('inst_ensino_banca_4_id', array(), null, array('class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Fim Monografia/gerais --}}

                    {{-- Fim Monografia/gerais --}}
                    <div role="tabpanel" class="tab-pane" id="formatura">
                        <div class="row">
                            <div class="form-group col-md-2">
                                <div class="fg-line">
                                    {!! Form::label('data_conclusao', 'Data Conclusão') !!}
                                    {!! Form::text('data_conclusao', Session::getOldInput('data_conclusao'), array('class' => 'form-control datepicker')) !!}
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <div class="fg-line">
                                    {!! Form::label('data_colacao', 'Data Colação') !!}
                                    {!! Form::text('data_colacao', Session::getOldInput('data_colacao'), array('class' => 'form-control datepicker')) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Fim Monografia/gerais --}}
                </div>
            </div>
            {{-- Fim Monografia--}}

            {{--Buttons Submit e Voltar--}}
            <div class="row">

                <div class="modal fade my-profile" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                                <button type="button"  class="btn btn-secondary" data-dismiss="modal">Sair</button>
                                <button type="button" onClick="take_snapshot()" class="btn btn-primary">Tirar foto</button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- <div class="col-md-9">
                     <div class="checkbox checkbox-primary">
                         @if(isset($aluno) && !empty($aluno->matricula))
                             {!! Form::checkbox('gerar_matricula', 1, true, array('class' => 'form-control', 'disabled' => 'disabled')) !!}
                         @else
                             {!! Form::hidden('gerar_matricula', 0) !!}
                             {!! Form::checkbox('gerar_matricula', 1, null, array('class' => 'form-control')) !!}
                         @endif
                         {!! Form::label('gerar_matricula', 'Gerar número de Matrícula', false) !!}
                     </div>
                 </div>--}}
                <div class="col-md-3 col-md-offset-9">
                    <div class="btn-group btn-group-justified">
                        <div class="btn-group">
                            <a href="{{ route('seracademico.tecnico.aluno.index') }}" class="btn btn-primary btn-block pull-right"> <i class="fa fa-long-arrow-left"></i>  Voltar</a>
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
</div>

@section('javascript')
    <script type="text/javascript" src="{{ asset('/js/createInstituicao/createInstituicao.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/createCursoPosGraduacao/createCursoPosGraduacao.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/createCursoFormacao/createFormacao.js') }}"></script>
    {{--Mensagens personalizadas--}}
    <script type="text/javascript" src="{{ asset('/js/validacoes/messages_pt_BR.js')  }}"></script>
    {{--Regras adicionais--}}
    <script type="text/javascript" src="{{ asset('/js/validacoes/regrasAdicionais/alphaSpace.js')  }}"></script>
    <script type="text/javascript" src="{{ asset('/lib/jquery-validation/src/additional/integer.js')  }}"></script>
    <script type="text/javascript" src="{{ asset('/lib/jquery-validation/src/additional/cpfBR.js')  }}"></script>
    <script type="text/javascript" src="{{ asset('/js/validacoes/regrasAdicionais/dateBr.js')  }}"></script>
    <script type="text/javascript" src="{{ asset('/js/validacoes/regrasAdicionais/decimal.js')  }}"></script>
    {{--Regras de validação--}}
    <script type="text/javascript" src="{{ asset('/js/validacoes/tecnico/aluno.js')  }}"></script>
    <script type="text/javascript">

        //Evento para exibir input e botão curso pós
        $('#linkNovaPosGraduacao').on('click', function(){
            $('#linkNovaPosGraduacao').hide();
            $('#novaPosGraduacao').show();
            $('#btnNovaPosGraduacao').show();
        })

        //Evento para exibir input e botão curso graduação
        $('#linkNovaFormacao').on('click', function(){
            $('#linkNovaFormacao').hide();
            $('#novaFormacao').show();
            $('#btnNovaFormacao').show();
        })

        //Evento para exibir input e botão de instituição (graduação)
        $('#linkNovaInstituicao').on('click', function(){
            $('#linkNovaInstituicao').hide();
            $('#novaInstituicao').show();
            $('#btnNovaInstituicao').show();
        })

        //Evento para exibir input e botão de instituição
        $('#linkNovaInstituicaoDePos').on('click', function(){
            $('#linkNovaInstituicaoDePos').hide();
            $('#novaInstituicaoDePos').show();
            $('#btnNovaInstituicaoDePos').show();
        })

        //Inserindo nova formação a nível de pós-graduação
        $('#btnNovaPosGraduacao').on('click', function(){
            var valor = $('#novaPosGraduacao').val();
            var nivel = 2;
            var idSelect = $('#cursoPosGraduacao');

            //Persistindo e injetando o dado no select2
            createCursoPosGraduacao(valor, nivel, idSelect);

            //Ocultando componentes do formulário
            $('#novaPosGraduacao').hide();
            $('#btnNovaPosGraduacao').hide();
            $('#linkNovaPosGraduacao').show();
            $('#novaPosGraduacao').val("");
        })

        //Inserindo nova formação (nível superior)
        $('#btnNovaFormacao').on('click', function(){
            var valor = $('#novaFormacao').val();
            var idArea = 3;
            var idSelect = $('#cursoSuperior');

            //Persistindo e injetando o dado no select2
            createFormacao(valor, idArea, idSelect);

            //Ocultando componentes do formulário
            $('#novaFormacao').hide();
            $('#btnNovaFormacao').hide();
            $('#linkNovaFormacao').show();
            $('#novaFormacao').val("");
        })

        //Inserindo nova instituição
        $('#btnNovaInstituicao').on('click', function(){
            var valor = $('#novaInstituicao').val();
            var nivel = 3;
            var idSelect = $('#instituicao');

            //Persistindo e injetando o dado no select2
            createInstituicao(valor, nivel, idSelect);

            //Ocultando componentes do formulário
            $('#novaInstituicao').hide();
            $('#btnNovaInstituicao').hide();
            $('#linkNovaInstituicao').show();
            $('#novaInstituicao').val("");
        })

        //Inserindo nova instituição
        $('#btnNovaInstituicaoDePos').on('click', function(){
            var valor = $('#novaInstituicaoDePos').val();
            var nivel = 3;
            var idSelect = $('#instituicaoDePos');

            //Persistindo e injetando o dado no select2
            createInstituicao(valor, nivel, idSelect);

            //Ocultando componentes do formulário
            $('#novaInstituicaoDePos').hide();
            $('#btnNovaInstituicaoDePos').hide();
            $('#linkNovaInstituicaoDePos').show();
            $('#novaInstituicaoDePos').val("");
        })

        Webcam.set({
            width: 260,
            height: 240,
            image_format: 'jpeg',
            jpeg_quality: 90
        });

        $(document).on('click', '#foto', function(){
            Webcam.attach( '#my_camera' );
        });

        function take_snapshot() {

            // take snapshot and get image data
            Webcam.snap( function(data_uri) {

                // display results in page
                document.getElementById('captura').innerHTML = '<img src="'+data_uri+'"/>';
                var raw_image_data = data_uri.replace(/^data\:image\/\w+\;base64\,/, '');
                document.getElementById('cod_img').value = raw_image_data;

                $(".my-profile").modal('hide');
                Webcam.reset();
               // $(".modal-dialog").modal('toggle');

            } );
        }

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
            width: 398,
            allowClear: true,
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
                        'valueWhere':  '3',
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
        $("#instituicaoDePos").select2({
            placeholder: 'Selecione uma instituição',
            minimumInputLength: 3,
            width: 398,
            allowClear: true,
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
                        'valueWhere':  '3',
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
        $("#cursoSuperior").select2({
            placeholder: 'Selecione uma formação acadêmica',
            minimumInputLength: 3,
            width: 400,
            ajax: {
                type: 'POST',
                url: "{{ route('seracademico.util.select2')  }}",
                dataType: 'json',
                delay: 250,
                crossDomain: true,
                allowClear: true,
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

        //consulta via select2
        $("#cursoPosGraduacao").select2({
            placeholder: 'Selecione uma formação acadêmica',
            minimumInputLength: 3,
            width: 400,
            ajax: {
                type: 'POST',
                url: "{{ route('seracademico.util.select2')  }}",
                dataType: 'json',
                delay: 250,
                crossDomain: true,
                allowClear: true,
                data: function (params) {
                    return {
                        'search':     params.term, // search term
                        'tableName':  'fac_pos_graduacoes',
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

                //remoção de possiveis mensagens de validação
                $('form div').removeClass("has-error");
                $('div small').remove();

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


        // Evento para carregar as sedes a partir do
        // curso selecionado
        $(document).ready(function () {
            //Ocultando o campo p/ adição de nova instituição
            $('#novaPosGraduacao').hide();
            $('#novaFormacao').hide();
            $('#novaInstituicao').hide();
            $('#novaInstituicaoDePos').hide();
            $('#btnNovaPosGraduacao').hide();
            $('#btnNovaFormacao').hide();
            $('#btnNovaInstituicao').hide();
            $('#btnNovaInstituicaoDePos').hide();

            var cursoId = $('#curso_id').val();

            // Validando o curso
            if(!cursoId) {
                return false;
            }

            // Recuperando as sedes e carregando o select
            getTurmasByCurso(cursoId);
        });

        // Evento para mudanção de curso carregar automaticamente as sedes
        $(document).on('change', '#curso_id', function () {
            // Recuperando o id do curso
            var cursoId = $(this).val();

            // Validando o curso
            if(!cursoId) {
                return false;
            }
            // Recuperando as sedes e carregando o select
            getSedeByCurso(cursoId);
        });

        // Evento para mudança de turma
        $(document).on('change', '#sede_id', function () {
            // Recuperando o id do curso
            var sedeId  = $(this).val();
            var cursoId = $('#curso_id').val();

            // Validando o curso
            if(!sedeId || !cursoId) {
                return false;
            }

            // Recuperando as sedes e carregando o select
            getTurmaBySede(sedeId, cursoId);
        });


        /**
         * Função para retornar as turmas referentes ao curso informado (cursoId)
         * e prencher o select de sedes.
         *
         * @param cursoId
        **/
        function getTurmasByCurso(cursoId)
        {
            // Requisição
            jQuery.ajax({
                type: 'GET',
                url: '/index.php/seracademico/mestrado/turma/getAllByCurso/' + cursoId,
                datatype: 'json',
                headers: {
                    'X-CSRF-TOKEN' : '{{  csrf_token() }}'
                },
            }).done(function (json) {
                if(json.success) {
                    // Options da turma
                    var option = "";

                    // Options da turma
                    option += '<option value="">Selecione uma turma</option>';

                    // Percorrendo as turmas
                    for (var i = 0; i < json.dados.length; i++) {
                        @if((isset($aluno->curriculos) && count($aluno->curriculos) > 0) && count($aluno->curriculos->last()->turmas) > 0)
                            if(json.dados[i]['sede_id'] == "{{ $aluno->curriculos->last()->pivot->turmas->last()->sede_id ?? null }}") {
                                if(json.dados[i]['id'] == "{{ $aluno->curriculos->last()->pivot->turmas->last()->id ?? null }}") {
                                    option += '<option selected="true" value="' + json.dados[i]['id'] + '">' + json.dados[i]['codigo'] + '</option>';
                                } else {
                                    option += '<option value="' + json.dados[i]['id'] + '">' + json.dados[i]['codigo'] + '</option>';
                                }
                            }
                        @else
                            option += '<option value="' + json.dados[i]['id'] + '">' + json.dados[i]['codigo'] + '</option>';
                        @endif
                    }

                    // Carregando a sede
                    @if(isset($aluno->curriculos) && isset($aluno->curriculos->last()->pivot->turmas->last()->sede->id))
                        $('#sede_id option').remove();
                        $('#sede_id').append('<option value="{{$aluno->curriculos->last()->pivot->turmas->last()->sede->id ?? ''}}">'+
                                '{{$aluno->curriculos->last()->pivot->turmas->last()->sede->nome ?? ""}}</option>');
                    @endif

                    // carregando as turmas em caso de edit
                    $('#turma_id option').remove();
                    $('#turma_id').append(option);
                }
            });
        }

        /**
         * Função para retornar as sedes referentes ao curso informado (cursoId)
         * e prencher o select de sedes.
         *
         * @param cursoId
         */
        function getSedeByCurso(cursoId)
        {
            // Requisição
            jQuery.ajax({
                type: 'GET',
                url: '/index.php/seracademico/mestrado/turma/getSedeByCurso/' + cursoId,
                datatype: 'json',
                headers: {
                    'X-CSRF-TOKEN' : '{{  csrf_token() }}'
                }
            }).done(function (json) {
                var option = "";

                option += '<option value="">Selecione uma sede</option>';
                for (var i = 0; i < json.dados.length; i++) {
                    option += '<option value="' + json.dados[i]['id'] + '">' + json.dados[i]['nome'] + '</option>';
                }

                $('#turma_id option').remove();
                $('#sede_id option').remove();
                $('#sede_id').append(option);
            });
        }

        /**
         *
         * @param sedeId
         * @param cursoId
         */
        function getTurmaBySede(sedeId, cursoId)
        {
            // Requisição
            jQuery.ajax({
                type: 'GET',
                url: '/index.php/seracademico/mestrado/turma/getTurmaBySede/' + sedeId + '/' + cursoId,
                datatype: 'json',
                headers: {
                    'X-CSRF-TOKEN' : '{{  csrf_token() }}'
                }
            }).done(function (json) {
                var option = "";

                option += '<option value="">Selecione uma turma</option>';
                for (var i = 0; i < json.dados.length; i++) {
                    option += '<option value="' + json.dados[i]['id'] + '">' + json.dados[i]['codigo'] + '</option>';
                }

                $('#turma_id option').remove();
                $('#turma_id').append(option);
            });
        }
    </script>
@stop