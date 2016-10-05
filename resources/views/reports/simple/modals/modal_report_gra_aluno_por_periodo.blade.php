<!-- Modal principal de disciplinas -->
<div id="modal-report-gra-aluno-por-periodo" class="modal fade modal-profile" tabindex="-1" role="dialog" aria-labelledby="modalProfile"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" id="closeModalHistorico" data-dismiss="modal">×</button>
                <h4 class="modal-title"><i class="material-icons">date_range</i> Filtro - Alunos por Período (Graduação)</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <div class="row">
                   <div class="col-md-12">
                       <div class="form-group">
                           {!! Form::label('semestres', 'Semestres') !!}
                           {!! Form::select('semestres', [], null, array('class' => 'form-control', 'id' => 'semestre_gra_aluno_por_periodo_id')) !!}
                       </div>

                       <div class="form-group">
                           {!! Form::label('periodos', 'Período') !!}
                           {!! Form::select('periodos', [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10], null, array('class' => 'form-control', 'id' => 'periodo_gra_aluno_por_periodo_id')) !!}
                       </div>

                       <div class="form-group">
                           {!! Form::label('cursos', 'Cursos') !!}
                           {!! Form::select('cursos', [], null, array('class' => 'form-control', 'id' => 'curso_gra_aluno_por_periodo_id')) !!}
                       </div>

                       <div class="form-group">
                           <button class="btn-sm btn-primary" type="submit" id="btnBuilderReportGraAlunoPorPeriodo">Relatório</button>
                       </div>
                   </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- FIM Modal de cadastro das Disciplinas-->