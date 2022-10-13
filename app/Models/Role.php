<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = [];

    public function professional() {
        return $this->hasOne(Professional::class, 'id', 'professional_id');
    }

    public function game() {
        return $this->belongsTo(Game::class, 'game_id', 'id');
    }

    public function detach($game) : void {
        self::where('game_id', $game)->delete();
    }
}
