<?php

namespace Seracademico\Services\PosGraduacao;

use Illuminate\Support\Facades\DB;
use Seracademico\Entities\PosGraduacao\Aluno;
use Seracademico\Repositories\PosGraduacao\AlunoRepository;
use Seracademico\Repositories\PosGraduacao\CurriculoRepository;
use Seracademico\Repositories\PosGraduacaoCursoRepository;
use Seracademico\Repositories\NotaRepository;
use Seracademico\Repositories\PosGraduacao\TurmaRepository;
use Carbon\Carbon;

class AlunoTurmaService
{
    /**
     * @var AlunoRepository
     */
    private $alunoRepository;

    /**
     * @var TurmaRepository
     */
    private $turmaRepository;

    /**
     * @var CurriculoRepository
     */
    private $curriculoRepository;

    /**
     * @var NotaRepository
     */
    private $notaRepository;

    /**
     * @param AlunoRepository $alunoRepository
     * @param TurmaRepository $turmaRepository
     * @param CurriculoRepository $curriculoRepository
     * @param NotaRepository $notaRepository
     */
    public function __construct(
        AlunoRepository $alunoRepository,
        TurmaRepository $turmaRepository,
        CurriculoRepository $curriculoRepository,
        NotaRepository $notaRepository)
    {
        $this->alunoRepository     = $alunoRepository;
        $this->turmaRepository     = $turmaRepository;
        $this->curriculoRepository = $curriculoRepository;
        $this->notaRepository      = $notaRepository;
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function getCursos()
    {
        $query = DB::table('fac_curriculos')
            ->distinct()
            ->join('fac_cursos', 'fac_curriculos.curso_id', '=', 'fac_cursos.id')
            ->join('fac_turmas', 'fac_turmas.curriculo_id', '=', 'fac_curriculos.id')
            ->join('fac_curriculo_disciplina', 'fac_curriculo_disciplina.curriculo_id', '=', 'fac_curriculos.id')
            ->select([
               'fac_curriculos.id as curriculo_id',
               'fac_cursos.nome as nome_curso'
            ]);

        $retorno = $query->get();

        if (count($retorno) == 0) {
            throw new \Exception("Não existe currículo vinculado a uma turma!");
        }

        return $retorno;
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function getTurmas()
    {
        $query = DB::table('fac_turmas')
            ->join('fac_curriculos', 'fac_turmas.curriculo_id', '=', 'fac_curriculos.id')
            ->select([
                'fac_turmas.id',
                'fac_turmas.codigo'
            ]);

        $retorno = $query->get();

        if (count($retorno) == 0) {
            throw new \Exception("Não existe Turmas vinculadas a esse curso!");
        }

        return $retorno;
    }

    /**
     * @param array $data
     * @return bool
     * @throws \Exception
     */
    public function store(array $data)
    {
        # Aplicação de regras de negócio
        $this->tratamentoCampos($data);

        #Recuperando o aluno e a turma
        $aluno = $this->alunoRepository->find($data['aluno_id']);
        $turma = $this->turmaRepository->find($data['turma_id']);

        # Verificando se o aluno foi encontrado
        if(!$aluno && !$turma) {
            throw new \Exception("Aluno ou turma não existe!");
        }

        # Deletando os valores da array
        unset($data['aluno_id']);
        unset($data['turma_id']);

        #Salvando
        $aluno->turmas()->attach($turma->id, $data);
        $aluno->save();

        #Criando o esquema de disciplinas e notas do aluno pela turma
        $this->tratamentoDisciplinas($aluno->id, $turma->id);

        #Retorno
        return true;
    }

    /*
    public function update(array $data, int $id) : Departamento
    {
        #Atualizando no banco de dados
        $departamento = $this->repository->update($data, $id);


        #Verificando se foi atualizado no banco de dados
        if(!$departamento) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $departamento;
    }*/

    /**
     * @param array $models
     * @return mixed
     */
    public function load(array $models) : array
    {
        #Declarando variáveis de uso
        $result = [];

        #Criando e executando as consultas
        foreach ($models as $model) {
            #qualificando o namespace
            $nameModel = "Seracademico\\Entities\\$model";

            #Recuperando o registro e armazenando no array
            $result[strtolower($model)] = $nameModel::get();
        }

        #retorno
        return $result;
    }

    /**
     * @param array $data
     * @return array
     */
    public function tratamentoCampos(array &$data)
    {
        # Tratamento de campos de chaves estrangeira
        foreach ($data as $key => $value) {
            $explodeKey = explode("_", $key);

            if ($explodeKey[count($explodeKey) -1] == "id" && $value == null ) {
                unset($data[$key]);
            }
        }

        #Retorno
        return $data;
    }

    /**
     * @param int $idAluno
     * @param int $idTurma
     * @return bool
     * @throws \Exception
     */
    public function tratamentoDisciplinas(int $idAluno, int $idTurma)
    {
        # Select para recuperar o id da tabela pivot
        $arrayResult = DB::table("pos_alunos_turmas")->select(["id"])->where("turma_id", $idTurma)->where("aluno_id", $idAluno)->get();

        # Verificando se um único registro foi recuperado
        if(count($arrayResult) == 1) {
            # Recuperando o id de da tabela pivot
            $idAlunoTurma = $arrayResult[0]->id;

            # Recuperando a turma e as disciplinas
            $objTurma     = $this->turmaRepository->find($idTurma);
            $disciplinas  = $objTurma->disciplinas;

            # Percorrendo as disciplinas e criando o esquemas de notas
            foreach ($disciplinas as $disciplina) {
                # Declarando o array para armazenamento do schema de nota
                $arrayNota = [];

                # Populando o array da nota
                $arrayNota['aluno_tuma_id']    = $idAlunoTurma;
                $arrayNota['disciplina_id']    = $disciplina->id;
                $arrayNota['situacao_nota_id'] = 3;

                # Salvando a nota no banco de dados
                $this->notaRepository->create($arrayNota);
            }

            # Retorno
            return true;
        }

        # Retono exception
        throw new \Exception("Esta turma não está vinculada a esse aluno.");
    }
}