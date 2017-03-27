<?php

namespace Seracademico\Entities\Biblioteca;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class DiasLetivosEmprestimo extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'bib_dias_letivos_emprestimo';

    protected $fillable = [ 
		'nome',
        'ativo'
	];

}