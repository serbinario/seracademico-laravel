@extends('portal.menuportal')

@section('banner')
    <div class="container">
        <h3 class="header white-text" style="margin-top: 5%;">Boletos</h3>
        <p class="white-text">Consulte e gere os seus boletos</p>
    </div>

    <div class="parallax"><img src="{{ asset('/portal/img/estudantes.jpg')}}"></div>
@endsection

@section('container_index')
    <br>
    <a href="{{ route('seracademico.portal.dashboard') }}" class="waves-effect waves-light btn right"><i class="material-icons left">arrow_back</i>Voltar</a>
    <br><br>
    <hr/>
    <div class="section">

        <!--   Icon Section   -->
        <div class="row">
            <div class="col s12">
                <h5>Boletos</h5>
                <br>
                <table class="bordered highlight ">
                    <thead>
                    <tr>
                        <th data-field="id">Nome</th>
                        <th data-field="id">Vencimento</th>
                        <th data-field="id">Tipo</th>
                        <th data-field="name">Status</th>
                        <th data-field="price">Gerar</th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr>
                        <td>Mensalidade</td>
                        <td>28/04/2016</td>
                        <td>Mensalidade</td>
                        <td>Pago</td>
                        <td><a class="btn"><i class="material-icons">check_circle</i></a></td>
                    </tr>
                    <tr>
                        <td>Mensalidade</td>
                        <td>28/05/2016</td>
                        <td>Mensalidade</td>
                        <td>Aberta</td>
                        <td><a class="btn"><i class="material-icons">description</i></a></td>
                    </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <br><br>
@endsection