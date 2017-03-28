<!-- Modal principal de disciplinas -->
<div id="modal-add-aluno" class="modal fade modal-profile" role="dialog" aria-labelledby="modalProfile"
     aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title">Adicionar aluno (Reposição de Aula)</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="turma_disciplina_id">Disciplina</label>
                                <select name="turma_disciplina_id" class="form-control" id="turma_disciplina_id">
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="add_aluno_curso">Curso</label>
                                <select name="add_aluno_curso" class="form-control" id="add_aluno_curso">
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="turma_aluno_id">Aluno</label>
                                <select name="turma_aluno_id" class="form-control" id="turma_aluno_id">
                                </select>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="btnSaveAddAluno">Salvar</button>
                <button class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- FIM Modal de cadastro das Disciplinas-->

