<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedore extends Model
{
    use HasFactory;

    public function persona(){
        return $this->belongsTo(Persona::class); //para la funcion de 1 a 1
    }

    public function compras(){
        return $this->hasMany(Compra::class);  //funcion para establecer una funcion de 1 a muchos
    }
}
