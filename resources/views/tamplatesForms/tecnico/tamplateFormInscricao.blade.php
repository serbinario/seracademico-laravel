<div class="row">
	<div class="col-md-12">
		<div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('nome', 'Nome  *:  max 60 caracteres (0-9 A-Z .-[ ])')!!}
                    {!! Form::text('nome', Session::getOldInput('nome'), array('class' => 'form-control', 'placeholder'=>'Nome do Vestibular')) !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
				{!! Form::label('codigo', 'Codigo *: max 8 carac.') !!}
				{!! Form::text('codigo', Session::getOldInput('codigo'), array('class' => 'form-control', 'placeholder'=>'Código')) !!}
                </div>
            </div>

            <div class="form-group col-md-1">
                {{--{!! Form::label('ativar', 'Ativar') !!}--}}
                <div class="checkbox checkbox-primary">
                    {!! Form::hidden('ativo', 0) !!}
                    {!! Form::checkbox('ativo', 1, null, array('class' => 'form-control', 'id'=>'ativo')) !!}
                    {!! Form::label('ativo', 'Ativar', false) !!}
                </div>
            </div>
		</div>


        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    @if(isset($model->id))
                        {!! Form::label('data_ranger', 'Data Inicial - Data Final') !!}
                        {!! Form::text('data_ranger', "{$model->data_inicio} - {$model->data_fim}" , array('class' => 'form-control ','id' => 'data_ranger', 'placeholder' => 'dd/mm/yyyy')) !!}
                    @else
                        {!! Form::label('data_ranger', 'Data Inicial - Data Final') !!}
                        {!! Form::text('data_ranger', null , array('class' => 'form-control ','id' => 'data_ranger', 'placeholder' => 'dd/mm/yyyy')) !!}
                    @endif
                </div>
            </div>
            {{--<div class="col-md-2">--}}
            {{--<div class="form-group">--}}

            {{--{!! Form::label('data_final', 'Data Final') !!}--}}
            {{--{!! Form::text('data_final', null, array('class' => 'form-control date', 'placeholder' => 'dd/mm/yyyy')) !!}--}}
            {{--</div>--}}
            {{--</div>--}}
            <div class="col-md-2">
                <div class="form-group">

                    {!! Form::label('quantidade', 'Qtd. Vagas') !!}
                    {!! Form::text('quantidade', Session::getOldInput('quantidade')  , array('class' => 'form-control numberFor')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('taxa_id', 'Taxa *') !!}
                    @if(isset($model->taxa))
                        {!! Form::select('taxa_id', $loadFields['financeiro\\taxa'] , $model->taxa->id, array('class' => 'form-control')) !!}
                    @else
                        {!! Form::select('taxa_id', $loadFields['financeiro\\taxa'] , null, array('class' => 'form-control')) !!}
                    @endif
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
                <a href="{{ route('seracademico.tecnico.inscricao.index') }}" class="btn btn-primary btn-block"><i class="fa fa-long-arrow-left"></i>  Voltar</a></div>
            <div class="btn-group">
                {!! Form::submit('Salvar', array('class' => 'btn btn-primary btn-block')) !!}
            </div>
        </div>
    </div>
</div>

@section('javascript')
    <script type="text/javascript" src="{{ asset('js/vestibular/validacao/form_validation_inscricao.js')  }}"></script>
    <script type="text/javascript">
        // Alerta para ativar o vestibular
        $(document).on('click', '#ativo', function () {
            if ($(this).is(':checked')) {
                swal("Marcando esse Vestibular como ativo, estará automaticamente desativando o atual ativo.", "Click no botão abaixo!", "warning");
            }
        });
    </script>
@stop