<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bloque extends Model
{
    protected $table = 'bloques';
    protected $primaryKey = 'idBloque';
    public $timestamps = false;

    protected $fillable = [
        'hora_inicio',
        'hora_fin'
    ];

    public function bloquePrestamos()
    {
        return $this->hasMany(BloquePrestamo::class, 'idBloque');
    }
}
