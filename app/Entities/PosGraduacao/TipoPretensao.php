<?php

namespace Seracademico\Entities\PosGraduacao;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class TipoPretensao extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'pos_tipos_pretensoes';

    protected $fillable = [ 
		'nome',
		'codigo',
	];

}