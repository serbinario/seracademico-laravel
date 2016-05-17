@extends('portal.menuportal')

@section('banner')
    <div class="container">
        <h3 class="header white-text" style="margin-top: 5%;">Portal do Estudante</h3>
        <p class="white-text">Seu lugar de estudos</p>
    </div>
    <div class="parallax"><img src="{{ asset('/portal/img/estudante.jpg')}}"></div>
@endsection

@section('container_index')
    <br>
    <div class="section">
        <!--   Icon Section   -->
        <div class="row">
            <div class="col s12 m4">

                <div class="box-dash">
                    <div class="icon-block">
                        <a href="{{ route('seracademico.portal.academico') }}" style="color: #283277;">
                            <h2 class="center light-blue-text"><img src="{{ asset('/portal/img/icons/png/polaroid.png')}}" alt="" class="img-dash"></h2>
                            <h5 class="center">Acadêmico</h5>
                        </a>
                        <p>We did most of the heavy lifting for you to provide a default stylings that incorporate our custom components. Additionally, we refined animations and transitions to provide a smoother experience for developers.</p>
                    </div>
                </div>
            </div>

            <div class="col s12 m4">
                <div class="box-dash">
                    <div class="icon-block">
                        <a href="{{ route('seracademico.portal.financeiro') }}" style="color: #283277;">
                            <h2 class="center light-blue-text"><img src="{{ asset('/portal/img/icons/png/video-player-3.png')}}" alt="" class="img-dash"></h2>
                            <h5 class="center">Financeiro</h5>
                        </a>
                        <p>We did most of the heavy lifting for you to provide a default stylings that incorporate our custom components. Additionally, we refined animations and transitions to provide a smoother experience for developers.</p>
                    </div>
                </div>
            </div>

            <div class="col s12 m4">
                <div class="box-dash">
                    <div class="icon-block">
                        <a href="{{ route('seracademico.portal.secretaria') }}" style="color: #283277;">
                            <h2 class="center light-blue-text"><img src="{{ asset('/portal/img/icons/png/film-1.png')}}" alt="" class="img-dash"></h2>
                            <h5 class="center">Secretaria</h5></a>

                        <p>We did most of the heavy lifting for you to provide a default stylings that incorporate our custom components. Additionally, we refined animations and transitions to provide a smoother experience for developers.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br><br>
@endsection