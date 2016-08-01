<?php

namespace Seracademico\Services\Graduacao;

use Seracademico\Entities\Graduacao\Curriculo;
use Seracademico\Entities\Graduacao\Vestibulando;
use Seracademico\Entities\Graduacao\VestibulandoNotaVestibular;
use Seracademico\Repositories\EnderecoRepository;
use Seracademico\Repositories\Graduacao\AlunoRepository;
use Seracademico\Repositories\Graduacao\VestibulandoFinanceiroRepository;
use Seracademico\Repositories\Graduacao\VestibulandoNotaVestibularRepository;
use Seracademico\Repositories\Graduacao\VestibulandoRepository;
use Seracademico\Repositories\Graduacao\VestibularRepository;
use Seracademico\Repositories\PessoaRepository;
use Seracademico\Facades\ParametroMatriculaFacade;

class VestibulandoService
{
    /**
     * @var VestibulandoRepository
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
     * @var VestibulandoNotaVestibularRepository
     */
    private $notaRepository;

    /**
     * @var PessoaRepository
     */
    private $pessoaRepository;

    /**
     * @var AlunoRepository
     */
    private $alunoRepository;

    /**
     * @var VestibulandoFinanceiroRepository
     */
    private $financeiroRepository;

    /**
     * @var string
     */
    private $destinationPath = "images/";

    /**
     * Método Construtor
     *
     * Método responsável por incializar o objeto
     * com as referências necessárias para o seu funcionamento.
     *
     * VestibulandoService constructor.
     * @param PessoaRepository $pessoaRepository
     * @param VestibulandoRepository $repository
     * @param EnderecoRepository $enderecoRepository
     * @param VestibularRepository $vestibularRepository
     * @param VestibulandoNotaVestibularRepository $notaRepository
     * @param AlunoRepository $alunoRepository
     * @param VestibulandoFinanceiroRepository $financeiroRepository
     */
    public function __construct(
        PessoaRepository $pessoaRepository,
        VestibulandoRepository $repository,
        EnderecoRepository $enderecoRepository,
        VestibularRepository $vestibularRepository,
        VestibulandoNotaVestibularRepository $notaRepository,
        AlunoRepository $alunoRepository,
        VestibulandoFinanceiroRepository $financeiroRepository)
    {
        $this->repository           = $repository;
        $this->pessoaRepository     = $pessoaRepository;
        $this->enderecoRepository   = $enderecoRepository;
        $this->vestibularRepository = $vestibularRepository;
        $this->notaRepository       = $notaRepository;
        $this->alunoRepository      = $alunoRepository;
        $this->financeiroRepository = $financeiroRepository;
    }

    /**
     * Método find
     *
     * Método responsável por recupear uma instância específica(id)
     * do vestibulando com todas as suas dependências.
     *
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function find($id)
    {
        #Recuperando o registro no banco de dados
        $relacionamentos = [
            'pessoa.instituicaoEscolar',
            'pessoa.endereco.bairro.cidade.estado',
            'pessoa.estadoCivil',
            'pessoa.sexo',
            'pessoa.turno',
            'pessoa.grauInstrucao',
            'pessoa.profissao',
            'pessoa.corRaca',
            'pessoa.ufNascimento',
            'vestibular.semestre',
            'aluno'
        ];

        $vestibulando = $this->repository->with($relacionamentos)->find($id);

        #Verificando se o registro foi encontrado
        if(!$vestibulando) {
            throw new \Exception('Vestibulando não encontrado!');
        }

        #retorno
        return $vestibulando;
    }


    /**
     * Método store
     *
     * Método responsável por tratar os dados recebidos pelo array
     * passado por parâmetro, e persistir os dados no banco de dados.
     *
     * @param array $data
     * @return Vestibulando
     * @throws \Exception
     */
    public function store(array $data) : Vestibulando
    {
        # Regras de negócios
        $this->tratamentoCampos($data);
        $this->tratamentoImagem($data);
        $this->tratamentoMediaEnem($data);
        $this->tratamentoMediaFicha($data);

        # Recuperando a pessoa pelo cpf
        $objPessoa = $this->pessoaRepository->with('endereco.bairro.cidade.estado')->findWhere(['cpf' => $data['pessoa']['cpf']]);
        $endereco  = null;

        # [RFV003-RN010] - Documento de Requisitos
        # Query para verificação se a pessoa já está cadastrada para o vestibular
        $row = \DB::table('fac_vestibulandos')
            ->join('fac_vestibulares', 'fac_vestibulares.id', '=', 'fac_vestibulandos.vestibular_id')
            ->join('pessoas', 'pessoas.id', '=', 'fac_vestibulandos.pessoa_id')
            ->where('fac_vestibulares.id', $data['vestibular_id'])
            ->where('pessoas.cpf', $data['pessoa']['cpf'])
            ->get();

        # Veriicando se a pessoa já está cadastrada para o vestibular
        if(count($row) > 0) {
            throw new \Exception('Pessoa já cadastrada para esse vestibular.');
        }

        # [RFV003-RN012] - Documento de Requisitos
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
            $pessoa   = $this->pessoaRepository->create($data['pessoa']);
        }

