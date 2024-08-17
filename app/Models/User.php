<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'usuarios';
    public $timestamps = false;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
        'roles_rol_id'
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
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Función para encriptar contraseñas
    public function setPasswordAttribute($password){
        $this -> attributes['password'] = bcrypt($password);
    }

    public function rol(){
        return $this -> belongsTo('App\Models\Rol','roles_rol_id');
    }

    public function administadores(){
        return $this -> hasMany('App\Models\Administrador');
    }

    public function bibliotecarios(){
        return $this -> hasMany('App\Models\Bibliotecario');
    }    
    
    public function alumnos(){
        return $this -> hasMany('App\Models\Alumno');
    }

    public function posts(){
        return $this -> hasMany('App\Models\Publicacion');
    }
        public function logins(){
        return $this -> hasMany('App\Models\HistorialDeLogin');
    }
}
