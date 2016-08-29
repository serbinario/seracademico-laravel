<!-- Modal principal de disciplinas $loadFields['graduacao\\vestibular']->toArray() -->
<div id="modal-frequencias-alunos" class="modal fade modal-profile" tabindex="-1" role="dialog" aria-labelledby="modalProfile" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 90%;">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" id="btnCloseModalFrequencias" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title"><i class="material-icons">playlist_add_check</i> Gerenciamento de frequencias</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <!-- Linha de descrição -->
                <div class="col-md-12 infModal">
                    <div class="col-md-2">
                        <span><strong>Turma: </strong><p id="tfTurma"></p></span>
                    </div>

                    <div class="col-md-2">
                        <span><strong>Período: </strong><p id="tfPeriodo"></p></span>
                    </div>

                    <div class="col-md-2">
                        <span><strong>Currículo: </strong><p id="tfCurriculo"></p></span>
                    </div>

                    <div class="col-md-4">
                        <span><strong>Curso: </strong><p id="tfCurso"></p></span>
                    </div>

                    <div class="col-md-2">
                        <span><strong>Semestre: </strong><p id="tfSemestre"></p></span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <form id="frequencias-search-form" class="form-inline" role="form" method="GET">
                            <div class="form-group">
                                {!! Form::select('disciplinaFrequenciasSearch', [], null, array('class' => 'form-control', 'id' => 'disciplinaFrequenciasSearch')) !!}
                            </div>

                            <div class="form-group">
                                <button class="btn-sm btn-primary" type="submit">Pesquisar</button>
                            </div>
                        </form>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        {{--<button class="btn btn-primary pull-right" id="btnIncluirDisciplinas" style="margin-bottom: 3%;">Incluir disciplinas</button>--}}

                        <table id="alunos-frequencias-grid" class="display table table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th style="width: 100%">Nome</th>
                                <th>1º Mês.</th>
                                <th>2º Mês</th>
                                <th>3º Mês</th>
                                <th>4º Mês</th>
                                <th>5º Mês</th>
                                <th>6º Mês</th>
                                <th>Total Faltas</th>
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