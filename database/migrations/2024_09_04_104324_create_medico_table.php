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
        Schema::create('medicos', function (Blueprint $table) {
            $table->unsignedInteger('pk_crm_med')->primary();
            $table->string('especialidade1_med', 40);
            $table->string('especialidade2_med', 40)->nullable();
            $table->string('email_med', 255);
            $table->string('uf_med', 18);
            $table->string('telefone_med', 20);
            $table->string('nome_med', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicos');
    }
};
