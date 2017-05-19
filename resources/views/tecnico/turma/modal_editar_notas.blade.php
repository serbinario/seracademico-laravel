<!-- Modal principal de disciplinas -->
<div id="modal-editar-notas" class="modal fade modal-profile" tabindex="-1" role="dialog" aria-labelledby="modalProfile" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 30%;">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title">Editar Notas do Aluno</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="nomePessoa">Nome </label>
                                <input type="text" name="nomePessoa" class="form-control" id="nomePessoa">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="nota_final">Nota Final </label>
                                <input type="text" name="nota_final" class="form-control" id="nota_final">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="situacao_id_editar">Situação</label>
                                <select name="situacao_id_editar" class="form-control" id="situacao_id_editar">
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="btnUpdateNotas">Salvar</button>
                <button class="btn btn-default" data-dismiss="modal" id="btnCancelNotas">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- FIM Modal de cadastro das Disciplinas-->