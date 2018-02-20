$(document).ready(function(){
    
    //######## Mascaras para formulário candidato ##########
    //Mascara códigos
    $('.codigo').mask('AAAAAAAA');

    //Mascara códigos
    $('.obs').mask('AAAAAAAA');

    //Cpf
    $('.cpf').mask('000.000.000-00', {reverse: true});

    //RG
    $('.rg').mask('0.000.000', {reverse: true});

    //CEP
    $('.cep').mask('00.000-000');

    //money
     $('.money').mask('000.000.000,00', {reverse: true});

    //Valor monetario em reais (R$)
    $('.moneyReal').maskMoney({prefix:'R$ ', allowZero: true, allowNegative: true, thousands:'.', decimal:',', affixesStay: false});

    //CNPJ
    $('.cnpj').mask('00.000.000/0000-00');

    //Telefone
    $('.phone').mask('(00)0000.0000');

    //Telefone celular
    $('.celPhone').mask('(00)00000.0000');

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

    //Numeros
    $('.elevenNumbers').mask('00000000000');

    //Numeros
    $('.twelveNumbers').mask('000000000000');

    //notasComuns
    $('.notasComuns').mask('00,00');

    //notasComuns
    $('.decimal').mask('0##0.00',  {placeholder: "R$", reverse: true});
    
    //código
   // $('.codigo').mask('###');

    //Data
    $('.date').mask('00/00/0000');

    //Enem
    $('.enem').mask("0##0.0", {reverse: true, maxlength: false});

    //ficha19
    $('.ficha19').mask("0#.00", {reverse: true, maxlength: false});


    $('.time').mask('00:00:00');

    $('.datepicker').datetimepicker({
        timepicker: false,
        format: 'd/m/Y',
        mask: false,
        lang: 'pt-BR',
        allowBlank: true,
    });

    $('.timepicker').datetimepicker({
        datepicker: false,
        pickSeconds: false,
        timepicker: false,
        format: 'H:i',
        mask: true,
        lang: 'pt-BR',
        allowBlank: true,
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
        $('.cep').unmask();
        $('.celPhone').unmask();
    });

    //##### Submeter formulário
    $('#formProfessor').submit(function() {
        $('.cpf').unmask();
        $('.cnpj').unmask();
        $('.phone').unmask();
        $('.cep').unmask();
        $('.celPhone').unmask();
    });

    //##### Submeter formulário
    $('#formVestibulando').submit(function() {
        $('.cpf').unmask();
        $('.phone').unmask();
        $('.celPhone').unmask();
    });
     
    //Vaga disponível
    $('#serbinario_sad_bundle_sadbundle_vagasdisponiveis_qtdVagas').mask('0000000000000000000', {reverse: true});
});