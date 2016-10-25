<?php

namespace Seracademico\Services\PosGraduacao;

use Illuminate\Support\Facades\DB;
use Seracademico\Entities\PosGraduacao\Aluno;
use Seracademico\Entities\PosGraduacao\AlunoFrequencia;
use Seracademico\Entities\PosGraduacao\AlunoNota;
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
            ->join('fac_cursos', 'fac_curriculos.curso_id', '=', 'fac_cursos.id')
            ->join('fac_turmas', 'fac_turmas.curriculo_id', '=', 'fac_curriculos.id')
            ->join('fac_curriculo_disciplina', 'fac_curriculo_disciplina.curriculo_id', '=', 'fac_curriculos.id')
            ->where('fac_turmas.tipo_nivel_sistema_id', 2)
            ->groupBy('fac_cursos.nome')
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
    public function getTurmas($idCurriculo)
    {
        $query = DB::table('fac_turmas')
            ->join('fac_curriculos', 'fac_turmas.curriculo_id', '=', 'fac_curriculos.id')
            ->where('fac_curriculos.id', $idCurriculo)
            ->groupBy('fac_turmas.codigo')
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

        # Verificando se o aluno foi encontrado
        if(!$aluno) {
            throw new \Exception("Aluno não existe!");
        }

        #Vinculando o curriculo
        $aluno->curriculos()->attach($data['curriculo_id']);

        #Salvando a situação
        $aluno->curriculos()->get()->last()->pivot->situacoes()->attach($data['situacao_id'], [
            'turma_origem_id' => $data['turma_id'] ?? null
        ]);

        # Verificando se a turma foi informada
        if(isset($data['turma_id']) && $data['turma_id']) {
            # Salvando a turma
            $aluno->curriculos()->get()->last()->pivot->turmas()->attach($data['turma_id']);

            # e tratando as notas e frequências
            $this->tratamentoNotas($aluno);
        }

        #Retorno
        return true;
    }

    /**
     * @param $id
     * @return array
     * @throws \Exception
     */
    public function edit($id)
    {
        # Recuperando o id do aluno
        $result = \DB::table('pos_alunos_turmas')
            ->join('pos_alunos_cursos', 'pos_alunos_cursos.id', '=', 'pos_alunos_turmas.pos_aluno_curso_id')
            ->join('pos_alunos', 'pos_alunos.id', '=', 'pos_alunos_cursos.aluno_id')
            ->where('pos_alunos_turmas.id', $id)
            ->select([
                'pos_alunos.id',
                'pos_alunos_cursos.curriculo_id as idCurriculo',
                'pos_alunos_turmas.turma_id as idTurma'
            ])->get();


        # Validando o retorno
        if(count($result) !== 1) {
            throw new \Exception("Nenhum aluno foi encontrado");
        }

        # Recuperando o objeto de aluno
        $objAluno      = $this->alunoRepository->find($result[0]->id);
        $objCurrriculo = $this->curriculoRepository->find($result[0]->idCurriculo);
        $objTurma      = $this->turmaRepository->find($result[0]->idTurma);

        # Array de retorno
        $arrayResult = [
            'aluno' => $objAluno,
            'turma' => $objTurma,
            'curso' => $objCurrriculo,
            'alunoTurma' => $objAluno->curriculos->find($objCurrriculo->id)->turmas->find($objTurma->id)->pivot,
            'situacao' => $objAluno->curriculos->find($objCurrriculo->id)->pivot->situacoes->last()
        ];

        # Retorno
        return $arrayResult;
    }

    /**
     * @param array $data
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public function update(array $data, int $id)
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

        #Recuperando o id do currículo
        $curriculoId = $data['curriculo_id'];
        unset($data['curriculo_id']);

        # Aplicação de regras de negócios
        $this->tratamentoSituacao($aluno, $curriculoId, $data);
        $this->tratamentoTurma($aluno, $turma, $curriculoId, $data);
        $this->tratamentoDisciplinas($aluno->curriculos->last()->pivot->id, $turma->id);

        #Retorno
        return true;
    }

    /**
     * @param $aluno
     * @param $turma
     * @param $curriculoId
     * @param $data
     * @return bool
     */
    public function tratamentoTurma($aluno, $turma, $curriculoId, &$data)
    {
        # Recuperando a ultima turma
        $lastTurma = $aluno->curriculos->last()->pivot->turmas->last();

        # Verificando se a turma é a mesma turma
        if(isset($lastTurma) && $lastTurma->id == $turma->id) {
            # Recuperando o Pivot
            $alunoTurma = $lastTurma->pivot;
            $alunoTurma->update($data);

            # Retorno
            return true;
        }

        # Salvando a turma
        $aluno->curriculos->find($curriculoId)->pivot->turmas()->attach($turma->id, $data);

        # Retorno
        return true;
    }

    /**
     * @param $aluno
     * @param $curriculoId
     * @return bool
     */
    public function tratamentoSituacao($aluno, $curriculoId, &$data)
    {
        #Salvando a situação
        $aluno->curriculos->find($curriculoId)->pivot->situacoes()->attach($data['situacao_id']);
        unset($data['situacao_id']);

        # Retorno
        return true;
    }


    /**
     * Método load
     *
     * Método responsável por recuperar todos os models (com seus repectivos
     * métodos personalizados para consulta, se for o caso) do array passado
     * por parâmetro.
     *
     * @param array $models || Melhorar esse código
     * @return array
     */
    public function load(array $models, $ajax = false) : array
    {
        #Declarando variáveis de uso
        $result    = [];
        $expressao = [];

        #Criando e executando as consultas
        foreach ($models as $model) {
            # separando as strings
            $explode   = explode("|", $model);

            # verificando a condição
            if(count($explode) > 1) {
                $model     = $explode[0];
                $expressao = explode(",", $explode[1]);
            }

            #qualificando o namespace
            $nameModel = "\\Seracademico\\Entities\\$model";

            #Verificando se existe sobrescrita do nome do model
            //$model     = isset($expressao[2]) ? $expressao[2] : $model;

            if ($ajax) {
                if(count($expressao) > 0) {
                    switch (count($expressao)) {
                        case 1 :
                            #Recuperando o registro e armazenando no array
                            $result[strtolower($model)] = $nameModel::{$expressao[0]}()->orderBy('nome', 'asc')->get(['nome', 'id', 'codigo']);
                            break;
                        case 2 :
                            #Recuperando o registro e armazenando no array
                            $result[strtolower($model)] = $nameModel::{$expressao[0]}($expressao[1])->orderBy('nome', 'asc')->get(['nome', 'id', 'codigo']);
                            break;
                        case 3 :
                            #Recuperando o registro e armazenando no array
                            $result[strtolower($model)] = $nameModel::{$expressao[0]}($expressao[1], $expressao[2])->orderBy('nome', 'asc')->get(['nome', 'id', 'codigo']);
                            break;
                    }

                } else {
                    #Recuperando o registro e armazenando no array
                    $result[strtolower($model)] = $nameModel::orderBy('nome', 'asc')->get(['nome', 'id']);
                }
            } else {
                if(count($expressao) > 0) {
                    switch (count($expressao)) {
                        case 1 :
                            #Recuperando o registro e armazenando no array
                            $result[strtolower($model)] = $nameModel::{$expressao[0]}()->orderBy('nome', 'asc')->lists('nome', 'id');
                            break;
                        case 2 :
                            #Recuperando o registro e armazenando no array
                            $result[strtolower($model)] = $nameModel::{$expressao[0]}($expressao[1])->orderBy('nome', 'asc')->lists('nome', 'id');
                            break;
                        case 3 :
                            #Recuperando o registro e armazenando no array
                            $result[strtolower($model)] = $nameModel::{$expressao[0]}($expressao[1], $expressao[2])->orderBy('nome', 'asc')->lists('nome', 'id');
                            break;
                    }
                } else {
                    #Recuperando o registro e armazenando no array
                    $result[strtolower($model)] = $nameModel::lists('nome', 'id');
                }
            }

            # Limpando a expressão
            $expressao = [];
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
     * @param array $data
     * @return bool
     * @throws \Exception
     */
    public function storeSituacao(array $data)
    {
        # Aplicação de regras de negócio
        $this->tratamentoCampos($data);

        # Cadastrando a situação
        DB::table('pos_alunos_situacoes')->insert($data);

//        # Verificando se é mudança de turma
//        if($data['situacao_id'] == 14) {
//            # Cadastrando a nova turma
//            DB::table('pos_alunos_turmas')->insert([
//                'pos_aluno_curso_id' => $data['pos_aluno_curso_id'],
//                'turma_id' => $data['turma_destino_id']
//            ]);
//        }

        # Retorno
        return true;
    }

    /**
     * @param Aluno $aluno
     * @return bool
     */
    public function tratamentoNotas(Aluno $aluno)
    {
        # Recuperando a entidade de currículo
        $curriculo =  $aluno->curriculos()->get()->last();

        # Recuperando a turma ativa, data atual e as notas do aluno
        $turma    = $curriculo->pivot->turmas()->get()->last();
        $dataHoje = new \DateTime('now');

        # Percorendo e persistindo as notas
        foreach($curriculo->disciplinas as $disciplina) {
            # Recuperando o ultimo calendário da disicplina
            $calendario = $turma->disciplinas()->find($disciplina->id)->pivot->calendarios->last();

            # Verificando se o calendário é
            if(isset($calendario) && \DateTime::createFromFormat('d/m/Y' , $calendario->data_final) < $dataHoje) {
                continue;
            }

            # Salvando as notas
            $turma->pivot->notas()
                ->save(new AlunoNota([
                    'disciplina_id'  => $disciplina->id,
                    'situacao_nota_id' => 10,
                    'turma_id' => $turma->id
                ]));
        }

        # Recuperando todas as notas
        $notas = $turma->pivot->notas()->get();

        # Criando as frequências para cada disciplinas
        foreach($notas as $nota) {
            # Recuperando os calendários
            $calendarios = $nota->disciplina->turmas()->find($turma->id)->pivot->calendarios;

            # Percorrendo os calendários e persistindo as frequências
            foreach ($calendarios as $calendario) {
                $nota->frequencias()->save(new AlunoFrequencia(['calendario_id' => $calendario->id]));
            }
        }

        # Retorno
        return true;
    }
}