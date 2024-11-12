<?php

namespace App\Models;

use App\Traits\Mutator\GenUid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubManifestLn extends Model
{
    use HasFactory, GenUid;
    protected $table = 'tb_sub_manifest_ln';
    protected $guarded = ['id'];
}
