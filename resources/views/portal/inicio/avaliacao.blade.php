@extends('portal.menuportal')

@section('banner')
    <div class="container">
        <h4 class="header white-text" style="margin-top: 5%;"><i class="material-icons left">android</i>ENGENHARIA DE SOFTWARE</h4>
        <p class="white-text"><i class="material-icons left">cached</i>Em Andamento</p>
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
            <div class="col s12">
                <h5>Avaliação Educacional</h5>
                <br>
                <ul class="collapsible popout" data-collapsible="accordion">
                    <li>
                        <div class="collapsible-header active"><i class="material-icons">class</i><b>Período Letivo - 2016.1</b></div>
                        <div class="collapsible-body" style="padding: 10px;">
                            <br>
                            <table class="bordered highlight centered">
                                <thead>
                                <tr>
                                    <th >Disciplina</th>
                                    <th >Status</th>
                                    <th >1ª Avaliação</th>
                                    <th >2ª Avaliação</th>
                                    <th >Final</th>
                                    <th >Média Final</th>
                                    <th >Faltas</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>AMBIENTES OPERACIONAIS</td>
                                    <td>APROVADO</td>
                                    <td>9,8</td>
                                    <td>7,3</td>
                                    <td>-</td>
                                    <td>8,5</td>
                                    <td>5</td>
                                </tr>
                                <tr>
                                    <td>PROCESSO DE NEGÓCIO EM TIC</td>
                                    <td>MATRICULADO</td>
                                    <td>10</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>0</td>
                                </tr>
                                <tr>
                                    <td>INTELIGÊNCIA ARTIFICIAL</td>
                                    <td>MATRICULADO</td>
                                    <td>9,8</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>2</td>
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
        </div>
    </div>
    <br><br>
@endsection