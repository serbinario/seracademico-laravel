<div class="row">
	<div class="col-md-10">
		<div class="row">

            <div class="col-md-4">
                <div class="form-group">
                    
				{!! Form::label('nome', 'Nome') !!}
				{!! Form::text('nome', Session::getOldInput('nome')  , array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    
				{!! Form::label('tratamento', 'Tratamento') !!}
				{!! Form::text('tratamento', Session::getOldInput('tratamento')  , array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    
				{!! Form::label('nome_pai', 'Nome do Pai') !!}
				{!! Form::text('nome_pai', Session::getOldInput('nome_pai')  , array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    
				{!! Form::label('nome_social', 'Nome Social') !!}
				{!! Form::text('nome_social', Session::getOldInput('nome_social')  , array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    
				{!! Form::label('nome_mae', 'Nome da Mãe') !!}
				{!! Form::text('nome_mae', Session::getOldInput('nome_mae')  , array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    
				{!! Form::label('identidade', 'Identidade') !!}
				{!! Form::text('identidade', Session::getOldInput('identidade')  , array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    
				{!! Form::label('orgao_rg', 'Orgão expeditor') !!}
				{!! Form::text('orgao_rg', Session::getOldInput('orgao_rg')  , array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    
				{!! Form::label('data_expedicao', 'Data de expedição') !!}
				{!! Form::text('data_expedicao', Session::getOldInput('data_expedicao'), array('class' => 'form-control datepicker')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    
				{!! Form::label('cpf', 'CPF') !!}
				{!! Form::text('cpf', Session::getOldInput('cpf')  , array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">

                    {!! Form::label('ctps_numero', 'CTPS-Número') !!}
                    {!! Form::text('ctps_numero', Session::getOldInput('ctps_numero')  , array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">

                    {!! Form::label('ctps_serie', 'CTPS-Série') !!}
                    {!! Form::text('ctps_serie', Session::getOldInput('ctps_serie')  , array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    
				{!! Form::label('titulo_eleitoral', 'Titulo Eleitoral') !!}
				{!! Form::text('titulo_eleitoral', Session::getOldInput('titulo_eleitoral')  , array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    
				{!! Form::label('zona', 'Zona') !!}
				{!! Form::text('zona', Session::getOldInput('zona')  , array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    
				{!! Form::label('secao', 'Seção') !!}
				{!! Form::text('secao', Session::getOldInput('secao')  , array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    
				{!! Form::label('resevista', 'Reservista') !!}
				{!! Form::text('resevista', Session::getOldInput('resevista')  , array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    
				{!! Form::label('categoria_resevista', 'Categoria Reservista') !!}
				{!! Form::text('categoria_resevista', Session::getOldInput('categoria_resevista')  , array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    
				{!! Form::label('data_nascimento', 'Nascimento') !!}
				{!! Form::text('data_nascimento', Session::getOldInput('data_nascimento'), array('class' => 'form-control datepicker')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">

                    {!! Form::label('data_admissao', 'Data Admissão') !!}
                    {!! Form::text('data_admissao', Session::getOldInput('data_nascimento'), array('class' => 'form-control datepicker')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    
				{!! Form::label('nacionalidade', 'Nascionalidade') !!}
				{!! Form::text('nacionalidade', Session::getOldInput('nacionalidade')  , array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    
				{!! Form::label('naturalidade', 'Naturalidade') !!}
				{!! Form::text('naturalidade', Session::getOldInput('naturalidade')  , array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="form-group col-md-10">
                {!! Form::label('endereco[logradouro]', 'Endereço ') !!}
                {!! Form::text('endereco[logradouro]', Session::getOldInput('endereco[logradouro]'), array('class' => 'form-control')) !!}
            </div>
            <div class="form-group col-md-2">
                {!! Form::label('endereco[numero]', 'Número') !!}
                {!! Form::text('endereco[numero]', Session::getOldInput('endereco[numero]'), array('class' => 'form-control')) !!}
            </div>
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
                {!! Form::label('endereco[bairros_id]', 'Bairro ') !!}
                @if(isset($model->endereco->bairro->id))
                    {!! Form::select('endereco[bairros_id]', array($model->endereco->bairro->id => $model->endereco->bairro->nome), $model->endereco->bairro->id,array('class' => 'form-control', 'id' => 'bairro')) !!}
                @else
                    {!! Form::select('endereco[bairros_id]', array(), Session::getOldInput('bairro'),array('class' => 'form-control', 'id' => 'bairro')) !!}
                @endif
            </div>
            <div class="form-group col-md-2">
                {!! Form::label('endereco[cep]', 'CEP ') !!}
                {!! Form::text('endereco[cep]', Session::getOldInput('endereco[cep]'), array('class' => 'form-control cep')) !!}
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    
				{!! Form::label('sexo_id', 'Sexo') !!}
				{!! Form::select('sexo_id',$loadFields['sexo'], null,  array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    
				{!! Form::label('turno_id', 'Turno') !!}
				{!! Form::select('turno_id', $loadFields['turno'], null, array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    
				{!! Form::label('titulacao_id', 'Titulação') !!}
				{!! Form::select('titulacao_id', $loadFields['titulacao'], null, array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">

                    {!! Form::label('grau_instrucao_id', 'Grau Intrução') !!}
                    {!! Form::select('grau_instrucao_id', $loadFields['grauinstrucao'], null, array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    
				{!! Form::label('profissao_id', 'Profissão') !!}
				{!! Form::select('profissao_id', $loadFields['profissao'], null, array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    
				{!! Form::label('religiao_id', 'Religião') !!}
				{!! Form::select('religiao_id', $loadFields['religiao'], null, array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    
				{!! Form::label('estado_civil_id', 'Estado Civil') !!}
				{!! Form::select('estado_civil_id', $loadFields['estadocivil'], null, array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    
				{!! Form::label('tipo_sanguinio_id', 'Tipo Sanguínio') !!}
				{!! Form::select('tipo_sanguinio_id', $loadFields['tiposanguinio'], null, array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    
				{!! Form::label('cor_raca_id', 'Cor/Raça') !!}
				{!! Form::select('cor_raca_id', $loadFields['corraca'], null, array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    
				{!! Form::label('uf_nascimento_id', 'UF Nascimento') !!}
				{!! Form::select('uf_nascimento_id', $loadFields['estado'], null, array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    
				{!! Form::label('email', 'E-mail') !!}
				{!! Form::text('email', Session::getOldInput('email')  , array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    
				{!! Form::label('telefone_fixo', 'Telefone Fixo') !!}
				{!! Form::text('telefone_fixo', Session::getOldInput('telefone_fixo')  , array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    
				{!! Form::label('celular', 'Celular') !!}
				{!! Form::text('celular', Session::getOldInput('celular')  , array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    
				{!! Form::label('celular2', 'Celular 2') !!}
				{!! Form::text('celular2', Session::getOldInput('celular2')  , array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="form-group col-md-4">
                {!! Form::label('tipoDef', 'Deficiências') !!}
                <div class="checkbox checkbox-primary">
                    {!! Form::hidden('deficiencia_fisica', 0) !!}
                    {!! Form::checkbox('deficiencia_fisica', 1, null, array('class' => 'form-control')) !!}
                    {!! Form::label('deficiencia_fisica', 'Física') !!}
                </div>
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
            <div class="col-md-2">
                <div class="fileinput fileinput-new" data-provides="fileinput">
                    <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 135px; height: 115px;">
                        @if (isset($model) && $model->path_image != null)
                            <div id="midias">
                                <img id="logo" src="/seracademico-laravel/public/images/{{$model->path_image}}"  alt="Foto" height="120" width="100"/><br/>
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
            <div class="col-md-4">
                <div class="form-group">
                    <label for="instituicao-graduacao">Graduação</label>
                    <select id="instituicao-graduacao" class="form-control" name="instituicao_graduacao_id">
                        @if(isset($model->id) && $model->instituicaoGraduacao != null)
                            <option value="{{ $model->instituicaoGraduacao->id  }}" selected="selected">{{ $model->instituicaoGraduacao->nome }}</option>
                        @endif
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="instituicao-pos">Pós Graduação</label>
                    <select id="instituicao-pos" class="form-control" name="instituicao_pos_id">
                        @if(isset($model->id) && $model->instituicaoPos != null)
                            <option value="{{ $model->instituicaoPos->id  }}" selected="selected">{{ $model->instituicaoPos->nome }}</option>
                        @endif
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="instituicao-mestrado">Mestrado</label>
                    <select id="instituicao-mestrado" class="form-control" name="instituicao_mestrado_id">
                        @if(isset($model->id) && $model->instituicaoMestrado != null)
                            <option value="{{ $model->instituicaoMestrado->id  }}" selected="selected">{{ $model->instituicaoMestrado->nome }}</option>
                        @endif
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="instituicao-doutorado">Doutorado</label>
                    <select id="instituicao-doutorado" class="form-control" name="instituicao_doutorado_id">
                        @if(isset($model->id) && $model->instituicaoDoutorado != null)
                            <option value="{{ $model->instituicaoDoutorado->id  }}" selected="selected">{{ $model->instituicaoDoutorado->nome }}</option>
                        @endif
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    
				{!! Form::label('especificacao_graduacao', 'Especificação Graduação') !!}
                {!! Form::text('especificacao_graduacao', Session::getOldInput('especificacao_graduacao')  , array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    
				{!! Form::label('especificacao_pos', 'Especificação Pós') !!}
                {!! Form::text('especificacao_pos', Session::getOldInput('especificacao_pos')  , array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    
				{!! Form::label('especificacao_mestrado', 'Especificação Mestrado') !!}
				{!! Form::text('especificacao_mestrado', Session::getOldInput('especificacao_mestrado')  , array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    
				{!! Form::label('especificacao_doutorado', 'Especificação Doutorado') !!}
				{!! Form::text('especificacao_doutorado', Session::getOldInput('especificacao_doutorado')  , array('class' => 'form-control')) !!}
                </div>
            </div>
		</div>
        <div class="row">
            <div class="col-md-8">

            </div>
            <div class="col-md-2">
                {!! Form::submit('Salvar', array('class' => 'btn btn-primary btn-block pull-right', 'id' => 'submitForm')) !!}
            </div>
            <div class="col-md-2">
                <a href="{{ route('seracademico.posgraduacao.professor.index') }}" class="btn btn-primary btn-block pull-right">Voltar</a>
            </div>
        </div>
	</div>
</div>