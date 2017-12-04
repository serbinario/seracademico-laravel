<?php

namespace Seracademico\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Mockery\CountValidator\Exception;
use Seracademico\Repositories\ReleaseRepository;
use Seracademico\Entities\Hora;

class ReleasesService
{
    /**
     * @var ReleaseRepository
     */
    protected $repository;

    /**
     * @param ReleaseRepository $repository
     */
    public function __construct(ReleaseRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param $data
     */
    public function store($data)
    {
        $release = $this->repository->create($data);

        if(!$release) {
            throw new Exception('Ocorreu um erro ao salvar');
        }
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function find($id)
    {
        #Recuperando o registro no banco de dados
        $lancamento = $this->repository->find($id);

        #Verificando se o registro foi encontrado
        if(!$lancamento) {
            throw new \Exception('Lançamento não encontrado');
        }

        #retorno
        return $lancamento;
    }

    /**
     * @param $data
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function update($data, $id)
    {
        #Atualizando no banco de dados
        $release = $this->repository->update($data, $id);

        #Verificando se foi atualizado no banco de dados
        if(!$release) {
            throw new \Exception('Ocorreu um erro ao cadastrar!');
        }

        #Retorno
        return $release;
    }

    /**
     * @return array|static
     */
    public function buscarLancamentos()
    {
        $lacamentosFormatados = [];

        $lancamentos = \DB::table('releases')
            ->join('release_type', 'release_type.id', '=', 'releases.tipo_id')
            ->join('desenvolvedores', 'desenvolvedores.id', '=', 'releases.desenvolvedor_id')
            ->join('sistemas', 'sistemas.id', '=', 'releases.sistema_id')
            ->select([
                'releases.id',
                \DB::raw("date_format(releases.data, '%d/%m/%Y') as data"),
                'releases.descricao',
                'desenvolvedores.nome as desenvolvedor',
                'release_type.nome as tipo',
                'sistemas.nome as sistema'
            ])
            ->get();

        if(!$lancamentos) {
            throw new Exception('Nenhum lançamento encontrado');
        }

        $lancamentosCollection = new Collection($lancamentos);

        $lancamentosMap = $lancamentosCollection->map(function($lancamento) {
            return [
                'data' => $lancamento->data,
                'descricao' => $lancamento->descricao,
                'desenvolvedor' => $lancamento->desenvolvedor,
                'tipo' => $lancamento->tipo,
                'sistema' => $lancamento->sistema
            ];
        });

        $lacamentosFormatados = $lancamentosMap->groupBy('data');
        $lancamentoDesc = $lacamentosFormatados->reverse();

        return $lacamentosFormatados;
    }
}