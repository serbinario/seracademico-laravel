<!-- Modal de cadastro das Disciplinas-->
<div id="modal-adicionar-periodos" class="modal fade modal-profile" role="dialog" aria-labelledby="modalProfile" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 90%">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title">Adicionar períodos de avaliação</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <div class="row" style="margin-bottom: 5%;">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12" style="background-color: #e6e9dc">
                                <div class="col-md-4" style="margin-top: 17px">
                                    <span><strong>Ano: </strong><p id="cAno"></p></span>
                                </div>

                                <div class="col-md-2" style="margin-top: 17px">
                                    <span><strong>Calendário: </strong><p id="cNome"></p></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row" style="margin-top: 2%;">

                    <!-- Gerendiamento das Disciplinas da Séries -->
                    <div class="col-md-12">
                        <!-- Adicionar Disciplina -->
                        <div class="row" style="margin-top: -2%;">
                            <div class="form-group col-md-2">
                                <div class=" fg-line">
                                    <label for="periodo">Período *</label>
                                    <div class="select">
                                        {!! Form::select("periodo", array(), null, array('class'=> 'form-control', 'id' => 'periodo')) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <div class="fg-line">
                                    <div class="fg-line">
                                        <label for="data_inicial">Data inicial *</label>
                                        {!! Form::text('data_inicial', null, array('class' => 'form-control input-sm', 'id' => 'dtInicial', 'placeholder' => 'Data inicial')) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <div class="fg-line">
                                    <div class="fg-line">
                                        <label for="data_final">Data final *</label>
                                        {!! Form::text('data_final', null, array('class' => 'form-control input-sm', 'id' => 'dtFinal', 'placeholder' => 'Data final')) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <div class="fg-line">
                                    <div class="fg-line">
                                        <label for="dias_letivos">Dias letivos</label>
                                        {!! Form::text('dias_letivos', null, array('class' => 'form-control input-sm', 'id' => 'diasLetivos', 'readonly' => 'readonly')) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <div class="fg-line">
                                    <div class="fg-line">
                                        <label for="semanas_letivas">Semanas letivas</label>
                                        {!! Form::text('semanas_letivas', null, array('class' => 'form-control input-sm', 'id' => 'semanasLetivas', 'readonly' => 'readonly')) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style=" margin-bottom: 3%;">
                            <div class="form-group col-md-2">
                                <div class="fg-line">
                                    <div class="fg-line">
                                        <label for="total_dias_letivos">Total dias letivos</label>
                                        {!! Form::text('total_dias_letivos', null, array('class' => 'form-control input-sm', 'id' => 'totalDias','readonly' => 'readonly')) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <div class="fg-line">
                                    <div class="fg-line">
                                        <label for="total_semanas_letivas">Total semanas letivas</label>
                                        {!! Form::text('total_semanas_letivas', null, array('class' => 'form-control input-sm', 'id' => 'totalSemanas', 'readonly' => 'readonly')) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <div class="fg-line" style="margin-top: 14px">
                                    <div class="fg-line">
                                        <button type="button" id="addPeriodo" class="btn btn-primary btn-sm m-t-10">Adicionar</button>
                                        <button style="margin-left: 5px" type="button" id="edtPeriodo" class="btn btn-success btn-sm m-t-10">Editar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Fim Adicionar Disciplina -->

                        <!-- Table de disciplinas -->
                        <div class="table-responsive">
                            <table id="periodos-grid" class="display table table-bordered" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th style="width: 20%;">Período</th>
                                    <th>Data inicial</th>
                                    <th>Data Final</th>
                                    <th>Dias letivos</th>
                                    <th>Semanas letivas</th>
                                    <th style="width: 8%;">Acão</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                        <!-- Fim Table de disciplinas -->
                    </div>
                    <!-- Fim do Gerendiamento das Disciplinas da Séries -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- FIM Modal de cadastro das Disciplinas-->
