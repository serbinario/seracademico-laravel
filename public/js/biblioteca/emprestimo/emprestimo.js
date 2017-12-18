/**
 * Created by Fabio Aguiar on 20/03/2017.
 */

$("#pessoa").select2();

//Vaariáveis globais
var id_emp1 = "";
var id_emp2 = "";
var idGraduacao = "";
var idPos = "";
var idProfessor = "";
var confirmacaoTermo = "";

var table = $('#sala-grid').DataTable({
    processing: true,
    serverSide: true,
    iDisplayLength: 5,
    bLengthChange: false,
    ajax: '/index.php/seracademico/biblioteca/gridEmprestimo',
    columns: [
        {data: 'titulo', name: 'bib_arcevos.titulo'},
        {data: 'cdd', name: 'bib_arcevos.cdd'},
        {data: 'cutter', name: 'bib_arcevos.cutter'},
        {data: 'subtitulo', name: 'bib_arcevos.subtitulo'},
        {data: 'edicao', name: 'bib_exemplares.edicao'},
        {data: 'tombo', name: 'bib_exemplares.codigo'},
        {data: 'nome_sit', name: 'bib_emprestimo.nome'},
        {data: 'nome_emp', name: 'bib_emprestimo.nome'},
        {data: 'codigo_barra', name: 'bib_exemplares.codigo_barra'},
        {data: 'tipo_acervo', name: 'bib_tipos_acervos.nome'},
        {data: 'action', name: 'action', orderable: false, searchable: false}
    ]
});


// Adicionar um exemplar para empréstimo
$('#sala-grid tbody').on('click', '.add', function (event) {
    event.preventDefault();

    if ($(this).parent().parent().hasClass('selected')) {
        $(this).parent().parent().removeClass('selected');
        return false;
    }
    else {
        table.$('tr.selected').removeClass('selected');
        $(this).parent().parent().addClass('selected');
    }

    var data = table.rows('.selected').data()[0];
    var html = "";

    if($('#emprestimos tbody tr').length <= 0) {
        id_emp1 = "";
        id_emp2 = "";
        $('#id_emprestimo').val("");
    }

    if(data['id_emp'] == '1'){ id_emp1 = data['id_emp']; $('#id_emprestimo').val(id_emp1);}
    if(data['id_emp'] == '2'){ id_emp2 = data['id_emp']; $('#id_emprestimo').val(id_emp2);}

    if(id_emp1 && id_emp2) {
        if(data['id_emp'] == '1'){ id_emp1 = ""; $('#id_emprestimo').val(id_emp2)}
        if(data['id_emp'] == '2'){ id_emp2 = ""; $('#id_emprestimo').val(id_emp1)}
        bootbox.alert("Vocẽ selecionou exemplares tanto de consulta quanto para empréstimo, decida apenas entre um dos dois tipo!");
        return false;
    }

    dadosAjax = {
        'tipo_emprestimo': data['id_emp'],
        'id': data['id'],
        'acervo_id': data['acervo_id'],
        'titulo': data['titulo'],
        'cutter': data['cutter'],
        'pessoas_id': $('#pessoa').val(),
        'pessoas_nome': $('select[name=pessoas_id] option:selected').text(),
        'tipo_pessoa': $('#tipo_pessoa').val(),
        'emprestimo_especial': $('#emprestimoEspecial').is(":checked") ? '1' : '0'
    };

    if (!$('#pessoa').val()) {
        bootbox.alert("Você deve selecionar um aluno!");
        return false;
    } else {

        jQuery.ajax({
            type: 'POST',
            url: "/index.php/seracademico/biblioteca/dataDevolucaoEmprestimo",
            data: dadosAjax,
            datatype: 'json'
        }).done(function (retorno) {

            if(retorno[2] == false) {
                bootbox.alert(retorno[1]);
                return false;
            }

            $('#emprestimos tbody tr').remove();
            for(var i = 0; i < retorno[3].length; i++){
                html += "<tr>";
                html += "<td>" + retorno[3][i]['titulo'] + "</td>";
                html += "<td>" + retorno[3][i]['cutter'] + "</td>";
                html += "<td>" + retorno[3][i]['subtitulo'] + "</td>";
                html += "<td>" + retorno[3][i]['edicao'] + "</td>";
                html += "<td>" + retorno[3][i]['tombo'] + "</td>";
                html += "<td>" +
                    "<button type='button' data='"+retorno[3][i]['emprestimo_id']+"' data2='"+retorno[3][i]['id']+"' class='btn-floating remove' onclick='RemoveTableRow(this)'  title='Deletar'><i class='fa fa-times'></i></button></li></td>" +
                    "<input type='hidden' name='id_emp' value='"+retorno[3][i]['emprestimo_id']+"'>";
                html += "</tr>";
            }

            $('#emprestimos tbody').append(html);
            $('#data').val(retorno[0]);
        });
    }
});

