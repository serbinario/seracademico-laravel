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
                                <span class="label label-success pull-right">Acervo</span>
                                <h5>Acervos</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins">{{count($acervo)}}</h1>
                                <small>Total acervos</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <span class="label label-info pull-right">Exemplar</span>
                                <h5>Exemplar</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins">{{count($exemplar)}}</h1>
                                <small>Total exemplar</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@stop