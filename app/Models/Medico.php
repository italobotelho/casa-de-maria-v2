<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medico extends Model
{
    use HasFactory;

    // Define a tabela associada a esta model
    protected $table = 'medicos';

    // Define a chave primária da tabela
    protected $primaryKey = 'pk_crm_med';

    // Diz ao Laravel que a chave primária é do tipo inteiro
    protected $keyType = 'int';

    // Desativa o incremento automático da chave primária
    public $incrementing = true;

    // Desativa a manutenção automática das colunas created_at e updated_at
    public $timestamps = true;

    protected $fillable = [
        'especialidade1_med',
        'especialidade2_med',
        'email_med',
        'uf_med',
        'telefone_med',
        'nome_med',
        'pk_crm_med'
    ];




    }
