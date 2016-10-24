<!-- Modal principal de disciplinas -->
<div id="modal-turma-aluno" class="modal fade modal-profile" role="dialog" aria-labelledby="modalProfile"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title">Histórico do Aluno</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Linha de descrição -->
                        <div class="col-md-12 infModal">
                            <div class="col-md-4">
                                <span><strong>Matrícula: </strong><p id="ctMatricula"></p></span>
                            </div>

                            <div class="col-md-4">
                                <span><strong>Nome do Aluno: </strong><p id="ctNomeAluno"></p></span>
                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col-md-12">
                                <a href="#" id="adicionar-curso" class="btn-sm btn-primary pull-right">Adicionar Curso</a><br><br>
                                <table id="curso-turma-grid" class="display table table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>Cód. Curso</th>
                                        {{--<th>Desc. Curso</th>--}}
                                        <th>Cód. Currículo</th>
                                        {{--<th>Desc. Currículo</th>--}}
                                        <th>Situação</th>
                                        <th>Data de início</th>
                                        <th>Cód. Turma</th>
                                        <th>Ação</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-12">
                        <a href="#" id="btnAdicionarSituacao" class="btn-sm btn-primary pull-right">Adicionar Situação</a><br><br>
                        <table id="situacao-grid" class="display table table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>Curso</th>
                                <th>Currículo</th>
                                <th>Situação</th>
                                <th>Turma</th>
                                {{--<th>Turma Destino</th>--}}
                                <th>Ação</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                {{--<div class="row">--}}
                    {{--<div class="col-md-12">--}}
                        {{--<!-- Nav tabs -->--}}
                        {{--<ul class="nav nav-tabs" role="tablist">--}}
                            {{--<li role="presentation" class="active">--}}
                                {{--<a href="#acursar" aria-controls="acursar" data-toggle="tab">A cursar</a>--}}
                            {{--</li>--}}
                            {{--<li role="presentation">--}}
                                {{--<a href="#cursando" aria-controls="cursando" role="tab" data-toggle="tab">Cursadas</a>--}}
                            {{--</li>--}}
                            {{--<li role="presentation">--}}
                                {{--<a href="#dispensadas" aria-controls="dispensadas" role="tab" data-toggle="tab">Dispensadas</a>--}}
                            {{--</li>--}}
                        {{--</ul>--}}
                        {{--<!-- End Nav tabs -->--}}

                        {{--<!-- Tab panes -->--}}
                        {{--<div class="tab-content">--}}

                            {{--ABA A CURSAR--}}
                            {{--<div role="tabpanel" class="tab-pane active" id="acursar">--}}
                                {{--<br/>--}}

                                {{--<table id="grid-acursar" class="display table table-bordered" cellspacing="0"--}}
                                       {{--width="100%">--}}
                                    {{--<thead>--}}
                                    {{--<tr>--}}
                                        {{--<th>CÓD.DISCIPLINA</th>--}}
                                        {{--<th>DESC.DISCIPLINA</th>--}}
                                        {{--<th>CÓD.TURMA</th>--}}
                                        {{--<th>MÉDIA</th>--}}
                                        {{--<th>SITUAÇÃO</th>--}}
                                    {{--</tr>--}}
                                    {{--</thead>--}}

                                {{--</table>--}}
                            {{--</div>--}}
                            {{--FIM A CURSAR--}}

                            {{--Aba Banca Examinadora--}}
                            {{--<div role="tabpanel" class="tab-pane" id="cursando">--}}
                                {{--<br/>--}}

                                {{--<table id="grid-cursadas" class="display table table-bordered" cellspacing="0"--}}
                                       {{--width="100%">--}}
                                    {{--<thead>--}}
                                    {{--<tr>--}}
                                        {{--<th>CÓD.DISCIPLINA</th>--}}
                                        {{--<th>DESC.DISCIPLINA</th>--}}
                                        {{--<th>CÓD.TURMA</th>--}}
                                        {{--<th>MÉDIA</th>--}}
                                        {{--<th>SITUAÇÃO</th>--}}
                                    {{--</tr>--}}
                                    {{--</thead>--}}

                                {{--</table>--}}
                            {{--</div>--}}
                            {{--FIM Aba Banca Examinadora --}}

                            {{--Aba Formatura--}}
                            {{--<div role="tabpanel" class="tab-pane" id="dispensadas">--}}
                                {{--<br/>--}}

                                {{--<table id="grid-dispensadas" class="display table table-bordered" cellspacing="0"--}}
                                       {{--width="100%">--}}
                                    {{--<thead>--}}
                                    {{--<tr>--}}
                                        {{--<th>CÓD.DISCIPLINA</th>--}}
                                        {{--<th>DESC.DISCIPLINA</th>--}}
                                        {{--<th>CÓD.TURMA</th>--}}
                                        {{--<th>MÉDIA</th>--}}
                                        {{--<th>SITUAÇÃO</th>--}}
                                    {{--</tr>--}}
                                    {{--</thead>--}}

                                {{--</table>--}}
                            {{--</div>--}}
                            {{--Aba Formatura--}}


                        {{--</div>--}}
                        {{--<!-- FIM Tab panes -->--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--FIM Linha da da Abas--}}
            </div>
        </div>
    </div>
</div>
</div>
<!-- FIM Modal de cadastro das Disciplinas-->