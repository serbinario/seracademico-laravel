<?php

namespace Seracademico\Services\Graduacao;

use Carbon\Carbon;
use Seracademico\Entities\Graduacao\Curriculo;
use Seracademico\Entities\Graduacao\Vestibulando;
use Seracademico\Entities\Graduacao\VestibulandoFinanceiro;
use Seracademico\Entities\Graduacao\VestibulandoNotaVestibular;
use Seracademico\Repositories\EnderecoRepository;
use Seracademico\Repositories\Financeiro\ContaBancariaRepository;
use Seracademico\Repositories\Graduacao\AlunoRepository;
use Seracademico\Repositories\Graduacao\VestibulandoFinanceiroRepository;
use Seracademico\Repositories\Graduacao\VestibulandoNotaVestibularRepository;
use Seracademico\Repositories\Graduacao\VestibulandoRepository;
use Seracademico\Repositories\Graduacao\VestibularRepository;
use Seracademico\Repositories\PessoaRepository;
use Seracademico\Repositories\Graduacao\VestibulandoDocumentoRepository;
use Seracademico\Facades\ParametroMatriculaFacade;
use Seracademico\Services\Financeiro\DebitoService;
use Seracademico\Services\TraitService;

class VestibulandoService
{
    use TraitService;

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
    private $vestibulandoDocumentoRepository;

    /**
     * @var string
     */
    private $destinationPath = "images/";

    /**
     * @var AlunoService
     */
    private $alunoService;
    /**
     * @var DebitoService
     */
    private $debitoService;

