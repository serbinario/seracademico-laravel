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
    </style>
@stop


@section('content')

    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <div class="col-sm-6 col-md-9">
                <h4>
                    <i class="flaticon-exam-1"></i>
                    Listar Inscrições
                </h4>
            </div>
            <div class="col-sm-6 col-md-3">
                <a href="{{ route('seracademico.tecnico.inscricao.create')}}" class="btn-sm btn-primary pull-right">Nova Inscrição</a>
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
                        <table id="inscricao-grid" class="display table table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th style="width: 20%;">Código</th>
                                <th>Nome</th>
                                <th>Data Inic. Insc.</th>
                                <th>Data Fim. Insc.</th>
                                <th>Data Criação</th>
                                <th>Situação</th>
                                <th style="width: 5%;">Acão</th>
                            </tr>
                            </thead>

                            <tfoot>
                            <tr>
                                <th style="width: 20%;">Código</th>
                                <th>Nome</th>
                                <th>Data Inic. Insc.</th>
                                <th>Data Fim. Insc.</th>
                                <th>Data Criação</th>
                                <th>Situação</th>
                                <th style="width: 5%;">Acão</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('tecnico.inscricao.modal_curso_turno')
    @include('tecnico.inscricao.modal_turno_store')
@stop

@section('javascript')
    <script src="{{ asset('/js/tecnico/inscricao/modal_curso.js')  }}"></script>
    <script src="{{ asset('/js/tecnico/inscricao/modal_turno.js')  }}"></script>
    <script src="{{ asset('/js/tecnico/inscricao/modal_turno_store.js')  }}"></script>
    <script type="text/javascript">



        var table = $('#inscricao-grid').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{!! route('seracademico.tecnico.inscricao.grid') !!}",
            columns: [
                {data: 'codigo', name: 'codigo'},
                {data: 'nome', name: 'nome'},
                {data: 'data_inicio', name: 'data_inicio'},
                {data: 'data_fim', name: 'data_fim'},
                {data: 'data_criacao', name: 'created_at'},
                {data: 'ativo', name: 'ativo'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });



        //declaração de variáveis úteis
        var idInscricao;

        // Ouvinte para evento de click no link de adicionar cursos
        $(document).on('click', '#btnAdicionarCursos', function () {
            // Recuperando o id do vestibular
            idInscricao = table.row($(this).parent().parent().parent().parent().parent().index()).data().id;

            // Carregando a grid de Cursos
            runTableDisciplinas(idInscricao);

            // Estado inicial dos botões de adicionar
            $("#btnAdicionarCursoTurno").attr("disabled", true);

            // Carregando a modal
            $('#modal-curso-turno').modal({ show:true });
        });
    </script>
@stop