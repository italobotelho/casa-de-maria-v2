<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Event extends Model
{
    use SoftDeletes;

    protected $fillable = ['title', 'start', 'end', 'color', 'procedimento_id', 'medico', 'convenio', 'paciente_id'];

    public function procedimento()
    {
        return $this->belongsTo(Procedimento::class, 'procedimento_id', 'pk_cod_proc');
    }

    public function medico()
    {
        return $this->belongsTo(Medico::class, 'medico', 'pk_crm_med'); // Aqui, 'medico' é o campo que armazena o ID do médico
    }
    
    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id'); // Ajuste o campo conforme sua estrutura
    }

    public function getStartAttribute($value)
    {
        $dateStart = Carbon::createFromFormat("Y-m-d H:i:s", $value)->format("Y-m-d");
        $timeStart = Carbon::createFromFormat("Y-m-d H:i:s", $value)->format("H:i:s");

        return $timeStart == '00:00:00' ? $dateStart : $value;
    }

    public function getEndAttribute($value)
    {
        $dateEnd = Carbon::createFromFormat("Y-m-d H:i:s", $value)->format("Y-m-d");
        $timeEnd = Carbon::createFromFormat("Y-m-d H:i:s", $value)->format("H:i:s");

        return $timeEnd == '00:00:00' ? $dateEnd : $value;
    }
}
