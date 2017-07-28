<?php

namespace Seracademico\Services\Doutorado;

use Seracademico\Entities\Doutorado\Aluno;
use Seracademico\Entities\Doutorado\AlunoFrequencia;
use Seracademico\Entities\Doutorado\AlunoNota;
use Seracademico\Entities\Doutorado\Curriculo;
use Seracademico\Repositories\Doutorado\AlunoRepository;
use Seracademico\Repositories\EnderecoRepository;
use Seracademico\Repositories\PessoaRepository;
use Seracademico\Services\TraitService;

class AlunoService
{
    use TraitService;

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
     * AlunoService constructor.
     *
     * @param AlunoRepository $repository
     * @param EnderecoRepository $enderecoRepository
     * @param PessoaRepository $pessoaRepository
     */
    public function __construct(AlunoRepository $repository,
                                EnderecoRepository $enderecoRepository,
                                PessoaRepository $pessoaRepository)
    {
        $this->repository         = $repository;
        $this->enderecoRepository = $enderecoRepository;
        $this->pessoaRepository   = $pessoaRepository;
    }

    /**
     * Método responável por retornar o aluno passado pelo o id
     * com todas as suas dependências.
     *
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
            'pessoa.cursoSuperior',
            'curriculos'
        ];

        # Recuperando o registor do aluno
        $aluno = $this->repository->with($relacionamentos)->find($id);

        #Verificando se o registro foi encontrado
        if(!$aluno) {
            throw new \Exception('Aluno não encontrado!');
        }

        #retorno
        return $aluno;
    }

    /**
     * Método responsável por salvar o aluno
     *
     * @param array $data
     * @return Aluno
     * @throws \Exception
     */
    public function store(array $data) : Aluno
    {
        #regras de negócios pre cadastro
        $this->tratamentoCampos($data);
        $this->tratamentoDePessoaEEndereco($data);
        $arrayMatricula = $this->tratamentoMatricula($data);
        $this->tratamentoCurso($data);
        $data = $this->remocaoEspacos($data);
        $this->loginPortalAluno($data, $arrayMatricula['matricula']);

        # Setando o tipo o tipo do aluno para doutorado
        $data['tipo_aluno_id'] = 4;

        #Salvando o registro pincipal
        $aluno =  $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$aluno) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        # Regras de negócios pós cadastro
        $this->tratamentoImagem($data, $aluno);

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
     * @param $data
     * @param $numeroMatricula
     */
    public function loginPortalAluno(&$data, $numeroMatricula)
    {
        //tratamento de senha
        $newPassword = "";

        if(empty($data['password'])) {
            unset($data['password']);
        } else {
            $newPassword = \bcrypt($data['password']);
        }

        //inserindo senha encriptada no array principal
        $data['password'] = $newPassword;

        //setando número de matricula como login do portal do aluno
        $data['login'] = $numeroMatricula;
    }

    /**
     * Método reponsável por atualizar o aluno.
     *
     * @param array $data
     * @param int $id
     * @return Aluno
     * @throws \Exception
     */
    public function update(array $data, int $id) : Aluno
    {
        # Regras de negócios pre edição
        $this->tratamentoCampos($data);
        $this->tratamentoDePessoaEEndereco($data);
        $this->tratamentoCurso($data);

        //encriptando senha
        $newPassword = "";

        if(empty($data['password'])) {
            unset($data['password']);
        } else {
            $newPassword = \bcrypt($data['password']);
        }

        //inserindo senha encriptada no array principal
        $data['password'] = $newPassword;

        #Atualizando no banco de dados
        $aluno = $this->repository->update($data, $id);

        #Verificando se foi atualizado no banco de dados
        if(!$aluno) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        # Regras de negócios pós edição
        $this->tratamentoImagem($data, $aluno);

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
     * Método responsável por gerenciar os cadastros e edições das
     * entidades de pessoa e endereço do aluno.
     *
     * @param $data
     */
    public function tratamentoDePessoaEEndereco(&$data)
    {
        # Recuperando a pessoa pelo cpf
        $endereco = null;
        $objPessoa = null;
        $resultPessoa = [];

        # Verificando se o cpf foi informado
        if($data['pessoa']['cpf']) {
            $resultPessoa = $this->pessoaRepository->with('endereco.bairro.cidade.estado')
                ->findWhere(['cpf' => $data['pessoa']['cpf']]);
        }

        # Verificando se a pesso já existe
        if(count($resultPessoa) > 0) {
            #aAlterando a o registro de pessoa e recuperando o registro
            $objPessoa = $this->pessoaRepository->update($data['pessoa'], $resultPessoa[0]->id);

            # Alterando o registor de endereço
            $this->enderecoRepository->update($data['pessoa']['endereco'], $objPessoa->endereco->id);
        } else {
            #Criando o registro de endereço
            $endereco = $this->enderecoRepository->create($data['pessoa']['endereco']);

            # setando a chave estrangeira de endereço em pessoa
            $data['pessoa']['enderecos_id'] = $endereco->id;

            # Criando o registro de pessoa e retornando o registro
            $objPessoa  = $this->pessoaRepository->create($data['pessoa']);
        }

        #setando as chaves estrageiras
        $data['pessoa_id'] = $objPessoa->id;
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
}