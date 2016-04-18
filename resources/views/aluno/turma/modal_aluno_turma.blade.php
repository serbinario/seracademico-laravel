<!-- Modal principal de disciplinas -->
<div id="modal-turma-aluno" class="modal fade modal-profile" role="dialog" aria-labelledby="modalProfile" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title">Vinculano o aluno a uma turma</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <div class="row">
                    <div class="col-md-12">
                        <a  href="#" id="adicionar-curso" class="btn-sm btn-primary">Adcionar curso</a><br><br>
                        <table id="curso-turma-grid" class="display table table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>CÓD. DO CURSO</th>
                                <th>DESC. DO CURSO</th>
                                <th>CÓD. CURRÍCULO</th>
                                <th>DESC. CURRÍCULO</th>
                                <th>SITUAÇÃO</th>
                                <th>DATA DE INÍCIO</th>
                                <th>COD. DA TURMA</th>
                                <th>AÇÃO</th>
                            </tr>
                            </thead>

                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#acursar" aria-controls="acursar" data-toggle="tab"><i class="fa fa-male"></i> A cursar</a>
                            </li>
                            <li role="presentation">
                                <a href="#cursando" aria-controls="cursando" role="tab" data-toggle="tab"><i class="fa fa-file-text"></i> Cursadas</a>
                            </li>
                            <li role="presentation">
                                <a href="#dispensadas" aria-controls="dispensadas" role="tab" data-toggle="tab"><i class="fa fa-globe"></i> Dispensadas</a>
                            </li>
                        </ul>
                        <!-- End Nav tabs -->

                        <!-- Tab panes -->
                        <div class="tab-content">

                            {{--ABA A CURSAR--}}
                            <div role="tabpanel" class="tab-pane active" id="acursar">
                                <br/>

                                <table id="grid-acursar" class="display table table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>CÓD.DISCIPLINA</th>
                                        {{--<th>DESC.DISCIPLINA</th>--}}
                                        <th>CÓD.TURMA</th>
                                        <th>MÉDIA</th>
                                        <th>SITUAÇÃO</th>
                                    </tr>
                                    </thead>

                                </table>
                            </div>
                            {{--FIM A CURSAR--}}

                            {{--Aba Banca Examinadora--}}
                            <div role="tabpanel" class="tab-pane" id="cursando">
                                <br/>

                                <table id="grid-cursadas" class="display table table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>CÓD.DISCIPLINA</th>
                                        {{--<th>DESC.DISCIPLINA</th>--}}
                                        <th>CÓD.TURMA</th>
                                        <th>MÉDIA</th>
                                        <th>SITUAÇÃO</th>
                                    </tr>
                                    </thead>

                                </table>
                            </div>
                            {{--FIM Aba Banca Examinadora --}}

                            {{--Aba Formatura--}}
                            <div role="tabpanel" class="tab-pane" id="dispensadas">
                                <br/>

                                <table id="grid-dispensadas" class="display table table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>CÓD.DISCIPLINA</th>
                                        {{--<th>DESC.DISCIPLINA</th>--}}
                                        <th>CÓD.TURMA</th>
                                        <th>MÉDIA</th>
                                        <th>SITUAÇÃO</th>
                                    </tr>
                                    </thead>

                                </table>
                            </div>
                            {{--Aba Formatura--}}


                        </div>
                        <!-- FIM Tab panes -->
                    </div>
                </div>
                {{--FIM Linha da da Abas--}}

            </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
<!-- FIM Modal de cadastro das Disciplinas-->