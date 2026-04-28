<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Medico;

class MedicoFactory extends Factory
{
    protected $model = Medico::class;

    public function definition()
    {
        return [
            'pk_crm_med' => $this->faker->unique()->numberBetween(100000, 999999), // CRM único
            'especialidade1_med' => $this->faker->randomElement(['Cardiologia', 'Neurologia', 'Ortopedia', 'Pediatria', 'Dermatologia']),
            'especialidade2_med' => $this->faker->optional()->randomElement(['Endocrinologia', 'Gastroenterologia', 'Oftalmologia', 'Psicologia', 'Psiquiatria']),
            'email_med' => $this->faker->unique()->safeEmail,
            'uf_med' => $this->faker->stateAbbr, // Sigla do estado brasileiro
            'telefone_med' => $this->faker->cellphoneNumber(false, true), // Celular no formato nacional
            'nome_med' => $this->faker->name,
        ];
    }
}
