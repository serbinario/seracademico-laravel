<!-- Modal do financeiro do vestibulando -->
<div id="modal-debitos" class="modal fade modal-profile" tabindex="-1" role="dialog" aria-labelledby="modalProfile" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title">Financeiro</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <div class="row">
                    <div class="col-md-12">

                        <div class="col-md-12 infModal">
                            <div class="col-md-4">
                                <span><strong>Vestibulando: </strong><p id="veVestibulando"></p></span>
                            </div>

                            <div class="col-md-4">
                                <span><strong>Vestibular: </strong><p id="veVestibular"></p></span>
                            </div>

                            <div class="col-md-4">
                                <span><strong>Semestre: </strong><p id="veSemestre"></p></span>
                            </div>
                        </div>

                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#debitosabertos" aria-controls="debitosabertos" data-toggle="tab">Débitos Abertos</a>
                            </li>
                            <li role="presentation">
                                <a href="#debitospagos" aria-controls="debitospagos" data-toggle="tab"> Débitos Pagos</a>
                            </li>
                        </ul>

                        <div class="tab-content">

                            <div role="tabpanel" class="tab-pane active" id="debitosabertos">
                                <br/>

                                <div class="row">
                                    <div style="margin-bottom: 2%;" class="col-md-2 col-md-offset-10">
                                        <button class="btn btn-primary pull-right" id="btnModalCreateDebitos">Adicionar</button>
                                    </div>
                                </div>

                                <table id="debitos-abertos-grid" class="display table table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>Taxa</th>
                                        <th style="width: 15%">Vencimento</th>
                                        <th style="width: 15%">Valor Débito</th>
                                        <th style="width: 5%">Ação</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>

                            <div role="tabpanel" class="tab-pane" id="debitospagos">
                                <br/>

                                <table id="debitos-pagos-grid" class="display table table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>Taxa</th>
                                        <th style="width: 15%">Vencimento</th>
                                        <th style="width: 15%">Valor Débito</th>
                                        <th style="width: 5%">Ação</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>

                        </div>

                    </div>
                </div>

                <div class="carregamento">
                    <img src="{{ asset('/img/pre-loader/gears_200x200.gif') }}" alt="carregamento">
                </div>
            </div>
        </div>
    </div>
</div>