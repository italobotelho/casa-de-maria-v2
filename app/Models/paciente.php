<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    use HasFactory;

    // Define a tabela associada a esta model
    protected $table = 'pacientes';

    // Define a chave primária da tabela
    protected $primaryKey = 'pk_cod_paci';

    // Diz ao Laravel que a chave primária é do tipo inteiro
    protected $keyType = 'int';

    // Desativa o incremento automático da chave primária
    public $incrementing = true;

    // Desativa a manutenção automática das colunas created_at e updated_at
    public $timestamps = true;

    // Define os campos que podem ser preenchidos em massa
    protected $fillable = [
        'fk_cidade',
        'fk_convenio_paci',
        'convenio_paci',
        'email_paci',
        'data_obito_paci',
        'carteira_convenio_paci',
        'responsavel_paci',
        'data_nasci_paci',
        'nome_paci',
        'cpf_responsavel_paci',
        'telefone_paci',
        'cpf_paci',
        'cep_paci',
        'rua_paci',
        'numero_paci',
        'bairro_paci',
        'complemento_paci',
        'cidade_paci',
        'uf_paci',
    ];

    // Define os campos que devem ser tratados como datas
    protected $dates = [
        'data_obito_paci',
        'data_nasci_paci',
    ];


    public function convenio()
    {
        return $this->belongsTo(Convenio::class, 'fk_convenio_paci','pk_id_conv', 'convenio_id');
    }
   
}

