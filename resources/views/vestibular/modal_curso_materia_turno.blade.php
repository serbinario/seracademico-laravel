<!-- Modal principal de disciplinas -->
<div id="modal-curso-materia-turno" class="modal fade modal-profile" tabindex="-1" role="dialog" aria-labelledby="modalProfile" aria-hidden="true">
    <div class="modal-dialog" style="width: 90%;">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title">Gerenciamento dos cursos do vestibular</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <div class="row">
                    <div class="col-md-5">
                        <select name="select_curso" id="select_curso" multiple="multiple"></select>
                        <button class="btn btn-primary pull-right" id="btnIncluirCursos" style="margin-bottom: 3%;">Incluir Cursos</button>
                        <table id="curso-grid" class="display table table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Código</th>
                                <th>Curso</th>
                                <th>Ação</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="col-md-7">

                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#materia" aria-controls="materia" data-toggle="tab"><i class="material-icons">collections_time</i> Matérias</a>
                            </li>
                            <li role="presentation">
                                <a href="#turno" aria-controls="turno" data-toggle="tab"><i class="material-icons">collections_time</i> Turnos</a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">

                            {{--Aba Pré - Matéria--}}
                            <div role="tabpanel" class="tab-pane active" id="materia">
                                <br/>

                                <table id="materia-grid" class="display table table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th style="width: 10%">Código</th>
                                        <th>Matéria</th>
                                        <th style="width: 10%">Peso</th>
                                        <th style="width: 15%">Qtd. Quest.</th>
                                        <th style="width: 5%">Ação</th>
                                    </tr>
                                    </thead>
                                </table>

                                <div class="row">
                                    <div class="col-md-5 col-md-offset-7">
                                        <div class="btn-group btn-group-justified">
                                            <div class="btn-group">
                                                <button class="btn btn-primary pull-right" id="btnAdicionarCursoMateria" disabled="disabled" style="margin-bottom: 3%;">Adicionar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{--FIM Aba Horario--}}

                            {{--Aba Pré - Turno--}}
                            <div role="tabpanel" class="tab-pane" id="turno">
                                <br/>

                                {{--<button class="btn btn-primary pull-right" id="btnAddCalendario" data-toggle="modal" data-target="#modal-novo-calendario" disabled="disabled" style="margin-bottom: 2%;">Novo calendário</button>--}}

                                <table id="turno-grid" class="display table table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>Turno</th>
                                        <th>Descrição</th>
                                        <th>Vagas</th>
                                        <th>Ação</th>
                                    </tr>
                                    </thead>
                                </table>

                                <div class="row">
                                    <div class="col-md-5 col-md-offset-7">
                                        <div class="btn-group btn-group-justified">
                                            <div class="btn-group">
                                                <button class="btn btn-primary pull-right" id="btnAdicionarCursoTurno" disabled="disabled" style="margin-bottom: 3%;">Adicionar</button>
                                            </div>
                                            {{--<div class="btn-group">--}}
                                            {{--<button class="btn btn-primary pull-right" id="btnEditarHorario" style="margin-bottom: 3%;">Editar</button>--}}
                                            {{--</div>--}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{--FIM Aba Turno--}}

                        </div>
                        <!-- FIM Tab panes -->

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- FIM Modal de cadastro das Disciplinas-->