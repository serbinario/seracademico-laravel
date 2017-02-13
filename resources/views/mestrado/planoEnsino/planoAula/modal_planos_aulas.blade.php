<!-- Modal principal de disciplinas -->
<div id="modal-planos-aulas" class="modal fade modal-profile" tabindex="-1" role="dialog" aria-labelledby="modalProfile"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" id="closeModalPlanoAula" data-dismiss="modal">×</button>
                <h4 class="modal-title"><i class="glyphicon glyphicon-list-alt"></i> Planos de Aula</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-12 infModal">

                            <div class="col-md-3">
                                <span><strong>Plano Ensino: </strong><p id="paPlanoEnsino"></p></span>
                            </div>

                            <div class="col-md-5">
                                <span><strong>Disciplina: </strong><p id="paDisciplina"></p></span>
                            </div>

                            <div class="col-md-2">
                                <span><strong>Carga H.: </strong><p id="paCargaHoraria"></p></span>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-12">
                        <a href="#" id="btnCreatePlanoAula" class="btn-sm btn-primary pull-right">Novo Plano de Aula</a><br><br>
                        <table id="grid-planos-aulas" class="display table table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Data</th>
                                <th>Hora Inicial</th>
                                <th>Hora Final</th>
                                <th>Número Aula</th>
                                <th>Professor 1</th>
                                <th style="width: 5%">Ação</th>
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