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
                        </div>

                        <!-- Links para a navegação -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#debitos" aria-controls="debitos" data-toggle="tab">Débitos</a>
                            </li>

                            <li role="presentation">
                                <a href="#carnes" aria-controls="carnes" data-toggle="tab">Carnês</a>
                            </li>
                        </ul>

                        <!-- Conteúdo de navegação de abas -->
                        <div class="tab-content">

                            <div role="tabpanel" class="tab-pane active" id="debitos">
                                <div class="row">
                                    <div style="margin-top: 1%;" class="col-md-2">
                                        <a id="btnModalCreateDebitos" class="btn-sm btn-primary pull-left">Novo Débito</a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <table id="grid-debitos" class="display table table-bordered"
                                               cellspacing="0" width="100%">
                                            <thead>
                                            <tr>
                                                <th style="width: 30%">Taxa</th>
                                                <th style="width: 15%">Vencimento</th>
                                                <th style="width: 15%">Valor</th>
                                                <th style="width: 20%">Sit. Boleto</th>
                                                <th>Carnê</th>
                                                <th style="width: 5%">Pago</th>
                                                <th style="width: 5%">Ação</th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane" id="carnes">

                                <table style="margin-top: 2%" id="grid-carnes" class="display table table-bordered"
                                       cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Data Criação</th>
                                        <th>Qtd. Parcelas</th>
                                        <th>Taxa</th>
                                        <th>Valor</th>
                                        <th style="width: 30%">Link</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>

                            <div class="carregamento">
                                {{--<img src="{{ asset('/img/pre-loader/gears_200x200.gif') }}" alt="carregamento">--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>