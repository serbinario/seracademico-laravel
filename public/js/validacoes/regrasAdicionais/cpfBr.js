$.validator.addMethod("cpfBr", function(value, element) {
    return this.optional(element) || /^([0-9]{3}\.?[0-9]{3}\.?[0-9]{3}\-?[0-9]{2}|[0-9]{2}\.?[0-9]{3}\.?[0-9]{3}\/?[0-9]{4}\-?[0-9]{2})$/i.test(value);
}, $.validator.messages.cpfBr);