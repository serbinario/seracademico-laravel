<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Uteis\SerbinarioDateFormat;

class Release extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'releases';

    protected $fillable = [
        'data',
        'descricao',
        'tipo_id',
        'desenvolvedor_id',
        'sistema_id'
    ];

    /**
     * @return string
     */
    public function getDataAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['data']);
    }

    /**
     * @param $value
     */
    public function setDataAttribute($value)
    {
        $this->attributes['data'] = SerbinarioDateFormat::toUsa($value);
    }
}
