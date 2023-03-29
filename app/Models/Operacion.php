<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Scout\Searchable;

use function PHPUnit\Framework\returnCallback;

class Operacion extends Model
{
    use HasFactory, Searchable;

    //Determinamos la tabla que está relacionada al modelo
    protected $table = "operaciones";

    //fillable es para visualizar los campos de la tabla en las consultas sql
    protected $fillable = [
        'tipo_operacion', 'fecha_operacion', 'activa', 'id_equipo',
        'id_ubicacion', 'id_persona', 'id_user'
    ];


    public function equipo(): HasOne
    {
        return $this->hasOne(Equipo::class, 'id', 'id_equipo');
    }

    public function ubicacion(): HasOne
    {
        return $this->hasOne(Ubicacion::class, 'id', 'id_ubicacion');
    }

    public function persona(): HasOne
    {
        return $this->hasOne(Persona::class, 'id', 'id_persona');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'id_user');
    }

    //campos que se van a utilizar en la busqueda
    public function toSearchableArray()
    {
        return [
            'tipo_operacion' => $this->tipo_operacion,
            'fecha_operacion' => $this->fecha_operacion
        ];
    }

    //Query scope

    public function scopeTipoOperacion($query, $tipo_operacion)
    {
        if ($tipo_operacion) {
            return $query->where('tipo_operacion', 'LIKE', "%$tipo_operacion%");
        }
    }

    public function scopeActiva($query, $activa)
    {
        if ($activa && $activa == 'on') {
            return $query->where('activa', 'LIKE', "si");
        }
    }
}
