<!-- Modal principal de disciplinas -->
<div id="modal-novo-calendario" class="modal fade modal-profile" tabindex="-1" role="dialog" aria-labelledby="modalProfile" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title">Criação do calendário das disciplinas</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="data">Data</label>
                                <input type="text" name="data" class="datepicker form-control" id="data" placeholder="Data">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="data_final">Data final</label>
                                <input type="text" name="data_final" class="datepicker form-control" id="data_final" placeholder="Data Final">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="hora_inicial">Hora inicial</label>
                                <input type="text" name="hora_inicial" class="form-control time" id="hora_inicial" placeholder="00:00:00">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="hora_final">Hora final</label>
                                <input type="text" name="hora_final" class="form-control time" id="hora_final" placeholder="00:00:00">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="sala_id">Sala</label>
                                <select name="sala_id" class="form-control" id="sala_id">
                                    @foreach($loadFields['sala'] as $key => $value)
                                        <option value="{{ $key  }}">{{ $value  }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="professor_id">Professor</label>
                                <select name="professor_id" class="form-control" id="professor_id">
                                    @foreach($loadFields['professor'] as $key => $value)
                                        <option value="{{ $key  }}">{{ $value  }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="btnSalvarCalendario">Salvar</button>
                <button class="btn btn-default" data-dismiss="modal" id="btnCancelarNovoCalendario">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- FIM Modal de cadastro das Disciplinas-->