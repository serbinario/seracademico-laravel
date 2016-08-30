@extends('menu')

@section('content')
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <div class="col-sm-6 col-md-9">
                <h4>
                    <i class="flaticon-employment-test"></i>
                    Relatório do Currículo
                </h4>
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

            <div class="row">
                <div class="col-md-12">
                    {!! Form::open(['route'=>'seracademico.graduacao.curriculo.reportById', 'method' => "POST", 'id' => 'reportCurriculo', 'class' => 'form-inline']) !!}
                    <div class="form-group">
                            {!! Form::select('curso_id', (['' => 'Selecione um Curso'] + $loadFields['graduacao\\curso']->toArray()), null, array('class' => 'form-control', 'id' => 'curso_id')) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::select('curriculo_id', ['' => 'Selecione um Currículo'], null, array('class' => 'form-control', 'id' => 'curriculo_id')) !!}
                        </div>

                        <div class="form-group">
                            <button class="btn-sm btn-primary" type="submit">Pesquisar</button>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop

@section('javascript')
    <script type="text/javascript">
        //Carregando os Currículos
        $(document).on('change', "#curso_id", function () {
            //Removendo os currículos
            $('#curriculo_id option').remove();

            //Recuperando o curso
            var curso = $(this).val();

            if (curso !== "") {
                var dados = {
                    'table' : 'fac_curriculos',
                    'field_search' : 'curso_id',
                    'value_search': curso,
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

                    option += '<option value="">Selecione um currículo</option>';
                    for (var i = 0; i < json.length; i++) {
                        option += '<option value="' + json[i]['id'] + '">'+ json[i]['codigo'] + ' : ' + json[i]['nome'] + '</option>';
                    }

                    $('#curriculo_id option').remove();
                    $('#curriculo_id').append(option);
                });
            }
        });

        // Evento para carregar o relatório
        $('#reportCurriculo').submit(function (event) {
            // Cancelando a propagação do método
            event.preventDefault();

            // Recuperando o id do currículo
            var curriculoId = $('#curriculo_id').find('option:selected').val();

            // Verificando se o currículo foi passado
            if(!curriculoId) {
                swal('Você deve informar um currículo', '', 'error');
                return false;
            }

            // Redirecionando
            window.open('/index.php/seracademico/graduacao/curriculo/reportById/' + curriculoId,'_blank');
        });
    </script>
@stop
