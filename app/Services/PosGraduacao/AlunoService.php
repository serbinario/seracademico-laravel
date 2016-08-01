<?php

namespace Seracademico\Services\PosGraduacao;

use Seracademico\Entities\Aluno;
use Seracademico\Repositories\AlunoRepository;
use Seracademico\Repositories\EnderecoRepository;
use Seracademico\Validators\AlunoValidator;
use Seracademico\Entities;

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
            'endereco.bairro.cidade.estado',
            'estadoCivil',
            'sexo',
            'turno',
            'grauInstrucao',
            'profissao',
            'corRaca',
            'ufNascimento',
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
        $data['data_insricao_vestibular'] = $this->convertDate($data['data_insricao_vestibular'], 'en');
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

    /**
     * @param $date
     * @return bool|string
     */
    public function convertDate($date, $format)
    {
        #declarando variável de retorno
        $result = "";

        #convertendo a data
        if (!empty($date) && !empty($format)) {
            #Fazendo o tratamento por idioma
            switch ($format) {
                case 'pt-BR' : $result = date_create_from_format('Y-m-d', $date); break;
                case 'en'    : $result = date_create_from_format('d/m/Y', $date); break;
            }
        }

        #retorno
        return $result;
    }

    /**
     * @param Aluno $aluno
     */
    public function getAlunoWithDateFormatPtBr(Aluno $aluno)
    {
        #validando as datas
        $aluno->data_expedicao   = $aluno->data_expedicao == '0000-00-00' ? "" : $aluno->data_expedicao;
        $aluno->data_nasciemento = $aluno->data_nasciemento == '0000-00-00' ? "" : $aluno->data_nasciemento;

        #tratando as datas
        $aluno->data_expedicao   = date('d/m/Y', strtotime($aluno->data_expedicao));
        $aluno->data_nasciemento = date('d/m/Y', strtotime($aluno->data_nasciemento));
        //$aluno->data_exame_nacional_um   = date('d/m/Y', strtotime($aluno->data_exame_nacional_um));
        //$aluno->data_exame_nacional_dois = date('d/m/Y', strtotime($aluno->data_exame_nacional_dois));

        #return
        return $aluno;
    }
}