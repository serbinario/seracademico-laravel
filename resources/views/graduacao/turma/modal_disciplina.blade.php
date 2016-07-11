<!-- Modal principal de disciplinas -->
<div id="modal-disciplina-horario" class="modal fade modal-profile" tabindex="-1" role="dialog" aria-labelledby="modalProfile" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 90%;">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title">Gerenciamento das disciplinas</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <!-- Linha de descrição -->
                <div class="col-md-12 infModal">
                    <div class="col-md-4">
                        <span><strong>Currículo: </strong><p id="tdCurriculo"></p></span>
                    </div>

                    <div class="col-md-6">
                        <span><strong>Curso: </strong><p id="tcCurso"></p></span>
                    </div>

                    <div class="col-md-2">
                        <span><strong>Ano: </strong><p id="taAno"></p></span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-5">
                        <button class="btn btn-primary pull-right" id="btnIncluirDisciplinas" style="margin-bottom: 3%;">Incluir disciplinas</button>

                        <table id="disciplina-grid" class="display table table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Código</th>
                                <th>Disciplina</th>
                                <th>Ação</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="col-md-7">

                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#horario" aria-controls="horario" data-toggle="tab"><i class="material-icons">collections_time</i> Horário</a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">

                            {{--Aba Pré - Reuisitos--}}
                            <div role="tabpanel" class="tab-pane active" id="horario">
                                <br/>

                                {{--<button class="btn btn-primary pull-right" id="btnAddCalendario" data-toggle="modal" data-target="#modal-novo-calendario" disabled="disabled" style="margin-bottom: 2%;">Novo calendário</button>--}}

                                <table id="horario-grid" class="display table table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>Hora</th>
                                        <th>Dom</th>
                                        <th>Seg</th>
                                        <th>Ter</th>
                                        <th>Qua</th>
                                        <th>Qui</th>
                                        <th>Sex</th>
                                        <th>Sab</th>
                                    </tr>
                                    </thead>
                                </table>

                                <div class="row">
                                    <div class="col-md-5 col-md-offset-7">
                                        <div class="btn-group btn-group-justified">
                                            <div class="btn-group">
                                                <button class="btn btn-primary pull-right" id="btnAdicionarHorario" style="margin-bottom: 3%;">Adicionar</button>
                                            </div>
                                            {{--<div class="btn-group">--}}
                                                {{--<button class="btn btn-primary pull-right" id="btnEditarHorario" style="margin-bottom: 3%;">Editar</button>--}}
                                            {{--</div>--}}
                                            <div class="btn-group">
                                                <button class="btn btn-primary pull-right" id="btnRemoverHorario" style="margin-bottom: 3%;">Excluir</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{--FIM Aba Horario--}}
                        </div>
                        <!-- FIM Tab panes -->

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- FIM Modal de cadastro das Disciplinas-->