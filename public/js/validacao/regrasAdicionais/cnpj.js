$.validator.addMethod("cnpj", function(value, element) {
    return this.optional(element) || /^[0-9+\/.-]{18}$/i.test(value);
}, $.validator.messages.cnpj);