<?php

namespace Seracademico\Entities\Graduacao;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Entities\Graduacao\PlanoEnsino;

class ConteudoProgramatico extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'fac_conteudos_programaticos';

    protected $fillable = [ 
		'nome',
		'plano_ensino_id',
	];

    public function planoEnsino()
    {
        return $this->belongsTo(PlanoEnsino::class);
    }

}