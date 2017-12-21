@extends('menu')

@section('css')
    <link rel="stylesheet" href="{{ asset('/js/tecnico/inscricao/css/modal_curso_turno.css') }}">
    <style type="text/css">
        .select2-close-mask{
            z-index: 2099;
        }

        .select2-dropdown{
            z-index: 3051;
        }

        #disciplina-grid tbody tr{
            font-size: 10px;
        }

        table.dataTable tbody th, table.dataTable tbody td {
            padding: 2px 10px;
        }

        .carregamento{
            display:    none;
            position:   fixed;
            z-index:    1000;
            top:        0;
            left:       0;
            height:     100%;
            width:      100%;
            background: rgba( 255, 255, 255, .8 )
            url("{{ asset('/img/pre-loader/gears_200x200.gif') }}")
            50% 50%
            no-repeat;
        }
    </style>
@stop


@section('content')

    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <div class="col-sm-6 col-md-9">
                <h4>
                    <i class="flaticon-exam-1"></i>
                    Listar Alunos
                </h4>
            </div>
            <div class="col-sm-6 col-md-3">
                <a href="{{ route('seracademico.emais.aluno.create')}}" class="btn-sm btn-primary pull-right">Novo Aluno</a>
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
                    <div class="table-responsive no-padding">
                        <table id="aluno-grid" class="display table table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Turno</th>
                                <th>Telefone celular</th>
                                <th>Data criação</th>
                                <th style="width: 5%;">Acão</th>
                            </tr>
                            </thead>

                            <tfoot>
                            <tr>
                                <th>Nome</th>
                                <th>Turno</th>
                                <th>Telefone celular</th>
                                <th>Data criação</th>
                                {{--<th>Situação</th>--}}
                                <th style="width: 5%;">Acão</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="carregamento"></div>
@stop

@include('emais.financeiro.modal_debitos')
@include('emais.financeiro.modal_create_debito')
@include('emais.financeiro.modal_edit_debito')
@include('emais.financeiro.modal_info_debito')

@section('javascript')
    <script type="text/javascript" src="{{ asset('/js/emais/aluno/financeiro/modal_debitos.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/emais/aluno/financeiro/modal_create_debitos.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/emais/aluno/financeiro/modal_edit_debitos.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/emais/aluno/financeiro/gerar_boleto.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/emais/aluno/financeiro/modal_info_debito.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/emais/aluno/financeiro/valida_campos_debitos.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/financeiro/helpers.js') }}"></script>
    <script type="text/javascript">
        var table = $('#aluno-grid').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{!! route('seracademico.emais.aluno.grid') !!}",
            columns: [
                {data: 'nome', name: 'pessoas.nome'},
                {data: 'turno', name: 'pre_turnos.nome'},
                {data: 'tel_celular', name: 'pre_alunos.tel_celular'},
                {data: 'data_criacao', name: 'pre_alunos.created_at'},
                /*{data: 'ativo', name: 'ativo'},*/
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

        // Evento para abrir o modal do financeiro
        $(document).on("click", "#btnModalFinanceiro", function () {
            // Recuperando os dados do aluno selecionado
            var rowTable = $(this).parents('tr');
            idAluno = table.row(rowTable).data().id;
            var nomeAluno   = table.row(rowTable).data().nome;

            $('#finNomeAluno').text(nomeAluno);

            runFinanceiro(idAluno);
        });
    </script>
@stop