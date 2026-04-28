<?php

// app/Models/Procedimento.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Procedimento extends Model
{
    protected $table = 'procedimentos';

    protected $fillable = [
        'nome_proc',
        'descricao_proc',
    ];

    protected $primaryKey = 'pk_cod_proc'; // Adicionei a chave primária

    protected $keyType = 'string';
}