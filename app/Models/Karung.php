<?php

namespace App\Models;

use App\Traits\Mutator\GenUid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karung extends Model
{
    use HasFactory, GenUid;
    protected $table = "tb_karung";
    protected $guarded = ['id'];

    public static function getNoKarung()
    {
        $prefix = 'KR';
        $date = now()->format('md');
        
        $lastNoKarung = self::latest()->first();

        if ($lastNoKarung) {
            $lastNumber = (int)substr($lastNoKarung->no_karung, -6);
            $newNumber = str_pad($lastNumber + 1, 6, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '000001';
        }

        return $prefix . $date . $newNumber;
    }

    public function DetailKarung() {
        return $this->hasMany(DetailKarung::class, 'no_karung', 'no_karung');
    }
}
