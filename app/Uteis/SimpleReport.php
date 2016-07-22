<?php
namespace Seracademico\Uteis;


use Seracademico\Contracts\Report;

class SimpleReport implements Report
{
    /**
     * Atributo que armazenará o sql principal
     *
     * @var string
     */
    private $sql;

    /**
     * Atributo que armazenará os campos da consulta principal
     *
     * @var array
     */
    private $fields;

    /**
     * Atributo que armazenará os campos do rodapé
     *
     * @var array
     */
    private $footer;

    /**
     * Atributo que armazenará o nome do relatório
     *
     * @var
     */
    private $nameReport;

    /**
     * Método responsável pela geração dos dados do relatório
     */
    public function generate($id)
    {
        # Carregandos os atributos necessários
        $this->load($id);

        # Recuperando a configuração do html
        $width  = array_column($this->fields, 'largura');
        $head   = array_column($this->fields, 'name');

        # Array de retorno
        $report = [
            'reportName' => $this->nameReport[0]->nome,
            'body'    => $this->body(),
            'footer'  => $this->footer(),
            'headers' => $head,
            'widths'  => $width
        ];
        
        # retorno
        return $report;
    }

    /**
     * Método responsável por retornar os dados do corpo
     *
     * @return mixed
     */
    private function body()
    {
        # Recuperando os campos e larguras da pesquisa principal
        $fields = implode(',', array_column($this->fields, 'field'));

        # Finalizando o sql principal
        $sql    = str_replace('FIELDS', $fields, $this->sql[0]);

        # Executando o sql principal
        return \DB::select($sql);
    }

    /**
     * Método responsável por retornar os dados do rodapé
     *
     * @return mixed
     */
    public function footer()
    {
        # Array de campos prontos para serem colocados no sql
        $footerFields = [];

        # percorendo o array de campos do rodapé
        foreach($this->footer as $f) {
            # Criando o alias
            $alias = strtolower($f->name);

            # Refatorando o nome do campo e adicionando no array
            $footerFields[] = "{$f->operation}({$f->field}) as {$alias}";
        }

        # String sql formatada dos campos
        $stringFooter = implode(',', $footerFields);

        # Finalizando o sql principal
        $sql    = str_replace('FIELDS', $stringFooter, $this->sql[0]);

        # Executando o sql principal
        return \DB::select($sql);
    }

    /**
     * Método responsável por carregar os atributos do objeto
     *
     * @param $id
     */
    private function load($id)
    {
        # Recuperando o nome do Relatório
        $this->nameReport =  \DB::table('reports')
            ->where('reports.id', $id)
            ->select([
                'reports.nome',
            ])
            ->get();

        # Recuperando o sql principal
        $this->sql =  \DB::table('reports')
            ->where('reports.id', $id)
            ->lists('reports.sql');

        # Carregando os campos principais
        $this->fields = \DB::table('fields_report')
            ->join('reports', 'reports.id', '=', 'fields_report.report_id')
            ->where('reports.id', $id)
            ->select([
                'fields_report.nome as field',
                'fields_report.descricao as name',
                'fields_report.largura'
            ])
            ->get();

        # Carregando os campos de rodapé
        $this->footer = \DB::table('footer_report')
            ->join('reports', 'reports.id', '=', 'footer_report.report_id')
            ->join('fields_report', 'fields_report.id', '=', 'footer_report.report_id')
            ->join('operation_report', 'operation_report.id', '=', 'footer_report.operation_id')
            ->where('reports.id', $id)
            ->select([
                'fields_report.nome as field',
                'fields_report.largura',
                'operation_report.nome as operation',
                'fields_report.descricao as name',
            ])
            ->get();
    }

    /**
     * Método responsável por retornar todos os relatórios
     *
     * @return mixed
     */
    public function getReports()
    {
        return \DB::table('report')->all();
    }
}