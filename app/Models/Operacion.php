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

    //definimos la relacion con el modelo equipo
    public function equipo(): HasOne
    {
        return $this->hasOne(Equipo::class, 'id', 'id_equipo');
    }

    //definimos la relacion con el modelo ubicacion
    public function ubicacion(): HasOne
    {
        return $this->hasOne(Ubicacion::class, 'id', 'id_ubicacion');
    }

    //definimos la relacion con el modelo persona
    public function persona(): HasOne
    {
        return $this->hasOne(Persona::class, 'id', 'id_persona');
    }

    //definimos la relacion con el modelo usuario
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

    //Definimos todos los métodos para definir query scope con las consultas predefinidas

    //Query Scope para filtrar por el campo cod_interno del equipo
    public function scopeCodInterno($query, $cod_interno)
    {
        if ($cod_interno) {
            return $query->whereHas('equipo', function ($query) use ($cod_interno) {
                $query->where('cod_interno', 'LIKE', "%$cod_interno%");
            });
        }
    }

    //Query Scope para filtrar por el campo cod_interno del equipo y el campo activa = 'si' además de enlazar
    //con otras consultas con la clausula OR
    public function scopeOrCodInternoActiva($query, $cod_interno)
    {
        if ($cod_interno) {
            return $query->orwherehas('equipo', function ($query) use ($cod_interno) {
                $query->where('cod_interno', 'LIKE', "%$cod_interno%");
            })->where('activa', 'LIKE', "si");
        }
    }

    //Query Scope para filtrar por el campo tipo_operacion
    public function scopeTipoOperacion($query, $tipo_operacion)
    {
        if ($tipo_operacion) {
            return $query->where('tipo_operacion', 'LIKE', "$tipo_operacion");
        }
    }

    //Query Scope para filtrar por el campo tipo_operacion y el campo activa = 'si' además de enlazar
    //con otras consultas con la clausula OR
    public function scopeOrTipoOperacionActiva($query, $tipo_operacion)
    {
        if ($tipo_operacion) {
            return $query->orwhere('tipo_operacion', 'LIKE', "%$tipo_operacion%")->where('activa', 'LIKE', "si");
        }
    }

    //Query Scope para filtrar por el campo activa
    public function scopeActiva($query, $activa)
    {
        if ($activa && $activa == 'on') {
            return $query->where('activa', 'LIKE', "si");
        }
    }

    //Query Scope para filtrar por el campo tecnico
    public function scopeTecnico($query, $tecnico)
    {
        if ($tecnico) {
            return $query->whereHas('user', function ($query) use ($tecnico) {
                $query->where('id', 'LIKE', "$tecnico");
            });
        }
    }

    //Query Scope para filtrar por el campo tecnico y el campo activa = 'si' además de enlazar
    //con otras consultas con la clausula OR
    public function scopeOrTecnicoActiva($query, $tecnico)
    {
        if ($tecnico) {
            return $query->orwhereHas('user', function ($query) use ($tecnico) {
                $query->where('username', 'LIKE', "%$tecnico%");
            })->where('activa', 'LIKE', "si");
        }
    }

    //Query Scope para filtrar por el campo persona
    public function scopePersona($query, $persona)
    {
        if ($persona) {
            return $query->whereHas('persona', function ($query) use ($persona) {
                $query->where('id', 'LIKE', "$persona");
            });
        }
    }

    //Query Scope para filtrar por el campo persona y el campo activa = 'si' además de enlazar
    //con otras consultas con la clausula OR
    public function scopeOrPersonaActiva($query, $persona)
    {
        if ($persona) {
            return $query->orwhereHas('persona', function ($query) use ($persona) {
                $query->whereraw("UPPER(CONCAT(nombre, ' ', apellidos)) LIKE UPPER(CONCAT( '%',?,'%'))", [$persona]);
            })->where('activa', 'LIKE', "si");
        }
    }

    //Query Scope para filtrar por el campo tipo_equipo del equipo
    public function scopeTipoEquipo($query, $tipo_equipo)
    {
        if ($tipo_equipo) {
            return $query->whereHas('equipo', function ($query) use ($tipo_equipo) {
                $query->where('id_tipo_equipo', 'LIKE', "$tipo_equipo");
            });
        }
    }

    //Query Scope para filtrar por el campo tipo_equipo del equipo y el campo activa = 'si' además de enlazar
    //con otras consultas con la clausula OR
    public function scopeOrTipoEquipoActiva($query, $tipo_equipo)
    {
        if ($tipo_equipo) {
            return $query->orwhereHas('equipo', function ($query) use ($tipo_equipo) {
                $query->whereHas('tipoEquipo', function ($query) use ($tipo_equipo) {
                    $query->where('tipo', 'LIKE', "%$tipo_equipo%");
                });
            })->where('activa', 'LIKE', "si");
        }
    }

    //Query Scope para filtrar por el campo ubicacion
    public function scopeUbicacion($query, $ubicacion)
    {
        if ($ubicacion) {
            return $query->whereHas('ubicacion', function ($query) use ($ubicacion) {
                $query->where('id', 'LIKE', "$ubicacion");
            });
        }
    }

    //Query Scope para filtrar por el campo ubicacion y el campo activa = 'si' además de enlazar
    //con otras consultas con la clausula OR
    public function scopeOrUbicacionActiva($query, $ubicacion)
    {
        if ($ubicacion) {
            return $query->orwhereHas('ubicacion', function ($query) use ($ubicacion) {
                $query->whereraw("UPPER(CONCAT(servicio, ' - ', dependencia)) LIKE UPPER(CONCAT( '%',?,'%'))", [$ubicacion]);
            })->where('activa', 'LIKE', "si");
        }
    }

    //Query Scope para filtrar por el campo contratacion del equipo
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

    //Query Scope para filtrar por inicio de fecha_operacion
    public function scopeFOperIni($query, $f_oper_ini)
    {
        if ($f_oper_ini) {
            return $query->where('fecha_operacion', '>=', $f_oper_ini);
        }
    }

    //Query Scope para filtrar por fin de fecha_operacion
    public function scopeFOperFin($query, $f_oper_fin)
    {
        if ($f_oper_fin) {
            return $query->where('fecha_operacion', '<', Carbon::parse($f_oper_fin)->addDay());
        }
    }

    //Query Scope para filtrar por el campo marca del equipo
    public function scopeMarca($query, $marca)
    {
        if ($marca) {
            return $query->whereHas('equipo', function ($query) use ($marca) {
                $query->where('marca', 'LIKE', "$marca");
            });
        }
    }

    //Query Scope para filtrar por el campo modelo del equipo
    public function scopeModelo($query, $modelo)
    {
        if ($modelo) {
            return $query->whereHas('equipo', function ($query) use ($modelo) {
                $query->where('modelo', 'LIKE', "$modelo");
            });
        }
    }

    //Query Scope para filtrar por el campo num_serie del equipo
    public function scopeNumSerie($query, $num_serie)
    {
        if ($num_serie) {
            return $query->whereHas('equipo', function ($query) use ($num_serie) {
                $query->where('num_serie', 'LIKE', "%$num_serie%");
            });
        }
    }

    //Query Scope para filtrar por el campo product_number del equipo
    public function scopeProductNumber($query, $product_number)
    {
        if ($product_number) {
            return $query->whereHas('equipo', function ($query) use ($product_number) {
                $query->where('product_number', 'LIKE', "%$product_number%");
            });
        }
    }
}
