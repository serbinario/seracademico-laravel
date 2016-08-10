<div class="row">
	<div class="col-md-12">


        <div class="row">
            <div class="col-md-10">
                <div class="form-group">
                    {!! Form::label('nome', 'Nome') !!}
					{!! Form::text('nome', Session::getOldInput('nome')  , array('class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('vigencia', 'Vigência') !!}
                    {!! Form::text('vigencia', Session::getOldInput('vigencia') , array('class' => 'form-control date datepicker')) !!}
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
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('carga_horaria', 'CH') !!}
					{!! Form::text('carga_horaria', Session::getOldInput('carga_horaria')  , array('class' => 'form-control')) !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::label('ementa', 'Ementa') !!}
                    {!! Form::textarea('ementa', Session::getOldInput('ementa') , array('class' => 'form-control', 'rows'=>'3')) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::label('obj_gerais', 'Obj. Gerais') !!}
                    {!! Form::textarea('obj_gerais', Session::getOldInput('obj_gerais') , array('class' => 'form-control', 'rows'=>'3')) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::label('obj_especifico', 'Obj. Especificos') !!}
                    {!! Form::textarea('obj_especifico', Session::getOldInput('obj_especifico') , array('class' => 'form-control', 'rows'=>'3')) !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::label('recurso_audivisual', 'Recursos Audivisuais') !!}
                    {!! Form::textarea('recurso_audivisual', Session::getOldInput('recurso_audivisual') , array('class' => 'form-control', 'rows'=>'3')) !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::label('bibliografia_basica', 'Bibliografia Básica') !!}
                    {!! Form::textarea('bibliografia_basica', Session::getOldInput('bibliografia_basica') , array('class' => 'form-control', 'rows'=>'3')) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::label('competencia', 'Competência') !!}
                    {!! Form::textarea('competencia', Session::getOldInput('competencia') , array('class' => 'form-control', 'rows'=>'3')) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::label('aula_pratica', 'Aulas Práticas') !!}
                    {!! Form::textarea('aula_pratica', Session::getOldInput('aula_pratica') , array('class' => 'form-control', 'rows'=>'3')) !!}
                </div>
            </div>
        </div>
	</div>

    {{--Linha da da Abas--}}
    <div class="row">
        <div class="col-md-12">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#autMec" aria-controls="dados" data-toggle="tab"><i class="material-icons">playlist_add</i> Autorização MEC</a>
                </li>
                <li role="presentation">
                    <a href="#metodologia" aria-controls="contato" role="tab" data-toggle="tab"><i class="material-icons">playlist_add_check</i> Metodologia</a>
                </li>
                <li role="presentation">
                    <a href="#avaliacao" aria-controls="ensMedio" role="tab" data-toggle="tab"><i class="material-icons">event_seat</i> Avaliacao</a>
                </li>
                <li role="presentation">
                    <a href="#datas" aria-controls="documentosObrig" role="tab" data-toggle="tab"><i class="material-icons">event</i> Datas</a>
                </li>
                <li role="presentation">
                    <a href="#finan" aria-controls="documentosObrig" role="tab" data-toggle="tab"><i class="material-icons">account_balance_wallet</i> Financeiro</a>
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

                {{--Aba metodologia--}}
                <div role="tabpanel" class="tab-pane" id="metodologia">
                    <br/>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                {!! Form::label('metodologia', 'Metodologia') !!}
                                {!! Form::textarea('metodologia', Session::getOldInput('metodologia') , array('class' => 'form-control', 'rows'=>'3')) !!}
                            </div>
                        </div>
                    </div>

                </div>
                {{--Aba metodologia--}}

                {{--Aba Datas--}}
                <div role="tabpanel" class="tab-pane" id="avaliacao">
                    <br/>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                {!! Form::label('avaliacao', 'Avaliação') !!}
                                {!! Form::textarea('avaliacao', Session::getOldInput('avaliacao') , array('class' => 'form-control', 'rows'=>'3')) !!}

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
                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('obs_vagas', 'Observação Vagas') !!}
                                {!! Form::textarea('obs_vagas', Session::getOldInput('obs_vagas')  ,['size' => '50x5'] , array('class' => 'form-control')) !!}
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

</div>

<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            {!! Form::label('conteudo_porgramatico_id', 'Conteudo Programatico') !!}
            {!! Form::text('conteudo_porgramatico_id', Session::getOldInput('conteudo_porgramatico_id')  , array('class' => 'form-control')) !!}
        </div>
    </div>
</div>

{{-- Grid conteudo programatico --}}
<div class="ibox-content">
    <div class="row">
        <div class="col-md-9">
            <div class="table-responsive no-padding">
                <table id="fac_plano_ensino" class="display table table-bordered" cellspacing="0" width="100%">
                    <thead>
                    <tr>

                        <th style="width: 20%;">Nome</th>

                    </tr>
                    </thead>
                </table>
            </div>
        </div>

        {{-- Botão --}}
        <div class="col-md-3">
            <a class="btn-sm btn-primary pull-right">Adicionar Conteúdo</a>
        </div>

    </div>
</div>
</br>
{{-- Grid conteudo programatico --}}

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

@section('javascript')
    <script type="text/javascript">
        
    </script>
@stop