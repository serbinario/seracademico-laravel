    <!-- Modal de cadastro das Disciplinas-->
    <div  id="modal-store-adicionar-eletiva" class="modal fade modal-profile" role="dialog" aria-labelledby="modalProfile" aria-hidden="true">
        <div class="modal-dialog" style="width: 30%; height: 90%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" id="btnCloseAddDisciplina" type="button">×</button>
                    <h4 class="modal-title"><i class="material-icons">add_to_photos</i>  Adicionar opções de eletivas</h4>
                </div>
                <div class="modal-body" style="alignment-baseline: central">
                  <div class="row">
                      <div class="row">
                          <div class="form-group col-md-12">
                              <label for="semestre_eletiva_id">Semestre</label>
                              <select name="semestre_eletiva_id" class="form-control" id="semestre_eletiva_id">
                              </select>
                          </div>
                      </div>

                      <div class="row">
                          <div class="form-group col-md-12">
                              <label for="curriculo_eletiva_id">Currículo</label>
                              <select name="curriculo_eletiva_id" class="form-control" id="curriculo_eletiva_id">
                              </select>
                          </div>
                      </div>

                      <div class="row">
                          <div class="form-group col-md-12">
                              <label for="disciplina_opcao_eletiva_id">Disciplina</label>
                              <select name="disciplina_opcao_eletiva_id" class="form-control" id="disciplina_opcao_eletiva_id">
                              </select>
                          </div>
                      </div>
                  </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" id="btnStoreAdicionarEletiva">Salvar</button>
                    <button class="btn btn-default" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- FIM Modal de cadastro das Disciplinas-->