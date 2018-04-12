@extends('menu')

@section('css')
    <style type="text/css" class="init">
        td.details-control {
            background: url({{asset("/imagemgrid/icone-produto-plus.png")}}) no-repeat center center;
            cursor: pointer;
        }
        tr.shown td.details-control {
            background: url({{asset("/imagemgrid/icone-produto-minus.png")}}) no-repeat center center;
        }


        a.visualizar {
            background: url({{asset("/imagemgrid/impressao.png")}}) no-repeat 0 0;
            width: 23px;
        }

        td.bt {
            padding: 10px 0;
            width: 126px;
        }

        td.bt a {
            float: left;
            height: 22px;
            margin: 0 10px;
        }
        .highlight {
            background-color: #FE8E8E;
        }
    </style>
@endsection

@section('content')

    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <div class="col-sm-6 col-md-9">
                <h4><i class="material-icons">find_in_page</i> Reservas dos livros</h4>
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

                @if(Session::has('error'))
                    <div class="alert alert-warning">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <em> {!! session('error') !!}</em>
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

                <div class="row">
                    <div class="col-md-12">
                        <form id="search-form" class="form-inline" role="form" method="GET">

                            <div class="form-check form-check-inline" style="color: #333;">
                                <input name='status' class="form-check-input" type="radio" id="inlineCheckbox1" value="1">
                                <label class="form-check-label" for="inlineCheckbox1">Pendentes</label>
                                <input name='status' class="form-check-input" type="radio" id="inlineCheckbox2" value="0">
                                <label class="form-check-label" for="inlineCheckbox2">Histórico</label>
                            </div>
                        </form>
                    </div>
                </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive no-padding">
                        <table id="sala-grid" class="display table table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Detalhe</th>
                                <th>Código</th>
                                <th>Data</th>
                                <th>Data de vencimento</th>
                                <th>Aluno</th>
                                <th>RG</th>
                                <th >Acão</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Detalhe</th>
                                <th>Código</th>
                                <th>Data</th>
                                <th>Data de vencimento</th>
                                <th>Aluno</th>
                                <th>RG</th>
                                <th >Acão</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('javascript')
    <script src="{{ asset('/js/handlebars-v4.0.5.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/biblioteca/reserva/reservas_realizadas.js')}}"></script>
@stop