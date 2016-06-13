<?php

namespace Seracademico\Services\Graduacao;

use Seracademico\Entities\Graduacao\Aluno;
use Seracademico\Repositories\Graduacao\AlunoRepository;
use Seracademico\Repositories\EnderecoRepository;
use Seracademico\Validators\Graduacao\AlunoValidator;

class AlunoService
{
    /**
     * @var AlunoRepository
     */
    private $repository;

    /**
     * @var EnderecoRepository
     */
    private $enderecoRepository;

    /**
     * @var string
     */
    private $destinationPath = "images/";

    /**
     * @param AlunoRepository $repository
     * @param EnderecoRepository $enderecoRepository
     */
    public function __construct(AlunoRepository $repository, EnderecoRepository $enderecoRepository)
    {
        $this->repository         = $repository;
        $this->enderecoRepository = $enderecoRepository;
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function find($id)
    {
        #Recuperando o registro no banco de dados

        $relacionamentos = [
            'pessoa.endereco.bairro.cidade.estado',
            'pessoa.estadoCivil',
            'pessoa.sexo',
            'pessoa.turno',
            'pessoa.grauInstrucao',
            'pessoa.profissao',
            'pessoa.corRaca',
            'pessoa.ufNascimento',
        ];

        $aluno = $this->repository->with($relacionamentos)->find($id);

        #Verificando se o registro foi encontrado
        if(!$aluno) {
            throw new \Exception('Aluno não encontrado!');
        }

        #retorno
        return $aluno;
    }

    /**
     * @param array $data
     * @return array
     */
    public function store(array $data) : Aluno
    {
        #tratamento de dados do aluno
        $data     = $this->tratamentoCamposAluno($data);

        #setando o nivel do sistema
        $data['tipo_nivel_sistema_id'] = 2;

        #tratando a imagem
        if(isset($data['img'])) {
            $file     = $data['img'];
            $fileName = md5(uniqid(rand(), true)) . "." . $file->getClientOriginalExtension();

            #Movendo a imagem
            $file->move($this->destinationPath, $fileName);

            #setando o nome da imagem no model
            $data['path_image'] = $fileName;

            #destruindo o img do array
            unset($data['img']);
        }

        #Criando no banco de dados
        $endereco = $this->enderecoRepository->create($data['endereco']);

        #setando o endereco
        $data['enderecos_id'] = $endereco->id;

        #Salvando o registro pincipal
        $aluno =  $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$aluno) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $aluno;
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, int $id) : Aluno
    {
        #tratamento de dados do aluno
        $data     = $this->tratamentoCamposAluno($data);

        #setando o nivel do sistema
        $data['tipo_nivel_sistema_id'] = 2;

        #Atualizando no banco de dados
        $aluno    = $this->repository->update($data, $id);
        $endereco = $this->enderecoRepository->update($data['endereco'], $aluno->endereco->id);

        #tratando a imagem
        if(isset($data['img'])) {
            $file     = $data['img'];
            $fileName = md5(uniqid(rand(), true)) . "." . $file->getClientOriginalExtension();


            #removendo a imagem antiga
            if ($aluno->path_image != null) {
                unlink(__DIR__ . "/../../public/" . $this->destinationPath . $aluno->path_image);
            }

            #Movendo a imagem
            $file->move($this->destinationPath, $fileName);

            #setando o nome da imagem no model
            $aluno->path_image = $fileName;
            $aluno->save();

            #destruindo o img do array
            unset($data['img']);
        }

        #Verificando se foi atualizado no banco de dados
        if(!$aluno || !$endereco) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $aluno;
    }

    /**
     * @param array $models
     * @return array
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
            $result[strtolower($model)] = $nameModel::lists('nome', 'id');
        }

        #retorno
        return $result;
    }

    /**
     * @param $data
     * @return mixed
     */
    private function tratamentoCamposAluno($data)
    {
        #tratamento de datas do aluno
        $data['data_expedicao']           = $this->convertDate($data['data_expedicao'], 'en');
        $data['data_nasciemento']         = $this->convertDate($data['data_nasciemento'], 'en');
        //$data['data_exame_nacional_um']   = $this->convertDate($data['data_exame_nacional_um'], 'pt-BR');
        //$data['data_exame_nacional_dois'] = $this->convertDate($data['data_exame_nacional_dois'], 'pt-BR');

        # Tratamento de campos de chaves estrangeira
        foreach ($data as $key => $value) {
            $explodeKey = explode("_", $key);

            if ($explodeKey[count($explodeKey) -1] == "id" && $value == null ) {
                $data[$key] = null;
            }
        }

        #retorno
        return $data;
    }
}