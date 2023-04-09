<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

//Definición del modelo Equipo
class Equipo extends Model
{
    //indicamos que es un modelo buscable mediante Laravel Scout
    use HasFactory, Searchable;

    //Determinamos la tabla que está relacionada al modelo
    protected $table = "equipos";

    //fillable es para visualizar los campos de la tabla en las consultas sql
    protected $fillable = [
        'cod_interno', 'cod_externo', 'marca', 'modelo',
        'product_number', 'num_serie', 'id_contratacion', 'id_tipo_equipo'
    ];


    //definimos la relacion con el modelo tipoEquipo
    public function tipoEquipo()
    {
        return $this->hasOne(TipoEquipo::class, 'id', 'id_tipo_equipo');
    }

    //definimos la relacion con el modelo contratacion
    public function contratacion()
    {
        return $this->hasOne(Contratacion::class, 'id', 'id_contratacion');
    }

    //definimos la relacion con el modelo operacion
    public function operaciones(): HasMany
    {
        return $this->hasMany(Operacion::class);
    }

    //campos que se van a utilizar en la busqueda
    public function toSearchableArray()
    {
        return [
            'cod_interno' => $this->cod_interno,
            'cod_externo' => $this->cod_externo,
            'marca' => $this->marca,
            'modelo' => $this->modelo,
            'product_number' => $this->product_number,
            'num_serie' => $this->num_serie,
            'id_contratacion' => $this->id_contratacion,
            'id_tipo_equipo' => $this->id_tipo_equipo,
        ];
    }
}
