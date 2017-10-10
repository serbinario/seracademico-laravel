<div id="modal-informacacoes-debito" class="modal fade modal-profile" tabindex="-1"
     role="dialog" aria-labelledby="modalProfile" aria-hidden="true">
    <div class="modal-dialog modal-large">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title"><i class="material-icons">assignment</i> Informações sobre o débito</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <div class="row">
                    <div class="col-md-12">

                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#infodebito" aria-controls="infodebito" data-toggle="tab">Débito</a>
                            </li>
                            <li role="presentation">
                                <a href="#infoboleto" aria-controls="infoboleto" data-toggle="tab">Boleto</a>
                            </li>
                        </ul>

                        <div class="tab-content">

                            <div role="tabpanel" class="tab-pane active" id="infodebito">
                                <h3 style="margin-top: 5%;">Taxa</h3>
                                <table class="table">
                                    <tr>
                                        <td style="font-weight: bold; width: 50%;">código: </td>
                                        <td><span id="infoCodTaxa"></span></td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold; width: 50%;">Tipo da taxa: </td>
                                        <td><span id="infoTipoTaxa"></span></td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold; width: 50%;">Valor</td>
                                        <td><span id="infoValorTaxa"></span></td>
                                    </tr>
                                </table>

                                <h3 style="margin-top: 5%;">Débito</h3>
                                <table class="table">
                                    <tr>
                                        <td style="font-weight: bold; width: 50%;">Vencimento</td>
                                        <td><span id="infoVencimentoDebito"></span></td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold; width: 50%;">Valor</td>
                                        <td><span id="infoValorDebito"></span></td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold; width: 50%;">Forma de pagamento</td>
                                        <td><span id="infoFormPagDebito"></span></td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold; width: 50%;">Pago</td>
                                        <td><span id="infoSituacaoDebito"></span></td>
                                    </tr>
                                </table>
                            </div>

                            <div role="tabpanel" class="tab-pane" id="infoboleto">
                                <table style="margin-top: 5%;" class="table">
                                    <tr>
                                        <td style="font-weight: bold; width: 50%;">Código: </td>
                                        <td><span id="infoBoletoCodigo"></span></td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold; width: 50%;">Valor: </td>
                                        <td><span id="infoValorBoleto"></span></td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold; width: 50%;">Situação: </td>
                                        <td><span id="infoSituacaoBoleto"></span></td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold; width: 50%;">Link: </td>
                                        <td><span id="infoLinkBoleto"></span></td>
                                    </tr>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>