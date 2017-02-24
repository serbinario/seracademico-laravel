<!-- Modal principal de disciplinas -->
<div id="modal-report-mes-turma-ata-assinatura" class="modal fade modal-profile" tabindex="-1" role="dialog" aria-labelledby="modalProfile"
     aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" id="closeModalHistorico" data-dismiss="modal">×</button>
                <h4 class="modal-title"><i class="material-icons">date_range</i> Filtro - Ata de Assinatura</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <div class="row">
                   <div class="col-md-12">
                       <div class="form-group">
                           {!! Form::label('cursos', 'Cursos') !!}
                           {!! Form::select('cursos', [], null, array('class' => 'form-control', 'id' => 'curso_mes_turma_ata_assinatura_id')) !!}
                       </div>

                       <div class="form-group">
                           {!! Form::label('turmas', 'Turmas') !!}
                           {!! Form::select('turmas', [], null, array('class' => 'form-control', 'id' => 'turma_mes_turma_ata_assinatura_id')) !!}
                       </div>

                       <div class="form-group">
                           {!! Form::label('disciplinas', 'Disciplinas') !!}
                           {!! Form::select('disciplinas', [], null, array('class' => 'form-control', 'id' => 'disciplina_mes_turma_ata_assinatura_id')) !!}
                       </div>

                       <div class="form-group">
                           {!! Form::label('turnos', 'Turnos') !!}
                           {!! Form::select('turnos', [0 => 'Selecione um turno', 'Manhã' => 'Manhã', 'Tarde' => 'Tarde'], null, array('class' => 'form-control', 'id' => 'turno_mes_turma_ata_assinatura_id')) !!}
                       </div>

                       <div class="form-group">
                           <button class="btn-sm btn-primary" type="submit" id="btnBuilderReportMesTurmaAtaAssinatura">Relatório</button>
                       </div>
                   </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- FIM Modal de cadastro das Disciplinas-->