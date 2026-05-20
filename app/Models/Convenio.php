<?php

// app/Models/Convenio.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Convenio extends Model
{
    use SoftDeletes;
    protected $table = 'convenios';

    protected $fillable = [
        'pk_cod_conv',
        'ans_conv',
        'nome_conv',
    ];

    protected $primaryKey = 'pk_id_conv';

    protected $keyType = 'string';

    public function pacientes()
    {
        return $this->hasMany(Paciente::class, 'convenio_id'); // Certifique-se de que o campo 'convenio_id' está correto
    }
}
