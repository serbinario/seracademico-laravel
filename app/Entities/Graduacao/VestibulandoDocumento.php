<?php

namespace Seracademico\Entities\Graduacao;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class VestibulandoDocumento extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'vest_documentos';

    protected $fillable = [
        'confirmacao',
        'path',
        'observacao',
        'vestibulando_id',
        'tipo_documento_id',
        'entregar_pessoalmente'
    ];

}
