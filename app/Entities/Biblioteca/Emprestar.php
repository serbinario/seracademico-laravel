<?php

namespace Seracademico\Entities\Biblioteca;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Entities\Aluno;

class Emprestar extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'bib_emprestimos';

    protected $fillable = [ 
		'alunos_id',
		'codigo',
		'data',
		'data_devolucao',
		'data_devolucao_real',
		'tipo_emprestimo',
	];

	public function aluno()
	{
		return $this->belongsTo(Aluno::class, 'alunos_id');
	}

	public function emprestimoExemplar()
	{
		return $this->belongsToMany(Exemplar::class, 'bib_emprestimos_exemplares', 'emprestimo_id', "exemplar_id");
	}

}