<?php

// app/Models/Procedimento.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Procedimento extends Model
{
    use SoftDeletes;
    protected $table = 'procedimentos';

    protected $fillable = [
        'nome_proc',
        'descricao_proc',
    ];

    protected $primaryKey = 'pk_cod_proc'; // Adicionei a chave primária

    protected $keyType = 'string';
}