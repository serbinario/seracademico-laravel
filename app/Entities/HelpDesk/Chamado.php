<?php

namespace Seracademico\Entities\HelpDesk;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Entities\User;

class Chamado extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'hp_chamados';

    protected $fillable = [
        'titulo',
        'descricao',
        'user_id',
        'status',
        'prioridade'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function respostas()
    {
        return $this->hasMany(Resposta::class, 'chamado_id');
    }
}
