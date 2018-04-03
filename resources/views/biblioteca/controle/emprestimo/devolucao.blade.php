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
                <h4><i class="material-icons">find_in_page</i> Devolução de livros</h4>
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
                <div class="alert alert-danger">
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

            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#individual" aria-controls="individual" role="tab" data-toggle="tab">Devolução por Empréstimo</a></li>
                <li role="presentation"><a href="#aluno" aria-controls="aluno" role="tab" data-toggle="tab">Devolução por Pessoa</a></li>
            </ul>

            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="individual">
                    <br />
                    <div class="row">
                        <div class="col-md-12">
                            <form id="search-form" class="form-inline" role="form" method="GET">
                                <div class="form-group">
                                    {!! Form::text('globalSearch',  null, array('class' => 'form-control', 'placeholder' => 'Pesquisa...')) !!}
                                </div>
                                <div class="form-group">
                                    <button class="btn-sm btn-primary" type="submit">Pesquisar</button>
                                </div>
                            </form>
                        </div><br /><br /><br /><br />
                        <div class="col-md-12">
                            <div class="table-responsive no-padding">
                                <table id="individual-grid" class="display table table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>Detalhe</th>
                                        <th>Código</th>
                                        <th>Data</th>
                                        <th>Data de devolução</th>
                                        <th>Data real de devolução</th>
                                        <th>Aluno</th>
                                        <th>Acão</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th style="width: 5%;">Detalhe</th>
                                        <th>Código</th>
                                        <th>Data</th>
                                        <th>Data de devolução</th>
                                        <th>Data real de devolução</th>
                                        <th>Aluno</th>
                                        <th style="width: 5%;">Acão</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="aluno">
                    <br />
                    <div class="row">
                        <div class="col-md-12">
                            <form id="search-form-aluno" class="form-inline" role="form" method="GET">
                                <div class="form-group">
                                    {!! Form::text('globalSearchAluno',  null, array('class' => 'form-control', 'placeholder' => 'Pesquisa...')) !!}
                                </div>
                                <div class="form-group">
                                    <button class="btn-sm btn-primary" type="submit">Pesquisar</button>
                                </div>
                            </form>
                        </div><br /><br /><br /><br />
                        <div class="col-md-12">
                            <div class="table-responsive no-padding">
                                <table id="aluno-grid" class="display table table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>Detalhe</th>
                                        <th>Nome</th>
                                        <th>RG</th>
                                        <th>CPF</th>
                                        <th >Acão</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th style="width: 5%;">Detalhe</th>
                                        <th>Nome</th>
                                        <th>RG</th>
                                        <th>CPF</th>
                                        <th style="width: 5%;">Acão</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('javascript')
    <script src="{{ asset('/js/handlebars-v4.0.5.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/biblioteca/emprestimo/devolucao.js')}}"></script>
@stop