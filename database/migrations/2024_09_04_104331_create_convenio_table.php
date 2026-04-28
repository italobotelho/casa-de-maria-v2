<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('convenios', function (Blueprint $table) {
            $table->BigIncrements('pk_id_conv');
            $table->string('ans_conv', 6)->nullable();
            $table->string('nome_conv', 55)->unique();
            $table->enum('status', ['ativo', 'inativo'])->default('ativo');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('convenios');
    }
};
