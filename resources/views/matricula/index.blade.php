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
                                    <table id="horario-grid" class="display table table-bordered" cellspacing="0" width="100%">
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
    <script type="text/javascript">
        // Tabela de alunos
        var tableAluno = $('#aluno-grid').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: "{!! route('seracademico.matricula.gridAluno') !!}",
            columns: [
                {data: 'nome', name: 'fac_alunos.nome'},
                {data: 'matricula', name: 'fac_alunos.matricula'},
                {data: 'celular', name: 'fac_alunos.celular'},
                {data: 'cpf', name: 'fac_alunos.cpf'}
            ]
        });

        // id do aluno clicado
        var idAluno;

        // Tabela de disciplinas
        var tableDisciplina;

        // Evento para quando clicar na grid de aluno
        $(document).on('click', '#aluno-grid tbody tr', function () {
            // Aplicando o estilo css
            $(this).parent().find("tr td").removeClass('row_selected');
            $(this).find("td").addClass("row_selected");

            // Recuperando o id do aluno selecionado
            idAluno = tableAluno.row($(this).index()).data().id;

            // Verificando se a tabela já foi carregada
            if(!tableDisciplina) {
                loadTableDisciplina(idAluno);
            } else {
                // Recarregando a tableDisciplina
                tableDisciplina.ajax.url("/index.php/seracademico/matricula/gridDisciplina/" + idAluno).load(function ( data ) {
                    $('#nomeCurso').text(data.data[0].nomeAluno + ' - ' +data.data[0].nomeCurso);
                });
            }

            // Verificando se a tabela já foi carregada
            if(!tableHorario) {
                loadTableHorario(idAluno);
            } else {
                // Recarregando a tableHorario
                tableHorario.ajax.url("/index.php/seracademico/matricula/gridHorario/" + idAluno).load();
            }

            // Tratamento das abas
            $("#nav-tab li").removeClass('active');
            $("#nav-tab li#li-disciplinas").addClass('active');

            $("#turmas").removeClass('active');
            $("#alunos").removeClass('active');
            $("#disciplinas").addClass('active');
        });

        // evento para escolher as disciplinas
        $(document).on('click', '#disciplina-grid tbody tr', function () {
            // Aplicando o estilo css
            if($(this).find("td").hasClass("row_selected")) {
                $(this).find("td").removeClass("row_selected");
            } else {
                $(this).find("td").addClass("row_selected");
            }
        });

        // Função para carregamento do tableDisciplina
        function loadTableDisciplina(idAluno)
        {
            // Carregando a tabela de disciplina
            tableDisciplina = $('#disciplina-grid').on( 'init.dt', function ( e, settings, data ) {
                $('#nomeCurso').text(data.data[0].nomeAluno + ' - ' +data.data[0].nomeCurso);
            }).DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                retrieve: true,
                ajax: "/index.php/seracademico/matricula/gridDisciplina/" + idAluno,
                columns: [
                    {data: 'codigo', name: 'fac_disciplinas.codigo'},
                    {data: 'nome', name: 'fac_disciplinas.nome'},
                    {data: 'periodo', name: 'fac_curriculo_disciplina.nome'}
                ]
            });
        }

        // Evento para quando clicar na tr da table de disciplinas
        $(document).on('click', '#disciplina-grid tbody tr', function () {
            // Array que armazenará os ids das disciplinas
            var arrayId   = [];

            // Varrendo as linhas
            $("#disciplina-grid tbody tr td.row_selected").parent().each(function (index, value) {
                arrayId[index] = tableDisciplina.row($(value).index()).data().id;
            });

            // Fazendo a requisição ajax
            jQuery.ajax({
                type: 'POST',
                data: {"dados" : arrayId},
                url: '/index.php/seracademico/matricula/getTurmas',
                datatype: 'json'
            }).done(function (retorno) {// validado as disciplinas do currículo
                // Verificando o retorno da requisição
                if(retorno.success) {
                    // Variável que armazenará o objeto tree e os nós
                    var zTreeObj, zNodes = [];

                    // Variável que armazenará as Configurações
                    var setting = {
                        callback: {
                            beforeCollapse: beforeCollapse,
                            onDblClick: onDblClick
                        }
                    };

                    // Criando os nós
                    $.each(retorno.dados, function (index, value) {
                        // Variável que armazenará as turmas
                        var turmas  =[];

                        $.each(value.turmas, function (index1, value1) {
                            // Variável que armazenará os horários
                            var horarios = [];

                            // Carregando os horários
                            $.each(value1.horarios, function (index2, value2) {
                                horarios[index2] = {
                                    name: value2.nomeDia + " - " + value2.codigoHora + " : " + value2.hora_inicial + " ás " + value2.hora_final,
                                    icon: "{{ asset('/img/plugins/zTree/diy/3.png') }}"
                                };
                            });

                            // Criando o nó da turma e adicionando à arvore
                            turmas[index1] = {
                                id : value1.idTurmaDisciplina,
                                name : value1.codigoTurma + " - " + value1.nomeTurma,
                                open:true,
                                collapse:false,
                                icon:"{{ asset('/img/plugins/zTree/diy/6.png') }}",
                                children: horarios
                            };
                        });

                        // Criando o nó pricipal (Disciplina)
                        zNodes[index] = {
                            name : value.codigoDisciplina + " - " +value.nomeDisciplina,
                            open:true,
                            collapse:false,
                            icon:"{{ asset('/img/plugins/zTree/diy/2.png') }}",
                            children: turmas
                        };
                    });

                    // Criando a árvore e recuperando o objeto ztree
                    zTreeObj = $.fn.zTree.init($("#ztree"), setting, zNodes);
                } else {
                    // Retorno caso não tenha currículo em uma turma ou algum erro
                    swal(retorno.msg, "Click no botão abaixo!", "error");
                }
            });
        });

        // Função para o collapase
        function beforeCollapse(treeId, treeNode) {
            return (treeNode.collapse !== false);
        }

        // Evento para adicionar horário ao aluno
        function onDblClick(event, treeId, treeNode) {
            if(treeNode.id && idAluno) {
                swal({
                    title: "Deseja realmente adicionar esses horários ?",
                    text: "",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Sim, desejo adicionar!",
                    closeOnConfirm: false
                },
                function(){
                    // Array de envio ajax
                    var dados = {
                        'idAluno' : idAluno,
                        'idTurmaDisciplina' : treeNode.id
                    };

                    // Fazendo a requisição ajax
                    jQuery.ajax({
                        type: 'POST',
                        data: dados,
                        url: '/index.php/seracademico/matricula/adicionarHorarioAluno',
                        datatype: 'json'
                    }).done(function (retorno) {
                        if(retorno.success) {
                            tableHorario.ajax.reload();
                            swal("Adicionado!", "Horaŕios adiciondos com sucesso.", "success");
                        } else {
                            swal("Ops! Ocorreu um problema!", retorno.msg, "error");
                        }
                    });

                });
            }
        }

        // Variável que armazenará a table de horário
        var tableHorario;

        // Função para carregar a grid
        function loadTableHorario (idAluno) {
            tableHorario = $('#horario-grid').DataTable({
                processing: true,
                serverSide: true,
                retrieve: true,
                iDisplayLength: 5,
                bLengthChange: false,
                bFilter: false,
                bPaginate: false,
                ajax: "/index.php/seracademico/matricula/gridHorario/" + idAluno,
                columns: [
                    {data: 'codigoHora', name: 'fac_horas.nome', orderable: false, searchable: false},
                    {data: 'domingo', name: 'domingo', orderable: false, searchable: false},
                    {data: 'segunda', name: 'segunda', orderable: false, searchable: false},
                    {data: 'terca', name: 'terca', orderable: false, searchable: false},
                    {data: 'quarta', name: 'quarta', orderable: false, searchable: false},
                    {data: 'quinta', name: 'quinta', orderable: false, searchable: false},
                    {data: 'sexta', name: 'sexta', orderable: false, searchable: false},
                    {data: 'sabado', name: 'sabado', orderable: false, searchable: false}
                ]
            });

            //Retorno
            return tableHorario;
        }
    </script>
@stop