<?php

namespace Seracademico\Services\Emais;

use Carbon\Carbon;
use Seracademico\Entities\Emais\Aluno;
use Seracademico\Repositories\Emais\AlunoRepository;
use Seracademico\Repositories\EnderecoRepository;
use Seracademico\Repositories\Financeiro\ContaBancariaRepository;
use Seracademico\Repositories\Financeiro\TaxaRepository;
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
     * @var TaxaRepository
     */
    private $taxaRepository;

    /**
     * @var ContaBancariaRepository
     */
    private $contaBancariaRepository;

    /**
     * AlunoService constructor.
     * @param AlunoRepository $repository
     * @param EnderecoRepository $enderecoRepository
     * @param PessoaRepository $pessoaRepository
     * @param TaxaRepository $taxaRepository
     * @param ContaBancariaRepository $contaBancariaRepository
     */
    public function __construct(
        AlunoRepository $repository,
        EnderecoRepository $enderecoRepository,
        PessoaRepository $pessoaRepository,
        TaxaRepository $taxaRepository,
        ContaBancariaRepository $contaBancariaRepository)
    {
        $this->repository         = $repository;
        $this->enderecoRepository = $enderecoRepository;
        $this->pessoaRepository   = $pessoaRepository;
        $this->taxaRepository = $taxaRepository;
        $this->contaBancariaRepository = $contaBancariaRepository;
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
            'pessoa.sexo',
            'modalidades',
            'materias'
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
        //dd($data);
        #regras de negócios pre cadastro
        $this->tratamentoCampos($data);
        $this->tratamentoDePessoaEEndereco($data);

        #Salvando o registro pincipal
        $aluno =  $this->repository->create($data);

        // Adicionar modalidade do aluno
        if(isset($data['pre_modalidade_id']) && count($data['pre_modalidade_id']) > 0){
            $aluno->modalidades()->attach($data['pre_modalidade_id']);
        }

        // Adicionar materias do aluno
        if(isset($data['pre_materia_id']) && count($data['pre_materia_id']) > 0){
            $aluno->materias()->attach($data['pre_materia_id']);
        }

        #Verificando se foi criado no banco de dados
        if(!$aluno) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }
        
        #Retorno
        return $aluno;
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

        #Atualizando no banco de dados
        $aluno = $this->repository->update($data, $id);

        // Adicionar modalidade do aluno
        if(isset($data['pre_modalidade_id']) && count($data['pre_modalidade_id']) > 0){
            $aluno->modalidades()->detach();
            $aluno->modalidades()->attach($data['pre_modalidade_id']);
        }

        // Adicionar materias do aluno
        if(isset($data['pre_materia_id']) && count($data['pre_materia_id']) > 0){
            $aluno->materias()->detach();
            $aluno->materias()->attach($data['pre_materia_id']);
        }

        #Verificando se foi atualizado no banco de dados
        if(!$aluno) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
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

            if (isset($objPessoa->endereco->id)) {
                # Alterando o registor de endereço
                $this->enderecoRepository->update($data['pessoa']['endereco'], $objPessoa->endereco->id);
            }

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
     * @param Aluno $aluno
     * @param string $addDiasVencimento
     * @return mixed
     * @throws \Exception
     */
    public function formatDebitoInscricao(Aluno $aluno, $addDiasVencimento = "")
    {
        $taxas = $this->taxaRepository->findWhere(['tipo_nivel_sistema_id' => 6]);

        if (count($taxas) == 0) {
            throw new \Exception('Taxa do inscrição do e+ não foi encontrada');
        }

        $modalidades = $aluno->modalidades;
        $valorDebito = 0;

        $modalidadeEnem = $modalidades->filter(function($item) { return $item->id == 1;})->first();
        $modalidadeIsoladas = $modalidades->filter(function($item) { return $item->id == 2;})->first();

        if ($modalidadeEnem) {
           $valorDebito += $modalidadeEnem->valor;
        }

        if ($modalidadeIsoladas) {
            $materias = $aluno->materias;

            if (count($materias) == 0) {
                throw new \Exception('Nenhuma matéria de isoloada foi encontrada');
            }

            foreach ($materias as $materia) {
                $valorDebito += $materia->valor;
            }
        }

        $taxaInscricao = $taxas->last();
        $contaBancaria = $this->contaBancariaRepository->getContaBancariaPadrao();

        $now = new Carbon();

        if (is_numeric($addDiasVencimento)) {
            $now->addDays($addDiasVencimento);
        } else {
            $now->day($taxaInscricao->dia_vencimento);
        }

        $dados['data_vencimento'] = $now->format('d/m/Y');
        $dados['mes_referencia'] = $now->format('m');
        $dados['ano_referencia'] = $now->format('Y');
        $dados['taxa_id'] = $taxaInscricao->id;
        $dados['valor_debito'] = $valorDebito;
        $dados['conta_bancaria_id'] = $contaBancaria->id;
        $dados['pago'] = 0;

        return $dados;
    }
}