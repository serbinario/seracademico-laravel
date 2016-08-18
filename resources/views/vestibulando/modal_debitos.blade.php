<!-- Modal do financeiro do vestibulando -->
<div id="modal-debitos" class="modal fade modal-profile" tabindex="-1" role="dialog" aria-labelledby="modalProfile" aria-hidden="true">
    <div class="modal-dialog" style="width: 90%;">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title">Financeiro</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <div class="row">
                    <div class="col-md-12">

                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#debitosabertos" aria-controls="debitosabertos" data-toggle="tab">Débitos Abertos</a>
                            </li>
                            <li role="presentation">
                                <a href="#debitospagos" aria-controls="debitospagos" data-toggle="tab"> Débitos Pagos</a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">

                            {{--Aba Débitos Abertos--}}
                            <div role="tabpanel" class="tab-pane active" id="debitosabertos">
                                <br/>

                                <table id="debitos-abertos-grid" class="display table table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th style="width: 10%">Cód Taxa</th>
                                        <th>Taxa</th>
                                        <th style="width: 10%">Vencimento</th>
                                        <th style="width: 10%">Valor Débito</th>
                                        <th style="width: 5%">Ação</th>
                                    </tr>
                                    </thead>
                                </table>

                                {{--<div class="row">--}}
                                    {{--<div class="col-md-2 col-md-offset-10">--}}
                                        {{--<button class="btn btn-primary pull-right" id="btnAdicionarDebitosAbertos">Adicionar</button>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            </div>
                            {{--FIM Débitos Abertos--}}

                            {{--Aba Pré - Turno--}}
                            <div role="tabpanel" class="tab-pane" id="debitospagos">
                                <br/>

                                <table id="debitos-pagos-grid" class="display table table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th style="width: 10%">Cód Taxa</th>
                                        <th>Taxa</th>
                                        <th style="width: 10%">Data Pagamento</th>
                                        <th style="width: 10%">Valor Desconto</th>
                                        <th style="width: 10%">Valor Pago</th>

                                    </tr>
                                    </thead>
                                </table>
                            </div>
                            {{--FIM Débitos Págos--}}

                        </div>
                        <!-- FIM Tab panes -->

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- FIM Modal financeiro-->