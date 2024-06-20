<?php

namespace App\Models;

use App\Traits\Mutator\GenUid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengirim extends Model
{
    use HasFactory, GenUid;
    protected $table = 'tb_pengirim';
    protected $guarded = ['id'];

    public static function getId()
    {
        $date = now()->format('ymd');

        // Ambil resi terbaru yang dibuat pada hari yang sama
        $lastId = self::latest()->first();

        if ($lastId) {
            // Ambil bagian nomor dari id dan tambahkan 1
            $lastNumber = (int)substr($lastId->id, -6);
            $newNumber = str_pad($lastNumber + 1, 6, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '000001';
        }

        return $date . $newNumber;
    }
}
