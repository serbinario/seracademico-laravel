<?php

namespace Seracademico\Entities\Biblioteca;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Entities\Aluno;
use Seracademico\Entities\Pessoa;

class Emprestar extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'bib_emprestimos';

    protected $fillable = [ 
		'pessoas_id',
		'codigo',
		'data',
		'data_devolucao',
		'data_devolucao_real',
		'tipo_emprestimo',
		'status',
		'users_id'
	];

	public function pessoa()
	{
		return $this->belongsTo(Pessoa::class, 'pessoas_id');
	}

	public function emprestimoExemplar()
	{
		return $this->belongsToMany(Exemplar::class, 'bib_emprestimos_exemplares', 'emprestimo_id', "exemplar_id")
			->withPivot(['id', 'emprestimo_id', 'exemplar_id']);;
	}

}