<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
    <title>Login</title>

    <!-- CSS  -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="{{ asset('/portal/css/materialize.css')}}" type="text/css" rel="stylesheet"
          media="screen,projection"/>
    <!-- <link rel="stylesheet" type="text/css" href="css/bootstrap.css"> -->
    <link href="{{ asset('/portal/css/style.css')}}" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>
<body style="background: #E6E6E6;">

<div class="container">
    <div class="row" style="margin-top: 10%;">

        <div class="col s12 m8 l6">
            <h3>Portal Acadêmico</h3>
            <p style="font-size: 15px;">Tenha acesso as suas informações acadêmicas e outros recursos</p>
        </div>

        <div class="col s12 m4 l6">
            <div class="card">
                <div class="card-content" style="padding: 30px !important;">
                    <img src="{{ asset('/portal/img/logo_alpha_faculdade-01.png')}}" alt="" style="width: 45%;margin-left: 30%;margin-top: -10%;margin-bottom: -5%;">
                    <br/>
                    <div class="row">
                        <form class="col s12" action="{{url('seracademico/portal/login')}}" method="post">
                            <div class="row">
                                <div class="input-field col s12">
                                    <i class="material-icons prefix">account_circle</i>
                                    <input id="icon_prefix" type="text" class="validate">
                                    <label for="icon_prefix">Usuário</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <i class="material-icons prefix">lock</i>
                                    <input id="icon_lock" type="password" class="validate">
                                    <label for="icon_lock">Senha</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s12">
                                    <div class="col s6 m6">
                                        <input type="checkbox" id="remember">
                                        <label for="remember">Lembrar</label>
                                    </div>
                                    <p class="col s6 m6">
                                        <button type="submit" class="btn waves-effect waves-light right" type="button" name="action">Login</button>
                                    </p>
                                </div>
                            </div>
                            <!--  <div class="row">
                              <div class="col m12">
                                <p class="right-align">
                                </p>
                              </div>
                            </div> -->
                        </form>
                    </div>
                    <br/>
                </div></div>
        </div>
    </div>

</div>

<!--  Scripts-->
<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script src="{{ asset('/portal/js/materialize.js')}}"></script>
<script src="{{ asset('/portal/js/init.js')}}"></script>

<script>
    $(document).ready(function(){
        $('.parallax').parallax();
    });
    $(document).ready(function() {
        $('select').material_select();
    });
</script>


</body>
</html>
