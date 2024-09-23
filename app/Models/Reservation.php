<?php

namespace App\Models;

use App\Models\Don;
use App\Models\User;
use App\Models\Rapport;
use App\Models\Donateur;
use App\Models\Beneficiaire;
use App\Models\Organisation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reservation extends Model
{
    use HasFactory;
    use Notifiable;

    protected $table = "reservations";

    protected $guarded = [];
    // protected $fillable = ['description', 'don_id', 'beneficiaire_id'];

    // Relation avec Don
    public function don()
    {
        return $this->belongsTo(Don::class);
    }

        // Relation avec le modèle User (créateur)
        public function organisation()
        {
            return $this->belongsTo(Organisation::class);
        }

        public function creator()
        {
            return $this->belongsTo(User::class, 'created_by');
        }


        // Relation avec le modèle User (modificateur)
        public function modifier()
        {
            return $this->belongsTo(User::class, 'modified_by');
        }

        // Relation avec Beneficiaire
        public function beneficiaire()
        {
            return $this->belongsTo(Beneficiaire::class);
        }

        public function rapport()
        {
            return $this->belongsTo(Rapport::class);
        }


        public function donateur()
        {
            return $this->belongsTo(Donateur::class);
        }



}
