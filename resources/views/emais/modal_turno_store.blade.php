    <!-- Modal de cadastro das Disciplinas-->
    <div  id="modal-turno-store" class="modal fade modal-profile" role="dialog" aria-labelledby="modalProfile" aria-hidden="true">
        <div class="modal-dialog modal-lg"  style="width: 20%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" type="button" data-dismiss="modal">×</button>
                    <h4 class="modal-title">Adicionar turno ao curso</h4>
                </div>
                <div class="modal-body" style="alignment-baseline: central">
                    <div class="row">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="turno_id">Turno</label>
                                    <select name="turno_id" class="form-control" id="turno_id">
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="quantidade">Qtd. Vagas</label>
                                    <input type="text" class="form-control" name="quantidade" id="quantidade">
                                </div>
                            </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" id="btnSalvarCursoTurno">Salvar</button>
                    <button class="btn btn-default" data-dismiss="modal" id="btnCancelarCursoTurno">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- FIM Modal de cadastro das Disciplinas-->