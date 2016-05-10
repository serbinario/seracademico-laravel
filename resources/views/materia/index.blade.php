@extends('menu')

@section('content')

    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <div class="col-sm-6 col-md-9">
                <h4>
                    <i class="material-icons">class</i>
                    Listar Matérias
                </h4>
            </div>
            <div class="col-sm-6 col-md-3">
                <a href="{{ route('seracademico.materia.create')}}" class="btn-sm btn-primary pull-right">Nova Matéria</a>
            </div>
        </div>
        <div class="ibox-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive no-padding">
                        <table id="materia-grid" class="display table table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th style="width: 20%;">Código</th>
                                <th>Nome</th>
                                <th style="width: 5%;">Acão</th>
                            </tr>
                            </thead>

                            <tfoot>
                            <tr>
                                <th style="width: 20%;">Código</th>
                                <th>Nome</th>
                                <th style="width: 5%;">Acão</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('javascript')
    <script type="text/javascript">
        var table = $('#materia-grid').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{!! route('seracademico.materia.grid') !!}",
            columns: [
                {data: 'codigo', name: 'codigo'},
                {data: 'nome', name: 'nome'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    </script>
@stop