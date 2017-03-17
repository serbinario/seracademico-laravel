<?php

namespace Seracademico\Entities\Biblioteca;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Entities\Taxa;

class EmprestimoExemplar extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'bib_emprestimos_exemplares';

    protected $fillable = [ 
		'emprestimo_id',
		'exemplar_id',
		'taxa_id',
		'valor_multa'
	];

	public function emprestimo()
	{
		return $this->belongsTo(Emprestar::class, 'emprestimo_id');
	}

	public function exemplar()
	{
		return $this->belongsTo(Exemplar::class, 'exemplar_id');
	}

	public function taxa()
	{
		return $this->belongsTo(Taxa::class, 'taxa_id');
	}

}