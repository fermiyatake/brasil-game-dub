<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = [];

    public function platforms() {
        return $this->belongsToMany(Platform::class);
    }

    public function studios() {
        return $this->belongsToMany(Studio::class)->orderByPivot('id', 'desc');
    }
}