//Excluir tr da tabela
(function ($) {
    RemoveTableRow = function (handler) {
        var tr = $(handler).closest('tr');

        tr.fadeOut(400, function () {
            tr.remove();
        });

        return false;
    };
})(jQuery);

// Carregar os empréstimos pendentes
$(document).ready(function(){

    $('.continuar').click(function(event){
        event.preventDefault();

        var idPessoa = $(this).attr('data');

        jQuery.ajax({
            type: 'POST',
            url: "/index.php/seracademico/biblioteca/findWhereEmprestimo",
            datatype: 'json',
            data: {'id_pessoa' : idPessoa},
        }).done(function (retorno) {

            var html= "";
            if(retorno.length > 0 ) {

                // var emprestimos = retorno[0]['emprestimo_exemplar'];
                var pessoaId = retorno[0]['pessoa_id'];
                var pessoaNome = retorno[0]['pessoa_nome'];

                $('#emprestimos tbody tr').remove();
                for (var i = 0; i < retorno.length; i++) {
                    html += "<tr>";
                    html += "<td>" + retorno[i]['titulo'] + "</td>";
                    html += "<td>" + retorno[i]['cutter'] + "</td>";
                    html += "<td>" + retorno[i]['subtitulo'] + "</td>";
                    html += "<td>" + retorno[i]['edicao'] + "</td>";
                    html += "<td>" + retorno[i]['tombo'] + "</td>";
                    html += "<td>" +
                        "<button type='button' data='"+retorno[i]['emprestimo_id']+"' data2='"+retorno[i]['id']+"' class='btn-floating remove' onclick='RemoveTableRow(this)'  title='Deletar'><i class='fa fa-times'></i></button></li></td>" +
                        "<input type='hidden' name='id_emp' value='"+retorno[i]['emprestimo_id']+"'>";
                    html += "</tr>";
                }

                var option = "<option selected value='"+pessoaId+"'>"+pessoaNome+"</option>";

                $('#pessoa option').remove();
                $('#pessoa').append(option);

                select2(retorno[0]['tipo_pessoa']);

                $('#emprestimos tbody').append(html);

                if(retorno[0]['emprestimo_especial'] == '1') {
                    $('#emprestimoEspecial').prop('checked', true);
                } else {
                    $('#emprestimoEspecial').prop('checked', false);
                }

                $( "#tipo_pessoa option" ).each(function() {
                    if($(this).val() == retorno[0]['tipo_pessoa']) {
                        $(this).prop('selected', true);
                    }
                });
            }

        });
    });

});

//Generico para os selects2
function formatRepoSelection(repo) {

    idGraduacao = repo.id_graduacao;
    idPos       = repo.id_pos;
    idProfessor = repo.id_professor;

    return repo.text
}

