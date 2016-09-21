<!-- Modal principal de disciplinas -->
<div id="modal-disciplina-edit" class="modal fade modal-profile" tabindex="-1" role="dialog" aria-labelledby="modalProfile" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 30%;">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title">Editar disciplina</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <div class="row">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="disciplina_editar_id">Disciplina</label>
                                <select name="disciplina_editar_id" class="form-control" id="disciplina_editar_id">
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="eletiva_editar">Eletiva para outros cursos ?</label>
                                <select name="eletiva_editar" class="form-control" id="eletiva_editar">
                                    <option value="0">Não</option>
                                    <option value="1">Sim</option>
                                </select>
                            </div>
                        </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="btnUpdateDisciplinaTurma">Salvar</button>
                <button class="btn btn-default" data-dismiss="modal" id="btnCancelarDisciplinaTurma">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- FIM Modal de cadastro das Disciplinas-->