@extends('menu')


@section('content')

    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>
                Edição de aluno
            </h5>
            {{--<div class="ibox-tools">
                <a class="collapse-link">
                    <i class="fa fa-chevron-up"></i>
                </a>
            </div>--}}
        </div>
        <div class="ibox-content">
            {!! Form::open(['route'=>'seracademico.alunos.update', 'method' => "POST"]) !!}
            <div class="row">
                <div class="col-md-10">
                    <div class="row">
                        <div class="form-group col-md-7">
                            {!! Form::label('nome', 'Nome') !!}
                            {!! Form::text('', '', array('class' => 'form-control')) !!}
                        </div>
                        <div class="form-group col-md-2">
                            {!! Form::label('nome', 'Nascimento') !!}
                            {!! Form::text('', '', array('class' => 'form-control')) !!}
                        </div>
                        <div class="form-group col-md-1">
                            {!! Form::label('idade', 'Idade') !!}
                            {!! Form::text('', '', array('class' => 'form-control')) !!}
                        </div>
                        <div class="form-group col-md-2">
                            {!! Form::label('sexo', 'Sexo') !!}
                            {!! Form::select('', array('Masculino', 'Feminino'), '', array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-5">
                            {!! Form::label('curso', 'Curso') !!}
                            {!! Form::text('', '', array('class' => 'form-control')) !!}
                        </div>
                        <div class="form-group col-md-4">
                            {!! Form::label('matricula', 'Matrícula') !!}
                            {!! Form::text('', '', array('class' => 'form-control')) !!}
                            <input type="hidden" value="" name="idAluno">
                        </div>
                        <div class="form-group col-md-3">
                            {!! Form::label('turno', 'Turno') !!}
                            {!! Form::select('', array('Manhã', 'Tarde'), '',array('class' => 'form-control')) !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <img alt="image" class="img-container" src="img/profile_small.jpg">
                </div>
            </div>
            <hr class="hr-line-dashed"/>
            <div class="row">
                <div class="col-md-12">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#dados" aria-controls="dados" data-toggle="tab"><i class="fa fa-child"></i>  Dados pessoais</a>
                        </li>
                        <li role="presentation">
                            <a href="#contato" aria-controls="contato" role="tab" data-toggle="tab"><i class="fa fa-globe"></i>  Informações para contato</a>
                        </li>
                        <li role="presentation">
                            <a href="#curriculo" aria-controls="curriculo" role="tab" data-toggle="tab"><i class="fa fa-file-text"></i>  Currículo escolar</a>
                        </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="dados">
                            <br/>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="form-group col-md-5">
                                            {!! Form::label('nomePai', 'Nome Pai') !!}
                                            {!! Form::text('', '', array('class' => 'form-control')) !!}
                                        </div>
                                        <div class="form-group col-md-5">
                                            {!! Form::label('nomeMae', 'Nome Mãe') !!}
                                            {!! Form::text('', '', array('class' => 'form-control')) !!}
                                        </div>
                                        <div class="form-group col-md-2">
                                            {!! Form::label('emancipado', 'Emancipado') !!}
                                            {!! Form::select('', array(), '',array('class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-3">
                                            {!! Form::label('estadoCivil', 'Estado Civil') !!}
                                            {!! Form::select('', array(), '',array('class' => 'form-control')) !!}
                                        </div>
                                        <div class="form-group col-md-3">
                                            {!! Form::label('grauInstrucao', 'Grau de instrução') !!}
                                            {!! Form::select('', array(), '',array('class' => 'form-control')) !!}
                                        </div>
                                        <div class="form-group col-md-4">
                                            {!! Form::label('profissao', 'Profissão') !!}
                                            {!! Form::select('', array(), '',array('class' => 'form-control')) !!}
                                        </div>
                                        <div class="form-group col-md-2">
                                            {!! Form::label('religiao', 'Religião') !!}
                                            {!! Form::select('', array(), '',array('class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-3">
                                            {!! Form::label('corRaca', 'Cor/Raça') !!}
                                            {!! Form::select('', array(), '',array('class' => 'form-control')) !!}
                                        </div>
                                        <div class="form-group col-md-3">
                                            {!! Form::label('tipoSanguineo', 'Tipo Sanguíneo') !!}
                                            {!! Form::select('', array(), '', array('class' => 'form-control')) !!}
                                        </div>
                                        <div class="form-group col-md-6">
                                            {!! Form::label('deficiencia', 'Deficiência') !!}
                                            {!! Form::select('', array(), '',array('class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-3">
                                            {!! Form::label('pais', 'País') !!}
                                            {!! Form::select('', array(), '',array('class' => 'form-control')) !!}
                                        </div>
                                        <div class="form-group col-md-3">
                                            {!! Form::label('ufNascimento', 'UF') !!}
                                            {!! Form::select('', array(), '',array('class' => 'form-control')) !!}
                                        </div>
                                        <div class="form-group col-md-3">
                                            {!! Form::label('naturalidade', 'Naturalidade') !!}
                                            {!! Form::text('', '', array('class' => 'form-control')) !!}
                                        </div>
                                        <div class="form-group col-md-3">
                                            {!! Form::label('nacionalidade', 'Nacionalidade') !!}
                                            {!! Form::text('', '', array('class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                    <div class="panel-group" id="accordion">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"> <i class="fa fa-chevron-circle-down"></i>  Documentos</a>
                                                </h4>
                                            </div>
                                            <div id="collapseTwo" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="form-group col-md-3">
                                                            {!! Form::label('identidade', 'Identidade') !!}
                                                            {!! Form::text('', '', array('class' => 'form-control')) !!}
                                                        </div>
                                                        <div class="form-group col-md-3">
                                                            {!! Form::label('orgaoRG', 'Orgão RG') !!}
                                                            {!! Form::text('', '', array('class' => 'form-control')) !!}
                                                        </div>
                                                        <div class="form-group col-md-3">
                                                            {!! Form::label('ufExp', 'UF') !!}
                                                            {!! Form::text('', '', array('class' => 'form-control')) !!}
                                                        </div>
                                                        <div class="form-group col-md-3">
                                                            {!! Form::label('dataExpedicao', 'Data expedição') !!}
                                                            <?php //$date = explode('T', $cliente['data_expedicao_alunos']);
                                                            //$data = \DateTime::createFromFormat('Y-m-d', $date[0]); ?>
                                                            {!! Form::text('', '', array('class' => 'form-control')) !!}
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-md-3">
                                                            {!! Form::label('cpf', 'CPF') !!}
                                                            {!! Form::text('', '', array('class' => 'form-control')) !!}
                                                        </div>
                                                        <div class="form-group col-md-2">
                                                            {!! Form::label('tituloEleitoral', 'Título Eleitoral') !!}
                                                            {!! Form::text('', '', array('class' => 'form-control')) !!}
                                                        </div>
                                                        <div class="form-group col-md-1">
                                                            {!! Form::label('secao', 'Seção') !!}
                                                            {!! Form::text('', '', array('class' => 'form-control')) !!}
                                                        </div>
                                                        <div class="form-group col-md-3">
                                                            {!! Form::label('reservista', 'Reservista') !!}
                                                            {!! Form::text('', '', array('class' => 'form-control')) !!}
                                                        </div>
                                                        <div class="form-group col-md-3">
                                                            {!! Form::label('categoriaReser', 'Categoria Reservista') !!}
                                                            {!! Form::text('', '', array('class' => 'form-control')) !!}
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
                                        <div class="form-group col-md-3">
                                            {!! Form::label('cep', 'CEP') !!}
                                            {!! Form::text('', '', array('class' => 'form-control')) !!}
                                        </div>
                                        <div class="form-group col-md-2">
                                            {!! Form::label('uf', 'UF') !!}
                                            {!! Form::select('', array('PE', 'PB'), '',array('class' => 'form-control', 'id' => 'estado')) !!}
                                        </div>
                                        <div class="form-group col-md-7">
                                            {!! Form::label('cidade', 'Cidade') !!}
                                            {!! Form::select('', array(), '',array('class' => 'form-control', 'id' => 'cidade')) !!}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            {!! Form::label('bairro', 'Bairro') !!}
                                            {!! Form::select('', array(), '',array('class' => 'form-control', 'id' => 'bairro')) !!}
                                        </div>
                                        <div class="form-group col-md-6">
                                            {!! Form::label('endereco', 'Endereço') !!}
                                            {!! Form::text('', '', array('class' => 'form-control')) !!}
                                        </div>
                                        <div class="form-group col-md-2">
                                            {!! Form::label('numero', 'Número') !!}
                                            {!! Form::text('', '', array('class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-5">
                                            {!! Form::label('email', 'Email') !!}
                                            {!! Form::text('', '', array('class' => 'form-control')) !!}
                                        </div>
                                        <div class="form-group col-md-3">
                                            {!! Form::label('telefone', 'Telefone') !!}
                                            {!! Form::text('', '', array('class' => 'form-control')) !!}
                                        </div>
                                        <div class="form-group col-md-2">
                                            {!! Form::label('celular1', 'Celular 1') !!}
                                            {!! Form::text('', '', array('class' => 'form-control')) !!}
                                        </div>
                                        <div class="form-group col-md-2">
                                            {!! Form::label('celular2', 'Celular 2') !!}
                                            {!! Form::text('', '', array('class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="curriculo">
                            <br/>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            {!! Form::label('outraEscola', 'Escola 2º Grau') !!}
                                            {!! Form::text('', '', array('class' => 'form-control')) !!}
                                        </div>
                                        <div class="form-group col-md-3">
                                            {!! Form::label('anoConlusao', 'Ano Conclusão') !!}
                                            {!! Form::text('', '', array('class' => 'form-control')) !!}
                                        </div>
                                        <div class="form-group col-md-3">
                                            {!! Form::label('mediaGlobal', 'Média global') !!}
                                            {!! Form::text('', '', array('class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {!! Form::label('1Exame', '1º Exame') !!}
                                                {!! Form::select('', array(), '', array('class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                {!! Form::label('data1', 'Data') !!}
                                                <?php //$date3 = explode('T', $cliente['data_exame_nacional_um']);
                                                //$data3 = \DateTime::createFromFormat('Y-m-d', $date3[0]); ?>
                                                {!! Form::text('', '', array('class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                {!! Form::label('nota1', 'Nota') !!}
                                                {!! Form::text('', '', array('class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {!! Form::label('2Exame', '2º Exame') !!}
                                                {!! Form::select('', array(), '', array('class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                {!! Form::label('data2', 'Data') !!}
                                                <?php //$date4 = explode('T', $cliente['data_exame_nacional_dois']);
                                                //$data4 = \DateTime::createFromFormat('Y-m-d', $date4[0]); ?>
                                                {!! Form::text('', '', array('class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                {!! Form::label('nota2', 'Nota') !!}
                                                {!! Form::text('', '', array('class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                    </div>

                                    {{--<div class="form-group">
                                        <label for="instituicao">Instituição</label>
                                        <select name="alunos[instituicao]" class="form-control" id="instituicao">
                                            <option value=""></option>
                                        </select>
                                    </div>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    {!! Form::submit('Enviar', array('class' => 'btn btn-primary')) !!}
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>

    @section('javascript')
    <script type="text/javascript">
        $(document).ready(function () {
            //Carregando os estados
            jQuery.ajax({
                type: 'GET',
                url: 'http://localhost/SerAcademico/web/app_dev.php/estados/all',
                headers: {
                    'Authorization': 'Bearer {{ Session::get("access_token") }}',
                    'X-CSRF-TOKEN' : '{{  csrf_token() }}'
                },
                datatype: 'json'
            }).done(function (json) {
                var option = "";

                option += '<option value="">Selecione um estado</option>';
                for (var i = 0; i < json.length; i++) {
                    option += '<option value="' + json[i]['id_estados'] + '">' + json[i]['prefixo_estados'] + '</option>';
                }

                $('#estado option').remove();
                $('#estado').append(option);
            });


            //Carregando as cidades
            $(document).on('change', "#estado", function () {
                var estado = $(this).val();

                if (estado !== "") {
                    var dados = {
                        estado: estado
                    }

                    jQuery.ajax({
                        type: 'POST',
                        url: 'http://localhost/SerAcademico/web/app_dev.php/cidades/byestado',
                        headers: {
                            'Authorization': 'Bearer {{ Session::get("access_token") }}',
                            'X-CSRF-TOKEN': '{{  csrf_token() }}'
                        },
                        data: dados,
                        datatype: 'json'
                    }).done(function (json) {
                        var option = "";

                        option += '<option value="">Selecione uma cidade</option>';
                        for (var i = 0; i < json.length; i++) {
                            option += '<option value="' + json[i]['id_cidades'] + '">' + json[i]['nome_cidade'] + '</option>';
                        }

                        $('#cidade option').remove();
                        $('#cidade').append(option);
                    });
                }
            });

            //Carregando os bairros
            $(document).on('change', "#cidade", function () {
                var cidade = $(this).val();

                if (cidade !== "") {
                    var dados = {
                        cidade: cidade
                    }

                    jQuery.ajax({
                        type: 'POST',
                        url: 'http://localhost/SerAcademico/web/app_dev.php/bairros/bycidade',
                        headers: {
                            'Authorization': 'Bearer {{ Session::get("access_token") }}',
                            'X-CSRF-TOKEN': '{{  csrf_token() }}'
                        },
                        data: dados,
                        datatype: 'json'
                    }).done(function (json) {
                        var option = "";

                        option += '<option value="">Selecione um bairro</option>';
                        for (var i = 0; i < json.length; i++) {
                            option += '<option value="' + json[i]['id_bairros'] + '">' + json[i]['nome_bairros'] + '</option>';
                        }

                        $('#bairro option').remove();
                        $('#bairro').append(option);
                    });
                }
            });
        });
    </script>
    @stop
@stop
