<!-- Modal principal de disciplinas -->
<div id="modal-tabela-precos" class="modal fade modal-profile" tabindex="-1" role="dialog" aria-labelledby="modalProfile"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" id="closeModalPrecoCurso" data-dismiss="modal">×</button>
                <h4 class="modal-title"><i class="glyphicon glyphicon-list-alt"></i> Tabela de Preços</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <div class="row">
                    <div class="col-md-12">
                        <h3 id="nomeCursoModal" class="pull-left">Curso</h3>
                        <button href="#" id="adicionar-tabela-precos" class="btn-sm btn-primary pull-right">Adicionar Tabela de preços</button><br><br>
                        <table id="grid-tabela-precos" class="display table table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Vigência</th>
                                <th>Semestre</th>
                                <th>Turno</th>
                                <th>Tipo</th>
                                <th style="width: 12%">Ação</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <button href="#" id="btnAddPrecoDisciplina" class="btn-sm btn-primary pull-right">Adicionar preços</button><br><br>
                        <table id="grid-precos" class="display table table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Quantidade</th>
                                <th>Preço</th>
                                <th  style="width: 12%">Ação</th>
                            </tr>
                            </thead>
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