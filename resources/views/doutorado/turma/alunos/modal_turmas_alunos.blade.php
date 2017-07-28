<!-- Modal principal de disciplinas -->
<div id="modal-turmas-alunos" class="modal fade modal-profile" tabindex="-1" role="dialog" aria-labelledby="modalProfile" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" id="btnCloseModalNotas" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title"><i class="material-icons">spellcheck</i> Gerenciamento de Alunos</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <!-- Linha de descrição -->
                <div class="col-md-12 infModal">
                    <div class="col-md-4">
                        <span><strong>Turma: </strong><p id="gaTurma"></p></span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <form id="search-form-alunos" class="form-inline" role="form" method="GET">
                            <div class="form-group">
                                {!! Form::select('disciplinaTurmaALunoSearch', [], null, array('class' => 'form-control', 'id' => 'disciplinaTurmaALunoSearch')) !!}
                                {!! Form::select('calendarioTurmaALunoSearch', ['' => 'Selecione um Calendário'], null, array('class' => 'form-control', 'id' => 'calendarioTurmaALunoSearch')) !!}
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
                        <table id="alunos-grid" class="display table table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th style="width: 40%">Nome</th>
                                <th>Status</th>
                                {{--<th>Disciplina</th>--}}
                                {{--<th>Situação</th>--}}
                                {{--<th>Ação</th>--}}
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 col-md-offset-8">
                        <button class="btn btn-primary pull-right" id="btnAddAluno" style="margin-bottom: 3%;">Adicionar Aluno (Reposição)</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- FIM Modal de cadastro das Disciplinas-->