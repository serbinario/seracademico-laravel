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
			\Seracademico\Repositories\DisciplinaRepository::class,
			\Seracademico\Repositories\DisciplinaRepositoryEloquent::class
		);

		$this->app->bind(
			\Seracademico\Repositories\DisciplinaRepository::class,
			\Seracademico\Repositories\DisciplinaRepositoryEloquent::class
		);

		$this->app->bind(
			\Seracademico\Repositories\CursoRepository::class,
			\Seracademico\Repositories\CursoRepositoryEloquent::class
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
            \Seracademico\Repositories\PosGraduacao\CalendarioDisciplinaTurmaEloquent::class
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
            \Seracademico\Repositories\BancoRepository::class,
            \Seracademico\Repositories\BancoRepositoryEloquent::class
        );
        $this->app->bind(
            \Seracademico\Repositories\TipoVencimentoRepository::class,
            \Seracademico\Repositories\TipoVencimentoRepositoryEloquent::class
        );

        $this->app->bind(
            \Seracademico\Repositories\TaxaRepository::class,
            \Seracademico\Repositories\TaxaRepositoryEloquent::class
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
        
	}
    
}