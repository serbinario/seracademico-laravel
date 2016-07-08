<!-- Modal principal de disciplinas -->
<div id="modal-curriculo" class="modal fade modal-profile" tabindex="-1" role="dialog" aria-labelledby="modalProfile"
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
                                <h3 id="tlMatricula"></h3>
                            </div>

                            <div class="col-md-6 col-xs-2">
                                <h3 id="tlNomeAluno"></h3>
                            </div>
                        </div>

                        <!-- Links para a navegação -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#acursar" aria-controls="acursar" data-toggle="tab"><i class="material-icons">collections_time</i> A Cursar</a>
                            </li>
                            <li role="presentation">
                                <a href="#cursadas" aria-controls="cursadas" data-toggle="tab"><i class="material-icons">collections_time</i> Cursadas</a>
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
                                            <th>Período</th>
                                            <th>Cod. Disciplina</th>
                                            <th>Disciplina</th>
                                            <th>C. Horária</th>
                                            <th>Créditos</th>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- FIM Modal de cadastro das Disciplinas-->