<!-- Modal principal de disciplinas -->
<div id="modal-create-planos-aulas" class="modal fade modal-profile" tabindex="-1" role="dialog" aria-labelledby="modalProfile" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 60%;">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title">Novo Plano de Aula</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <div class="row">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="data">Data</label>
                            <input name="data" class="form-control datepicker" id="data">
                        </div>

                        <div class="form-group col-md-2">
                            <label for="hora_inicial">Hora Inicial</label>
                            <input name="hora_inicial" class="form-control time" id="hora_inicial">
                        </div>

                        <div class="form-group col-md-2">
                            <label for="hora_final">Hora Final</label>
                            <input name="hora_final" class="form-control time" id="hora_final">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="numero_aula">Número Aula</label>
                            <input name="numero_aula" class="form-control" id="numero_aula">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Links para a navegação -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#professores" aria-controls="professores" data-toggle="tab">Professores</a>
                        </li>
                        <li role="presentation">
                            <a href="#conteudos" aria-controls="conteudos" data-toggle="tab">Conteúdos</a>
                        </li>
                    </ul>

                    <!-- Conteúdo de navegação de pastas -->
                    <div class="tab-content">

                        {{--Aba Professores --}}
                        <div role="tabpanel" class="tab-pane active" id="professores">
                            <br>
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <label for="professor_1_id">Professor 1</label>
                                    <select name="professor_1_id" class="form-control" id="professor_1_id"></select>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="professor_2_id">Professor 2</label>
                                    <select name="professor_2_id" class="form-control" id="professor_2_id"></select>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="professor_3_id">Professor 3</label>
                                    <select name="professor_3_id" class="form-control" id="professor_3_id"></select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <label for="professor_4_id">Professor 4</label>
                                    <select name="professor_4_id" class="form-control" id="professor_4_id"></select>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="professor_5_id">Professor 5</label>
                                    <select name="professor_5_id" class="form-control" id="professor_5_id"></select>
                                </div>
                            </div>
                        </div>
                        {{-- Fim Aba Professores --}}

                        {{--Aba conteudos --}}
                        <div role="tabpanel" class="tab-pane" id="conteudos">
                            <br>
                           <div class="row">
                               <div class="col-md-9">
                                   <div class="form-group">
                                       <select type="text" class="form-control" id='conteudo_plano_aula'></select>
                                   </div>
                               </div>

                               {{-- Botão --}}
                               <div class="col-md-3">
                                   <button type="button" class="btn-sm btn-primary" id="btnAddConteudoPlanoAula">Adicionar Conteúdo</button>
                               </div>
                           </div>

                            {{-- Grid conteudo programatico --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive no-padding">
                                        <table id="grid-conteudo-programatico-plano-aula" class="display table table-bordered" cellspacing="0" width="100%">
                                            <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Conteúdo</th>
                                                <th style="width: 5%;">Ação</th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            {{-- Grid conteudo programatico --}}
                        </div>
                        {{-- Fim Aba conteudos --}}
                    </div>
                    <!-- Fim Conteúdo de navegação de pastas -->
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="btnSavePlanoAula">Salvar</button>
                <button class="btn btn-default" data-dismiss="modal" id="btnCancelPlanoAula">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- FIM Modal de cadastro das Disciplinas-->