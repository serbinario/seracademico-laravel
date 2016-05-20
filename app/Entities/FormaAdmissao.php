<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class FormaAdmissao extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "formas_admissoes";

    protected $fillable = [
        'nome'
    ];
}
