<!-- Modal de cadastro das Disciplinas-->
<div id="modal-material" class="modal fade modal-profile" role="dialog" aria-labelledby="modalProfile" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title">Adicionar materiais ao módulo</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row" style="margin-bottom: 3%;">
                            <div class="col-md-6">
                                <div class="fg-line">
                                    {!! Form::label('nome', 'Nome do material') !!}
                                    <input type="text" class="form-control" name="nome" id="nome">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="fg-line">
                                    {!! Form::label('file', 'Material') !!}
                                    <input type="file" class="form-control" name="file" id="file">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="fg-line">
                                    <button class="btn btn-sm btn-primary" type="button" id="addMaterial" style="margin-top:23px">Adicionar Material</button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table id="material-grid" class=" table table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Acão</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Nome</th>
                                        <th style="width: 5%;">Acão</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- FIM Modal de cadastro das Disciplinas-->