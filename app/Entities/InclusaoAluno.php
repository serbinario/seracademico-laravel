<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Entities\Graduacao\Curriculo;
use Seracademico\Uteis\SerbinarioDateFormat;

class InclusaoAluno extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "inclusao_aluno";

    protected $dates = [
        "data_inclusao"
    ];

    protected $fillable = [
        'curriculo_id',
        'turno_id',
        'forma_admissao_id',
        'data_inclusao',
        'aluno_id'
    ];

    /**
     * @return string
     */
    public function getDataInclusaoAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['data_inclusao']);
    }

    /**
     * @return string
     */
    public function setDataInclusaoAttribute($value)
    {
        $this->attributes['data_inclusao'] = SerbinarioDateFormat::toUsa($value);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function formaAdmissao()
    {
        return $this->belongsTo(FormaAdmissao::class, 'forma_admissao_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function curriculo()
    {
        return $this->belongsTo(Curriculo::class, 'curriculo_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function turno()
    {
        return $this->belongsTo(Turno::class, 'turno_id');
    }
}
