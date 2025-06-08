<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
 use HasFactory;

    protected $fillable = [
        'monto',
        'plazo',
        'fecha_inicio',
        'perfil_riesgo',
        'estado',
        'observaciones',
        'user_id',

    ];

    public function user()
   {
       return $this->belongsTo(User::class);
   }
}
