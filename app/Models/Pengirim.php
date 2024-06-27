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

    public function manifest() {
        return $this->belongsTo(Manifest::class, 'id_pengirim', 'id');
    }
}
