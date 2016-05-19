<?php

namespace Seracademico\Entities\Graduacao;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Seracademico\Entities\CorRaca;
use Seracademico\Entities\Curso;
use Seracademico\Entities\CursoSuperior;
use Seracademico\Entities\Endereco;
use Seracademico\Entities\Estado;
use Seracademico\Entities\EstadoCivil;
use Seracademico\Entities\Exame;
use Seracademico\Entities\GrauInstrucao;
use Seracademico\Entities\InclusaoALuno;
use Seracademico\Entities\Instituicao;
use Seracademico\Entities\Profissao;
use Seracademico\Entities\Religiao;
use Seracademico\Entities\Sexo;
use Seracademico\Entities\TipoSanguinio;
use Seracademico\Entities\Turno;


class Aluno extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "fac_alunos";

    protected $fillable = [
        'matricula',
        'nome',
        'email',
        'telefone_fixo',
        'celular',
        'celular2',
        'nome_pai',
        'nome_social',
        'nome_mae',
        'identidade',
        'orgao_rg',
        'data_expedicao',
        'cpf',
        'titulo_eleitoral',
        'zona',
        'secao',
        'resevista',
        'catagoria_resevista',
        'data_nasciemento',
        'nacionalidade',
        'naturalidade',
        'ano_conclusao_2_grau',
        'outra_escola',
        'data_exame_nacional_um',
        'nota_exame_nacional_um',
        'data_exame_nacional_dois',
        'nota_exame_nacional_dois',
        'enderecos_id',
        'sexos_id',
        'turnos_id',
        'grau_instrucoes_id',
        'profissoes_id',
        'religioes_id',
        'estados_civis_id',
        'tipos_sanguinios_id',
        'cores_racas_id',
        'exames1_id',
        'exames2_id',
        'uf_nascimento_id',
        'deficiencia_fisica',
        'deficiencia_auditiva',
        'deficiencia_visual',
        'deficiencia_outra',
        'fac_instituicoes_id',
        'fac_cursos_superiores_id',
        'ano_conclusao_superior',
        'path_image',
        'tipo_nivel_sistema_id',
        'rg_doc_obrigatorio',
        'cpf_doc_obrigatorio',
        'certidao_nasc_cas_doc_obrigatorio',
        'titulo_eleitor_doc_obrigatorio',
        'reservista_doc_obrigatorio',
        'diploma_doc_obrigatorio',
        'fotos_3x4_doc_obrigatorio',
        'comp_residencia_doc_obrigatorio',
        'histo_gradu_autentic_obrigatorio',
        'ativo'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function endereco()
    {
        return $this->belongsTo(Endereco::class, 'enderecos_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sexo()
    {
        return $this->belongsTo(Sexo::class, 'sexos_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function turno()
    {
        return $this->belongsTo(Turno::class, 'turnos_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function grauInstrucao()
    {
        return $this->belongsTo(GrauInstrucao::class, 'grau_instrucoes_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function profissao()
    {
        return $this->belongsTo(Profissao::class, 'profissoes_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function religiao()
    {
        return $this->belongsTo(Religiao::class, 'religioes_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function estadoCivil()
    {
        return $this->belongsTo(EstadoCivil::class, 'estados_civis_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipoSanguinio()
    {
        return $this->belongsTo(TipoSanguinio::class, 'tipos_sanguinios_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function corRaca()
    {
        return $this->belongsTo(CorRaca::class, 'cores_racas_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ufNascimento()
    {
        return $this->belongsTo(Estado::class, 'uf_nascimento_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function exame1()
    {
        return $this->belongsTo(Exame::class, 'exames1_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function exame2()
    {
        return $this->belongsTo(Exame::class, 'exames2_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function instituicao()
    {
        return $this->belongsTo(Instituicao::class, "fac_instituicoes_id");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cursoSuperior()
    {
        return $this->belongsTo(CursoSuperior::class, 'fac_cursos_superiores_id');
    }

//    /**
//     * @param Model $parent
//     * @param array $attributes
//     * @param string $table
//     * @param bool $exists
//     * @return \Illuminate\Database\Eloquent\Relations\Pivot|Disciplina
//     */
//    public function newPivot(Model $parent, array $attributes, $table, $exists)
//    {
//        # Criando um pivot para Turma
//        if ($parent instanceof Turma) {
//            return new AlunoTurma($parent, $attributes, $table, $exists);
//        }
//
//        # Retorno do novo Pivot
//        return parent::newPivot($parent, $attributes, $table, $exists);
//    }
}