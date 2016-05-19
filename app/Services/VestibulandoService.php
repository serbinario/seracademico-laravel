<?php

namespace Seracademico\Services;

use Seracademico\Entities\Aluno;
use Seracademico\Repositories\AlunoNotaVestibularRepository;
use Seracademico\Repositories\AlunoRepository;
use Seracademico\Repositories\EnderecoRepository;
use Seracademico\Repositories\VestibularRepository;
use Seracademico\Validators\AlunoValidator;
use Seracademico\Entities;

class VestibulandoService
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
     * @var VestibularRepository
     */
    private $vestibularRepository;

    /**
     * @var AlunoNotaVestibularRepository
     */
    private $notaRepository;

    /**
     * @var string
     */
    private $destinationPath = "images/";

    /**
     * @param AlunoRepository $repository
     * @param EnderecoRepository $enderecoRepository
     * @param VestibularRepository $vestibularRepository
     * @param AlunoNotaVestibularRepository $notaRepository
     */
    public function __construct(
        AlunoRepository $repository,
        EnderecoRepository $enderecoRepository,
        VestibularRepository $vestibularRepository,
        AlunoNotaVestibularRepository $notaRepository)
    {
        $this->repository           = $repository;
        $this->enderecoRepository   = $enderecoRepository;
        $this->vestibularRepository = $vestibularRepository;
        $this->notaRepository       = $notaRepository;
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
            throw new \Exception('Vestibulando não encontrado!');
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
        $data = $this->tratamentoCamposAluno($data);
        $this->tratamentoCampos($data);
        $this->tratamentoInscricao($data);

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

        #tratamento vestibular
        $this->tratamentoVestibular($aluno);

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
        $data = $this->tratamentoCamposAluno($data);
        $this->tratamentoCampos($data);
        $this->tratamentoInscricao($data, $id);

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
                if(count($expressao) > 1) {
                    switch (count($expressao)) {
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
                if(count($expressao) > 1) {
                    #Recuperando o registro e armazenando no array
                    $result[strtolower($model)] = $nameModel::{$expressao[0]}($expressao[1])->lists('nome', 'id');
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
        $aluno->data_insricao_vestibular = $aluno->data_insricao_vestibular == '0000-00-00' ? "" : $aluno->data_insricao_vestibular;


        #tratando as datas
        $aluno->data_expedicao   = date('d/m/Y', strtotime($aluno->data_expedicao));
        $aluno->data_nasciemento = date('d/m/Y', strtotime($aluno->data_nasciemento));
        $aluno->data_insricao_vestibular = date('d/m/Y', strtotime($aluno->data_insricao_vestibular));
        //$aluno->data_exame_nacional_um   = date('d/m/Y', strtotime($aluno->data_exame_nacional_um));
        //$aluno->data_exame_nacional_dois = date('d/m/Y', strtotime($aluno->data_exame_nacional_dois));

        #return
        return $aluno;
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
     * @return mixed
     */
    public function tratamentoInscricao(array &$data, $id = "") : array
    {
        # Validando o parâmetro
        if(isset($data['gerar_inscricao']) && $data['gerar_inscricao'] == 1) {
            if($id) {
                $vestibulando = $this->repository->find($id);
                if($vestibulando->gerar_inscricao == 1) {
                    unset($data['gerar_inscricao']);
                    return $data;
                }
            }

            # Gerando a inscrição
            $data['inscricao'] = $this->gerarInscricao();
        }

        # retorno
        return $data;
    }

    /**
     * @return string
     */
    public function gerarInscricao()
    {
        # Recuperndo a data atual
        $dataNow = new \DateTime('now');

        # Retorno
        return $dataNow->format('YmdHis');
    }

    /**
     * @param Aluno $aluno
     * @throws \Exception
     */
    public function tratamentoVestibular(Aluno $aluno)
    {
        # Verificando o vestibular
        if(!$aluno->vestibular) {
            throw new \Exception('Vestibular não existe');
        }

        # Verificando se o aluno já possui notas
        if(count($aluno->notasVestibular) > 0) {
            return false;
        }

        # Recuperando as matérias
        $idVestibular = $aluno->vestibular->id;
        $materias     = \DB::table('fac_materias')
                        ->select('id')
                        ->whereIn('id', function ($query) use ($idVestibular) {
                            $query->from('vestibular_curso_materia')
                                ->distinct()
                                ->select('vestibular_curso_materia.materia_id')
                                ->join('vestibulares_cursos', 'vestibulares_cursos.id', '=', 'vestibular_curso_materia.vestibular_curso_id')
                                ->join('fac_cursos', 'fac_cursos.id', '=', 'vestibulares_cursos.curso_id')
                                ->join('vestibulares', 'vestibulares.id', '=', 'vestibulares_cursos.vestibular_id')
                                ->where('vestibulares.id', $idVestibular)
                                ->get();
                        })->get();

        # Criando as notas dos alunos
        foreach ($materias as $materia) {
            $aluno->notasVestibular()->create(['materia_id' => $materia->id]);
        }

        # Retorno
        return true;
    }

    /**
     * @param array $data
     * @return mixed
     * @throws \Exception
     */
    public function findNota(array $data)
    {
        # Validando os dados da requisição
        if(!isset($data['idNota']) && !is_numeric($data['idNota']) &&
            !isset($data['idVestibulando']) && !is_numeric($data['idVestibulando'])) {
            throw new \Exception('Dados inválidos');
        }

        # Recuperando a nota
        $nota = $this->notaRepository->find($data['idNota']);

        # Verificando se a nota existe
        if(!$nota) {
            throw new \Exception('Nota não existe');
        }

        # Retorno
        return $nota;
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function updateNota(array $data, int $id) : Entities\AlunoNotaVestibular
    {
        #Atualizando no banco de dados
        $nota = $this->notaRepository->update($data, $id);


        #$nota se foi atualizado no banco de dados
        if(!$nota) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $nota;
    }

    /**
     * @param $dados
     * @param $idVestibulando
     * @return bool
     * @throws \Exception
     */
    public function updateInclusao($dados, $idVestibulando)
    {
        # Recuperando o vestibulando e o currículo
        $vestibulando = $this->repository->find($idVestibulando);
        $curriculo    = Entities\Graduacao\Curriculo::byCurso($dados['curso_id']);

        # Verificando se o vestibulando existe
        if(!$vestibulando && !$curriculo) {
            throw new \Exception('Vestibulando não existe');
        }

        # Regra de negócio do currículo
        unset($dados['curso_id']);
        $dados['curriculo_id'] = $curriculo[0]->id;
        $dados['situacao_id']  = 1;
        $dados['periodo']      = 1;

        #Regrade negócio matrícula
        $dataNow = new \DateTime('now');
        $dados['matricula']    = $dataNow->format('YmdHis');

        #atualizando o matriculando
        $vestibulando->situacao_id = $dados['situacao_id'];
        $vestibulando->periodo     = $dados['periodo'];
        $vestibulando->matricula   = $dados['matricula'];
        $vestibulando->save();


        # Atualizando a inclusão
        $inclusao = $vestibulando->inclusao;
        $inclusao->curriculo_id = $dados['curriculo_id'];
        $inclusao->forma_admissao_id = $dados['forma_admissao_id'];
        $inclusao->data_inclusao = $dados['data_inclusao'];
        $inclusao->turno_id = $dados['turno_id'];
        $inclusao->save();

        #retorno
        return true;
    }
}