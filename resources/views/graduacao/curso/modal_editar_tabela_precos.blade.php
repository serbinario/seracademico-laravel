<!-- Modal principal de disciplinas -->
<div id="editar-modal-precos" class="modal fade modal-profile" tabindex="-1" role="dialog" aria-labelledby="modalProfile"
     aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title">Edição da Tabela de Preços</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <div class="row">
                    <div class="row">
                        <input type="hidden" id="idPrecoCurso">
                        <div class="form-group col-md-4">
                            <label for="virgencia_editar">Virgencia</label>
                            <input type="text" name="virgencia_editar" class="datepicker form-control" id="virgencia_editar" placeholder="Data">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="periodo_id_editar">Período</label>
                            <select name="periodo_id_editar" class="form-control" id="periodo_id_editar">
                                {{--@foreach($loadFields['periodo'] as $key => $value)--}}
                                    {{--<option value="{{ $key  }}">{{ $value  }}</option>--}}
                                {{--@endforeach--}}
                            </select>
                        </div>
                     </div>

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="tipo_preco_curso_id_editar">Tipo Preço</label>
                            <select name="tipo_preco_curso_id_editar" class="form-control" id="tipo_preco_curso_id_editar">
                                {{--@foreach($loadFields['tipoprecocurso'] as $key => $value)--}}
                                    {{--<option value="{{ $key  }}">{{ $value  }}</option>--}}
                                {{--@endforeach--}}
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="turno_id_editar">Turno</label>
                            <select name="turno_id_editar" class="form-control" id="turno_id_editar">
                                {{--@foreach($loadFields['tipoprecocurso'] as $key => $value)--}}
                                {{--<option value="{{ $key  }}">{{ $value  }}</option>--}}
                                {{--@endforeach--}}
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="btnUpdateTabelaPrecos">Salvar</button>
                <button class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
</div>
<!-- FIM Modal de cadastro das Disciplinas-->