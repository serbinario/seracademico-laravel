@extends('portal.menuportal')

@section('banner')
    <div class="container">
        <h4 class="header white-text" style="margin-top: 5%;"><i class="material-icons left">android</i>ENGENHARIA DE SOFTWARE</h4>
        <p class="white-text">Em Andamento</p>
    </div>

    <div class="parallax"><img src="{{ asset('/portal/img/strategy.jpg')}}"></div>
@endsection

@section('container_index')
    <br>
    <a href="{{ route('seracademico.portal.academico') }}" class="waves-effect waves-light btn right"><i class="material-icons left">arrow_back</i>Voltar</a>
    <br><br>
    <hr/>

    <div class="section">

        <!--   Icon Section   -->
        <div class="row">
            <div class="col s12 m8">
                <h5>Grade Curricular</h5>
                <br>
                <ul class="collapsible popout" data-collapsible="accordion">
                    <li>
                        <div class="collapsible-header active"><i class="material-icons">class</i><b>1º Período</b></div>
                        <div class="collapsible-body" style="padding: 10px;">
                            <br>
                            <table class="bordered highlight">
                                <thead>
                                <tr>
                                    <th >Código</th>
                                    <th >Disciplina</th>
                                    <th >Tipo</th>
                                </tr>
                                </thead>

                                <tbody>
                                <tr>
                                    <td>EGH 1321</td>
                                    <td>AMBIENTES OPERACIONAIS</td>
                                    <td>OBRIGATÓRIA</td>
                                </tr>
                                <tr>
                                    <td>EGH 1671</td>
                                    <td>MATEMÁTICA APLICADA</td>
                                    <td>OPCIONAL</td>
                                </tr>
                                <tr>
                                    <td>EGH 5643</td>
                                    <td>INTRODUÇÃO À PEDAGOGIA</td>
                                    <td>OPCIONAL</td>
                                </tr>

                                </tbody>
                            </table>
                            <br>
                        </div>
                    </li>
                    <li>
                        <div class="collapsible-header"><i class="material-icons">class</i><b>2º Período</b></div>
                        <div class="collapsible-body"><p>Lorem ipsum dolor sit amet.</p></div>
                    </li>
                    <li>
                        <div class="collapsible-header"><i class="material-icons">class</i><b>3º Período</b></div>
                        <div class="collapsible-body"><p>Lorem ipsum dolor sit amet.</p></div>
                    </li>
                </ul>
            </div>

            <div class="col s12 m4">
                <h5>Professores</h5>
                <br>
                <ul class="collection">
                    <li class="collection-item avatar">
                        <img src="../img/photo.png" alt="" class="circle">
                        <span class="title">Carlos Augusto</span>
                        <p>Informática Aplicada<br>
                            Computação
                        </p>
                        <a href="#!" class="secondary-content"><i class="material-icons">launch</i></a>
                    </li>
                    <li class="collection-item avatar">
                        <img src="../img/photo.png" alt="" class="circle">
                        <span class="title">Milena Santos</span>
                        <p>Banco de Dados<br>
                            Redes Neurais, Inteligência Artificial
                        </p>
                        <a href="#!" class="secondary-content"><i class="material-icons">launch</i></a>
                    </li>
                    <li class="collection-item avatar">
                        <img src="../img/photo.png" alt="" class="circle">
                        <span class="title">Dilermando Silva</span>
                        <p>Computação Gráfica<br>
                            Redes, Jogos
                        </p>
                        <a href="#!" class="secondary-content"><i class="material-icons">launch</i></a>
                    </li>
                    <li class="collection-item avatar">
                        <img src="../img/photo.png" alt="" class="circle">
                        <span class="title">Paula Santos</span>
                        <p>Libras<br>
                            Letras, Inglês Instrumental
                        </p>
                        <a href="#!" class="secondary-content"><i class="material-icons">launch</i></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <br><br>
@endsection