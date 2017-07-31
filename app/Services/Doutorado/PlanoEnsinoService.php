<?php

namespace Seracademico\Services\Doutorado;

use Seracademico\Entities\Doutorado\ConteudoProgramatico;
use Seracademico\Repositories\Doutorado\ConteudoProgramaticoRepository;
use Seracademico\Repositories\Doutorado\PlanoEnsinoRepository;
use Seracademico\Entities\Doutorado\PlanoEnsino;

class PlanoEnsinoService
{
    /**
     * @var PlanoEnsinoRepository
     */
    private $repository;

    /**
     * @var ConteudoProgramaticoRepository
     */
    private $conteudoProgramaticoRepository;

    /**
     * @var string
     */
    private $destinationPath = "images/";

    /**
     * PlanoEnsinoService constructor.
     * @param PlanoEnsinoRepository $repository
     * @param ConteudoProgramaticoRepository $conteudoProgramaticoRepository
     */
    public function __construct(PlanoEnsinoRepository $repository, ConteudoProgramaticoRepository $conteudoProgramaticoRepository)
    {
        $this->repository = $repository;
        $this->conteudoProgramaticoRepository = $conteudoProgramaticoRepository;
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function find($id)
    {
        #Recuperando o registro no banco de dados
        $planoEnsino = $this->repository->find($id);

        #Verificando se o registro foi encontrado
        if(!$planoEnsino) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
        return $planoEnsino;
    }

    /**
     * @param array $data
     * @return PlanoEnsino
     * @throws \Exception
     */
    public function store(array $data) : PlanoEnsino
    {
        # Regras de negócio
        $this->tratamentoCampos($data);
        $this->tratamentoPlanoAtivo($data);
        $this->tratamentoImagem($data);

        #Salvando o registro pincipal
        $planoEnsino =  $this->repository->create($data);

        # salvando os conteúdos programáticos
        $planoEnsino->conteudoProgramatico()->saveMany($this->tratamentoConteudosProgramaticos($data));

        #Verificando se foi criado no banco de dados
        if(!$planoEnsino) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $planoEnsino;
    }

    /**
     * @param array $data
     * @param int $id
     * @return PlanoEnsino
     * @throws \Exception
     */
    public function update(array $data, int $id) : PlanoEnsino
    {
        # Regras de negócio
        $this->tratamentoCampos($data);
        $this->tratamentoPlanoAtivo($data);

        # Recuperando o vestibulando
        $planoEnsino = $this->repository->find($id);

        #Regras de negócios
        $this->tratamentoImagem($data, $planoEnsino);

        #Atualizando no banco de dados
        $planoEnsino = $this->repository->update($data, $id);

        #Verificando se foi atualizado no banco de dados
        if(!$planoEnsino) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $planoEnsino;
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
     * @return mixed
     */
    private function tratamentoPlanoAtivo(array &$data): array
    {
        #Verificando se a condição é válida
        if($data['ativo'] == 1) {
            #Recuperando o(s) plano(s) ativo(s)
            $rows = $this->repository->findWhere(['ativo' => 1, 'disciplina_id' => $data['disciplina_id'],
                'carga_horaria' => $data['carga_horaria']]);

            #Varrendo o array
            foreach($rows as $row) {
                $plano = $this->repository->find($row->id);

                $plano->ativo = 0;
                $plano->save();
            }
        }

        #retorno
        return $data;
    }

    /**
     * @param array $data
     * @return array
     */
    public function tratamentoCampos(array &$data)
    {
        # Tratamento de campos de chaves estrangeira
        foreach ($data as $key => $value) {
            if(is_array($value)) {
                foreach ($value as $key2 => $value2) {
                    $explodeKey2 = explode("_", $key2);

                    if ($explodeKey2[count($explodeKey2) -1] == "id" && $value2 == null ) {
                        $data[$key][$key2] = null;
                    }
                }
            }

            $explodeKey = explode("_", $key);

            if ($explodeKey[count($explodeKey) -1] == "id" && $value == null ) {
                $data[$key] = null;
            }
        }

        #Retorno
        return $data;
    }

    /**
     * @param array $data
     * @return array
     */
    public function tratamentoConteudosProgramaticos(array $data)
    {
        # Array de retorno
        $arrayResult = [];

        # Recuperado e removendo do array o conteúdo programático
        $conteudos = explode(',', $data['conteudo_programatico']);
        unset($data['conteudo_programatico']);

        # Criando o array de retorno
        foreach ($conteudos as $conteudo) {
            $arrayResult[] = new ConteudoProgramatico(['nome' => $conteudo]);
        }
 
        # Retorno
        return $arrayResult;
    }

    /**
     * @param array $data
     * @return mixed
     * @throws \Exception
     */
    public function storeConteudoProgramatico(array $data)
    {
        #Salvando o registro pincipal
        $conteudo =  $this->conteudoProgramaticoRepository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$conteudo) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $conteudo;
    }


    /**
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public function deleteConteudoProgramatico(int $id)
    {
        # Recuperando o registor on banco de dados
        $conteudo = $this->conteudoProgramaticoRepository->find($id);

        #Verificando se foi atualizado no banco de dados
        if(!$conteudo) {
            throw new \Exception('Conteúdo não encontrado!');
        }

        # Removendo do banco
        $this->conteudoProgramaticoRepository->delete($id);

        #Retorno
        return true;
    }

    /**
     * @param array $data
     * @return array
     */
    public function tratamentoImagem(array &$data, $planoEnsino = "")
    {
        #tratando a imagem
        foreach ($data as $key => $value) {
            $explode = explode("_", $key);

            if (count($explode) > 0 && $explode[0] == "path") {
                $file = $data[$key];
                $fileName = md5(uniqid(rand(), true)) . "." . $file->getClientOriginalExtension();

                # Validando a atualização
                if (!empty($planoEnsino) && $planoEnsino->{$key} != null) {
                    unlink(__DIR__ . "/../../../public/" . $this->destinationPath . $planoEnsino->{$key});
                }

                #Movendo a imagem
                $file->move($this->destinationPath, $fileName);

                #renomeando
                $data[$key] = $fileName;
            }
        }

        # retorno
        return $data;
    }

    /**
     * @param $planoEnsino
     * @param $anexo
     * @return bool
     */
    public function deleteFile($planoEnsino, $anexo)
    {
        # Removendo o arquivo do diretório
        unlink(__DIR__ . "/../../../public/" . $this->destinationPath . $planoEnsino->$anexo);

        # Removendo o arquivo do banco de dados
        $planoEnsino->$anexo = null;
        $planoEnsino->save();

        # Retorno
        return true;
    }
}