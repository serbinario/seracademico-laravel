<!-- Modal principal de disciplinas -->
<div id="modal-agendamento-aluno" class="modal fade modal-profile" role="dialog" aria-labelledby="modalProfile" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title">Agendar aluno na segunda chamada</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <div class="row">
                    <!-- Linha de descrição -->
                    <div class="col-md-12 infModal">
                        <div class="col-md-12">
                            <span><strong>Data: </strong><p id="dtAgendamento"></p></span>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <table id="agendamento-disciplina-grid" class="display table table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Disciplina</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="col-md-7">
                        <div class="row">
                            <form id="aluno-search-form" class="form-inline" role="form" method="GET">
                                <div class="form-group">
                                    {!! Form::select('aluno', [], null, array('class' => 'form-control', 'id' => 'aluno')) !!}
                                </div>

                                <div class="form-group">
                                    <button class="btn-sm btn-primary" id="addAluno" type="button">Adicionar aluno</button>
                                </div>
                            </form>
                        </div>
                        <div class="row">
                            <table id="agendamento-aluno-grid" class="display table table-bordered" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>Aluno</th>
                                    <th style="width: 10%">Acão</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- FIM Modal de cadastro das Disciplinas-->