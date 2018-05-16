<html>
<head>
    {{--Documento personalizado em 14/05/2018 @Gustavo--}}
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title>Ficha de inscrição</title>

    <style type="text/css">
        #body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
            margin-left: 15%;
        }

      /*  table { page-break-inside:auto; }
        tr    { page-break-inside:avoid; page-break-after:auto }
        thead { display:table-header-group }
        tfoot { display:table-footer-group }*/

        .table {
            display: block;
            margin-top: 5%;
            margin-right: 5%;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            border: 0.5px solid;
            border-collapse: collapse;    
        }

        .table tr, .table tr td  {
            border: 0.5px solid;

        }
        .table tr{
            width: 100%;
        }

        .table td {
            padding: 4px;

        }
        h2{
            font-size:13px;
        }
        h1{
            position:absolute;
            top: 80px;
            right:270px;
        }

      /*  #imagem-um {
            width: 90px;
            margin-left: 7%;
        }
*/
         /*#imagem-dois {
           width: 70px;
           margin-left: 13%;
       } */

    /*    #imagem-tres {
            width: 60px;
            margin-left: 13%;
        }*/

        #imagem-logo {
            width:15%; 
            display: block;
            position:relative;
            top: 50px;
            right: 92px;
        }
         #imagem-assinatura {
            width:50%; 
            display: block;
            left: 90px;
            right: auto;
        }
        .listra{
            width: 10px;
            height:1000px;
            background: firebrick;
            float:left;
            margin:5px;
            z-index: -10;
            margin-top: 100px;
        }
        #listra1{
            margin-left:48px;
        }
        #semi-borda{
            position:absolute;
            left: 330px;
            top:50px;
            width: 550px;
            height: 1047px;
            border:  2px solid;
            border-left: 0px;
            border-bottom: 0px;
            border-color:#bfbfbf; 
            z-index: -3;
            display: inline-block;
        }
        /*
        
        #header h1 {
            font-size: 12px;
            text-align: center;
            margin-top: 1%;
            margin-bottom: 5%;
        }

        #cursos {
            margin-top: 5%;
            margin-left: 5%;
        }

        #cursos table {
            font-weight: bold;
            width: 100%;
        }

        #pessoas h2 {
            margin-top: 5%;
            margin-left: 5%;
            margin-bottom: 1%;
            font-size: 12px;
        }

        #footer {
            position: absolute;
            bottom: 0;
            left: 5%;
            right: 5%;
        }*/
    </style>
</head>

<body> 
    <div id="listras">
        <div class="listra" id="listra1"></div>
        <div class="listra"></div>
        <div class="listra"></div>
    </div>
     <div id=semi-borda></div>
   

<div id="header">
    <br>
   

 
<!-- <img id="imagem-um" src="{{ asset('img/contrato-mestrado/image4.png') }}" alt="Logo"> -->
 <!--  {{-- <img id="imagem-tres" src="{{ asset('img/contrato-mestrado/image2.jpeg') }}" alt="Logo">--}}
  {{--<img id="imagem-dois" src="{{ asset('img/contrato-mestrado/image1.png') }}" alt="Logo">--}}
  <img id="imagem-quatro" src="{{ asset('img/contrato-mestrado/image3.jpeg') }}" alt="Logo"> -->

    <center><h1>FICHA DE INSCRIÇÃO</h1></center>
