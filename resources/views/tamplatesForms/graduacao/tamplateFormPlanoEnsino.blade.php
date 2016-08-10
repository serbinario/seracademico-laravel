<div class="row">
	<div class="col-md-12">

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    					{!! Form::label('nome', 'Nome') !!}
					{!! Form::text('nome', Session::getOldInput('nome')  , array('class' => 'form-control')) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    
					{!! Form::label('vigencia', 'Vigência') !!}
					{!! Form::text('vigencia', Session::getOldInput('vigencia'), array('class' => 'form-control datepicker date')) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    
					{!! Form::label('disciplina_id', 'Disciplina') !!}
					{!! Form::select('disciplina_id', array(), NULL, array('class' => 'form-control')) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    					{!! Form::label('carga_horaria', 'CH') !!}
					{!! Form::text('carga_horaria', Session::getOldInput('carga_horaria')  , array('class' => 'form-control')) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    					{!! Form::label('conteudo_porgramatico_id', 'Conteudo Programatico') !!}
					{!! Form::text('conteudo_porgramatico_id', Session::getOldInput('conteudo_porgramatico_id')  , array('class' => 'form-control')) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    					{!! Form::label('ementa', 'Ementa') !!}
					{!! Form::text('ementa', Session::getOldInput('ementa')  , array('class' => 'form-control')) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    					{!! Form::label('obj_gerais', 'Obj. Gerais') !!}
					{!! Form::text('obj_gerais', Session::getOldInput('obj_gerais')  , array('class' => 'form-control')) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    					{!! Form::label('obj_especifico', 'Obj. Especificos') !!}
					{!! Form::text('obj_especifico', Session::getOldInput('obj_especifico')  , array('class' => 'form-control')) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    					{!! Form::label('metodologia', 'Metodologia') !!}
					{!! Form::text('metodologia', Session::getOldInput('metodologia')  , array('class' => 'form-control')) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    					{!! Form::label('recurso_audivisual', 'Recursos Audivisuais') !!}
					{!! Form::text('recurso_audivisual', Session::getOldInput('recurso_audivisual')  , array('class' => 'form-control')) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    					{!! Form::label('avaliacao', 'Avaliação') !!}
					{!! Form::text('avaliacao', Session::getOldInput('avaliacao')  , array('class' => 'form-control')) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    					{!! Form::label('bibliografia_basica', 'Bibliografia Básica') !!}
					{!! Form::text('bibliografia_basica', Session::getOldInput('bibliografia_basica')  , array('class' => 'form-control')) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    					{!! Form::label('competencia', 'Competência') !!}
					{!! Form::text('competencia', Session::getOldInput('competencia')  , array('class' => 'form-control')) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    					{!! Form::label('aula_pratica', 'Aulas Práticas') !!}
					{!! Form::text('aula_pratica', Session::getOldInput('aula_pratica')  , array('class' => 'form-control')) !!}
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
                <a href="{{ route('seracademico.graduacao.planoEnsino.index') }}" class="btn btn-primary"><i class="fa fa-long-arrow-left"></i>  Voltar</a>
            </div>
            <div class="btn-group">
                {!! Form::submit('Salvar', array('class' => 'btn btn-primary', 'id' => 'submitForm')) !!}
            </div>
        </div>
    </div>
</div>