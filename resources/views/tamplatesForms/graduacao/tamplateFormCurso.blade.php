<div class="row">
	<div class="col-md-12">
		<div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    {!! Form::label('nome', 'Nome *') !!}
                    {!! Form::text('nome', Session::getOldInput('nome')  , array('class' => 'form-control')) !!}
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('codigo', 'Código *') !!}
                    {!! Form::text('codigo', Session::getOldInput('codigo')  , array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="form-group col-md-1">
                {!! Form::label('ativar', 'Ativar') !!}
                <div class="checkbox checkbox-primary">
                    {!! Form::hidden('ativo', 0) !!}
                    {!! Form::checkbox('ativo', 1, null, array('class' => 'form-control', 'id'=>'ativo')) !!}
                    {!! Form::label('ativo', 'Ativar', false) !!}
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('carga_horaria', 'Carga horária total') !!}
                    {!! Form::text('carga_horaria', Session::getOldInput('carga_horaria')  , array('class' => 'form-control number')) !!}
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
				{!! Form::label('duracao_meses', 'Duração (meses) ') !!}
				{!! Form::text('duracao_meses', Session::getOldInput('duracao_meses')  , array('class' => 'form-control number')) !!}
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('tipo_curso_id', 'Tipo Curso *') !!}
                    {!! Form::select('tipo_curso_id', $loadFields['tipocurso'], null,  array('class' => 'form-control')) !!}
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">                    
				{!! Form::label('cordenador_id', 'Cordenador') !!}
				{!! Form::select('cordenador_id', array(), null, array('class' => 'form-control')) !!}
                </div>
            </div>
            
            {{--<div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('tipo_nivel_sistema_id', 'Nível Sistema') !!}
                    {!! Form::select('tipo_nivel_sistema_id', $loadFields['tiponivelsistema'], null,  array('class' => 'form-control')) !!}
                </div>
            </div>--}}
		</div>
        <hr class="hr-line-dashed"/>

        {{--Linha da da Abas--}}
        <div class="row">
            <div class="col-md-12">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#autMec" aria-controls="dados" data-toggle="tab">Autorização MEC</a>
                    </li>
                    <li role="presentation">
                        <a href="#recMec" aria-controls="contato" role="tab" data-toggle="tab">Reconhecimento MEC</a>
                    </li>
                    <li role="presentation">
                        <a href="#vagas" aria-controls="ensMedio" role="tab" data-toggle="tab"> Vagas</a>
                    </li>
                    <li role="presentation">
                        <a href="#datas" aria-controls="documentosObrig" role="tab" data-toggle="tab">Datas</a>
                    </li>
                    <li role="presentation">
                        <a href="#finan" aria-controls="documentosObrig" role="tab" data-toggle="tab">Financeiro</a>
                    </li>

                </ul>
                <!-- End Nav tabs -->

                <!-- Tab panes -->
                <div class="tab-content">

                    {{--Aba Autorização MEC--}}
                    <div role="tabpanel" class="tab-pane active" id="autMec">
                        <br/>

                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    {!! Form::label('portaria_mec_aut', 'Portaria MEC (AUT)') !!}
                                    {!! Form::text('portaria_mec_aut', Session::getOldInput('portaria_mec_aut')  , array('class' => 'form-control')) !!}
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('numero_decreto_aut', 'Nº Decreto (AUT)') !!}
                                    {!! Form::text('numero_decreto_aut', Session::getOldInput('numero_decreto_aut')  , array('class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">

                                    {!! Form::label('data_decreto_aut', 'Data Decreto (AUT)') !!}
                                    {!! Form::text('data_decreto_aut', Session::getOldInput('data_decreto_aut'), array('class' => 'form-control datepicker date')) !!}
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">

                                    {!! Form::label('data_dou_aut', 'Data Dou (AUT)') !!}
                                    {!! Form::text('data_dou_aut', Session::getOldInput('data_dou_aut'), array('class' => 'form-control datepicker date')) !!}
                                </div>
                            </div>

                        </div>
                    </div>
                    {{--FIM Aba Autorização MEC--}}

                    {{--Aba Reconhecimento MEC--}}
                    <div role="tabpanel" class="tab-pane" id="recMec">
                        <br/>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">

                                    {!! Form::label('portaria_mec_rec', 'Portaria MEC (REC)') !!}
                                    {!! Form::text('portaria_mec_rec', Session::getOldInput('portaria_mec_rec')  , array('class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">

                                    {!! Form::label('numero_decreto_rec', 'Nº Decreto (REC)') !!}
                                    {!! Form::text('numero_decreto_rec', Session::getOldInput('numero_decreto_rec')  , array('class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">

                                    {!! Form::label('data_decreto_rec', 'Data Decreto (REC)') !!}
                                    {!! Form::text('data_decreto_rec', Session::getOldInput('data_decreto_rec')  , array('class' => 'form-control datepicker date')) !!}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">

                                    {!! Form::label('data_dou_rec', 'Data Dou (REC') !!}
                                    {!! Form::text('data_dou_rec', Session::getOldInput('data_dou_rec'), array('class' => 'form-control datepicker date')) !!}
                                </div>
                            </div>

                        </div>
                    </div>
                    {{--Aba Reconhecimento MEC--}}

                    {{--Aba Datas--}}
                    <div role="tabpanel" class="tab-pane" id="datas">
                        <br/>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">

                                    {!! Form::label('data_matricula_inicio', 'Matrícula Início') !!}
                                    {!! Form::text('data_matricula_inicio', Session::getOldInput('data_matricula_inicio'), array('class' => 'form-control datepicker date')) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">

                                    {!! Form::label('data_matricula_fim', 'Matrícula Final') !!}
                                    {!! Form::text('data_matricula_fim', Session::getOldInput('data_matricula_fim'), array('class' => 'form-control datepicker date')) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">

                                    {!! Form::label('inicio_aula', 'Início Aulas') !!}
                                    {!! Form::text('inicio_aula', Session::getOldInput('inicio_aula'), array('class' => 'form-control datepicker date')) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">

                                    {!! Form::label('fim_aula', 'Fim Aulas') !!}
                                    {!! Form::text('fim_aula', Session::getOldInput('fim_aula'), array('class' => 'form-control datepicker date')) !!}
                                </div>
                            </div>
                        </div>

                    </div>
                    {{--FIM Aba Datas --}}

                    {{--Aba Vagas--}}
                    <div role="tabpanel" class="tab-pane" id="vagas">
                        <br/>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">

                                    {!! Form::label('maximo_vagas', 'Máximo Vagas') !!}
                                    {!! Form::text('maximo_vagas', Session::getOldInput('maximo_vagas')  , array('class' => 'form-control number')) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">

                                    {!! Form::label('minimo_vagas', 'Mínimo Vagas') !!}
                                    {!! Form::text('minimo_vagas', Session::getOldInput('minimo_vagas')  , array('class' => 'form-control number')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Form::label('obs_vagas', 'Observação Vagas') !!}
                                    {!! Form::textarea('obs_vagas', Session::getOldInput('obs_vagas') , array('class' => 'form-control', 'rows'=>'3')) !!}
                                </div>
                            </div>
                        </div>

                    </div>
                    {{--FIM Aba Financeiro --}}

                    {{--Aba Vagas--}}
                    <div role="tabpanel" class="tab-pane" id="finan">
                        <br/>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">

                                    {!! Form::label('valor', 'Valor') !!}
                                    {!! Form::text('valor', Session::getOldInput('valor')  , array('class' => 'form-control money')) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">

                                    {!! Form::label('parcelas', 'Qtd. Parcelas') !!}
                                    {!! Form::text('parcelas', Session::getOldInput('parcelas')  , array('class' => 'form-control number')) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">

                                    {!! Form::label('vencimento_inicial', 'Vencimento Inicial') !!}
                                    {!! Form::text('vencimento_inicial', Session::getOldInput('vencimento_inicial'), array('class' => 'form-control datepicker date')) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--FIM Aba Financeiro --}}
                </div>
                <!-- FIM Tab panes -->
            </div>
        </div>
        {{--FIM Linha da da Abas--}}

        {{--Buttons Submit e Voltar--}}
        <div class="row">
            <div class="col-md-9"></div>
            <div class="col-md-3">
                <div class="btn-group btn-group-justified">
                <div class="btn-group">
                <a href="{{ route('seracademico.graduacao.curso.index') }}" class="btn btn-primary btn-block"><i class="fa fa-long-arrow-left"></i>  Voltar</a></div>
                <div class="btn-group">
                {!! Form::submit('Salvar', array('class' => 'btn btn-primary btn-block')) !!}
                </div>
            </div>
            
            
        </div>
        {{--Fim Buttons Submit e Voltar--}}

	</div>
</div>

@section('javascript')
    <script type="text/javascript">
        $(document).ready(function () {
            console.log(Lang.getLocale());
            Lang.setLocale('pt-BR');

            $('#formCurso').bootstrapValidator({
                fields: {
                    nome: {
                        validators: {
                            notEmpty: {
                                message: Lang.get('validation.required', { attribute: 'Nome' })
                            },
                            stringLength: {
                                max: 200,
                                message: Lang.get('validation.max', { attribute: 'Nome' })
                            }
                        }
                    },
                    codigo: {
                        validators: {
                            notEmpty: {
                                message: Lang.get('validation.required', { attribute: 'Código' })
                            }
                        }
                    },

                    duracao_meses: {
                        validators: {
                            numeric: {
                                message: Lang.get('validation.numeric', { attribute: 'Duraçao' })
                            }
                        }
                    },
                    numero_decreto_aut: {
                        validators: {
                            numeric: {
                                message: Lang.get('validation.numeric', { attribute: 'N' })
                            }
                        }
                    }
                }
            });

        });
    </script>
@stop