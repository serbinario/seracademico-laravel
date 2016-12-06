<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class SimpleReport extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'reports';

    protected $fillable = [ 
		'nome',
		'sql',
		'crud_id',
	];

	/**
	 * @param $query
	 * @param $idCrud
	 * @return mixed
	 */
	public function scopeByCrud($query, $idCrud)
	{
		return $query->where('crud_id', $idCrud);
	}

}