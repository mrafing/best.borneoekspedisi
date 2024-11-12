<?php

namespace App\Models;

use App\Traits\Mutator\GenUid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailKarung extends Model
{
    use HasFactory, GenUid;
    protected $table = "tb_detail_karung";
    protected $guarded = ["id"];

    public function Karung() {
        return $this->hasMany(Karung::class, 'no_karung', 'no_karung');
    }
}
