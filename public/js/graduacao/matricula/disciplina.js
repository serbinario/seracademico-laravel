// Tabela de disciplinas
var tableDisciplina;

// Função para carregamento do tableDisciplina
function loadTableDisciplina(idAluno)
{
    // Carregando a tabela de disciplina
    tableDisciplina = $('#disciplina-grid').on( 'init.dt', function ( e, settings, data ) {
        if(data.data.length > 0) {
            $('#nomeCurso').text(data.data[0].nomeAluno + ' - ' +data.data[0].nomeCurso);
        } else {
            $('#nomeCurso').text("Nenhuma disciplina encontrada para esse aluno");
        }
    }).DataTable({
        processing: true,
        serverSide: true,
        autoWidth: false,
        retrieve: true,
        ajax: "/index.php/seracademico/matricula/gridDisciplina/" + idAluno,
        columns: [
            {data: 'codigo', name: 'fac_disciplinas.codigo'},
            {data: 'nome', name: 'fac_disciplinas.nome'},
            {data: 'periodo', name: 'fac_curriculo_disciplina.nome'}
        ]
    });
}

// evento para escolher as disciplinas
$(document).on('click', '#disciplina-grid tbody tr', function () {
    // Aplicando o estilo css
    if($(this).find("td").hasClass("row_selected")) {
        $(this).find("td").removeClass("row_selected");
    } else {
        $(this).find("td").addClass("row_selected");
    }
});

// Evento para quando clicar na tr da table de disciplinas
$(document).on('click', '#disciplina-grid tbody tr', function () {
    // Array que armazenará os ids das disciplinas
    var arrayId   = [];

    // Varrendo as linhas
    $("#disciplina-grid tbody tr td.row_selected").parent().each(function (index, value) {
        arrayId[index] = tableDisciplina.row($(value).index()).data().id;
    });

    // Fazendo a requisição ajax
    jQuery.ajax({
        type: 'POST',
        data: {"dados" : arrayId},
        url: '/index.php/seracademico/matricula/getTurmas',
        datatype: 'json'
    }).done(function (retorno) {// validado as disciplinas do currículo
        // Verificando o retorno da requisição
        if(retorno.success) {
            // Variável que armazenará o objeto tree e os nós
            var zTreeObj, zNodes = [];

            // Variável que armazenará as Configurações
            var setting = {
                callback: {
                    beforeCollapse: beforeCollapse,
                    onDblClick: onDblClick
                }
            };

            // Criando os nós
            $.each(retorno.dados, function (index, value) {
                // Variável que armazenará as turmas
                var turmas  =[];

                $.each(value.turmas, function (index1, value1) {
                    // Variável que armazenará os horários
                    var horarios = [];

                    // Carregando os horários
                    $.each(value1.horarios, function (index2, value2) {
                        horarios[index2] = {
                            name: value2.nomeDia + " - " + value2.codigoHora + " : " + value2.hora_inicial + " ás " + value2.hora_final,
                            icon: "img/plugins/zTree/diy/3.png"
                        };
                    });

                    // Criando o nó da turma e adicionando à arvore
                    turmas[index1] = {
                        id : value1.idTurmaDisciplina,
                        name : value1.codigoTurma + " - " + value1.nomeTurma,
                        idDisciplina: value.idDisciplina,
                        open:true,
                        collapse:false,
                        icon:"/img/plugins/zTree/diy/6.png",
                        children: horarios
                    };
                });

                // Criando o nó pricipal (Disciplina)
                zNodes[index] = {
                    name : value.codigoDisciplina + " - " +value.nomeDisciplina,
                    open:true,
                    collapse:false,
                    icon:"/img/plugins/zTree/diy/2.png",
                    children: turmas
                };
            });

            // Criando a árvore e recuperando o objeto ztree
            zTreeObj = $.fn.zTree.init($("#ztree"), setting, zNodes);
        } else {
            // Retorno caso não tenha currículo em uma turma ou algum erro
            swal(retorno.msg, "Click no botão abaixo!", "error");
        }
    });
});
