<?php

namespace Seracademico\Entities\PosGraduacao;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Entities\PosGraduacao\Curso;
use Seracademico\Entities\Pessoa;
use Seracademico\Uteis\SerbinarioDateFormat;

class Aluno extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "pos_alunos";

    protected $dates = [
        "data_inscricao"
    ];

    protected $fillable = [
        'matricula',
        'data_inscricao',
        'pessoa_id',
        'turno_id',
        'path_image'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'pessoa_id');
    }

    /**
     * @return \DateTime
     */
    public function getDataInscricaoAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['data_inscricao']);
    }

    /**
     * @return \DateTime
     */
    public function setDataInscricaoAttribute($value)
    {
        $this->attributes['data_inscricao'] = SerbinarioDateFormat::toUsa($value);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function curriculos()
    {
        return $this->belongsToMany(Curriculo::class, 'pos_alunos_cursos', 'aluno_id', 'curriculo_id')->withPivot(['situacao_id']);
    }
}