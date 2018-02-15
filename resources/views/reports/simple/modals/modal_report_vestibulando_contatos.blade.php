<!-- Modal principal de disciplinas -->
<div id="modal-report-vestibulando-contatos" class="modal fade modal-profile" tabindex="-1" role="dialog" aria-labelledby="modalProfile"
     aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" id="closeModalHistorico" data-dismiss="modal">×</button>
                <h4 class="modal-title"><i class="material-icons">date_range</i> Filtro - Alunos Vestibulando - Contatos</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <div class="row">
                   <div class="col-md-12">
                       <div class="form-group">
                           {!! Form::label('cursos', 'Cursos') !!}
                           <select name="cursos" class="form-control" id="curno_vestibulando_contatos_id">
                               @foreach($selectCursos as $key => $nomeCurso)
                                   <option value="{{$key}}">{{$nomeCurso}}</option>
                               @endforeach
                           </select>
                       </div>
                       <div class="form-group">
                           {!! Form::label('turnos', 'Turnos') !!}
                           {!! Form::select('turnos', [], null, array('class' => 'form-control', 'id' => 'turno_vestibulando_contatos_id')) !!}
                       </div>
                       <div class="form-group">
                           <button class="btn-sm btn-primary" type="submit" id="btnBuilderReportVestibulandooContatos">Relatório</button>
                       </div>
                   </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- FIM Modal de cadastro das Disciplinas-->