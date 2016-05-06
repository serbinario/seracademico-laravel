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
                                <th>Nome</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($resultado->items() as $f)
                                <tr>
                                    <td>{{ $f->titulo }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Nome</th>
                            </tr>
                            </tfoot>
                        </table>
                        <section id="pagination">
                            {!!  $resultado->render() !!}
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('javascript')
@stop