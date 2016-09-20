<!-- Modal principal de disciplinas -->
<div id="modal-curriculo" class="modal fade modal-profile" tabindex="-1" role="dialog" aria-labelledby="modalProfile"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" id="closeModalHistorico" data-dismiss="modal">×</button>
                <h4 class="modal-title"><i class="material-icons">assignment</i> Currículo do Aluno</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Linha de descrição -->
                        <div class="col-md-12 infModal">
                            <div class="col-md-4">
                                <span><strong>Matrícula: </strong><p id="tlMatricula"></p></span>
                            </div>

                            <div class="col-md-4">
                                <span><strong>Nome do Aluno: </strong><p id="tlNomeAluno"></p></span>
                            </div>

                            <div class="col-md-2">
                                <span><strong>Curso: </strong><p id="tlCurso"></p></span>
                            </div>

                            <div class="col-md-2">
                                <span><strong>Período: </strong><p id="tlPeriodo"></p></span>
                            </div>
                        </div>

                        <!-- Links para a navegação -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#acursar" aria-controls="acursar" data-toggle="tab">A Cursar</a>
                            </li>

                            <li role="presentation">
                                <a href="#cursando" aria-controls="cursando" data-toggle="tab">Cursando</a>
                            </li>

                            <li role="presentation">
                                <a href="#cursadas" aria-controls="cursadas" data-toggle="tab">Cursadas</a>
                            </li>

                            <li role="presentation">
                                <a href="#dispensadas" aria-controls="cursadas" data-toggle="tab">Dispensadas</a>
                            </li>

                            <li role="presentation">
                                <a href="#extra" aria-controls="extra" data-toggle="tab">Extra Curriculares</a>
                            </li>

                            <li role="presentation">
                                <a href="#eletiva" aria-controls="eletiva" data-toggle="tab">Eletivas</a>
                            </li>
                        </ul>

                        <!-- Conteúdo de navegação de pastas -->
                        <div class="tab-content">

                            {{--Aba A Cursar --}}
                            <div role="tabpanel" class="tab-pane active" id="acursar">
                                <br/>
                                <!-- Table a cursar -->
                                <table id="grid-acursar" class="display table table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Detalhe</th>
                                            <th>Período</th>
                                            <th>Cod. Disciplina</th>
                                            <th>Disciplina</th>
                                            <th>C. Horária</th>
                                            <th>Créditos</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>

                            <!-- Aba Cursando -->
                            <div role="tabpanel" class="tab-pane" id="cursando">
                                <br/>

                                <!-- Table a Cursando -->
                                <table id="grid-cursando" class="display table table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>Período</th>
                                        <th>Cod. Disciplina</th>
                                        <th>Disciplina</th>
                                        <th>C. Horária</th>
                                        <th>Créditos</th>
                                        <th>Média</th>
                                        <th>Turma</th>
                                        <th>Situação</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>

                            <!-- Aba Cursadas -->
                            <div role="tabpanel" class="tab-pane" id="cursadas">
                                <br/>

                                <!-- Table a cursadas -->
                                <table id="grid-cursadas" class="display table table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Detalhe</th>
                                            <th>Período</th>
                                            <th>Cod. Disciplina</th>
                                            <th>Disciplina</th>
                                            <th>C. Horária</th>
                                            <th>Créditos</th>
                                            <th>Média</th>
                                            <th>Turma</th>
                                            <th>Situação</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>

                            <!-- Aba Dispensadas -->
                            <div role="tabpanel" class="tab-pane" id="dispensadas">
                                <br/>

                                <!-- Adicinar disciplina dispensada-->
                                <a id="btnNewDispensarDisciplina" class="btn-sm btn-primary pull-right">Dispensar Disciplina</a>

                                <!-- Table Dispensadas -->
                                <table id="grid-dispensadas" class="display table table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>Semestre</th>
                                        <th>Cod. Disciplina</th>
                                        <th>Disciplina</th>
                                        <th>Média</th>
                                        <th>C.H.</th>
                                        <th>Créditos</th>
                                        <th>Motivo</th>
                                        <th>Ação</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>

                            <!-- Aba Extra -->
                            <div role="tabpanel" class="tab-pane" id="extra">
                                <br/>

                                <!-- Adicinar disciplina extra curricular-->
                                <a id="btnAddDisciplinaExtraCurricular" class="btn-sm btn-primary pull-right">Adicionar Disciplina</a>

                                <!-- Table a Cursando -->
                                <table id="grid-extras" class="display table table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>Período</th>
                                        <th>Cod. Disciplina</th>
                                        <th>Disciplina</th>
                                        <th>C. Horária</th>
                                        <th>Créditos</th>
                                        <th>Currículo</th>
                                        <th>Ação</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>

                            <!-- Aba Eletiva -->
                            <div role="tabpanel" class="tab-pane" id="eletiva">
                                <br/>

                                <!-- Table Eletivas -->
                                <table id="grid-eletivas" class="display table table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>Período</th>
                                        <th>Cod. Disciplina</th>
                                        <th>Disciplina</th>
                                        <th>C. Horária</th>
                                        <th>Créditos</th>
                                        <th>Currículo</th>
                                        <th>Cod. Eletiva</th>
                                        <th>Curriculo Eletiva</th>
                                        <th>Ação</th>
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