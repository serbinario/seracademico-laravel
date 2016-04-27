@extends('menu')

@section('content')

    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <div class="col-sm-6 col-md-9">
                <h4><i class="material-icons">find_in_page</i> Listar Acervos</h4>
            </div>
            <div class="col-sm-6 col-md-3">
                <a href="{{ route('seracademico.biblioteca.createAcervo')}}" class="btn-sm btn-primary pull-right">Novo Acervo</a>
            </div>
        </div>
        <div class="ibox-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive no-padding">
                        <table id="sala-grid" class="display table table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Título</th>
                                <th>Subtítulo</th>
                                <th >Acão</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Título</th>
                                <th>Subtítulo</th>
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
        var table = $('#sala-grid').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{!! route('seracademico.biblioteca.gridAcervo') !!}",
            columns: [
                {data: 'titulo', name: 'titulo'},
                {data: 'subtitulo', name: 'subtitulo'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    </script>
@stop