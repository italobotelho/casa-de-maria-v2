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
        $tables = ['pacientes', 'medicos', 'clinicas', 'convenios', 'procedimentos'];

        foreach ($tables as $table) {
            if (\Illuminate\Support\Facades\Schema::hasTable($table) && !\Illuminate\Support\Facades\Schema::hasColumn($table, 'deleted_at')) {
                Schema::table($table, function (Blueprint $tableBlueprint) {
                    $tableBlueprint->softDeletes();
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = ['pacientes', 'medicos', 'clinica', 'convenios', 'procedimentos'];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $tableBlueprint) {
                $tableBlueprint->dropSoftDeletes();
            });
        }
    }
};
