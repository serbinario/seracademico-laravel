@extends('menu')

@section('content')
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h4>
                <i class="material-icons">class</i>
                Cadastrar Plano de Ensino
            </h4>
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

            {!! Form::open(['route'=>'seracademico.graduacao.planoEnsino.store', 'method' => "POST", "id" => "formPlanoEnsino" ]) !!}
                @include('tamplatesForms.graduacao.tamplateFormPlanoEnsino')
            {!! Form::close() !!}
        </div>
    </div>
@stop

{{--@section('javascript')--}}
    {{--<script type="text/javascript">--}}
        {{--$('#btnCreateConteudo').on("click", function () {--}}
            {{--var row = document.getElementById('#ConteudoProgramatico');--}}



        {{--});--}}
    {{--</script>--}}
{{--@stop--}}