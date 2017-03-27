<!-- Modal principal de disciplinas -->
<div id="modal-diario-aula" class="modal fade modal-profile" role="dialog" aria-labelledby="modalProfile" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 90%;">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title"><i class="fa fa-calendar" aria-hidden="true"></i> Gerenciamento dos diários de aulas</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <!-- Linha de descrição -->
                <div class="col-md-12 infModal">
                    <div class="col-md-2">
                        <span><strong>Turma: </strong><p id="daTurma"></p></span>
                    </div>

                    <div class="col-md-2">
                        <span><strong>Currículo: </strong><p id="daCurriculo"></p></span>
                    </div>

                    <div class="col-md-4">
                        <span><strong>Curso: </strong><p id="daCurso"></p></span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-5">
                        <h3>Disciplinas</h3>
                        <hr class="hr-dashline">

                        <table id="diario-aula-disciplina-grid" class="display table table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Código</th>
                                <th>Disciplina</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="col-md-7">
                        <span class="sbtable">
                            <button class="btn-floating" disabled="disabled" id="btnCreateDiarioAula" title="Adicionar Diário de Aula"><i class="material-icons">alarm_add</i></button>
                        </span>
                        <h3>Diários de Aulas</h3>
                        <hr class="hr-dashline">
                        <table id="diario-aula-grid" class="display table table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Detalhe</th>
                                <th>Número Aula</th>
                                <th>Data</th>
                                <th>C. Horária</th>
                                <th>Hora Inicial</th>
                                <th>Hora Final</th>
                                <th>Professor</th>
                                <th>Ação</th>
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