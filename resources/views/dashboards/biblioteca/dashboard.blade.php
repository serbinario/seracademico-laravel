@extends('menu')

@section('content')
    <div class="ibox float-e-margins">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h4>
                    <i class="material-icons">view_module</i>
                    Dashboard Biblioteca
                </h4>
            </div>

            <div class="ibox-content">
                <div class="row">
                    <br />
                    <div class="col-lg-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                {{--<span class="label label-success pull-right">Acervo</span>--}}
                                <h5>Acervos não periódico</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins">{{$acervoNP->qtd_acervos_np}}</h1>
                                <small>Total acervos</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Exemplar não periódico</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins">{{$exemplarNP->qtd_exemplar_np}}</h1>
                                <small>Total exemplar</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Acervo periódico</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins">{{$acervoP->qtd_acervos_p}}</h1>
                                <small>Total acervo</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Exemplar periódico</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins">{{$exemplarP->qtd_exemplar_p}}</h1>
                                <small>Total exemplar</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@stop