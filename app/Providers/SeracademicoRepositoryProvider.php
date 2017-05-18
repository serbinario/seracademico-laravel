<?php

namespace Seracademico\Providers;

use Illuminate\Support\ServiceProvider;
use Seracademico\Contracts\Report;
use Seracademico\Uteis\SimpleReport;

class SeracademicoRepositoryProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Report::class, SimpleReport::class);
        
        $this->app->bind(
            \Seracademico\Repositories\Graduacao\VestibulandoRepository::class,
            \Seracademico\Repositories\Graduacao\VestibulandoRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\BairroRepository::class,
            \Seracademico\Repositories\BairroRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\CidadeRepository::class,
            \Seracademico\Repositories\CidadeRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\CorRacaRepository::class,
            \Seracademico\Repositories\CorRacaRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\EnderecoRepository::class,
            \Seracademico\Repositories\EnderecoRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\EstadoCivilRepository::class,
            \Seracademico\Repositories\EstadoCivilRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\EstadoRepository::class,
            \Seracademico\Repositories\EstadoRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\ExameRepository::class,
            \Seracademico\Repositories\ExameRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\GrauInstrucaoRepository ::class,
            \Seracademico\Repositories\GrauInstrucaoRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\InstituicaoMedioRepository::class,
            \Seracademico\Repositories\InstituicaoMedioRepositoryEloquent::class
        );


        $this->app->bind(
            \Seracademico\Repositories\InstituicaoSuperiorRepository::class,
            \Seracademico\Repositories\InstituicaoSuperiorRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\ProfissaoRepository::class,
            \Seracademico\Repositories\ProfissaoRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\ReligiaoRepository::class,
            \Seracademico\Repositories\ReligiaoRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\SexoRepository::class,
            \Seracademico\Repositories\SexoRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\TipoSanguinioRepository::class,
            \Seracademico\Repositories\TipoSanguinioRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\TurnoRepository::class,
            \Seracademico\Repositories\TurnoRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\TipoSanguinioRepository::class,
            \Seracademico\Repositories\TipoSanguinioRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\EmpresaRepository::class,
            \Seracademico\Repositories\EmpresaRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\UserRepository::class,
            \Seracademico\Repositories\UserRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\RoleRepository::class,
            \Seracademico\Repositories\RoleRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\PermissionRepository::class,
            \Seracademico\Repositories\PermissionRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\SalaRepository::class,
            \Seracademico\Repositories\SalaRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\TipoAvaliacaoRepository::class,
            \Seracademico\Repositories\TipoAvaliacaoRepositoryEloquent::class
        );
  
		$this->app->bind(
			\Seracademico\Repositories\TipoDisciplinaRepository::class,
			\Seracademico\Repositories\TipoDisciplinaRepositoryEloquent::class
		);

		$this->app->bind(
			\Seracademico\Repositories\TipoCursoRepository::class,
			\Seracademico\Repositories\TipoCursoRepositoryEloquent::class
		);

		$this->app->bind(
			\Seracademico\Repositories\SedeRepository::class,
			\Seracademico\Repositories\SedeRepositoryEloquent::class
		);
		$this->app->bind(
			\Seracademico\Repositories\DepartamentoRepository::class,
			\Seracademico\Repositories\DepartamentoRepositoryEloquent::class
		);

		$this->app->bind(
			\Seracademico\Repositories\PosGraduacao\DisciplinaRepository::class,
			\Seracademico\Repositories\PosGraduacao\DisciplinaRepositoryEloquent::class
		);

		$this->app->bind(
			\Seracademico\Repositories\PosGraduacao\CursoRepository::class,
			\Seracademico\Repositories\PosGraduacao\CursoRepositoryEloquent::class
		);

		$this->app->bind(
			\Seracademico\Repositories\PosGraduacao\CurriculoRepository::class,
			\Seracademico\Repositories\PosGraduacao\CurriculoRepositoryEloquent::class
		);

		$this->app->bind(
			\Seracademico\Repositories\ProfessorRepository::class,
			\Seracademico\Repositories\ProfessorRepositoryEloquent::class
		);

		$this->app->bind(
			\Seracademico\Repositories\PosGraduacao\TurmaRepository::class,
			\Seracademico\Repositories\PosGraduacao\TurmaRepositoryEloquent::class
		);

        $this->app->bind(
            \Seracademico\Repositories\TipoNivelSistemaRepository::class,
            \Seracademico\Repositories\TipoNivelSistemaRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\PosGraduacao\CalendarioDisciplinaTurmaRepository::class,
            \Seracademico\Repositories\PosGraduacao\CalendarioDisciplinaTurmaRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\SituacaoNotaRepository::class,
            \Seracademico\Repositories\SituacaoNotaRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\SituacaoAlunoRepository::class,
            \Seracademico\Repositories\SituacaoAlunoRepositoryEloquent::class
        );
 
		$this->app->bind(
			\Seracademico\Repositories\NotaRepository::class,
			\Seracademico\Repositories\NotaRepositoryEloquent::class
		);

        $this->app->bind(
            \Seracademico\Repositories\Graduacao\DisciplinaRepository::class,
            \Seracademico\Repositories\Graduacao\DisciplinaRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\Graduacao\CursoRepository::class,
            \Seracademico\Repositories\Graduacao\CursoRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\Graduacao\SemestreRepository::class,
            \Seracademico\Repositories\Graduacao\SemestreRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\Graduacao\TipoPrecoCursoRepository::class,
            \Seracademico\Repositories\Graduacao\TipoPrecoCursoRepositoryEloquent::class);

        $this->app->bind(
            \Seracademico\Repositories\Graduacao\PrecoCursoRepository::class,
            \Seracademico\Repositories\Graduacao\PrecoCursoRepositoryEloquent::class);

        $this->app->bind(
            \Seracademico\Repositories\Graduacao\PrecoDisciplinaCursoRepository::class,
            \Seracademico\Repositories\Graduacao\PrecoDisciplinaCursoRepositoryEloquent::class);

        $this->app->bind(
            \Seracademico\Repositories\Biblioteca\EditoraRepository::class,
            \Seracademico\Repositories\Biblioteca\EditoraRepositoryEloquent::class
        );
        $this->app->bind(
            \Seracademico\Repositories\Biblioteca\ArcevoRepository::class,
            \Seracademico\Repositories\Biblioteca\ArcevoRepositoryEloquent::class
        );
        $this->app->bind(
            \Seracademico\Repositories\Biblioteca\TipoAcervoRepository::class,
            \Seracademico\Repositories\Biblioteca\TipoAcervoRepositoryEloquent::class
        );
        $this->app->bind(
            \Seracademico\Repositories\Biblioteca\TipoAutorRepository::class,
            \Seracademico\Repositories\Biblioteca\TipoAutorRepositoryEloquent::class
        );
        $this->app->bind(
            \Seracademico\Repositories\Biblioteca\SegundaEntradaRepository::class,
            \Seracademico\Repositories\Biblioteca\SegundaEntradaRepositoryEloquent::class
        );
        $this->app->bind(
            \Seracademico\Repositories\Biblioteca\PrimeiraEntradaRepository::class,
            \Seracademico\Repositories\Biblioteca\PrimeiraEntradaRepositoryEloquent::class
        );
        $this->app->bind(
            \Seracademico\Repositories\Biblioteca\ColecaoRepository::class,
            \Seracademico\Repositories\Biblioteca\ColecaoRepositoryEloquent::class
        );
        $this->app->bind(
            \Seracademico\Repositories\Biblioteca\GeneroRepository::class,
            \Seracademico\Repositories\Biblioteca\GeneroRepositoryEloquent::class
        );
        $this->app->bind(
            \Seracademico\Repositories\Biblioteca\CorredorRepository::class,
            \Seracademico\Repositories\Biblioteca\CorredorRepositoryEloquent::class
        );
        $this->app->bind(
            \Seracademico\Repositories\Biblioteca\EstanteRepository::class,
            \Seracademico\Repositories\Biblioteca\EstanteRepositoryEloquent::class
        );
        $this->app->bind(
            \Seracademico\Repositories\Biblioteca\SituacaoRepository::class,
            \Seracademico\Repositories\Biblioteca\SituacaoRepositoryEloquent::class
        );
        $this->app->bind(
            \Seracademico\Repositories\Biblioteca\IdiomaRepository::class,
            \Seracademico\Repositories\Biblioteca\IdiomaRepositoryEloquent::class
        );
        $this->app->bind(
            \Seracademico\Repositories\Biblioteca\AquisicaoRepository::class,
            \Seracademico\Repositories\Biblioteca\AquisicaoRepositoryEloquent::class
        );
        $this->app->bind(
            \Seracademico\Repositories\Biblioteca\IlustracaoRepository::class,
            \Seracademico\Repositories\Biblioteca\IlustracaoRepositoryEloquent::class
        );
        $this->app->bind(
            \Seracademico\Repositories\Biblioteca\EmprestimoRepository::class,
            \Seracademico\Repositories\Biblioteca\EmprestimoRepositoryEloquent::class
        );
        $this->app->bind(
            \Seracademico\Repositories\Biblioteca\ExemplarRepository::class,
            \Seracademico\Repositories\Biblioteca\ExemplarRepositoryEloquent::class
        );
        $this->app->bind(
            \Seracademico\Repositories\Biblioteca\ResponsavelRepository::class,
            \Seracademico\Repositories\Biblioteca\ResponsavelRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\Graduacao\CurriculoRepository::class,
            \Seracademico\Repositories\Graduacao\CurriculoRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\Graduacao\TurmaRepository::class,
            \Seracademico\Repositories\Graduacao\TurmaRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\DiaRepository::class,
            \Seracademico\Repositories\DiaRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\HoraRepository::class,
            \Seracademico\Repositories\HoraRepositoryEloquent::class
        );
        
		$this->app->bind(
			\Seracademico\Repositories\Biblioteca\EmprestarRepository::class,
			\Seracademico\Repositories\Biblioteca\EmprestarRepositoryEloquent::class
		);
		$this->app->bind(
			\Seracademico\Repositories\Biblioteca\EmprestimoExemplarRepository::class,
			\Seracademico\Repositories\Biblioteca\EmprestimoExemplarRepositoryEloquent::class
		);
		$this->app->bind(
			\Seracademico\Repositories\Biblioteca\ReservaRepository::class,
			\Seracademico\Repositories\Biblioteca\ReservaRepositoryEloquent::class
		);
		$this->app->bind(
			\Seracademico\Repositories\Biblioteca\ReservaExemplarRepository::class,
			\Seracademico\Repositories\Biblioteca\ReservaExemplarRepositoryEloquent::class
		);

        $this->app->bind(
            \Seracademico\Repositories\Graduacao\MateriaRepository::class,
            \Seracademico\Repositories\Graduacao\MateriaRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\Financeiro\BancoRepository::class,
            \Seracademico\Repositories\Financeiro\BancoRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\TipoVencimentoRepository::class,
            \Seracademico\Repositories\TipoVencimentoRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\Financeiro\TaxaRepository::class,
            \Seracademico\Repositories\Financeiro\TaxaRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\Graduacao\VestibularRepository::class,
            \Seracademico\Repositories\Graduacao\VestibularRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\Graduacao\VestibulandoNotaVestibularRepository::class,
            \Seracademico\Repositories\Graduacao\VestibulandoNotaVestibularRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\Graduacao\AlunoRepository::class,
            \Seracademico\Repositories\Graduacao\AlunoRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\PessoaRepository::class,
            \Seracademico\Repositories\PessoaRepositoryEloquent::class
        );

		$this->app->bind(
			\Seracademico\Repositories\ParametroRepository::class,
			\Seracademico\Repositories\ParametroRepositoryEloquent::class
		);

        $this->app->bind(
            \Seracademico\Repositories\ItemParametroRepository::class,
            \Seracademico\Repositories\ItemParametroRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\Graduacao\VestibulandoFinanceiroRepository::class,
            \Seracademico\Repositories\Graduacao\VestibulandoFinanceiroRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\Graduacao\AlunoNotaRepository::class,
            \Seracademico\Repositories\Graduacao\AlunoNotaRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\Graduacao\AlunoFrequenciaRepository::class,
            \Seracademico\Repositories\Graduacao\AlunoFrequenciaRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\Graduacao\MotivoRepository::class,
            \Seracademico\Repositories\Graduacao\MotivoRepositoryEloquent::class);

        $this->app->bind(
            \Seracademico\Repositories\Graduacao\AlunoDisciplinaDispensadaRepository::class,
            \Seracademico\Repositories\Graduacao\AlunoDisciplinaDispensadaRepositoryEloquent::class);
  
		$this->app->bind(
			\Seracademico\Repositories\Biblioteca\BibParametroRepository::class,
			\Seracademico\Repositories\Biblioteca\BibParametroRepositoryEloquent::class
		);

        $this->app->bind(
            \Seracademico\Repositories\TipoPermissaoRepository::class,
            \Seracademico\Repositories\TipoPermissaoRepositoryEloquent::class);

 
		$this->app->bind(
			\Seracademico\Repositories\Financeiro\TipoExigenciaRepository::class,
			\Seracademico\Repositories\Financeiro\TipoExigenciaRepositoryEloquent::class
		);

		$this->app->bind(
			\Seracademico\Repositories\Financeiro\ExigenciaRepository::class,
			\Seracademico\Repositories\Financeiro\ExigenciaRepositoryEloquent::class
		);        

		$this->app->bind(
			\Seracademico\Repositories\Financeiro\TipoMultaRepository::class,
			\Seracademico\Repositories\Financeiro\TipoMultaRepositoryEloquent::class
		);

		$this->app->bind(
			\Seracademico\Repositories\Financeiro\TipoJuroRepository::class,
			\Seracademico\Repositories\Financeiro\TipoJuroRepositoryEloquent::class
		);
        
		$this->app->bind(
			\Seracademico\Repositories\Financeiro\TipoDebitoRepository::class,
			\Seracademico\Repositories\Financeiro\TipoDebitoRepositoryEloquent::class
		);

		$this->app->bind(
			\Seracademico\Repositories\Financeiro\TipoTaxaRepository::class,
			\Seracademico\Repositories\Financeiro\TipoTaxaRepositoryEloquent::class
		);

		$this->app->bind(
			\Seracademico\Repositories\Financeiro\DebitoAbertoAlunoRepository::class,
			\Seracademico\Repositories\Financeiro\DebitoAbertoAlunoRepositoryEloquent::class
		);

		$this->app->bind(
			\Seracademico\Repositories\Financeiro\IncidenciaRepository::class,
			\Seracademico\Repositories\Financeiro\IncidenciaRepositoryEloquent::class
		);

		$this->app->bind(
			\Seracademico\Repositories\Financeiro\TipoValorRepository::class,
			\Seracademico\Repositories\Financeiro\TipoValorRepositoryEloquent::class
		);

		$this->app->bind(
			\Seracademico\Repositories\Financeiro\DataVencimentoRepository::class,
			\Seracademico\Repositories\Financeiro\DataVencimentoRepositoryEloquent::class
		);

		$this->app->bind(
			\Seracademico\Repositories\Financeiro\TipoDiaRepository::class,
			\Seracademico\Repositories\Financeiro\TipoDiaRepositoryEloquent::class
		);

		$this->app->bind(
			\Seracademico\Repositories\Financeiro\TipoBeneficioRepository::class,
			\Seracademico\Repositories\Financeiro\TipoBeneficioRepositoryEloquent::class
		);

		$this->app->bind(
			\Seracademico\Repositories\Financeiro\FormaPagamentoRepository::class,
			\Seracademico\Repositories\Financeiro\FormaPagamentoRepositoryEloquent::class
		);

		$this->app->bind(
			\Seracademico\Repositories\Financeiro\LocalPagamentoRepository::class,
			\Seracademico\Repositories\Financeiro\LocalPagamentoRepositoryEloquent::class
		);


		$this->app->bind(
			\Seracademico\Repositories\Financeiro\FechamentoRepository::class,
			\Seracademico\Repositories\Financeiro\FechamentoRepositoryEloquent::class
		);

		$this->app->bind(
			\Seracademico\Repositories\Financeiro\TipoMoedaRepository::class,
			\Seracademico\Repositories\Financeiro\TipoMoedaRepositoryEloquent::class
		);

		$this->app->bind(
			\Seracademico\Repositories\Financeiro\BoletoRepository::class,
			\Seracademico\Repositories\Financeiro\BoletoRepositoryEloquent::class
		);

		$this->app->bind(
			\Seracademico\Repositories\Financeiro\BeneficioRepository::class,
			\Seracademico\Repositories\Financeiro\BeneficioRepositoryEloquent::class
		);

		$this->app->bind(
			\Seracademico\Repositories\Graduacao\PlanoEnsinoRepository::class,
			\Seracademico\Repositories\Graduacao\PlanoEnsinoRepositoryEloquent::class
		);

		$this->app->bind(
			\Seracademico\Repositories\Graduacao\ConteudoProgramaticoRepository::class,
			\Seracademico\Repositories\Graduacao\ConteudoProgramaticoRepositoryEloquent::class
		);
		

		$this->app->bind(
			\Seracademico\Repositories\Graduacao\PlanoAulaRepository::class,
			\Seracademico\Repositories\Graduacao\PlanoAulaRepositoryEloquent::class
		);

		$this->app->bind(
			\Seracademico\Repositories\Graduacao\DiarioAulaRepository::class,
			\Seracademico\Repositories\Graduacao\DiarioAulaRepositoryEloquent::class
		);

		$this->app->bind(
			\Seracademico\Repositories\Financeiro\BoletoVestibulandoRepository::class,
			\Seracademico\Repositories\Financeiro\BoletoVestibulandoRepositoryEloquent::class
		);

        $this->app->bind(
            \Seracademico\Repositories\Graduacao\HorarioDisciplinaTurmaRepository::class,
            \Seracademico\Repositories\Graduacao\HorarioDisciplinaTurmaRepositoryEloquent::class
        );

		$this->app->bind(
			\Seracademico\Repositories\PosGraduacao\AlunoRepository::class,
			\Seracademico\Repositories\PosGraduacao\AlunoRepositoryEloquent::class
		);

		$this->app->bind(
			\Seracademico\Repositories\Graduacao\AlunoDisciplinaExtraCurricularRepository::class,
			\Seracademico\Repositories\Graduacao\AlunoDisciplinaExtraCurricularRepositoryEloquent::class
		);

		$this->app->bind(
			\Seracademico\Repositories\Graduacao\AlunoDisciplinaEletivaRepository::class,
			\Seracademico\Repositories\Graduacao\AlunoDisciplinaEletivaRepositoryEloquent::class
		);

        $this->app->bind(
            \Seracademico\Repositories\Graduacao\AlunoEquivalenciaRepository::class,
            \Seracademico\Repositories\Graduacao\AlunoEquivalenciaRepositoryEloquent::class
        );

		$this->app->bind(
			\Seracademico\Repositories\PosGraduacao\CanalCaptacaoRepository::class,
			\Seracademico\Repositories\PosGraduacao\CanalCaptacaoRepositoryEloquent::class
		);

		$this->app->bind(
			\Seracademico\Repositories\PosGraduacao\TipoPretensaoRepository::class,
			\Seracademico\Repositories\PosGraduacao\TipoPretensaoRepositoryEloquent::class
		);

		$this->app->bind(
			\Seracademico\Repositories\PosGraduacao\ProfessorPosRepository::class,
			\Seracademico\Repositories\PosGraduacao\ProfessorPosRepositoryEloquent::class
		);

		$this->app->bind(
			\Seracademico\Repositories\PosGraduacao\AlunoNotaRepository::class,
			\Seracademico\Repositories\PosGraduacao\AlunoNotaRepositoryEloquent::class
		);
		

		$this->app->bind(
			\Seracademico\Repositories\PosGraduacao\AlunoFrequenciaRepository::class,
			\Seracademico\Repositories\PosGraduacao\AlunoFrequenciaRepositoryEloquent::class
		);

		$this->app->bind(
			\Seracademico\Repositories\PosGraduacao\AlunoDisciplinaDispensadaRepository::class,
			\Seracademico\Repositories\PosGraduacao\AlunoDisciplinaDispensadaRepositoryEloquent::class
		);

		$this->app->bind(
			\Seracademico\Repositories\PosGraduacao\AlunoDisciplinaExtraCurricularRepository::class,
			\Seracademico\Repositories\PosGraduacao\AlunoDisciplinaExtraCurricularRepositoryEloquent::class
		);

		$this->app->bind(
			\Seracademico\Repositories\PosGraduacao\AlunoDisciplinaEquivalenteRepository::class,
			\Seracademico\Repositories\PosGraduacao\AlunoDisciplinaEquivalenteRepositoryEloquent::class
		);

		$this->app->bind(
			\Seracademico\Repositories\PosGraduacao\PlanoEnsinoRepository::class,
			\Seracademico\Repositories\PosGraduacao\PlanoEnsinoRepositoryEloquent::class
		);

		$this->app->bind(
			\Seracademico\Repositories\PosGraduacao\ConteudoProgramaticoRepository::class,
			\Seracademico\Repositories\PosGraduacao\ConteudoProgramaticoRepositoryEloquent::class
		);


		$this->app->bind(
			\Seracademico\Repositories\PosGraduacao\PlanoAulaRepository::class,
			\Seracademico\Repositories\PosGraduacao\PlanoAulaRepositoryEloquent::class
		);

		$this->app->bind(
			\Seracademico\Repositories\PosGraduacao\DiarioAulaRepository::class,
			\Seracademico\Repositories\PosGraduacao\DiarioAulaRepositoryEloquent::class
		);

		$this->app->bind(
			\Seracademico\Repositories\PoloRepository::class,
			\Seracademico\Repositories\PoloRepositoryEloquent::class
		);

        $this->app->bind(
            \Seracademico\Repositories\Mestrado\DisciplinaRepository::class,
            \Seracademico\Repositories\Mestrado\DisciplinaRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\Mestrado\AlunoRepository::class,
            \Seracademico\Repositories\Mestrado\AlunoRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\Mestrado\CursoRepository::class,
            \Seracademico\Repositories\Mestrado\CursoRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\Mestrado\CurriculoRepository::class,
            \Seracademico\Repositories\Mestrado\CurriculoRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\Mestrado\TurmaRepository::class,
            \Seracademico\Repositories\Mestrado\TurmaRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\Mestrado\ProfessorRepository::class,
            \Seracademico\Repositories\Mestrado\ProfessorRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\Mestrado\CalendarioDisciplinaTurmaRepository::class,
            \Seracademico\Repositories\Mestrado\CalendarioDisciplinaTurmaRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\Mestrado\AlunoNotaRepository::class,
            \Seracademico\Repositories\Mestrado\AlunoNotaRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\Mestrado\AlunoFrequenciaRepository::class,
            \Seracademico\Repositories\Mestrado\AlunoFrequenciaRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\Mestrado\PlanoAulaRepository::class,
            \Seracademico\Repositories\Mestrado\PlanoAulaRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\Mestrado\PlanoEnsinoRepository::class,
            \Seracademico\Repositories\Mestrado\PlanoEnsinoRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\Mestrado\ConteudoProgramaticoRepository::class,
            \Seracademico\Repositories\Mestrado\ConteudoProgramaticoRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\Mestrado\DiarioAulaRepository::class,
            \Seracademico\Repositories\Mestrado\DiarioAulaRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\Mestrado\AlunoDisciplinaDispensadaRepository::class,
            \Seracademico\Repositories\Mestrado\AlunoDisciplinaDispensadaRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\Mestrado\AlunoDisciplinaExtraCurricularRepository::class,
            \Seracademico\Repositories\Mestrado\AlunoDisciplinaExtraCurricularRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\Mestrado\AlunoDisciplinaEquivalenteRepository::class,
            \Seracademico\Repositories\Mestrado\AlunoDisciplinaEquivalenteRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\Tecnico\DisciplinaRepository::class,
            \Seracademico\Repositories\Tecnico\DisciplinaRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\Tecnico\AlunoRepository::class,
            \Seracademico\Repositories\Tecnico\AlunoRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\Tecnico\CursoRepository::class,
            \Seracademico\Repositories\Tecnico\CursoRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\Tecnico\CurriculoRepository::class,
            \Seracademico\Repositories\Tecnico\CurriculoRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\Tecnico\TurmaRepository::class,
            \Seracademico\Repositories\Tecnico\TurmaRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\Tecnico\ProfessorRepository::class,
            \Seracademico\Repositories\Tecnico\ProfessorRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\Tecnico\CalendarioDisciplinaTurmaRepository::class,
            \Seracademico\Repositories\Tecnico\CalendarioDisciplinaTurmaRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\Tecnico\AlunoNotaRepository::class,
            \Seracademico\Repositories\Tecnico\AlunoNotaRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\Tecnico\AlunoFrequenciaRepository::class,
            \Seracademico\Repositories\Tecnico\AlunoFrequenciaRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\Tecnico\PlanoAulaRepository::class,
            \Seracademico\Repositories\Tecnico\PlanoAulaRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\Tecnico\PlanoEnsinoRepository::class,
            \Seracademico\Repositories\Tecnico\PlanoEnsinoRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\Tecnico\ConteudoProgramaticoRepository::class,
            \Seracademico\Repositories\Tecnico\ConteudoProgramaticoRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\Tecnico\DiarioAulaRepository::class,
            \Seracademico\Repositories\Tecnico\DiarioAulaRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\Tecnico\AlunoDisciplinaDispensadaRepository::class,
            \Seracademico\Repositories\Tecnico\AlunoDisciplinaDispensadaRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\Tecnico\AlunoDisciplinaExtraCurricularRepository::class,
            \Seracademico\Repositories\Tecnico\AlunoDisciplinaExtraCurricularRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\Tecnico\AlunoDisciplinaEquivalenteRepository::class,
            \Seracademico\Repositories\Tecnico\AlunoDisciplinaEquivalenteRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\InstituicaoRepository::class,
            \Seracademico\Repositories\InstituicaoRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\CursoPosGraduacaoRepository::class,
            \Seracademico\Repositories\CursoPosGraduacaoRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\CursoSuperiorRepository::class,
            \Seracademico\Repositories\CursoSuperiorRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\CalendarioRepository::class,
            \Seracademico\Repositories\CalendarioRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\EventoRepository::class,
            \Seracademico\Repositories\EventoRepositoryEloquent::class
        );
    }
}