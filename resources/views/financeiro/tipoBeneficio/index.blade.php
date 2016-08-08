@extends('menu')

@section('content')

    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <div class="col-sm-6 col-md-9">
                <h4>
                    <i class="material-icons">class</i>
                    Listar Tipos de Beneficios
                </h4>
            </div>
            <div class="col-sm-6 col-md-3">
                <a href="{{ route('seracademico.financeiro.tipoBeneficio.create')}}" class="btn-sm btn-primary pull-right">Nova Tipo de Beneficio</a>
            </div>
        </div>
        <div class="ibox-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive no-padding">
                        <table id="tipos-beneficios-grid" class="display table table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>

                                <th style="width: 16%;">Código</th>

                                <th style="width: 16%;">Descrição</th>

                                <th style="width: 16%;">Válido</th>

                                <th style="width: 16%;">Até</th>

                                <th style="width: 16%;">Inicio</th>

                                <th style="width: 16%;">Final</th>

                                <th style="width: 16%;">Valor</th>

                                <th style="width: 16%;">Tipo</th>

                                <th style="width: 16%;">Incidência</th>

                                <th style="width: 16%;">Dia Inicial</th>

                                <th style="width: 16%;">Dia Final</th>

                                <th style="width: 16%;">Tipo Dia</th>

                                <th style="width: 16%;">Acao</th>

                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('javascript')
    <script type="text/javascript">
        var table = $('#tipos-beneficios-grid').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{!! route('seracademico.financeiro.tipoBeneficio.grid') !!}",
            columns: [
                {data: 'codigo',        name: 'fin_tipos_beneficios.codigo'},        //codigo
                {data: 'nome',          name: 'fin_tipos_beneficios.nome'},          //nome
                {data: 'validoInicio',  name: 'fin_tipos_beneficios.valido_inicio'}, //rg
                {data: 'validoFim',     name: 'fin_tipos_beneficios.valido_fim'},    //data nasc
                {data: 'dataInicio',    name: 'fin_tipos_beneficios.data_inicio'},   //cpf
                {data: 'dataFim',       name: 'fin_tipos_beneficios.data_fim'},      //endereco
                {data: 'valor',         name: 'fin_tipos_beneficios.valor'},         //endereco
                {data: 'tipoId',        name: 'fin_tipos_valores.nome'},               //endereco
                {data: 'incidenciaId',  name: 'fin_incidencia.nome'},                  //endereco
                {data: 'diaInicialId',  name: 'data_nascimento_inicial.nome'},             //endereco
                {data: 'diaFinalId',    name: 'data_nascimento_final.nome'},             //endereco
                {data: 'tipoDiaId',     name: 'fin_tipo_dia.nome'},                    //endereco
                {data: 'action',        name: 'action', orderable: false, searchable: false}
            ]
        });
    </script>
@stop