// Função para chamar o select dois
function select2(tipo){

    //consulta via select2 responsável
    $("#pessoa").select2({
        placeholder: 'Selecione uma pessoa',
        minimumInputLength: 1,
        templateSelection: formatRepoSelection,
        width: 400,
        ajax: {
            type: 'POST',
            url: "/index.php/seracademico/util/queryByselect2Pessoa",
            dataType: 'json',
            delay: 250,
            crossDomain: true,
            data: function (params) {
                return {
                    'search':     params.term, // search term
                    'tableName':  'pessoas',
                    'fieldName':  'nome',
                    'parametro':  tipo,
                    'page':       params.page
                };
            },
            processResults: function (data, params) {

                // parse the results into the format expected by Select2
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data, except to indicate that infinite
                // scrolling can be used
                params.page = params.page || 1;

                return {
                    results: data.data,
                    pagination: {
                        more: (params.page * 30) < data.total_count
                    }
                };
            }
        }
    });
}

// Tratar os tipos de aluoos a serem selecionados
$(document).on('change', '#tipo_pessoa', function (event) {

    var tipo = $(this).val();

    if(tipo) {

        if(tipo == 2 || tipo == 3) {
            $('#emprestimoEspecial').prop('checked', true);
        } else {
            $('#emprestimoEspecial').prop('checked', false);
        }

        select2(tipo);
    } else {
        $("#pessoa").select2();
    }

});

// Confirmação do empréstimo
$(document).on('submit', '#form', function (event) {
    $(document).ready(function(){

        if($("#tipo_pessoa").val() == '3' && !$("#emprestimoEspecial").prop( "checked")) {
            bootbox.alert('Esse empréstimos deve ser do tipo especial');
            event.preventDefault();
        } else if($('#emprestimos tbody tr').length <= 0){
            bootbox.alert('você deve selecionar pelo menos um exemplar');
            event.preventDefault();
        } else if(confirmacaoTermo == '1'){
            bootbox.alert('Essa pessoa precisa assinar o termo');
            event.preventDefault();
        } else {
            setTimeout(explode, 1000);
            $( "#tipo_pessoa option" ).each(function() {
                $(this).prop('selected', false);
            });
        }
    });

    function explode(){
        location.reload();
    }
});

// Submeter form modal
$(document).on('submit', '#formModal', function (event) {
    $(document).ready(function(){
        setTimeout(explode, 1000);
        $( "#tipo_pessoa option" ).each(function() {
            $(this).prop('selected', false);
        });
    });

    function explode(){
        location.reload();
    }
});

// Remover um exemplar do empréstimo
$(document).on('click', 'button.remove', function (event) {
    event.preventDefault();
    var id = $(this).attr('data');
    var id2 = $(this).attr('data2');
    jQuery.ajax({
        type: 'get',
        url: "/index.php/seracademico/biblioteca/deleteEmprestimo/"+id+"/"+id2,
        datatype: 'json'
    }).done(function (retorno) {

    });
});

// Assinar termo
$(document).on('change', '#pessoa', function (event) {
    event.preventDefault();
    var idPessoa = $(this).val();
    var tipoPessoa = $('#tipo_pessoa').val();
    var idAlunoProfessor = "";

    if(tipoPessoa == '1') {
        var idAlunoProfessor = idGraduacao;
    } else if (tipoPessoa == '2' || tipoPessoa == '3') {
        var idAlunoProfessor = idPos;
    } else if (tipoPessoa == '4') {
        var idAlunoProfessor = idProfessor;
    }

    if (idPessoa && tipoPessoa && idAlunoProfessor) {

        jQuery.ajax({
            type: 'POST',
            url: "/index.php/seracademico/biblioteca/validarTermoBiblioteca",
            data: {
                'id_pessoa' : idPessoa,
                'tipo_pessoa' : tipoPessoa,
                'idAlunoProfessor' : idAlunoProfessor
            },
            datatype: 'json'
        }).done(function (retorno) {
            if(retorno == '1') {
                $('#tipoPessoa').val(tipoPessoa);
                $('#idAlunoProfessor').val(idAlunoProfessor);
                $("#modal-assinar-termo").modal({show:true});
                confirmacaoTermo = retorno;
                //bootbox.alert('Esta pessoa ainda não assinou o termo');
            } else {
                confirmacaoTermo = retorno;
            }
        });
    }

});
