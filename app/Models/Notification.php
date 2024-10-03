<?php

namespace App\Models;

use App\Models\Reservation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class  Notification extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

}

