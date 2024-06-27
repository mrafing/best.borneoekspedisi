<?php

namespace App\Models;

use App\Traits\Mutator\GenUid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penerima extends Model
{
    use HasFactory, GenUid;
    protected $table = 'tb_penerima';
    protected $guarded = ['id'];

    public function manifest() {
        return $this->belongsTo(Manifest::class, 'id_penerima', 'id');
    }

    public function kecamatan() {
        return $this->belongsTo(Kecamatan::class, 'id_kecamatan_penerima', 'id');
    }
}
