<!-- Modal principal de disciplinas -->
<div id="modal-create-disciplina-eletiva" class="modal fade modal-profile" tabindex="-1" role="dialog" aria-labelledby="modalProfile" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title">Adicionar Eletiva</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <div class="row">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="turma_disciplina_id">Disciplina Eletiva</label>
                            <select name="turma_disciplina_id" class="form-control" id="turma_disciplina_id">
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="btnSaveDisciplinaEletiva">Salvar</button>
                <button class="btn btn-default" data-dismiss="modal" id="btnCancelDisciplinaEletiva">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- FIM Modal de cadastro das Disciplinas-->