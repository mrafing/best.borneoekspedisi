<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    use HasFactory;
    protected $table = 'tb_provinsi';
    protected $casts = [
        'id' => 'string',
    ];

    public function kota() {
        return $this->hasMany(Kota::class, 'id_provinsi', 'id');
    }
}
