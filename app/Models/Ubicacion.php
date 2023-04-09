<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

//Definición del modelo Ubicacion
class Ubicacion extends Model
{
    //indicamos que es un modelo buscable mediante Laravel Scout
    use HasFactory, Searchable;

    //Determinamos la tabla que está relacionada al modelo
    protected $table = "ubicaciones";

    //fillable es para visualizar los campos de la tabla en las consultas sql
    protected $fillable = ['servicio', 'dependencia', 'direccion', 'planta'];

    //campos que se van a utilizar en la busqueda
    public function toSearchableArray()
    {
        return [
            'servicio' => $this->servicio,
            'dependencia' => $this->dependencia,
            'direccion' => $this->direccion,
            'planta' => $this->planta,
        ];
    }
}
