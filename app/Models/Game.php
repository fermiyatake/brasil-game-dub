<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = [];

    public const NO_COVER = 'no-cover.jpg';

    public function platforms() {
        return $this->belongsToMany(Platform::class);
    }

    public function studios() {
        return $this->belongsToMany(Studio::class)->orderByPivot('id', 'desc');
    }

    public function roles() {
        return $this->belongsToMany(Role::class);
    }

    public function voices() {
        return $this->belongsToMany(Voice::class);
    }
}
