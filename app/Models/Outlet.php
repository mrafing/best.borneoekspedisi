<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
    use HasFactory;
    protected $table = 'tb_outlet';

    public function user() {
        return $this->hasMany(User::class, 'id_outlet', 'id');
    }

    public function mitra () {
        return $this->belongsTo(Mitra::class, 'id_mitra', 'id');
    }
}
