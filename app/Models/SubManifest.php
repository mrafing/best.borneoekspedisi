<?php

namespace App\Models;

use App\Traits\Mutator\GenUid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubManifest extends Model
{
    use HasFactory, GenUid;
    protected $table = 'tb_sub_manifest';
    protected $guarded = ['id'];
}
