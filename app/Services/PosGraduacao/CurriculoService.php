<?php

namespace Seracademico\Services\PosGraduacao;

use Seracademico\Repositories\PosGraduacao\CurriculoRepository;
use Seracademico\Entities\PosGraduacao\Curriculo;
use Seracademico\Repositories\PosGraduacao\CursoRepository;
use Seracademico\Repositories\PosGraduacao\DisciplinaRepository;
use Seracademico\Services\TraitService;

class CurriculoService
{
    use TraitService;

    /**
     * @var CurriculoRepository
     */
    private $repository;

    /**
     * @var DisciplinaRepository
     */
    private $disciplinaRepository;

    /**
     * CurriculoService constructor.
     * @param CurriculoRepository $repository
     * @param DisciplinaRepository $disciplinaRepository
     */
    public function __construct(CurriculoRepository $repository, DisciplinaRepository $disciplinaRepository)
    {
        $this->repository           = $repository;
        $this->disciplinaRepository = $disciplinaRepository;
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function find($id)
    {
        #Recuperando o registro no banco de dados
        $curriculo = $this->repository->find($id);

        #Verificando se o registro foi encontrado
        if(!$curriculo) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
        return $curriculo;
    }

    /**
     * @param array $data
     * @return Curriculo
     * @throws \Exception
     */
    public function store(array $data) : Curriculo
    {
        #setando o nivel do sistema
        $data['tipo_nivel_sistema_id'] = 2;

        #Executando regras de negócios
        $this->tratamentoCurriculoAtivo($data);

        #Salvando o registro pincipal
        $curriculo =  $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$curriculo) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $curriculo;
    }

    /**
     * @param array $data
     * @param int $id
     * @return Curriculo
     * @throws \Exception
     */
    public function update(array $data, int $id) : Curriculo
    {
        #setando o nivel do sistema
        $data['tipo_nivel_sistema_id'] = 2;

        #Executando regras de negócios
        $this->tratamentoCurriculoAtivo($data);

        #Atualizando no banco de dados
        $curriculo = $this->repository->update($data, $id);

        #Verificando se foi atualizado no banco de dados
        if(!$curriculo) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $curriculo;
    }

    /**
     * @param $idDisciplina
     * @param $idCurriculo
     * @return array
     * @throws \Exception
     */
    public function disciplinaFind($idDisciplina, $idCurriculo)
    {
        # Recuperando a disciplina
        $curriculo       = $this->repository->find($idCurriculo);
        $disciplina      = $curriculo->disciplinas()->find($idDisciplina);

        # Verificando a existência da disciplina
        if(!$curriculo && !$disciplina) {
            throw new \Exception("Disciplina não encontrada!");
        }

        # Recuperando o pivot
        $pivotDisciplina = $disciplina->pivot;

        # Retorno
        return [
            'model' => $pivotDisciplina,
            'nomeDisciplina' => $disciplina->nome,
            'codigoDisciplina' => $disciplina->codigo
        ];
    }

    /**
     * @param array $data
     * @return bool
     * @throws \Exception
     */
    public function disciplinaStore(array $data)
    {
        # Regras de negócios
        $this->tratamentoCampos($data);

        # Recuperando o currículo
        $curriculo     = $this->repository->find($data['curriculo_id']);
        $objDisciplina = $this->disciplinaRepository->find($data['disciplina_id']);

        # Verificando se o currículo foi recuperado
        if(!$curriculo && !$objDisciplina) {
            throw new \Exception("Curriculo não encontrado!");
        }

        # atrelando os valores
        $curriculo->disciplinas()->attach($objDisciplina,
            [
                'carga_horaria_total'   => $data['carga_horaria_total'],
                'qtd_credito' => $data['qtd_credito'],
                'qtd_faltas'  => $data['qtd_faltas']
            ]
        );

        # Retorno
        return true;
    }

    /**
     * @param $data
     * @return bool
     * @throws \Exception
     */
    public function disciplinaDelete($data)
    {
        # Recuperando o currículo
        $curriculo  = $this->repository->find($data['idCurriculo']);
        $disciplina = $this->disciplinaRepository->find($data['idDisciplina']);

        # Verificando se o currículo foi recuperado
        if(!$curriculo && !$disciplina) {
            throw new \Exception("Curriculo não encontrado!");
        }

        #Disvinculando a disciplina do currículo
        $curriculo->disciplinas()->detach($disciplina->id);

        #Retorno
        return true;
    }

    /**
     * @param $idDisciplina
     * @param $idCurriculo
     * @param $dados
     * @return bool
     * @throws \Exception
     */
    public function disciplinaUpdate($idDisciplina, $idCurriculo, $dados)
    {
        # Regras de negócios
        $this->tratamentoCampos($dados);

        # Recuperando a disciplina
        $curriculo       = $this->repository->find($idCurriculo);
        $disciplina      = $curriculo->disciplinas()->find($idDisciplina);

        # Verificando a existência da disciplina
        if(!$curriculo && !$disciplina) {
            throw new \Exception("Disciplina não encontrada!");
        }

        #Salvando mudanças
        $disciplina->pivot->update($dados);

        #retorno
        return true;
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function getDisciplina($id)
    {
        #Recuperando o registro no banco de dados
        $disciplina = $this->disciplinaRepository->find($id);

        #Verificando se o registro foi encontrado
        if(!$disciplina) {
            throw new \Exception('Disciplina não encontrada!');
        }

        #retorno
        return $disciplina;
    }

    /**
     * @param array $data
     * @return mixed
     */
    private function tratamentoCurriculoAtivo(array &$data): array
    {
        #Verificando se a condição é válida
        if($data['ativo'] == 1 && isset($data['curso_id'])) {
            #Recuperando o(s) currículo(s) ativo(s)
            $rows = $this->repository->getCurriculoAtivo($data['curso_id']);

            #Varrendo o array
            foreach($rows as $row) {
                $curriculo = $this->repository->find($row->id);

                $curriculo->ativo = 0;
                $curriculo->save();
            }
        }

        #retorno
        return $data;
    }
}