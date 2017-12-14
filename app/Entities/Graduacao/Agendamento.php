<?php

namespace Seracademico\Entities\Graduacao;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Uteis\SerbinarioDateFormat;

class Agendamento extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'vest_agendamento';

    protected $fillable = [
        'data'
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
}
