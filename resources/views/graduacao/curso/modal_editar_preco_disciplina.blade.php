<!-- Modal principal de disciplinas -->
<div id="modal-editar-preco-disciplina" class="modal fade modal-profile" tabindex="-1" role="dialog" aria-labelledby="modalProfile"
     aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title">Edição de preço por disciplinas</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <input type="hidden" id="idPrecoDisciplina">
                <div class="row">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="qtd_disciplinas_editar">Qtd. Disciplinas</label>
                            <input type="text" name="qtd_disciplinas_editar" class="form-control" id="qtd_disciplinas_editar" placeholder="Qtd.Disciplinas">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="preco_editar">Preço</label>
                            <input type="text" name="preco_editar" class="form-control" id="preco_editar" placeholder="Preço">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="btnUpdatePrecoDisciplina">Salvar</button>
                <button class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
</div>
<!-- FIM Modal de cadastro das Disciplinas-->