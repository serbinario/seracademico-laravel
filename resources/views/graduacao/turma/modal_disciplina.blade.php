<!-- Modal principal de disciplinas -->
<div id="modal-disciplina-horario" class="modal fade modal-profile" tabindex="-1" role="dialog" aria-labelledby="modalProfile" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title">Horário das disciplinas</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <div class="row">
                    <div class="col-md-5">
                        <button class="btn btn-primary pull-right" id="btnIncluirDisciplinas" style="margin-bottom: 3%;">Incluir disciplinas</button>

                        <table id="disciplina-grid" class="display table table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Disciplina</th>
                                <th>Ação</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="col-md-7">

                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#horario" aria-controls="horario" data-toggle="tab"><i class="material-icons">collections_time</i> Horário</a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">

                            {{--Aba Pré - Reuisitos--}}
                            <div role="tabpanel" class="tab-pane active" id="horario">
                                <br/>

                                {{--<button class="btn btn-primary pull-right" id="btnAddCalendario" data-toggle="modal" data-target="#modal-novo-calendario" disabled="disabled" style="margin-bottom: 2%;">Novo calendário</button>--}}

                                <table id="horario-grid" class="display table table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>Hora</th>
                                        <th>Dom</th>
                                        <th>Seg</th>
                                        <th>Ter</th>
                                        <th>Qua</th>
                                        <th>Qui</th>
                                        <th>Sex</th>
                                        <th>Sab</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                            {{--FIM Aba Horario--}}
                        </div>
                        <!-- FIM Tab panes -->

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- FIM Modal de cadastro das Disciplinas-->