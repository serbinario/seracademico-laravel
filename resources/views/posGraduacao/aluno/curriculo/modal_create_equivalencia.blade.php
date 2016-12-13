<!-- Modal principal de disciplinas -->
<div id="modal-create-equivalencia" class="modal fade modal-profile" tabindex="-1" role="dialog" aria-labelledby="modalProfile" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title">Adicionar Disciplina</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <div class="row">
                <div class="row">
                        <div class="form-group col-md-12">
                            <label for="equivalencia_disciplina_id">Disciplina</label>
                            <select name="equivalencia_disciplina_id" class="form-control" id="equivalencia_disciplina_id">
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="curriculo_equivalencia_id">Currículo Equivalência</label>
                            <select name="curriculo_equivalencia_id" class="form-control" id="curriculo_equivalencia_id">
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="disciplina_equivalencia_id">Disciplina Equivalente</label>
                            <select name="disciplina_equivalencia_id" class="form-control" id="disciplina_equivalencia_id">
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="btnSaveEquivalencia">Salvar</button>
                <button class="btn btn-default" data-dismiss="modal" id="btnCancelEquivalencia">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- FIM Modal de cadastro das Disciplinas-->