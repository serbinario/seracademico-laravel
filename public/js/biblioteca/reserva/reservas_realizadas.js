/**
 * Created by Fabio Aguiar on 20/03/2017.
 */

$(document).ready(function () {

    function format(d) {

        var acervo = d['acervos'];
        var tipoEmprestimo = d['tipo_emprestimo'];
        var pessoaId = d['pessoas_id'];
        var reservaId = d['id'];
        var emprestimoEspecial = d['emprestimo_especial'];
        var qtdExempEmprestado = 0;
        var url = '/seracademico/biblioteca/saveEmprestimo';
        var tipoPessoa = d['tipo_pessoa'];
        var qtdEmprestimoAtual = d['qtdEmprestimos']['qtdEmprestimoAtual'];
        var qtdEmprestimoMaximo = d['qtdEmprestimos']['qtdEmprestimoMaximo'];

        var html = "<form action='"+url+"' id='form' method='post' target='_blank'>";
        html += "<table class='table table-bordered'>";
        html += "<thead>" +
            "<tr><td>Título</td><td>Subtitulo</td><td>Número de chamada</td><td>Exemplares disponíveis</td>" +
            "<td>Situação da fila</td><td>Empréstimos ativos</td><td>Selecionar</td></tr>" +
            "</thead>";

        for (var i = 0; i < acervo.length; i++) {

            //verificando a quantidade de exemplares já emprestados
            if(acervo[i]['status'] == '1') {
                qtdExempEmprestado++;
            }

            html += "<tr>";
            html += "<td>" + acervo[i]['titulo'] + "</td>";
            html += "<td>" + acervo[i]['subtitulo'] + "</td>";
            html += "<td>" + acervo[i]['numero_chamada'] + "</td>";
            html += "<td>" + acervo[i]['qtdExemplares'] + "</td>";

            // criando status para o primeiro da fila
            if (acervo[i]['status_fila'] == 1) {
                html += "<td>Aguardando</td>";
            } else {
                html += "<td></td>";
            }

            // Criando um status para caso do límite de empréstimo tenha cido atingindo
            if (qtdEmprestimoAtual == qtdEmprestimoMaximo && acervo[i]['status_fila'] == 1) {
                html += "<td>Limite de empréstimo atingido</td>";
            } else if (acervo[i]['status_fila'] == 1) {
                html += "<td>"+qtdEmprestimoAtual+"</td>";
            } else {
                html += "<td></td>";
            }


            if(acervo[i]['qtdExemplares'] == 0 || acervo[i]['status'] == '1' || acervo[i]['status_fila'] == '2'){
                html += "<td></td>";
            } else if (acervo[i]['qtdExemplares'] > 0 && acervo[i]['status'] == '0' && acervo[i]['status_fila'] == '1' 
                        && qtdEmprestimoAtual < qtdEmprestimoMaximo) {
                
                html += "<td><input class='acervo' type='checkbox' name='id[]' value='"+acervo[i]['acervo_id']+"'></td>";
                html += "<input type='hidden' name='edicao[]' value='"+acervo[i]['edicao']+"'>";
            }

            html += "</tr>";
        }

        html += "</table>";
        html += "<input type='hidden' name='tipo_emprestimo' value='"+tipoEmprestimo+"'>";
        html += "<input type='hidden' name='id_pessoa' value='"+pessoaId+"'>";
        html += "<input type='hidden' name='id_reserva' value='"+reservaId+"'>";
        html += "<input type='hidden' name='emprestimoEspecial' value='"+emprestimoEspecial+"'>";
        html += "<input type='hidden' name='tipo_pessoa' value='"+tipoPessoa+"'>";

        if(qtdExempEmprestado < acervo.length) {
            html += "<input type='submit' class='btn btn-primary' value='Confirmar'>";
        }

        html += "</form>";

        return  html;
    }

    var table = $('#sala-grid').DataTable({
        processing: true,
        serverSide: true,
        order: [[ 1, "asc" ]],
        ajax: '/index.php/seracademico/biblioteca/gridReservados',
        columns: [
            {
                "className":      'details-control',
                "orderable":      false,
                "data":           'pessoas.nome',
                "defaultContent": ''
            },
            {data: 'codigo', name: 'bib_reservas.codigo'},
            {data: 'data', name: 'bib_reservas.data'},
            {data: 'data_vencimento', name: 'bib_reservas.data_vencimento'},
            {data: 'nome', name: 'pessoas.nome'},
            {data: 'identidade', name: 'pessoas.identidade'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    // Add event listener for opening and closing details
    $('#sala-grid tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );

        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child( format(row.data()) ).show();
            tr.addClass('shown');
        }
    });
});

$(document).on('submit', '#form', function (event) {
    $(document).ready(function(){

        if(!$(".acervo").prop( "checked")) {
            bootbox.alert('Marque ao menos um livro para empréstimo!');
            event.preventDefault();
        } else {
            setTimeout(explode, 1000);
        }
    });

    function explode(){
        location.reload();
    }
});