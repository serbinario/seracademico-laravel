<!-- Modal principal de disciplinas -->
<div id="modal-historico" class="modal fade modal-profile" tabindex="-1" role="dialog" aria-labelledby="modalProfile"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" id="closeModalHistorico" data-dismiss="modal">×</button>
                <h4 class="modal-title">Histórico do Aluno</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <div class="row">
                    <div class="row">
                        <div class="col-md-4">
                            <h3 id="tlHMatricula"></h3>
                        </div>

                        <div class="col-md-4">
                            <h3 id="tlHNomeAluno"></h3>
                        </div>

                        <div class="col-md-2">
                            <h3 id="tlHCurso"></h3>
                        </div>

                        <div class="col-md-2">
                            <h3 id="tlHPeriodo"></h3>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <button href="#" id="btnAddHistorico" class="btn-sm btn-primary pull-right">Novo Histórico</button><br><br>
                        <table id="grid-historico" class="display table table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Semestre</th>
                                <th>Curso</th>
                                <th>Currículo</th>
                                {{--<th>Cod. Situação</th>--}}
                                <th>Situação</th>
                                <th>Período</th>
                                {{--<th>Cod. Turma</th>--}}
                                <th style="width: 12%">Ação</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <button href="#" id="btnAddSituacao" class="btn-sm btn-primary pull-right">Nova Situação</button><br><br>
                        <table id="grid-situacao" class="display table table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Sequência</th>
                                <th>Data</th>
                                {{--<th>Cod. Situação</th>--}}
                                <th>Situação</th>
                                <th>Curso Origem</th>
                                <th>Curso Destino</th>
                                <th>Observação</th>
                                <th  style="width: 12%">Ação</th>
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