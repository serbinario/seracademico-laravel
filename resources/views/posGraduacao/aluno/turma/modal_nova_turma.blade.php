<!-- Modal principal de disciplinas -->
<div id="modal-nova-turma-aluno" class="modal fade modal-profile" role="dialog" aria-labelledby="modalProfile"
     aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title">Adicionar curso ao aluno</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="curso">Curso</label>
                                <select name="curso" class="form-control" id="curso">
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="turma_id">Turma</label>
                                <select name="turma_id" class="form-control" id="turma_id">
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="situacao_id">Situacao</label>
                                <select name="situacao_id" class="form-control" id="situacao_id">
                                </select>
                            </div>
                        </div>


                        {{--Linha da da Abas--}}
                        {{--<div class="row">--}}
                            {{--<div class="col-md-12">--}}
                                {{--<!-- Nav tabs -->--}}
                                {{--<ul class="nav nav-tabs" role="tablist">--}}
                                    {{--<li role="presentation" class="active">--}}
                                        {{--<a href="#monografia" aria-controls="dados" data-toggle="tab">Monografia / Gerais</a>--}}
                                    {{--</li>--}}
                                    {{--<li role="presentation">--}}
                                        {{--<a href="#banca_exam" aria-controls="documentosObrig" role="tab"--}}
                                           {{--data-toggle="tab">Monografia / Banca--}}
                                            {{--Examinadora</a>--}}
                                    {{--</li>--}}
                                    {{--<li role="presentation">--}}
                                        {{--<a href="#formatura" aria-controls="contato" role="tab" data-toggle="tab">Formatura</a>--}}
                                    {{--</li>--}}
                                {{--</ul>--}}
                                {{--<!-- End Nav tabs -->--}}

                                {{--<!-- Tab panes -->--}}
                                {{--<div class="tab-content">--}}

                                    {{--Aba Monografia--}}
                                    {{--<div role="tabpanel" class="tab-pane active" id="monografia">--}}
                                        {{--<br/>--}}

                                        {{--<div class="row">--}}
                                            {{--<div class="col-md-12">--}}
                                                {{--<div class="form-group">--}}
                                                    {{--<label for="titulo">Título</label>--}}
                                                    {{--<input type="text" class="form-control" name="titulo" id="titulo"--}}
                                                           {{--placeholder="Informe um título">--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}

                                        {{--<div class="row">--}}
                                            {{--<div class="col-md-4">--}}
                                                {{--<div class="form-group">--}}
                                                    {{--<label for="nota_final">Nota Final</label>--}}
                                                    {{--<input type="text" class="form-control" name="nota_final"--}}
                                                           {{--id="nota_final" placeholder="Informe a nota final">--}}
                                                {{--</div>--}}
                                            {{--</div>--}}

                                            {{--<div class="col-md-4">--}}
                                                {{--<div class="form-group">--}}
                                                    {{--<label for="madia">Média</label>--}}
                                                    {{--<input type="text" class="form-control" name="madia" id="madia"--}}
                                                           {{--placeholder="Média">--}}
                                                {{--</div>--}}
                                            {{--</div>--}}

                                            {{--<div class="col-md-4">--}}
                                                {{--<div class="form-group">--}}
                                                    {{--<label for="media_conceito">Média Conceito</label>--}}
                                                    {{--<select name="media_conceito" id="media_conceito"--}}
                                                            {{--class="form-control">--}}
                                                        {{--<option>Selecione</option>--}}
                                                        {{--<option value="1">CUMPRIO</option>--}}
                                                        {{--<option value="0">NÃO CUMPRIO</option>--}}
                                                    {{--</select>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}

                                            {{--<div class="col-md-4">--}}
                                                {{--<div class="form-group">--}}
                                                    {{--<label for="defendeu">Defendeu</label>--}}
                                                    {{--<select name="defendeu" id="defendeu" class="form-control">--}}
                                                        {{--<option>Selecione</option>--}}
                                                        {{--<option value="1">Sim</option>--}}
                                                        {{--<option value="0">Não</option>--}}
                                                    {{--</select>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}

                                        {{--<div class="row">--}}
                                            {{--<div class="col-md-8">--}}
                                                {{--<div class="form-group">--}}
                                                    {{--<label for="professor_orientador_id">Professor orientador</label>--}}
                                                    {{--<select name="professor_orientador_id" class="form-control"--}}
                                                            {{--id="professor_orientador_id">--}}
                                                    {{--</select>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}

                                            {{--<div class="col-md-4">--}}
                                                {{--<div class="form-group">--}}
                                                    {{--<label for="defesa">Defesa</label>--}}
                                                    {{--<input type="text" name="defesa" class="form-control datepicker"--}}
                                                           {{--id="defesa" placeholder="Data">--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                    {{--FIM Aba Monografia--}}

                                    {{--Aba Banca Examinadora--}}
                                    {{--<div role="tabpanel" class="tab-pane" id="banca_exam">--}}
                                        {{--<br/>--}}

                                        {{--<div class="row">--}}
                                            {{--<div class="col-md-6">--}}
                                                {{--<div class="form-group">--}}
                                                    {{--<label for="professor_banca_1_id">Professor 01</label>--}}
                                                    {{--<select name="professor_banca_1_id" class="form-control"--}}
                                                            {{--id="professor_banca_1_id">--}}
                                                    {{--</select>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                            {{--<div class="col-md-6">--}}
                                                {{--<div class="form-group">--}}
                                                    {{--<label for="inst_ensino_banca_1_id">Instituição 01</label>--}}
                                                    {{--<select name="inst_ensino_banca_1_id" class="form-control"--}}
                                                            {{--id="inst_ensino_banca_1_id">--}}
                                                    {{--</select>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}

                                        {{--<div class="row">--}}
                                            {{--<div class="col-md-6">--}}
                                                {{--<div class="form-group">--}}
                                                    {{--<label for="professor_banca_2_id">Professor 02</label>--}}
                                                    {{--<select name="professor_banca_2_id" class="form-control"--}}
                                                            {{--id="professor_banca_2_id">--}}
                                                    {{--</select>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                            {{--<div class="col-md-6">--}}
                                                {{--<div class="form-group">--}}
                                                    {{--<label for="inst_ensino_banca_2_id">Instituição 02</label>--}}
                                                    {{--<select name="inst_ensino_banca_2_id" class="form-control"--}}
                                                            {{--id="inst_ensino_banca_2_id">--}}
                                                    {{--</select>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}

                                        {{--<div class="row">--}}
                                            {{--<div class="col-md-6">--}}
                                                {{--<div class="form-group">--}}
                                                    {{--<label for="professor_banca_3_id">Professor 03</label>--}}
                                                    {{--<select name="professor_banca_3_id" class="form-control"--}}
                                                            {{--id="professor_banca_3_id">--}}
                                                    {{--</select>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                            {{--<div class="col-md-6">--}}
                                                {{--<div class="form-group">--}}
                                                    {{--<label for="inst_ensino_banca_3_id">Instituição 03</label>--}}
                                                    {{--<select name="inst_ensino_banca_3_id" class="form-control"--}}
                                                            {{--id="inst_ensino_banca_3_id">--}}
                                                    {{--</select>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}

                                        {{--<div class="row">--}}
                                            {{--<div class="col-md-6">--}}
                                                {{--<div class="form-group">--}}
                                                    {{--<label for="professor_banca_4_id">Professor 04</label>--}}
                                                    {{--<select name="professor_banca_4_id" class="form-control"--}}
                                                            {{--id="professor_banca_4_id">--}}
                                                    {{--</select>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                            {{--<div class="col-md-6">--}}
                                                {{--<div class="form-group">--}}
                                                    {{--<label for="inst_ensino_banca_4_id">Instituição 04</label>--}}
                                                    {{--<select name="inst_ensino_banca_4_id" class="form-control"--}}
                                                            {{--id="inst_ensino_banca_4_id">--}}
                                                    {{--</select>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}

                                    {{--</div>--}}
                                    {{--FIM Aba Banca Examinadora --}}

                                    {{--Aba Formatura--}}
                                    {{--<div role="tabpanel" class="tab-pane" id="formatura">--}}
                                        {{--<br/>--}}
                                        {{--<div class="row">--}}
                                            {{--<div class="col-md-2">--}}
                                                {{--<div class="form-group">--}}
                                                    {{--<label for="data_conclusao">Data Conclusão</label>--}}
                                                    {{--<input type="text" name="data_conclusao"--}}
                                                           {{--class="form-control datepicker" id="data_conclusao"--}}
                                                           {{--placeholder="Data">--}}
                                                {{--</div>--}}
                                            {{--</div>--}}

                                            {{--<div class="col-md-2">--}}
                                                {{--<div class="form-group">--}}
                                                    {{--<label for="data_colacao">Data Colação</label>--}}
                                                    {{--<input type="text" name="data_colacao"--}}
                                                           {{--class="form-control datepicker" id="data_colacao"--}}
                                                           {{--placeholder="Data">--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                    {{--Aba Formatura--}}


                                {{--</div>--}}
                                {{--<!-- FIM Tab panes -->--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--FIM Linha da da Abas--}}

                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="btnSalvarTurmaAluno">Salvar</button>
                <button class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- FIM Modal de cadastro das Disciplinas-->

