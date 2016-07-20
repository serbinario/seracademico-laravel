<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Permission extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'model',
        'tipo_permissao_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipo()
    {
        return $this->belongsTo(TipoPermissao::class, 'tipo_permissao_id');
    }

}
