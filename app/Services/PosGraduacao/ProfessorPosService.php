<?php

namespace Seracademico\Services\PosGraduacao;

use Seracademico\Repositories\PosGraduacao\ProfessorPosRepository;
use Seracademico\Entities\PosGraduacao\ProfessorPos;
use Seracademico\Repositories\EnderecoRepository;
use Seracademico\Repositories\PessoaRepository;
use Carbon\Carbon;
use Seracademico\Services\TraitService;

class ProfessorPosService
{
    use TraitService;
    
    /**
     * @var ProfessorPosRepository
     */
    private $repository;

    /**
     * @var EnderecoRepository
     */
    private $enderecoRepository;

    /**
     * @var PessoaRepository
     */
    private $pessoaRepository;

    /**
     * @var string
     */
    private $destinationPath = "images/";

    /**
     * ProfessorService constructor.
     * @param ProfessorPosRepository $repository
     * @param EnderecoRepository $enderecoRepository
     * @param PessoaRepository $pessoaRepository
     */
    public function __construct(ProfessorPosRepository $repository,
                                EnderecoRepository $enderecoRepository,
                                PessoaRepository $pessoaRepository)
    {
        $this->repository         = $repository;
        $this->enderecoRepository = $enderecoRepository;
        $this->pessoaRepository   = $pessoaRepository;
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function find($id)
    {

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

        #Recuperando o registro no banco de dados
        $professor = $this->repository->with($relacionamentos)->find($id);
        //dd($professor->endereco->cep);
        #Verificando se o registro foi encontrado
        if(!$professor) {
            throw new \Exception('Empresa não encontrada!');
        }

        #retorno
        return $professor;
    }

    /**
     * @param array $data
     * @return ProfessorPos
     * @throws \Exception
     */
    public function store(array $data) : ProfessorPos
    {
        #trata campos vazios
        $this->tratamentoCampos($data);

        # Tratamento imagens de cam
        $imgCam = isset($data['cod_img']) ? $data['cod_img'] : "";
        $img    = isset($data['img']) ? $data['img'] : "";

        # Regras de negócios
        $this->tratamentoImagem($data);

        #injetando senha de acesso ao portal do aluno no array principal
        $this->loginPortalAluno($data, $data['pessoa']['cpf']);

        # Recuperando a pessoa pelo cpf
        $objPessoa = $this->pessoaRepository->with('pessoa.endereco.bairro.cidade.estado')->findWhere(['cpf' => empty($data['pessoa']['cpf']) ?? 0]);
        $endereco  = null;

        # Verificando se a pesso já existe
        if(count($objPessoa) > 0) {
            #aAlterando a pessoa e o endereço
            $pessoa   = $this->pessoaRepository->update($data['pessoa'], $objPessoa[0]->id);
            $endereco =$this->enderecoRepository->update($data['pessoa']['endereco'], $pessoa->endereco->id);
        } else {
            #Criando o endereco e pessoa
            $endereco = $this->enderecoRepository->create($data['pessoa']['endereco']);

            # setando a chave estrangeira e criando a pessoa
            $data['pessoa']['enderecos_id'] = $endereco->id;
            $pessoa   = $this->pessoaRepository->create($data['pessoa']);
        }

        #setando as chaves estrageiras
        $data['pessoa_id'] = $pessoa->id;
        $data['tipo_nivel_sistema_id'] = 2;
        $data['primeiro_acesso'] = 0;

        #Salvando o registro pincipal
        $professor =  $this->repository->create($this->tratamentoDatas($data));

        //Validando se a imagem vem da webcam ou não, e salvando no banco
        if($imgCam && !$img) {

            $pdo = \DB::connection()->getPdo();

            $query = "UPDATE fac_professores SET path_image = '{$imgCam}', tipo_img = 2 where id = {$professor->id} ";

            $pdo->query($query);

        } else if ($img && !$imgCam) {

            $this->insertImg($professor->id, 1);

        } else if ($imgCam && $img) {

            $pdo = \DB::connection()->getPdo();

            $query = "UPDATE fac_professores SET path_image = '{$imgCam}', tipo_img = 2 where id = {$professor->id} ";

            $pdo->query($query);

        }

        #Verificando se foi criado no banco de dados
        if(!$professor) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $professor;
    }

    /**
     * @param $data
     */
    public function loginPortalAluno(&$data, $cpf) {

        $cpf = str_replace(array('.', '-'), "", $cpf);

        #tratando a senha
        $data['password'] = \bcrypt($cpf);

        #setando número de matricula como login do portal do aluno
        $data['login'] = $cpf;
    }

    /**
     * @param array $data
     * @param int $id
     * @return ProfessorPos
     * @throws \Exception
     */
    public function update(array $data, int $id) : ProfessorPos
    {
        $imgCam = isset($data['cod_img']) ? $data['cod_img'] : "";
        $img    = isset($data['img']) ? $data['img'] : "";

        # Regras de negócios
        $this->tratamentoCampos($data);
        $this->tratamentoDatas($data);

        # Recuperando o vestibulando
        $professor = $this->repository->find($id);

        $this->loginPortalAluno($data, $professor->pessoa->cpf);

        # Regras de negócios
        $this->tratamentoImagem($data, $professor);

        //Validando se a imagem vem da webcam ou não, e salvando no banco
        if($imgCam && !$img) {

            $pdo = \DB::connection()->getPdo();

            $query = "UPDATE fac_professores SET path_image = '{$imgCam}', tipo_img = 2 where id = {$id} ";

            $pdo->query($query);

        } else if ($img && !$imgCam) {

            $this->insertImg($professor->id, 1);

        } else if ($imgCam && $img) {

            $pdo = \DB::connection()->getPdo();

            $query = "UPDATE fac_professores SET path_image = '{$imgCam}', tipo_img = 2 where id = {$id} ";

            $pdo->query($query);

        }

        #Atualizando no banco de dados
        $professor = $this->repository->update($this->tratamentoDatas($data), $id);
        $pessoa   = $this->pessoaRepository->update($data['pessoa'], $professor->pessoa->id);
        $endereco = $this->enderecoRepository->update($data['pessoa']['endereco'], $pessoa->endereco->id);


        #Verificando se foi atualizado no banco de dados
        if(!$professor || !$endereco) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $professor;
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function tratamentoDatas(array $data) : array
    {
        #tratando as datas
        $data['data_admissao']   = $data['data_admissao'] != "" ? Carbon::createFromFormat("d/m/Y", $data['data_admissao']) : "";

        #retorno
        return $data;
    }

    /**
     * @param $id
     * @return string
     */
    public function getPathArquivo($id, $tipo)
    {
        # Recuperando o contrato
        $professor = $this->repository->find($id);

        #Retornando o caminho completo do arquivo
        return $this->destinationPath . $professor->$tipo;
    }
}