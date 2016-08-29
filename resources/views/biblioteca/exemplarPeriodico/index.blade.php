@extends('menu')

@section('content')

    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <div class="col-sm-6 col-md-9">
                <h4><i class="material-icons">receipt</i> Listar Exemplares Periódicos</h4>
            </div>
            <div class="col-sm-6 col-md-3">
                <a href="{{ route('seracademico.biblioteca.createExemplarP')}}" class="btn-sm btn-primary pull-right">Novo Exemplar Periódico</a>
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
                        <table id="sala-grid" class="display table table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Acervo - Título</th>
                                <th>Número do Periódico</th>
                                <th>Situação</th>
                                <th>Tombo</th>
                                <th>Link de acesso</th>
                                <th >Acão</th>
                            </tr>
                            </thead>

                            <tfoot>
                            <tr>
                                <th>Acervo - Título</th>
                                <th>Número do Periódico</th>
                                <th>Situação</th>
                                <th>Tombo</th>
                                <th>Link de acesso</th>
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
            ajax: "{!! route('seracademico.biblioteca.gridExemplarP') !!}",
            columns: [
                {data: 'titulo', name: 'bib_arcevos.titulo'},
                {data: 'edicao', name: 'bib_exemplares.edicao'},
                {data: 'nome_sit', name: 'bib_emprestimo.nome'},
                {data: 'tombo', name: 'bib_exemplares.codigo'},
                {data: 'link', name: 'link', orderable: false, searchable: false},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

        $(document).on('click', 'a.excluir', function (event) {
            event.preventDefault();
            var url = $(this).attr('href');
            bootbox.confirm("Tem certeza da exclusão do item?", function (result) {
                if (result) {
                    location.href = url
                } else {
                    false;
                }
            });
        });
    </script>
@stop