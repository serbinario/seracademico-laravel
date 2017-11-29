@extends('menu')

@section('content')
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <div class="col-sm-6 col-md-9">
                <h4>
                    <i class="fa fa-users"></i>
                    Lista de Atualizações dos Sistemas
                </h4>
            </div>
        </div>
        <div class="ibox-content">
            <table class="display table table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th width="140">Data</th>
                    <th>Atividades</th>
                </tr>
                </thead>
                <tbody>
                @foreach($lancamentos as $data => $valores)
                    <tr>
                        <td>{{$data}}</td>
                        <td>
                            <ul>
                                @foreach($valores as $valor)
                                    <li>
                                        <b>{{$valor['tipo']}}</b>: {{$valor['descricao']}} - {{$valor['sistema']}} <b>{{' @'.$valor['desenvolvedor']}}</b>
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop