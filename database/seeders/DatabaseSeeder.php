<?php

namespace Database\Seeders;

use App\Models\Procedimento;
use App\Models\Paciente;
use App\Models\Medico;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UsuarioSeeders::class,
            ProcedimentoSeeder::class,
            ConvenioSeeder::class,
        ]);

        Medico::factory()->count(15)->create();
        Paciente::factory()->count(100)->create();
    }
}
