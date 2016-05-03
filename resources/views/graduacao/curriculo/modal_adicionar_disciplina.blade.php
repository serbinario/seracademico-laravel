    <!-- Modal de cadastro das Disciplinas-->
    <div  id="modal-adicionar-disciplina-curriculo" class="modal fade modal-profile" role="dialog" aria-labelledby="modalProfile" aria-hidden="true">
        <div class="modal-dialog" style="width: 100%; height: 100%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" type="button" data-dismiss="modal">×</button>
                    <h4 class="modal-title">Adicionar disciplinas ao currículo</h4>
                </div>
                <div class="modal-body" style="alignment-baseline: central">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Filtro personalizado</h3>
                                </div>
                                <div class="panel-body">
                                    <form id="search-form" class="form-inline" role="form" method="GET">
                                        <div class="form-group">
                                            <label for="periodoSearch">Período: </label>
                                            <input id="periodoSearch" class="form-control" type="text" placeholder="search período" name="periodoSearch">
                                        </div>
                                        <div class="form-group">
                                            <button class="btn btn-primary" type="submit">Pesquisar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-sm btn-primary pull-right" type="button" id="graduacaoAddDisciplina">Adicionar Disciplinas</button>
                            <table id="add-disciplina-curriculo" class="display table table-bordered" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th style="width: 5%;">Código</th>
                                    <th>Nome</th>
                                    <th style="width: 5%;">Período</th>
                                    <th style="width: 5%;">Qtd. Faltas</th>
                                    <th style="width: 5%;">CH. Total</th>
                                    <th style="width: 5%;">CH. Prática</th>
                                    <th style="width: 5%;">CH. Teórica</th>
                                    <th style="width: 5%;">Crédito</th>
                                    <th style="width: 10%;">Tipo da disciplina</th>
                                    <th >Acão</th>
                                </tr>
                                </thead>

                                <tfoot>
                                <tr>
                                    <th style="width: 5%;">Código</th>
                                    <th>Nome</th>
                                    <th style="width: 5%;">Período</th>
                                    <th style="width: 5%;">Qtd. Faltas</th>
                                    <th style="width: 5%;">CH. Total</th>
                                    <th style="width: 5%;">CH. Prática</th>
                                    <th style="width: 5%;">CH. Teórica</th>
                                    <th style="width: 5%;">Crédito</th>
                                    <th style="width: 10%;">Tipo da disciplina</th>
                                    <th >Acão</th>
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