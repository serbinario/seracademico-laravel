<?php

namespace Seracademico\Services\Biblioteca;

use Carbon\Carbon;
use Seracademico\Repositories\Biblioteca\ArcevoRepository;
use Seracademico\Repositories\Biblioteca\ExemplarRepository;
use Seracademico\Entities\Biblioteca\Exemplar;
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
     * @var
     */
    private $anoAtual;

    /**
     * @var
     */
    private $ultimoAno;

    /**
     * @var
     */
    private $tombo;

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
    public function findFixa($id)
    {
        $relacionamentos = [
            'acervo.exemplares',
            'acervo.tipoAcervo',
            'acervo.colecao',
            'acervo.genero',
            'acervo.situacao',
            'acervo.corredor',
            'acervo.estante',
            'acervo.segundaEntrada.responsaveis',
            'acervo.primeiraEntrada.responsaveis',
            'idioma',
            'editora',
            'ilustracoes',
            'aquisicao',
            'emprestimo',
            'emprestimos'
        ];

        #Recuperando o registro no banco de dados
        $exemplar = $this->repository->with($relacionamentos)->find($id);

        #Verificando se o registro foi encontrado
        if(!$exemplar) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
        return $exemplar;
    }
    
    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function find($id)
    {
        $relacionamentos = [
            'acervo',
            'emprestimos'
        ];
        
        #Recuperando o registro no banco de dados
        $exemplar = $this->repository->with($relacionamentos)->find($id);

        #Verificando se o registro foi encontrado
        if(!$exemplar) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
        return $exemplar;
    }

    /**
 * @return mixed
 * @throws \Exception
 */
    public function countExemplarNPeriodico()
    {
        $exemplar = \DB::table('bib_exemplares')
            ->join('bib_arcevos', 'bib_arcevos.id', '=', 'bib_exemplares.arcevos_id')
            ->where('bib_arcevos.tipo_periodico', '=', '1')
            ->select([
                \DB::raw('COUNT(bib_exemplares.id) as qtd_exemplar_np'),
            ])->get();

        #Verificando se o registro foi encontrado
        if(!$exemplar) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
        return $exemplar[0];
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function countExemplarPeriodico()
    {
        $exemplar = \DB::table('bib_exemplares')
            ->join('bib_arcevos', 'bib_arcevos.id', '=', 'bib_exemplares.arcevos_id')
            ->where('bib_arcevos.tipo_periodico', '=', '2')
            ->select([
                \DB::raw('COUNT(bib_exemplares.id) as qtd_exemplar_p'),
            ])->get();

        #Verificando se o registro foi encontrado
        if(!$exemplar) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
        return $exemplar[0];
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function detalheAcervo($id)
    {
        $relacionamentos = [
            'acervo.primeiraEntrada.responsaveis',
        ];

        $exemplar = $this->repository->with($relacionamentos)->find($id);

        if($exemplar->edicao && $exemplar->ano) {
            $exemplares = \DB::table('bib_exemplares')
                ->join('bib_arcevos', 'bib_arcevos.id', '=', 'bib_exemplares.arcevos_id')
                ->join('bib_situacao', 'bib_situacao.id', '=', 'bib_exemplares.situacao_id')
                ->where('bib_exemplares.arcevos_id', '=', $exemplar->arcevos_id)
                //->where('bib_exemplares.edicao', '=', $exemplar->edicao)
                //->where('bib_exemplares.ano', '=', $exemplar->ano)
                //->where('bib_exemplares.exemp_principal', '!=', '1')
                ->select('bib_arcevos.*', 'bib_situacao.*','bib_exemplares.*')
                ->get();
        } else if($exemplar->edicao && !$exemplar->ano) {
            $exemplares = \DB::table('bib_exemplares')
                ->join('bib_arcevos', 'bib_arcevos.id', '=', 'bib_exemplares.arcevos_id')
                ->join('bib_situacao', 'bib_situacao.id', '=', 'bib_exemplares.situacao_id')
                ->where('bib_exemplares.arcevos_id', '=', $exemplar->arcevos_id)
                //->where('bib_exemplares.edicao', '=', $exemplar->edicao)
                //->where('bib_exemplares.ano', '=', "")
                //->where('bib_exemplares.exemp_principal', '!=', '1')
                ->select('bib_arcevos.*', 'bib_situacao.*','bib_exemplares.*')
                ->get();
        } else if(!$exemplar->edicao && $exemplar->ano) {
            $exemplares = \DB::table('bib_exemplares')
                ->join('bib_arcevos', 'bib_arcevos.id', '=', 'bib_exemplares.arcevos_id')
                ->join('bib_situacao', 'bib_situacao.id', '=', 'bib_exemplares.situacao_id')
                ->where('bib_exemplares.arcevos_id', '=', $exemplar->arcevos_id)
                //->where('bib_exemplares.ano', '=', $exemplar->ano)
                //->where('bib_exemplares.edicao', '=', "")
                //->where('bib_exemplares.exemp_principal', '!=', '1')
                ->select('bib_arcevos.*', 'bib_situacao.*','bib_exemplares.*')
                ->get();
        } else {
            $exemplares = \DB::table('bib_exemplares')
                ->join('bib_arcevos', 'bib_arcevos.id', '=', 'bib_exemplares.arcevos_id')
                ->join('bib_situacao', 'bib_situacao.id', '=', 'bib_exemplares.situacao_id')
                ->where('bib_exemplares.arcevos_id', '=', $exemplar->arcevos_id)
               // ->where('bib_exemplares.edicao', '=', "")
               // ->where('bib_exemplares.ano', '=', "")
                //->where('bib_exemplares.exemp_principal', '!=', '1')
                ->select('bib_arcevos.*', 'bib_situacao.*','bib_exemplares.*')
                ->get();
        }


        $data = [
            'exemplar' => $exemplar,
            'exemplares' => $exemplares
        ];

        #Verificando se o registro foi encontrado
        if(!$exemplar) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
        return $data;
    }

    /**
     * @param $codigo
     * @return string
     */
    public function tratarCodigoExemplar($codigo)
    {
        if($codigo <= 1 || ($this->anoAtual != $this->ultimoAno)) {
            $newCod2  = '1'.$this->anoAtual;
        } else {
            $newCod = $codigo + 1;
            $newCod2 = $newCod.$this->anoAtual;
        }

        $newCod2 = str_pad($newCod2,8,"0",STR_PAD_LEFT);

        return $newCod2;
    }

    /**
     * @param array $data
     * @return array
     */
    public function store(array $data) : Exemplar
    {

        $data = $this->tratamentoDatas($data);
        $data = $this->tratamentoCampos($data);

        //dd($data);
        //recupera o acervo
        $acervo = $this->repoAcervo->find($data['arcevos_id']);

        //recupera o maior código ja registrado
        $dataObj  = new \DateTime('now');
        $this->anoAtual = date('Y');

        #recuperando o último código
        $codigo = \DB::table('bib_exemplares')
            ->where('bib_exemplares.codigo', 'like', '%'.$this->anoAtual)
            ->max('codigo');

        $codigoMax = $codigo != null ? $codigo : "0001{$this->anoAtual}";
        $codigoAtual = substr($codigoMax, 0, -4);
        $this->ultimoAno = substr($codigo, -4);
        
        //trata a quantidade de exemplar caso o valor informado seja 0
        $qtdExemplar = $data['registros'] != '0' && $data['registros'] != '' ? $qtdExemplar = $data['registros'] : $qtdExemplar = '1';
       
        if($acervo['exemplar_ref'] == '1') {
            for($i = 0; $i < $qtdExemplar; $i++) {
                if($i == 0){
                    $data['exemp_principal'] = '1';
                    $data['emprestimo_id'] = '2';
                    $data['situacao_id'] = '3';
                    $this->tombo = $this->tratarCodigoExemplar($codigoAtual);
                    $data['codigo'] = $this->tombo;
                    $data = $this->insertImg($data);

                    #Salvando o registro principal
                    $exemplar =  $this->repository->create($data);
                    $this->insertImg($exemplar->id);
                    $ultCodigo = substr($exemplar->codigo, 0, -4);
                    $codNovo = $ultCodigo + 1;
                    $this->tombo = $codNovo.$this->anoAtual;
                } else {
                    $data['exemp_principal'] = '0';
                    $data['emprestimo_id'] = '2';
                    $data['situacao_id'] = '3';
                    $data['codigo'] = $this->tombo;

                    #Salvando o registro principal
                    $exemplar =  $this->repository->create($data);
                    $this->insertImg($exemplar->id);
                    $ultCodigo = substr($exemplar->codigo, 0, -4);
                    $codNovo = $ultCodigo + 1;
                    $this->tombo = $codNovo.$this->anoAtual;
                }
            }
        } else {
            for($i = 0; $i < $qtdExemplar; $i++) {
                if($i == 0){
                    $data['exemp_principal'] = '1';
                    $data['emprestimo_id'] = '2';
                    $data['situacao_id'] = '3';
                    $this->tombo = $this->tratarCodigoExemplar($codigoAtual);
                    $data['codigo'] = $this->tombo;

                    #Salvando o registro principal
                    $exemplar =  $this->repository->create($data);
                    $this->insertImg($exemplar->id);
                    $ultCodigo = substr($exemplar->codigo, 0, -4);
                    $codNovo = $ultCodigo + 1;
                    $this->tombo = $codNovo.$this->anoAtual;
                } else {
                    $data['exemp_principal'] = '0';
                    $data['emprestimo_id'] = '1';
                    $data['situacao_id'] = '1';
                    $data['codigo'] = $this->tombo;
                    
                    #Salvando o registro principal
                    $exemplar =  $this->repository->create($data);
                    $this->insertImg($exemplar->id);
                    $ultCodigo = substr($exemplar->codigo, 0, -4);
                    $codNovo = $ultCodigo + 1;
                    $this->tombo = $codNovo.$this->anoAtual;
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
     * @param $id
     */
    public function insertImg($id)
    {
        #tratando a imagem
        if(isset($_FILES['img']['tmp_name']) && $_FILES['img']['tmp_name'] != null) {

            $tmpName = $_FILES['img']['tmp_name'];

            $fp = fopen($tmpName, 'r');

            $add = fread($fp, filesize($tmpName));

            $add = addslashes($add);

            fclose($fp);

            $pdo = \DB::connection()->getPdo();

            $query = "UPDATE bib_exemplares SET path_image = '{$add}' where id =  $id ";

            $pdo->query($query);
            
        }

    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, int $id) : Exemplar
    {

        $data = $this->tratamentoDatas($data);
        $data = $this->tratamentoCampos($data);

        $codigo = $data['codigo'];
        $ano    = $data['ano_tombo'];

        $data['codigo'] = $codigo.$ano;

        #Atualizando no banco de dados
        $exemplar = $this->repository->update($data, $id);
        $this->insertImg($exemplar->id);

        #Verificando se foi atualizado no banco de dados
        if(!$exemplar) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $exemplar;
    }

    /**
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public function delete(int $id)
    {
        #deletando o curso
        $result = $this->repository->delete($id);

        # Verificando se a execução foi bem sucessida
        if(!$result) {
            throw new \Exception('Ocorreu um erro ao tentar remover o responsável!');
        }

        #retorno
        return true;
    }

    /**
     * @return mixed
     */
    public function acervos()
    {
        $nameModel = "Seracademico\\Entities\\Biblioteca\\Arcevo";

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
            $nameModel = "Seracademico\\Entities\\Biblioteca\\$model";

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

}