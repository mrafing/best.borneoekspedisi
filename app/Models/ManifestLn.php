<?php

namespace App\Models;

use App\Traits\Mutator\GenUid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManifestLn extends Model
{
    use HasFactory, GenUid;
    protected $table = 'tb_manifest_ln';
    protected $guarded = ['id'];

    public function pengirim() {
        return $this->belongsTo(Pengirim::class, 'id_pengirim', 'id');
    }

    public function penerimaLn() {
        return $this->belongsTo(PenerimaLn::class, 'id_penerima_ln', 'id');
    }

    public function barang() {
        return $this->belongsTo(Barang::class, 'id_barang', 'id');
    }

    public function ongkirLn() {
        return $this->belongsTo(OngkirLn::class, 'id_ongkir_ln', 'id');
    }

    public function layanan() {
        return $this->belongsTo(Layanan::class, 'id_layanan', 'id');
    }

    public function outlet() {
        return $this->belongsTo(Outlet::class, 'id_outlet_terima', 'id');
    }
}
