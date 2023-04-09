<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

//Definición del modelo Contratacion
class Contratacion extends Model
{
    //indicamos que es un modelo buscable mediante Laravel Scout
    use HasFactory, Searchable;

    //Determinamos la tabla que está relacionada al modelo
    protected $table = "contrataciones";

    //fillable es para visualizar los campos de la tabla en las consultas sql
    protected $fillable = ['titulo', 'empresa', 'fecha_inicio', 'fecha_fin'];

    //indicamos los campos de tipo fecha
    protected $dates = [
        'created_at',
        'updated_at',
        'fecha_inicio',
        'fecha_fin'
    ];

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
