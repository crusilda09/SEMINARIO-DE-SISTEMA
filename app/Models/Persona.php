<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;

    public function documento(){
        return $this->belongsTo(Documento::class); //buscando al modelo documento ... funcion para relacionar tablaas
    }

    
    public function proveedore(){
        return $this->hasOne(Proveedore::class);
    }
    
    public function cliente(){
        return $this->hasOne(Cliente::class);
    }

    
}
