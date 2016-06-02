<?php

namespace Seracademico\Entities\Graduacao;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Uteis\SerbinarioDateFormat;

class PrecoCurso extends Model implements Transformable
{
    use TransformableTrait;

    protected $dates    = [
        'virgencia'
    ];

    protected $table    = "fac_precos_cursos";

    protected $fillable = [
        'turno_id',
        'tipo_preco_curso_id',
        'semestre_id',
        'curso_id',
        'virgencia'
    ];

    /**
     *
     * @return \DateTime
     */
    public function setVirgenciaAttribute($value)
    {
        $this->attributes['virgencia'] = SerbinarioDateFormat::toUsa($value);
    }

    /**
     * @return \DateTime
     */
    public function getVirgenciaAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['virgencia']);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function precosDisciplaCurso()
    {
        return $this->hasMany(PrecoDisciplinaCurso::class, "preco_curso_id", "id");
    }
}
