<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    use HasFactory;
    protected $table = 'tb_kecamatan';

    public function kota() {
        return $this->belongsTo(Kota::class, 'id_kota', 'id');
    }
}
