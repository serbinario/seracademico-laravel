<!-- Modal de cadastro das Disciplinas-->
<div id="modal-modulos" class="modal fade modal-profile" role="dialog" aria-labelledby="modalProfile" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title">Adicionar módulo ao grupo de módulos - <span id="nModulo"></span></h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row" style="margin-bottom: 3%;">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="codigo">Código</label>
                                    <input type="text" class="form-control" name="codigo" id="codigo">
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="nome">Nome</label>
                                    <input type="text" class="form-control" name="nome" id="nome">
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <button class="btn btn-sm btn-primary" type="button" id="addModulo" style="margin-top:21px">Adicionar Módulo</button>
                                        <button class="btn btn-sm btn-primary" type="button" id="editModulo" style="margin-top:21px">Editar Módulo</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table id="modulos-grid" class="display table table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Nome</th>
                                        <th>Acão</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Código</th>
                                        <th>Nome</th>
                                        <th style="width: 5%;">Acão</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- FIM Modal de cadastro das Disciplinas-->