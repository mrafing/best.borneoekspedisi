<?php

namespace App\Models;

use App\Traits\Mutator\GenUid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory, GenUid;
    protected $table = 'tb_barang';
    protected $guarded = ['id'];

    public function manifest() {
        return $this->belongsTo(Manifest::class, 'id_barang', 'id');
    }

    public function manifestLn() {
        return $this->belongsTo(ManifestLn::class, 'id_barang', 'id');
    }
}
