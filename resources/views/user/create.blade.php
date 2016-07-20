@extends('menu')

@section('content')
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h4>
                <i class="material-icons">account_circle</i>
                Cadastrar Usuário
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

            {!! Form::open(['route'=>'seracademico.user.store', 'method' => "POST", 'enctype' => 'multipart/form-data' ]) !!}
            <div class="row">
                <div class="col-md-12">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs">
                        <li role="presentation" class="active">
                            <a href="#user" aria-controls="user" role="tab" data-toggle="tab">Dados Gerais</a>
                        </li>
                        <li role="presentation">
                            <a href="#permission" aria-controls="permission" role="tab" data-toggle="tab">Permissões</a>
                        </li>
                        <li role="presentation">
                            <a href="#perfil" aria-controls="perfil" role="tab" data-toggle="tab">Perfís</a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="user">
                            <br/>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        {!! Form::label('name', 'Nome') !!}
                                        {!! Form::text('name', '', array('class' => 'form-control')) !!}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {!! Form::label('email', 'Email') !!}
                                        {!! Form::text('email', '', array('class' => 'form-control')) !!}
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        {!! Form::label('password', 'Senha') !!}
                                        {!! Form::password('password', '', array('class' => 'form-control')) !!}
                                    </div>
                                </div>
                                {{--<div class="col-md-4">--}}
                                    {{--<div class="fileinput fileinput-new" data-provides="fileinput">--}}
                                        {{--<div class="fileinput-preview thumbnail" data-trigger="fileinput"--}}
                                             {{--style="width: 135px; height: 115px;">--}}
                                        {{--</div>--}}
                                        {{--<div>--}}
                                            {{--<span class="btn btn-primary btn-xs btn-block btn-file">--}}
                                                {{--<span class="fileinput-new">Selecionar</span>--}}
                                                {{--<span class="fileinput-exists">Mudar</span>--}}
                                                {{--<input type="file" name="img">--}}
                                            {{--</span>--}}
                                            {{--<a href="#" class="btn btn-warning btn-xs fileinput-exists col-md-6" data-dismiss="fileinput">Remover</a>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                <div class="col-md-1">
                                    <div class="checkbox checkbox-primary">
                                        {!! Form::hidden('active', 0) !!}
                                        {!! Form::checkbox('active', 1, null, array('class' => 'form-control')) !!}
                                        {!! Form::label('active', 'Ativo') !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="permission">
                            <br/>

                            <div id="tree-role">
                                <ul>
                                    <li>
                                        <input type="checkbox"> Todos
                                        <ul>
                                            @if(isset($loadFields['tipopermissao']))
                                                @foreach($loadFields['tipopermissao'] as $tipo)
                                                        <!-- Inicio Accordion  -->
                                                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                                            <div class="panel panel-default">
                                                                <div class="panel-heading" role="tab" id="headingTwo">
                                                                    <h4 class="panel-title">
                                                                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#body-{{ $tipo->id }}" aria-expanded="false" aria-controls="body-{{ $tipo->id }}">
                                                                            {{ $tipo->name }}
                                                                        </a>
                                                                    </h4>
                                                                </div>
                                                                <div id="body-{{ $tipo->id  }}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                                                    <div class="panel-body">
                                                                        @if(count($tipo->permissoes) > 0)
                                                                            @foreach($tipo->permissoes as $permission)
                                                                                <li><input type="checkbox" name="permission[]" value="{{ $permission->id  }}"> {{ $permission->description }} </li>
                                                                            @endforeach
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Fim Accordion  -->
                                                @endforeach
                                            @endif
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="perfil">
                            <br/>

                            <div id="tree-permission">
                                 <ul>
                                     @if(isset($loadFields['role']))
                                         @foreach($loadFields['role'] as $id => $role)
                                            <li><input type="checkbox" name="role[]" value="{{ $id  }}"> {{ $role }} </li>
                                         @endforeach
                                     @endif
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
                                    <a href="{{ route('seracademico.user.index') }}" class="btn btn-primary btn-block"><i class="fa fa-long-arrow-left"></i>  Voltar</a></div>
                                <div class="btn-group">
                                    {!! Form::submit('Enviar', array('class' => 'btn btn-primary btn-block pull-right')) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--Fim Buttons Submit e Voltar--}}

            </div>
            {!! Form::close() !!}
        </div>
        
    </div>
@stop

@section('javascript')
    <script type="text/javascript" class="init">
        $(document).ready(function () {
            $("#tree-role, #tree-permission").tree();

            $('#user a').click(function (e) {
                e.preventDefault();
                $(this).tab('show');
            });
        });
    </script>
@stop