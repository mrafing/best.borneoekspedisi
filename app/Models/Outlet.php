<?php

namespace App\Models;

use App\Traits\Mutator\GenUid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
    use HasFactory, GenUid;
    protected $table = 'tb_outlet';
    // protected $guarded = ['id'];

    public function user() {
        return $this->hasMany(User::class, 'id_outlet', 'id');
    }

    public function mitra () {
        return $this->belongsTo(Mitra::class, 'id_mitra', 'id');
    }

    public function kecamatan () {
        return $this->belongsTo(Kecamatan::class, 'id_kecamatan', 'id');
    }

    public function manifest () {
        return $this->hasMany(Manifest::class, 'id_outlet_terima', 'id');
    }

    public function kecamatanDelivery() {
        return $this->hasMany(Kecamatan::class, 'id_outlet_delivery', 'id');
    }
}
