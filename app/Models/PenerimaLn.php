<?php

namespace App\Models;

use App\Traits\Mutator\GenUid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenerimaLn extends Model
{
    use HasFactory, GenUid;
    protected $table = 'tb_penerima_ln';
    protected $guarded = ['id'];

    public function manifestLn() {
        return $this->belongsTo(ManifestLn::class, 'id_penerima_ln', 'id');
    }

    public function kotaLn() {
        return $this->belongsTo(KotaLn::class, 'id_kota_ln_penerima', 'id');
    }
}
