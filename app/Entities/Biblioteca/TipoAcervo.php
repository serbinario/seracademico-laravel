<?php

namespace Seracademico\Entities\Biblioteca;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class TipoAcervo extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'bib_tipos_acervos';

    protected $fillable = [ 
		'nome',
	];

}