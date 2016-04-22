<!-- Modal principal de disciplinas -->
<div id="modal-disciplina-calendario" class="modal fade modal-profile" role="dialog" aria-labelledby="modalProfile" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title">Criação do calendário das disciplinas</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <div class="row">
                    <div class="col-md-4">
                        <table id="calendario-disciplina-grid" class="display table table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th style="width: 20%">Código</th>
                                <th style="width: 40%">Nome</th>
                            </tr>
                            </thead>

                            <tfoot>
                            <tr>
                                <th style="width: 20%">Código</th>
                                <th style="width: 40%">Nome</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="col-md-8">
                        <button class="btn btn-primary" id="btnAddCalendario" data-toggle="modal" data-target="#modal-novo-calendario" disabled="disabled">Novo calendário</button>
                        <table id="calendario-cargahoraria-grid" class="display table table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Data</th>
                                <th>Data Final</th>
                                <th>Hora Inicial</th>
                                <th>Hora Final</th>
                                <th>Sala</th>
                                <th>Nome Professor</th>
                                <th>Acão</th>
                            </tr>
                            </thead>

                            <tfoot>
                            <tr>
                                <th>Data</th>
                                <th>Data Final</th>
                                <th>Hora Inicial</th>
                                <th>Hora Final</th>
                                <th>Sala</th>
                                <th>Nome Professor</th>
                                <th style="width: 10%;">Acão</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
<!-- FIM Modal de cadastro das Disciplinas-->