<!-- Modal principal de disciplinas -->
<div id="modal-disciplina-calendario" class="modal fade modal-profile" tabindex="-1" role="dialog" aria-labelledby="modalProfile" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title">Calendário das disciplinas</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <div class="row">
                    <!-- Linha de descrição -->
                    <div class="col-md-12 infModal">
                        <div class="col-md-12">
                            <span><strong>Turma: </strong><p id="caTurma"></p></span>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <button class="btn btn-primary pull-right" id="btnIncluirDisciplinas" style="margin-bottom: 3%;">Incluir disciplinas</button>

                        <table id="calendario-disciplina-grid" class="display table table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Disciplina</th>
                                <th>Ação</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="col-md-7">
                        <button class="btn btn-primary pull-right" id="btnAddCalendario" disabled="disabled" style="margin-bottom: 2%;">Novo calendário</button>

                        <table id="calendario-cargahoraria-grid" class="display table table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Data</th>
                                <th>Data Final</th>
                                <th>Hora Inicial</th>
                                <th>Hora Final</th>
                                <th>Sala</th>
                                <th>Nome Professor</th>
                                <th style="width: 15%;">Acão</th>
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