    /**
     * @var ContaBancariaRepository
     */
    private $contaBancariaRepository;

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
     * @param AlunoService $alunoService
     */
    public function __construct(
        PessoaRepository $pessoaRepository,
        VestibulandoRepository $repository,
        EnderecoRepository $enderecoRepository,
        VestibularRepository $vestibularRepository,
        VestibulandoNotaVestibularRepository $notaRepository,
        AlunoRepository $alunoRepository,
        AlunoService $alunoService,
        DebitoService $debitoService,
        VestibulandoDocumentoRepository $vestibulandoDocumentoRepository,
        ContaBancariaRepository $contaBancariaRepository)
    {
        $this->repository = $repository;
        $this->pessoaRepository = $pessoaRepository;
        $this->enderecoRepository = $enderecoRepository;
        $this->vestibularRepository = $vestibularRepository;
        $this->notaRepository = $notaRepository;
        $this->alunoRepository = $alunoRepository;
        $this->alunoService = $alunoService;
        $this->debitoService = $debitoService;
        $this->vestibulandoDocumentoRepository = $vestibulandoDocumentoRepository;
        $this->contaBancariaRepository = $contaBancariaRepository;
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
            'aluno',
            'agendamento'
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
        $imgCam = isset($data['cod_img']) ? $data['cod_img'] : "";
        $img    = isset($data['img']) ? $data['img'] : "";

        # Regras de negócios
        $this->tratamentoCampos($data);
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
        $data['pessoa']['nome'] = mb_strtoupper($data['pessoa']['nome']);
        if(count($objPessoa) > 0) {
            #aAlterando a pessoa e o endereço
            $this->pessoaRepository->update($data['pessoa'], $objPessoa[0]->id);
            $endereco = $this->enderecoRepository->update($data['pessoa']['endereco'], $objPessoa[0]->endereco->id);
            $pessoa = $objPessoa[0];
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

        //Validando se a imagem vem da webcam ou não, e salvando no banco
        if($imgCam && !$img) {
            $pdo = \DB::connection()->getPdo();
            $query = "UPDATE fac_vestibulandos SET path_image = '{$imgCam}', tipo_img = 2 where id = {$vestibulando->id} ";
            $pdo->query($query);
        } else if ($img && !$imgCam) {
            $this->insertImg($vestibulando->id, 1);
        } else if ($imgCam && $img) {
            $pdo = \DB::connection()->getPdo();
            $query = "UPDATE fac_vestibulandos SET path_image = '{$imgCam}', tipo_img = 2 where id = {$vestibulando->id} ";
            $pdo->query($query);
        }

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
        #variavel de uso
        $endereco = '';

        $imgCam = isset($data['cod_img']) ? $data['cod_img'] : "";
        $img    = isset($data['img']) ? $data['img'] : "";

        # Recuperando o vestibulando
        $vestibulando = $this->repository->find($id);

        //Validando se a imagem vem da webcam ou não, e salvando no banco
        if($imgCam && !$img) {
            $pdo = \DB::connection()->getPdo();
            $query = "UPDATE fac_vestibulandos SET path_image = '{$imgCam}', tipo_img = 2 where id = {$id} ";
            $pdo->query($query);
        } else if ($img && !$imgCam) {
            $this->insertImg($vestibulando->id, 1);
        } else if ($imgCam && $img) {
            $pdo = \DB::connection()->getPdo();
            $query = "UPDATE fac_vestibulandos SET path_image = '{$imgCam}', tipo_img = 2 where id = {$id} ";
            $pdo->query($query);
        }

        # Regras de negócios
        $this->tratamentoCampos($data);
        //$this->tratamentoInscricao($data, $id); // [RFV003-RN004]
        $this->tratamentoMediaEnem($data);
        $this->tratamentoMediaFicha($data);

        //só será executado se o vestibulando veio por meio do portal do vestibulando
        if(isset($data['documentos'])) {
            $this->salvarDocumentos($data['documentos']);
        }

        #Atualizando no banco de dados
        $data['pessoa']['nome'] = mb_strtoupper($data['pessoa']['nome']);
        $vestibulando = $this->repository->update($data, $id);
        $pessoa       = $this->pessoaRepository->update($data['pessoa'], $vestibulando->pessoa->id);

        /*
         * Atualiza endereço somente se já existir
         */
        if(isset($pessoa->endereco)){
            $endereco = $this->enderecoRepository->update($data['pessoa']['endereco'], $pessoa->endereco->id);
        }

        /*
         * Condição de atualização (criação) quando o vestibulando foi cadastrado pela interface pública de cadastro de vestibulandos.
         * Isso ocorre pois, quando é feito o cadastro, não é possível cadastrar um endereço até que o próprio vestibulando
         * faça isso após o seu primeiro login.
         * A primeira linha cria o registro
         * A segunda vincula com pessoa
        */
        $endereco = $this->enderecoRepository->create($data['pessoa']['endereco']);
        $this->pessoaRepository->update(['enderecos_id' => $endereco->id], $pessoa->id);

        #Verificando se foi atualizado no banco de dados
        if(!$vestibulando || !$endereco || !$pessoa) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $vestibulando;
    }

    /**
     * @param $documentos
     * @description Este metodo tem a função de receber o array com os documentos e o id de seus respectivos registros
     * na base de dados.Sua principal função é ornganizar e salvar o estado atual de cada documento, se existe ou não alguma
     * observação referente a ele, status, se confirma a entrega ou não, e estado, se aceito ou não.
     */
    private function salvarDocumentos(array $documentos)
    {
        foreach ($documentos as $key => $value) {
            $chaveArray = explode('_', $key);

            if(count($chaveArray) == 2) {
                $documento = $this->vestibulandoDocumentoRepository->find($chaveArray[1]);

                /**
                 * status entrega, caso o operador rejeite o documento, seu estado passa a ser "aguardando reenvio" e
                 * confirmacao passa a ficar aguardando nova alteração, aparecendo em branco para o operador
                 **/
                if($chaveArray[0] == 'confirmacao' && $value == 2) {
                    $documento->documento_estado_id = 3;
                    //$documento->confirmacao = null;
                } else {
                    $documento->documento_estado_id = 4;
                }

                $documento->{$chaveArray[0]} = $value;
                $documento->save();
            }
        }
    }

    /**
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public function delete(int $id)
    {
        #deletando o vstibulando
        $vestibulando = $this->repository->find($id);

        \DB::table('vest_documentos')->where('vestibulando_id', $id)->delete();
        \DB::table('fin_boletos_vestibulandos')->where('vestibulando_id', $id)->delete();
        \DB::table('fac_vestibulandos_financeiros')->where('vestibulando_id', $id)->delete();
        \DB::table('fac_vestibulandos_notas_vestibulares')->where('vestibulando_id', $id)->delete();

        #deletando o vstibulando
        $result = $this->repository->delete($id);

        $pessoa = \DB::table('pessoas')->where('id', $vestibulando->pessoa_id)->select()->first();

        \DB::table('pessoas')->where('id', $pessoa->id)->delete();
        \DB::table('enderecos')->where('id', $pessoa->enderecos_id)->delete();

        // Deletando o registro de contato do vestibulando
        if ($vestibulando->contato_id) {
            $contato = \DB::table('pessoas')->where('id', $vestibulando->contato_id)->select()->first();

            \DB::table('pessoas')->where('id', $contato->id)->delete();
        }

        # Verificando se a execução foi bem sucessida
        if(!$result) {
            throw new \Exception('Ocorreu um erro ao tentar remover o responsável!');
        }

        #retorno
        return true;
    }

    /**
     * @param $id
     */
    public function insertImg($id, $tipo)
    {
        #tratando a imagem
        if(isset($_FILES['img']['tmp_name']) && $_FILES['img']['tmp_name'] != null) {
            $tmpName = $_FILES['img']['tmp_name'];
            $fp = fopen($tmpName, 'r');
            $add = fread($fp, filesize($tmpName));
            $add = addslashes($add);
            fclose($fp);
            $pdo = \DB::connection()->getPdo();
            $query = "UPDATE fac_vestibulandos SET path_image = '{$add}', tipo_img = {$tipo} where id =  $id ";
            $pdo->query($query);
        }

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
//    public function tratamentoInscricao(array &$data, $id = "") : array
//    {
//        # Variáveis
//        $idVestibular = 0;
//
//        # Validando o parâmetro
//        if(isset($data['gerar_inscricao']) && $data['gerar_inscricao'] == 1) {
//            # Verificando se o id foi passado
//            if($id) {
//                # Recuperando o vestibulando e o id do vestibular
//                $vestibulando = $this->repository->find($id);
//                $idVestibular = $vestibulando->vestibular->id;
//
//                # Query para recuperar o débito de inscrição do vestibulando
//                $row = \DB::table('fac_vestibulandos')
//                    ->join('fac_vestibulandos_financeiros', 'fac_vestibulandos_financeiros.vestibulando_id', '=', 'fac_vestibulandos.id')
//                    ->join('fin_taxas', 'fin_taxas.id', '=', 'fac_vestibulandos_financeiros.taxa_id')
//                    ->join('fin_tipos_taxas', 'fin_tipos_taxas.id', '=', 'fin_taxas.tipo_taxa_id')
//                    ->where('fin_tipos_taxas.id', 1)
//                    ->where('fac_vestibulandos_financeiros.pago', 1)
//                    ->where('fac_vestibulandos.id', $vestibulando->id)
//                    ->get();
//
//                # Verificando se o débito de inscrição for pago
//                if(count($row) == 0) {
//                    # Exception
//                    throw new \Exception('Dados informados cadastrados, porem só poderá ser gerado a inscrição se o debito do vestibular for pago.');
//                }
//
//                # Veriicando se o vetibulando já tem inscrição gerada
//                if($vestibulando->gerar_inscricao == 1) {
//                    unset($data['gerar_inscricao']);
//                    return $data;
//                }
//            }
////            else {
////                $idVestibular = $data['vestibular_id'];
////            }
//
//            # Gerando a inscrição
//            $data['inscricao'] = $this->gerarInscricao($idVestibular);
//        }
//
//        # retorno
//        return $data;
//    }

    /**
     * Método Responsável por gerar o número de inscrição
     * se por acaso o débito do vestibular for págo
     *
     * @param VestibulandoFinanceiro $vestibulandoFinanceiro
     * @param Vestibulando $vestibulando
     * @return bool
     */
    public function tratamentoInscricao(VestibulandoFinanceiro $vestibulandoFinanceiro, Vestibulando $vestibulando)
    {
        # Verificando se a taxa foi informada, e se o débito foi págo
        if(isset($vestibulandoFinanceiro->taxa->id) && $vestibulandoFinanceiro->pago && !$vestibulando->inscricao) {
            $query = \DB::table('fin_taxas')
                ->join('fin_tipos_taxas', 'fin_tipos_taxas.id', '=', 'fin_taxas.tipo_taxa_id')
                ->where('fin_taxas.id', $vestibulandoFinanceiro->taxa->id)
                ->where('fin_tipos_taxas.id', 1)
                ->get();

            # Verificanado se houve retorno
            if(count($query) > 0) {
                $vestibulando->inscricao = $this->gerarInscricao($vestibulando->vestibular->id);
                $vestibulando->save();
            }

            # Retorno
            return true;
        }

        # Retorno
        return false;
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
        $materias = \DB::table('fac_materias')
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
     * [RFV003-RN003] - Documento de Requisitos
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
        $this->debitoService->store($vestibulando, $this->formatDebitoInscricao($vestibulando));
        return true;
    }

    /**
     * @param Vestibulando $vestibulando
     * @return mixed
     */
    public function formatDebitoInscricao(Vestibulando $vestibulando, $addDiasVencimento = "")
    {
        $vestibular = $vestibulando->vestibular;
        $taxaVestibular = $vestibular->taxa;
        $contaBancaria = $this->contaBancariaRepository->getContaBancariaPadrao();

        $now = new Carbon();

        if (is_numeric($addDiasVencimento)) {
            $now->addDays($addDiasVencimento);
        } else {
            $now->day($taxaVestibular->dia_vencimento);
        }

        $dados['data_vencimento'] = $now->format('d/m/Y');
        $dados['mes_referencia'] = $now->format('m');
        $dados['ano_referencia'] = $now->format('Y');
        $dados['taxa_id'] = $taxaVestibular->id;
        $dados['valor_debito'] = $taxaVestibular->valor;
        $dados['conta_bancaria_id'] = $contaBancaria->id;
        $dados['pago'] = 0;

        return $dados;
    }

    /**
     * Método tratamentoMediaEnem
     *
     * [RFV003-RN014] - Documento de Requisitos
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

        # Inicializacao de variaveis
        $notas = array();
        $mediaEnem = 0;

        # Testando se foram inseridos registros com valor 0 (zero)
        if ($notaHumanas > 0){
            $notas[] = $notaHumanas;
        }

        if ($notaNatureza > 0){
            $notas[] = $notaNatureza;
        }

        if ($notaMatematica > 0){
            $notas[] = $notaMatematica;
        }

        if ($notaLinguagem > 0){
            $notas[] = $notaLinguagem;
        }

        # Contangem de registros diferentes de 0 (zero)
        $divisor = count($notas);

        # Obtendo a media
        # Testando se os campos foram preenchidos
        # array_sum() soma os elementos de um array
        if($divisor){
            $mediaEnem = (((array_sum($notas))/$divisor) + $notaRedacao);
        }

        # Calculando a média - Andrey
        //$mediaEnem      =  ((($notaHumanas + $notaNatureza + $notaMatematica + $notaLinguagem)/4) + $notaRedacao) / 2;

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
        //$semestreVigente = ParametroMatriculaFacade::getSemestreVigente();

        # variável que armazenará a mensagem de retorno
        //$mensagem = "";

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
            $dados['matricula']       = $this->alunoService->gerarMatricula();
            $dados['vestibulando_id'] = $vestibulando->id;

            # Transferindo para aluno
            $aluno = $this->alunoRepository->create($dados);
            
            # matriculando o aluno
            # Regra de negócio para o semestre
            $aluno->semestres()->attach($dados['semestre_id']);

            #Adicionando o currículo ao aluno
            $aluno->curriculos()->attach($curriculo[0]->id);

            # cadastrando a situação
            $aluno->semestres()->find($dados['semestre_id'])->pivot->situacoes()
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
     * @param $vestibulando
     * @param $comprovante
     * @return bool
     */
    public function deleteFile($vestibulando, $comprovante)
    {
        # Removendo o arquivo do diretório
        unlink(__DIR__ . "/../../../public/" . $this->destinationPath . $vestibulando->$comprovante);

        # Removendo o arquivo do banco de dados
        $vestibulando->$comprovante = null;
        $vestibulando->save();
        
        # Retorno
        return true;
    }
}