<!-- Modal principal de disciplinas -->
<div id="modal-edit-diario-aula" class="modal fade modal-profile" role="dialog" aria-labelledby="modalProfile"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" id="closeModalCreateDiarioAula" data-dismiss="modal">×</button>
                <h4 class="modal-title"><i class="material-icons">assignment</i> Editar Diário de Aula</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <div class="row">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="professor_id_diario_aula_edit">Professores</label>
                            <select name="professor_id_diario_aula_edit" class="form-control" id="professor_id_diario_aula_edit">
                            </select>
                        </div>

                        <div class="form-group col-md-2">
                            <label for="data_diario_aula_edit">Data</label>
                            <input type="text" name="data_diario_aula_edit" id="data_diario_aula_edit" class="form-control datepicker">
                        </div>

                        <div class="form-group col-md-2">
                            <label for="carga_horaria_diario_aula_edit">Carga horária</label>
                            <input type="text" name="carga_horaria_diario_aula_edit" id="carga_horaria_diario_aula_edit" class="form-control">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-2">
                            <label for="numero_aula_diario_aula_edit">Número Aula</label>
                            <input type="text" name="numero_aula_diario_aula_edit" class="form-control" id="numero_aula_diario_aula_edit">
                        </div>

                        <div class="form-group col-md-2">
                            <label for="hora_inicial_diario_aula_edit">Hora inicial</label>
                            <input type="text" name="hora_inicial_diario_aula_edit" id="hora_inicial_diario_aula_edit" class="form-control time">
                        </div>

                        <div class="form-group col-md-2">
                            <label for="hora_final_diario_aula_edit">Hora final</label>
                            <input type="text" name="hora_final_diario_aula_edit" id="hora_final_diario_aula_edit" class="form-control time">
                        </div>


                    </div>

                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="assunto_ministrado_edit">Assunto Ministrado</label>
                            <textarea class="form-control" rows="5" name="assunto_ministrado_edit" id="assunto_ministrado_edit"></textarea>
                        </div>
                    </div>

                    <hr>

                    <div class="row" style="padding-bottom: 10px;">
                        <div class="col-md-10">
                            <select name="conteudo_programatico_diario_aula_edit" class="form-control" id="conteudo_programatico_diario_aula_edit">
                            </select>
                        </div>

                        <div class="col-md-2">
                            <button id="btnAddConteudoProgramaticoDiarioAulaEdit" class="btn btn-primary">Adicionar</button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <div class="table-responsive no-padding">
                                <table id="conteudo-programatico-diario-aula-grid-edit" class="display table table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th style="width: 5%;">Acão</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="btnUpdateDiarioAula">Salvar</button>
                <button class="btn btn-default" data-dismiss="modal" id="btnCancelDiarioAula">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- FIM Modal de cadastro das Disciplinas-->