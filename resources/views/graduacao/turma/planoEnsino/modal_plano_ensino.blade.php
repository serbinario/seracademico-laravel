<!-- Modal principal de disciplinas -->
<div id="modal-plano-ensino" class="modal fade modal-profile" role="dialog" aria-labelledby="modalProfile" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 90%;">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title"><i class="fa fa-calendar" aria-hidden="true"></i> Gerenciamento dos planos de ensino</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <!-- Linha de descrição -->
                <div class="col-md-12 infModal">
                    <div class="col-md-2">
                        <span><strong>Turma: </strong><p id="peTurma"></p></span>
                    </div>

                    <div class="col-md-2">
                        <span><strong>Período: </strong><p id="pePeriodo"></p></span>
                    </div>

                    <div class="col-md-2">
                        <span><strong>Currículo: </strong><p id="peCurriculo"></p></span>
                    </div>

                    <div class="col-md-4">
                        <span><strong>Curso: </strong><p id="peCurso"></p></span>
                    </div>

                    <div class="col-md-2">
                        <span><strong>Semestre: </strong><p id="peSemestre"></p></span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-7">
                        <h3>Disciplinas</h3>
                        <hr class="hr-dashline">

                        <table id="plano-ensino-disciplina-grid" class="display table table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Código</th>
                                <th>Disciplina</th>
                                <th>Plano Ensino</th>
                            </tr>
                            </thead>
                        </table>
                    </div>

                    <div class="col-md-5 form-group">
                        <h3>Planos de Ensino</h3>
                        <hr class="hr-dashline">

                        <form class="form-inline">
                            <div class="form-group">
                                <select type="text" class="form-control" id="planoEnsino">
                                    <option value="">Selecione um plano de ensino</option>
                                </select>
                            </div>
                            <button type="button" id="addPlanoEnsino" class="btn btn-primary">Adicionar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- FIM Modal de cadastro das Disciplinas-->