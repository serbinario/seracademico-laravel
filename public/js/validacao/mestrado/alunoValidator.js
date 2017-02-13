// Regras de validação
$(document).ready(function () {
/*'img' => 'image|max:800',
 'matricula' => 'unique:pos_alunos,matricula',

 'pessoa.cpf' => 'required_if:tipo_pretensao_id,==, ""|max:20|pos_aluno_unique_in_pessoa:cpf,:id',
 'pessoa.nome_pai' => 'max:60|serbinario_alpha_space_especial',
 'pessoa.nome_mae' => 'max:60|serbinario_alpha_space_especial',
 'pessoa.data_nasciemento' => 'required_if:tipo_pretensao_id,==, ""|serbinario_date_format:"d/m/Y"',
 'pessoa.identidade' => 'required_if:tipo_pretensao_id,==, ""|digits_between:4,11|numeric',
 'pessoa.enderecos_id' => 'integer',
 'pessoa.sexos_id' => 'integer',
 'pessoa.turnos_id' => 'integer',
 'pessoa.grau_instrucoes_id' => 'integer',
 'pessoa.profissoes_id' => 'integer',
 'pessoa.estados_civis_id' => 'integer',
 'pessoa.tipos_sanguinios_id' => 'integer',
 'pessoa.cores_racas_id' => 'integer',
 'estados_id' => 'integer',
 'pessoa.uf_nascimento_id' => 'integer',
 'pessoa.uf_exp' => '',
 'pessoa.nome_social' => 'max:200|serbinario_alpha_space',
 'pessoa.orgao_rg' => 'max:30',
 'pessoa.data_expedicao' => 'serbinario_date_format:"d/m/Y"',
 'pessoa.titulo_eleitoral' => 'digits_between:4,20|numeric',
 'pessoa.zona' => 'digits_between:1,11|numeric',
 'pessoa.secao' => 'digits_between:1,11|numeric',
 'pessoa.resevista' => 'digits_between:4,11|numeric',
 'pessoa.catagoria_resevista' => 'max:20',
 'pessoa.nacionalidade' => 'max:30|serbinario_alpha_space',
 'pessoa.naturalidade' => 'max:30|serbinario_alpha_space',
 'pessoa.email' => 'email|max:50|pos_aluno_unique_in_pessoa:email,:id',
 'pessoa.telefone_fixo' => 'digits_between:9,11|numeric',
 'pessoa.celular' => 'digits_between:9,11|numeric',
 'pessoa.celular2' => 'digits_between:9,11|numeric',
 'pessoa.deficiencia_auditiva' => 'integer',
 'pessoa.deficiencia_visual' => 'integer',
 'pessoa.deficiencia_fisica' => 'integer',
 'pessoa.deficiencia_outra' => 'integer',
 //
 //            //Tabela Endereço
 'pessoa.endereco.logradouro' => 'serbinario_alpha_space|max:100',
 'pessoa.endereco.numero' => 'numeric|max:99999',
 'pessoa.endereco.complemento' => 'max:100',
 'pessoa.endereco.bairros_id' => 'integer',
 'pessoa.nome' => 'required|max:60|serbinario_alpha_space_especial',*/
    $("#formAluno").validate({
        rules: {
            'pessoa.nome': {
                required: true,
                maxlength: 60
            },

            'num_nis': {
                required: true,
                number: true,
                maxlength: 30
            },

            'num_inep': {
                required: true,
                number: true,
                maxlength: 30
            },

            'cgm[nome]': {
                required: true,
                maxlength: 45,
                alphaSpace: true
            },

            'cgm[data_nascimento]': {
                required: true,
                //dateBr: true,
                maxlength: 15

            },

            'cgm[sexo_id]': {
                required: true,
                integer: true
            },

            'cgm[cpf]': {
                //required: true,
                cpfBr: true,
                // maxlength: 15,
                unique: [laroute.route('aluno.searchCpf'), $('#idAluno')]
            },

            'cgm[rg]': {
                //required: true,
                number: true,
                maxlength: 20
            },

            'cgm[pai]': {
                maxlength: 45,
                //required: true,
                alphaSpace: true
            },

            'cgm[mae]': {
                maxlength: 45,
                //required: true,
                alphaSpace: true
            },

            'cgm[email]': {
                email: true,
                maxlength: 45
            },

            'cgm[nacionalidade_id]': {
                integer: true
            },

            'cgm[naturalidade]': {
                required: true,
                alphaSpace: true,
                maxlength: 45
            },

            'telefone[nome]': {
                required: true,
                maxlength: 18
            },

            'cgm[endereco][logradouro]': {
                required: true,
                alphaSpace: true,
                maxlength: 200
            },

            'cgm[endereco][numero]': {
                required: true,
                number: true,
                maxlength: 10
            },

            'cgm[endereco][complemento]': {
                //alphaSpace: true,
                maxlength: 100
            },

            'cgm[endereco][cep]': {
                //number: true,
                maxlength: 15
            },

            'cgm[endereco][bairro_id]': {
                required: true,
                integer: true
            },

            estado: {
                required: true,
                integer: true
            },

            cidade: {
                required: true,
                integer: true
            },

            'cgm[endereco][zona_id]': {
                required: true,
                integer: true
            }
        },
        //For custom messages
        /*messages: {
             nome_operadores:{
             required: "Enter a username",
             minlength: "Enter at least 5 characters"
         }
         },*/
        //Reponsavel por indicar em que guia do formulário existe preenchimento incorreto
        invalidHandler: function(e, validator) {
            if(validator.errorList.length) {
                $('#tabs').attr('data-tab-color', 'red');
                $('#tabs a[href="#' + jQuery(validator.errorList[0].element).closest(".tab-pane").attr('id') + '"]').tab('show');
            }
        },
        //Define qual elemento será adicionado
        errorElement : 'small',
        errorPlacement: function(error, element) {
            error.insertAfter(element.parent());
        },

        highlight: function(element, errorClass) {
            //console.log("Error");
            $(element).parent().parent().addClass("has-error");
        },

        unhighlight: function(element, errorClass, validClass) {
            //console.log("Sucess");
            $(element).parent().parent().removeClass("has-error");
        }
    });
})