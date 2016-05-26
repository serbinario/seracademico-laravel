@extends('menu')

@section('content')

    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <div class="col-sm-6 col-md-9">
                <h4>
                    <i class="material-icons">class</i>
                    Listar Configurações
                </h4>
            </div>
            <div class="col-sm-6 col-md-3">
                <a href="{{ route('seracademico.parametro.create')}}" class="btn-sm btn-primary pull-right">Novo Parametro</a>
            </div>
        </div>
        <div class="ibox-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive no-padding">
                        <table id="parametro-grid" class="display table table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Nome</th>
                                <th >Acão</th>
                            </tr>
                            </thead>

                            <tfoot>
                            <tr>
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

    <!-- Modais -->
    @include('parametro.modal_itens')
@stop

@section('javascript')
    <script type="text/javascript" src="{{ asset('/js/parametro/modal_itens.js') }}"></script>
    <script type="text/javascript">
        var table = $('#parametro-grid').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{!! route('seracademico.parametro.grid') !!}",
            columns: [
                {data: 'nome', name: 'nome'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

        // variável que armazenará o id de parâmetro
        var idParametro;
        var nomeParametro;

        // evento para o click de btnItensParametros
        $(document).on('click', '#btnItensParametros', function () {
            // reuperando o id do parêmetro
            idParametro   = table.row($(this).parent().parent().parent().parent().parent()).data().id;
            nomeParametro =table.row($(this).parent().parent().parent().parent().parent()).data().nome;

            // Colocando o nome do parametro no título
            $("#tituloParametro").text("Parâmetro: " + nomeParametro);

            // executando o modal
            runTableItens(idParametro);
        });
    </script>
@stop