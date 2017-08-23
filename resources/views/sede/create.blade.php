@extends('menu')

@section('content')
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <div class="col-sm-6 col-md-9">
                <h4><i class="fa fa-building"></i>Cadastrar Polo</h4>
            </div>
            <div class="col-sm-6 col-md-3">

            </div>
        </div>

        <div class="ibox-content">

            @if(Session::has('message'))
                <div class="alert alert-success">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <em> {!! session('message') !!}</em>
                </div>
            @endif

            @if(Session::has('errors'))
                <div class="alert alert-danger">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            {!! Form::open(['route'=>'seracademico.sede.store', 'method' => "POST" ]) !!}
                @include('tamplatesForms.tamplateFormSede')
            {!! Form::close() !!}
        </div>        
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
        </script>
    @stop
@stop