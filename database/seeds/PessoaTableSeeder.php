<?php

use Illuminate\Database\Seeder;
use Fake\Factory as Faker;
use Illuminate\Database\Query\Builder;
class PessoaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        # Criando as pessoas faker
        factory(\Seracademico\Entities\Pessoa::class, 10)->create()->each(function ($pessoa) {
            $endereco = \Seracademico\Entities\Endereco::create([]);
            $pessoa->enderecos_id = $endereco->id;
            $pessoa->save();
        });
    }
}
