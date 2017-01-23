@extends('menu')

@section('content')
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h4>
                <i class="material-icons">account_box</i>
                Editar Perfil
            </h4>
        </div>

        <div class="ibox-content">

            @if(Session::has('message'))
                <div class="alert alert-success">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <em> {!! session('message') !!}</em>
                </div>
            @endif

            {!! Form::model($role, ['route'=> ['seracademico.role.update', $role->id], 'method' => "POST", 'enctype' => 'multipart/form-data' ]) !!}
            <div class="row">
                <div class="col-md-12">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs">
                        <li role="presentation" class="active">
                            <a href="#role" aria-controls="role" role="tab" data-toggle="tab">Dados Gerais</a>
                        </li>
                        <li role="presentation">
                            <a href="#permission" aria-controls="permission" role="tab" data-toggle="tab">Permissões</a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="role">
                            <br/>

                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('name', 'Nome') !!}
                                    {!! Form::text('name', null, array('class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('description', 'Descrição') !!}
                                    {!! Form::text('description', null, array('class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="permission">
                            <br/>
                            <div id="tree-permission" style="padding: 15px;">
                                <ul>
                                    <li>
                                        @if(count($role->permissions->lists('name')->all()) > 0)
                                            <input type="checkbox" checked> Todos
                                        @else
                                            <input type="checkbox"> Todos
                                        @endif
                                        <br/>
                                        <ul >
                                            <!-- Inicio Accordion  -->
                                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                                @if(isset($loadFields['tipopermissao']))
                                                    @foreach($loadFields['tipopermissao'] as $tipo)
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading" role="tab" id="headingTwo">
                                                                <p class="panel-title">
                                                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#body-{{ $tipo->id }}" aria-expanded="false" aria-controls="body-{{ $tipo->id }}">
                                                                        {{ utf8_decode($tipo->name) }}
                                                                    </a>
                                                                </p>
                                                            </div>
                                                            <div id="body-{{ $tipo->id  }}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                                                <div class="panel-body">
                                                                    @if(count($tipo->permissoes) > 0)
                                                                        @foreach($tipo->permissoes as $permission)
                                                                            @if(\in_array($permission->name, $role->permissions->lists('name')->all()))
                                                                                <li><input type="checkbox" name="permission[]" checked value="{{ $permission->id  }}"> {{ utf8_decode($permission->description) }} </li>
                                                                            @else
                                                                                <li><input type="checkbox" name="permission[]" value="{{ $permission->id  }}"> {{ utf8_decode($permission->description) }} </li>
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <!-- Fim Accordion  -->
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    {{--Buttons Submit e Voltar--}}
                    <div class="row">
                        <div class="col-md-9"></div>
                        <div class="col-md-3">
                            <div class="btn-group btn-group-justified">
                                <div class="btn-group">
                                    <a href="{{ route('seracademico.role.index') }}" class="btn btn-primary btn-block"><i class="fa fa-long-arrow-left"></i>  Voltar</a></div>
                                <div class="btn-group">
                                    {!! Form::submit('Salvar', array('class' => 'btn btn-primary btn-block pull-right')) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--Fim Buttons Submit e Voltar--}}
                </div>

            </div>
            {!! Form::close() !!}
        </div>
    </div>
@stop

@section('javascript')
    <script type="text/javascript" class="init">
        $(document).ready(function () {
            $("#tree-permission").tree();
        });
    </script>
@stop