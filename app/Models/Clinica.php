<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clinica extends Model
{
    protected $fillable = [
        'nome_clin',
        'cnpj_clin',
        'descricao_clin',
        'telefone_clin',
        'email_aten_clin',
        'email_resp_clin',
        'cep_clin',
        'rua_clin',
        'numero_clin',
        'bairro_clin',
        'complemento_clin',
        'cidade_clin',
        'uf_clin',
        'cod_ibge_clin',
    ];

    protected $primaryKey = 'cnpj_clin';
    
}

