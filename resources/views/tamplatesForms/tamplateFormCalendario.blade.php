<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="form-group col-md-4">
                {!! Form::label('nome', 'Nome') !!}
                {!! Form::text('nome', Session::getOldInput('nome'), array('class' => 'form-control', 'placeholder' => 'Nome do calendário')) !!}
            </div>
            <div class="form-group col-md-1">
                {!! Form::label('ano', 'Ano') !!}
                {!! Form::text('ano', Session::getOldInput('ano'), array('class' => 'form-control', 'placeholder' => 'Ano')) !!}
            </div>

        </div>
        {{--Buttons Submit e Voltar--}}
        <div class="row">
            <div class="col-md-9"></div>
            <div class="col-md-3">
                <div class="btn-group btn-group-justified">
                    <div class="btn-group">
                        <a href="{{ route('seracademico.calendarioAnual.index') }}" class="btn btn-primary btn-block"><i class="fa fa-long-arrow-left"></i>  Voltar</a></div>
                    <div class="btn-group">
                        {!! Form::submit('Salvar', array('class' => 'btn btn-primary btn-block')) !!}
                    </div>
                </div>
            </div>
            {{--Fim Buttons Submit e Voltar--}}
        </div>
    </div>
</div>

@section('javascript')
    {{--Mensagens personalizadas--}}{{--
    <script type="text/javascript" src="{{ asset('/js/validacoes/messages_pt_BR.js')  }}"></script>
    --}}{{--Regras adicionais--}}{{--
    <script type="text/javascript" src="{{ asset('/js/validacoes/regrasAdicionais/unique.js')  }}"></script>
    <script type="text/javascript" src="{{ asset('/lib/jquery-validation/src/additional/integer.js')  }}"></script>
    --}}{{--Regras de validação--}}{{--
    <script type="text/javascript" src="{{ asset('/js/validacoes/moduloParametros/calendarioValidator.js')  }}"></script>--}}
@endsection