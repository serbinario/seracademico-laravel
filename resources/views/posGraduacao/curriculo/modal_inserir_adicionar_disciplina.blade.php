<!-- Modal principal de disciplinas -->
<div id="modal-inserir-adicionar-disciplina" class="modal fade modal-profile" tabindex="-1" role="dialog" aria-labelledby="modalProfile"
     aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title">Adicionar disciplina</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <div class="row">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="disciplina_id">Disciplina</label>
                            <select name="disciplina" class="form-control" id="disciplina_id">
                            </select>
                        </div>
                    </div>

                    {{--Linha da da Abas--}}
                    <div class="row">
                        <div class="col-md-12">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active">
                                    <a href="#configuracoes" aria-controls="configuracoes" data-toggle="tab">Configurações</a>
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