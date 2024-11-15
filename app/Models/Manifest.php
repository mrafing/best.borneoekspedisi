<?php

namespace App\Models;

use App\Traits\Mutator\GenUid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manifest extends Model
{
    use HasFactory, GenUid;
    protected $table = 'tb_manifest';
    protected $guarded = ['id'];

    public static function getNoResi()
    {
        $prefix = 'BE';
        $date = now()->format('md');
        
        // Ambil resi terbaru
        $lastResi = self::latest()->first();

        if ($lastResi) {
            // Ambil bagian nomor dari no_resi dan tambahkan 1
            $lastNumber = (int)substr($lastResi->no_resi, -6);
            $newNumber = str_pad($lastNumber + 1, 6, '0', STR_PAD_LEFT);
        } else {
            // Jika tidak ada resi pada hari ini, mulai dari 0000001
            $newNumber = '000001';
        }

        return $prefix . $date . $newNumber;
    }

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

    public function layanan() {
        return $this->belongsTo(Layanan::class, 'id_layanan', 'id');
    }

    public function outlet() {
        return $this->belongsTo(Outlet::class, 'id_outlet_terima', 'id');
    }

    public function tracking() {
        return $this->hasMany(Tracking::class, 'id_manifest', 'id');
    }

    public function submanifest() {
        return $this->hasMany(SubManifest::class, 'id_manifest', 'id');
    }
}
