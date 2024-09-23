<?php

namespace App\Models;

use App\Models\User;
use App\Models\Rapport;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Beneficiaire extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rapport()
    {
        return $this->belongsTo(Rapport::class);
    }
}
