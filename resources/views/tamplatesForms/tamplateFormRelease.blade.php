<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('data', 'Data') !!}
                    @if(isset($model))
                        {!! Form::text('data', $model->data, array('class' => 'form-control')) !!}
                    @else
                        {!! Form::text('data', (new DateTime('now'))->format('d/m/Y'), array('class' => 'form-control')) !!}
                    @endif
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('tipo_id', 'Tipo de Lançamento') !!}
                    @if(isset($model))
                        {!! Form::select('tipo_id', $model->tipo_id, array('class' => 'form-control')) !!}
                    @else
                        {!! Form::select('tipo_id', $tipoLancamento, Session::getOldInput('tipo_id'), array('class' => 'form-control')) !!}
                    @endif
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('sistema_id', 'Sistema') !!}
                    @if(isset($model))
                        {!! Form::select('sistema_id', $model->sistema_id, array('class' => 'form-control')) !!}
                    @else
                        {!! Form::select('sistema_id', ['' => 'Selecione sistema', '1' => 'SerAcadêmico', '2' => 'Portal do Vestibulando', '3' => 'Portal do Aluno'], Session::getOldInput('sistema_id'), array('class' => 'form-control')) !!}
                    @endif
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('desenvolvedor_id', 'Responsável') !!}
                    @if(isset($model))
                        {!! Form::select('desenvolvedor_id', $model->desenvolvedor_id, array('class' => 'form-control')) !!}
                    @else
                        {!! Form::select('desenvolvedor_id', $desenvolvedor, Session::getOldInput('desenvolvedor_id'), array('class' => 'form-control')) !!}
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('descricao', 'Descrição') !!}
                    @if(isset($model))
                        {!! Form::textarea('descricao', $model->descricao, ['size' => '120x5'], array('class' => 'form-control')) !!}
                    @else
                        {!! Form::textarea('descricao', Session::getOldInput('descricao') , ['size' => '120x5'], array('class' => 'form-control')) !!}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
    <button type="submit" class="btn btn-primary">Salvar</button>
</div>

