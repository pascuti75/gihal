<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Contratacion extends Model
{
    use HasFactory, Searchable;

    //Determinamos la tabla que está relacionada al modelo
    protected $table = "contrataciones";

    //fillable es para visualizar los campos de la tabla en las consultas sql
    protected $fillable = ['titulo', 'empresa', 'fecha_inicio', 'fecha_fin'];

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */


     //campos que se van a utilizar en la busqueda
    public function toSearchableArray()
    {
        return [
            'titulo' => $this->titulo,
            'empresa' => $this->empresa,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin,
        ];
    }
}
