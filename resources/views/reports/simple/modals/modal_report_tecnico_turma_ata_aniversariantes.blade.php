<!-- Modal principal de disciplinas -->
<div id="modal-report-tec-turma-ata-aniversariante" class="modal fade modal-profile" tabindex="-1" role="dialog" aria-labelledby="modalProfile"
     aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" id="closeModalHistorico" data-dismiss="modal">×</button>
                <h4 class="modal-title"><i class="material-icons">date_range</i> Filtro - Ata de Aniversariantes</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <div class="row">
                   <div class="col-md-12">
                       <div class="form-group">
                           {!! Form::label('cursos', 'Cursos') !!}
                           {!! Form::select('cursos', [], null, array('class' => 'form-control', 'id' => 'curso_tec_turma_ata_aniversariante_id')) !!}
                       </div>

                       <div class="form-group">
                           {!! Form::label('turmas', 'Turmas') !!}
                           {!! Form::select('turmas', [], null, array('class' => 'form-control', 'id' => 'turma_tec_turma_ata_aniversariante_id')) !!}
                       </div>

                       <div class="form-group">
                           {!! Form::label('disciplinas', 'Mês') !!}
                           {!! Form::select('disciplinas',
                            [1 => 'Janiero', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril', 5 => 'Maio', 6 => 'Junho',
                             7 => 'Julho', 8 => 'Agosto', 9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'],
                             date('m'), array('class' => 'form-control', 'id' => 'mes_aniversario_tec_turma_ata_aniversariante')) !!}
                       </div>

                       <div class="form-group">
                           <button class="btn-sm btn-primary" type="submit" id="btnBuilderReportTecTurmaAtaAniversariante">Relatório</button>
                       </div>
                   </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- FIM Modal de cadastro das Disciplinas-->