<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comprobante extends Model
{
    use HasFactory;

    public function compras(){
        return $this->hasMany(Compra::class); //1 comprobante puede tener muchas compras por eso la funcion hasMany
    }
    public function ventas(){
        return $this->hasMany(Venta::class);
    }
}
