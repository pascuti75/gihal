<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Scout\Searchable;
use Carbon\Carbon;

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

    public function scopeCodInterno($query, $cod_interno)
    {
        if ($cod_interno) {
            return $query->whereHas('equipo', function ($query) use ($cod_interno) {
                $query->where('cod_interno', 'LIKE', "%$cod_interno%");
            });
        }
    }


    public function scopeTipoOperacion($query, $tipo_operacion)
    {
        if ($tipo_operacion) {
            return $query->where('tipo_operacion', 'LIKE', "$tipo_operacion");
        }
    }


    public function scopeActiva($query, $activa)
    {
        if ($activa && $activa == 'on') {
            return $query->where('activa', 'LIKE', "si");
        }
    }


    public function scopeTecnico($query, $tecnico)
    {
        if ($tecnico) {
            return $query->whereHas('user', function ($query) use ($tecnico) {
                $query->where('id', 'LIKE', "$tecnico");
            });
        }
    }


    public function scopePersona($query, $persona)
    {
        if ($persona) {
            return $query->whereHas('persona', function ($query) use ($persona) {
                $query->where('id', 'LIKE', "$persona");
            });
        }
    }


    public function scopeTipoEquipo($query, $tipo_equipo)
    {
        if ($tipo_equipo) {
            return $query->whereHas('equipo', function ($query) use ($tipo_equipo) {
                $query->where('id_tipo_equipo', 'LIKE', "$tipo_equipo");
            });
        }
    }


    public function scopeUbicacion($query, $ubicacion)
    {
        if ($ubicacion) {
            return $query->whereHas('ubicacion', function ($query) use ($ubicacion) {
                $query->where('id', 'LIKE', "$ubicacion");
            });
        }
    }


    public function scopeContratacion($query, $contratacion)
    {
        if ($contratacion) {
            return $query->whereHas('equipo', function ($query) use ($contratacion) {
                $query->whereHas('contratacion', function ($query) use ($contratacion) {
                    $query->where('id', 'LIKE', "$contratacion");
                });
            });
        }
    }


    public function scopeFOperIni($query, $f_oper_ini)
    {
        if ($f_oper_ini) {
            return $query->where('fecha_operacion', '>=', $f_oper_ini);
        }
    }


    public function scopeFOperFin($query, $f_oper_fin)
    {
        if ($f_oper_fin) {
            return $query->where('fecha_operacion', '<', Carbon::parse($f_oper_fin)->addDay());
        }
    }

    public function scopeMarca($query, $marca)
    {
        if ($marca) {
            return $query->whereHas('equipo', function ($query) use ($marca) {
                $query->where('marca', 'LIKE', "$marca");
            });
        }
    }

    public function scopeModelo($query, $modelo)
    {
        if ($modelo) {
            return $query->whereHas('equipo', function ($query) use ($modelo) {
                $query->where('modelo', 'LIKE', "$modelo");
            });
        }
    }

    public function scopeNumSerie($query, $num_serie)
    {
        if ($num_serie) {
            return $query->whereHas('equipo', function ($query) use ($num_serie) {
                $query->where('num_serie', 'LIKE', "%$num_serie%");
            });
        }
    }

    public function scopeProductNumber($query, $product_number)
    {
        if ($product_number) {
            return $query->whereHas('equipo', function ($query) use ($product_number) {
                $query->where('product_number', 'LIKE', "%$product_number%");
            });
        }
    }
}
