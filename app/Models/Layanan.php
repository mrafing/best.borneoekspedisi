<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    use HasFactory;
    protected $table = 'tb_layanan';
    protected $casts = [
        'id' => 'string',
    ];

    public function manifest() {
        return $this->hasMany(Manifest::class, 'id_layanan', 'id');
    }

    public function hargaOngkir() {
        return $this->hasMany(hargaOngkir::class, 'id_layanan', 'id');
    }
}
