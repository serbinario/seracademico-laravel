<!-- Modal principal de disciplinas -->
<div id="modal-debitos" class="modal fade modal-profile" tabindex="-1" role="dialog" aria-labelledby="modalProfile"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title"><i class="material-icons">assignment</i> Financeiro do Aluno</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Linha de descrição -->
                        <div class="col-md-12 infModal">
                            <div class="col-md-4">
                                <span><strong>Matrícula: </strong><p id="finMatricula"></p></span>
                            </div>

                            <div class="col-md-4">
                                <span><strong>Nome do Aluno: </strong><p id="finNomeAluno"></p></span>
                            </div>

                            <div class="col-md-2">
                                <span><strong>Curso: </strong><p id="finCurso"></p></span>
                            </div>

                            <div class="col-md-2">
                                <span><strong>Período: </strong><p id="finPeriodo"></p></span>
                            </div>
                        </div>

                        <!-- Links para a navegação -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#debitos-abertos" aria-controls="debitos-abertos" data-toggle="tab">Débitos Abertos</a>
                            </li>

                            <li role="presentation">
                                <a href="#debitos-fechados" aria-controls="debitos-fechados" data-toggle="tab">Débitos Fechados</a>
                            </li>

                            <li role="presentation">
                                <a href="#boletos" aria-controls="boletos" data-toggle="tab">Boletos</a>
                            </li>
                        </ul>

                        <!-- Conteúdo de navegação de pastas -->
                        <div class="tab-content">

                            {{--Aba A Cursar --}}
                            <div role="tabpanel" class="tab-pane active" id="debitos-abertos">
                                <br>

                                <div class="col-md-3 col-md-offset-9">
                                    <a id="btnCreateDebitoAberto" class="btn-sm btn-primary pull-right">Novo Débito</a>
                                </div>
                                <br><br>

                                <!-- Table a cursar -->
                                <table id="grid-debitos-abertos" class="display table table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>Cod. Taxa</th>
                                        <th>Taxa</th>
                                        <th>V. Taxa</th>
                                        <th>Vencimento</th>
                                        <th>V. Multa</th>
                                        <th>V. Juros</th>
                                        <th>Valor</th>
                                        <th>Mês</th>
                                        <th>Ano</th>
                                        <th>Ação</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>

                            <!-- Aba Cursadas -->
                            <div role="tabpanel" class="tab-pane" id="debitos-fechados">
                                <br/>

                                <!-- Table a cursadas -->
                                <table id="grid-debitos-fechados" class="display table table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>Cod. Taxa</th>
                                        <th>Taxa</th>
                                        <th>V. Taxa</th>
                                        <th>Vencimento</th>
                                        <th>V. Multa</th>
                                        <th>V. Juros</th>
                                        <th>Valor</th>
                                        <th>Mês</th>
                                        <th>Ano</th>
                                        {{--<th>Ação</th>--}}
                                    </tr>
                                    </thead>
                                </table>
                            </div>

                            <!-- Aba Boletos -->
                            <div role="tabpanel" class="tab-pane" id="boletos">
                                <br/>

                                <!-- Table a cursadas -->
                                <table id="grid-boletos" class="display table table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>Nosso Número</th>
                                        <th>Vencimento</th>
                                        <th>Valor</th>
                                        <th>Data Doc.</th>
                                        <th>Nº Doc.</th>
                                        {{--<th>Ação</th>--}}
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