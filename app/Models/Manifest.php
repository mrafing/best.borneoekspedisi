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
        $date = now()->format('ymd');
        
        // Ambil resi terbaru yang dibuat pada hari yang sama
        $lastResi = self::whereDate('created_at', now()->format('Y-m-d'))
                        ->orderBy('no_resi', 'desc')
                        ->first();

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
}
