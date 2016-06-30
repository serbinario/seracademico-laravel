<!-- Modal principal de disciplinas $loadFields['graduacao\\vestibular']->toArray() -->
<div id="modal-notas-alunos" class="modal fade modal-profile" tabindex="-1" role="dialog" aria-labelledby="modalProfile" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 90%;">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" id="btnCloseModalNotas" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title">Gerenciamento de notas</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <div class="row">
                    <div class="col-md-12">
                        <form id="search-form" class="form-inline" role="form" method="GET">
                            <div class="form-group">
                                {!! Form::select('disciplinaSearch', [], null, array('class' => 'form-control', 'id' => 'disciplinaSearch')) !!}
                            </div>

                            <div class="form-group">
                                <button class="btn btn-primary" type="submit">Pesquisar</button>
                            </div>
                        </form>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        {{--<button class="btn btn-primary pull-right" id="btnIncluirDisciplinas" style="margin-bottom: 3%;">Incluir disciplinas</button>--}}

                        <table id="alunos-notas-grid" class="display table table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th style="width: 40%">Nome</th>
                                <th>1º Unid.</th>
                                <th>2º Unid.</th>
                                <th>2º Chamada</th>
                                <th>Final</th>
                                <th>Média</th>
                                <th>Faltas</th>
                                <th>Situação</th>
                                <th>Ação</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- FIM Modal de cadastro das Disciplinas-->