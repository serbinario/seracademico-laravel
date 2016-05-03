<!-- Modal principal de disciplinas -->
<div id="modal-inserir-adicionar-disciplina" class="modal fade modal-profile" tabindex="-1" role="dialog" aria-labelledby="modalProfile"
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
                            <label for="disciplina_id">Disciplina</label>
                            <select name="disciplina_id" class="form-control" id="disciplina_id">
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="periodo">Período</label>
                            <select name="periodo" class="form-control" id="periodo">
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
                                    <a href="#configuracoes" aria-controls="configuracoes" data-toggle="tab"><i class="material-icons">collections_bookmark</i> Configurações</a>
                                </li>
                                <li role="presentation">
                                    <a href="#prerequisitos" aria-controls="prerequisitos" data-toggle="tab"><i class="material-icons">collections_bookmark</i> Pré-requisitos</a>
                                </li>
                                <li role="presentation">
                                    <a href="#corequisitos" aria-controls="corequisitos" data-toggle="tab"><i class="material-icons">collections_bookmark</i> Co-requisitos</a>
                                </li>

                            </ul>
                            <!-- End Nav tabs -->

                            <!-- Tab panes -->
                            <div class="tab-content">

                                {{--Aba Pré - Reuisitos--}}
                                <div role="tabpanel" class="tab-pane active" id="configuracoes">
                                    <br/>

                                    <!-- Configurações da disciplina -->
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="carga_horaria_total">CH. Total</label>
                                            <input type="text" class="form-control" name="carga_horaria_total" id="carga_horaria_total">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="carga_horaria_teorica">CH. Teórica</label>
                                            <input type="text" class="form-control" name="carga_horaria_teorica" id="carga_horaria_teorica">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="carga_horaria_pratica">CH. Prática</label>
                                            <input type="text" class="form-control" name="carga_horaria_pratica" id="carga_horaria_pratica">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="qtd_credito">Qtd. Crédito</label>
                                            <input type="text" class="form-control" name="qtd_credito" id="qtd_credito">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="qtd_faltas">Qtd. Faltas</label>
                                            <input type="text" class="form-control" name="qtd_faltas" id="qtd_faltas">
                                        </div>
                                    </div>
                                </div>
                                {{--FIM Aba configurações da disciplina MEC--}}

                                {{--FIM Inicio aba prerequisitos--}}
                                <div role="tabpanel" class="tab-pane" id="prerequisitos">
                                    <!-- Disciplias Pre-requisitos -->
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="">Pré-requisitos 1</label>
                                            <select name="pre_disciplinas" id="pre_disciplina_1" class="form-control">
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="">Pré-requisitos 2</label>
                                            <select name="pre_disciplinas" id="pre_disciplina_2" class="form-control">
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="">Pré-requisitos 3</label>
                                            <select name="pre_disciplinas" id="pre_disciplina_3" class="form-control">
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="">Pré-requisitos 4</label>
                                            <select name="pre_disciplinas" id="pre_disciplina_4" class="form-control">
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="">Pré-requisitos 5</label>
                                            <select name="pre_disciplinas" id="pre_disciplina_5" class="form-control">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                {{--FIM Aba Autorização MEC--}}

                                {{--Aba Pré - Reuisitos --}}
                                <div role="tabpanel" class="tab-pane" id="corequisitos">
                                    <br/>

                                    <!-- Disciplias Co-requisitos -->
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="">Co-requisitos</label>
                                            <select name="co_disciplinas" id="co_disciplina_1" class="form-control">
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
                <button class="btn btn-primary" id="btnSalvarAdicionarDisciplina">Salvar</button>
                <button class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
</div>
<!-- FIM Modal de cadastro das Disciplinas-->