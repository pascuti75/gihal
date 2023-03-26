<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

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


    public function equipo()
    {
        return $this->hasOne(Equipo::class, 'id', 'id_equipo');
    }

    public function ubicacion()
    {
        return $this->hasOne(Ubicacion::class, 'id', 'id_ubicacion');
    }

    public function persona()
    {
        return $this->hasOne(Persona::class, 'id', 'id_persona');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'id_user');
    }

    //campos que se van a utilizar en la busqueda
    public function toSearchableArray()
    {
        return [
            'tipo_operacion' => $this->tipo_operacion,
            'fecha_operacion' => $this->fecha_operacion,
            'id_equipo' => $this->id_equipo,
            'id_ubicacion' => $this->id_ubicacion,
            'id_persona' => $this->id_persona,
            'id_user' => $this->id_user,
            // 'equipo.cod_interno' => $this->equipo->cod_interno

        ];
    }
}
