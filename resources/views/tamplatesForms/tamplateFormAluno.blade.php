<div class="row">
    <div class="col-md-10">
        <div class="row">
            <div class="form-group col-md-8">
                {!! Form::label('nome', 'Nome *') !!}
                {!! Form::text('nome',  Session::getOldInput('nome') , array('class' => 'form-control')) !!}
            </div>
            <div class="form-group col-md-2">
                {!! Form::label('data_nasciemento', 'Nascimento *') !!}
                {!! Form::text('data_nasciemento', null, array('class' => 'form-control datepicker date')) !!}
            </div>
            <div class="form-group col-md-2">
                {!! Form::label('sexo', 'Sexo ') !!}
                {!! Form::select('sexos_id', $loadFields['sexo'], Session::getOldInput('sexos_id'), array('class' => 'form-control')) !!}
            </div>
        </div>
        <div class="row">
            {{--<div class="form-group col-md-3">
            {!! Form::label('curso', 'Curso') !!}
            {!! Form::select('curso',  array('1' => 'Curso'), array(),array('class' => 'form-control')) !!}
        </div>
        <div class="form-group col-md-2">
            {!! Form::label('turma', 'Turma ') !!}
            {!! Form::select('turma',  array('1' => 'Turma'), array(),array('class' => 'form-control')) !!}
        </div>
        <div class="form-group col-md-2">
            {!! Form::label('turno', 'Turno ') !!}
            {!! Form::select('turno', array(), Session::getOldInput('nome'),array('class' => 'form-control')) !!}
        </div>
        <div class="form-group col-md-2">
            {!! Form::label('currículo', 'Currículo') !!}
            {!! Form::select('currículo', array(), Session::getOldInput('nome'),array('class' => 'form-control')) !!}
        </div>--}}
        <div class="form-group col-md-2">
            {!! Form::label('matricula', 'Matrícula ') !!}
            {!! Form::text('matricula', Session::getOldInput('nome') , array('class' => 'form-control')) !!}
            <input type="hidden" value="" id="idAluno" name="idAluno">
        </div>
        <div class="form-group col-md-1">
            {!! Form::label('ativar', 'Ativar') !!}
            <div class="checkbox checkbox-primary">
                {!! Form::hidden('ativo', 0) !!}
                {!! Form::checkbox('ativo', 1, null, array('class' => 'form-control')) !!}
                {!! Form::label('ativo', 'Ativar', false) !!}
            </div>
        </div>

    </div>
</div>
<div class="col-md-2">
    <div class="fileinput fileinput-new" data-provides="fileinput">
        <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 135px; height: 115px;">
            @if (isset($aluno) && $aluno->path_image != null)
            <div id="midias">
                <img id="logo" src="/images/{{$aluno->path_image}}"  alt="Foto" height="120" width="100"/><br/>
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
</div>
</div>
<hr class="hr-line-dashed"/>


