<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

     protected $table = 'user'; 
     protected $primaryKey = 'idUser'; 
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'idPersona',
        'Contrasena',
        'estadoSancion',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'Contrasena',
        'remember_token',
    ];
    public function getAuthPassword()
    {
        return $this->Contrasena;
    }
    public function persona()
    {
        // belongsTo(Modelo, clave_foranea_local, clave_primaria_remota)
        return $this->belongsTo(Persona::class, 'idPersona', 'idPersona');
    }
        public function roles()
    {
        // belongsToMany(Modelo, tabla_pivote, clave_local, clave_relacionada)
        return $this->belongsToMany(Rol::class, 'rol_user', 'idUser', 'idRol');
    }
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

}
