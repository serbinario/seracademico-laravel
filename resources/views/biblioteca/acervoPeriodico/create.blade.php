@extends('menu')

@section('content')
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <div class="col-sm-6 col-md-9">
                <h4><i class="material-icons">find_in_page</i> Cadastrar Acervo Periódico</h4>
            </div>
            <div class="col-sm-6 col-md-3">

            </div>
        </div>

        <div class="ibox-content">

            @if(Session::has('message'))
                <div class="alert alert-success">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <em> {!! session('message') !!}</em>
                </div>
            @endif

            @if(Session::has('errors'))
                <div class="alert alert-danger">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif
            {!! Form::open(['route'=>'seracademico.biblioteca.storeAcervoP', 'method' => "POST" ]) !!}
            @include('tamplatesForms.tamplateFormArcevoPeriodico')
            {!! Form::close() !!}
        </div>
    </div>
@stop

@section('javascript')
    <script type="text/javascript">

        function maiuscula(id) {
            //palavras para ser ignoradas
            var wordsToIgnore = ["DOS", "DAS", "de", "do", "dos", "Dos", "Das", "das"],
                    minLength = 2;
            var str = $('#' + id).val();
            var getWords = function (str) {
                return str.match(/\S+\s*/g);
            };
            $('#' + id).each(function () {
                var words = getWords(this.value);
                $.each(words, function (i, word) {
                    // somente continua se a palavra nao estiver na lista de ignorados
                    if (wordsToIgnore.indexOf($.trim(word)) == -1 && $.trim(word).length > minLength) {
                        words[i] = words[i].charAt(0).toUpperCase() + words[i].slice(1).toLowerCase();
                    } else {
                        words[i] = words[i].toLowerCase();
                    }
                });
                this.value = words.join("");
            });
        }
        //Deixar letra maiúscula
        $(document).ready(function ($) {
            // Chamada da funcao upperText(); ao carregar a pagina
            upperText();
            // Funcao que faz o texto ficar em uppercase
            function upperText() {

                // Para tratar o colar
                $("#sobrenome").bind('paste', function (e) {
                    var el = $(this);
                    setTimeout(function () {
                        var text = $(el).val();
                        el.val(text.toUpperCase());
                    }, 100);
                });

                // Para tratar quando é digitado
                $("#sobrenome").keypress(function () {
                    var el = $(this);
                    if (!el.hasClass('semCaixaAlta')) {
                        console.log('asdas');
                        setTimeout(function () {
                            var text = $(el).val();
                            el.val(text.toUpperCase());
                        }, 100);
                    }
                });
            }

        });
    </script>
@stop