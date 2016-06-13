<?php

use Illuminate\Database\Seeder;
use Fake\Factory as Faker;

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
        factory(\Seracademico\Entities\Pessoa::class, 20)->create();
    }
}
