<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    public function airports() {
        return $this->hasMany(Airport::class);
    }

    public function flights() {
        return $this->hasMany(Flight::class);
    }
}
