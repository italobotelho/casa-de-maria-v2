<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clinicas', function (Blueprint $table) {
            $table->bigInteger('cnpj_clin')->primary();
            $table->string('nome_clin', 50);
            $table->string('descricao_clin', 150);
            $table->string('telefone_clin', 12);
            $table->string('email_aten_clin', 50);
            $table->string('email_resp_clin', 50);
            $table->string('cep_clin', 9)->nullable();
            $table->string('rua_clin', 17)->nullable();
            $table->string('numero_clin', 5)->nullable();
            $table->string('bairro_clin', 50)->nullable();
            $table->string('complemento_clin', 100)->nullable();
            $table->string('cidade_clin', 30)->nullable();
            $table->string('uf_clin', 2)->nullable();
            $table->bigInteger('cod_ibge_clin')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clinicas');
    }
};