<!-- Modal principal de disciplinas -->
<div id="modal-edit-nova-turma-aluno" class="modal fade modal-profile" role="dialog" aria-labelledby="modalProfile"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title">Adicionar curso ao aluno</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="curso_edit">Curso</label>
                                <select  name="curso_edit" class="form-control" id="curso_edit">
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="turma_id_edit">Turma</label>
                                <select  name="turma_id_edit" class="form-control" id="turma_id_edit">
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="situacao_id_edit">Situacao</label>
                                <select name="situacao_id_edit" class="form-control" id="situacao_id_edit">
                                </select>
                            </div>
                        </div>

                        {{--Linha da da Abas--}}
                        <div class="row">
                            <div class="col-md-12">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active">
                                        <a href="#monografiaedit" aria-controls="monografiaedit" data-toggle="tab">Monografia / Gerais</a>
                                    </li>
                                    <li role="presentation">
                                        <a href="#banca_examedit" aria-controls="banca_examedit" role="tab"
                                           data-toggle="tab">Monografia / Banca
                                            Examinadora</a>
                                    </li>
                                    <li role="presentation">
                                        <a href="#formaturaedit" aria-controls="formaturaedit" role="tab" data-toggle="tab">Formatura</a>
                                    </li>
                                </ul>
                                <!-- End Nav tabs -->

                                <!-- Tab panes -->
                                <div class="tab-content">

                                    {{--Aba Monografia--}}
                                    <div role="tabpanel" class="tab-pane active" id="monografiaedit">
                                        <br/>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="titulo_edit">Título</label>
                                                    <input type="text" class="form-control" name="titulo_edit" id="titulo_edit"
                                                           placeholder="Informe um título">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="nota_final_edit">Nota Final</label>
                                                    <input type="text" class="form-control" name="nota_final_edit"
                                                           id="nota_final_edit" placeholder="Informe a nota final">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="madia_edit">Média</label>
                                                    <input type="text" class="form-control" name="madia_edit" id="madia_edit"
                                                           placeholder="Média">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="media_conceito_edit">Média Conceito</label>
                                                    <select name="media_conceito_edit" id="media_conceito_edit"
                                                            class="form-control">
                                                        <option>Selecione</option>
                                                        <option value="1">CUMPRIO</option>
                                                        <option value="0">NÃO CUMPRIO</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="defendeu_edit">Defendeu</label>
                                                    <select name="defendeu_edit" id="defendeu_edit" class="form-control">
                                                        <option>Selecione</option>
                                                        <option value="1">Sim</option>
                                                        <option value="0">Não</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label for="professor_orientador_id_edit">Professor orientador</label>
                                                    <select name="professor_orientador_id_edit" class="form-control"
                                                            id="professor_orientador_id_edit">
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="defesa_edit">Defesa</label>
                                                    <input type="text" name="defesa_edit" class="form-control datepicker"
                                                           id="defesa_edit" placeholder="Data">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{--FIM Aba Monografia--}}

                                    {{--Aba Banca Examinadora--}}
                                    <div role="tabpanel" class="tab-pane" id="banca_examedit">
                                        <br/>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="professor_banca_1_id_edit">Professor 01</label>
                                                    <select name="professor_banca_1_id_edit" class="form-control"
                                                            id="professor_banca_1_id_edit">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="inst_ensino_banca_1_id_edit">Instituição 01</label>
                                                    <select name="inst_ensino_banca_1_id_edit" class="form-control"
                                                            id="inst_ensino_banca_1_id_edit">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="professor_banca_2_id_edit">Professor 02</label>
                                                    <select name="professor_banca_2_id_edit" class="form-control"
                                                            id="professor_banca_2_id_edit">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="inst_ensino_banca_2_id_edit">Instituição 02</label>
                                                    <select name="inst_ensino_banca_2_id_edit" class="form-control"
                                                            id="inst_ensino_banca_2_id_edit">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="professor_banca_3_id_edit">Professor 03</label>
                                                    <select name="professor_banca_3_id_edit" class="form-control"
                                                            id="professor_banca_3_id_edit">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="inst_ensino_banca_3_id_edit">Instituição 03</label>
                                                    <select name="inst_ensino_banca_3_id_edit" class="form-control"
                                                            id="inst_ensino_banca_3_id_edit">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="professor_banca_4_id_edit">Professor 04</label>
                                                    <select name="professor_banca_4_id_edit" class="form-control"
                                                            id="professor_banca_4_id_edit">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="inst_ensino_banca_4_id_edit">Instituição 04</label>
                                                    <select name="inst_ensino_banca_4_id_edit" class="form-control"
                                                            id="inst_ensino_banca_4_id_edit">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    {{--FIM Aba Banca Examinadora --}}

                                    {{--Aba Formatura--}}
                                    <div role="tabpanel" class="tab-pane" id="formaturaedit">
                                        <br/>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="data_conclusao_edit">Data Conclusão</label>
                                                    <input type="text" name="data_conclusao_edit"
                                                           class="form-control datepicker" id="data_conclusao_edit"
                                                           placeholder="Data">
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="data_colacao_edit">Data Colação</label>
                                                    <input type="text" name="data_colacao_edit"
                                                           class="form-control datepicker" id="data_colacao_edit"
                                                           placeholder="Data">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{--Aba Formatura--}}


                                </div>
                                <!-- FIM Tab panes -->
                            </div>
                        </div>
                        {{--FIM Linha da da Abas--}}

                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="btnUpdateTurmaAluno">Salvar</button>
                <button class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- FIM Modal de cadastro das Disciplinas-->

