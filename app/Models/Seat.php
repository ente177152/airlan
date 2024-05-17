<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    public $fillable = ['airplane_id', 'status'];

    use HasFactory;

    public function airplane() {
        return $this->belongsTo(Airplane::class);
    }
}
