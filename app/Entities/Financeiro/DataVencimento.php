<?php

namespace Seracademico\Entities\Financeiro;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class DataVencimento extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'fin_data_vencimento';

    protected $fillable = [ 
		'codigo',
		'nome',
	];

    public function tipoBeneficio(){
        return $this->hasMany('Seracademico\Entities\Financeiro\TipoBeneficio');
    }

}