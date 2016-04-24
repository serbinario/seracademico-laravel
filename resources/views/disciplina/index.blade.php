@extends('menu')

@section('content')

    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <div class="col-sm-6 col-md-9">
                <h4>
                    <i class="fa fa-users"></i>
                    Listar disciplinas
                </h4>
            </div>
            <div class="col-sm-6 col-md-3">
                <a href="{{ route('seracademico.posgraduacao.disciplina.create')}}" class="btn-sm btn-primary pull-right">Nova Disciplina</a>
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
                        <table id="disciplina-grid" class="display table table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Código</th>
                                <th>Nome</th>
                                <th>Tipo da disciplina</th>
                                <th>Carga Horaria</th>
                                {{--<th>Tipo de avaliação</th>--}}
                                <th style="width: 5%;">Acão</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Código</th>
                                <th>Nome</th>
                                <th>Tipo da disciplina</th>
                                <th>Carga Horaria</th>
                                {{--<th>Tipo de avaliação</th>--}}
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
        var table = $('#disciplina-grid').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: "{!! route('seracademico.posgraduacao.disciplina.grid') !!}",
            columns: [
                {data: 'codigo', name: 'fac_disciplinas.codigo'},
                {data: 'nome', name: 'fac_disciplinas.nome'},
                {data: 'tipo_disciplina', name: 'fac_tipo_disciplinas.nome'},
                {data: 'carga_horaria', name: 'fac_disciplinas.carga_horaria'},
                /*{data: 'tipo_avaliacao', name: 'fac_tipo_avaliacoes.nome'},*/
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    </script>
@stop