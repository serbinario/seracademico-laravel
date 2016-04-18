@extends('menu')

@section('content')
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <div class="col-md-9">
                <h4>
                    <i class="fa fa-users"></i>
                    Listar Tipos de Disciplinas
                </h4>
            </div>
            <div class="col-md-3">
                <a href="{{ route('seracademico.tipoDisciplina.create')}}"" class="btn-sm btn-primary">Novo Tipo de Disciplina</a>
            </div>
        </div>

        <div class="ibox-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive no-padding">
                        <table id="sala-grid" class="display table table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Nome</th>
                                <th >Acão</th>
                            </tr>
                            </thead>

                            <tfoot>
                            <tr>
                                <th>Nome</th>
                                <th style="width: 10%;">Acão</th>
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
        var table = $('#sala-grid').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{!! route('seracademico.tipoDisciplina.grid') !!}",
            columns: [
                {data: 'nome', name: 'nome'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    </script>
@stop