<?php

namespace Seracademico\Entities\Graduacao;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class PrecoDisciplinaCurso extends Model implements Transformable
{
    use TransformableTrait;

    protected $table    = "fac_precos_discplina_curso";

    protected $fillable = [
        'preco',
        'qtd_disciplinas',
        'preco_curso_id'
    ];

}
