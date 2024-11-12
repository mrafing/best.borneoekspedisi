<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HargaOngkirLn extends Model
{
    use HasFactory;
    protected $table = 'tb_harga_ongkir_ln';
    protected $casts = [
        'id' => 'string',
    ];

    public function layanan() {
        return $this->belongsTo(Layanan::class, 'id_layanan', 'id');
    }
}
