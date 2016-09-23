<!-- Modal principal de disciplinas -->
<div id="modal-curriculo-eletiva" class="modal fade modal-profile" tabindex="-1" role="dialog" aria-labelledby="modalProfile" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 90%;">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title"><i class="fa fa-calendar" aria-hidden="true"></i> Gerenciamento das disciplinas eletivas</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <!-- Linha de descrição -->
                <div class="col-md-12 infModal">
                    <div class="col-md-2">
                        <span><strong>Código: </strong><p id="ceCodigoCurriculo"></p></span>
                    </div>

                    <div class="col-md-8">
                        <span><strong>Currículo: </strong><p id="ceNomeCurriculo"></p></span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-5">
                        <h3>Disciplinas Eletivas</h3>
                        <hr class="hr-dashline">

                        <table id="disciplina-eletiva-grid" class="display table table-bordered" cellspacing="0" width="100%">
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
                            <button class="btn-floating" id="btnAdicionarOpcaoEletiva" title="Adicionar opções de eletiva"><i class="material-icons">alarm_add</i></button>
                        </span>

                        <h4>Opções da Eletiva</h4>

                        <hr class="hr-dashline">
                        <table id="opcoes-eletivas-grid" class="display table table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Semestre</th>
                                <th>Disciplina</th>
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