        #setando as chaves estrageiras
        $data['pessoa_id'] = $pessoa->id;

        #Salvando o registro pincipal
        $vestibulando =  $this->repository->create($data);

        #Verificando se foi criado no banco de dados
        if(!$vestibulando) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        # Regras de negócios
        $this->tratamentoVestibular($vestibulando);
        $this->tratamentoDebitoInscricao($vestibulando); // [RFV003-RN003]

        #Retorno
        return $vestibulando;
    }

    /**
     * Método update
     *
     * Método responsável por tratar os dados recebidos pelo array
     * passado por parâmetro, e persistir os dados no banco de dados.
     *
     * @param array $data
     * @param int $id
     * @return Vestibulando
     * @throws \Exception
     */
    public function update(array $data, int $id) : Vestibulando
    {
        # Recuperando o vestibulando
        $vestibulando = $this->repository->find($id);

        # Regras de negócios
        $this->tratamentoCampos($data);
        $this->tratamentoImagem($data, $vestibulando);
        $this->tratamentoInscricao($data, $id); // [RFV003-RN004]
        $this->tratamentoMediaEnem($data);
        $this->tratamentoMediaFicha($data);


        #Atualizando no banco de dados
        $vestibulando = $this->repository->update($data, $id);
        $pessoa       = $this->pessoaRepository->update($data['pessoa'], $vestibulando->pessoa->id);
        $endereco     = $this->enderecoRepository->update($data['pessoa']['endereco'], $pessoa->endereco->id);

        #Verificando se foi atualizado no banco de dados
        if(!$vestibulando || !$endereco || !$pessoa) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $vestibulando;
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
     * Método tratamentoCampos
     *
     * Método responsável por tratar os campos de chave estrangeira
     * do array passado por parâmentro, onde se não houver valor vinculado
     * ao campo ele irá atribuir null ao mesmo. Isso é necessário, pois quando não
     * escolhido um valor para um campo de chave estrangeira no formulário de cadastro
     * ele vem com uma string vazia "" como valor, e isso ocasiona errors sql.
     *
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
     * Método tratamentoImagem
     *
     * Método que faz o tratamento das imagens enviadas para o cadastro
     * do vestibulando.
     *
     * @param array $data
     * @return array
     */
    public function tratamentoImagem(array &$data, $vestibulando = "")
    {
        #tratando a imagem
        foreach ($data as $key => $value) {
            $explode = explode("_", $key);
            
            if (count($explode) > 0 && $explode[0] == "path") {
                $file = $data[$key];
                $fileName = md5(uniqid(rand(), true)) . "." . $file->getClientOriginalExtension();

                # Validando a atualização
                if (!empty($vestibulando) && $vestibulando->{$key} != null) {
                    unlink(__DIR__ . "/../../../public/" . $this->destinationPath . $vestibulando->{$key});
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
     * [RFV003-RN004] - Documento de Requisitos
     *
     * Método responsável por gerar o número de inscrição do vestibulando
     * onde o mesmo só poderá ser gerado se a taxa de inscrição(Vestibular)
     * estiver sido paga.
     *
     * @param array $data
     * @param string $id
     * @return array
     * @throws \Exception
     */
    public function tratamentoInscricao(array &$data, $id = "") : array
    {
        # Variáveis
        $idVestibular = 0;

        # Validando o parâmetro
        if(isset($data['gerar_inscricao']) && $data['gerar_inscricao'] == 1) {
            # Verificando se o id foi passado
            if($id) {
                # Recuperando o vestibulando e o id do vestibular
                $vestibulando = $this->repository->find($id);
                $idVestibular = $vestibulando->vestibular->id;

                # Query para recuperar o débito de inscrição do vestibulando
                $row = \DB::table('fac_vestibulandos')
                    ->join('fac_vestibulandos_financeiros', 'fac_vestibulandos_financeiros.vestibulando_id', '=', 'fac_vestibulandos.id')
                    ->join('taxas', 'taxas.id', '=', 'fac_vestibulandos_financeiros.taxa_id')
                    ->join('tipos_taxas', 'tipos_taxas.id', '=', 'taxas.tipo_taxa_id')
                    ->where('tipos_taxas.id', 1)
                    ->where('fac_vestibulandos_financeiros.pago', 1)
                    ->where('fac_vestibulandos.id', $vestibulando->id)
                    ->get();

                # Verificando se o débito de inscrição for pago
                if(count($row) == 0) {                    
                    # Exception
                    throw new \Exception('Dados informados cadastrados, porem só poderá ser gerado a inscrição se o debito do vestibular for pago.');
                }

                # Veriicando se o vetibulando já tem inscrição gerada
                if($vestibulando->gerar_inscricao == 1) {
                    unset($data['gerar_inscricao']);
                    return $data;
                }
            }
//            else {
//                $idVestibular = $data['vestibular_id'];
//            }

            # Gerando a inscrição
            $data['inscricao'] = $this->gerarInscricao($idVestibular);
        }

        # retorno
        return $data;
    }

    /**
     * [RFV003-RN004] - Documento de Requisitos
     *
     * Método responsável por verificar à ultima inscrição do
     * vestibular em questão e gerar uma nova inscrição única
     * para o vestibulando.
     *
     * @return string
     */
    public function gerarInscricao($idVestibular)
    {
        # Recuperando o vestibular
        $objVestibular = $this->vestibularRepository->find($idVestibular);
        $lastIncricao  = $objVestibular->vestibulandos->max('inscricao');

        # Verificando se o vestibular possui vestibulando
        if(!$lastIncricao) {
            return '0001';
        }

        # Recuperando a ultima inscrição do vestibular, algoritmo de incremento
        # para nova inscrição
        $lastIncricao = (int) $lastIncricao;
        $newInscricao = str_pad(($lastIncricao + 1), 4, "0", STR_PAD_LEFT) ;

        # retorno
        return $newInscricao;
    }

    /**
     * Método tratamentoVestibular
     *
     * Método responsável por gerar altomaticamente as notas do vestibular
     * para cada matéria do mesmo.
     *
     * @param Vestibulando $vestibulando
     * @return bool
     * @throws \Exception
     */
    public function tratamentoVestibular(Vestibulando $vestibulando)
    {
        # Verificando o vestibular
        if(!$vestibulando->vestibular) {
            throw new \Exception('Vestibular não existe');
        }

        # Verificando se o vestibulando já possui notas
        if(count($vestibulando->notasVestibular) > 0) {
            return false;
        }

        # Recuperando as matérias
        $idVestibular = $vestibulando->vestibular->id;
        $materias     = \DB::table('fac_materias')
                        ->select('id')
                        ->whereIn('id', function ($query) use ($idVestibular) {
                            $query->from('fac_vestibular_curso_materia')
                                ->distinct()
                                ->select('fac_vestibular_curso_materia.materia_id')
                                ->join('fac_vestibulares_cursos', 'fac_vestibulares_cursos.id', '=', 'fac_vestibular_curso_materia.vestibular_curso_id')
                                ->join('fac_cursos', 'fac_cursos.id', '=', 'fac_vestibulares_cursos.curso_id')
                                ->join('fac_vestibulares', 'fac_vestibulares.id', '=', 'fac_vestibulares_cursos.vestibular_id')
                                ->where('fac_vestibulares.id', $idVestibular)
                                ->get();
                        })->get();

        # Criando as notas dos alunos
        foreach ($materias as $materia) {
            $vestibulando->notasVestibular()->create(['materia_id' => $materia->id]);
        }

        # Retorno
        return true;
    }

    /**
     * [RFV003-RN003] - Documento de Reuisitos
     *
     * Método responsável por recuperar a taxa do vestibular
     * que o vestibulando está se matriculando e gerar automaticamente
     * um débito da inscrição(Vestibular) para o mesmo, que só poderá
     * fazer a prova com o débito págo.
     *
     * @param Vestibulando $vestibulando
     * @return bool
     */
    public function tratamentoDebitoInscricao(Vestibulando $vestibulando)
    {
        # Data atual
        $now = new \DateTime('now');

        # Recuperando o vestibular e a taxa do vestibular
        $vestibular     = $vestibulando->vestibular;
        $taxaVestibular = $vestibular->taxa;

        # criando o array do financeiro
        $dados['vestibulando_id'] = $vestibulando->id;
        $dados['vencimento']      = $now->format('d/m/Y');
        $dados['mes_referencia']  = $now->format('m');
        $dados['ano_referencia']  = $now->format('Y');
        $dados['taxa_id']         = $taxaVestibular->id;

        # Criação do do débito do vestibulando
        $this->financeiroRepository->create($dados);

        # retorno
        return true;
    }

    /**
     * Método tratamentoMediaEnem
     *
     * Método que trata os valores das notas do enem passadas por parâmetro
     * e calcula a média segundo algorítmo de geração de média do enem.
     *
     * @param array $dados
     */
    public function tratamentoMediaEnem(array &$dados)
    {
        # Tratando as notas
        $notaHumanas    = !isset($dados['nota_humanas']) || $dados['nota_humanas'] == "" ? 0.0 :  $dados['nota_humanas'];
        $notaNatureza   = !isset($dados['nota_natureza']) || $dados['nota_natureza'] == "" ? 0.0 :  $dados['nota_natureza'];
        $notaMatematica = !isset($dados['nota_matematica']) || $dados['nota_matematica'] == "" ? 0.0 :  $dados['nota_matematica'];
        $notaLinguagem  = !isset($dados['nota_linguagem']) || $dados['nota_linguagem'] == "" ? 0.0 :  $dados['nota_linguagem'];
        $notaRedacao    = !isset($dados['nota_redacao']) || $dados['nota_redacao'] == "" ? 0.0 :  $dados['nota_redacao'];

        # Calculando a média
        $mediaEnem      =  ((($notaHumanas + $notaNatureza + $notaMatematica + $notaLinguagem)/4) + $notaRedacao) / 2;

        # setando o array para média do enem
        $dados['media_enem'] = $mediaEnem;
    }

    /**
     * Método tratamentoMediaFicha
     *
     * Método que trata os valores das notas da ficha19 passadas por parâmetro
     * e calcula a média segundo algorítmo de geração de média da ficha19.
     *
     * @param array $dados
     */
    public function tratamentoMediaFicha(array &$dados)
    {
        # Variáveis de uso
        $somaNotasFicha = 0.0;
        $mediaFicha     = 0.0;

        # Percorrendo o array
        $count = 0;
        foreach ($dados as $key => $value) {
            # Cortando a string
            $explode = explode('_', $key);

            # Verificando se é nota da ficha
            if(count($explode) == 3 && $explode[0] == 'ficha') {
                # Soma das notas
                $somaNotasFicha  += $value == "" ? 0.0 : (double) $value;

                # Incremento
                $count++;
            }
        }

        # Calculando a média
        $mediaFicha     =  $somaNotasFicha/$count;

        # setando o array para média do enem
        $dados['media_ficha'] = $mediaFicha;
    }

    /**
     * Método findNota
     *
     * Método responsável por recupear uma instância específica(id)
     * da nota com todas as suas dependências.
     *
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
     * Método updateNota
     *
     * Método responsável por tratar os dados recebidos pelo array
     * passado por parâmetro, e persistir os dados no banco de dados.
     *
     * @param array $data
     * @param int $id
     * @return VestibulandoNotaVestibular
     * @throws \Exception
     */
    public function updateNota(array $data, int $id) : VestibulandoNotaVestibular
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
     * Método updateInclusao
     *
     * Método responsável por tratar os dados recebidos pelo array
     * passado por parâmetro, e persistir os dados no banco de dados.
     * Para a primeira solicitação de cadastro, será criado um aluno
     * com vinculo com o vestibulando em questão, onde é concretizada
     * a transferência, a partir da segunda requisição, os dados de transferência
     * serão atualizados.
     *
     * @param $dados
     * @param $idVestibulando
     * @return bool
     * @throws \Exception
     */
    public function updateInclusao($dados, $idVestibulando)
    {
        # Recuperando o semestre vigente
        $semestreVigente = ParametroMatriculaFacade::getSemestreVigente();

        # variável que armazenará a mensagem de retorno
        $mensagem = "";

        # Recuperando o vestibulando e o currículo
        $vestibulando = $this->repository->find($idVestibulando);

        # Verificando se o vestibulando existe
        if(!$vestibulando) {
            throw new \Exception('Vestibulando não existe');
        }

        # Regra de negócio da data
        $dados['data_transferencia'] = new \DateTime('now');

        # Regra de negócio de pessoa
        $dados['pessoa_id'] = $vestibulando->pessoa->id;

        # Verificando se o aluno já foi transferido
        if($vestibulando->aluno) {
            $this->alunoRepository->update($dados, $vestibulando->aluno->id);

            # setando a mensagem
            $mensagem = "Dados de transferência atualizados com sucesso!";
        } else {
            # Verificando se o curso foi passado
            if(!isset($dados['curso_id'])) {
                throw new \Exception('Curso não informado.');
            }

            # recuperando o currúculo
            $curriculo = Curriculo::byCurso($dados['curso_id']);

            # Verificando se o currículo existe
            if(count($curriculo) == 0) {
                throw new \Exception('Currículo não encontrado.');
            }

            # Recuperando a data atual
            $now = new \DateTime('now');

            # Geração da matrícula e vinculo com o vestibulando
            $dados['matricula']       = $now->format('YmdHis');
            $dados['vestibulando_id'] = $vestibulando->id;

            # Transferindo para aluno
            $aluno = $this->alunoRepository->create($dados);
            
            # matriculando o aluno
            # Regra de negócio para o semestre
            $aluno->semestres()->attach($semestreVigente->id);

            #Adicionando o currículo ao aluno
            $aluno->curriculos()->attach($curriculo[0]->id);

            # cadastrando a situação
            $aluno->semestres()->find($semestreVigente->id)->pivot->situacoes()
                ->attach(1, ['data' => $now->format('YmdHis'), 'curriculo_origem_id' => $curriculo[0]->id]);

            # setando a mensagem
            $mensagem = "Transferência realizada com sucesso!";
        }        
        
        #retorno
        return $mensagem;
    }

    /**
     * Método search
     *
     * Método responsável por recupear uma instância específica(id)
     * da pessoa com todas as suas dependências.
     *
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
        $vestibulando = $this->pessoaRepository->with($relacionamentos)->findWhere([ $key =>$value ]);

        # Verificando o se o vestibulando foi recuperado
        if(count($vestibulando) == 0) {
            throw new \Exception("Dados não encontrados");
        }

        # Retorno
        return $vestibulando;
    }

    /**
     * Método storeDebitosAbertos
     *
     * Método responsável por tratar os dados recebidos pelo array
     * passado por parâmetro, e persistir os dados no banco de dados.
     *
     * @param array $dados
     * @return bool
     */
    public function storeDebitosAbertos(array $dados)
    {
        # Regra de negócio para págo
        $dados['pago'] = 0;

        # Cadastrando
        $this->financeiroRepository->create($dados);

        # Retorno
        return true;
    }

    /**
     * Método updateDebitosAbertos
     *
     * Método responsável por tratar os dados recebidos pelo array
     * passado por parâmetro, e persistir os dados no banco de dados.
     *
     * @param array $dados
     * @return bool
     */
    public function updateDebitosAbertos(array $dados, int $id)
    {
            # Cadastrando
        $this->financeiroRepository->update($dados, $id);

        # Retorno
        return true;
    }

    /**
     * Método findDebito
     *
     * Método responsável por recupear uma instância específica(id)
     * do débito com todas as suas dependências.
     *
     * @param int $id
     * @return mixed
     * @throws \Exception
     */
    public function findDebito(int $id)
    {
        #Recuperando o registro no banco de dados
        $relacionamentos = [
            'taxa',
            'taxa.tipoTaxa'
        ];

        $debito = $this->financeiroRepository->with($relacionamentos)->find($id);

        #Verificando se o registro foi encontrado
        if(!$debito) {
            throw new \Exception('Vestibulando não encontrado!');
        }

        #retorno
        return $debito;
    }

    /**
     * Método deleteDebitosAbertos
     *
     * Método responsável por deletar um débito específico(id)
     * do banco de dados.
     *
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public function deleteDebitosAbertos(int $id)
    {
        # Recuperando o débito
        $debito = $this->financeiroRepository->find($id);

        # Verificando se existe
        if(!$debito) {
             throw new \Exception('Débito não encontrado');
         }

        # Transação de remoção
        $this->financeiroRepository->delete($id);

        # retorno
        return true;
    }
}