<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voice extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = [];
    
    public function professional() {
        return $this->hasOne(Professional::class, 'id', 'professional_id');
    }
}
