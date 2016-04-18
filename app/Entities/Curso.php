<?php

namespace Seracademico\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Uteis\SerbinarioDateFormat;

class Curso extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'fac_cursos';

    protected $dates = [
        'data_decreto_rec',
        'data_dou_rec',
        'data_decreto_aut',
        'data_dou_aut',
        'data_matricula_inicio',
        'data_matricula_fim',
        'inicio_aula',
        'fim_aula',
        'vencimento_inicial'
    ];

    protected $fillable = [
        'nome',
        'codigo',
        'duracao_meses',
        'portaria_mec_rec',
        'numero_decreto_rec',
        'data_decreto_rec',
        'data_dou_rec',
        'portaria_mec_aut',
        'numero_decreto_aut',
        'data_decreto_aut',
        'data_dou_aut',
        'data_matricula_inicio',
        'data_matricula_fim',
        'inicio_aula',
        'fim_aula',
        'maximo_vagas',
        'minimo_vagas',
        'obs_vagas',
        'valor',
        'parcelas',
        'vencimento_inicial',
        'tipo_curso_id',
        'cordenador_id',
        'tipo_nivel_sistema_id',
        'carga_horaria',
        'ativo'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function curriculos()
    {
        return $this->hasMany(Curriculo::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipoCurso()
    {
        return $this->belongsTo(TipoCurso::class, "tipo_curso_id");
    }

    /**
     *
     * @return \DateTime
     */
    public function getDataDecretoRecAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['data_decreto_rec']);
    }

    /**
     * @return \DateTime
     */
    public function getDataDouRecAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['data_dou_rec']);
    }

    /**
     * @return \DateTime
     */
    public function getDataDecretoAutAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['data_decreto_aut']);
    }

    /**
     * @return \DateTime
     */
    public function getDataDouAutAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['data_dou_aut']);
    }

    /**
     * @return \DateTime
     */
    public function getDataMatriculaInicioAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['data_matricula_inicio']);
    }

    /**
     * @return \DateTime
     */
    public function getDataMatriculaFimAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['data_matricula_fim']);
    }

    /**
     * @return \DateTime
     */
    public function getInicioAulaAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['inicio_aula']);
    }

    /**
     * @return \DateTime
     */
    public function getFimAulaAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['fim_aula']);
    }

    /**
     * @return \DateTime
     */
    public function getVencimentoInicialAttribute()
    {
        return SerbinarioDateFormat::toBrazil($this->attributes['vencimento_inicial']);
    }

    /**
     * @param $query
     * @param $value
     * @return mixed
     */
    public function scopeByCurriculoAtivo($query)
    {
        return $query->select('fac_cursos.nome', 'fac_cursos.id')
            ->join('fac_curriculos', 'fac_curriculos.curso_id', '=', 'fac_cursos.id')
            ->where('fac_curriculos.ativo', 1);
    }
}