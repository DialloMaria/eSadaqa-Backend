<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Organisation extends Model
{
    use HasFactory;
    use Notifiable;
    protected $guarded = [];


    public function user()
{
    return $this->belongsTo(User::class);
}

}
