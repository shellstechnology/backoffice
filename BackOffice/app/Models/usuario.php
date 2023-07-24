<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Validation\ValidatesRequests;

class Usuario extends Model
{
    protected $table = 'usuario';
    use HasFactory;

    use SoftDeletes;
    use ValidatesRequests;
    public $timestamps = true;
}
