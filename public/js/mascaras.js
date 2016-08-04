$(document).ready(function(){
    
    //######## Mascaras para formulário candidato ##########
    
    //Cpf
    $('.cpf').mask('000.000.000-00', {reverse: true});

    //RG
    $('.rg').mask('0.000.000', {reverse: true});

    //CEP
    $('.cep').mask('00000-000');

    //money
     $('.money').mask('000.000.000,00', {reverse: true});

    //Transforma valores em Real (R$) para Dollar ($)
    $('.moneyReal').maskMoney({prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false});

    //CNPJ
    $('.cnpj').mask('00.000.000.0000-00');

    //Telefone
    $('.phone').mask('(00)00000.0000');

    //Numeros
    $('.number').mask('#0' , {reverse: true});

    //Numeros
    $('.numberTwo').mask('00');

    //Numeros
    $('.numberThree').mask('000');

    //Numeros
    $('.numberFor').mask('0000');

    //Numeros
    $('.numberFive').mask('00000');

    //notasComuns
    $('.notasComuns').mask('00,00');
    
    //código
    $('.codigo').mask('###');

    //Data
    $('.date').mask('00/00/0000');

    //Enem
    $('.enem').mask("0##0.00", {reverse: true, maxlength: false});

    //ficha19
    $('.ficha19').mask("0#.00", {reverse: true, maxlength: false});


    $('.time').mask('00:00:00');

    $('.datepicker').datetimepicker({
        timepicker: false,
        format: 'd/m/Y',
        mask: false,
        lang: 'pt-BR'
    });

    //##### Tipos de beneficio
    //##### Submeter formulário
    $('#formTipoBeneficio').submit(function() {

        $('.moneyReal').each(function (index, value) {

            $(value).val($('.moneyReal').maskMoney('unmasked')[index]);

        });

    });

    //##### Submeter formulário
    $('#formTaxa').submit(function() {

        $('.moneyReal').each(function (index, value) {

            $(value).val($('.moneyReal').maskMoney('unmasked')[index]);

        });

    });

    //##### Submeter formulário
    $('#formAluno').submit(function() {
        $('.cpf').unmask();
        $('.phone').unmask();
    });

    //##### Submeter formulário
    $('#formVestibulando').submit(function() {
        $('.cpf').unmask();
        $('.phone').unmask();
    });
     
    //Vaga disponível
    $('#serbinario_sad_bundle_sadbundle_vagasdisponiveis_qtdVagas').mask('0000000000000000000', {reverse: true});
});