@extends('menu')

@section('content')
    <div class="ibox float-e-margins">

        <div class="ibox-title">
            <div class="col-sm-6 col-md-9">
                <h4><i class="fa fa-users"></i>Listar Cursos</h4>
            </div>
            <div class="col-sm-6 col-md-3">
                <a href="{{ route('seracademico.posgraduacao.curso.create')}}" class="btn-sm btn-primary pull-right">Novo Curso</a>
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
                                <th>Código</th>
                                <th>Nome</th>
                                <th>Tipo do Curso</th>
                                <th>Ativo</th>
                                <th >Acão</th>
                            </tr>
                            </thead>

                            <tfoot>
                            <tr>
                                <th>Código</th>
                                <th>Nome</th>
                                <th>Tipo do Curso</th>
                                <th>Ativo</th>
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
            autoWidth: false,
            ajax: "{!! route('seracademico.posgraduacao.curso.grid') !!}",
            columns: [
                {data: 'codigo', name: 'fac_cursos.codigo'},
                {data: 'nome', name: 'fac_cursos.nome'},
                {data: 'tipocurso', name: 'fac_tipo_cursos.nome'},
                {data: 'ativo', name: 'fac_cursos.ativo'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    </script>
@stop