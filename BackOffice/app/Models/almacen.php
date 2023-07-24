<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Validation\ValidatesRequests;
class Almacen extends Model
{
    protected $table = 'almacen';
    use HasFactory;
    use SoftDeletes;
    use ValidatesRequests;
    public $timestamps = true;
    public function direccionAlmacen()
    {
        return $this->belongsTo(DireccionAlmacen::class, 'IdDireccionAlmacen');
    }

    // Relación con LugarEntrega
    public function lugarEntrega()
    {
        return $this->belongsTo(LugarEntrega::class, 'IdLugarDeEntrega');
    }
}