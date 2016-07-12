<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Gestão Acadêmica</title>

    <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('/font-awesome/css/font-awesome.css')}}" rel="stylesheet">
    <link href="{{ asset('/css/select2.min.css')}}" rel="stylesheet">
    <link href="{{ asset('/css/animate.css')}}" rel="stylesheet">
    <link href="{{ asset('/css/style.css')}}" rel="stylesheet">
    <link href="https://code.jquery.com/ui/1.11.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('/css/jquery.tree.css')  }}" rel="stylesheet">
    <link href="{{ asset('/css/jasny-bootstrap.css')  }}" rel="stylesheet">
    <link href="{{ asset('/css/awesome-bootstrap-checkbox.css')  }}" rel="stylesheet">
    <link href="{{asset('/css/bootstrapValidation.mim.css')}}" rel="stylesheet">
    <link href="{{asset('/css/jquery.datetimepicker.css')}}" rel="stylesheet"/>

    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">


    @yield('css')
</head>

<body>

<div id="wrapper">
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <img alt="image" class="logoDash" src="{{ asset('/img/logoser2.png')}}"/>
                </li>
                <li>
                    <a href="index.html"><i class="fa fa-th-large"></i> <span class="nav-label">Secretaria</span> <span
                                class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="{{ route('seracademico.aluno.index') }}">Alunos</a></li>
                    </ul>
                </li>
                <li>
                    <a href="index.html"><i class="fa fa-th-large"></i> <span class="nav-label">Cadastros</span> <span
                                class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                       <li><a href="{{ route('seracademico.user.index') }}">Usuários</a></li>
                    </ul>
                </li>
            </ul>

        </div>
    </nav>

    <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i>
                    </a>
                </div>
                <div class="profile-img">
                    <span>
                        @if(isset(Session::get("user")['img']))
                            <img alt="image" class="img-circle" src="{{asset('/uploads/fotos/'.Session::get("user")['img'])}}" alt="Foto"  height="50" width="50">
                        @endif
                    </span>
                </div>
                <ul class="nav navbar-top-links navbar-right">
                    <li>
                        <div class="dropdown">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                             <span class="text-muted text-xs block">Usuário<b class="caret"></b></span></a>
                            <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                <li><a href="profile.html">Perfil</a></li>
                                <li><a href="contacts.html">Notificações</a></li>
                                <li class="divider"></li>
                                <li><a href="{{ url('auth/logout') }}">Logout</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Mainly scripts -->
<script src="{{ asset('/js/jquery-2.1.1.js')}}"></script>
<script src="{{ asset('/js/jquery-ui.js')}}"></script>
<script src="{{ asset('/js/select2.full.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('/js/bootstrap.min.js')}}"></script>
<script src="{{ asset('/js/plugins/metisMenu/jquery.metisMenu.js')}}"></script>
<script src="{{ asset('/js/plugins/toastr.min.js')}}"></script>
<script src="{{ asset('/js/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>
<script src="{{ asset('/js/bootstrapvalidator.js')}}" type="text/javascript"></script>
<script src="{{ asset('/js/jquery.tree.js')}}" type="text/javascript"></script>
<script src="{{ asset('/js/jquery.datetimepicker.js')}}" type="text/javascript"></script>

<script src="{{ asset('/js/jquery.dataTables.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('/js/dataTables.buttons.min.js')}}" type="text/javascript"></script>

<script src="{{ asset('/vendor/datatables/buttons.server-side.js') }}"></script>

<!-- Custom and plugin javascript -->
<script src="{{ asset('/js/inspinia.js')}}"></script>
<script src="{{ asset('/js/plugins/pace/pace.min.js')}}"></script>
<script src="{{ asset('/js/jasny-bootstrap.js')}}"></script>
<script src="{{ asset('/js/jquery.mask.js')}}"></script>
<script src="{{ asset('/js/mascaras.js')}}"></script>
@yield('javascript')
</body>

</html>