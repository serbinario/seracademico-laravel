<div class="row">
	<div class="col-md-12">
		<div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('data', 'Data *') !!}
                    {!! Form::text('data', Session::getOldInput('data')  , array('class' => 'form-control date')) !!}
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('hora_inicio', 'Hoara inicial *') !!}
                    {!! Form::text('hora_inicio', Session::getOldInput('hora_inicio')  , array('class' => 'form-control time')) !!}
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('hora_final', 'Hoara final *') !!}
                    {!! Form::text('hora_final', Session::getOldInput('hora_final')  , array('class' => 'form-control time')) !!}
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('hora_entrada', 'Hoara de entrada *') !!}
                    {!! Form::text('hora_entrada', Session::getOldInput('hora_entrada')  , array('class' => 'form-control time')) !!}
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('agendamento_tp_id', 'Tipo da prova *') !!}
                    {!! Form::select('agendamento_tp_id', $loadFields['tecnico\\agendamentotipoprova'], null,  array('class' => 'form-control')) !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('curso', 'Curso *') !!}
                    {!! Form::select('curso', (['' => 'Selecione uma disciplina'] + $loadFields['tecnico\\curso']->toArray()), null,  array('id' => 'curso', 'class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('disciplina', 'Disciplina *') !!}
                    {!! Form::select('disciplina', array(), null,  array('id' => 'disciplina', 'class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <button style="margin-top: 18px" type="button" id="add-disciplina" class="btn btn-primary btn-small">Adicionar</button>
                </div>
            </div>

            <div class="col-md-12">
                <table id="table-disciplinas" class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Curso</th>
                        <th>Disciplina</th>
                        <th>Ação</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($model->disciplinas))
                        @foreach($model->disciplinas as $disciplina)
                            <tr>
                                <td>@if(isset($disciplina->curriculos->last()->curso->nome)){{ $disciplina->curriculos->last()->curso->nome }}@endif</td>
                                <td>@if(isset($disciplina->nome)){{ $disciplina->nome }}@endif
                                    <input type='hidden' name='disciplinas[]' value='@if(isset($disciplina->id)){{ $disciplina->id }}@endif'></td>
                                <td style='width: 10px'><button type='button' class='btn btn-danger delete-disciplina'>Excluir</button></td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
		</div>

        {{--Buttons Submit e Voltar--}}
        <div class="row">
            <div class="col-md-9"></div>
            <div class="col-md-3">
                <div class="btn-group btn-group-justified">
                <div class="btn-group">
                <a href="{{ route('seracademico.tecnico.agendamento.index') }}" class="btn btn-primary btn-block"><i class="fa fa-long-arrow-left"></i>  Voltar</a></div>
                <div class="btn-group">
                {!! Form::submit('Salvar', array('class' => 'btn btn-primary btn-block')) !!}
                </div>
            </div>
        </div>
        {{--Fim Buttons Submit e Voltar--}}

	</div>
</div>
</div>

@section('javascript')
    <script type="text/javascript">
        //Carregando as cidades
        $(document).on('change', "#curso", function () {

            //Removendo as disciplinas
            $('#disciplina option').remove();

            //Recuperando o estado
            var curso = $(this).val();

            if (curso !== "") {

                var dados = {
                    'curso': curso
                };

                jQuery.ajax({
                    type: 'POST',
                    url: '{{ route('seracademico.tecnico.agendamento.getdisciplina')  }}',
                    data: dados,
                    datatype: 'json'
                }).done(function (json) {
                    var option = "";

                    option += '<option value="">Selecione uma disciplina</option>';
                    for (var i = 0; i < json.length; i++) {
                        option += '<option value="' + json[i]['id'] + '">' + json[i]['nome'] + '</option>';
                    }

                    $('#disciplina option').remove();
                    $('#disciplina').append(option);
                });
            }
        });

        // Ação para adicionar disciplinas
        $(document).on('click', '#add-disciplina', function () {

            var cursoTxt        = $('select[id=curso] option:selected').text();
            var disciplinaTxt   = $('select[id=disciplina] option:selected').text();
            var disciplina      = $('#disciplina').val();
            var html            = "";

            // Validando os campos obrigatórios
            if (!cursoTxt && !disciplina) {
                return false;
            }

            // Criando o corpo da tabela
            html += "<tr>";
            html += "<td>"+cursoTxt+"<input type='hidden' name='' value='"+cursoTxt+"'>"+"</td>";
            html += "<td>"+disciplinaTxt+"<input type='hidden' name='disciplinas[]' value='"+disciplina+"'>"+"</td>";
            html += "<td style='width: 10px'><button type='button' class='btn btn-danger delete-disciplina'>Excluir</button></td>";
            html += "</tr>";

            $('#table-disciplinas tbody').prepend(html);

        });

        // Ação para deletar uma tr da tabela de disciplinas
        $('#table-disciplinas').on('click', '.delete-disciplina', function(){
            $(this).closest('tbody tr').remove().fadeOut(300);
        });
    </script>
@stop