<?php

namespace Seracademico\Entities\Financeiro;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Incidencia extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'fin_incidencia';

    protected $fillable = [ 
		'codigo',
		'nome',
	];

    public function tipoBeneficio(){
        return $this->hasMany('Seracademico\Entities\Financeiro\TipoBeneficio');
    }
}