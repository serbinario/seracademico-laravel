<?php

namespace Seracademico\Entities\Biblioteca;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class EmprestimoExemplar extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'bib_emprestimos_exemplares';

    protected $fillable = [ 
		'emprestimo_id',
		'exemplar_id',
		'taxa_id',
	];

}