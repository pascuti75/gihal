<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Persona extends Model
{
    use HasFactory, Searchable;

    //Determinamos la tabla que está relacionada al modelo
    protected $table = "personas";

    //fillable es para visualizar los campos de la tabla en las consultas sql
    protected $fillable = ['nombre', 'apellidos', 'tipo_personal'];

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */


     //campos que se van a utilizar en la busqueda
    public function toSearchableArray()
    {
        return [
            'nombre' => $this->nombre,
            'apellidos' => $this->apellidos,
            'tipo_personal' => $this->tipo_personal,
        ];
    }
}
