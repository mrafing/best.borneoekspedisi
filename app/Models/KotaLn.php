<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KotaLn extends Model
{
    use HasFactory;
    protected $table = 'tb_kota_ln';
    protected $casts = [
        'id' => 'string',
    ];

    public function negaraLn() {
        return $this->belongsTo(NegaraLn::class, 'id_negara', 'id');
    }

    public function penerimaLn() {
        return $this->hasMany(PenerimaLn::class, 'id_kota_ln_penerima', 'id');
    }
}
