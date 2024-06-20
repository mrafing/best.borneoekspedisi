<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kota extends Model
{
    use HasFactory;
    protected $table = 'tb_kota';
    protected $casts = [
        'id' => 'string',
    ];

    public function kecamatan() {
        return $this->hasMany(Kecamatan::class, 'id_kota', 'id');
    }

    public function provinsi() {
        return $this->belongsTo(Provinsi::class, 'id_provinsi', 'id');
    }
}
