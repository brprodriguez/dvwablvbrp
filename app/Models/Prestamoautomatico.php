<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestamoautomatico  extends Model
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
        'termsycond',
    ];

    public function user()
   {
       return $this->belongsTo(User::class);
   }
}
