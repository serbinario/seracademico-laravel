<!-- Modal principal de disciplinas -->
<div id="modal-itens-parametros" class="modal fade modal-profile" tabindex="-1" role="dialog" aria-labelledby="modalProfile" aria-hidden="true">
    <div class="modal-dialog" style="width: 70%;">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title">Gerenciamento de itens do parâmetro</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <div class="row">
                    <div class="col-md-6">
                        <h2 style="margin-bottom: 10px;" id="tituloParametro"></h2>
                    </div>

                    <div class="col-md-6">
                        <button style="margin-top: 10px;" class="btn btn-primary pull-right" id="btnAddItesParametros" style="margin-bottom: 3%;">Novo Item</button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                         <table id="itens-grid" class="display table table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Valor</th>
                                <th>Ação</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Nome</th>
                                <th style="width: 20%;">Valor</th>
                                <th style="width: 5%;">Ação</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- FIM Modal de cadastro das Disciplinas-->