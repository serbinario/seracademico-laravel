<?php

namespace Seracademico\Entities\Biblioteca;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

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
	];

}