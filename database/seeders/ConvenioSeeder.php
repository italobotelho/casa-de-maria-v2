<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConvenioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('convenios')->insert([
            [
                'nome_conv' => 'Particular'
            ],
            
            [
                'nome_conv' => 'Unimed'
            ]
        ]);
    }
}
