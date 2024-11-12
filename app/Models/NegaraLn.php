<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NegaraLn extends Model
{
    use HasFactory;
    protected $table = 'tb_negara_ln';
    protected $casts = [
        'id' => 'string',
    ];

    public function kotaLn() {
        return $this->hasMany(KotaLn::class, 'id_negara', 'id');
    }
}