<div class="row">
    <div class="col-md-12">

        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active">
                <a href="#dados" aria-controls="dados" data-toggle="tab"><i class="material-icons">contacts</i> Dados pessoais</a>
            </li>
            <li role="presentation">
                <a href="#contato" aria-controls="contato" role="tab" data-toggle="tab"><i class="material-icons">contact_phone</i>Informações para contato</a>
            </li>
            <li role="presentation">
                <a href="#ensMedio" aria-controls="ensMedio" role="tab" data-toggle="tab"><i class="material-icons">school</i> Ensino Superior</a>
            </li>
            <li role="presentation">
                <a href="#documentosObrig" aria-controls="documentosObrig" role="tab" data-toggle="tab"><i class="material-icons">subtitles</i>Documentos Obrigatórios</a>
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
                                {!! Form::label('estado_civis_id', 'Estado Civil ') !!}
                                {!! Form::select('estado_civis_id', $loadFields['estadocivil'], Session::getOldInput('estado_civis_id'),array('class' => 'form-control')) !!}
                            </div>
                            <div class="form-group col-md-2">
                                {!! Form::label('grau_instrucoes_id', 'Grau de instrução') !!}
                                {!! Form::select('grau_instrucoes_id', $loadFields['grauinstrucao'], Session::getOldInput('grau_instrucoes_id'),array('class' => 'form-control')) !!}
                            </div>
                            <div class="form-group col-md-4">
                                {!! Form::label('profissoes_id', 'Profissão ') !!}
                                {!! Form::select('profissoes_id', array(), Session::getOldInput('profissoes_id'),array('class' => 'form-control')) !!}
                            </div>
                            <div class="form-group col-md-2">
                                {!! Form::label('cores_racas_id', 'Cor/Raça') !!}
                                {!! Form::select('cores_racas_id', ([null => 'Selecione uma opção'] + $loadFields['corraca']->toArray()), Session::getOldInput('cores_racas_id'),array('class' => 'form-control')) !!}
                            </div>
                            <div class="form-group col-md-2">
                                {!! Form::label('tipos_sanguinios_id', 'Tipo Sanguíneo') !!}
                                {!! Form::select('tipos_sanguinios_id', ([null => 'Selecione uma opção'] + $loadFields['tiposanguinio']->toArray()) , Session::getOldInput('tipos_sanguinios_id'), array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-3">
                                {!! Form::label('nacionalidade', 'Nacionalidade ') !!}
                                {!! Form::text('nacionalidade', Session::getOldInput('nacionalidade'), array('class' => 'form-control')) !!}
                            </div>
                            <div class="form-group col-md-3">
                                {!! Form::label('uf_nascimento_id', 'UF Nascimento') !!}
                                {!! Form::select('uf_nascimento_id', $loadFields['estado'], Session::getOldInput('uf_nascimento_id'),array('class' => 'form-control')) !!}
                            </div>
                            <div class="form-group col-md-3">
                                {!! Form::label('naturalidade', 'Naturalidade ') !!}
                                {!! Form::text('naturalidade', Session::getOldInput('naturalidade'), array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <legend><i class="fa fa-archive"></i> Outros dados</legend>
                        <div class="panel-group" id="accordion">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#filiacao"> <i class="material-icons">arrow_drop_down_circle</i> Filiação</a>
                                        </h4>
                                    </div>
                                    <div id="filiacao" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    {!! Form::label('nome_pai', 'Nome Pai *') !!}
                                                    {!! Form::text('nome_pai', Session::getOldInput('nome_pai'), array('class' => 'form-control')) !!}
                                                </div>
                                                <div class="form-group col-md-6">
                                                    {!! Form::label('nome_mae', 'Nome Mãe *') !!}
                                                    {!! Form::text('nome_mae',Session::getOldInput('nome_mae'), array('class' => 'form-control')) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"> <i class="material-icons">arrow_drop_down_circle</i> Documentos</a>
                                            </h4>
                                        </div>
                                        <div id="collapseTwo" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="form-group col-md-3">
                                                        {!! Form::label('identidade', 'Identidade *') !!}
                                                        {!! Form::text('identidade', Session::getOldInput('identidade'), array('class' => 'form-control')) !!}
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        {!! Form::label('orgao_rg', 'Orgão RG ') !!}
                                                        {!! Form::text('orgao_rg', Session::getOldInput('orgao_rg'), array('class' => 'form-control')) !!}
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        {!! Form::label('uf_exp', 'UF') !!}
                                                        {!! Form::text('uf_exp', Session::getOldInput('nome'), array('class' => 'form-control')) !!}
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        {!! Form::label('data_expedicao', 'Data expedição') !!}
                                                        {!! Form::text('data_expedicao', null , array('class' => 'form-control datepicker date')) !!}
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-3">
                                                        {!! Form::label('cpf', 'CPF *') !!}
                                                        {!! Form::text('cpf', Session::getOldInput('cpf'), array('class' => 'form-control cpf', 'id' => 'cpfAlunos')) !!}
                                                    </div>
                                                    <div class="form-group col-md-2">
                                                        {!! Form::label('titulo_eleitoral', 'Título Eleitoral') !!}
                                                        {!! Form::text('titulo_eleitoral', Session::getOldInput('titulo_eleitoral'), array('class' => 'form-control')) !!}
                                                    </div>
                                                    <div class="form-group col-md-1">
                                                        {!! Form::label('zona', 'Zona') !!}
                                                        {!! Form::text('zona', Session::getOldInput('zona'), array('class' => 'form-control')) !!}
                                                    </div>
                                                    <div class="form-group col-md-1">
                                                        {!! Form::label('secao', 'Seção') !!}
                                                        {!! Form::text('secao', Session::getOldInput('secao') , array('class' => 'form-control')) !!}
                                                    </div>
                                                    <div class="form-group col-md-2">
                                                        {!! Form::label('resevista', 'Reservista') !!}
                                                        {!! Form::text('resevista', Session::getOldInput('resevista'), array('class' => 'form-control')) !!}
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        {!! Form::label('catagoria_resevista', 'Categoria Reservista') !!}
                                                        {!! Form::text('catagoria_resevista', Session::getOldInput('catagoria_resevista'), array('class' => 'form-control')) !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#deficiencia"> <i class="material-icons">arrow_drop_down_circle</i> Deficiencia</a>
                                                </h4>
                                            </div>
                                            <div id="deficiencia" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    <div class="row">

                                                        <div class="form-group col-md-12">
                                                            {!! Form::label('tipoDef', 'Deficiências') !!}
                                                            <div class="checkbox checkbox-primary">
                                                                {!! Form::hidden('deficiencia_fisica', 0) !!}
                                                                {!! Form::checkbox('deficiencia_fisica', 1, null, array('class' => 'form-control')) !!}
                                                                {!! Form::label('deficiencia_fisica', 'Física') !!}
                                                                <div class="checkbox checkbox-primary checkbox-inline">
                                                                    {!! Form::hidden('deficiencia_auditiva', 0) !!}
                                                                    {!! Form::checkbox('deficiencia_auditiva', 1, null, array('class' => 'form-control')) !!}
                                                                    {!! Form::label('deficiencia_auditiva', 'Auditivas', false) !!}
                                                                </div>
                                                                <div class="checkbox checkbox-primary checkbox-inline">
                                                                    {!! Form::hidden('deficiencia_visual', 0) !!}
                                                                    {!! Form::checkbox('deficiencia_visual', 1, null, array('class' => 'form-control')) !!}
                                                                    {!! Form::label('deficiencia_visual', 'Visuais', false) !!}
                                                                </div>
                                                                <div class="checkbox checkbox-primary checkbox-inline">
                                                                    {!! Form::hidden('deficiencia_outra', 0) !!}
                                                                    {!! Form::checkbox('deficiencia_outra', 1, null,array('class' => 'form-control')) !!}
                                                                    {!! Form::label('deficiencia_outra', 'Outras') !!}
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
                                            {!! Form::label('endereco[logradouro]', 'Endereço ') !!}
                                            {!! Form::text('endereco[logradouro]', Session::getOldInput('endereco[logradouro]'), array('class' => 'form-control')) !!}
                                        </div>
                                        <div class="form-group col-md-2">
                                            {!! Form::label('endereco[numero]', 'Número') !!}
                                            {!! Form::text('endereco[numero]', Session::getOldInput('endereco[numero]'), array('class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-3">
                                            {!! Form::label('estado', 'UF ') !!}
                                            @if(isset($aluno->endereco->bairro->cidade->estado->id))
                                            {!! Form::select('estado', $loadFields['estado'], $aluno->endereco->bairro->cidade->estado->id, array('class' => 'form-control', 'id' => 'estado')) !!}
                                            @else
                                            {!! Form::select('estado', $loadFields['estado'], Session::getOldInput('estado'), array('class' => 'form-control', 'id' => 'estado')) !!}
                                            @endif
                                        </div>
                                        <div class="form-group col-md-4">
                                            {!! Form::label('cidade', 'Cidade ') !!}
                                            @if(isset($aluno->endereco->bairro->cidade->id))
                                            {!! Form::select('cidade', array($aluno->endereco->bairro->cidade->id => $aluno->endereco->bairro->cidade->nome), $aluno->endereco->bairro->cidade->id,array('class' => 'form-control', 'id' => 'cidade')) !!}
                                            @else
                                            {!! Form::select('cidade', array(), Session::getOldInput('cidade'),array('class' => 'form-control', 'id' => 'cidade')) !!}
                                            @endif
                                        </div>
                                        <div class="form-group col-md-3">
                                            {!! Form::label('endereco[bairros_id]', 'Bairro ') !!}
                                            @if(isset($aluno->endereco->bairro->id))
                                            {!! Form::select('endereco[bairros_id]', array($aluno->endereco->bairro->id => $aluno->endereco->bairro->nome), $aluno->endereco->bairro->id,array('class' => 'form-control', 'id' => 'bairro')) !!}
                                            @else
                                            {!! Form::select('endereco[bairros_id]', array(), Session::getOldInput('bairro'),array('class' => 'form-control', 'id' => 'bairro')) !!}
                                            @endif
                                        </div>
                                        <div class="form-group col-md-2">
                                            {!! Form::label('endereco[cep]', 'CEP ') !!}
                                            {!! Form::text('endereco[cep]', Session::getOldInput('endereco[cep]'), array('class' => 'form-control cep')) !!}
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
                                                                {!! Form::label('email', 'E-mail') !!}
                                                                {!! Form::text('email', Session::getOldInput('email'), array('class' => 'form-control')) !!}
                                                            </div>
                                                            <div class="form-group col-md-3">
                                                                {!! Form::label('telefone_fixo', 'Telefone fixo') !!}
                                                                {!! Form::text('telefone_fixo', Session::getOldInput('telefone_fixo') , array('class' => 'form-control phone')) !!}
                                                            </div>
                                                            <div class="form-group col-md-2">
                                                                {!! Form::label('celular', 'Celular') !!}
                                                                {!! Form::text('celular', Session::getOldInput('celular'), array('class' => 'form-control phone')) !!}
                                                            </div>
                                                            <div class="form-group col-md-2">
                                                                {!! Form::label('celular2', 'Celular 2') !!}
                                                                {!! Form::text('celular2', Session::getOldInput('celular2'), array('class' => 'form-control phone')) !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="panel-heading">
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
                                                            <div class="row">
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
                                                            </div>
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
                                                    </div>
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
                                                <div class="form-group col-md-5">
                                                    <label for="fac_cursos_superiores_id">Formação Acadêmica</label>
                                                    <select id="formacao" name="fac_cursos_superiores_id" class="form-control">
                                                        @if(isset($aluno->id) && $aluno->cursoSuperior != null)
                                                        <option value="{{ $aluno->cursoSuperior->id  }}" selected="selected">{{ $aluno->cursoSuperior->nome }}</option>
                                                        @endif
                                                    </select>
                                                </div>

                                                <div class="form-group col-md-5">
                                                    <label for="instituicao">Instituição</label>
                                                    <select id="instituicao" class="form-control" name="fac_instituicoes_id">
                                                     @if(isset($aluno->id) && $aluno->instituicao != null)
                                                     <option value="{{ $aluno->instituicao->id  }}" selected="selected">{{ $aluno->instituicao->nome }}</option>
                                                     @endif
                                                 </select>
                                             </div>

                                             <div class="form-group col-md-2">
                                                {!! Form::label('ano_conclusao_superior', 'Ano Conclusão') !!}
                                                {!! Form::text('ano_conclusao_superior', Session::getOldInput('nome'), array('class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                {!! Form::label('outra_escola', 'Outra Instituição') !!}
                                                {!! Form::text('outra_escola', Session::getOldInput('outra_escola'), array('class' => 'form-control')) !!}
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
                                    {{--Fim da Primeria coluna--}}

                                    {{--Segunda coluna--}}
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
                                    {{--Fim da Segunda coluna--}}
                                </div>
                            </div>
                            {{--Aba Documentos Obrigatorios--}}

                        </div>
                        {{--Buttons Submit e Voltar--}}
                        <div class="row">
                            <div class="col-md-9"></div>                            
                            <div class="col-md-3">
                                <div class="btn-group btn-group-justified">
                                    <div class="btn-group">
                                        <a href="{{ route('seracademico.posgraduacao.aluno.index') }}" class="btn btn-primary"><i class="fa fa-long-arrow-left"></i>  Voltar</a>
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
