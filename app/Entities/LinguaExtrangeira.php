<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class LinguaExtrangeira extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "linguas_extrangeiras";

    protected $fillable = [
        'nome'

    ];

}
