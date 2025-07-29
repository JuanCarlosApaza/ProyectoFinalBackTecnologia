<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;
    protected $fillable = [
        "nombre",
        "logo",
        "direccion",
        "telefono",
        "texto",
        "fondo",
        "estado",
        "id_usuario"


    ];
    
    public function productos(){
        return $this->hasMany(Producto::class, 'id_empresa', 'id');
    }
}
