<!-- Modal principal de disciplinas -->
<div id="modal-assinar-termo" class="modal fade modal-profile" tabindex="-1" role="dialog" aria-labelledby="modalProfile"
     aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" id="closeModalHistorico" data-dismiss="modal">×</button>
                <h4 class="modal-title"><i class="material-icons">date_range</i> Assinatura do termo de biblioteca</h4>
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <div class="row">
                   <div class="col-md-12">
                       {!! Form::open(['route'=>'seracademico.biblioteca.confirmarTermoBiblioteca', 'method' => "POST", 'id' => 'formModal', 'target' => '__blank' ]) !!}

                            <div class="form-group">
                               <input type="hidden" value="" id="tipoPessoa" name="tipo_pessoa">
                                <input type="hidden" value="" id="idAlunoProfessor" name="idAlunoProfessor">
                           </div>

                           <div class="form-group">
                               <button class="btn-sm btn-primary" type="submit">Confirmar assinatura</button>
                           </div>

                       {!! Form::close() !!}
                   </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- FIM Modal de cadastro das Disciplinas-->