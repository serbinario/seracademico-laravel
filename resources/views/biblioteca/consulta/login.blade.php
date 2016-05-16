<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
    <title>Biblioteca Faculdade</title>

    <!-- CSS  -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="{{ asset('/biblioteca/css/materialize.css')}}" type="text/css" rel="stylesheet"
          media="screen,projection"/>
    <!-- <link rel="stylesheet" type="text/css" href="css/bootstrap.css"> -->
    <link href="{{ asset('/biblioteca/css/style.css')}}" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>
<body>
<div class="container">
    <div class="row" style="margin-top: 10%;">

        <div class="col s12 m8 l6">
            <h4>Portal Acadêmico</h4>
            <p>Faça login</p>
        </div>

        <div class="col s12 m4 l6">
            <div class="card">
                <div class="card-content" style="padding: 30px !important;">
                    <h4 class="center-align">Login</h4>
                    <br/>
                    <div class="row">
                        <form class="col s12">
                            <div class="row">
                                <div class="input-field col s12">
                                    <i class="material-icons prefix">account_circle</i>
                                    <input id="icon_prefix" type="text" class="validate">
                                    <label for="icon_prefix">Usuário</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <i class="material-icons prefix">phone</i>
                                    <input id="icon_telephone" type="password" class="validate">
                                    <label for="icon_telephone">Senha</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s12">
                                    <p>
                                        <input type="checkbox" id="remember">
                                        <label for="remember">Remember me</label>
                                        <button class="btn btn-large waves-effect waves-light" type="button" name="action">Login</button>
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
<script src="{{ asset('/biblioteca/js/materialize.js')}}"></script>
<script src="{{ asset('/biblioteca/js/init.js')}}"></script>

<script>
    $(document).ready(function () {
        $('.parallax').parallax();
    });
    $(document).ready(function () {
        $('select').material_select();
    });
</script>


</body>
</html>
