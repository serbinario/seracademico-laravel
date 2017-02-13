<?php

namespace Seracademico\Entities\Mestrado;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Uteis\SerbinarioDateFormat;

class PlanoAula extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'fac_planos_aulas';

	protected $dates    = [
        'data'
	];

    protected $fillable = [ 
		'data',
		'hora_inicial',
		'hora_final',
		'numero_aula',
		'plano_ensino_id',
		'conteudo_programatico_id',
		'professor_1_id',
		'professor_2_id',
		'professor_3_id',
		'professor_4_id',
		'professor_5_id',
	];

    /**
     * @return \DateTime
     */
    public function getDataAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['data']);
    }

    /**
     * @return \DateTime
     */
    public function setDataAttribute($value)
    {
        $this->attributes['data'] = SerbinarioDateFormat::toUsa($value);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function conteudos()
    {
        return $this->belongsToMany(ConteudoProgramatico::class, 'fac_planos_aulas_conteudos_programaticos', 'plano_aula_id');
    }
}