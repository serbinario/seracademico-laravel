<?php

namespace Seracademico\Entities\PosGraduacao;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class CanalCaptacao extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'pos_canais_captacoes';

    protected $fillable = [ 
		'nome',
		'codigo',
	];

}