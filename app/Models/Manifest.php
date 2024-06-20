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
}
