<?php

namespace Seracademico\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Bus\SelfHandling;

class SendEmailAlertaBiblioteca extends Command implements SelfHandling
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:emailalertabiblioteca';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia e-mails de notificação para usuários com emprétimos atrasados na biblioteca';

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
        $dateObj = new \DateTime('now');
        $date    = $dateObj->format('Y-m-d');

        // Consultando os empréstimos em atraso
        $emprestimos = \DB::table('bib_emprestimos')
            ->join('pessoas', 'pessoas.id', '=', 'bib_emprestimos.pessoas_id')
            ->where('bib_emprestimos.status', '1')
            ->where('bib_emprestimos.status_devolucao', '0')
            ->where('bib_emprestimos.data_devolucao', '<', $date)
            ->select([
                'bib_emprestimos.id',
                'pessoas.nome',
                'pessoas.email',
                'bib_emprestimos.data_devolucao as devolucao',
                'bib_emprestimos.status_devolucao'
            ])->get();

        // Tratando os empréstimos consultados
        foreach ($emprestimos as $emprestimo) {

            // Consultando os exemplares adquiridos no empréstimo
            $exemplares = \DB::table('bib_emprestimos_exemplares')
                ->join('bib_emprestimos', 'bib_emprestimos_exemplares.emprestimo_id', '=', 'bib_emprestimos.id')
                ->join('bib_exemplares', 'bib_exemplares.id', '=', 'bib_emprestimos_exemplares.exemplar_id')
                ->join('bib_arcevos', 'bib_arcevos.id', '=', 'bib_exemplares.arcevos_id')
                ->join('bib_tipos_acervos', 'bib_tipos_acervos.id', '=', 'bib_arcevos.tipos_acervos_id')
                ->join('pessoas', 'pessoas.id', '=', 'bib_emprestimos.pessoas_id')
                ->where('bib_emprestimos.status', '=', '1')
                ->where('bib_emprestimos.id', '=', $emprestimo->id)
                ->select([
                    'bib_arcevos.titulo',
                    'bib_arcevos.cutter',
                    'bib_arcevos.subtitulo',
                    'bib_arcevos.titulo',
                    'bib_arcevos.numero_chamada',
                    'bib_exemplares.edicao',
                    \DB::raw('CONCAT (SUBSTRING(bib_exemplares.codigo, 4, 4), "/", SUBSTRING(bib_exemplares.codigo, -4, 4)) as tombo'),
                    'bib_tipos_acervos.nome as tipo_acervo'
                ])->get();

            # Enviando o email de notificação por atraso da devolução do emprétimos
            \Mail::send('emails.biblioteca.email_notificacao_atraso_emprestimos',
                ['emprestimo' => $emprestimo, 'exemplares' => $exemplares],
                function ($email) use ($emprestimo) {
                    $email->from('biblioteca@alpha.rec.br', 'Alpha');
                    $email->subject('Notificação de atraso de empréstimos - Biblioteca Faculdade Alpha');
                    $email->to('fabinhobarreto2@gmail.com', 'Alpha Educação e Treinamentos');
                });

        }
    }

}
