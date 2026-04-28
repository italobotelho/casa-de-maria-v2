<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProcedimentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('procedimentos')->insert([
            [
                'nome_proc' => 'Consulta',
                'descricao_proc' => 'Consulta padrão',
            ],
            [
                'nome_proc' => 'Retorno',
                'descricao_proc' => 'Retorno padrão de 30 dias',
            ],          
        ]);
    }
}
