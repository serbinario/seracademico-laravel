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
                <h4><i class="flaticon-teacher-at-the-blackboard"></i>
                    Listar Professores</h4>
            </div>
            <div class="col-sm-6 col-md-3">
                <a href="{{ route('seracademico.posgraduacao.professorpos.create')}}" class="btn-sm btn-primary pull-right">Novo Professor</a>
            </div>
        </div>
        <div class="ibox-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive no-padding">
                        <table id="professor-grid" class="display table table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Nome</th>
                                <th>CPF</th>
                                <th>Acão</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Nome</th>
                                <th>CPF</th>
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
        var table = $('#professor-grid').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{!! route('seracademico.posgraduacao.professorpos.grid') !!}",
            columns: [
                {data: 'nome', name: 'pessoas.nome'},
                {data: 'cpf', name: 'pessoas.cpf'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

        /*//Seleciona uma linha
        $('#aluno-grid tbody').on( 'click', 'tr', function () {
            if ( $(this).hasClass('selected') ) {
                $(this).removeClass('selected');
            }
            else {
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        } );

        //Retonra o id do registro
        $('#aluno-grid tbody').on( 'click', 'tr', function () {

            var rows = table.row( this ).data()

            console.log( rows.id );
        } );*/

    </script>
@stop
