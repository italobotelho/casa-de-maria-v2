<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pacientes', function (Blueprint $table) {
            $table->increments('pk_cod_paci'); // Primary key, auto-incrementing

            // Foreign key reference
            $table->unsignedBigInteger('fk_convenio_paci'); // Should match 'bigIncrements' type from 'convenio' table
            $table->foreign('fk_convenio_paci')->references('pk_id_conv')->on('convenios')->onDelete('cascade');

            $table->string('img_paci')->nullable;
            $table->integer('angulo_rotacao')->nullable();
            $table->string('nome_paci', 50)->nullable();
            $table->string('telefone_paci', 15)->nullable();
            $table->string('email_paci', 255)->nullable();
            $table->dateTime('data_nasci_paci')->nullable();
            $table->string('cpf_paci', 14)->nullable();
            $table->string('cpf_responsavel_paci', 14)->nullable();
            $table->string('responsavel_paci', 50)->nullable();
            $table->string('carteira_convenio_paci', 20)->nullable();
            $table->dateTime('data_obito_paci')->nullable();
            $table->enum('genero', ['masc', 'fem', 'nao_informar'])->nullable();
            $table->string('cep_paci', 9)->nullable();
            $table->string('rua_paci', 50)->nullable();
            $table->string('numero_paci',10)->nullable();
            $table->string('bairro_paci', 50)->nullable();
            $table->string('complemento_paci', 100)->nullable();
            $table->string('cidade_paci', 30)->nullable();
            $table->string('uf_paci', 2)->nullable();


            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pacientes');
    }
};
