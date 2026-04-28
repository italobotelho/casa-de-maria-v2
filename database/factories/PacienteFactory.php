<?php

namespace Database\Factories;

use App\Models\Paciente;
use App\Models\Convenio;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

class PacienteFactory extends Factory
{

protected $model = Paciente::class;

    public function definition()
    {
        // Selecionando um convênio aleatório
        $convenio = Convenio::inRandomOrder()->first();
        $convenioId = $convenio ? $convenio->pk_id_conv : null;

        return [
            'fk_convenio_paci' => $convenioId, // Referência ao convênio aleatório ou null
            'img_paci' => 'imagens_pacientes/default-profile-pic.png', // Imagem padrão do sistema
            'angulo_rotacao' => 0, // Ângulo de rotação fixo em 0
            'nome_paci' => $this->faker->name(),
            'telefone_paci' => $this->faker->phoneNumber(),
            'email_paci' => $this->faker->safeEmail(),
            'data_nasci_paci' => $this->faker->date(),
            'cpf_paci' => $this->faker->cpf(),
            'cpf_responsavel_paci' => $this->faker->cpf(),
            'responsavel_paci' => $this->faker->name(),
            'carteira_convenio_paci' => ($convenioId && $convenioId != 1) ? $this->faker->numerify(str_repeat('#', random_int(11, 20))) : null, // Gera carteira só se o convênio não for 1
            'data_obito_paci' => null, // Mantendo o campo obito como null
            'genero' => $this->faker->randomElement(['masc', 'fem', 'nao_informar']),
            'cep_paci' => $this->faker->postcode(),
            'rua_paci' => $this->faker->streetName(),
            'numero_paci' => $this->faker->buildingNumber(),
            'bairro_paci' => $this->faker->word(),
            'complemento_paci' => $this->faker->secondaryAddress(),
            'cidade_paci' => $this->faker->city(),
            'uf_paci' => $this->faker->stateAbbr(),
        ];
    }
}
