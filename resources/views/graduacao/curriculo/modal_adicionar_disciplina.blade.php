    <!-- Modal de cadastro das Disciplinas-->
    <div  id="modal-adicionar-disciplina-curriculo" class="modal fade modal-profile" role="dialog" aria-labelledby="modalProfile" aria-hidden="true">
        <div class="modal-dialog" style="width: 98%; height: 90%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" id="btnCloseAddDisciplina" type="button">×</button>
                    <h4 class="modal-title"><i class="material-icons">add_to_photos</i>  Adicionar disciplinas ao currículo</h4>
                </div>
                <div class="modal-body" style="alignment-baseline: central">
                    <!-- Linha de descrição -->
                    <div class="col-md-12 infModal">
                        <div class="col-md-2">
                            <span><strong>Código: </strong><p id="adCodigoCurriculo"></p></span>
                        </div>

                        <div class="col-md-8">
                            <span><strong>Currículo: </strong><p id="adNomeCurriculo"></p></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <form id="search-form" class="form-inline" role="form" method="GET">
                                <div class="form-group">
                                    <label for="periodoSearch">Período: </label>
                                    <input id="periodoSearch" class="form-control" type="text" name="periodoSearch">
                                </div>
                                <div class="form-group">
                                    <button class="btn-sm btn-primary" type="submit">Pesquisar</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-8">
                            <button class="btn-floating pull-right" type="button" id="graduacaoAddDisciplina" title="Adicionar Disciplinas"><i class="material-icons">add_to_photos</i></button>
                        </div>
                    </div>
                    <hr class="hr-dashline">
                    <div class="row">
                        <div class="col-md-12">
                            <table id="add-disciplina-curriculo" class="display table table-bordered" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>Detalhe</th>
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
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- FIM Modal de cadastro das Disciplinas-->