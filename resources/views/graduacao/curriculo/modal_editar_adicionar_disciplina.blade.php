<!-- Modal principal de disciplinas -->
<div id="modal-editar-adicionar-disciplina" class="modal fade modal-profile" tabindex="-1" role="dialog" aria-labelledby="modalProfile"
     aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title">Inserir preço por dsiciplinas</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <div class="row">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="disciplina_id_editar">Disciplina</label>
                            <select name="disciplina_id_editar" class="form-control" id="disciplina_id_editar">
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="periodo_editar">Período</label>
                            <select name="periodo_editar" class="form-control" id="periodo_editar">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                                <option value="13">10</option>
                                <option value="14">14</option>
                                <option value="15">15</option>
                            </select>
                        </div>
                    </div>

                    {{--Linha da da Abas--}}
                    <div class="row">
                        <div class="col-md-12">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active">
                                    <a href="#configuracoesEditar" aria-controls="configuracoesEditar" data-toggle="tab"><i class="material-icons">collections_bookmark</i> Configurações</a>
                                </li>
                                <li role="presentation">
                                    <a href="#prerequisitosEditar" aria-controls="prerequisitosEditar" data-toggle="tab"><i class="material-icons">collections_bookmark</i> Pré-requisitos</a>
                                </li>
                                <li role="presentation">
                                    <a href="#corequisitosEditar" aria-controls="corequisitosEditar" data-toggle="tab"><i class="material-icons">collections_bookmark</i> Co-requisitos</a>
                                </li>
                            </ul>
                            <!-- End Nav tabs -->

                            <!-- Tab panes -->
                            <div class="tab-content">

                                {{--Aba Pré - Reuisitos--}}
                                <div role="tabpanel" class="tab-pane active" id="configuracoesEditar">
                                    <br/>

                                    <!-- Configurações da disciplina -->
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="carga_horaria_total_editar">CH. Total</label>
                                            <input type="text" class="form-control" name="carga_horaria_total_editar" id="carga_horaria_total_editar">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="carga_horaria_teorica_editar">CH. Teórica</label>
                                            <input type="text" class="form-control" name="carga_horaria_teorica_editar" id="carga_horaria_teorica_editar">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="carga_horaria_pratica_editar">CH. Prática</label>
                                            <input type="text" class="form-control" name="carga_horaria_pratica_editar" id="carga_horaria_pratica_editar">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="qtd_credito_editar">Qtd. Crédito</label>
                                            <input type="text" class="form-control" name="qtd_credito_editar" id="qtd_credito_editar">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="qtd_faltas_editar">Qtd. Faltas</label>
                                            <input type="text" class="form-control" name="qtd_faltas_editar" id="qtd_faltas_editar">
                                        </div>
                                    </div>
                                </div>
                                {{--FIM Aba configurações da disciplina MEC--}}

                                {{--Aba Pré - Reuisitos--}}
                                <div role="tabpanel" class="tab-pane" id="prerequisitosEditar">
                                    <br/>

                                    <!-- Disciplias Pre-requisitos -->
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="">Pré-requisitos 1</label>
                                            <select name="pre_disciplinas_editar" id="pre_disciplina_1_editar" class="form-control">
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="">Pré-requisitos 2</label>
                                            <select name="pre_disciplinas_editar" id="pre_disciplina_2_editar" class="form-control">
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="">Pré-requisitos 3</label>
                                            <select name="pre_disciplinas_editar" id="pre_disciplina_3_editar" class="form-control">
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="">Pré-requisitos 4</label>
                                            <select name="pre_disciplinas_editar" id="pre_disciplina_4_editar" class="form-control">
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="">Pré-requisitos 5</label>
                                            <select name="pre_disciplinas_editar" id="pre_disciplina_5_editar" class="form-control">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                {{--FIM Aba Autorização MEC--}}

                                {{--Aba Pré - Reuisitos --}}
                                <div role="tabpanel" class="tab-pane" id="corequisitosEditar">
                                    <br/>

                                    <!-- Disciplias Co-requisitos -->
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="">Co-requisitos</label>
                                            <select name="co_disciplinas_editar" id="co_disciplina_1_editar" class="form-control">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                {{--Aba Co - Requisito--}}

                            </div>
                            <!-- FIM Tab panes -->
                        </div>
                    </div>
                    {{--FIM Linha da da Abas--}}
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="btnUpdateAdicionarDisciplina">Salvar</button>
                <button class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
</div>
<!-- FIM Modal de cadastro das Disciplinas-->