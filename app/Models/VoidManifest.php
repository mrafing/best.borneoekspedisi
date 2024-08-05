<?php

namespace App\Models;

use App\Traits\Mutator\GenUid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoidManifest extends Model
{
    use HasFactory, GenUid;
    protected $table = 'tb_void_manifest';
    protected $guarded = ['id'];

    public function pengirim() {
        return $this->belongsTo(Pengirim::class, 'id_pengirim', 'id');
    }

    public function penerima() {
        return $this->belongsTo(Penerima::class, 'id_penerima', 'id');
    }

    public function barang() {
        return $this->belongsTo(Barang::class, 'id_barang', 'id');
    }

    public function ongkir() {
        return $this->belongsTo(Ongkir::class, 'id_ongkir', 'id');
    }

}
