<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promociones extends Model
{
    use HasFactory;
    protected $fillable = [
        "imagen",
        "id_producto",
        "estado",
    ];

    public function producto() {
        return $this->belongsTo(Producto::class, 'id_producto');
    }
}
