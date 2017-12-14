<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class ReleaseType extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'release_type';

    protected $fillable = [
        'id',
        'nome'
    ];

}
