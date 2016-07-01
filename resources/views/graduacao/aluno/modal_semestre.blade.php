<!-- Modal principal de disciplinas -->
<div id="modal-semestre" class="modal fade modal-profile" tabindex="-1" role="dialog" aria-labelledby="modalProfile"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" id="closeModalHistorico" data-dismiss="modal">×</button>
                <h4 class="modal-title">Currículo do Aluno</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Linha de descrição -->
                        <div class="row">
                            <div class="col-md-4">
                                <h3 id="sTlMatricula"></h3>
                            </div>

                            <div class="col-md-6 col-xs-2">
                                <h3 id="sTlNomeAluno"></h3>
                            </div>
                        </div>

                        <!-- Links para a navegação -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#horario" aria-controls="acursar" data-toggle="tab"><i class="material-icons">collections_time</i> Horário</a>
                            </li>
                            <li role="presentation">
                                <a href="#notas" aria-controls="notas" data-toggle="tab"><i class="material-icons">collections_time</i> Notas</a>
                            </li>

                            <li role="presentation">
                                <a href="#faltas" aria-controls="faltas" data-toggle="tab"><i class="material-icons">collections_time</i> Faltas</a>
                            </li>
                        </ul>

                        <!-- Conteúdo de navegação de pastas -->
                        <div class="tab-content">

                            {{--Aba A Horário --}}
                            <div role="tabpanel" class="tab-pane active" id="horario">
                                <br/>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="panel panel-default">
                                            <div class="panel-body">
                                                <ul id="ztree" class="ztree"></ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <!-- Tabela de horário -->
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
                                    </div>
                                </div>
                            </div>

                            <!-- Aba Notas -->
                            <div role="tabpanel" class="tab-pane" id="notas">
                                <br/>
                                <!-- Tabela de notas -->
                                <table id="semestre-notas-grid" class="display table table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th style="width: 100%">Disciplina</th>
                                        <th>1º Unid.</th>
                                        <th>2º Unid.</th>
                                        <th>2º Chamada</th>
                                        <th>Final</th>
                                        <th>Média</th>
                                        <th>Faltas</th>
                                        <th>Situação</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>

                            <!-- Aba Faltas -->
                            <div role="tabpanel" class="tab-pane" id="faltas">
                                <br/>
                                <!-- Tabela de faltas -->
                                <table id="semestre-faltas-grid" class="display table table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th style="width: 100%">Disciplina</th>
                                        <th>1º Mês.</th>
                                        <th>2º Mês</th>
                                        <th>3º Mês</th>
                                        <th>4º Mês</th>
                                        <th>5º Mês</th>
                                        <th>6º Mês</th>
                                        <th>Total Faltas</th>
                                        <th>Situação</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- FIM Modal de cadastro das Disciplinas-->