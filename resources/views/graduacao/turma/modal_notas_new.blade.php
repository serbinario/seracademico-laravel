
<style type="text/css">
#notas-grid{
    font-weight: bold;
}
    
#notas-grid tr:nth-child(even),tr:nth-child(even) input {
background-color:#79CEC8;
color:white;
} 
input, select:focus{ 
    box-shadow: 0 0 0 0;
    border: 0 none;
    outline: 0;

} 
</style>

<div id="modal_notas_new" class="modal fade modal-profile" tabindex="-1" role="dialog" aria-labelledby="modalProfile" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 90%;">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" id="btnCloseModalNotas" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title"><i class="material-icons">spellcheck</i> Gerenciamento de Notas</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <!-- Linha de descrição -->
                <div class="col-md-12 infModal">
                    <div class="col-md-2">
                        <span><strong>Turma: </strong><p id="tnTurma"></p></span>
                    </div>

                    <div class="col-md-2">
                        <span><strong>Período: </strong><p id="tnPeriodo"></p></span>
                    </div>

                    <div class="col-md-2">
                        <span><strong>Currículo: </strong><p id="tnCurriculo"></p></span>
                    </div>

                    <div class="col-md-4">
                        <span><strong>Curso: </strong><p id="tnCurso"></p></span>
                    </div>

                    <div class="col-md-2">
                        <span><strong>Semestre: </strong><p id="tnSemestre"></p></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <form id="search-form" class="form-inline" role="form" method="GET">
                            <div class="form-group">
                                {!! Form::select('disciplinaSearch', [], null, array('class' => 'form-control', 'id' => 'disciplinaSearch')) !!}
                            </div>
                        </form>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        {{--<button class="btn btn-primary pull-right" id="btnIncluirDisciplinas" style="margin-bottom: 3%;">Incluir disciplinas</button>--}}


                        <table id="notas-grid" class="display table table-bordered table-responsive" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th style="width: 7%">1º Unid.</th>
                                    <th style="width: 7%">2º Unid.</th>
                                    <th style="width: 7%">2º Chamada</th>
                                    <th style="width: 7%">Final</th>
                                    <th>Média</th>
                                    <th>Faltas</th>
                                    <th>Situação</th>
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