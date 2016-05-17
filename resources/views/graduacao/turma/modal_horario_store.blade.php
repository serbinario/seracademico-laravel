    <!-- Modal de cadastro das Disciplinas-->
    <div  id="modal-horario-store" class="modal fade modal-profile" role="dialog" aria-labelledby="modalProfile" aria-hidden="true">
        <div class="modal-dialog" style="width: 30%">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" type="button" data-dismiss="modal">×</button>
                    <h4 class="modal-title">Adicionar horário</h4>
                </div>
                <div class="modal-body" style="alignment-baseline: central">
                    <div class="row">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="disciplina_horario_id">Disciplina</label>
                                    <select name="disciplina_horario_id" class="form-control" id="disciplina_horario_id">
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="dia_id">Dia</label>
                                    <select name="dia_id" class="form-control" id="dia_id">
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="hora_id">Hora</label>
                                    <select name="hora_id" class="form-control" id="hora_id">
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="sala_id">Sala</label>
                                    <select name="sala_id" class="form-control" id="sala_id">
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="professor_id">Professor</label>
                                    <select name="professor_id" class="form-control" id="professor_id">
                                    </select>
                                </div>
                            </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" id="btnStoreHorario">Salvar</button>
                    <button class="btn btn-default" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- FIM Modal de cadastro das Disciplinas-->