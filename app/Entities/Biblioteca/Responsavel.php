<?php

namespace Seracademico\Entities\Biblioteca;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Responsavel extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'responsaveis';

    protected $fillable = [
		'nome',
		'sobrenome',
        'tipo_reponsavel_id'
	];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function autores(){
        return $this->hasMany(PrimeiraEntrada::class, 'responsaveis_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function outros(){
        return $this->hasMany(SegundaEntrada::class, 'responsaveis_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipo()
    {
        return $this->belongsTo(TipoResponsavel::class, 'tipo_reponsavel_id');
    }

}