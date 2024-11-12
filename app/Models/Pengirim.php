<?php

namespace App\Models;

use App\Console\Kernel;
use App\Traits\Mutator\GenUid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengirim extends Model
{
    use HasFactory, GenUid;
    protected $table = 'tb_pengirim';
    protected $guarded = ['id'];

    public function manifest() {
        return $this->belongsTo(Manifest::class, 'id_pengirim', 'id');
    }

    public function manifestLn() {
        return $this->belongsTo(ManifestLn::class, 'id_pengirim', 'id');
    }

    public function kecamatan() {
        return $this->belongsTo(Kecamatan::class, 'id_kecamatan_pengirim', 'id');
    }
}
