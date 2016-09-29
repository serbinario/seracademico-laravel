<!DOCTYPE html>
<html ng-app="seracademico">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SerAcadêmico - Gestão Acadêmica</title>

    <link href="{{ asset('/css/bootstrap.min.css')}}" rel="stylesheet">
    {{--<link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">--}}

    <link href="{{ asset('/fonts/iconfont/material-icons.css')}}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700,900,300" rel="stylesheet">
    <link href="{{ asset('/font-awesome/css/font-awesome.css')}}" rel="stylesheet">
    <link href="{{ asset('/css/select2.min.css')}}" rel="stylesheet">
    <link href="{{ asset('/css/animate.css')}}" rel="stylesheet">
    <link href="{{ asset('/css/style.css')}}" rel="stylesheet">

    <link href="{{ asset('/css/jquery-ui.css')}}" rel="stylesheet">
    {{--<link href="https://code.jquery.com/ui/1.11.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet" type="text/css">--}}

    {{--Fontes personalizadas--}}
    <link href="{{ asset('/fonts/pkt4/font/flaticon.css')}}" rel="stylesheet">

    <link href="{{ asset('/css/jquery.tree.css')  }}" rel="stylesheet">
    {{--<link href="{{ asset('/css/jasny-bootstrap.css')  }}" rel="stylesheet">--}}
    <link href="{{ asset('/css/awesome-bootstrap-checkbox.css')  }}" rel="stylesheet">
    <link href="{{ asset('/css/bootstrapValidation.mim.css')}}" rel="stylesheet">
    <link href="{{ asset('/css/jquery.datetimepicker.css')}}" rel="stylesheet"/>

    <link href="{{ asset('/css/jquery.dataTables.min.css')}}" rel="stylesheet"/>
    {{--<link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">--}}

    <link href="{{ asset('/css/buttons.dataTables.min.css')}}" rel="stylesheet"/>
    {{--<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">--}}

    <link rel="stylesheet" href="{{ asset('/css/plugins/sweetalert/sweetalert.css')  }}">
    <link rel="stylesheet" href="{{ asset('/css/plugins/botao/botao-fab.css')  }}">
    <link rel="stylesheet" href="{{ asset('/css/bootstrap-multiselect.css')  }}">

    <!-- Krajee -->
    <link rel="stylesheet" href="{{ asset('/css/plugins/Krajee/fileinput.min.css')  }}">

    <!-- zTree-->
    <link rel="stylesheet" href="{{ asset('/css/plugins/zTree/zTreeStyle.css')  }}">
    {{--<link rel="stylesheet" href="{{ asset('/css/plugins/zTree/demo.css')  }}">--}}


    <!-- Include Date Range Picker http://www.daterangepicker.com/#examples -->
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />

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

                @role('posgraduacao')
                <li>
                    <a href="index.html"><i class="material-icons">school</i> <span class="nav-label">Pós-Graduação</span> <span
                                class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li>
                            <a href="#"><i class="material-icons">style</i> Secretaria <span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level">
                                <li><a href="{{ route('seracademico.posgraduacao.aluno.index') }}"><i class="fa fa-users"></i>Alunos</a></li>
                                <li><a href="{{ route('seracademico.posgraduacao.disciplina.index') }}"><i class="material-icons">collections_bookmark</i> Disciplinas</a></li>
                                <li><a href="{{ route('seracademico.posgraduacao.curso.index') }}"><i class="material-icons">next_week</i> Cursos</a></li>
                                <li><a href="{{ route('seracademico.posgraduacao.curriculo.index') }}"><i class="material-icons">library_books</i> Currículos</a></li>
                                <li><a href="{{ route('seracademico.posgraduacao.turma.index') }}"><i class="material-icons">turned_in</i> Turmas</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="#"><i class="flaticon-exam-2"></i> Relatórios <span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level collapse">
                                <li><a href="{{ route('seracademico.posgraduacao.aluno.reportViewGeralAlunoCandidato') }}"><i class="flaticon-employment-test"></i> Geral de Alunos e Candidatos</a></li>
                                {{--<li><a targt="_blank" href="{{ route('seracademico.vestibular.relatorios.relatorio2') }}"><i class="material-icons">collections_bookmark</i> Relatório 2</a></li>--}}
                            </ul>
                        </li>
                        {{--<li>--}}
                            {{--<a href="#">Tesouraria <span class="fa arrow"></span></a>--}}
                            {{--<ul class="nav nav-third-level">--}}
                                {{--<li><a href="{{ route('seracademico.posgraduacao.aluno.index') }}">Alunos</a></li>--}}
                                {{--<li><a href="{{ route('seracademico.posgraduacao.disciplina.index') }}">Disciplinas</a></li>--}}
                                {{--<li><a href="{{ route('seracademico.posgraduacao.curso.index') }}">Cursos</a></li>--}}
                                {{--<li><a href="{{ route('seracademico.posgraduacao.curriculo.index') }}">Currículos</a></li>--}}
                                {{--<li><a href="{{ route('seracademico.posgraduacao.turma.index') }}">Turmas</a></li>--}}
                            {{--</ul>--}}
                        {{--</li>--}}
                    </ul>
                </li>
                @endrole

                @permission('graduacao.aluno.select|graduacao.disciplina.select|graduacao.curso.select|graduacao.curriculo.select|graduacao.turma.select|graduacao.materia.select|graduacao.vestibular.select|graduacao.vestibulando.select')
                <li>
                    <a href="index.html"><i class="fa fa-graduation-cap"></i> <span class="nav-label">Graduação</span> <span
                                class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        @permission('graduacao.materia.select|graduacao.vestibular.select|graduacao.vestibulando.select')
                        <li>
                            <a href="#"><i class="flaticon-test"></i> Vestibular <span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level collapse">
                                @permission('graduacao.materia.select')
                                <li><a href="{{ route('seracademico.materia.index') }}"><i class="flaticon-passed-exam"></i> Matérias</a></li>
                                @endpermission

                                @permission('graduacao.vestibular.select')
                                <li><a href="{{ route('seracademico.vestibular.index') }}"><i class="flaticon-exam-1"></i> Vestibulares</a></li>
                                @endpermission

                                @permission('graduacao.vestibulando.select')
                                <li><a href="{{ route('seracademico.vestibulando.index') }}"><i class="flaticon-employment-test"></i> Vestibulando</a></li>
                                @endpermission

                                <li>
                                    <a href="#"><i class="flaticon-exam-2"></i> Relatórios <span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level collapse">
                                        <li><a target="_blank" href="{{ route('seracademico.vestibular.relatorios.relatorio1') }}"><i class="material-icons">contacts</i> Vestibulandos</a></li>
                                        <li><a href="{{ route('seracademico.vestibular.relatorios.viewReportQuantidadesGerais') }}"><i class="material-icons">insert_chart</i> Vestibular Geral Quantitativo</a></li>
                                        {{--<li><a targt="_blank" href="{{ route('seracademico.vestibular.relatorios.relatorio2') }}"><i class="material-icons">collections_bookmark</i> Relatório 2</a></li>--}}
                                    </ul>
                                </li>

                            </ul>
                        </li>
                        @endpermission

                        @permission('graduacao.aluno.select|graduacao.disciplina.select|graduacao.curso.select|graduacao.curriculo.select|graduacao.turma.select')
                        <li><a href="#"><i class="material-icons">markunread_mailbox</i> Secretaria <span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level collapse">
                                <li><a href="{{ route('seracademico.posgraduacao.professor.index') }}"><i class="flaticon-teacher-at-the-blackboard"></i> Professor</a></li>

                                @permission('graduacao.aluno.select')
                                <li><a href="{{ route('seracademico.matricula.index') }}"><i class="flaticon-male-university-graduate-silhouette-with-the-cap"></i>Matricular Aluno</a></li>
                                <li><a href="{{ route('seracademico.graduacao.aluno.index') }}"><i class="fa fa-users"></i>Alunos</a></li>
                                @endpermission

                                @permission('graduacao.disciplina.select')
                                <li><a href="{{ route('seracademico.graduacao.disciplina.index') }}"><i class="material-icons">collections_bookmark</i> Disciplinas</a></li>
                                @endpermission

                                @permission('graduacao.curso.select')
                                <li><a href="{{ route('seracademico.graduacao.curso.index') }}"><i class="flaticon-book-4"></i> Cursos</a></li>
                                @endpermission

                                @permission('graduacao.curriculo.select')
                                <li><a href="{{ route('seracademico.graduacao.curriculo.index') }}"><i class="material-icons">library_books</i> Currículos</a></li>
                                @endpermission

                                @permission('graduacao.turma.select')
                                <li><a href="{{ route('seracademico.graduacao.turma.index') }}"><i class="material-icons">turned_in</i> Turmas</a></li>
                                @endpermission

                                <li><a href="{{ route('seracademico.graduacao.planoEnsino.index') }}"><i class="material-icons">line_weight</i> Planos de Ensino</a></li>

                                <li>
                                    <a href="#"><i class="flaticon-exam-2"></i> Relatórios <span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level collapse">
                                        <li><a href="{{ route('seracademico.graduacao.curriculo.reportView') }}"><i class="flaticon-employment-test"></i> Currículos</a></li>
                                        {{--<li><a targt="_blank" href="{{ route('seracademico.vestibular.relatorios.relatorio2') }}"><i class="material-icons">collections_bookmark</i> Relatório 2</a></li>--}}
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        @endpermission

                        <li><a href="#"><i class="material-icons">card_travel</i> Financeiro <span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level collapse">
                                <li><a href="{{ route('seracademico.financeiro.taxa.index') }}"><i class="flaticon-currency-rates"></i> Taxas </a></li>
                                <li><a href="{{ route('seracademico.financeiro.banco.index') }}"><i class="fa fa-university"></i> Bancos </a></li>
                                <li><a href="{{ route('seracademico.financeiro.tipoBeneficio.index') }}"><i class="material-icons">account_balance_wallet</i> Tipos de Beneficios </a></li>
                            </ul>
                        </li>

                        {{--<li>
                            <a href="#">Tesouraria <span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level">
                                <li><a href="{{ route('seracademico.posgraduacao.aluno.index') }}">Alunos</a></li>
                                <li><a href="{{ route('seracademico.posgraduacao.disciplina.index') }}">Disciplinas</a></li>
                                <li><a href="{{ route('seracademico.posgraduacao.curso.index') }}">Cursos</a></li>
                                <li><a href="{{ route('seracademico.posgraduacao.curriculo.index') }}">Currículos</a></li>
                                <li><a href="{{ route('seracademico.posgraduacao.turma.index') }}">Turmas</a></li>
                            </ul>
                        </li>--}}
                    </ul>
                </li>
                @endpermission

                @role('admin')
                <li><a href="index.html"><i class="material-icons">lock</i> <span class="nav-label">Segurança</span> <span
                                class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="{{ route('seracademico.user.index') }}"><i class="material-icons">account_circle</i> Usuários</a></li>
                        <li><a href="{{ route('seracademico.role.index') }}"><i class="material-icons">account_box</i> Perfís</a></li>
                    </ul>
                </li>


                <li>
                    <a href="index.html"><i class="material-icons">perm_data_setting</i> <span class="nav-label">Parâmetros</span> <span
                                class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="{{ route('seracademico.empresa.check') }}"><i class="flaticon-3d-buildings"></i> Empresa</a></li>
                        <li><a href="{{ route('seracademico.sede.index') }}"><i class="fa fa-building"></i> Sedes</a></li>
                        <li><a href="{{ route('seracademico.departamento.index') }}"><i class="material-icons">view_module</i> Dpts/Sede</a></li>
                        <li><a href="{{ route('seracademico.sala.index') }}"><i class="flaticon-audience-in-presentation-of-business"></i> Salas</a></li>
                        <li><a href="{{ route('seracademico.tipoAvaliacao.index') }}"><i class="fa fa-star-half-empty"></i> Tipos de Avaliações</a></li>
                        <li><a href="{{ route('seracademico.tipoDisciplina.index') }}"><i class="fa fa-tags"></i> Tipos de Disciplinas</a></li>
                        <li><a href="{{ route('seracademico.graduacao.semestre.index') }}"><i class="fa fa-calendar"></i> Semestres</a></li>
                        <li><a href="{{ route('seracademico.tipoCurso.index') }}"><i class="flaticon-portfolio-filled-open-folder"></i> Tipos de Cursos</a></li>
                        <li><a href="{{ route('seracademico.tipoVencimento.index') }}"><i class="flaticon-tool"></i> Tipo de Vencimento</a></li>
                        <li><a href="{{ route('seracademico.graduacao.motivo.index') }}"><i class="material-icons">rate_review</i> Motivos</a></li>
                        <li><a href="{{ route('seracademico.hora.index') }}"><i class="flaticon-currency-rates"></i> Horas</a></li>
                        <li><a href="{{ route('seracademico.parametro.index') }}"><i class="flaticon-settings"></i> Configurações</a></li>
                    </ul>
                </li>
                @endrole


                @role('biblioteca')
                <li>
                    <a href="index.html"><i class="fa fa-book"></i> <span class="nav-label"> Biblioteca</span> <span
                                class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="{{ route('seracademico.biblioteca.indexResponsavel') }}"><i class="material-icons">perm_identity</i> Responsável</a></li>
                        <li><a href="{{ route('seracademico.biblioteca.indexEditora') }}"><i class="material-icons">card_travel</i> Editora</a></li>
                        <li>
                            <a href="#"><i class="flaticon-book"></i> Acervos <span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level">
                                <li><a href="{{ route('seracademico.biblioteca.indexAcervo') }}"><i class="flaticon-interface-1"></i> Não periódico</a></li>
                                <li><a href="{{ route('seracademico.biblioteca.indexAcervoP') }}"><i class="flaticon-interface"></i> Periódico</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><i class="flaticon-library"></i> Exemplar <span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level">
                                <li><a href="{{ route('seracademico.biblioteca.indexExemplar') }}"><i class="flaticon-interface-1"></i> Não periódico</a></li>
                                <li><a href="{{ route('seracademico.biblioteca.indexExemplarP') }}"><i class="flaticon-interface"></i> Periódico</a></li>
                            </ul>
                        </li>
                        <li><a href="{{ route('indexConsulta') }}" target="__blank"><i class="flaticon-book-with-magnifying-glass"></i> Consulta</a></li>
                        <li>
                            <a href="#"><i class="flaticon-book-3"></i> Controle <span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level">
                                <li><a href="{{ route('seracademico.biblioteca.indexEmprestimo') }}"><i class="flaticon-book-2"></i> Emprestimo</a></li>
                                <li><a href="{{ route('seracademico.biblioteca.viewDevolucaoEmprestimo') }}"><i class="flaticon-book-1"></i> Devolução</a></li>
                                <li><a href="{{ route('seracademico.biblioteca.indexReserva') }}"><i class="flaticon-commerce"></i> Reservar</a></li>
                                <li><a href="{{ route('seracademico.biblioteca.reservados') }}"><i class="flaticon-read"></i> Reservas</a></li>
                            </ul>
                        </li>
                        <li><a href="{{ route('seracademico.biblioteca.indexParametro') }}"><i class="material-icons">perm_identity</i> Parâmetros</a></li>
                        <li><a href="{{ route('seracademico.biblioteca.indexColecao') }}"><i class="material-icons">card_travel</i> Coleções</a></li>
                        <li><a href="{{ route('seracademico.biblioteca.indexGenero') }}"><i class="material-icons">card_travel</i> Gêneros</a></li>
                    </ul>
                </li>
                <li>
                    <a href="index.html"><i class="material-icons">dashboard</i> <span class="nav-label"> Dashboards</span> <span
                                class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li><a href="{{ route('seracademico.biblioteca.dashboardBliblioteca') }}"><i class="flaticon-library-1"></i> Dashboard Biblioteca</a></li>
                    </ul>
                </li>
                <li>
                    <a href="{{ route('seracademico.portal.indexPortal') }}" target="__blank"><i class="flaticon-business"></i> Portal</a>
                </li>
                @endrole
            </ul>
        </div>
    </nav>

    <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-exchange" aria-hidden="true"></i>
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
                                <span class="text-muted text-xs block" style="text-align: right;"><b style="color: #2F5286;">{{ Auth::user()->name }}</b> <b class="caret"></b></span>
                            </a>
                            <small style="text-align: left;">Semestre: {{ ParametroMatricula::getSemestreVigente()->nome ?? "" }} - Escopo {{ getenv('APP_ENV') }}</small>
                            <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                {{-- <li><a href="profile.html">Perfil</a></li>
                                 <li><a href="contacts.html">Notificações</a></li>--}}
                                {{--<li class="divider"></li>--}}
                                <li><a href="{{ url('auth/logout') }}">Sair</a></li>
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
<script src="{{ asset('/js/bootstrap-multiselect.js')}}" type="text/javascript"></script>
<script src="{{ asset('/js/bootbox.min.js')}}" type="text/javascript"></script>

<!-- Include Date Range Picker http://www.daterangepicker.com/#examples -->
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>

<script src="{{ asset('/js/dataTables.buttons.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('/vendor/datatables/buttons.server-side.js') }}"></script>

{{--<script src="{{ asset('/js/jquery.datatables.customsearch.js')}}" type="text/javascript"></script>--}}

<!-- zTree -->
<script src="{{ asset('/js/plugins/zTree/jquery.ztree.core.min.js')}}"></script>

<!-- Krajee -->
<script src="{{ asset('/js/plugins/Krajee/fileinput.min.js')}}"></script>
<script src="{{ asset('/js/plugins/Krajee/locale/pt-BR.js')}}"></script>
<script src="{{ asset('/js/plugins/Krajee/plugins/canvas-to-blob.min.js')}}"></script>
<script src="{{ asset('/js/plugins/Krajee/plugins/purify.min.js')}}"></script>
<script src="{{ asset('/js/plugins/Krajee/plugins/sortable.min.js')}}"></script>

<!-- Angular -->
<script type="text/javascript" src="{{ asset('/js/plugins/angular/angular.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('/js/app.js') }}"></script>

<!-- Mascaras -->
<script src="{{ asset('/js/jquery.maskMoney.min.js')}}"></script>

<!-- Flot -->
<script src="{{ asset('js/plugins/flot/jquery.flot.js') }}"></script>
<script src="{{ asset('js/plugins/flot/jquery.flot.categories.js') }}"></script>
{{--<script src="{{ asset('js/plugins/flot/jquery.flot.tooltip.min.js') }}"></script>--}}
<script src="{{ asset('js/plugins/flot/jquery.flot.resize.js') }}"></script>
<script src="{{ asset('js/plugins/flot/jquery.flot.pie.js') }} "></script>
<script src="{{ asset('js/plugins/flot/jquery.flot.time.js') }}"></script>

<!-- Custom and plugin javascript -->
<script src="{{ asset('/js/inspinia.js')}}"></script>
<script src="{{ asset('/js/plugins/pace/pace.min.js')}}"></script>
{{--<script src="{{ asset('/js/jasny-bootstrap.js')}}"></script>--}}
<script src="{{ asset('/js/jquery.mask.js')}}"></script>
<script src="{{ asset('/js/mascaras.js')}}"></script>
<script src="{{ asset('/js/sb-admin-2.js')}}"></script>
<script src="{{ asset('/messages.js')}}"></script>
<script src="{{ asset('/js/plugins/sweetalert/sweetalert.min.js')  }}"></script>
<script src="{{ asset('/js/plugins/botao/materialize.min.js')  }}"></script>
<script type="text/javascript">
    $(document).on({
        'show.bs.modal': function () {
            var zIndex = 1040 + (10 * $('.modal:visible').length);
            $(this).css('z-index', zIndex);
            setTimeout(function() {
                $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
            }, 0);
        },
        'hidden.bs.modal': function() {
            if ($('.modal:visible').length > 0) {
                // restore the modal-open class to the body element, so that scrolling works
                // properly after de-stacking a modal.
                setTimeout(function() {
                    $(document.body).addClass('modal-open');
                }, 0);
            }
        }
    }, '.modal');
</script>
@yield('javascript')
</body>

</html>
