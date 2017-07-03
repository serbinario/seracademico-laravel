<!-- Modal de cadastro das Disciplinas-->
<div id="modal-grade-curricular" class="modal fade modal-profile" role="dialog" aria-labelledby="modalProfile" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title">Adicionar disciplinas ao currículo</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row" style="margin-bottom: 3%;">
                            <div class="col-md-3">
                                <div class="fg-line">
                                    {!! Form::label('', 'Módulo') !!}
                                    {!! Form::select('modulo_id', ([0 => "Selecione o módulo"] + $modulos), Session::getOldInput('modulo_id'), array('class' => 'form-control', 'id' => 'modulo_id')) !!}
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <label>Disciplinas</label>
                                    <select  id="select-disciplina" multiple="multiple" class="form-control"></select>
                                        <span class="input-group-btn">
                                            <button class="btn btn-sm btn-primary" type="button" id="addDisciplina" style="margin-top:23px">Adicionar Disciplinas</button>
                                        </span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table id="disciplina-grid" class="display table table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th style="width: 5%;">Qtd. Faltas</th>
                                        <th style="width: 10%;">Tipo da disciplina</th>
                                        <th style="width: 10%;">Modulo</th>
                                        <th >Acão</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Nome</th>
                                        <th style="width: 5%;">Qtd. Faltas</th>
                                        <th style="width: 10%;">Tipo da disciplina</th>
                                        <th style="width: 10%;">Modulo</th>
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