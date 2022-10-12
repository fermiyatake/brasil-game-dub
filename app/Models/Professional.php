<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professional extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = [];

    public const TBA_ID = 986;

    public function voices() {
        return $this->hasMany(Voice::class);
    }
}
