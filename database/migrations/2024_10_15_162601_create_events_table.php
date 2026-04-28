<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->string('title');
            $table->dateTime('start');
            $table->dateTime('end');
            $table->string('color', 7);
            $table->unsignedBigInteger('procedimento_id'); // Foreign key
            $table->unsignedInteger('medico'); // Alterado para unsignedInteger
            $table->string('convenio'); // Alterado para armazenar o nome do convênio
            $table->unsignedInteger('paciente_id');
            
            // Definindo as chaves estrangeiras
            $table->foreign('procedimento_id')->references('pk_cod_proc')->on('procedimentos');
            $table->foreign('medico')->references('pk_crm_med')->on('medicos'); // Chave estrangeira para medicos
            $table->foreign('paciente_id')->references('pk_cod_paci')->on('pacientes');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropForeign(['procedimento_id']);
            $table->dropForeign(['medico']); // Removendo a chave estrangeira do medico
        });
        Schema::dropIfExists('events');
    }
};