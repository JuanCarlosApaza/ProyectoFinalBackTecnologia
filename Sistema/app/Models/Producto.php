<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    protected $fillable = [
        "nombre",
        "id_empresa",
        "id_categoria",
        "precio",
        "cantidad",
        "descripcion",
        "estado",
        "imagen",
        "descuento",
    ];
    
    public function empresa() {
        return $this->belongsTo(Empresa::class);
    }

    public function categoria() {
        return $this->belongsTo(Categoria::class);
    }

    public function promociones() {
        return $this->hasMany(Promociones::class, 'id_producto');
    }

    public function detallesVenta() {
        return $this->hasMany(Detalle_Venta::class, 'id_producto');
    }
}
