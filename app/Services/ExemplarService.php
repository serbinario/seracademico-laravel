<?php

namespace Seracademico\Services;

use Carbon\Carbon;
use Seracademico\Repositories\ArcevoRepository;
use Seracademico\Repositories\ExemplarRepository;
use Seracademico\Entities\Exemplar;
//use Carbon\Carbon;

class ExemplarService
{
    /**
     * @var ExemplarRepository
     */
    private $repository;

    /**
     * @var ArcevoRepository
     */
    private $repoAcervo;

    /**
     * @var string
     */
    private $destinationPath = "img-exemplar/";

    /**
     * @param ExemplarRepository $repository
     */
    public function __construct(ExemplarRepository $repository, ArcevoRepository $repoAcervo)
    {
        $this->repository = $repository;
        $this->repoAcervo = $repoAcervo;
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function find($id)
    {
        #Recuperando o registro no banco de dados
        $exemplar = $this->repository->find($id);

        #Verificando se o registro foi encontrado
        if(!$exemplar) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
        return $exemplar;
    }

    /**
     * @param array $data
     * @return array
     */
    public function store(array $data) : Exemplar
    {

        $data = $this->tratamentoDatas($data);

        //recupera o acervo
        $acervo = $this->repoAcervo->find($data['arcevos_id']);

        //recupera o maior código ja registrado
        $codigo = \DB::table('bib_exemplares')->max('codigo');
        $codigoMax = $codigo != null ? $codigoMax = $codigo : $codigoMax = '1';

        //trata a quantidade de exemplar caso o valor informado seja 0
        $qtdExemplar = $data['registros'] == '0' ? $qtdExemplar = 1 : $qtdExemplar = $data['registros'];
        //dd($codigoMax);
        if($acervo['exemplar_ref'] == '1') {
            for($i = 0; $i < $qtdExemplar; $i++) {
                if($i == 0){
                    $data['exemp_principal'] = '1';
                    $data['emprestimo_id'] = '2';
                    $data['situacao_id'] = '3';
                    $data['codigo'] = $this->tratarCodigoExemplar($codigoMax);
                    #Salvando o registro pincipal
                    $exemplar =  $this->repository->create($data);
                    $codigoMax = $exemplar->codigo + 1;
                } else {
                    $data['exemp_principal'] = '0';
                    $data['emprestimo_id'] = '2';
                    $data['situacao_id'] = '3';
                    $data['codigo'] = $codigoMax;
                    #Salvando o registro pincipal
                    $exemplar =  $this->repository->create($data);
                    $codigoMax = $exemplar->codigo + 1;
                }
            }
        } else {
            for($i = 0; $i < $qtdExemplar; $i++) {
                if($i == 0){
                    $data['exemp_principal'] = '1';
                    $data['emprestimo_id'] = '2';
                    $data['situacao_id'] = '3';
                    $data['codigo'] = $this->tratarCodigoExemplar($codigoMax);
                    #Salvando o registro pincipal
                    $exemplar =  $this->repository->create($data);
                    $codigoMax = $exemplar->codigo + 1;
                } else {
                    $data['exemp_principal'] = '0';
                    $data['emprestimo_id'] = '1';
                    $data['situacao_id'] = '1';
                    $data['codigo'] = $codigoMax;
                    #Salvando o registro pincipal
                    $exemplar =  $this->repository->create($data);
                    $codigoMax = $exemplar->codigo + 1;
                }
            }
        }

        #Verificando se foi criado no banco de dados
        if(!$exemplar) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $exemplar;
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, int $id) : Exemplar
    {

        #Atualizando no banco de dados
        $exemplar = $this->repository->update($data, $id);

        #tratando a imagem
        /*if(isset($data['img'])) {
            $file     = $data['img'];
            $fileName = md5(uniqid(rand(), true)) . "." . $file->getClientOriginalExtension();


            #removendo a imagem antiga
            if ($exemplar->path_image != null) {
                unlink(__DIR__ . "/../../public/" . $this->destinationPath . $exemplar->path_image);
            }

            #Movendo a imagem
            $file->move($this->destinationPath, $fileName);

            #setando o nome da imagem no model
            $exemplar->path_image = $fileName;
            $exemplar->save();

            #destruindo o img do array
            unset($data['img']);
        }*/

        #Verificando se foi atualizado no banco de dados
        if(!$exemplar) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $exemplar;
    }

    /**
     * @return mixed
     */
    public function acervos()
    {
        $nameModel = "Seracademico\\Entities\\Arcevo";

        #Recuperando o registro e armazenando no array
        $result[strtolower("Arcevo")] = $nameModel::lists('titulo', 'id');

        return $result;
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
     * @param array $data
     * @return mixed
     */
    public function tratamentoDatas($data) : array
    {
         #tratando as datas
         $data['data_aquisicao'] = $data['data_aquisicao'] ? $this->convertDate($data['data_aquisicao'], 'en') : "";

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
    public function getDateFormatPtBr($entity)
    {
        #validando as datas
        $entity->data_aquisicao   = $entity->data_aquisicao == '0000-00-00' ? "" : $entity->data_aquisicao;

        #tratando as datas
        $entity->data_aquisicao   = date('d/m/Y', strtotime($entity->data_aquisicao));
        //$aluno->data_exame_nacional_um   = date('d/m/Y', strtotime($aluno->data_exame_nacional_um));
        //$aluno->data_exame_nacional_dois = date('d/m/Y', strtotime($aluno->data_exame_nacional_dois));

        #return
        return $entity;
    }

    /**
     * @param $codigo
     * @return string
     */
    public function tratarCodigoExemplar($codigo)
    {
        if($codigo <= 1) {
            $newCod  = $codigo;
        } else {
            $newCod = $codigo + 1;
        }

        $newCod = str_pad($newCod,6,"0",STR_PAD_LEFT);

        return $newCod;
    }

    /**
     * @param $data
     */
    public function insertImg($data, $img)
    {
        #tratando a imagem
        if(isset($img) && $img != null) {
            $file     = $img;
            $fileName = md5(uniqid(rand(), true)) . "." . $file->getClientOriginalExtension();

            #Movendo a imagem
            $file->move($this->destinationPath, $fileName);

            #setando o nome da imagem no model
            $data['path_image'] = $fileName;

            #destruindo o img do array
            unset($data['img']);

        }

        return $data;
    }

}