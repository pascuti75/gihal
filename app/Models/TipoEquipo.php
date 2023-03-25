<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

class TipoEquipo extends Model
{
    use HasFactory, Searchable;

    //Determinamos la tabla que está relacionada al modelo
    protected $table = "tipos_equipo";

    //fillable es para visualizar los campos de la tabla en las consultas sql
    protected $fillable = ['cod_tipo_equipo', 'tipo'];



    //Relacion con equipos
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
