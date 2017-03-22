@extends('menu')

@section('css')
    <style>
        table.dataTable tbody th, table.dataTable tbody td {
            padding: 2px 10px;
        }
    </style>
@endsection
@section('content')

    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <div class="col-sm-6 col-md-9">
                <h4><i class="material-icons">receipt</i> Realizar reserva</h4>
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

            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive no-padding">
                        <table id="sala-grid" class="display table table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Acervo - Título</th>
                                <th>Cutter</th>
                                <th>Subtítulo</th>
                                <th>Edição</th>
                                <th>Data de previsão</th>
                                <th>Quantidade de reservas</th>
                                <th>Acão</th>
                            </tr>
                            </thead>

                            <tfoot>
                            <tr>
                                <th>Acervo - Título</th>
                                <th>Cutter</th>
                                <th>Subtítulo</th>
                                <th>Edição</th>
                                <th>Data de previsão</th>
                                <th>Quantidade de reservas</th>
                                <th style="width: 10%;">Acão</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                @if(count($reservasPendentes) > 0)
                    <div class="col-md-6">
                        <div class="table-responsive no-padding">
                            <table id="emprestimos-pendente"  class="display table table-bordered" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th colspan="2">Reservas pendentes</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($reservasPendentes as $reserva)
                                    <tr>
                                        <td>{{$reserva->pessoa->nome}}</td>
                                        <td style="width: 10%;"><a href="#" data="{{$reserva->pessoa->id}}" class="continuar">Continuar</a></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
                {!! Form::open(['route'=>'seracademico.biblioteca.confirmarReserva', 'method' => "POST", 'id' => 'form' ]) !!}
                    <div class="col-md-12">
                        <div class="form-group col-md-2">
                            <select class="form-control" id="tipo_pessoa">
                                <option value="">Tipo pessoa</option>
                                <option value="1">Graduação</option>
                                <option value="2">Pós-graduação</option>
                                <option value="3">Mestrado</option>
                                <option value="4">Professor</option>
                            </select>
                        </div>
                        <div class="form-group col-md-5">
                            {!! Form::select('pessoas_id', array(), null, array('class' => 'form-control', 'id' => 'pessoa')) !!}
                            <input type="hidden" name="edicao" id="edicao">
                            <input type="hidden" name="tipo_emprestimo" id="id_emprestimo">
                        </div>
                        <div class="form-group col-md-3" style="margin-top: -8px">
                            <div class="checkbox checkbox-primary">
                                <input type="checkbox" class="form-control" id="emprestimoEspecial">
                                {!! Form::label('emprestimoEspecial', 'Para empréstimo especial?', false) !!}
                            </div>
                        </div>
                        <input type="submit" style="margin-left: -50px" id="conf_reserva" class="btn btn-success btn-sm" value="Confirmar reserva">
                    </div>
                    <div class="col-md-12">
                        <div class="table-responsive no-padding">
                            <table id="emprestimos" class="display table table-bordered" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>Acervo - Título</th>
                                    <th>Cutter</th>
                                    <th>Subtítulo</th>
                                    <th>Edição</th>
                                    <th>Ação</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    @include('biblioteca.controle.reserva.modal_fila_de_reserva')
@stop

@section('javascript')
    <script type="text/javascript" src="{{asset('/js/biblioteca/reserva/reserva.js')}}"></script>
@stop