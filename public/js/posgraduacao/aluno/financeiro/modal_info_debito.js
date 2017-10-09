$(document).on("click", "#btnInfoDebito", function () {
    var idDebito = tableDebitos.row($(this).parents('tr')).data().id;

    jQuery.ajax({
        type: 'GET',
        url: '/index.php/seracademico/posgraduacao/aluno/financeiro/infoDebito/' + idDebito,
        datatype: 'json',

    }).done(function (retorno) {
        if(retorno.success) {
            loadInfoDebitoDom(retorno.debito);
            $('#modal-informacacoes-debito').modal({show: true});
        } else {
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
});

function loadInfoDebitoDom(debito) {
    $('#infoCodTaxa').html(debito.taxa.codigo);
    $('#infoTipoTaxa').html(debito.taxa.tipo_taxa.nome);
    $('#infoValorTaxa').html(debito.taxa.valor);
    $('#infoVencimentoDebito').html(debito.data_vencimento);
    $('#infoValorDebito').html(debito.valor_debito);
    $('#infoSituacaoDebito').html(debito.pago ? "Sim" : "Não");

    $('#infoBoletoCodigo').html(debito.boleto ? debito.boleto.gnet_charge : '');
    $('#infoValorBoleto').html(debito.boleto.gnet_valor ? debito.boleto.gnet_valor : '');
    $('#infoSituacaoBoleto').html(debito.boleto ? debito.boleto.status_gnet.nome : '');

    var htmlLink = '<a target="_blank" href="'+ debito.boleto.gnet_link +'">Abrir o boleto em outra página</a>';
    $('#infoLinkBoleto').html(
        debito.boleto
            ? htmlLink
            : ''
    );
}