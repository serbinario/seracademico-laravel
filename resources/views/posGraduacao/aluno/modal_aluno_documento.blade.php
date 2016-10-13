<!-- Modal principal de disciplinas -->
<div id="modal-aluno-documento" class="modal fade modal-profile" tabindex="-1" role="dialog" aria-labelledby="modalProfile" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 30%;">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title">Gerar Documento</h4>
            </div>
            {!! Form::open(['route'=>'seracademico.posgraduacao.aluno.documentos', 'method' => "GET", 'id' => 'formAluno', 'target' => '_black']) !!}
                <div class="modal-body" style="alignment-baseline: central">
                    <div class="row">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="documentacao_id">Documento</label>
                                <select name="documentacao_id" class="form-control" id="documentacao_id">
                                </select>
                                <input type="hidden" name="id_aluno" id="id_aluno" value="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" id="btnGerarDocumento">Salvar</button>
                    <button class="btn btn-default" data-dismiss="modal" id="btnCancelDocumento">Cancelar</button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
<!-- FIM Modal de cadastro das Disciplinas-->