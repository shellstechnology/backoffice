<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Validation\ValidatesRequests;
class LugarEntrega extends Model
{
    protected $table = 'lugarentrega';
    use HasFactory;
    use SoftDeletes;
    use ValidatesRequests;
    public $timestamps = true;

}