@extends('menu')

@section("css")
    <style type="text/css">
        table.dataTable tbody th, table.dataTable tbody td {
            padding: 2px 10px;
        }

        .row_selected {
            background-color: #69aaa6 !important;
            color: #FFF;
            font-weight: bold;
        }
    </style>
@stop


@section('content')

    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <div class="col-sm-6 col-md-9">
                <h4>
                    <i class="material-icons">class</i>
                    Matricular Aluno
                </h4>
            </div>
        </div>
        <div class="ibox-content">
            <div class="row">
                <div class="col-md-12">

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" id="nav-tab" role="tablist">
                        <li role="presentation" class="active" id="li-alunos">
                            <a href="#alunos"  aria-controls="alunos" data-toggle="tab"><i class="fa fa-male"></i>Alunos</a>
                        </li>
                        <li role="presentation" id="li-disciplinas">
                            <a href="#disciplinas"  aria-controls="disciplinas" role="tab" data-toggle="tab"><i class="fa fa-globe"></i>Disciplinas</a>
                        </li>
                        <li role="presentation" id="li-turmas">
                            <a href="#turmas" aria-controls="turmas"  role="tab" data-toggle="tab"><i class="fa fa-globe"></i>Turmas</a>
                        </li>
                    </ul>
                    <!-- End Nav tabs -->

                    <!-- Conteúdo das abas -->
                    <div class="tab-content">

                        <!-- Aba Alunos -->
                        <div role="tabpanel" class="tab-pane active" id="alunos">
                            <br>

                            <div class="table-responsive no-padding">
                                <table id="aluno-grid" class="display table table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Matrícula</th>
                                        <th>Telefones</th>
                                        <th>CPF</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Matrícula</th>
                                        <th>Telefones</th>
                                        <th>CPF</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <!-- Fim Aba Alunos -->

                        <!-- Aba Disciplinas -->
                        <div role="tabpanel" class="tab-pane" id="disciplinas">
                            <br>

                            <h3 id="nomeCurso"></h3>
                            <div class="table-responsive no-padding">
                                <table id="disciplina-grid" class="display table table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Disciplina</th>
                                        <th>Período</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Código</th>
                                        <th>Disciplina</th>
                                        <th>Período</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <!-- Fim Aba Disciplinas -->

                        <!-- Aba Tumas -->
                        <div role="tabpanel" class="tab-pane" id="turmas">
                            <br>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <h3>Disciplinas á adicionar</h3>
                                            <ul id="ztree" class="ztree">
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <h3>Horário do aluno</h3>
                                    <table id="horario-grid" class="display table table-bordered" cellspacing="2" width="100%">
                                        <thead>
                                        <tr>
                                            <th>Hora</th>
                                            <th>Dom</th>
                                            <th>Seg</th>
                                            <th>Ter</th>
                                            <th>Qua</th>
                                            <th>Qui</th>
                                            <th>Sex</th>
                                            <th>Sab</th>
                                        </tr>
                                        </thead>
                                    </table>

                                    <div class="row">
                                        <div class="col-md-4 col-md-offset-8">
                                            <button type="button" class="btn btn-primary" id="btnFinalizarMatricula">Finalizar Matrícula</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Fim Aba Disciplinas -->

                    </div>
                    <!-- Fim Conteúdo das abas -->

                </div>
            </div>
        </div>
    </div>
@stop

@section('javascript')
    <script type="text/javascript" src="{{ asset('/js/graduacao/matricula/aluno.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/graduacao/matricula/disciplina.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/graduacao/matricula/horario.js') }}"></script>
    <script type="text/javascript">
        // Evento para finalizar matrícula
        $(document).on('click', '#btnFinalizarMatricula', function () {
            // Fazendo a requisição ajax
            jQuery.ajax({
                type: 'POST',
                data: {'idAluno' : idAluno},
                url: '/index.php/seracademico/matricula/finalizarMatricula',
                datatype: 'json'
            }).done(function (retorno) {
                if(retorno.success) {
                    swal({
                        title: retorno.msg,
                        text: "Redirecionamento em 2 segundos",
                        timer: 2000,
                        showConfirmButton: false
                    });

                    // Redirecionando
                    window.location.reload();
                    //swal(retorno.msg, "Horaŕios adiciondos com sucesso.", "success");
                    //setTimeout(function(){ window.location.reload(); },1000);
                } else {
                    swal("Ops! Ocorreu um problema!", retorno.msg, "error");
                }
            });
        });
    </script>
@stop