<!-- Modal principal de disciplinas -->
<div id="modal-report-gra-aluno-por-entrada" class="modal fade modal-profile" tabindex="-1" role="dialog" aria-labelledby="modalProfile"
     aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" id="closeModalHistorico" data-dismiss="modal">×</button>
                <h4 class="modal-title"><i class="material-icons">date_range</i> Filtro - Alunos por Tipo de Entrada (Graduação)</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <div class="row">
                   <div class="col-md-12">
                       <div class="form-group">
                           {!! Form::label('tipos_entrada', 'Tipo de entrada') !!}
                           {!! Form::select('tipos_entrada', [], null, array('class' => 'form-control', 'id' => 'tipo_gra_aluno_por_entrada_id')) !!}
                       </div>
                       <div class="form-group">
                           <button class="btn-sm btn-primary" type="submit" id="btnBuilderReportGraAlunoPorEntrada">Relatório</button>
                       </div>
                   </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- FIM Modal de cadastro das Disciplinas-->