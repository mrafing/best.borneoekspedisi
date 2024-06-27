<?php

namespace App\Models;

use App\Traits\Mutator\GenUid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ongkir extends Model
{
    use HasFactory, GenUid;
    protected $table = 'tb_ongkir';
    protected $guarded = ['id'];

    public function manifest() {
        return $this->belongsTo(Manifest::class, 'id_ongkir', 'id');
    }
}
