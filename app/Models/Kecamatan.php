<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    use HasFactory;
    protected $table = 'tb_kecamatan';
    protected $casts = [
        'id' => 'string',
    ];

    public function kota() {
        return $this->belongsTo(Kota::class, 'id_kota', 'id');
    }

    public function outlet () {
        return $this->hasMany(Outlet::class, 'id_kecamatan', 'id');
    }

    public function penerima() {
        return $this->hasMany(Penerima::class, 'id_kecamatan_penerima', 'id');
    }

    public function outletDelivery() {
        return $this->belongsTo(Outlet::class, 'id_outlet_delivery', 'id');
    }
}
