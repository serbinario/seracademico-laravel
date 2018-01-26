@extends('menu')

@section('css')
    <style type="text/css">
        .select2-container {
            width: 100% !important;
            padding: 0;
        }

        .select2-close-mask{
            z-index: 2099;
        }

        .select2-dropdown{
            z-index: 3051;
        }

        /*#disciplina-grid tbody tr{*/
            /*font-size: 10px;*/
        /*}*/

        td.details-control {
            background: url("{{asset("imagemgrid/icone-produto-plus.png")}}") no-repeat center center;
            cursor: pointer;
        }

        tr.details td.details-control {
            background: url("{{asset("imagemgrid/icone-produto-minus.png")}}") no-repeat center center;
        }

        table.dataTable tbody th, table.dataTable tbody td {
            padding: 2px 10px;
        }
    </style>
@stop

@section('content')
    <div class="ibox float-e-margins">

        <div class="ibox-title">
            <div class="col-sm-6 col-md-9">
                <h4><i class="material-icons">library_books</i> Listar Modulos</h4>
            </div>
            <div class="col-sm-6 col-md-3">
                <a href="{{ route('seracademico.tecnico.modulo.create')}}" class="btn-sm btn-primary pull-right">Novo Modulo</a>
            </div>
        </div>

        <div class="ibox-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive no-padding">
                        <table id="modulo-grid" class="display table table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Código</th>
                                <th>Nome</th>
                                <th>Acão</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Código</th>
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

@include('tecnico.modulo.modal_adicionar_material')

@section('javascript')
    <script type="text/javascript">
        /*Datatable da grid principal*/
        var table = $('#modulo-grid').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: "{!! route('seracademico.tecnico.modulo.grid') !!}",
            columns: [
                {data: 'codigo', name: 'tec_modulos.codigo'},
                {data: 'nome', name: 'tec_modulos.nome'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

        //Variável que armazenará o id do módulo
        var idModulo = 0;
        var table2;

        /*Responsável em abrir modal*/
        $(document).on("click", '.grid-materiais', function () {
            $("#modal-material").modal({show: true, keyboard: true});
            idModulo = table.row($(this).parents('tr').index()).data().id;

            /*Datatable da grid Modal*/
            table2 = $('#material-grid').DataTable({
                retrieve: true,
                processing: true,
                serverSide: true,
                iDisplayLength: 5,
                bLengthChange: false,
                ajax: "/seracademico/tecnico/modulo/gridByModulo/" + idModulo,
                columns: [
                    {data: 'nome', name: 'nome'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });

            //Carregando a datatable
            table2.ajax.url("/seracademico/tecnico/modulo/gridByModulo/" + idModulo).load();
        });

        // Pega o arquivo a ser feito upload
        var formData = new FormData();
        $('#file').change(function (event) {
            //formData  = new FormData();
            formData.append('file', event.target.files[0]); // para apenas 1 arquivo
            //var name = event.target.files[0].content.name; // para capturar o nome do arquivo com sua extenção
        });

        //Evento do click no botão adicionar disciplina
        $(document).on('click', '#addMaterial', function (event) {

            var nome  = $('#nome').val();

            // Verificando preenchimento dos campos disciplina e modulo
            if (!nome) {
                sweetAlert("Oops...", "Há campos obrigatórios que não foram preenchidos", "error");
                return false;
            }

            //Setando os valores para envio do fomulario
            formData.append('nome', nome);
            formData.append('modulo_id', idModulo);

            jQuery.ajax({
                type: 'POST',
                url: '{{ route('seracademico.tecnico.modulo.adicionarMateriais')  }}',
                data: formData,
                datatype: 'json',
                processData: false,
                contentType: false
            }).done(function (json) {
                if(json['msg']) {
                    swal("Material(s) adicionado(s) com sucesso!", "Click no botão abaixo!", "success");
                } else {
                    swal(json['msg'], "Click no botão abaixo!", "success");
                }

                table2.ajax.reload();

                $('#nome').val("");
                $('#file').val("");
            });
        });

        //Evento de remover o telefone
        $(document).on('click', '.removerMaterial', function (event) {

            event.preventDefault();

            var idMaterial = table2.row($(this).parents('tr').index()).data().id;

            // Requisição Ajax
            jQuery.ajax({
                type: 'GET',
                url: "/seracademico/tecnico/modulo/removerMateriais/" + idMaterial,
                datatype: 'json'
            }).done(function (json) {
                if(json['msg']) {
                    swal("Material removido com sucesso!", "Click no botão abaixo!", "success");
                } else {
                    swal(json['msg'], "Click no botão abaixo!", "success");
                }

                table2.ajax.reload();
            });
        });

        //Evento de remover o telefone
        $(document).on('click', '.downloadFile', function (event) {

            event.preventDefault();

            var path = table2.row($(this).parents('tr').index()).data().path;

            var caminho = "{{ asset('uploads/tecnico/modulos/materiais') }}" + "/" + path;

            window.open(caminho);
        });
    </script>
@stop