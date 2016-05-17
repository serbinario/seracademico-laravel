<!-- Modal principal de disciplinas -->
<div id="modal-disciplina-store" class="modal fade modal-profile" tabindex="-1" role="dialog" aria-labelledby="modalProfile" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 30%;">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title">Inclusão de disciplinas</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <div class="row">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="disciplina_id">Disciplina</label>
                                <select name="disciplina_id" class="form-control" id="disciplina_id">
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="eletiva_id">Eletiva</label>
                                <select name="eletiva_id" class="form-control" id="eletiva_id">
                                </select>
                            </div>
                        </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="btnSalvarDisciplinaTurma">Salvar</button>
                <button class="btn btn-default" data-dismiss="modal" id="btnCancelarDisciplinaTurma">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- FIM Modal de cadastro das Disciplinas-->