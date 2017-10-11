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
use Seracademico\Repositories\InstituicaoRepository;
use Seracademico\Repositories\ProfissaoRepository;
use Seracademico\Repositories\SituacaoAlunoRepositoryEloquent;

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
     * @var InstituicaoRepository
     */
    private $instituicaoRepository;

    /**
     * @var string
     */
    private $destinationPath = "images/";

    /**
     * @var CurriculoRepository
     */
    private $curriculoRepository;

    /**
     * @var ProfissaoRepository
     */
    private $profissaoRepository;

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
        CurriculoRepository $curriculoRepository,
        InstituicaoRepository $instituicaoRepository,
        ProfissaoRepository $profissaoRepository)
    {
        $this->repository         = $repository;
        $this->enderecoRepository = $enderecoRepository;
        $this->pessoaRepository   = $pessoaRepository;
        $this->situacaoRepository = $situacaoRepository;
        $this->curriculoRepository = $curriculoRepository;
        $this->instituicaoRepository = $instituicaoRepository;
        $this->profissaoRepository = $profissaoRepository;
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
            'pessoa.instituicaoEscolar',
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
     * @param $dados
     * @author felipe
     * @description
     * Metodo responsavel por remover possiveis espaços em branco nos formularios de cadastro e edição de alunos.
     * ATENÇÃO: Se estiver dando problema na senha de login do portal, verificar se este metodo esta modificando de
     * alguma forma a integridade da senha inserida pelo usuário.
     */
    public function remocaoEspacos($dados)
    {
        #variavel de uso
        $data = [];

        #separando dados da matriz
        $arrayPessoa   = $dados['pessoa'];
        $arrayPessoas  = $dados['pessoas'];
        $arrayEndereco = $dados['pessoa']['endereco'];

        #removendo-os da matriz
        unset($arrayPessoa['endereco']);
        unset($dados['pessoa']);
        unset($dados['pessoas']);

        #removendo espaços em branco
        $data = array_map('trim', $dados);
        $data['pessoa'] = array_map('trim', $arrayPessoa);
        $data['pessoas'] = array_map('trim', $arrayPessoas);
        $data['pessoa']['endereco'] = array_map('trim', $arrayEndereco);

        return $data;
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

        $this->tratamentoCampos($data);
        $arrayMatricula = $this->tratamentoMatricula($data);
        $data = $this->remocaoEspacos($data);
        $this->loginPortalAluno($data, $arrayMatricula['matricula']);

        # Recuperando a pessoa pelo cpf
        $objPessoa = [];
        $endereco  = null;

        # Validando o cpf
        if($data['pessoa']['cpf']) {
            $objPessoa = $this->pessoaRepository->with('endereco.bairro.cidade.estado')
                ->findWhere(['cpf' => $data['pessoa']['cpf']]);
        }

        # Verificando se a pessoa já existe
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

        $this->tratamentoCurso($data, $pessoa);

        #setando as chaves estrageiras
        $data['pessoa_id'] = $pessoa->id;
        $data['primeiro_acesso'] = 0;

        //encriptando senha
        /*$newPassword = "";*/

        /*if(empty($data['password'])) {
            unset($data['password']);
        } else {
            $newPassword = \bcrypt($data['password']);
        }*/

        //inserindo senha encriptada no array principal
        /*$data['password'] = $newPassword; */

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

            # Verificando se a turma foi informada
            if($data['turma_id']) {
                # Recuperando o ultimo registro e vinculando a turma ao curso
                $aluno->curriculos()->get()->last()->pivot->turmas()->attach($data['turma_id']);

                # Recuperando o ultimo registro e vinculando a situação
                $aluno->curriculos()->get()->last()->pivot->situacoes()->attach(1, [
                    'turma_origem_id' => $data['turma_id'] ?? null
                ]);

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

        //encriptando senha
        //$newPassword = "";

        /*if(empty($data['password'])) {
            unset($data['password']);
        } else {
            $newPassword = \bcrypt($data['password']);
        }*/

        //inserindo senha encriptada no array principal
        //$data['password'] = $newPassword;

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

        if(!$aluno->matricula) {
            $arrayMatricula = $this->tratamentoMatricula($data);
            $this->loginPortalAluno($data, $arrayMatricula['matricula']);
            $aluno->matricula = $arrayMatricula['matricula'];
            $aluno->save();
        } else {
            $this->loginPortalAluno($data, $aluno->matricula);
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
            if(isset($data['turma_id'])) {
                # Regra de negócio para tratamento da turma em caso de atualização
                $this->tratamentoTurmaUpdate($aluno, !empty($data['turma_id']) ? $data['turma_id'] : null);
            }
        }

        #Retorno
        return $aluno;
    }

    /**
     * @param $key
     * @param $value
     * @return mixed
     * @throws \Exception
     */
    public function search($key, $value)
    {
        # Joins
        $relacionamentos = [
            'instituicaoEscolar',
            'endereco.bairro.cidade.estado',
        ];

        # Fazendo a consulta
        $aluno = $this->pessoaRepository->with($relacionamentos)->findWhere([ $key =>$value ]);

        # Verificando o se o vestibulando foi recuperado
        if(count($aluno) == 0) {
            throw new \Exception("Dados não encontrados");
        }

        # Retorno
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
        $aluno->curriculos()->find($idCurriculo)->pivot->situacoes()->attach(1, [
            'turma_origem_id' => count($aluno->curriculos()->get()->last()->pivot->turmas) > 0
                ? $aluno->curriculos()->get()->last()->pivot->turmas->last()->id
                : null
        ]);
    }

    /**
     * @param $aluno
     * @param $idTurma
     * @return bool
     * @throws \Exception
     */
    public function tratamentoTurmaUpdate($aluno, $idTurma)
    {
        # Recuperando o currículo do aluno
        $curriculo = $aluno->curriculos()->get()->last();
        $turmas    = $curriculo->pivot->turmas()->get();

        # Verificando se existe turma cadastada
        if(count($turmas) > 0 && $turmas->last()->id != $idTurma) {
            # Recuperando o pivot da turma
            $alunoTurma  = $turmas->last()->pivot;
            $lastTurmaId = $alunoTurma->turma_id;

            # Filtrando se a turma está em andamento
            $emAndamento = $turmas->last()->pivot->notas()->get()->filter(function ($nota) {
                return in_array($nota->situacao_nota_id, [1,2,6,7]) && is_numeric($nota->nota_final);
            });

            # Verificando se a turma já está em andamento
            if(count($emAndamento) > 0) {
                throw new \Exception('Turma não pode ser alterada, pois já está em andamento!');
            }

            # remover as frequências
            $turmas->last()->pivot->notas()->get()->each(function ($nota) {
                # removendo as frequências
                $nota->frequencias()->delete();

                # retorno
                return false;
            });

            # Removendo as notas
            $turmas->last()->pivot->notas()->delete();

            # Atualizando a turma no pivot
            $curriculo->pivot->turmas()->updateExistingPivot($alunoTurma->turma_id, ['turma_id' => $idTurma]);
            
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

            # Tratamento das notas do aluno
            $this->tratamentoNotas($aluno);

        } else if(count($turmas) == 0) {
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
        }

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
     * @param $pessoa
     * @return bool
     * @throws \Exception
     */
    public function tratamentoCurso(array &$data, $pessoa = "")
    {
        if(!empty($pessoa)
            && $this->repository->verificaCursoAtivoEmOutroCadastro($data['curso_id'], $pessoa)) {
            throw new \Exception("Existe para esse aluno um outro cadastro com o mesmo curso ativo");
        }

        # recuperando o currículo
        $curriculo = Curriculo::byCurso($data['curso_id']);

        # Verificando se o currículo foi encontrado
        if(!$curriculo || count($curriculo) == 0) {
            throw new \Exception('Curso informado não possui currículo ativo!');
        }

        # tratando o array
        unset($data['curso_id']);
        $data['curriculo_id'] = $curriculo[0]->id;

        # retorno
        return true;
    }

    /**
     * @param $data
     * @param $numeroMatricula
     */
    public function loginPortalAluno(&$data, $numeroMatricula)
    {
        #tratando a senha
        $data['password'] = \bcrypt($numeroMatricula);

        #setando número de matricula como login do portal do aluno
        $data['login'] = $numeroMatricula;
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
                    if(is_array($value2)) {
                        foreach ($value2 as $key3 => $value3) {
                            $explodeKey3 = explode("_", $key3);

                            if ($explodeKey3[count($explodeKey3) -1] == "id" && !$value3 ) {
                                unset($data[$key][$key2][$key3]);
                            }
                        }
                    } else {
                        $explodeKey2 = explode("_", $key2);

                        if ($explodeKey2[count($explodeKey2) -1] == "id" && !$value2 ) {
                            unset($data[$key][$key2]);
                        }
                    }
                }
            }

            $explodeKey = explode("_", $key);

            if ($explodeKey[count($explodeKey) -1] == "id" && !$value ) {
                unset($data[$key]);
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
        # Gerando a matrícula
        $data['matricula'] = $this->gerarMatricula();

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

        # Recuperando o último aluno cadastrado
        $aluno  = $this->repository->orderBy('created_at', 'desc')->first();

        # Recuperando a matrícula
        $lastIncricao = $aluno->matricula;

        # Recuperando o mês
        $numberMonth    = date('m');
        $numberSemestre = $numberMonth >= 8 ? 2 : 1;

        # Verificando se o vestibular possui vestibulando
        if(!$lastIncricao) {
            return $now->format('Y') . $numberSemestre . '0001';
        }

        # Recuperando a ultima inscrição do vestibular, algoritmo de incremento
        # para nova inscrição
        $lastIncricao = (int) (substr($lastIncricao, -4));
        $newInscricao = str_pad(($lastIncricao + 1), 4, "0", STR_PAD_LEFT) ;

        # retorno
        return $now->format('Y') . $numberSemestre . $newInscricao;
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
     * @param $data
     * @return bool
     */
    public function insertValor($data)
    {
        #Salvando registro
        $retorno = $this->profissaoRepository->create($data);

        return true;
    }
}