</div>
<img id="imagem-logo" src="{{ asset('img/logo_atenas_college.png') }}" alt="Logo">
<div id="body">
    <div id="cursos">
    <div id="pessoas">
        
        <h2 style="margin-left: 30px;"><b>DADOS PESSOAIS:</b></h2>
        <?php $sexo = $aluno['pessoa']['sexo']['nome']?>

        <table class="table" style="width: 700px; margin-top: 0; margin-bottom: 2%; margin-bottom: 70px;">
            <tr>
                <td colspan="6">NomeCompleto: {{ $aluno['pessoa']['nome'] }}</td>
            </tr>
            <tr>
                <td colspan="6">Email: {{ $aluno['pessoa']['email'] ?? '' }}</td>
            </tr>
            <tr>
                   <td colspan="6"><pre>Sexo:    Masculino ( {{ $sexo == 'Masculino' ? 'X' : ' ' }}  )           Feminino (  {{ $sexo == 'Feminino' ? 'X' : ' '  }}  )</pre></td>
            </tr>
            <tr>
                <td colspan="6">CPF: {{ $aluno['pessoa']['cpf'] ?? '' }}</td>
            </tr>
            <tr>
                <td colspan="6"><pre>Título de Eleitor Insc.nº                                                                 Zona:                          Seção:</pre></td>
            </tr>
            <tr>
                <td colspan="6">Reservista nº </td>
            </tr>
             <tr style="margin-top: 3px;">
                <td colspan="4"style="width: 80%;">Endereço: {{ $aluno['pessoa']['endereco']['logradouro'] ?? '' }}</td>
                <td colspan="2" >Nº {{ $aluno['pessoa']['endereco']['numero'] ?? '' }}</td>
            </tr>

            <tr>
                <td colspan="2" style="width: 30%;">BAIRRO: {{ $aluno['pessoa']['endereco']['bairro']['nome'] ?? '' }}</td>
                <td colspan="2" style="width: 45%;">Complemento: </td>
                <td colspan="2" style="width: 15%;">UF: {{$aluno['pessoa']['endereco']['bairro']['cidade']['estado']['prefixo'] ?? '' }}</td>
            </tr>

            <tr>
                <td colspan="3">Cidade: {{$aluno['pessoa']['endereco']['bairro']['cidade']['estado']['nome'] ?? '' }}</td>
                <td colspan="3">Cep: {{ $aluno['pessoa']['endereco']['cep'] ?? '' }}</td>
            </tr>

            <tr>
                 
                    <?php 
                        if(isset($aluno['pessoa']['telefone_fixo']) && isset($aluno['pessoa']['celular'])){
                            echo  "<b>"."<td colspan=\"3\">Telefones:".$aluno['pessoa']['telefone_fixo']." </td><td colspan=\"3\"> ".$aluno['pessoa']['celular']."</td></b>"; 
                        }else{ 
                    ?>
                     <td colspan="6">Telefones: 
                        <b>
                            {{ $aluno['pessoa']['telefone_fixo'] ?? ''}}
                            {{ $aluno['pessoa']['celular'] ?? '' }}
                        </b>
                    <?php } ?>            
                </td>
            </tr>
             <tr>
                <td colspan="2" style="width: 30%">R.G: {{ $aluno['pessoa']['identidade'] ?? '' }}</td>
                <td colspan="2">Data de expedição: {{ $aluno['pessoa']['data_expedicao'] ?? '' }}</td>
                <td colspan="2" style="width: 30%">Órgão emissor: {{ $aluno['pessoa']['orgao_rg'] ?? '' }}</td>
            </tr>
        </table>
    </div>
    <h2>SERVIÇOS DESEJADOS:</h2>
    <table class="table" style="width: 700px;margin-top: 0; margin-bottom: 2%; text-align: center;">
        <tr>
            <td colspan="2"><pre>(     ) Pós-graduação para mestrado</pre></td>
            <td colspan="2"><pre>(     ) Mestrado para Doutorado</pre></td>
            <td colspan="2"><pre>(     ) Revalidação Graduação</pre></td>
        </tr>
        <tr>
            <td colspan="3"><pre>(     ) Reconhecimento de Titulo  Mestrado</pre></td>
            <td colspan="3"><pre>(     ) Reconhecimento de Titulo de Doutorado</pre></td>
        </tr>               

    </table>


    <table class="table" style="width: 700px;margin-top: 40px; margin-bottom: 2%; text-align: justify;">
        <tr>
            <td><pre> Mestrado de Interesse:</pre></td>
        </tr>
        <tr>
            <td><pre> Área de pesquisa:</pre></td>
        </tr>
        <tr>
             <td><pre> Pólo:</pre></td>
        </tr>

    </table>


     <table class="table" style="width:700px;margin-top: 50px; margin-bottom: 2%; text-align: justify;">
        <tr>
            <td colspan="3" ><pre>Cor/Raça:</pre></td>
            <td colspan="3" ><pre>Ensino Médio Instituição        (      ) Privada    (       ) Pública</pre></td>
 </tr>
<tr>
<td colspan="4" > Graduação em: </td>
<td colspan="2" style="width: 20%;" > Ano de Conclusão:</td>
        </tr>
        <tr>
<td colspan="6" ><pre>Possui necessidades especiais: (     ) Sim(     ) Não </pre> </td>
        </tr>
        <tr>
             <td colspan="6" ><pre> Se sim, quais:</pre></td>
        </tr><tr>
             <td colspan="6" ><pre> Captador:</pre></td>
        </tr>

    </table>
</div>

<div style="font-size: 15px;"><b>
    <span style="display:block;">___________________,____/_______.</span>
    <span style="position:absolute; left:120px; bottom: 200px;"><pre>________________________________________
                Assinatura Do Candidato(a)</pre></span>
     <span style="position:absolute; right:30px; bottom: 200px;"><pre>________________________________________
                 Funcionário Responsável</pre></span>

</b></div>
<footer style=" text-align:justify;color:grey; position:absolute; bottom:0; left:320px;">
    <center>
    <img id="imagem-assinatura" src="{{ asset('img/assinatura_marcelo_barbosa_atenas.png') }}" alt="Logo">
    <span><pre>
        ATENAS COLLEGE
200 Continental Drive, Suite 401, Newark, Delaware, 19713
         Registro Federal: PI 5000094168
        Registro Estadual:EIN 37-1838647
          www.atenascollege.university
               </pre></span></center>
</footer>

</body>
</html>