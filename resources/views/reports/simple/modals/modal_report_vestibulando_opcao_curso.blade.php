<div id="modal-opcao-por-curso" class="modal fade modal-profile" tabindex="-1" role="dialog" aria-labelledby="modalProfile" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 30%;">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                {{--<h4 class="modal-title">Transfência de vestibulando para aluno</h4>--}}
            </div>
            <div class="modal-body" style="alignment-baseline: central">
                <div class="row">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="cursos">Curso</label>
                            <select name="cursos" class="form-control" id="cursos">
                                @foreach($selectCursos as $key => $nomeCurso)
                                    <option value="{{$key}}">{{$nomeCurso}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="btnGerarRelatorioOpcaoPorCurso">Gerar</button>
                <button class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>