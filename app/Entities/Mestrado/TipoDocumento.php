<?php

namespace Seracademico\Entities\Mestrado;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class TipoDocumento extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'pos_tipos_documentos_alunos';

    protected $fillable = [ 
		'nome',
	];

}