<!-- Modal principal de disciplinas -->
<div id="modal-beneficios" class="modal fade modal-profile" tabindex="-1" role="dialog" aria-labelledby="modalProfile"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title"><i class="material-icons">assignment</i> Benefícios do Aluno</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Linha de descrição -->
                        <div class="col-md-12 infModal">
                            <div class="col-md-4">
                                <span><strong>Matrícula: </strong><p id="benMatricula"></p></span>
                            </div>

                            <div class="col-md-4">
                                <span><strong>Nome do Aluno: </strong><p id="benNomeAluno"></p></span>
                            </div>

                            <div class="col-md-2">
                                <span><strong>Curso: </strong><p id="benCurso"></p></span>
                            </div>

                            <div class="col-md-2">
                                <span><strong>Período: </strong><p id="benPeriodo"></p></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-3 col-md-offset-9">
                            <a id="btnCreateBeneficio" class="btn-sm btn-primary pull-right">Novo Benefício</a>
                        </div>
                        <br><br>

                        <!-- Table a cursar -->
                        <table id="grid-beneficios" class="display table table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Detalhe</th>
                                <th>Benefício</th>
                                <th>Tipo Valor</th>
                                <th>Valor</th>
                                <th>Inicio</th>
                                <th>Fim</th>
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