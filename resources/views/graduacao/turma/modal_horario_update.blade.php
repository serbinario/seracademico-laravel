    <!-- Modal de cadastro das Disciplinas-->
    <div  id="modal-horario-update" class="modal fade modal-profile" role="dialog" aria-labelledby="modalProfile" aria-hidden="true">
        <div class="modal-dialog" style="width: 30%">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" type="button" data-dismiss="modal">×</button>
                    <h4 class="modal-title">Editar horário</h4>
                </div>
                <div class="modal-body" style="alignment-baseline: central">
                    <div class="row">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="disciplina_horario_id_editar">Disciplina</label>
                                    <select name="disciplina_horario_id_editar" disabled="disabled" class="form-control" id="disciplina_horario_id_editar">
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="dia_id_editar">Dia</label>
                                    <select name="dia_id_editar" disabled="disabled" class="form-control" id="dia_id_editar">
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="hora_id_editar">Hora</label>
                                    <select name="hora_id_editar" disabled="disabled" class="form-control" id="hora_id_editar">
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="sala_id_editar">Sala</label>
                                    <select name="sala_id_editar" class="form-control" id="sala_id_editar">
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="professor_id_editar">Professor</label>
                                    <select name="professor_id_editar" class="form-control" id="professor_id_editar">
                                    </select>
                                </div>
                            </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" id="btnUpdateHorario">Salvar</button>
                    <button class="btn btn-default" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- FIM Modal de cadastro das Disciplinas-->