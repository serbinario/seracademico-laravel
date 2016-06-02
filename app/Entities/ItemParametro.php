<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class ItemParametro extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'fac_parametros_itens';

    protected $fillable = [ 
		'nome',
        'valor',
        'parametro_id'
	];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parametro()
    {
        return $this->belongsTo(Parametro::class, 'parametro_id');
    }
}