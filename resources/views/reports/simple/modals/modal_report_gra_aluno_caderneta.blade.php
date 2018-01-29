<!-- Modal principal de caderneta -->
<div id="modal-report-gra-aluno-caderneta" class="modal fade modal-profile" tabindex="-1" role="dialog" aria-labelledby="modalProfile"
     aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" id="closeModalCaderneta" data-dismiss="modal">×</button>
                <h4 class="modal-title"><i class="material-icons">date_range</i> Filtro - Caderneta de Turma (Graduação)</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <div class="row">
                   <div class="col-md-12">
                       <div class="form-group">
                           {!! Form::label('cursos', 'Cursos') !!}
                           {!! Form::select('cursos', [], null, array('class' => 'form-control', 'id' => 'curso_pos_turma_caderneta_id')) !!}
                       </div>

                       <div class="form-group">
                           {!! Form::label('turmas', 'Turmas') !!}
                           {!! Form::select('turmas', [], null, array('class' => 'form-control', 'id' => 'turma_pos_turma_caderneta_id')) !!}
                       </div>

                       <div class="form-group">
                           {!! Form::label('disciplinas', 'Disciplinas') !!}
                           {!! Form::select('disciplinas', [], null, array('class' => 'form-control', 'id' => 'disciplina_pos_turma_caderneta_id')) !!}
                       </div>

                       <div class="form-group">
                           <button class="btn-sm btn-primary" type="submit" id="btnBuilderReportGraAlunoCaderneta">Gerar</button>
                       </div>
                   </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- FIM Modal de cadastro das Disciplinas-->