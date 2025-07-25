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
        "estado",
    ];
    public function productos(){
        return $this->hasMany(Producto::class);
    }
}
