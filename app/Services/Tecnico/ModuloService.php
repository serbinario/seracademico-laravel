<?php

namespace Seracademico\Services\Tecnico;

use Seracademico\Repositories\Tecnico\MaterialRepository;
use Seracademico\Repositories\Tecnico\ModuloRepository;
use Seracademico\Entities\Tecnico\Modulo;
use Illuminate\Support\Facades\File;

class ModuloService
{

    private $repository;

    /**
     * @var string
     */
    private $destinationPath = "uploads/tecnico/modulos/materiais/";
    /**
     * @var MaterialRepository
     */
    private $repositoryMaterial;

    /**
     * ModuloService constructor.
     * @param ModuloRepository $repository
     * @param MaterialRepository $repositoryMaterial
     */
    public function __construct(ModuloRepository $repository,
                                MaterialRepository $repositoryMaterial)
    {
        $this->repository = $repository;
        $this->repositoryMaterial = $repositoryMaterial;
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function find($id)
    {
        #Recuperando o registro no banco de dados
        $modulo = $this->repository->find($id);

        #Verificando se o registro foi encontrado
        if(!$modulo) {
            throw new \Exception('Modulo não encontrada!');
        }

        #retorno
        return $modulo;
    }

    /**
     * @param array $data
     * @return Modulo
     * @throws \Exception
     */
    public function store(array $data) : Modulo
    {
        #Salvando o registro pincipal
        $modulo = $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$modulo) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $modulo;
    }

    /**
     * @param array $data
     * @param int $id
     * @return Modulo
     * @throws \Exception
     */
    public function update(array $data, int $id) : Modulo
    {
        #Atualizando no banco de dados
        $modulo = $this->repository->update($data, $id);

        #Verificando se foi atualizado no banco de dados
        if(!$modulo) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $modulo;
    }

    /**
     * @param array $models
     * @return array
     */
    public function load(array $models) : array
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

            if(count($expressao) > 1) {
                #Recuperando o registro e armazenando no array
                $result[strtolower($model)] = $nameModel::{$expressao[0]}($expressao[1])->lists('nome', 'id');
            } else {
                #Recuperando o registro e armazenando no array
                $result[strtolower($model)] = $nameModel::lists('nome', 'id');
            }

            # Limpando a expressão
            $expressao = [];
        }

        #retorno
        return $result;
    }

    /**
     * @param array $data
     * @return mixed
     * @throws \Exception
     */
    public function adicionarMateriais(array $data)
    {
        #tratando o arquivo
        if(isset($data['file'])) {
            $file     = $data['file'];
            $fileName = md5(uniqid(rand(), true)) . "." . $file->getClientOriginalExtension();

            #Movendo o arquivo
            $file->move($this->destinationPath, $fileName);

            #setando o nome da imagem no model
            $data['path'] = $fileName;

            #destruindo o img do array
            unset($data['file']);
        }

        #Salvando o registro pincipal
        $material =  $this->repositoryMaterial->create($data);

        #Verificando se foi criado no banco de dados
        if(!$material) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $material;
    }

    /**
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public function removerMateriais(int $id)
    {
        $material = $this->repositoryMaterial->find($id);

        #deletando o curso
        $result = $this->repositoryMaterial->delete($id);

        #removendo a arquivo antigo
        if($material->path != null) {
            File::delete($this->destinationPath . $material->path);
        }

        # Verificando se a execução foi bem sucessida
        if(!$result) {
            throw new \Exception('Ocorreu um erro ao tentar remover o curso!');
        }

        #retorno
        return true;
    }
}