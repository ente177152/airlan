<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    use HasFactory;

    public function airplane() {
        return $this->belongsTo(Airplane::class);
    }

    public function airport() {
        return $this->belongsTo(Airport::class, 'from_airport_id');
    }

    public function airport_to() {
        return $this->belongsTo(Airport::class, 'to_airport_id');
    }

    public function city() {
        return $this->belongsTo(City::class, 'from_city_id');
    }

    public function city_to() {
        return $this->belongsTo(City::class, 'to_city_id');
    }

    public function tickets() {
        return $this->hasMany(Ticket::class);
    }
}
