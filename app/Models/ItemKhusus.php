<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemKhusus extends Model
{
    use HasFactory;
    protected $table = 'tb_item_khusus';
    protected $casts = [
        'id' => 'string',
    ];
}
