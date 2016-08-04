<?php

namespace Seracademico\Entities\Financeiro;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class TipoValor extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'fin_tipo_valores';

    protected $fillable = [ 
		'codigo',
		'nome',
	];

    public function tipoBeneficio(){
        return $this->hasMany('Seracademico\Entities\Financeiro\TipoBeneficio');
    }

}