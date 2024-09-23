<?php

namespace App\Models;

use App\Models\User;
use App\Models\Donateur;
use App\Models\Beneficiaire;
use App\Models\Organisation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rapport extends Model
{
    use HasFactory;

    protected $table = "rapports";


    protected $fillable = [
        'contenu',
        'reservation_id',
        'beneficiaire_id'
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function beneficiaire()
    {
        return $this->belongsTo(Beneficiaire::class);
    }

    public function organisation()
    {
        return $this->belongsTo(Organisation::class);
    }

    public function donateur()
    {
        return $this->belongsTo(Donateur::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

}
