@extends('menu')

@section('content')

    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <div class="col-sm-6 col-md-9">
                <h4>
                    <i class="material-icons">class</i>
                    Listar Planos de Ensino
                </h4>
            </div>
            <div class="col-sm-6 col-md-3">
                <a href="{{ route('seracademico.graduacao.planoEnsino.create')}}" class="btn-sm btn-primary pull-right">Novo Plano de Ensino</a>
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

                                <th style="width: 3%;">Ação</th>

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
        var table = $('#fac_plano_ensino').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{!! route('seracademico.graduacao.planoEnsino.grid') !!}",
            columns: [
                {data: 'nome', name: 'nome'},
                {data: 'disciplina_id', name: 'disciplina_id'},
                {data: 'carga_horaria', name: 'carga_horaria'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    </script>
@stop