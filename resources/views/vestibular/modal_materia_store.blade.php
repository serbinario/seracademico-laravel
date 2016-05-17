    <!-- Modal de cadastro das Disciplinas-->
    <div  id="modal-materia-store" class="modal fade modal-profile" role="dialog" aria-labelledby="modalProfile" aria-hidden="true">
        <div class="modal-dialog modal-lg"  style="width: 25%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" type="button" data-dismiss="modal">×</button>
                    <h4 class="modal-title">Adicionar matéria ao curso</h4>
                </div>
                <div class="modal-body" style="alignment-baseline: central">
                    <div class="row">
                            <div class="row">
                                <div class="form-group col-md-8">
                                    <label for="materia_id">Matéria</label>
                                    <select name="materia_id" class="form-control" id="materia_id">
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="peso">Peso</label>
                                    <input type="text" class="form-control" name="peso" id="peso">
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="qtd_questoes">Qtd. Questões</label>
                                    <input type="text" class="form-control" name="qtd_questoes" id="qtd_questoes">
                                </div>
                            </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" id="btnSalvarCursoMateria">Salvar</button>
                    <button class="btn btn-default" data-dismiss="modal" id="btnCancelarCursoMateria">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- FIM Modal de cadastro das Disciplinas-->