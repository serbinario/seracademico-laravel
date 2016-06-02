@extends('portal.menuportal')

@section('banner')
    <div class="container">
        <h3 class="header white-text" style="margin-top: 5%;">Secretaria</h3>
        <p class="white-text">Informações Documentais</p>
    </div>

    <div class="parallax"><img src="{{ asset('/portal/img/cadastro-b2bb5424ab1094597f584241829d6d1f.jpg')}}"></div>
@endsection

@section('container_index')
    <br>
    <a href="{{ route('seracademico.portal.dashboard') }}" class="waves-effect waves-light btn right"><i class="material-icons left">arrow_back</i>Voltar</a>
    <br><br>
    <hr/>
    <div class="section">

        <!--   Icon Section   -->
        <div class="row">
            <div class="col s12 m4">
                <div class="box-dash">
                    <div class="icon-block">
                        <h2 class="center light-blue-text"><img src="{{ asset('/portal/img/icons/png/focus.png')}}" alt="" class="img-dash"></h2>
                        <h5 class="center">Documentos</h5>
                        <p class="center">Cadastre ou atualize seus documentos</p>
                    </div>
                </div>
            </div>

            <div class="col s12 m4">
                <div class="box-dash">
                    <div class="icon-block">
                        <h2 class="center"><img src="{{ asset('/portal/img/icons/png/webcam.png')}}" alt="" class="img-dash"></h2>
                        <h5 class="center">Declarações</h5>
                        <p class="center">Solicite declarações de vínculo e outras</p>
                    </div>
                </div>
            </div>

            <div class="col s12 m4">
                <div class="box-dash">
                    <div class="icon-block">
                        <h2 class="center light-blue-text"><img src="{{ asset('/portal/img/icons/png/photography.png')}}" alt="" class="img-dash"></h2>
                        <h5 class="center">Relacionamento</h5>
                        <p class="center">Entre com contato</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <br><br>
@endsection