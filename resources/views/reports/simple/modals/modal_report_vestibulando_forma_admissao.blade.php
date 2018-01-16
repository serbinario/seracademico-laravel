<div id="modal-forma-admissao" class="modal fade modal-profile" tabindex="-1" role="dialog" aria-labelledby="modalProfile" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 30%;">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                {{--<h4 class="modal-title">Transfência de vestibulando para aluno</h4>--}}
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <div class="row">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="forma_ingresso">Forma de Ingresso</label>
                            <select name="forma_ingresso" class="form-control" id="forma_ingresso">
                                <option value="1">Enem</option>
                                <option value="0">Vestibular (redação)</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="btnGerarRelatorioFormaIngresso">Gerar</button>
                <button class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>