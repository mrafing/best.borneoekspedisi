<?php

namespace App\Models;

use App\Traits\Mutator\GenUid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mitra extends Model
{
    use HasFactory, GenUid;
    protected $table = 'tb_mitra';
    // protected $casts = [
    //     'id' => 'string'
    // ];

    protected $guarded = ['id'];

    public function outlet () {
        return $this->hasMany(Outlet::class, 'id_mitra', 'id');
    }

    // public static function getId()
    // {
    //     $latestMitra = self::latest()->first();
    
    //     if (!$latestMitra) {
    //         return 'MT1';
    //     }
    
    //     $latestId = $latestMitra->id;
    //     $nextNumber = (int) substr($latestId, 1) + 1;
    
    //     $nextId = 'MT' . $nextNumber;
    
    //     // Cek apakah ID sudah ada, jika ya, increment lagi
    //     while (self::where('id', $nextId)->exists()) {
    //         $nextNumber++;
    //         $nextId = 'MT' . $nextNumber;
    //     }
    
    //     return $nextId;
    // }
    
}
