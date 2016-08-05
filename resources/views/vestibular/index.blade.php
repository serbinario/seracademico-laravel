@extends('menu')

@section('css')
    <link rel="stylesheet" href="{{ asset('/js/vestibular/css/modal_curso_materia_turno.css') }}">
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
                    Listar Vestibulares
                </h4>
            </div>
            <div class="col-sm-6 col-md-3">
                <a href="{{ route('seracademico.vestibular.create')}}" class="btn-sm btn-primary pull-right">Novo Vestibular</a>
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
                        <table id="vestibular-grid" class="display table table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th style="width: 20%;">Código</th>
                                <th>Nome</th>
                                <th>Data Prova</th>
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
                                <th>Data Prova</th>
                                <th>Data Prova</th>
                                <th>Data Prova</th>
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

    @include('vestibular.modal_curso_materia_turno')
    @include('vestibular.modal_materia_store')
    @include('vestibular.modal_turno_store')
@stop

@section('javascript')
    <script src="{{ asset('/js/vestibular/modal_curso.js')  }}"></script>
    <script src="{{ asset('/js/vestibular/modal_materia.js')  }}"></script>
    <script src="{{ asset('/js/vestibular/modal_turno.js')  }}"></script>
    <script src="{{ asset('/js/vestibular/modal_materia_store.js')  }}"></script>
    <script src="{{ asset('/js/vestibular/modal_turno_store.js')  }}"></script>
    <script type="text/javascript">
        var table = $('#vestibular-grid').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{!! route('seracademico.vestibular.grid') !!}",
            columns: [
                {data: 'codigo', name: 'codigo'},
                {data: 'nome', name: 'nome'},
                {data: 'data_prova', name: 'data_prova'},
                {data: 'data_inicial', name: 'data_inicial'},
                {data: 'data_final', name: 'data_final'},
                {data: 'data_criacao', name: 'created_at'},
                {data: 'ativo', name: 'ativo'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

        //declaração de variáveis úteis
        var idVestibular;

        // Ouvinte para evento de click no link de adicionar cursos
        $(document).on('click', '#btnAdicionarCursos', function () {
            // Recuperando o id do vestibular
            idVestibular = table.row($(this).parent().parent().parent().parent().parent().index()).data().id;

            // Carregando a grid de Cursos
            runTableCurso(idVestibular);

            // Estado inicial dos botões de adicionar
            $("#btnAdicionarCursoMateria").attr("disabled", true);
            $("#btnAdicionarCursoTurno").attr("disabled", true);

            // Carregando a modal
            $('#modal-curso-materia-turno').modal({ show:true });
        });
    </script>
@stop