<!-- Modal principal de disciplinas -->
<div id="modal-semestre" class="modal fade modal-profile" tabindex="-1" role="dialog" aria-labelledby="modalProfile"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" id="closeModalHistorico" data-dismiss="modal">×</button>
                <h4 class="modal-title"><i class="material-icons">date_range</i> Semestre do Aluno</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Linha de descrição -->
                        <div class="col-md-12 infModal">
                            <div class="col-md-4">
                                <span><strong>Matrícula: </strong><p id="tlSMatricula"></p></span>
                            </div>

                            <div class="col-md-4">
                                <span><strong>Nome do Aluno: </strong><p id="tlSNomeAluno"></p></span>
                            </div>

                            <div class="col-md-2">
                                <span><strong>Curso: </strong><p id="tlSCurso"></p></span>
                            </div>

                            <div class="col-md-2">
                                <span><strong>Período: </strong><p id="tlSPeriodo"></p></span>
                            </div>
                        </div>

                        <!-- Links para a navegação -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#horario" aria-controls="acursar" data-toggle="tab">Horário</a>
                            </li>
                            <li role="presentation">
                                <a href="#notas" aria-controls="notas" data-toggle="tab">Notas</a>
                            </li>

                            <li role="presentation">
                                <a href="#faltas" aria-controls="faltas" data-toggle="tab">Faltas</a>
                            </li>

                            <li role="presentation">
                                <a href="#gerenciardisciplinas" aria-controls="faltas" data-toggle="tab">Gerenciar Disciplinas</a>
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
                                        <th>Disciplina</th>
                                        <th width="8%">1º Unid.</th>
                                        <th width="8%">2º Unid.</th>
                                        <th width="8%">2º Chamada</th>
                                        <th width="8%">Final</th>
                                        <th width="8%">Média</th>
                                        <th width="8%">Faltas</th>
                                        <th width="8%">Situação</th>
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
                                        <th>Disciplina</th>
                                        <th width="8%">1º Mês.</th>
                                        <th width="8%">2º Mês</th>
                                        <th width="8%">3º Mês</th>
                                        <th width="8%">4º Mês</th>
                                        <th width="8%">5º Mês</th>
                                        <th width="8%">6º Mês</th>
                                        <th width="8%">Total Faltas</th>
                                        <th width="8%">Situação</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                            <!-- Fim Aba faltas -->

                            <!-- Aba Gerenciar Disciplinas -->
                            <div role="tabpanel" class="tab-pane" id="gerenciardisciplinas">
                                <br/>
                                <div class="row">
                                    <div class="col-md-12">

                                        <!-- Nav tabs -->
                                        <ul class="nav nav-tabs" id="nav-tab" role="tablist">
                                            <li role="presentation" class="active">
                                                <a href="#disciplinas"  aria-controls="disciplinas" role="tab" data-toggle="tab">Disciplinas</a>
                                            </li>
                                            <li role="presentation">
                                                <a href="#turmas" aria-controls="turmas"  role="tab" data-toggle="tab">Turmas</a>
                                            </li>
                                        </ul>
                                        <!-- End Nav tabs -->

                                        <!-- Conteúdo das abas -->
                                        <div class="tab-content">

                                            <!-- Aba Disciplinas -->
                                            <div role="tabpanel" class="tab-pane active" id="disciplinas">
                                                <br>
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
                                                                <ul id="gerenciamento-disciplina-ztree" class="ztree">
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <h3>Horário do aluno</h3>
                                                        <table id="gerenciardisciplinas-horario-grid" class="display table table-bordered" cellspacing="2" width="100%">
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
                                                            <div class="col-md-8 col-md-offset-4 form-group">
                                                                <label for="serachDisciplina"></label>
                                                                <div class="input-group">
                                                                    <select class="form-control" id="selRemoverHorario">
                                                                        <option value="">Selecione um discilina</option>
                                                                    </select>
                                                                    <span class="input-group-btn">
                                                                        <a id="btnRemoverHorario" class="btn-sm btn-primary">Remover</a>
                                                                    </span>
                                                                </div>
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
                            <!-- Fim Gerenciar Disciplinas -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- FIM Modal de cadastro das Disciplinas-->