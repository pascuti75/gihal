<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Scout\Searchable;


class User extends Authenticatable
{
    //indicamos que es un modelo buscable mediante Laravel Scout
    use HasApiTokens, HasFactory, Notifiable, Searchable;

    //fillable es para visualizar los campos de la tabla en las consultas sql
    protected $fillable = [
        'username',
        'password',
        'es_administrador',
        'es_gestor',
        'es_tecnico',
        'es_consultor',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [];



    //campos que se van a utilizar en la busqueda
    public function toSearchableArray()
    {
        return [
            'username' => $this->username,
        ];
    }
}
