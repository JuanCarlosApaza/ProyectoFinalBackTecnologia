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
    public function empresa(){
        return $this->belongsTo(Empresa::class,"id_empresa");
    }
    public function categoria(){
        return $this->belongsTo(Categoria::class,"id_categoria");
    }
}
