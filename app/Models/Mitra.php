<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mitra extends Model
{
    use HasFactory;
    protected $table = 'tb_mitra';

    public function outlet () {
        return $this->hasMany(Outlet::class, 'id_mitra', 'id');
    }
}
