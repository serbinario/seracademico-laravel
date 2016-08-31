<!-- Modal principal de disciplinas -->
<div id="modal-disciplina-horario" class="modal fade modal-profile" tabindex="-1" role="dialog" aria-labelledby="modalProfile" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 90%;">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title"><i class="fa fa-calendar" aria-hidden="true"></i> Gerenciamento das disciplinas</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <!-- Linha de descrição -->
                <div class="col-md-12 infModal">
                    <div class="col-md-2">
                        <span><strong>Turma: </strong><p id="thTurma"></p></span>
                    </div>

                    <div class="col-md-2">
                        <span><strong>Período: </strong><p id="thPeriodo"></p></span>
                    </div>

                    <div class="col-md-2">
                        <span><strong>Currículo: </strong><p id="thCurriculo"></p></span>
                    </div>

                    <div class="col-md-4">
                        <span><strong>Curso: </strong><p id="thCurso"></p></span>
                    </div>

                    <div class="col-md-2">
                        <span><strong>Semestre: </strong><p id="thSemestre"></p></span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-5">
                        <button class="btn-floating pull-right" id="btnIncluirDisciplinas" title="Incluir Disciplinas"><i class="material-icons">collections_bookmark</i></button>
                        <h3>Disciplinas</h3>
                        <hr class="hr-dashline">

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

                        <span class="sbtable">
                            <button class="btn-floating" id="btnAdicionarHorario" title="Adicionar Horário"><i class="material-icons">alarm_add</i></button>
                            <button class="btn-floating" id="btnEditarHorario" title="Adicionar Horário"><i class="material-icons">edit</i></button>
                            <button class="btn-floating" id="btnRemoverHorario" title="Remover Horário"><i class="material-icons">delete</i></button>
                        </span>
                        <h3>Horário</h3>
                        <hr class="hr-dashline">
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

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- FIM Modal de cadastro das Disciplinas-->