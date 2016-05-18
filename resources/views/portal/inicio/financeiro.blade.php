@extends('portal.menuportal')

@section('banner')
    <div class="container">
        <h3 class="header white-text" style="margin-top: 5%;">Financeiro</h3>
        <p class="white-text">Informações financeiras</p>
    </div>

    <div class="parallax"><img src="{{ asset('/portal/img/estudantes.jpg')}}"></div>
@endsection

@section('container_index')
    <br>
    <a href="{{ route('seracademico.portal.dashboard') }}" class="waves-effect waves-light btn right"><i
                class="material-icons left">arrow_back</i>Voltar</a>
    <br><br>
    <hr/>
    <div class="section">
        <!--   Icon Section   -->
        <div class="row">
            <div class="col s12 m4">
                <div class="box-dash">
                    <div class="icon-block">
                        <h2 class="center light-blue-text"><img src="{{ asset('/portal/img/icons/pen.png')}}" alt="" class="img-dash">
                        </h2>
                        <h5 class="center">Boletos</h5>
                        <p class="center">Consulte e gerencie seus boletos pagos e a pagar</p>
                    </div>
                </div>
            </div>

            {{--<div class="col s12 m4">
                <div class="box-dash">
                    <div class="icon-block">
                        <h2 class="center"><img src="{{ asset('/portal/img/icons/pen.png')}}" alt="" class="img-dash"></h2>
                        <h5 class="center">Guias</h5>
                        <p class="center">Tenha acesso a guias enviados pelo financeiro</p>
                    </div>
                </div>
            </div>

            <div class="col s12 m4">
                <div class="box-dash">
                    <div class="icon-block">
                        <h2 class="center light-blue-text"><img src="{{ asset('/portal/img/icons/money.png')}}" alt="" class="img-dash">
                        </h2>
                        <h5 class="center">Taxas</h5>
                        <p class="center">Gerencie o pagamento de taxas extras</p>
                    </div>
                </div>
            </div>--}}
        </div>
    </div>
    <br><br>
@endsection