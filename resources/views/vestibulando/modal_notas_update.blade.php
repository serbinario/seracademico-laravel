<!-- Modal principal de disciplinas -->
<div id="modal-nota-update" class="modal fade modal-profile" tabindex="-1" role="dialog" aria-labelledby="modalProfile" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title">Adicionar nota</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="codigo">Código</label>
                                <input type="text" class="form-control" name="codigo" id="codigo">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="materia">Matéria</label>
                                <input type="text" class="form-control" name="materia" id="materia">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="acertos">Acertos</label>
                                <input type="text" class="form-control" name="acertos" id="acertos">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="pontuacao">Pontuação</label>
                                <input type="text" class="form-control" name="pontuacao" id="pontuacao">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="btnUpdateNotas">Salvar</button>
                <button class="btn btn-default" data-dismiss="modal" id="btnCancelarNotas">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- FIM Modal de cadastro das Disciplinas-->