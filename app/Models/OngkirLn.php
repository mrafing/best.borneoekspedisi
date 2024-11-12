<?php

namespace App\Models;

use App\Traits\Mutator\GenUid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OngkirLn extends Model
{
    use HasFactory, GenUid;
    protected $table = 'tb_ongkir_ln';
    protected $guarded = ['id'];

    public function manifestLn() {
        return $this->belongsTo(ManifestLn::class, 'id_ongkir_ln', 'id');
    }
}
