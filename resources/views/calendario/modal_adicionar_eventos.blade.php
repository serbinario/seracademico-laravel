<!-- Modal de cadastro das Disciplinas-->
<div id="modal-adicionar-eventos" class="modal fade modal-profile" role="dialog" aria-labelledby="modalProfile" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 90%">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title">Adicionar Eventos</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <div class="row" style="margin-bottom: 5%;">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12" style="background-color: #e6e9dc">
                                <div class="col-md-4" style="margin-top: 17px">
                                    <span><strong>Ano: </strong><p id="eAno"></p></span>
                                </div>

                                <div class="col-md-2" style="margin-top: 17px">
                                    <span><strong>Calendário: </strong><p id="eNome"></p></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row" style="margin-top: 2%;">

                    <!-- Gerendiamento das Disciplinas da Séries -->
                    <div class="col-md-12">
                        <!-- Adicionar Disciplina -->
                        <div class="row" style="margin-top: -2%; margin-bottom: 3%;">
                            <div class="form-group col-md-2">
                                <div class=" fg-line">
                                    <label for="tipoEvento">Tipo evento *</label>
                                    <div class="select">
                                        {!! Form::select("tipo_evento", array(), null, array('class'=> 'form-control', 'id' => 'tipoEvento')) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <div class="fg-line">
                                    <div class="fg-line">
                                        <label for="nome">Nome *</label>
                                        {!! Form::text('nome', null, array('class' => 'form-control input-sm', 'id' => 'nome', 'placeholder' => 'Nome')) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <div class="fg-line">
                                    <div class="fg-line">
                                        <label for="dtFeriado">Data feriado *</label>
                                        {!! Form::text('data_feriado', null, array('class' => 'form-control input-sm', 'id' => 'dtFeriado', 'placeholder' => 'Data feriado')) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <div class="fg-line">
                                    <div class="fg-line">
                                        <label for="diaSemana">Dia da semana</label>
                                        {!! Form::text('dia_semana', null, array('class' => 'form-control input-sm', 'id' => 'diaSemana', 'readonly' => 'readonly')) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <div class=" fg-line">
                                    <label for="diaLetivo">Dia letivo *</label>
                                    <div class="select">
                                        {!! Form::select("dia_letivo", array(), null, array('class'=> 'form-control', 'id' => 'diaLetivo')) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <div class="fg-line" style="margin-top: 20px">
                                    <div class="fg-line">
                                        <button type="button" id="addEvento" class="btn btn-primary btn-sm m-t-10">Adicionar</button>
                                        {{--<button style="margin-left: 5px" type="button" id="edtEvento" class="btn btn-success btn-sm m-t-10">Editar</button>--}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Fim Adicionar Eventos -->

                        <!-- Table de eventos letivos -->
                        <div class="table-responsive">
                            <table id="eventos-grid" class="display table table-bordered" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th style="width: 20%;">Descrição</th>
                                    <th>Data Feriado</th>
                                    <th>Dia da semana</th>
                                    <th>Dia letivo</th>
                                    <th>Tipo do evento</th>
                                    <th style="width: 3%;">Acão</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                        <!-- Fim Table de eventos letivos -->
                    </div>
                    <!-- Fim do Gerendiamento das Disciplinas da Séries -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- FIM Modal de cadastro das Disciplinas-->
