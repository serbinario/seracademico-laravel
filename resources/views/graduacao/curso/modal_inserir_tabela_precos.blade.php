<!-- Modal principal de disciplinas -->
<div id="modal-precos" class="modal fade modal-profile" tabindex="-1" role="dialog" aria-labelledby="modalProfile"
     aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title">Tabela de Preços</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <div class="row">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="virgencia">Virgencia</label>
                            <input type="text" name="virgencia" class="datepicker form-control" id="virgencia" placeholder="Data">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="semestre_id">Semestre</label>
                            <select name="semestre_id" class="form-control" id="semestre_id">
                                {{--@foreach($loadFields['semestre'] as $key => $value)--}}
                                    {{--<option value="{{ $key  }}">{{ $value  }}</option>--}}
                                {{--@endforeach--}}
                            </select>
                        </div>
                     </div>

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="tipo_preco_curso_id">Tipo</label>
                            <select name="tipo_preco_curso_id" class="form-control" id="tipo_preco_curso_id">
                                {{--@foreach($loadFields['tipoprecocurso'] as $key => $value)--}}
                                    {{--<option value="{{ $key  }}">{{ $value  }}</option>--}}
                                {{--@endforeach--}}
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="turno_id">Turno</label>
                            <select name="turno_id" class="form-control" id="turno_id">
                                {{--@foreach($loadFields['tipoprecocurso'] as $key => $value)--}}
                                {{--<option value="{{ $key  }}">{{ $value  }}</option>--}}
                                {{--@endforeach--}}
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="btnSalvarTabelaPrecos">Salvar</button>
                <button class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
</div>
<!-- FIM Modal de cadastro das Disciplinas-->