<?php

namespace Seracademico\Entities\Graduacao;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class VestibulandoNotaVestibular extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'fac_vestibulandos_notas_vestibulares';

    protected $fillable = [
        'vestibulando_id',
        'materia_id',
        'acertos',
        'pontuacao'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function materia()
    {
        return $this->belongsTo(Materia::class, 'materia_id');
    }
}
