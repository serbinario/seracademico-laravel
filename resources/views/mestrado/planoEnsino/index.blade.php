@extends('menu')

@section("css")

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
                    <i class="material-icons">line_weight</i>
                    Listar Planos de Ensino
                </h4>
            </div>
            <div class="col-sm-6 col-md-3">
                <a href="{{ route('seracademico.mestrado.planoEnsino.create')}}" class="btn-sm btn-primary pull-right">Novo Plano de Ensino</a>
            </div>
        </div>
        <div class="ibox-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive no-padding">
                        <table id="fac_plano_ensino" class="display table table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>

                                <th style="width: 32%;">Nome</th>

                                <th style="width: 32%;">Disciplina</th>

                                <th style="width: 3%;">CH</th>
                                <th style="width: 3%;">Vigência</th>

                                <th style="width: 3%;">Ativo</th>

                                <th style="width: 3%;">Ação</th>

                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('posGraduacao.planoEnsino.planoAula.modal_planos_aulas')
    @include('posGraduacao.planoEnsino.planoAula.modal_create_planos_aulas')
    @include('posGraduacao.planoEnsino.planoAula.modal_edit_planos_aulas')
@stop

@section('javascript')
    <script type="text/javascript" src="{{ asset('/js/posgraduacao/planoEnsino/planoAula/modal_planos_aulas.js')  }}"></script>
    <script type="text/javascript" src="{{ asset('/js/posgraduacao/planoEnsino/planoAula/modal_create_planos_aulas.js')  }}"></script>
    <script type="text/javascript" src="{{ asset('/js/posgraduacao/planoEnsino/planoAula/modal_edit_planos_aulas.js')  }}"></script>
    <script type="text/javascript" src="{{ asset('/js/posgraduacao/planoEnsino/planoAula/create_conteudo_programatico_plano_aula.js')  }}"></script>
    <script type="text/javascript" src="{{ asset('/js/posgraduacao/planoEnsino/planoAula/edit_conteudo_programatico_plano_aula.js')  }}"></script>
    <script type="text/javascript" src="{{ asset('/js/posgraduacao/planoEnsino/planoAula/grid_conteudo_programatico_plano_aula.js')  }}"></script>
    <script type="text/javascript">
        var table = $('#fac_plano_ensino').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{!! route('seracademico.mestrado.planoEnsino.grid') !!}",
            columns: [
                {data: 'nome', name: 'nome'},
                {data: 'nomeDisciplina', name: 'fac_disciplinas.nome'},
                {data: 'carga_horaria', name: 'carga_horaria'},
                {data: 'vigencia', name: 'vigencia'},
                {data: 'ativo', name: 'fac_plano_ensino.ativo'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

        // variável que armazenará o id do plano de enisno
        var idPlanoEnsino;

        // Evento disparado no click do link #modalPlanoAula
        $(document).on('click', '#modalPlanoAula', function () {
            // Recuperando o id
            idPlanoEnsino = table.row($(this).parents('tr')).data().id;

            // Recuperando os dados de descrição
            var nomePlanoEnsino = table.row($(this).parents('tr')).data().nome;
            var nomeDiscplina = table.row($(this).parents('tr')).data().nomeDisciplina;
            var cargaHoraria = table.row($(this).parents('tr')).data().carga_horaria;

            // Setando a descrição
            $('#paPlanoEnsino').text(nomePlanoEnsino);
            $('#paDisciplina').text(nomeDiscplina);
            $('#paCargaHoraria').text(cargaHoraria);

            // Executando o modal de plano de aula
            runPlanoAula(idPlanoEnsino);
        });
    </script>
@stop