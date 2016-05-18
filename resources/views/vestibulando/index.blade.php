@extends('menu')

@section("css")
    <link rel="stylesheet" href="{{ asset('/js/posgraduacao/turma/css/modal_calendario.css') }}">
    <style type="text/css">
        table.dataTable tbody th, table.dataTable tbody td {
            padding: 2px 10px;
        }
    </style>
@stop

@section('content')

    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <div class="col-sm-6 col-md-9">
                <h4>
                    <i class="fa fa-users"></i>
                    Listar Vestibulandos
                </h4>
            </div>
            <div class="col-sm-6 col-md-3">
                <a href="{{ route('seracademico.vestibulando.create')}}" class="btn-sm btn-primary pull-right">Novo Vestibulando</a>
            </div>
        </div>
        <div class="ibox-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive no-padding">
                        <table id="vestibulando-grid" class="display table table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Inscrição</th>
                                <th>Telefones</th>
                                <th>CPF</th>
                                <th>Vestibular</th>
                                <th>Acão</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Nome</th>
                                <th>Inscrição</th>
                                <th>Telefones</th>
                                <th>CPF</th>
                                <th>Vestibular</th>
                                <th style="width: 5%">Acão</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('vestibulando.modal_notas')
    @include('vestibulando.modal_notas_update')
    @include('vestibulando.modal_inclusao')
@stop

@section('javascript')
    <script type="text/javascript" src="{{ asset('/js/vestibulando/modal_notas.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/vestibulando/modal_notas_update.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/vestibulando/modal_inclusao.js') }}"></script>
    <script type="text/javascript">
        var table = $('#vestibulando-grid').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: "{!! route('seracademico.vestibulando.grid') !!}",
            columns: [
                {data: 'nome', name: 'fac_alunos.nome'},
                {data: 'inscricao', name: 'fac_alunos.inscricao'},
                {data: 'celular', name: 'fac_alunos.celular'},
                {data: 'cpf', name: 'fac_alunos.cpf'},
                {data: 'vestibular', name: 'vestibulares.nome'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

        // Id do vestibulando
        var idVestibulando;

        // Evento para modal de notas
        $(document).on('click', '#notas', function () {
            // Recuperando o id do vestibulando
            idVestibulando = table.row($(this).parent().parent().parent().parent().parent()).data().id;

            // Executando a tabela de notas
            runTableNotas(idVestibulando);
        });

        // Evento para modal de notas
        $(document).on('click', '#inclusao', function () {
            // Recuperando o id do vestibulando
            idVestibulando = table.row($(this).parent().parent().parent().parent().parent()).data().id;

            // Executando a tabela de notas
            runInclusao();
        });
    </script>
@stop
