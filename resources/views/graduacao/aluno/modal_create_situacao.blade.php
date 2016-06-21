<!-- Modal principal de disciplinas -->
<div id="modal-create-situacao" class="modal fade modal-profile" tabindex="-1" role="dialog" aria-labelledby="modalProfile" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 30%;">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title">Nova Situação</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <div class="row">
                    {{--<div class="row">--}}
                        {{--<div class="form-group col-md-12">--}}
                            {{--<label for="curso_id">Curso</label>--}}
                            {{--<select name="curso_id" class="form-control" id="curso_id">--}}
                            {{--</select>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="situacao_id">Situação</label>
                            <select name="situacao_id" class="form-control" id="situacao_id">
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="observacao">Observação</label>
                            <input type="text" name="observacao" class="form-control" id="observacao">
                        </div>
                    </div>
                    {{--@role('admin')--}}
                    {{--<div class="row">--}}
                        {{--<div class="form-group col-md-12">--}}
                            {{--<label for="semestre_id">Semestre</label>--}}
                            {{--<select name="semestre_id" class="form-control" id="semestre_id">--}}
                            {{--</select>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--@endrole--}}

                    {{--<div class="row">--}}
                        {{--<div class="form-group col-md-12">--}}
                            {{--<label for="periodo">Período</label>--}}
                            {{--<input type="text" name="periodo" class="form-control" id="periodo">--}}
                        {{--</div>--}}
                    {{--</div>--}}

                        {{--<div class="row">--}}
                            {{--<div class="form-group col-md-6">--}}
                                {{--<label for="data_inclusao">Data</label>--}}
                                {{--<input type="text" class="form-control datepicker" name="data_inclusao" id="data_inclusao">--}}
                            {{--</div>--}}
                        {{--</div>--}}
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="btnSaveSituacao">Salvar</button>
                <button class="btn btn-default" data-dismiss="modal" id="btnCancelSituacao">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- FIM Modal de cadastro das Disciplinas-->