<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class TipoPermissao extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = 'tipos_permissoes';

    protected $fillable = [
        'nome'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function permissoes()
    {
        return $this->hasMany(Permission::class, 'tipo_permissao_id');
    }
}
