<!-- Modal principal de caderneta -->
<div id="modal-report-dou-prof-vinculo" class="modal fade modal-profile" tabindex="-1" role="dialog" aria-labelledby="modalProfile"
     aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" id="closeModalCaderneta" data-dismiss="modal">×</button>
                <h4 class="modal-title"><i class="material-icons">date_range</i> Filtro - Declaração de Vínculo (doutrado)</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <div class="row">
                   <div class="col-md-12">
                       <div class="form-group">
                           {!! Form::label('professor', 'Professor') !!}
                           {!! Form::select('professor', [], null, array('class' => 'form-control', 'id' => 'dou_professor_id')) !!}
                       </div>
                       <div class="form-group">
                           {!! Form::label('disciplina', 'Disciplina') !!}
                           {!! Form::select('disciplina', [], null, array('class' => 'form-control', 'id' => 'dou_disciplina_id')) !!}
                       </div>
                       <div class="form-group">
                           <button class="btn-sm btn-primary" type="submit" id="btnBuilderReportDouProfessorVinculo">Gerar</button>
                       </div>
                   </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- FIM Modal de cadastro das Disciplinas-->