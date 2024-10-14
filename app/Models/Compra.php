<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;

    public function proveedore(){
        return $this->belongsTo(Proveedore::class);  //funcion de 1 a 1 a la inversa
    }

    public function comprobante(){
        return $this->belongsTo(Comprobante::class);
    }

    public function productos(){
        return $this->belongsToMany(Producto::class)->withTimestamps()->withPivot('cantidad','precio_compra','percio_venta');//para relaciones muchos a muchos se usa la funcion belongstoMany
    }//with_Timestamps para crear los valoes de createAt y upadtedAt
    

}
