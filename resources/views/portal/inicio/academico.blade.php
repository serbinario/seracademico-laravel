@extends('portal.menuportal')

@section('banner')
    <div class="container">
        <h3 class="header white-text" style="margin-top: 5%;">Acadêmico</h3>
        <p class="white-text">Informações do seu curso para auxiliar sua formação</p>
    </div>

    <div class="parallax"><img src="{{ asset('/portal/img/aprovaçao-feliz.jpg')}}"></div>
@endsection

@section('container_index')
    <br>
    <a href="{{ route('seracademico.portal.dashboard') }}" class="waves-effect waves-light btn right"><i class="material-icons left">arrow_back</i>Voltar</a>
    <br><br>
    <hr/>
    <div class="section">

        <!--   Icon Section   -->
        <div class="row">
            <div class="col s12 m3">
                <div class="box-dash">
                    <div class="icon-block">
                        <h2 class="center light-blue-text"><img src="{{ asset('/portal/img/icons/png/clapperboard.png')}}" alt="" class="img-dash"></h2>
                        <h5 class="center">Disciplinas</h5>
                        <p class="center">Consulte e matricule-se em disciplinas</p>
                    </div>
                </div>
            </div>

            <div class="col s12 m3">
                <div class="box-dash">
                    <div class="icon-block">
                        <h2 class="center"><img src="{{ asset('/portal/img/icons/png/video-player-2.png')}}" alt="" class="img-dash"></h2>
                        <h5 class="center">Horários</h5>
                        <p class="center">Consulte o horário das disciplinas em que está cadastrado</p>
                    </div>
                </div>
            </div>

            <div class="col s12 m3">
                <div class="box-dash">
                    <div class="icon-block">
                        <h2 class="center light-blue-text"><img src="{{ asset('/portal/img/icons/png/film.png')}}" alt="" class="img-dash"></h2>
                        <h5 class="center">Notas</h5>
                        <p class="center">Consulte suas notas</p>
                    </div>
                </div>
            </div>

            <div class="col s12 m3">
                <div class="box-dash">
                    <div class="icon-block">
                        <h2 class="center light-blue-text"><a href="{{ route('seracademico.biblioteca.indexConsulta') }}"><img src="{{ asset('/portal/img/icons/png/video-player.png')}}" alt="" class="img-dash"></a></h2>
                        <h5 class="center">Biblioteca</h5>
                        <p class="center">Consulte nosso acerco e encontre o livro que você precisa</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br><br>
@endsection