<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class TipoEquipo extends Model
{
    use HasFactory, Searchable;

    //Determinamos la tabla que está relacionada al modelo
    protected $table = "tipos_equipo";

    //fillable es para visualizar los campos de la tabla en las consultas sql
    protected $fillable = ['cod_tipo_equipo', 'tipo'];

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */


    //campos que se van a utilizar en la busqueda
    public function toSearchableArray()
    {
        return [
            'cod_tipo_equipo' => $this->cod_tipo_equipo,
            'tipo' => $this->tipo
        ];
    }
}
