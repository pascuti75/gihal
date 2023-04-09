<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

//Definición del modelo TipoEquipo
class TipoEquipo extends Model
{
    //indicamos que es un modelo buscable mediante Laravel Scout
    use HasFactory, Searchable;

    //Determinamos la tabla que está relacionada al modelo
    protected $table = "tipos_equipo";

    //fillable es para visualizar los campos de la tabla en las consultas sql
    protected $fillable = ['cod_tipo_equipo', 'tipo'];

    ///definimos la relacion con el modelo equipo
    public function equipos(): HasMany
    {
        return $this->hasMany(Equipo::class);
    }

    //campos que se van a utilizar en la busqueda
    public function toSearchableArray()
    {
        return [
            'cod_tipo_equipo' => $this->cod_tipo_equipo,
            'tipo' => $this->tipo
        ];
    }
}
