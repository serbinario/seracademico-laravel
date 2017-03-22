<div class="row">
	<div class="col-md-12">
		<div class="row">
            @foreach($loadFields as $loadField)
                <div class="col-md-1">
                    <div class="checkbox checkbox-primary">
                        <input type="checkbox" @if($loadField->ativo == '1') checked @endif name="dias_letivos[]" value="{{$loadField->id}}" class="form-control">
                        {!! Form::label('dias_letivos', $loadField->nome, false) !!}
                    </div>
                </div>
            @endforeach
		</div>
	</div>
</div><br />
{{--Buttons Submit e Voltar--}}
<div class="row">
    <div class="col-md-3">
        <div class="btn-group btn-group-justified">
            <div class="btn-group">
                {!! Form::submit('Salvar', array('class' => 'btn btn-primary btn-block')) !!}
            </div>
        </div>
    </div>
    {{--Fim Buttons Submit e Voltar--}}
</div>