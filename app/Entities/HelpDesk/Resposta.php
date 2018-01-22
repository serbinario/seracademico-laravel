<?php

namespace Seracademico\Entities\HelpDesk;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Resposta extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'hp_respostas';

    protected $fillable = [
        'chamado_id',
        'descricao',
        'resposta_id',
        'status',
        'user_id'
    ];

    public function chamado()
    {
        return $this->belongsTo(Chamado::class, 'chamado_id');
    }

}
