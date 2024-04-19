<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class manifest extends Model
{
    use HasFactory;
    protected $table = 'tb_manifest';
    // protected $guarded = ['id'];
}
