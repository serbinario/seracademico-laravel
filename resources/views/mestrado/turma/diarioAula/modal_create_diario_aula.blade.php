<!-- Modal principal de disciplinas -->
<div id="modal-create-diario-aula" class="modal fade modal-profile" role="dialog" aria-labelledby="modalProfile"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" id="closeModalCreateDiarioAula" data-dismiss="modal">×</button>
                <h4 class="modal-title"><i class="material-icons">assignment</i> Cadastrar Diário de Aula</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <div class="row">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="professor_id_diario_aula">Professores</label>
                            <select name="professor_id_diario_aula" class="form-control" id="professor_id_diario_aula">
                            </select>
                        </div>

                        <div class="form-group col-md-2">
                            <label for="data_diario_aula">Data</label>
                            <input type="text" name="data_diario_aula" id="data_diario_aula" class="form-control datepicker">
                        </div>

                        <div class="form-group col-md-2">
                            <label for="carga_horaria_diario_aula">Carga horária</label>
                            <input type="text" name="carga_horaria_diario_aula" id="carga_horaria_diario_aula" class="form-control">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-2">
                            <label for="numero_aula_diario_aula">Número Aula</label>
                            <input type="text" name="numero_aula_diario_aula" class="form-control" id="numero_aula_diario_aula">
                        </div>

                        <div class="form-group col-md-2">
                            <label for="hora_inicial_diario_aula">Hora inicial</label>
                            <input type="text" name="hora_inicial_diario_aula" id="hora_inicial_diario_aula" class="form-control time">
                        </div>

                        <div class="form-group col-md-2">
                            <label for="hora_final_diario_aula">Hora final</label>
                            <input type="text" name="hora_final_diario_aula" id="hora_final_diario_aula" class="form-control time">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="assunto_ministrado">Assunto Ministrado</label>
                            <textarea class="form-control" rows="5" name="assunto_ministrado" id="assunto_ministrado"></textarea>
                        </div>
                    </div>

                    <hr>

                    <div class="row" style="padding-bottom: 10px;">
                        <div class="col-md-10">
                            <select name="conteudo_programatico_diario_aula" class="form-control" id="conteudo_programatico_diario_aula">
                            </select>
                        </div>

                        <div class="col-md-2">
                            <button id="btnAddConteudoProgramaticoDiarioAula" class="btn btn-primary">Adicionar</button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <div class="table-responsive no-padding">
                                <table id="conteudo-programatico-diario-aula-grid" class="display table table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>Id</th>
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
                <button class="btn btn-primary" id="btnSaveDiarioAula">Salvar</button>
                <button class="btn btn-default" data-dismiss="modal" id="btnCancelDiarioAula">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- FIM Modal de cadastro das Disciplinas-->