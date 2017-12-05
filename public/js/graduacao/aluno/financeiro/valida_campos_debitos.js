function validationFaild(msg) {
    swal(msg, 'click no botão abaixo', 'error');
    return false;
}

function validaCampos(campos) {
    if (!campos.taxa_id) {
        return validationFaild('O campo taxa é obrigatório');
    }

    if (!campos.data_vencimento) {
        return validationFaild('O campo Data de Vencimento é obrigatório');
    }

    if (!campos.valor_debito) {
        return validationFaild('O campo Valor é  obrigatório');
    }

    if (!campos.mes_referencia) {
        return validationFaild('O campo Mês de Referência obrigatório');
    }

    if (!campos.ano_referencia) {
        return validationFaild('O campo Ano de Referência é obrigatório');
    }

    if (!campos.conta_bancaria_id) {
        return validationFaild('O campo Conta Bancária é obrigatório');
    }

    return true;
}


