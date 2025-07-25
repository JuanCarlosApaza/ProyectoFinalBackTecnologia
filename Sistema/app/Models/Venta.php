<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;
    protected $fillable = [
        "metodo_pago",
        "id_usuario",
        "total",
        "estado",
    ];

    public function usuario() {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function detalles() {
        return $this->hasMany(Detalle_Venta::class, 'id_venta');
    }
}
