<?php

namespace Seracademico\Services\PosGraduacao;

use Seracademico\Entities\PosGraduacao\Aluno;
use Seracademico\Entities\PosGraduacao\AlunoFrequencia;
use Seracademico\Entities\PosGraduacao\AlunoNota;
use Seracademico\Entities\PosGraduacao\Curriculo;
use Seracademico\Repositories\PosGraduacao\AlunoRepository;
use Seracademico\Repositories\EnderecoRepository;
use Seracademico\Repositories\PessoaRepository;
use Seracademico\Repositories\PosGraduacao\CurriculoRepository;
use Seracademico\Repositories\SituacaoAlunoRepositoryEloquent;
use Seracademico\Facades\ParametroMatriculaFacade;

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
     * @var PessoaRepository
     */
    private $pessoaRepository;

    /**
     * @var SituacaoAlunoRepositoryEloquent
     */
    private $situacaoRepository;

    /**
     * @var string
     */
    private $destinationPath = "images/";

    /**
     * @var CurriculoRepository
     */
    private $curriculoRepository;

    /**
     * AlunoService constructor.
     * @param AlunoRepository $repository
     * @param EnderecoRepository $enderecoRepository
     * @param PessoaRepository $pessoaRepository
     * @param SituacaoAlunoRepositoryEloquent $situacaoRepository
     * @param CurriculoRepository $curriculoRepository
     */
    public function __construct(
        AlunoRepository $repository,
        EnderecoRepository $enderecoRepository,
        PessoaRepository $pessoaRepository,
        SituacaoAlunoRepositoryEloquent $situacaoRepository,
        CurriculoRepository $curriculoRepository)
    {
        $this->repository         = $repository;
        $this->enderecoRepository = $enderecoRepository;
        $this->pessoaRepository   = $pessoaRepository;
        $this->situacaoRepository = $situacaoRepository;
        $this->curriculoRepository = $curriculoRepository;
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
            'curriculos'
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
     * @return Aluno
     * @throws \Exception
     */
    public function store(array $data) : Aluno
    {
        # Recuperando dados da imagem
        $imgCam = isset($data['cod_img']) ? $data['cod_img'] : "";
        $img    = isset($data['img']) ? $data['img'] : "";

        #regras de negócios
        $this->tratamentoCampos($data);
        //$this->tratamentoMatricula($data);
        $this->tratamentoCurso($data);

        # Recuperando a pessoa pelo cpf
        $objPessoa = [];
        $endereco  = null;

        # Validando o cpf
        if($data['pessoa']['cpf']) {
            $objPessoa = $this->pessoaRepository->with('endereco.bairro.cidade.estado')->findWhere(['cpf' => $data['pessoa']['cpf']]);
        }

        # Verificando se a pesso já existe
        if(count($objPessoa) > 0) {
            #aAlterando a pessoa e o endereço
            $pessoa   = $this->pessoaRepository->update($data['pessoa'], $objPessoa[0]->id);
            $endereco = $this->enderecoRepository->update($data['pessoa']['endereco'], $pessoa->endereco->id);
        } else {
            #Criando o endereco e pessoa
            $endereco = $this->enderecoRepository->create($data['pessoa']['endereco']);

            # setando a chave estrangeira e criando a pessoa
            $data['pessoa']['enderecos_id'] = $endereco->id;
            $pessoa  = $this->pessoaRepository->create($data['pessoa']);
        }

        #setando as chaves estrageiras
        $data['pessoa_id'] = $pessoa->id;

        #Salvando o registro pincipal
        $aluno =  $this->repository->create($data);

        //Validando se a imagem vem da webcam ou não, e salvando no banco
        if($imgCam && !$img) {
            # Recuperando a conexão
            $pdo = \DB::connection()->getPdo();

            # Query de atualização
            $query = "UPDATE pos_alunos SET path_image = '{$imgCam}', tipo_img = 2 where id = {$aluno->id} ";

            # Persistindo as alterações
            $pdo->query($query);
        } else if ($img && !$imgCam) {
            # Inserindo a imagem
            $this->insertImg($aluno->id, 1);
        } else if ($imgCam && $img) {
            # Recuperando a conexão
            $pdo = \DB::connection()->getPdo();

            # Query de atualização
            $query = "UPDATE pos_alunos SET path_image = '{$imgCam}', tipo_img = 2 where id = {$aluno->id} ";

            # Persistindo as alterações
            $pdo->query($query);
        }

        #Verificando se foi criado no banco de dados
        if(!$aluno) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        # Tratamento do currículo do aluno
        if(isset($data['curriculo_id'])) {
            #Vinculando o currículo, situação e turma ao aluno
            $aluno->curriculos()->attach($data['curriculo_id']);

            # Recuperando o ultimo registro e vinculando a situação
            $aluno->curriculos()->get()->last()->pivot->situacoes()->attach(1, [
                'turma_origem_id' => $data['turma_id'] ?? null
            ]);

            # Verificando se a turma foi informada
            if($data['turma_id']) {
                # Recuperando o ultimo registro e vinculando a turma ao curso
                $aluno->curriculos()->get()->last()->pivot->turmas()->attach($data['turma_id']);

                # Regras de negócios para cadastro automático de
                # notas e frequências
                $this->tratamentoNotas($aluno);
            }
        }
        
        #Retorno
        return $aluno;
    }

    /**
     * @param array $data
     * @param int $id
     * @return Aluno
     * @throws \Exception
     */
    public function update(array $data, int $id) : Aluno
    {
        # Recuperando dados da imagem
        $imgCam = isset($data['cod_img']) ? $data['cod_img'] : "";
        $img    = isset($data['img']) ? $data['img'] : "";

        # Recuperando o vestibulando
        $aluno = $this->repository->find($id);     

        #Regras de negócios
        $this->tratamentoCampos($data);
        $this->tratamentoCurso($data);
        //$this->tratamentoMatricula($data);

        //Validando se a imagem vem da webcam ou não, e salvando no banco
        if($imgCam && !$img) {
            # Recuperando a conexão
            $pdo = \DB::connection()->getPdo();

            # Alterando o registro
            $query = "UPDATE pos_alunos SET path_image = '{$imgCam}', tipo_img = 2 where id = {$id} ";

            # Persistindo as alterações
            $pdo->query($query);
        } else if ($img && !$imgCam) {
            # Inserindo a imagem
            $this->insertImg($aluno->id, 1);
        } else if ($imgCam && $img) {
            # Recuperando a conexão
            $pdo = \DB::connection()->getPdo();

            # Alterando o registro
            $query = "UPDATE pos_alunos SET path_image = '{$imgCam}', tipo_img = 2 where id = {$id} ";

            # Persistindo as alterações
            $pdo->query($query);
        }

        #Atualizando no banco de dados
        $aluno    = $this->repository->update($data, $id);
        $pessoa   = $this->pessoaRepository->update($data['pessoa'], $aluno->pessoa->id);
        $endereco = $this->enderecoRepository->update($data['pessoa']['endereco'], $pessoa->endereco->id);

        #Verificando se foi atualizado no banco de dados
        if(!$aluno || !$endereco) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        # Tratamento do currículo do aluno
        if(isset($data['curriculo_id'])) {
            # Regra de negócios para tratamento do curriculo
            $this->tratamentoCursoUpdate($aluno, $data['curriculo_id']);

            # Verificando se a turma foi informada
            if($data['turma_id']) {
                # Regra de negócio para tratamento da turma em caso de atualização
                $this->tratamentoTurmaUpdate($aluno, $data['turma_id']);
            }
        }

        #Retorno
        return $aluno;
    }

    /**
     * @param $aluno
     * @param $idCurriculo
     * @return bool
     */
    public function tratamentoCursoUpdate($aluno, $idCurriculo)
    {
        # Verificando se existe currículo cadastrado, se existir se é igual ao informado
        if(count($aluno->curriculos) > 0 && $aluno->curriculos->last()->id == $idCurriculo) {
            return true;
        }

        #Vinculando o currículo, situação e turma ao aluno
        $aluno->curriculos()->attach($idCurriculo);
        $aluno->curriculos()->find($idCurriculo)->situacoes()->attach(1, [
            'turma_origem_id' => $aluno->curriculos->last()->pivot->turmas->last()->id ?? null
        ]);
    }

    /**
     * @param $aluno
     * @param $idTurma
     * @return bool
     */
    public function tratamentoTurmaUpdate($aluno, $idTurma)
    {
        # Recuperando o currículo do aluno
        $curriculo = $aluno->curriculos()->get()->last();

        # Verificando se existe turma cadastada
        if(count($curriculo->pivot->turmas()->get()) > 0) {
            # Recuperando o pivot da turma
            $alunoTurma  = $curriculo->pivot->turmas()->get()->last()->pivot;
            $lastTurmaId = $alunoTurma->turma_id;

            # Filtrando as situações
            $situacoes = $curriculo->pivot->situacoes()->get()->filter(function ($situacao) use ($lastTurmaId) {
                return $situacao->turma_origem_id == $lastTurmaId;
            });

            # Alterando a turma de origem das situações
            $situacoes->each(function ($situacao) use ($idTurma) {
                # Alterando o id da turma de origem
                $situacao->pivot->turma_origem_id = $idTurma;
                $situacao->pivot->save();

                # Retorno ficticio
                return false;
            });

            # Atualizando a turma no pivot
            $alunoTurma->turma_id = $idTurma;
            $alunoTurma->save();

            # Retorno
            return true;
        }

        # Vinculando a turma
        $curriculo->pivot->turmas()->attach($idTurma);

        # Alterando a turma de origem das situações
        $curriculo->pivot->situacoes()->get()->each(function ($situacao) use ($idTurma) {
            # Alterando o id da turma de origem
            $situacao->pivot->turma_origem_id = $idTurma;
            $situacao->pivot->save();

            # Retorno ficticio
            return false;
        });

        # Tratamento das notas do aluno
        $this->tratamentoNotas($aluno);

        #retorno
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
            $disciplinaTurma = $turma->disciplinas()->find($disciplina->id);
            $calendario = $disciplinaTurma ? $disciplinaTurma->pivot->calendarios->last() : null;

            # Verificando se existe calendário
            if(!isset($calendario)) {
                continue;
            }

            # Verificando se o calendário é válido
            if(\DateTime::createFromFormat('d/m/Y' , $calendario->data_final) < $dataHoje) {
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

    /**
     * @param $id
     */
    public function insertImg($id, $tipo)
    {
        #tratando a imagem
        if(isset($_FILES['img']['tmp_name']) && $_FILES['img']['tmp_name'] != null) {
            # Tratando a imagem
            $tmpName = $_FILES['img']['tmp_name'];
            $fp = fopen($tmpName, 'r');
            $add = fread($fp, filesize($tmpName));

            # Escapando os caractéres
            $add = addslashes($add);

            # Fechando o arquivo
            fclose($fp);

            # Persistindo no banco
            $pdo = \DB::connection()->getPdo();
            $query = "UPDATE pos_alunos SET path_image = '{$add}', tipo_img = {$tipo} where id =  $id ";
            $pdo->query($query);
        }

    }

    /**
     * @param array $data
     * @return bool
     * @throws \Exception
     */
    public function tratamentoCurso(array &$data)
    {
        # Verificando se o curso foi informado
        if(!isset($data['curso_id'])) {
            //throw new \Exception('Curso não informado');
            return true;
        }
        
        # recuperando o currículo
        $curriculo = Curriculo::byCurso($data['curso_id']);

        # Verificando se o currículo foi encontrado
        if(!$curriculo && !count($curriculo) == 1) {
            throw new \Exception('Currículo não encontrado');
        }

        # tratando o array
        unset($data['curso_id']);
        $data['curriculo_id'] = $curriculo[0]->id;

        # retorno
        return true;
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
    public function tratamentoImagem(array &$data, $aluno = "")
    {
        #tratando a imagem
        foreach ($data as $key => $value) {
            $explode = explode("_", $key);

            if (count($explode) > 0 && $explode[0] == "path") {
                $file = $data[$key];
                $fileName = md5(uniqid(rand(), true)) . "." . $file->getClientOriginalExtension();

                # Validando a atualização
                if (!empty($aluno) && $aluno->{$key} != null) {
                    unlink(__DIR__ . "/../../../public/" . $this->destinationPath . $aluno->{$key});
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
     * @param array $data
     * @return mixed
     */
    public function tratamentoMatricula(array &$data) : array
    {
        # Validando o parâmetro
       // if(isset($data['gerar_matricula']) && $data['gerar_matricula'] == 1) {
        # Gerando a matrícula
        $data['matricula'] = $this->gerarMatricula();
        //}

        # retorno
        return $data;
    }

    /**
     * @return string
     */
    public function gerarMatricula()
    {
        # Recuperando a data atual
        $now = new \DateTime("now");

        # Recuperando todos os alunos
        $arrayAlunos   = collect($this->repository->all());
        $lastIncricao  = $arrayAlunos->max('matricula');

        # Verificando se o vestibular possui vestibulando
        if(!$lastIncricao) {
            return $now->format('Y') . '0001';
        }

        # Recuperando a ultima inscrição do vestibular, algoritmo de incremento
        # para nova inscrição
        $lastIncricao = (int) (substr($lastIncricao, -4));
        $newInscricao = str_pad(($lastIncricao + 1), 4, "0", STR_PAD_LEFT) ;

        # retorno
        return $now->format('Y') . $newInscricao;
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
}